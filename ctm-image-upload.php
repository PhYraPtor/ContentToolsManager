<?php
// (1) INIT
// @TODO - Handle the $_POST vars if you have any
error_reporting(E_ALL & ~E_NOTICE);

// (2) FILE CHECK
// HTML file type restriction can still miss at times
// E.g. Restrict upload size to prevent resource hogging.
if (isset($_FILES['image']['tmp_name']) && isset($_POST['page'])) {
    $allowed = ["bmp", "gif", "jpg", "jpeg", "png", "webp"];
    $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $extension = pathinfo($_FILES["image"]["name"]);
    $extension = $extension['extension'];
    $extension = strtolower($extension);
    if (in_array($ext, $allowed)) {
        try {
            // $source = $_FILES["image"]["tmp_name"];
            // $destination = $_SERVER['REQUEST_URI'] . '/' . $_FILES["image"]["name"];
            // $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/';
            // move_uploaded_file($source, $destination);

            $dbh = new PDO('mysql:host=robinoelou.mysql.db;dbname=robinoelou', 'robinoelou', '87HsEKcf9LAHTfM');
            $r = 'INSERT INTO images (original_name) VALUES (?)';
            $stmt= $dbh->prepare($r);
            $stmt->execute([$_FILES["image"]["name"]]);
            $imgId = $dbh->lastInsertId();

            $source = $_FILES["image"]["tmp_name"];
            // $destination = $_SERVER['REQUEST_URI'] . '/' . $imgId;
            $destination = 'images/' . $_POST['page'] . '/' . $imgId . '.' . $extension;
            if (!file_exists('./images/' . $_POST['page'])) {
                if (!mkdir('./images/' . $_POST['page'], 0777, true)) {
                    echo json_encode([
                        "status" => 500,
                        "message" => "Impossible de créer le dossier"
                    ]);
                    die();
                }
            }

            // @todo : faire le nom du dossier

            move_uploaded_file($source, $destination);
            $size = getimagesize('./'.$destination);
            $dbSize = json_encode($size);

            $r = 'UPDATE images SET url = ?, size = ? WHERE id = ?';
            $stmt = $dbh->prepare($r);
            $stmt->execute([$destination, $dbSize, $imgId]);
            $link = 'http://ctm.robinoger.com/';

            // Réponse

            header('Content-Type: application/json');
            echo json_encode([
                "status" => 200,
                "message" => "File Uploaded",
                "url" => $link . $destination,
                "size" => $size,
                "id" => $imgId
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
