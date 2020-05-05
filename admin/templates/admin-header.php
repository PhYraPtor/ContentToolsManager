<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']?>/admin/assets/css/admin.css">
	<title>Site Admin</title>
</head>
<body>
<header>
    <nav>
        <a href="/admin/admin.php">Admin</a>
        <a href="/admin/admin.php?view=pages-admin">Pages</a>
        <a href="/admin/admin.php?view=user-list">Utilisateurs</a>
        <a href="/admin/admin.php?view=add-user-form">Ajouter un utilisateur</a>
        <a href="#">Paramètres du site</a>
    </nav>
</header>
