<?php
include "../connection/db.php";
// include "../core/plugin-utils.php";

$plugins = scandir("../plugins");

// $stmt = $conn->prepare("SELECT plugin_slug, plugin_status FROM gp_plugins");
$stmt = $conn->prepare("SELECT plugin_slug, plugin_status FROM gp_plugins");

$stmt->execute();
$dbPlugins = [];
$stmt->bind_result($slug, $status);

while ($stmt->fetch()) {
    $dbPlugins[$slug] = $status;
}

?>

<table border="1" cellpadding="10" width="100%">
<tr>
  <th>Plugin</th>
  <th>Status</th>
  <th>Action</th>
</tr>

<?php foreach ($plugins as $plugin): ?>
<?php 
    if ($plugin === "." || $plugin === "..") continue;
    
    $pluginFile = "../plugins/$plugin/$plugin.php";
    // $meta = gp_parse_plugin_header($pluginFile);

    $status = $dbPlugins[$plugin] ?? "inactive";
?>
<tr>
  <!-- <td>
    <strong><?= $meta["Plugin Name"] ?></strong><br>
    <small><?= $meta["Description"] ?></small>
    <br><small><em>Version: <?= $meta["Version"] ?> — Author: <?= $meta["Author"] ?></em></small>
  </td> -->
  
  <td><?= ucfirst($status) ?></td>
  
  <td>
    <?php if ($status === "inactive"): ?>
        <a href="plugins_action.php?plugin=<?= $plugin ?>&action=activate">Activate</a>
    <?php else: ?>
        <a href="plugins_action.php?plugin=<?= $plugin ?>&action=deactivate">Deactivate</a>
    <?php endif; ?>
  </td>
  <td>
    <?php if ($status === "active"): ?>
        <a href="plugins_action.php?plugin=<?= $plugin ?>&action=deactivate">Deactivate</a> |
        <a href="plugin-settings.php?plugin=<?= $plugin ?>">Settings</a>
    <?php else: ?>
        <a href="plugins_action.php?plugin=<?= $plugin ?>&action=activate">Activate</a>
    <?php endif; ?>
</td>
<?php if ($status === "active"): ?>
    <a href="plugins_action.php?plugin=<?= $plugin ?>&action=deactivate">Deactivate</a> |
    <a href="plugin-settings.php?plugin=<?= $plugin ?>">Settings</a> |
    <a href="plugins_action.php?plugin=<?= $plugin ?>&action=uninstall" style="color:red;">Uninstall</a>
<?php else: ?>
    <a href="plugins_action.php?plugin=<?= $plugin ?>&action=activate">Activate</a> |
    <a href="plugins_action.php?plugin=<?= $plugin ?>&action=uninstall" style="color:red;">Uninstall</a>
<?php endif; ?>

</tr>
<?php endforeach; ?>

</table>
