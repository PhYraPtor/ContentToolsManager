<?php
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
    if(is_string($page)) {
        $dbh = new PDO('mysql:host=robinoelou.mysql.db;dbname=robinoelou', 'robinoelou', '87HsEKcf9LAHTfM');
        $r = $dbh->prepare('SELECT id FROM pages WHERE title = ? LIMIT 1');
        $r->execute([$page]);
        $pageId = $r->fetchAll();
        if ($pageId && !empty($pageId)) {
            $pageId = $pageId[0]['id'];
            if (isset($_GET['preview']) && $_GET['preview'] == 'true') {
                // Vue de la page en dev
            }
            $r = $dbh->prepare('SELECT * FROM fields_dev WHERE page = ? ORDER BY updated DESC');
            $r->execute([$pageId]);
            $fieldsResults = $r->fetchAll();
            $fields = array();
            foreach ($fieldsResults as $field) {
                $fields[$field['field']] = $field['content'];
            }
            print_r($fields);
            include('./templates/home.php');

        } else {
            echo 'La page n\'existe pas.';
        }
    } else {
        die();
    }
} else {
    die();
}
?>
