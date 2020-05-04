<?php
session_start();
if (isset($_POST['login']) && !empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    // $password = password_hash($password, PASSWORD_DEFAULT);
    require('../db-config.php');
    $r = $dbh->prepare('SELECT id, password, username, mail, role FROM users WHERE( username = ? OR mail = ?)');
    $r->execute([$login, $login]);
    $creds = $r->fetchAll();
    if (sizeof($creds) > 0) {
        if (password_verify($password, $creds[0]['password'])) {
            // Utilisateur authentifié
            $_SESSION['userid'] = $creds[0]['password'];
            $_SESSION['mail'] = $creds[0]['mail'];
            $_SESSION['username'] = $creds[0]['username'];
            $_SESSION['role'] = $creds[0]['role'];
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = 'admin.php';
            header('Location: http://'.$host.$uri.'/'.$extra);
            exit();
        } else {
            // Mauvais mot de passe
            echo 'error !';
        }
    } else {
        // Utilisateur inconnu
        echo 'creds error';
    }
} else {
    // Pas de $_POST
    die();
}
