<?php
if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['title']) && !empty($_GET['title']) && isset($_GET['template']) && !empty($_GET['template'])) {
    $pageId = $_GET['id'];
    $pageTitle = $_GET['title'];
    $pageTemplate = $_GET['template'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Modifier les paramètres de la page</title>
</head>
<body>
    <h1>Modifier les paramètres de la page</h1>
    <form action="#">
        <label for="page-title"></label>
        <input id="page-title" type="text" value="<?php echo $pageTitle ?>">
        <label for="page-template"></label>
        <input id="page-template" type="text" value="<?php echo $pageTemplate ?>">
        <input type="submit" value="Valider">
    </form>
</body>
</html>

