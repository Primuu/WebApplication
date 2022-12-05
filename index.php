<?php
    session_start();
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

    include('cfg.php');
    include('showpage.php');
    include('./admin/admin.php');

    (empty($_GET['idp'])) ? $pageId = 1 : $pageId = $_GET['idp'];
    
    ($_SESSION['loggedIn'] == 0 && $pageId == 999) ? $pageId = 1 : $pageId;

    $title = PokazTytul($link, $pageId);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php
            echo("$title");
            ?>
        </title>
        <meta http-equiv="Content-type" content="text/html; chasrset=UTF-8" />
        <meta http-equiv="Content-language" content="pl" />
        <meta name="Author" content="Adam Trentowski" />
        <link href="./css/general.css" rel="stylesheet" />
        <link rel="icon" href="./img/rocket.png">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="./js/timedate.js" type="text/javascript"></script>
        <script src="./js/stars.js" type="text/javascript"></script>
    </head>
    <header>
        <ul class="topnav">
            <li class="navbar-left">
                <a href="?idp=1">Strona Główna</a>
            </li>
            <li class="navbar-left">
                <a href="?idp=2">News</a>
            </li>
            <li class="navbar-left">
                <a href="?idp=3">Ciekawostki</a>
            </li>
            <li class="navbar-right">
                <a href="mailto:162602@student.uwm.edu.pl">Kontakt</a>
            </li>
        </ul> 
    </header>
    <?php

        PokazPodstrone($link, $pageId);
        
        if ($pageId == 1) 
        {
            echo(FormularzLogowania());
        }
        if ($pageId == 999)
        {
            panelAdministracyjny();
        }
        
    ?>
    <div class="identifier">
            <?php
                $nr_indeksu = '162602';
                $nrGrupy = '2';
                echo 'Autor: Adam Trentowski - '.$nr_indeksu.', grupa '.$nrGrupy.' <br /><br />';
            ?>
    </div>
</html>
