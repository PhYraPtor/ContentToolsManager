<?php
$dbh = new PDO('mysql:host=robinoelou.mysql.db;dbname=robinoelou', 'robinoelou', '87HsEKcf9LAHTfM');
$r = $dbh->prepare('SELECT * FROM pages');
$r->execute();
$res = $r->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administration des pages</title>
</head>
<body>
<?php
    print_r($res)
?>
</body>
</html>
