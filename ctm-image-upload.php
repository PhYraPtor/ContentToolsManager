<?php
// (1) INIT
// @TODO - Handle the $_POST vars if you have any
error_reporting(E_ALL & ~E_NOTICE);

// (2) FILE CHECK
// HTML file type restriction can still miss at times
// @TODO - Add more of your own file checks if you want.
// E.g. Restrict upload size to prevent resource hogging.
if (isset($_FILES['image']['tmp_name']) && isset($_POST['page'])) {
    $allowed = ["bmp", "gif", "jpg", "jpeg", "png", "webp"];
    $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    if (in_array($ext, $allowed)) {
        try {
            // $source = $_FILES["image"]["tmp_name"];
            // $destination = $_SERVER['REQUEST_URI'] . '/' . $_FILES["image"]["name"];
            // $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/';
            // move_uploaded_file($source, $destination);

            $dbh = new PDO('mysql:host=robinoelou.mysql.db;dbname=robinoelou', 'robinoelou', '87HsEKcf9LAHTfM');
            $r = 'INSERT INTO images (size) VALUES (?)';
            $stmt= $dbh->prepare($r);
            $stmt->execute([$_POST['size']]);
            $imgId = $dbh->lastInsertId();

            $source = $_FILES["image"]["tmp_name"];
            $destination = $_SERVER['REQUEST_URI'] . '/' . $imgId;

            // @todo : faire le nom du dossier

            move_uploaded_file($source, $destination);

            $r = 'UPDATE images SET (url = ?) WHERE id = ?';
            $stmt = $dbh->prepare($r);
            $stmt->execute([$destination, $imgId]);

            // Réponse

            header('Content-Type: application/json');
            echo json_encode([
                "status" => 200,
                "message" => "File Uploaded",
                "url" => $link . $destination,
                "size" => getimagesize($_FILES["image"]["name"])
            ]);
        }
        catch (PDOException $e) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => 500,
                "message" => "Impossible de se connecter à la db : ".$e
            ]);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => 403,
            "message" => "Image Format Not Supported"
        ]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => 404,
        "message" => "No Image Provided"
    ]);
}
/*
// (3) MOVE UPLOADED FILE OUT OF TEMP FOLDER
// @TODO - change the destination folder wherever you want
if ($pass) {
    $source = $_FILES["image"]["tmp_name"];
    $destination = $_FILES["image"]["name"];
    move_uploaded_file($source, $destination);
}

// (4) SERVER RESPONSE
header('Content-Type: application/json');
$pass ? $status = 200 : $status = 404;
echo json_encode([
    "status" => 200,
    "message" => $pass ? "Upload OK" : $error,
    "url" => $_FILES["image"]["name"],
    "size" => getimagesize($_FILES["image"]["name"])
]);
*/
