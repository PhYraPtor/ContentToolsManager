<?php
session_start();

if (isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
    $user_mail = $_SESSION['mail'];
    $user_name = $_SESSION['username'];
    $user_role = $_SESSION['role'];

    include('./templates/admin-header.php');
    include('./templates/admin-main.php');
    include('./templates/admin-footer.php');

} else {
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'login.php';
    session_destroy();
    header('Location: http://' . $host . $uri . '/' . $extra);
    exit();
}


