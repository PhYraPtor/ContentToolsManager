<?php
// Ecrire ici les identifiants de connexion à la base de données

$dbhost = 'robinoelou.mysql.db';
$dbname = 'robinoelou';
$dbpassword = '87HsEKcf9LAHTfM';
$dbusername = 'robinoelou';

$dbh = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.'', $dbusername, $dbpassword);
