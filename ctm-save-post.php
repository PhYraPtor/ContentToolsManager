<?php

if (isset($_POST['data']) && !empty($_POST['data'])) {
    $data = json_decode($_POST['data']);
    $page = $_POST['page'];
    if ($page) {
        $dbh = new PDO('mysql:host=robinoelou.mysql.db;dbname=robinoelou', 'robinoelou', '87HsEKcf9LAHTfM');
        $r = $dbh->prepare('SELECT * FROM pages WHERE title = ?');
        $r->execute(array($page));
        $pageInDb = $r->fetchAll();

        if ($pageInDb) {
            // La page existe, on la met à jour
            $debug = $pageInDb[0];
            $debug = $debug['id'];
            // $r = $dbh->prepare('SELECT * FROM fields_dev WHERE page = ?');
            // $r->execute([$pageInDb['id']]);
            foreach ($data as $field) {
                $f = json_decode($field);
                $r = $dbh->prepare('SELECT * FROM fields_dev WHERE page = ? AND field = ?');
                $r->execute([$pageInDb[0]['id'], $f->nomDuChamp]);

                $fieldExists = $r->fetchAll();
                $debug = $fieldExists;
                if ($fieldExists && !empty($fieldExists)) {
                    $fieldExists = $fieldExists[0];
                    // Le champ existe, on l'update
                    $u = $dbh->prepare('UPDATE fields_dev SET content = ?, updated = NOW() WHERE id = ?');
                    $u->execute([$f->valeur, $fieldExists['id']]);
                } else {
                    // Le champ n'existe pas, on l'insère
                    $i = $dbh->prepare('INSERT INTO fields_dev(page, field, content, created, modified) VALUES (?,?,?,NOW(),NOW())');
                    $i->execute([$pageInDb[0]['id'], $f->nomDuChamp, $f->valeur]);
                }
            }

        } else {
            // La page n'existe pas déjà, on la crée
            $r = $dbh->prepare('INSERT INTO pages(title, created, modified) VALUES (?, NOW(), NOW())');
            $r->execute([$page]);
            $id = $dbh->lastInsertId();
            $debug = array([]);
            foreach ($data as $field) {
                $f = json_decode($field);
                $r = $dbh->prepare('INSERT INTO fields_dev(page, field, content, created, updated) VALUES (?, ?, ?, NOW(), NOW())');
                $r->execute([$id, $f->nomDuChamp, $f->valeur]);
                array_push($debug, $data);
            }
        }

    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => 500,
            "message" => "No page mentionned"
        ]);
    }
    header('Content-Type: application/json');
    echo json_encode([
        "status" => 200,
        "message" => $data,
        "debug" => $debug
    ]);
}
else {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => 500,
        "message" => "No data"
    ]);
}
