<?php

if (isset($_POST['img_id']) && !empty($_POST['img_id'])) {
    $imgID = $_POST['img_id'];
    $imgWidth = isset($_POST['img_width']) ? $_POST['img_width'] : 600;
    if (isset($_POST['img_crop'])) {
        // Gérer le code du croping de l'image ici
        $imgCropped = 600;
    } else {
        $imgCropped = 600;
    }
    try {
        $dbh = new PDO('mysql:host=robinoelou.mysql.db;dbname=robinoelou', 'robinoelou', '87HsEKcf9LAHTfM');
        $r = 'UPDATE images SET max_width = ? WHERE id = ?';
        $stmt= $dbh->prepare($r);
        $stmt->execute([$imgCropped, $imgID]);
        $r = 'SELECT *  FROM images WHERE id = ?';
        $stmt= $dbh->prepare($r);
        $stmt->execute([$imgID]);
        $imgData = $stmt->fetchAll();
        if ($imgData) {
            // Tout va bien
            header('Content-Type: application/json');
            echo json_encode([
                "status" => 200,
                "message" => "Success",
                "img_id" => $imgData['id'],
                "url" => $imgData['url'],
                "max_width" => $imgData['max_width']
            ]);
        } else {
            // Pas d'image, WTF
            echo json_encode([
                "status" => 404,
                "message" => 'Image non retrouvée'
            ]);
        }
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => 500,
            "message" => "Update Error : " . $e
        ]);
    }

}
