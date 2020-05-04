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
        <a href="/">Admin</a>
        <a href="#">Pages</a>
        <a href="#">Utilisateurs</a>
        <a href="#">Ajouter un utilisateur</a>
        <a href="#">Paramètres du site</a>
    </nav>
</header>
