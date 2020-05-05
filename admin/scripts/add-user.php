<?php
if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['mail']) && !empty($_POST['mail'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $mail = $_POST['mail'];
    include_once('../db-config.php');
    $r = $dbh->prepare('SELECT id FROM users WHERE username = ? OR mail = ?');
    $r->execute([$login, $mail]);
    $userExists = $r->fetchAll();
    if (!$userExists) {
        $r = $dbh->prepare('INSERT INTO users(username, password, mail, created) VALUES (?, ?, ?, NOW())');
        $r->execute([$login, $password, $mail]);
    } else {
        echo 'user already exists';
    }
} else {
    echo 'no creds';
}
