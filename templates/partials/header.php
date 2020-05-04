<?php

function editable()
{
    if (isset($GLOBALS['dev']) && $GLOBALS['dev'] == true) {
        echo "data-editable";
    }
}

?>
<!DOCTYPE HTML>
<!--
Paradigm Shift by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>Antoine Bonin | Portfolio</title>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="description"
          content="Etudiant à Digital Campus Lyon,je suis aussi amateur de webdesign, développement et photographie !">
    <meta name="author" content="Antoine Bonin">
    <link rel="stylesheet" href="../../assets/css/main.css"/>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/content-tools/content-tools.css">
    <!--link rel="stylesheet" type="text/css" href="../style.css"-->
    <script src="https://kit.fontawesome.com/5a25629c5a.js"></script>
</head>
