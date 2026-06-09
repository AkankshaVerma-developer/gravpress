<?php
session_start();
require_once "../connection/db.php";

// if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['user_name']; // FIXED

// Get active theme
$res = $conn->query("SELECT theme_slug FROM active_theme WHERE user_id=$user_id");
$row = $res->fetch_assoc();
$theme = $row ? $row['theme_slug'] : "light";

// TEMP FIX (until you share the database)
$websites = [];
$active_sites_count = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - GravPress</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
      <!-- Sidebar -->
    <!-- <div class="sidebar">
        <div class="logo">
            <h2>GravPress</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="nav-item active">
                <span class="icon">🏠</span>
                <span>Dashboard</span>
            </a>
            <a href="my-sites.php" class="nav-item">
                <span class="icon">🌐</span>
                <span>My Sites</span>
            </a>
            <a href="themes.php" class="nav-item">
                <span class="icon">🎨</span>
                <span>Themes</span>
            </a>
            <a href="media.php" class="nav-item">
                <span class="icon">📁</span>
                <span>Media</span>
            </a>
            <a href="settings.php" class="nav-item">
                <span class="icon">⚙️</span>
                <span>Settings</span>
            </a>
            <a href="logout.php" class="nav-item">
                <span class="icon">🚪</span>
                <span>Logout</span>
            </a>
        </nav>
    </div> -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Welcome back, <?php echo htmlspecialchars($username); ?>!</h1>
            <div class="selectedTheme">
            <h2>Activated Theme: <?php echo ucfirst($theme); ?></h2>

<a href="preview.php?theme=<?php echo $theme; ?>" class="btn">Preview Theme</a>
<a href="create_theme_copy.php?theme=<?php echo $theme; ?>" class="btn">Edit Theme</a>

</div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🌐</div>
                    <div class="stat-info">
                        <h3><?php echo count($websites); ?></h3>
                        <p>Total Sites</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📄</div>
                    <div class="stat-info">
                        <h3>0</h3>
                        <p>Total Pages</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-info">
                        <h3>0</h3>
                        <p>Total Visits</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⚡</div>
                    <div class="stat-info">
                        <h3><?php echo $active_sites_count; ?></h3>
                        <p>Active Sites</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="section">
                <h2>Quick Actions</h2>
                <div class="actions-grid">
                    <a href="create_own_website.php" class="action-card">
                        <span class="action-icon">➕</span>
                        <h3>Create New Site</h3>
                        <p>Start building your website</p>
                    </a>
                    <a href="../user/view/gravtheme.php" class="action-card">
                        <span class="action-icon">🎨</span>
                        <h3>Browse Themes</h3>
                        <p>Choose from our collection</p>
                    </a>
                    <a href="media.php" class="action-card">
                        <span class="action-icon">📤</span>
                        <h3>Upload Media</h3>
                        <p>Add images and files</p>
                    </a>
                </div>
            </div>

            <!-- Recent Sites -->
            <div class="section">
                <!-- <div class="section-header">
                    <h2>Your Websites</h2>
                    <a href="create-site.php" class="btn-primary">+ New Site</a>
                </div> -->
                
                <?php if (count($websites) > 0): ?>
                    <div class="sites-grid">
                        <?php foreach ($websites as $site): ?>
                            <div class="site-card">
                                <div class="site-header">
                                    <h3><?php echo htmlspecialchars($site['site_name']); ?></h3>
                                    <span class="status <?php echo (!empty($site['is_active']) || !empty($site['active'])) ? 'active' : 'inactive'; ?>">
                                        <?php echo (!empty($site['is_active']) || !empty($site['active'])) ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </div>
                                <div class="site-info">
                                    <p class="site-url">
                                        <span class="icon">🔗</span>
                                        <?php echo htmlspecialchars($site['subdomain']); ?>.gravpress.com
                                    </p>
                                    <p class="site-theme">
                                        <span class="icon">🎨</span>
                                        Theme: <?php echo htmlspecialchars($site['theme_name'] ?? 'Not Set'); ?>
                                    </p>
                                </div>
                                <div class="site-actions">
                                    <a href="edit-site.php?id=<?php echo $site['id']; ?>" class="btn-secondary">Edit</a>
                                    <a href="customize.php?id=<?php echo $site['id']; ?>" class="btn-secondary">Customize</a>
                                    <a href="../sites/<?php echo $site['subdomain']; ?>" target="_blank" class="btn-secondary">View</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <span class="empty-icon">🌐</span>
                        <h3>No websites yet</h3>
                        <p>Create your first website to get started!</p>
                        <a href="create_own_website.php" class="btn-primary">Create Your First Site</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


<!-- --------------------/* for counting site*/---------------------- -->
<script>
async function refreshCounts(){
  try {
    const res = await fetch('counts.php');
    if (!res.ok) return;
    const j = await res.json();
    document.querySelector('#count-sites').textContent = j.sites;
    document.querySelector('#count-pages').textContent = j.pages;
    document.querySelector('#count-visits').textContent = j.visits;
    document.querySelector('#count-active').textContent = j.active;
  } catch(e){}
}
setInterval(refreshCounts, 5000);
refreshCounts();
</script>

</body>
</html>
