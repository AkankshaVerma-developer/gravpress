<?php
// admin/create_theme_copy.php
session_start();
require_once "../connection/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$theme = isset($_GET['theme']) ? preg_replace('/[^a-zA-Z0-9_\-]/','', $_GET['theme']) : '';
if (!$theme) {
    die("No theme specified.");
}

$projectRoot = realpath(__DIR__ . "/..");        // <project>/admin/.. = project root
$srcTheme = $projectRoot . "/user/view/theme/" . $theme;
if (!is_dir($srcTheme)) {
    die("Theme folder not found: " . htmlspecialchars($srcTheme));
}

$copy = $projectRoot . "/sites/{$user_id}_" . $theme . "_copy";

// Recursive copy function
function copyFolder($src, $dst) {
    @mkdir($dst, 0777, true);
    $items = scandir($src);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $srcPath = $src . DIRECTORY_SEPARATOR . $item;
        $dstPath = $dst . DIRECTORY_SEPARATOR . $item;
        if (is_dir($srcPath)) {
            copyFolder($srcPath, $dstPath);
        } else {
            copy($srcPath, $dstPath);
        }
    }
}

// 1) Copy theme folder
if (!is_dir($copy)) {
    copyFolder($srcTheme, $copy);
}

// 2) Also copy global assets (css + images) into the copy so relative assets can be served from copy
$globalCss = $projectRoot . "/user/css";
$globalImages = $projectRoot . "/user/images";

// copy css -> $copy/css
if (is_dir($globalCss)) {
    copyFolder($globalCss, $copy . "/css");
}
// copy images -> $copy/images
if (is_dir($globalImages)) {
    copyFolder($globalImages, $copy . "/images");
}

/*
 * 3) Adjust asset paths inside copied PHP files
 */
$phpFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($copy));
foreach ($phpFiles as $file) {
    if ($file->isFile() && preg_match('/\.php$/i', $file->getFilename())) {
        $path = $file->getRealPath();
        $contents = file_get_contents($path);

        // common variants -> replace to local 'css/...' or 'images/...'
        // css:
        $contents = preg_replace('#(\.\./){1,}css/#i', 'css/', $contents);
        $contents = preg_replace('#/user/css/#i', 'css/', $contents); // if absolute used
        // images:
        $contents = preg_replace('#(\.\./){1,}images/#i', 'images/', $contents);
        $contents = preg_replace('#/user/images/#i', 'images/', $contents);

        // also fix src/href that use ../../.. style to point to local css/images if they include "css" or "images"
        // (keeps other absolute links untouched)
        $contents = preg_replace_callback(
            '#(href|src)\s*=\s*([\'"])([^\'"]+)([\'"])#i',
            function($m) {
                $attr = $m[1];
                $url = $m[3];
                // if url contains 'css/' or '/css/' -> make relative to local css/
                if (preg_match('#(^(\.\./)+|/)?(user/)?css/#i', $url)) {
                    $new = 'css/' . preg_replace('#.*css/#i','',$url);
                    return "{$attr}={$m[2]}{$new}{$m[4]}";
                }
                if (preg_match('#(^(\.\./)+|/)?(user/)?images/#i', $url)) {
                    $new = 'images/' . preg_replace('#.*images/#i','',$url);
                    return "{$attr}={$m[2]}{$new}{$m[4]}";
                }
                return $m[0];
            },
            $contents
        );

        file_put_contents($path, $contents);
    }
}

/*
 * 4) Auto-inject click-to-edit JS before </body> in every copied PHP file
 *    We inject a small marker comment so it's easy to identify later.
 */
$injectJS = <<<EOD
<!-- AUTO-INJECT : CLICK TO EDIT -->
<script>
// Prevent navigating inside iframe
document.addEventListener("click", function(e){
    if (e.ctrlKey || e.metaKey) return;

    e.preventDefault();
    e.stopPropagation();

    const el = e.target;
    const selector = getCleanSelector(el);

    window.parent.postMessage({
        type: "elementClicked",
        tag: el.tagName,
        text: el.innerText || "",
        src: el.getAttribute("src") || el.getAttribute("data-src") || "",
        color: window.getComputedStyle(el).color,
        font: window.getComputedStyle(el).fontSize,
        selector: selector
    }, "*");
});

/*
  BETTER SELECTOR SYSTEM
  ✔ No nth-child() unless required
  ✔ Uses id, class, or closest stable parent
  ✔ Works for headings, titles, spans, buttons, etc.
*/
function getCleanSelector(el){

    // 1) ID → best selector
    if (el.id) return "#" + el.id;

    // 2) Has unique class → .class
    if (el.className){
        let cls = el.className.trim().split(/\s+/)[0];
        if (cls) return el.tagName.toLowerCase() + "." + cls;
    }

    // 3) Avoid selecting huge containers → find nearest editable element
    let safe = el.closest("p, h1, h2, h3, h4, h5, h6, img, button, a, span");
    if (safe && safe !== el){
        return getCleanSelector(safe);
    }

    // 4) Fallback simple tag
    return el.tagName.toLowerCase();
}
</script>

EOD;

foreach ($phpFiles as $file) {
    if ($file->isFile() && preg_match('/\.php$/i', $file->getFilename())) {
        $path = $file->getRealPath();
        $contents = file_get_contents($path);
        // only inject if not already present
        if (strpos($contents, '<!-- AUTO-INJECT : CLICK TO EDIT -->') === false) {
            // if file has </body>, inject before it; otherwise append at end
            if (stripos($contents, '</body>') !== false) {
                $contents = str_ireplace('</body>', $injectJS . "\n</body>", $contents);
            } else {
                $contents .= "\n" . $injectJS;
            }
            file_put_contents($path, $contents);
        }
    }
}

// 5) Save path of custom theme in DB (active_theme.user_custom_theme)
$stmt = $conn->prepare("UPDATE active_theme SET user_custom_theme = ? WHERE user_id = ?");
$copyDbPath = "sites/" . $user_id . "_" . $theme . "_copy"; // web path relative to project root
$stmt->bind_param("si", $copyDbPath, $user_id);
$stmt->execute();

// 6) Redirect to editor and pass the web path for iframe src.
// Build web-accessible copy path relative to admin folder.

$webCopy = "../" . $copyDbPath; // this will be used as iframe src: ../sites/1_theme_copy/home.php

header("Location: editor.php?copy=" . urlencode($webCopy));
exit;
