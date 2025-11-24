<!DOCTYPE html>
<html>
<head>
    <title>Website Builder</title>
   <style>
    body {
    margin: 0;
    font-family: Arial;
}

.builder-container {
    display: flex;
    height: 100vh;
}

/* Sidebar */
.sidebar {
    width: 240px;
    background: #1e1f26;
    color: #fff;
    padding: 20px;
    overflow-y: auto;
}

.sidebar h2 {
    margin-bottom: 10px;
}

.block {
    padding: 12px;
    background: #2d2f39;
    margin-bottom: 10px;
    border-radius: 6px;
    cursor: grab;
}

.block:hover {
    background: #3a3c48;
}

/* Canvas */
.canvas {
    flex: 1;
    background: #f5f5f5;
    border-left: 3px solid #ddd;
    padding: 20px;
    overflow-y: scroll;
}

.placeholder {
    text-align: center;
    color: #818181;
    margin-top: 40px;
}

/* Dropped Elements */
.element {
    border: 1px dashed #aaa;
    padding: 20px;
    margin-bottom: 15px;
    background: #fff;
    position: relative;
}

.remove-btn {
    position: absolute;
    top: 6px;
    right: 6px;
    background: red;
    color: #fff;
    font-size: 12px;
    border: none;
    padding: 3px 6px;
    cursor: pointer;
    border-radius: 4px;
}

    </style>
</head>

<body>

<div class="builder-container">

    <!-- LEFT SIDEBAR WITH BLOCKS -->
    <div class="sidebar">
        <h2>Blocks</h2>

        <div class="block" draggable="true" data-file="header.html">Header</div>
        <div class="block" draggable="true" data-file="text.html">Text</div>
        <div class="block" draggable="true" data-file="image.html">Image</div>
        <div class="block" draggable="true" data-file="button.html">Button</div>
        <div class="block" draggable="true" data-file="two-column.html">Two Column</div>
        <div class="block" draggable="true" data-file="footer.html">Footer</div>
    </div>

    <!-- MAIN CANVAS -->
    <div class="canvas" id="canvas">
        <h2 class="placeholder">Drag Blocks Here</h2>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

    const blocks = document.querySelectorAll(".block");
    const canvas = document.getElementById("canvas");

    blocks.forEach(block => {
        block.addEventListener("dragstart", (e) => {
            e.dataTransfer.setData("file", block.dataset.file);
        });
    });

    canvas.addEventListener("dragover", (e) => {
        e.preventDefault();
    });

    canvas.addEventListener("drop", async (e) => {
        e.preventDefault();
        const file = e.dataTransfer.getData("file");

      const response = await fetch("./blocks/" + file);

        const html = await response.text();

        const wrapper = document.createElement("div");
        wrapper.classList.add("element");
        wrapper.innerHTML = html + `<button class="remove-btn">X</button>`;

        // Remove placeholder text when first block added
        let placeholder = document.querySelector(".placeholder");
        if (placeholder) placeholder.remove();

        canvas.appendChild(wrapper);

        // Remove element button
        wrapper.querySelector(".remove-btn").onclick = () => wrapper.remove();
    });
});

</script>

</body>
</html>
