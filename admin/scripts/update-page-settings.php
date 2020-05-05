<?php
if (isset($_POST['pageTitle']) && !empty($_POST['pageTitle']) && isset($_POST['pageTemplate']) && !empty($_POST['pageTemplate']) && isset($_POST['pageId']) && !empty($_POST['pageId'])) {
    require('../../db-config.php');
    $r = $dbh->prepare('UPDATE pages SET title = ?, pretty_title = ?, template = ?, modified = NOW() WHERE id = ?');
    $r -> execute([$_POST['pageTitle'], $_POST['prettyTitle'], $_POST['pageTemplate'], $_POST['pageId']]);
    header('Location:http://'.$_SERVER['HTTP_HOST'].'/admin/admin.php?view=pages-admin');
} else {
    // Pas les arguments suffisants
    echo 'Erreur dans les argmuents';
}
?>
