<?php
require_once '../partials/db.php';
include 'inc/header.php';
include 'inc/sidebar.php';

$cats = $conn->query("SELECT id,name FROM categories ORDER BY name ASC");
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = mysqli_real_escape_string($conn, $_POST['content'] ?? '');

    $meta_title = trim($_POST['meta_title'] ?? '');
    $category_id = is_numeric($_POST['category_id']) ? (int)$_POST['category_id'] : null;

    // image upload
    $image_name = null;
    if (!empty($_FILES['image']['name'])) {
        $img = $_FILES['image'];
        $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp','gif'];
        if (!in_array(strtolower($ext), $allowed)) {
            $err = 'Invalid image type';
        } else {
            $image_name = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '', $img['name']);
            move_uploaded_file($img['tmp_name'], '../images/' . $image_name);
        }
    }

    if (!$err) {
        $stmt = $conn->prepare("INSERT INTO posts (title, content, image, meta_title, category_id) VALUES (?,?,?,?,?)");
        $stmt->bind_param('ssssi', $title, $content, $image_name, $meta_title, $category_id);
        $stmt->execute();
        $stmt->close();
        header('Location: posts.php');
        exit;
    }
}
?>
<main class="main-content">
  <h2>Add Post</h2>
  <?php if($err): ?><div class="alert alert-danger"><?=htmlspecialchars($err)?></div><?php endif; ?>
  <form method="POST" enctype="multipart/form-data" onsubmit="syncEditor()">
    <div class="mb-3">
      <label>Title</label>
      <input name="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Category</label>
      <select name="category_id" class="form-control">
        <option value="">-- Select --</option>
        <?php while($c = $cats->fetch_assoc()): ?>
          <option value="<?=$c['id']?>"><?=htmlspecialchars($c['name'])?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label>Image</label>
      <input type="file" name="image" class="form-control">
    </div>

    <div class="mb-3">
      <label>Short Description</label>
      <input name="meta_title" class="form-control">
    </div>

    <!-- Rich Editor -->
    <div class="mb-2">
      <label>Content</label>
      <div class="editor-toolbar mb-1">
        <button type="button" onclick="format('bold')"><b>B</b></button>
        <button type="button" onclick="format('italic')"><i>I</i></button>
        <button type="button" onclick="format('underline')"><u>U</u></button>
        <button type="button" onclick="format('insertUnorderedList')">UL</button>
        <button type="button" onclick="format('insertOrderedList')">OL</button>
        <button type="button" onclick="format('formatBlock','H1')">H1</button>
        <button type="button" onclick="format('formatBlock','H2')">H2</button>
        <button type="button" onclick="format('formatBlock','H3')">H3</button>
        <button type="button" onclick="format('justifyLeft')">Left</button>
        <button type="button" onclick="format('justifyCenter')">Center</button>
        <button type="button" onclick="format('justifyRight')">Right</button>
        <button type="button" onclick="format('uppercase')">UPPER</button>
        <button type="button" onclick="format('lowercase')">lower</button>
        <button type="button" onclick="addLink()">Link</button>
      </div>
      <div id="editor" contenteditable="true"></div>
      <textarea name="content" id="contentHidden" style="display:none;"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Save Post</button>
  </form>

<script>
// Core function to format selected text
function format(command, value = null) {
    const selection = window.getSelection();
    if (!selection.rangeCount) return;

    const range = selection.getRangeAt(0);
    const selectedText = range.toString();
    if (!selectedText) return;

    let el;

    switch(command) {
        case 'bold':
            el = document.createElement('b'); break;
        case 'italic':
            el = document.createElement('i'); break;
        case 'underline':
            el = document.createElement('u'); break;
        case 'formatBlock':
            // normalize to lowercase tag name
            const tag = String(value || 'p').toLowerCase();
            el = document.createElement(tag);
            break;
        case 'uppercase':
        case 'lowercase':
            el = document.createElement('span');
            el.textContent = (command === 'uppercase') ? selectedText.toUpperCase() : selectedText.toLowerCase();
            break;
        case 'insertUnorderedList':
            document.execCommand('insertUnorderedList');
            return;
        case 'insertOrderedList':
            document.execCommand('insertOrderedList');
            return;
        case 'justifyLeft':
        case 'justifyCenter':
        case 'justifyRight':
            document.execCommand(command);
            return;
        default:
            return;
    }

    // For normal formatting (b,i,u,H1..H3)
    if (!el.textContent) el.textContent = selectedText;

    range.deleteContents();
    range.insertNode(el);

    // Move cursor after inserted node
    selection.removeAllRanges();
    const newRange = document.createRange();
    newRange.setStartAfter(el);
    newRange.setEndAfter(el);
    selection.addRange(newRange);
}

// Function to add link to selected text
function addLink() {
    let url = prompt("Enter URL (e.g. https://google.com):");
    if (!url) return;

    // Trim spaces and quotes
    url = url.trim().replace(/^["']|["']$/g, '');

    // Add https:// if missing
    if (!/^https?:\/\//i.test(url)) {
        url = 'https://' + url;
    }

    // Validate final URL using try/catch
    try {
        new URL(url); // throws error if invalid
    } catch (e) {
        alert("Invalid URL. Please enter a proper one like https://google.com");
        return;
    }

    // Get selected text
    const selection = window.getSelection();
    if (!selection.rangeCount) {
        alert("Please select text to create a link.");
        return;
    }

    const range = selection.getRangeAt(0);
    const selectedText = range.toString();
    if (!selectedText) {
        alert("Please select text before adding a link.");
        return;
    }

    // Create <a> tag
    const a = document.createElement('a');
    a.href = encodeURI(url); //  ensure safe encoding
    a.target = '_blank';
    a.rel = 'noopener noreferrer';
    a.textContent = selectedText;

    range.deleteContents();
    range.insertNode(a);
}


// Sync editor content into the hidden textarea
function syncEditor() {
    document.getElementById('contentHidden').value = document.getElementById('editor').innerHTML;
}

document.querySelectorAll('.editor-toolbar button').forEach(btn=>{
  btn.addEventListener('mousedown', function(e){
    e.preventDefault(); 
  });
});
</script>

</main>
