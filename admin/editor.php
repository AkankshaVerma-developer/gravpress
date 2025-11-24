<?php
session_start();
require_once "../connection/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['copy'])) {
    die("No copy specified. Please start editor via create_theme_copy.php?theme=THEME_SLUG");
}

$webCopy = $_GET['copy']; // something like ../sites/1_theme-ecommerce_copy
// map to filesystem path to list pages
$projectRoot = realpath(__DIR__ . "/..");
$fsCopy = realpath($projectRoot . DIRECTORY_SEPARATOR . ltrim($webCopy, "./\\/"));

if ($fsCopy === false || !is_dir($fsCopy)) {
    die("Copied theme folder not found: " . htmlspecialchars($fsCopy));
}

// collect all php pages in copy root (not deeply nested pages)
$pages = [];
$dirIter = new DirectoryIterator($fsCopy);
foreach ($dirIter as $f) {
    if ($f->isFile() && preg_match('/\.php$/i', $f->getFilename())) {
        $pages[] = $f->getFilename();
    }
}
if (count($pages) === 0) {
    // try recursive fallback (if pages are in subfolders)
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($fsCopy));
    foreach ($rii as $file) {
        if ($file->isFile() && preg_match('/\.php$/i', $file->getFilename())) {
            $relative = str_replace($fsCopy . DIRECTORY_SEPARATOR, '', $file->getRealPath());
            $pages[] = $relative;
        }
    }
}

// pick first page to load
$firstPage = $pages[0] ?? 'home.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GravPress - Click Editor</title>
<link rel="stylesheet" href="sidebar.css"> 
<style>
body{margin:0;display:flex;font-family:Arial, sans-serif;height:100vh}
.sidebar{width:300px;background:#f6f6f6;border-right:1px solid #ddd;padding:16px;box-sizing:border-box;overflow:auto;}
.preview-wrap{flex:1;min-width:0}
iframe{width:100%;height:100%;border:0}
.page-list .page-item{background:#fff;padding:8px;border:1px solid #ddd;margin-bottom:8px;border-radius:6px;cursor:pointer}
.controls h3{margin:8px 0}
.input-wrap{margin-bottom:12px}
label{display:block;font-weight:600;margin-bottom:6px}
textarea, input[type="text"]{width:100%;padding:8px;box-sizing:border-box}
button{padding:8px 12px;border-radius:6px;border:1px solid #bbb;background:#fff;cursor:pointer}
button.primary{background:#2d8cff;color:#fff;border-color:#2d8cff}
</style>
</head>
<body>

<div class="sidebar">
    <a href="dashboard.php"> 
                <span>Dashboard</span>
            </a>
    <button id="saveWebsiteBtn" class="btn-save">💾 Save Website</button>

<script>
document.getElementById('saveWebsiteBtn').addEventListener('click', function () {
    if (!confirm("Are you sure you want to save your edited website?")) return;

    fetch("save_website.php", {
        method: "POST"
    })
    .then(res => res.text())
    .then(data => {
        alert(data);
        window.location.href = "saved_sites.php";
    });
});
</script>

<style>
.btn-save{
    background:black;
    margin-left:7px;
    color:#fff;
    border:0;
    border-radius:6px;
    cursor:pointer;
    font-size:16px;
}
</style>
    <h2>Click-to-Edit</h2>

    <div class="block">
        <strong>Pages</strong>
        <div class="page-list">
            <?php foreach ($pages as $p): 
                $escaped = htmlspecialchars($p);
            ?>
            <div class="page-item" onclick="loadPage('<?php echo rawurlencode($p); ?>')">
                <?php echo $escaped; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <hr>

    <div class="controls">
        <h3>Selected: <span id="element-type">None</span></h3>

        <div id="text-editor" class="input-wrap" style="display:none;">
            <label>Edit Text</label>
            <textarea id="text-value" rows="4"></textarea>
            <button onclick="saveChange('text')" class="primary">Save Text</button>
        </div>

        <!-- <div id="image-editor" class="input-wrap" style="display:none;">
            <label>Image URL</label>
            <input type="text" id="img-url">
            <button onclick="saveChange('image')" class="primary">Save Image</button>
        </div> -->
    <div id="image-editor" class="input-wrap" style="display:none;">
    <label>Image URL</label>
    <input type="text" id="img-url" placeholder="Paste image URL">

    <label style="margin-top:10px;">OR Upload Image</label>
    <input type="file" id="img-file" accept="image/*">

    <button onclick="saveChange('image')" class="primary" style="margin-top:10px;">Save Image</button>
  </div>


        <div id="color-editor" class="input-wrap" style="display:none;">
            <label>Color</label>
            <input type="color" id="color-value">
            <button onclick="saveChange('color')" class="primary">Save Color</button>
        </div>

        <div id="font-editor" class="input-wrap" style="display:none;">
            <label>Font Size</label>
            <input type="range" id="font-value" min="10" max="80">
            <div style="margin-top:8px"><button onclick="saveChange('font')" class="primary">Save Font Size</button></div>
        </div>

        <hr>
        <div style="margin-top:8px">
            <button onclick="publishCopy()">Publish (set as active)</button>
            <button onclick="resetCopy()">Reset Copy</button>
        </div>
    </div>
</div>

<div class="preview-wrap">
    <!-- iframe will load pages from the web-copy path like ../sites/1_theme-ecommerce_copy/home.php -->
    <iframe id="preview" src="<?php echo htmlspecialchars($webCopy . '/' . $firstPage); ?>"></iframe>
</div>

<script>
let currentSelector = null;
let currentPage = '<?php echo addslashes($firstPage); ?>';
const webCopy = "<?php echo addslashes($webCopy); ?>"; // e.g. ../sites/1_theme-ecommerce_copy

function loadPage(page) {
    currentPage = decodeURIComponent(page);
    document.getElementById('preview').src = webCopy + '/' + page;
}

/* receive messages from iframe (injected script)
   data: { type: "elementClicked", selector, tag, text, src, color, font }
*/
window.addEventListener("message", function(ev){
    const data = ev.data;
    if (!data || data.type !== 'elementClicked') return;

    currentSelector = data.selector;
    const tag = data.tag || '';
    document.getElementById('element-type').innerText = tag;

    if (tag === 'IMG') {
        document.getElementById('text-editor').style.display = 'none';
        document.getElementById('image-editor').style.display = 'block';
        document.getElementById('color-editor').style.display = 'none';
        document.getElementById('font-editor').style.display = 'none';
        document.getElementById('img-url').value = data.src || '';
    } else {
        document.getElementById('text-editor').style.display = 'block';
        document.getElementById('image-editor').style.display = 'none';
        document.getElementById('color-editor').style.display = 'block';
        document.getElementById('font-editor').style.display = 'block';
        document.getElementById('text-value').value = data.text || '';
        document.getElementById('color-value').value = data.color || '#000000';
        document.getElementById('font-value').value = parseInt((data.font||'16').replace('px','')) || 16;
    }
});

function saveChange(type) {
    if (!currentSelector) { alert('Select an element first by clicking in the preview'); return; }
    let value = '';
    ////--------type ----------------------------------///
    if (type === 'text') value = document.getElementById('text-value').value;
    if (type === 'image') {
    const fileInput = document.getElementById('img-file');
    const urlValue = document.getElementById('img-url').value;

    if (fileInput.files.length > 0) {
        let form = new FormData();
        form.append("copy", webCopy);
        form.append("page", currentPage);
        form.append("selector", currentSelector);
        form.append("type", "image_file");
        form.append("file", fileInput.files[0]);

        fetch("save_changes.php", { method: "POST", body: form })
        .then(r => r.text())
        .then(txt => {
            alert(txt);
            document.getElementById('preview').contentWindow.location.reload();
        });
        return;
    }

    // URL fallback
    value = urlValue;
}

    if (type === 'color') value = document.getElementById('color-value').value;
    if (type === 'font') value = document.getElementById('font-value').value + 'px';

    const params = new URLSearchParams();
    params.append('copy', webCopy);
    params.append('page', currentPage);
    params.append('selector', currentSelector);
    params.append('type', type);
    params.append('value', value);

    fetch('save_changes.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params.toString()
    }).then(r => r.text()).then(txt => {
        alert(txt);
        // reload only the iframe page to reflect change
        document.getElementById('preview').contentWindow.location.reload();
    });
}

// publish: mark this copy as active in DB (publishing script will set active_theme.user_custom_theme or theme_slug)
function publishCopy() {
    const params = new URLSearchParams();
    params.append('copy', webCopy);
    fetch('publish_theme.php', { method:'POST', body: params.toString() })
    .then(r => r.text())
    .then(txt => alert(txt));
}

function resetCopy() {
    if (!confirm('Reset the copied theme and recreate from original?')) return;
    const params = new URLSearchParams();
    params.append('copy', webCopy);
    fetch('reset_copy.php', { method:'POST', body: params.toString() })
    .then(r => r.text()).then(t => {
        alert(t);
        location.reload();
    });
}
</script>
<!-- <button id="saveWebsiteBtn" class="btn-save">💾 Save Website</button>

<script>
document.getElementById('saveWebsiteBtn').addEventListener('click', function () {
    if (!confirm("Are you sure you want to save your edited website?")) return;

    fetch("save_website.php", {
        method: "POST"
    })
    .then(res => res.text())
    .then(data => {
        alert(data);
        window.location.href = "saved_sites.php";
    });
});
</script>

<style>
.btn-save{
    background:white;
    padding:12px 20px;
    color:#fff;
    border:0;
    border-radius:6px;
    cursor:pointer;
    font-size:16px;
}
</style> -->

</body>
</html>
