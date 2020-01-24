<?php
error_reporting(E_ALL & ~E_NOTICE);

if(isset($_POST)){
    try {
        $dbh = new PDO('mysql:host=robinoelou.mysql.db;dbname=robinoelou', 'robinoelou', '87HsEKcf9LAHTfM');
        $r = 'INSERT INTO images (url, size, crop) VALUES (?,?,?)';
        $stmt= $dbh->prepare($r);
        $stmt->execute([$_POST['url'], $_POST['size'], $_POST['crop']]);
    }
    catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => 500,
            "message" => "Impossible de se connecter à la db : ".$e
        ]);
    }
    header('Content-Type: application/json');
    echo json_encode([
        "status" => 200,
        "message" => "File Uploaded",
        "post" => $_POST,
        "size" => getimagesize($_POST['url'])
    ]);
} else {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => 404,
        "message" => "No Files Provided"
    ]);
}
