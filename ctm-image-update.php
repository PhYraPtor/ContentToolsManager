<?php

if (isset($_POST['img_id']) && !empty($_POST['img_id'])) {
    // CROP
    if (isset($_POST['img_crop'])) {
        echo json_encode([
            "status" => 200,
            "message" => "Crop",
            "valeur" => $_POST['img_crop']
        ]);
    }
}

function convertCropCoord ($coord, $size) {
    return [$coord[0], $coord[1], $coord[2] * $size[0], $coord[3] * $size[1]];
}
