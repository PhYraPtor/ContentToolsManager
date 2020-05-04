<?php
$dbh = new PDO('mysql:host=robinoelou.mysql.db;dbname=robinoelou', 'robinoelou', '87HsEKcf9LAHTfM');
$r = $dbh->prepare('SELECT * FROM pages');
$r->execute();
$pages = $r->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administration des pages</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Template</th>
        <th>Créé</th>
        <th>Modifié</th>
        <th>Éditer</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($pages as $page) {
        echo '<tr>';
            echo'<td>'.$page['id'].'</td>';
            echo'<td>'.$page['title'].'</td>';
            echo'<td>'.$page['template'].'</td>';
            echo'<td>'.$page['created'].'</td>';
            echo'<td>'.$page['modified'].'</td>';
            echo'<td><a href="edit-page-settings.php?id='.$page['id'].'&title='.$page['title']. '&template=' . $page['template'] . '">Modifier</a></td>';
        echo '</tr>';
    }
    ?>
    </tbody>
</table>

</body>
</html>
