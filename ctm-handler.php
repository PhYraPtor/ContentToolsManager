<?php
header('Content-type: application/json');

if(!empty($_REQUEST['s'])){
    echo $_REQUEST['s'];
} else {
    echo 'no s';
}
