<?php

if (isset($_POST['img_id']) && !empty($_POST['img_id'])) {
    // CROP
    if (isset($_POST['img_crop'])) {
        $dbh = new PDO('mysql:host=robinoelou.mysql.db;dbname=robinoelou', 'robinoelou', '87HsEKcf9LAHTfM');
        $r = $dbh->prepare('SELECT * FROM images WHERE id = ?');
        $r->execute(array($_POST['img_id']));
        $imageInDb = $r->fetchAll();

        if ($imageInDb) {
            list($width, $height, $img_type) = getimagesize('http://ctm.robinoger.com/'.$imageInDb[0]['url']);
            switch($img_type) {
                case 1:
                    $image = imagecreatefromgif('http://ctm.robinoger.com/'.$imageInDb[0]['url']);
                    break;
                case 2:
                    $image = imagecreatefromjpeg('http://ctm.robinoger.com/'.$imageInDb[0]['url']);
                    break;
                case 3:
                    $image = imagecreatefrompng('http://ctm.robinoger.com/'.$imageInDb[0]['url']);
                    break;
                default:
                    die();
                    break;
            }
            // $image = imagecreatefromjpeg('http://ctm.robinoger.com/'.$imageInDb[0]['url']);
            $crop = $_POST['img_crop'];
            $crop = explode(',', $crop);
            $new_y = $height * $crop[0];
            $new_x = $width * $crop[1];
            $new_height = ($height * $crop[2]) - $new_y;
            $new_width = ($width * $crop[3]) - $new_x;
            $cropped_img = imagecrop($image, ['x' => $new_x, 'y' => $new_y, 'width' => $new_width, 'height' => $new_height]);

            if($cropped_img !== FALSE) {
                switch($img_type) {
                    case 1:
                        $image = imagegif($cropped_img, 'http://ctm.robinoger.com/'.$imageInDb[0]['id'].'-cropped.gif');
                        $url = 'http://ctm.robinoger.com/'.$imageInDb[0]['id'].'-cropped.gif';
                        break;
                    case 2:
                        $image = imagejpeg($cropped_img, 'http://ctm.robinoger.com/'.$imageInDb[0]['id'].'-cropped.jpg');
                        $url = 'http://ctm.robinoger.com/'.$imageInDb[0]['id'].'-cropped.jpg';
                        break;
                    case 3:
                        $image = imagepng($cropped_img, 'http://ctm.robinoger.com/'.$imageInDb[0]['id'].'-cropped.png');
                        $url = 'http://ctm.robinoger.com/'.$imageInDb[0]['id'].'-cropped.png';
                        break;
                    default:
                        die();
                        break;
                }
                if ($image) {
                    try {
                        $r = $dbh->prepare('INSERT INTO images(url, size, alt, max_width, original_name, crop_id) VALUES (?,?,?,?,?,?)');
                        $r->execute([$url, $imageInDb[0]['size'], $_POST['img_alt'], 0, $imageInDb[0]['original_name'], $imageInDb[0]['id']]);
                    }
                    catch (PDOException $e) {
                        echo json_encode([
                            "status" => 505,
                            "message" => "Erreur dans l'inscription dans la base de données",
                        ]);
                        die();
                    }
                }
                echo json_encode([
                    "status" => 200,
                    "message" => "Crop",
                    "valeur" => $_POST['img_crop'],
                    "image" => $imageInDb,
                    "size" => $imageInDb[0]['size'],
                    "url" => 'http://ctm.robinoger.com/'.$imageInDb[0]['url'],
                    "dansleif" => "OUI"
                ]);
            } else {
                echo json_encode([
                    "status" => 500,
                    "message" => "Crop failed",
                    "valeur" => $_POST['img_crop'],
                    "image" => $imageInDb,
                    "size" => $imageInDb[0]['size'],
                    "url" => 'http://ctm.robinoger.com/'.$imageInDb[0]['url'],
                    "dansleif" => "NON"
                ]);
            }
            imagedestroy($cropped_img);
            imagedestroy($image);

            // Si ça marche on renvoie l'url, getimagesize(), alt =
        } else {
            echo json_encode([
                "status" => 404,
                "message" => "Image not found in DB"
            ]);
        }
    }
}
