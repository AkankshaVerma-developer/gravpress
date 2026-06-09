// // admin/builder/assets/js/builder.js
// // Requires GrapesJS and grapesjs-preset-webpage (we included both from CDN in index.php)

// document.addEventListener('DOMContentLoaded', async function () {
//   // Initialize GrapesJS editor with preset
//   const editor = grapesjs.init({
//     container: '#gjs',
//     height: '800px',
//     width: '1200px',
//     fromElement: false,
//     storageManager: { autoload: false, autosave: false },
//     plugins: ['gjs-preset-webpage'],
//     pluginsOpts: {
//       'gjs-preset-webpage': {}
//     },
//     canvas: {
//       styles: [],
//       scripts: []
//     },
//   });

//   // Move default panels into our UI: show block manager inside left panel
//   const bm = editor.BlockManager;
//   const panelEl = document.getElementById('gjs-blocks');
//   if (panelEl) panelEl.appendChild(bm.getContainer());

//   // Move asset manager inside our assetsPanel
//   const am = editor.AssetManager;
//   const assetsPanel = document.getElementById('gjs-assets');
//   if (assetsPanel) assetsPanel.appendChild(am.getContainer());

//   // Move style manager into right inspector (we'll display it)
//   const sm = editor.StyleManager;
//   const smContainer = editor.Panels.getPanel('views-container') || null;
//   // add style manager into rightpanel
//   const rightEl = document.getElementById('inspectorInner');
//   if (rightEl) rightEl.appendChild(editor.StyleManager.getContainer());

//   // Add a couple of base blocks (heading, paragraph, image, button, divider)
//   bm.add('heading', {
//     label: '<b>Heading</b>',
//     category: 'Basic',
//     attributes: { class: 'fa fa-header' },
//     content: '<h1 style="font-size:32px;margin:0;">Your Title</h1>'
//   });

//   bm.add('paragraph', {
//     label: 'Paragraph',
//     category: 'Basic',
//     content: '<p style="font-size:16px;line-height:1.6;color:#333;">Insert your paragraph here</p>'
//   });

//   bm.add('button', {
//     label: 'Button',
//     category: 'Basic',
//     content: '<button style="background:#ff6b6b;color:#fff;padding:10px 18px;border-radius:6px;border:0;">Click me</button>'
//   });

//   bm.add('image', {
//     label: 'Image',
//     category: 'Basic',
//     content: { type:'image' }
//   });

//   bm.add('divider', {
//     label: 'Divider',
//     category: 'Basic',
//     content: '<hr style="border:none;border-top:1px solid #eee;margin:16px 0" />'
//   });

//   // Add Sections (predefined) into sections panel
//   const sections = [
//     { id:'hero', label:'Hero', content: `<section style="padding:80px 40px;text-align:center;background:#f7f8ff"><h1 style="font-size:40px;margin:0">Hero Title</h1><p style="margin-top:12px;color:#666">A short subtitle</p></section>` },
//     { id:'about', label:'About', content: `<section style="padding:60px 40px;background:#fff"><div style="max-width:900px;margin:0 auto"><h2>About us</h2><p>Describe your company</p></div></section>` },
//     { id:'contact', label:'Contact', content: `<section style="padding:40px;background:#f9fafb"><div style="max-width:900px;margin:0 auto"><h3>Contact</h3><p>Please contact us</p></div></section>` }
//   ];
//   const sectionsEl = document.getElementById('gjs-sections');
//   sections.forEach(s => {
//     const btn = document.createElement('div');
//     btn.className = 'gjs-block-section';
//     btn.style = 'background:#fff;padding:12px;border-radius:8px;margin-bottom:8px;cursor:pointer';
//     btn.innerHTML = `<strong>${s.label}</strong><div style="color:#666;font-size:13px;margin-top:6px">Preview</div>`;
//     btn.addEventListener('click', () => editor.DomComponents.addComponent({ content: s.content, type: 'default' }));
//     sectionsEl.appendChild(btn);
//   });

//   // Block search box (simple filter)
//   const search = document.getElementById('blockSearch');
//   if (search) {
//     search.addEventListener('input', () => {
//       const q = search.value.trim().toLowerCase();
//       const blocks = document.querySelectorAll('.gjs-block');
//       blocks.forEach(b => {
//         const label = (b.querySelector('.gjs-block-label')?.innerText || '').toLowerCase();
//         b.style.display = label.indexOf(q) === -1 ? 'none' : '';
//       });
//     });
//   }

//   // Pages manager: load pages for this website (via AJAX)
//   const pagesSelect = document.getElementById('pagesSelect');
//   async function loadPages() {
//     if (!window.WEBSITE_ID || WEBSITE_ID == 0) return;
//     try {
//       const res = await fetch('load_pages_list.php?website_id=' + WEBSITE_ID);
//       const data = await res.json();
//       if (data.status === 'ok') {
//         pagesSelect.innerHTML = '';
//         data.pages.forEach(p => {
//           const o = document.createElement('option');
//           o.value = p.page_name;
//           o.text = p.page_name;
//           pagesSelect.appendChild(o);
//         });
//       }
//     } catch (err) {
//       console.warn('Failed loading pages list', err);
//     }
//   }
//   await loadPages();

//   // Load active page content (default 'home' if available)
//   async function loadPage(pageName = 'home') {
//     if (!window.WEBSITE_ID || WEBSITE_ID == 0) {
//       editor.setComponents('<div style="padding:40px;text-align:center"><h2>Create or open a website first</h2></div>');
//       return;
//     }
//     try {
//       const res = await fetch('load_page.php?website_id=' + WEBSITE_ID + '&page_name=' + encodeURIComponent(pageName));
//       const data = await res.json();
//       if (data.status === 'ok') {
//         if (data.grapes_json) {
//           try {
//             const json = JSON.parse(data.grapes_json);
//             if (json) {
//               editor.loadProjectData(json);
//             } else {
//               editor.setComponents(data.html || '<div></div>');
//             }
//           } catch(e) {
//             editor.setComponents(data.html || '<div></div>');
//             editor.setStyle(data.css || '');
//           }
//         } else {
//           editor.setComponents(data.html || '<div></div>');
//           editor.setStyle(data.css || '');
//         }
//       } else {
//         // no page found: blank
//         editor.setComponents('<div></div>');
//       }
//     } catch (err) {
//       console.error('Load page failed', err);
//       editor.setComponents('<div></div>');
//     }
//   }
//   // initial load
//   await loadPage('home');

//   // pagesSelect change
//   pagesSelect.addEventListener('change', e => loadPage(e.target.value));

//   // Add page button
//   document.getElementById('addPageBtn').addEventListener('click', async () => {
//     const name = prompt('New page name (e.g. about):');
//     if (!name) return;
//     try {
//       const fd = new FormData(); fd.append('website_id', WEBSITE_ID); fd.append('page_name', name); fd.append('html', '<div></div>'); fd.append('css', ''); fd.append('grapes_json', JSON.stringify({components: []}));
//       const res = await fetch('save_page.php', { method: 'POST', body: fd });
//       const data = await res.json();
//       if (data.status === 'ok') {
//         await loadPages();
//         pagesSelect.value = name;
//         loadPage(name);
//       } else alert('Failed creating page: ' + (data.message || 'unknown'));
//     } catch (err) { console.error(err); alert('Network error'); }
//   });

  // rename page
  // document.getElementById('renamePageBtn').addEventListener('click', async () => {
  //   const oldName = pagesSelect.value;
  //   if (!oldName) return alert('No page selected');
  //   const newName = prompt('Rename page to:', oldName);
  //   if (!newName || newName === oldName) return;
  //   // To rename we will duplicate under new name and delete old 
  //   try {
  //     // fetch old data
  //     const res = await fetch('load_page.php?website_id=' + WEBSITE_ID + '&page_name=' + oldName);
  //     const data = await res.json();
  //     if (data.status !== 'ok') return alert('Cannot load page');
  //     const fd = new FormData();
  //     fd.append('website_id', WEBSITE_ID);
  //     fd.append('page_name', newName);
  //     fd.append('html', data.html || '');
  //     fd.append('css', data.css || '');
  //     fd.append('grapes_json', data.grapes_json || '');
  //     const res2 = await fetch('save_page.php', { method: 'POST', body: fd });
  //     const d2 = await res2.json();
  //     if (d2.status === 'ok') {
  //       // delete old page.js endpoint (not implemented: you can implement delete_page.php)
  //       await loadPages();
  //       pagesSelect.value = newName;
  //       loadPage(newName);
  //     } else alert('Rename failed');
  //   } catch (err) { console.error(err); }
  // });

//   // Add section button (inserts a container wrapper block)
//   document.getElementById('addSectionBtn').addEventListener('click', () => {
//     const section = `<section style="padding:60px 30px;background:#fff"><div style="max-width:1000px;margin:0 auto"><h2>New Section</h2><p>Add content inside this section</p></div></section>`;
//     editor.Components.addComponent(section);
//   });

//   // zoom controls
//   let zoomVal = 100;
//   const zoomValEl = document.getElementById('zoomVal');
//   document.getElementById('zoomIn').addEventListener('click', () => {
//     zoomVal = Math.min(200, zoomVal + 10);
//     editor.setZoom(zoomVal/100);
//     zoomValEl.innerText = zoomVal + '%';
//   });
//   document.getElementById('zoomOut').addEventListener('click', () => {
//     zoomVal = Math.max(30, zoomVal - 10);
//     editor.setZoom(zoomVal/100);
//     zoomValEl.innerText = zoomVal + '%';
//   });

//   // preview
//   document.getElementById('previewBtn').addEventListener('click', () => editor.runCommand('preview'));

//   // Clear canvas
//   document.getElementById('clearCanvasBtn').addEventListener('click', () => {
//     if (confirm('Clear page content?')) editor.runCommand('core:canvas-clear');
//   });

//   // Save button: get HTML, CSS, and grapes JSON and send to save_page.php
//   document.getElementById('saveBtn').addEventListener('click', async () => {
//     try {
//       const html = editor.getHtml();
//       const css = editor.getCss();
//       const json = editor.getProjectData();
//       const fd = new FormData();
//       fd.append('website_id', WEBSITE_ID || 0);
//       fd.append('page_name', pagesSelect.value || 'home');
//       fd.append('html', html);
//       fd.append('css', css);
//       fd.append('grapes_json', JSON.stringify(json));
//       const res = await fetch('save_page.php', { method: 'POST', body: fd });
//       const data = await res.json();
//       if (data.status === 'ok') alert('Saved');
//       else alert('Save failed: ' + (data.message || 'unknown'));
//       await loadPages();
//     } catch (err) { console.error(err); alert('Save failed'); }
//   });

//   // Publish: call publish_site.php for current page
//   document.getElementById('publishBtn').addEventListener('click', async () => {
//     if (!confirm('Publish will generate static files under sites/ folder. Continue?')) return;
//     const page = pagesSelect.value || 'home';
//     try {
//       const res = await fetch('publish_site.php?website_id=' + WEBSITE_ID + '&page_name=' + encodeURIComponent(page));
//       const data = await res.json();
//       if (data.status === 'ok') alert('Published: ' + data.path);
//       else alert('Publish failed: ' + (data.message || 'unknown'));
//     } catch (err) { console.error(err); alert('Publish error'); }
//   });

// });

document.addEventListener("DOMContentLoaded", async () => {
  // --- Initialize GrapesJS editor ---
  window.editor = grapesjs.init({
    container: "#gjs",
    height: "100%",
    width: "100%",
    storageManager: false,
    plugins: ['gjs-preset-webpage'],
    pluginsOpts: { 'gjs-preset-webpage': {} },
    styleManager: {
      sectors: [
        { name: "Typography", open: true, buildProps: ["font-family","font-size","font-weight","color","line-height","letter-spacing","text-align","text-transform"] },
        { name: "Background", open: false, buildProps: ["background","background-color"] },
        { name: "Borders", open:false, buildProps: ["border","border-radius"] },
        { name: "Spacing", open:false, buildProps: ["margin","padding"] },
        { name: "Size", open:false, buildProps: ["width","height","max-width"] }
      ]
    }
  });

  // --- Utility: fetch HTML file content, return string or null on error ---
  async function loadBlockHtml(path) {
    try {
      const res = await fetch(path, { cache: "no-store" });
      if (!res.ok) { console.warn("Missing block file:", path); return null; }
      return await res.text();
    } catch (err) {
      console.warn("Error loading block file:", path, err);
      return null;
    }
  }

  // --- Register elements (blocks) from your folder automatically ---
  const elementFiles = [
    "heading.html",
    "paragraph.html",
    "image.html",
    "button.html",
    "divider.html",
    "container.html"
  ];

  const sectionFiles = [
    "hero.html",
    "about.html",
    "services.html",
    "gallery.html",
    "contact.html"
  ];

  const bm = editor.BlockManager;

  // load element files and register blocks
  for (const file of elementFiles) {
    const path = `blocks/elements/${file}`;
    const html = await loadBlockHtml(path);
    if (html) {
      // use file name (without extension) as id
      const id = file.replace('.html','');
      bm.add(id, {
        id,
        label: id.charAt(0).toUpperCase() + id.slice(1),
        category: 'Elements',
        content: html
      });
    }
  }

  // load section files and register as blocks (category: Sections)
  for (const file of sectionFiles) {
    const path = `blocks/sections/${file}`;
    const html = await loadBlockHtml(path);
    if (html) {
      const id = 'section-' + file.replace('.html','');
      bm.add(id, {
        id,
        label: file.replace('.html','').replace('-', ' ').replace('_',' '),
        category: 'Sections',
        content: html
      });
    }
  }

  // --- Put GrapesJS block manager & asset manager containers into your left panels ---
  // BlockManager container
  const blocksPanelEl = document.getElementById('gjs-blocks');
  if (blocksPanelEl) {
    const bmContainer = bm.getContainer();
    // Clear existing children, then append the grapes block container
    blocksPanelEl.innerHTML = '';
    blocksPanelEl.appendChild(bmContainer);
  }

  // Asset manager container into assets panel
  const assetsPanelEl = document.getElementById('gjs-assets');
  if (assetsPanelEl) {
    assetsPanelEl.innerHTML = '';
    assetsPanelEl.appendChild(editor.AssetManager.getContainer());
  }

  // Move style manager to right panel if it exists 
  const inspectorInner = document.getElementById('inspectorInner');
  if (inspectorInner) {
    // style manager container
    const styleContainer = editor.StyleManager.getContainer();
    inspectorInner.appendChild(styleContainer);
  }

  // --- Rich text controls: add common  actions (bold, italic, color, fontsize) ---
  editor.on("rte:enable", (rte, component) => {
    // basic actions: add only if not already registered
    const addIfNot = (name, config) => {
      try { rte.addAction(name, config); } catch (e) { /* ignore if already */ }
    };

    addIfNot("bold", { icon: "<b>B</b>", attributes: { title: "Bold" }, result: rte => rte.exec("bold") });
    addIfNot("italic", { icon: "<i>I</i>", attributes: { title: "Italic" }, result: rte => rte.exec("italic") });
    addIfNot("underline", { icon: "<u>U</u>", attributes: { title: "Underline" }, result: rte => rte.exec("underline") });

    addIfNot("color", {
      icon: "A", attributes: { title: "Text color" },
      result: () => {
        const color = prompt("Enter text color (name or hex):", "#000000");
        if (color) component.addStyle({ color });
      }
    });

    addIfNot("fontsize", {
      icon: "F", attributes: { title: "Font size" },
      result: () => {
        const size = prompt("Enter font size (eg. 24px):", "16px");
        if (size) component.addStyle({ "font-size": size });
      }
    });
  });

  // --- Open style manager automatically when user selects a component ---
  editor.on("component:selected", () => {
    try {
      const btn = editor.Panels.getButton("options", "sw-visibility");
      if (btn) btn.set("active", 1);
    } catch (e) {
      // ignore if panel doesn't exist
    }
  });

  // --- Tabs (Elements / Sections / Assets) switching logic ---
  const tabButtons = document.querySelectorAll(".gp-tab");
  const panels = {
    blocks: document.getElementById("blocksPanel"),
    sections: document.getElementById("sectionsPanel"),
    assets: document.getElementById("assetsPanel")
  };

  tabButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      tabButtons.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      const tab = btn.dataset.tab;
      Object.values(panels).forEach(p => p.classList.add("hidden"));
      if (panels[tab]) panels[tab].classList.remove("hidden");

      // Activate grapes internal panels if available (safe try/catch)
      try {
        if (tab === "blocks" || tab === "sections") {
          const bBtn = editor.Panels.getButton("views", "open-blocks");
          if (bBtn) bBtn.set("active", 1);
        } else if (tab === "assets") {
          const aBtn = editor.Panels.getButton("views", "open-assets");
          if (aBtn) aBtn.set("active", 1);
        }
      } catch (err) { /* ignore */ }
    });
  });

  // --- Device selector (Desktop/Tablet/Mobile) ---
  const deviceSelect = document.getElementById('deviceSelect');
  if (deviceSelect) {
    deviceSelect.addEventListener('change', (e) => {
      const val = e.target.value;
      // GrapesJS uses device manager names like 'Desktop','Tablet','Mobile' if configured by preset
      try { editor.setDevice(val); } catch (err) {
        // fallback: adjust canvas width manually
        const canvasEl = document.querySelector('#gjs .gjs-cv-canvas');
        if (canvasEl) {
          if (val === 'Mobile') canvasEl.style.width = '375px';
          else if (val === 'Tablet') canvasEl.style.width = '768px';
          else canvasEl.style.width = '';
        }
      }
    });
  }

  // --- Zoom controls ---
let zoomVal = 100;
const zoomInBtn = document.getElementById("zoomIn");
const zoomOutBtn = document.getElementById("zoomOut");
const zoomValEl = document.getElementById("zoomVal");
const preview = document.getElementById("editorPreview");

function applyZoom() {
  preview.style.transform = `scale(${zoomVal / 100})`;
  preview.style.transformOrigin = "top left";
}

zoomInBtn.addEventListener("click", () => {
  zoomVal = Math.min(200, zoomVal + 10);
  zoomValEl.innerText = zoomVal + "%";
  applyZoom();
});

zoomOutBtn.addEventListener("click", () => {
  zoomVal = Math.max(30, zoomVal - 10);
  zoomValEl.innerText = zoomVal + "%";
  applyZoom();
});

// set initial zoom
applyZoom();


  // --- Add Section button ---
 document.addEventListener("DOMContentLoaded", () => {

  window.editor = window.editor || editor; // ensure global

  const btn = document.getElementById("addSectionBtn");

  if (!btn) return console.error("❌ Button not found");

  btn.addEventListener("click", () => {

    console.log("Button clicked");

    if (!window.editor) {
      alert("Editor not loaded!");
      return;
    }

    const newPage = editor.addComponents(`
      <section style="min-height:500px;padding:50px;background:#fff;border:1px solid #ccc;margin:20px 0;">
        <h2>New Section</h2>
        <p>Click text to edit.</p>
      </section>
    `);

    editor.select(newPage);

  });

});


  // --- Clear canvas button ---
  const clearBtn = document.getElementById('clearCanvasBtn');
  if (clearBtn) clearBtn.addEventListener('click', () => {
    if (confirm('Clear the page?')) editor.runCommand('core:canvas-clear');
  });

  // --- Preview (use grapes preview command) ---
  const previewBtn = document.getElementById('previewBtn');
  if (previewBtn) previewBtn.addEventListener('click', () => {
    try { editor.runCommand('preview'); } catch (e) { // fallback open new window
      const html = editor.getHtml(); const css = editor.getCss();
      const w = window.open('', '_blank');
      w.document.write(`<!doctype html><html><head><meta charset="utf-8"><style>${css}</style></head><body>${html}</body></html>`);
      w.document.close();
    }
  });

  // --- Save button: send to save_page.php --- (expects server endpoint from earlier)
  const saveBtn = document.getElementById('saveBtn');
  if (saveBtn) saveBtn.addEventListener('click', async () => {
    try {
      const html = editor.getHtml();
      const css = editor.getCss();
      const json = editor.getProjectData ? editor.getProjectData() : editor.getComponents();
      const grapesStr = JSON.stringify(json);

      const fd = new FormData();
      fd.append('website_id', (new URLSearchParams(location.search)).get('website_id') || 0);
      fd.append('page_name', (document.getElementById('pagesSelect')?.value) || 'home');
      fd.append('html', html);
      fd.append('css', css);
      fd.append('grapes_json', grapesStr);

      const res = await fetch('save_page.php', { method: 'POST', body: fd });
      const data = await res.json();
      if (data.status === 'ok') alert('Saved');
      else alert('Save failed: ' + (data.message || 'unknown'));
    } catch (err) {
      console.error(err);
      alert('Save failed (see console)');
    }
  });
  //-------------------------------------------------------------------------//
document.getElementById("savePageBtn").addEventListener("click", async () => {
    let htmlContent = document.getElementById("canvas").innerHTML;

    let formData = new FormData();
    formData.append("content", htmlContent);

    let response = await fetch("saved_site.php", {
        method: "POST",
        body: formData
    });

    let result = await response.text();
    alert(result); // popup message
});

  // --- Publish (calls publish_site.php) ---
  const publishBtn = document.getElementById('publishBtn');
  if (publishBtn) publishBtn.addEventListener('click', async () => {
    if (!confirm('Publish will create static HTML files in sites/ folder. Continue?')) return;
    const page = (document.getElementById('pagesSelect')?.value) || 'home';
    const websiteId = (new URLSearchParams(location.search)).get('website_id') || 0;
    try {
      const res = await fetch(`publish_site.php?website_id=${websiteId}&page_name=${encodeURIComponent(page)}`);
      const data = await res.json();
      if (data.status === 'ok') alert('Published to: ' + data.path);
      else alert('Publish failed: ' + (data.message || 'unknown'));
    } catch (err) {
      console.error(err);
      alert('Publish failed (network)');
    }
  });

  // --- Pages list loader (optional, simple) ---
  const pagesSelect = document.getElementById('pagesSelect');
  async function loadPagesList() {
    try {
      const websiteId = (new URLSearchParams(location.search)).get('website_id') || 0;
      if (!websiteId || !pagesSelect) return;
      const res = await fetch('load_pages_list.php?website_id=' + websiteId);
      const data = await res.json();
      if (data.status === 'ok' && Array.isArray(data.pages)) {
        pagesSelect.innerHTML = '';
        data.pages.forEach(p => {
          const opt = document.createElement('option');
          opt.value = p.page_name; opt.text = p.page_name;
          pagesSelect.appendChild(opt);
        });
      } else {
        // create a default 'home' if none
        pagesSelect.innerHTML = '<option value="home">home</option>';
      }
    } catch (err) {
      console.warn('pages load failed', err);
    }
  }
  await loadPagesList();

  // load selected page (default 'home')
  async function loadPage(pageName = 'home') {
    try {
      const websiteId = (new URLSearchParams(location.search)).get('website_id') || 0;
      if (!websiteId) {
        editor.setComponents('<div style="padding:40px;text-align:center"><h2>Create or open a website first</h2></div>');
        return;
      }
      const res = await fetch(`load_page.php?website_id=${websiteId}&page_name=${encodeURIComponent(pageName)}`);
      const data = await res.json();
      if (data.status === 'ok') {
        if (data.grapes_json) {
          try { editor.loadProjectData(JSON.parse(data.grapes_json)); return; } catch (e) {}
        }
        editor.setComponents(data.html || '<div></div>');
        editor.setStyle(data.css || '');
      } else {
        editor.setComponents('<div></div>');
      }
    } catch (err) {
      console.error('load page error', err);
      editor.setComponents('<div></div>');
    }
  }
  // initial load
  await loadPage((pagesSelect?.value) || 'home');
  // on change
  if (pagesSelect) pagesSelect.addEventListener('change', (e) => loadPage(e.target.value));

  // --- End initialization ---
  console.info('Builder initialized');
});
