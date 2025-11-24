<?php
// admin/save_changes.php
session_start();
require_once "../connection/db.php";

if (!isset($_POST['copy'], $_POST['page'], $_POST['selector'], $_POST['type'])) {
    http_response_code(400);
    echo "Missing parameters.";
    exit;
}

$webCopy = $_POST['copy']; // ../sites/1_theme-ecommerce_copy
$page = $_POST['page'];    // e.g. home.php or subdir/page.php
$selector = $_POST['selector']; // CSS selector as sent by injected script
$type = $_POST['type']; // text|image|color|font
$value = isset($_POST['value']) ? $_POST['value'] : '';

// resolve filesystem path of the page
$projectRoot = realpath(__DIR__ . "/..");
$fsCopy = realpath($projectRoot . DIRECTORY_SEPARATOR . ltrim($webCopy, "./\\/"));

if ($fsCopy === false) {
    echo "Copy folder not found.";
    exit;
}

$pagePath = $fsCopy . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, urldecode($page));
if (!file_exists($pagePath)) {
    echo "Page file not found: " . htmlspecialchars($pagePath);
    exit;
}

$content = file_get_contents($pagePath);

// We will use a conservative approach:
//  - For text: find the element by selector and replace innerHTML/text between tags (simple regex)
//  - For image: find <img ... src="..."> and replace src
//  - For color/font: alter style attribute or insert/update style attribute
// Note: This is not a full DOM parser but works for typical theme HTML structures.

function preg_quote_selector_for_regex($sel) {
    // From selector like "h2.hero: nth-child(2)" we will only keep tag+classes+nth-child
    // We need to convert sel to a regex that recognizes the opening tag.
    // Examples:
    //  "#id" -> id="id"
    //  "h2.class1.class2:nth-child(1)" -> <h2 ... class="...class1...class2..." ...>
    $sel = trim($sel);
    if (strpos($sel, '#') === 0) {
        $id = substr($sel,1);
        return '/(<[^>]*\\bid\\s*=\\s*["\']' . preg_quote($id, '/') . '["\'][^>]*>)(.*?)(<\\/[^>]+>)/si';
    }
    if ($sel === "title") {
    return '/(<title>)(.*?)(<\/title>)/si';
}

    // tag.class1.class2(:nth-child(...))?
    $tag = $sel;
    $classMatch = [];
    $classes = [];
    if (preg_match('/^([a-z0-9]+)(.*)/i', $sel, $m)) {
        $tag = $m[1];
        $rest = $m[2];
        if (preg_match_all('/\\.([a-z0-9_-]+)/i', $rest, $cm)) {
            $classes = $cm[1];
        }
    }
    // Build regex that matches opening tag with those classes in class attribute
    if (!empty($classes)) {
        // require that class attribute contains all class tokens
        $classChecks = '';
        foreach ($classes as $c) {
            $classChecks .= '(?=[^>]*\\bclass\\s*=\\s*[\'\'][^\'\']*\\b' . preg_quote($c, '/') . '\\b)';
        }
        $regex = '/(<'.$tag.'[^>]*' . $classChecks . '[^>]*>)(.*?)(<\\/'. $tag .'>)/si';
        return $regex;
    } else {
        // fallback to simple tag match
        return '/(<'.$tag.'[^>]*>)(.*?)(<\\/'.$tag.'>)/si';
    }
}

if ($type === 'text') {
    $regex = preg_quote_selector_for_regex($selector);
    $new = preg_replace($regex, '$1' . $value . '$3', $content, 1);
    if ($new === null) {
        echo "Failed to update text.";
        exit;
    }
    file_put_contents($pagePath, $new);
    echo "Text updated.";
    exit;
}

if ($type === 'image') {
    // replace src attribute for the matched img element using selector
    // if selector is #id or img.class or img:nth-child etc.
    if (strpos($selector, '#') === 0) {
        $id = substr($selector,1);
        $pattern = '/(<img[^>]*\\bid\\s*=\\s*[\'"]' . preg_quote($id,'/') . '[\'"][^>]*\\ssrc=["\'])([^"\']*)(["\'][^>]*>)/i';
        $replacement = '$1' . $value . '$3';
        $new = preg_replace($pattern, $replacement, $content, 1);
        file_put_contents($pagePath, $new);
        echo "Image updated.";
        exit;
    } else {
        // try to match img with class names in selector
        if (preg_match('/\\.([a-z0-9_-]+)/i', $selector, $cm)) {
            $class = $cm[1];
            $pattern = '/(<img[^>]*\\bclass\\s*=\\s*[\'\"][^\'\"]*\\b' . preg_quote($class,'/') . '\\b[^\'\"]*["\'][^>]*\\ssrc=["\'])([^"\']*)(["\'][^>]*>)/i';
            $new = preg_replace($pattern, '$1' . $value . '$3', $content, 1);
            file_put_contents($pagePath, $new);
            echo "Image updated.";
            exit;
        }
    }
    echo "Image selector not recognized.";
    exit;
}

if ($type === 'color') {
    // set inline style color: VALUE or background-color: VALUE if element had background earlier
    $regex = preg_quote_selector_for_regex($selector);
    // find opening tag and add/replace style attribute color rule
    if (preg_match($regex, $content, $m)) {
        $openTag = $m[1]; // like <h2 class="..">
        // insert or update style attribute
        if (preg_match('/style\s*=\s*([\'"])(.*?)\\1/i', $openTag, $sm)) {
            $currentStyle = $sm[2];
            // replace color property if exists, else append
            if (preg_match('/color\s*:\s*[^;]+/i', $currentStyle)) {
                $newStyle = preg_replace('/color\s*:\s*[^;]+/i', 'color: '.$value, $currentStyle);
            } else {
                $newStyle = rtrim($currentStyle, '; ') . '; color: ' . $value . ';';
            }
            $newOpen = str_replace($sm[0], 'style="'. $newStyle .'"', $openTag);
        } else {
            $newOpen = rtrim($openTag, '>') . ' style="color: ' . $value . ';">';
        }
        $newContent = str_replace($openTag, $newOpen, $content);
        file_put_contents($pagePath, $newContent);
        echo "Color updated.";
        exit;
    } else {
        echo "Element not found for color.";
        exit;
    }
}

if ($type === 'font') {
    $regex = preg_quote_selector_for_regex($selector);
    if (preg_match($regex, $content, $m)) {
        $openTag = $m[1];
        if (preg_match('/style\s*=\s*([\'"])(.*?)\\1/i', $openTag, $sm)) {
            $currentStyle = $sm[2];
            if (preg_match('/font-size\s*:\s*[^;]+/i', $currentStyle)) {
                $newStyle = preg_replace('/font-size\s*:\s*[^;]+/i', 'font-size: '.$value, $currentStyle);
            } else {
                $newStyle = rtrim($currentStyle, '; ') . '; font-size: ' . $value . ';';
            }
            $newOpen = str_replace($sm[0], 'style="'. $newStyle .'"', $openTag);
        } else {
            $newOpen = rtrim($openTag, '>') . ' style="font-size: ' . $value . ';">';
        }
        $newContent = str_replace($openTag, $newOpen, $content);
        file_put_contents($pagePath, $newContent);
        echo "Font size updated.";
        exit;
    } else {
        echo "Element not found for font.";
        exit;
    }
}
if ($type === 'image_file') {
    $uploadDir = $fsCopy . "/uploads";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $fileName = time() . "_" . basename($_FILES['file']['name']);
    $dest = $uploadDir . "/" . $fileName;
    move_uploaded_file($_FILES['file']['tmp_name'], $dest);

    // Replace with new uploaded file path
    $imgUrl = "uploads/" . $fileName;

  // build selector regex first----------------------------------------
$regex = preg_quote_selector_for_regex($selector);

// extract the exact <img ...> tag using the selector
if (preg_match($regex, $content, $m)) {
    $openTag = $m[1];

    // Replace only the src inside this tag
    $newOpen = preg_replace(
        '/src=["\'][^"\']*["\']/i',
        'src="' . $imgUrl . '"',
        $openTag
    );

    $newContent = str_replace($openTag, $newOpen, $content);
    file_put_contents($pagePath, $newContent);

    echo "Image updated (file uploaded).";
    exit;
}

}

echo "Unknown action.";
exit;
