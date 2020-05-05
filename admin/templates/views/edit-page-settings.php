<?php
if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['title']) && isset($_GET['template']) && isset($_GET['prettyTitle'])) {
    $pageId = $_GET['id'];
    $pageTitle = $_GET['title'];
    $pageTemplate = $_GET['template'];
    $prettyTitle = $_GET['prettyTitle'];
    ?>
	<h1>Modifier les paramètres de la page</h1>
	<form action="../../admin/scripts/update-page-settings.php" method="post">
		<label for="page-title">Slug</label>
		<input id="page-title" type="text" name="pageTitle" value="<?php echo $pageTitle ?>">
		<label for="pretty-title">Titre</label>
		<input id="pretty-title" type="text" name="prettyTitle" value="<?php echo $prettyTitle ?>">
		<label for="page-template">Template</label>
		<input id="page-template" type="text" name="pageTemplate" value="<?php echo $pageTemplate ?>">
		<input type="hidden" name="pageId" value="<?php echo $pageId ?>">
		<input type="submit" value="Valider">
	</form>

    <?php
} else {
	?>
		<h1>Modifier les paramètres de la page</h1>
		<p class="error">Erreur dans l'URL</p>
<?php
}
?>

