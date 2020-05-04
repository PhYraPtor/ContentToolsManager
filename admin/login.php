<?php
session_start();
if (!empty($_SESSION['username'])) {
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/admin/assets/css/admin.css">
		<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/admin/assets/css/login.css">
    <title>Site Admin</title>
</head>
<body>
<section class="login-form-container">
	<form class="login-form" action="auth.php" method="post">
		<h1>Connexion</h1>
		<input id="identifiant" name="login" type="text" placeholder="Identifiant ou mail">
		<input id="password" type="password" name="password" placeholder="Mot de passe">
		<input type="submit" value="Se connecter">
	</form>
	<a href="/">Retour à l'accueil</a>
</section>
</body>
</html>

