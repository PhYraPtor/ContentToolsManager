<?php

// SUPPRIMER CE FICHER AVANT LA RELEASE

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Site Admin</title>
</head>
<body>
<form action="add-user.php" method="post">
	<label for="identifiant">Identifiant</label>
	<input id="identifiant" name="login" type="text" placeholder="Pseudo">
	<label for="mail">Mail</label>
	<input id="mail" name="mail" type="text" placeholder="Adresse mail">
	<label for="password">Mot de passe</label>
	<input id="password" type="password" name="password">
	<input type="submit" value="Se connecter">
</form>
</body>
</html>

