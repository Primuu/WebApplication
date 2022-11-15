<?php
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    (empty($_GET['idp'])) ? $pageName = 'main' : $pageName = $_GET['idp'];
    $file = './html/'.$pageName.'.html';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; chasrset=UTF-8" />
        <meta http-equiv="Content-language" content="pl" />
        <meta name="Author" content="Adam Trentowski" />
        <link href="./css/index-.css" rel="stylesheet" />
        <link rel="icon" href="./img/rocket.png">
    </head>
    <header>
        <ul class="topnav">
            <li class="navbar-left">
                <a href="?idp=main">Strona Główna</a>
            </li>
            <li class="navbar-left">
                <a href="?idp=news">News</a>
            </li>
            <li class="navbar-left">
                <a href="?idp=facts">Ciekawostki</a>
            </li>
            <li class="navbar-right">
                <a href="mailto:162602@student.uwm.edu.pl">Kontakt</a>
            </li>
        </ul> 
    </header>
    <?php
        if (file_exists($file))
        {
            include($file);
        }
        else 
        {
            throw new ErrorException("this site does not exist. ");
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
