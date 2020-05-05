<?php
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
    if(is_string($page)) {
        $dbh = new PDO('mysql:host=robinoelou.mysql.db;dbname=robinoelou', 'robinoelou', '87HsEKcf9LAHTfM');
        $r = $dbh->prepare('SELECT id, template, pretty_title FROM pages WHERE title = ? LIMIT 1');
        $r->execute([$page]);
        $res = $r->fetchAll();
        if ($res && !empty($res)) {
            $page = array();
            $page['id'] = $res[0]['id'];
            $page['template'] = $res[0]['template'];
            $GLOBALS['dev'] = false;
            if (isset($_GET['preview']) && $_GET['preview'] == 'true') {
                $GLOBALS['dev'] = true;
            }
            $r = $dbh->prepare('SELECT * FROM fields_dev WHERE page = ? ORDER BY updated DESC');
            $r->execute([$page['id']]);
            $fieldsResults = $r->fetchAll();
            $fields = array();
            foreach ($fieldsResults as $field) {
                $fields[$field['field']] = $field['content'];
            }
            include('./templates/partials/header.php');
            include('./templates/views/'.$page['template']);
            include('./templates/partials/footer.php');

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
