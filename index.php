<?php

    //Start sesji
    session_start();

    // Wywietlenie bledow oraz ostrzezen
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

    include('cfg.php');
    include('showpage.php');
    include('./admin/admin.php');
    include('contact.php');
    include('./shop/categories.php');
    include('./shop/shop-panel.php');
    include('./shop/products.php');
    include('./shop/shop.php');

    // Domyslne przyjecie id podstorony jako idp=1
    (empty($_GET['idp'])) ? $pageId = 1 : $pageId = $_GET['idp'];
    
    // Jesli uzytkownik nie jest zalogowany, panel administracyjny/panel sklepu nie pokaze mu sie
    ($_SESSION['loggedIn'] == 0 && $pageId == 999 ||
     $_SESSION['loggedIn'] == 0 && $pageId == 1000||
     $_SESSION['loggedIn'] == 0 && $pageId == 1001||
     $_SESSION['loggedIn'] == 0 && $pageId == 1002) ? $pageId = 1 : $pageId;

    $title = PokazTytul($link, $pageId);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php
            // Wyswietlenie tytulu w karcie przegladarki
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
    <!-- Pasek nawigacyjny -->
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
            <li class="navbar-left">
                <a href="?idp=1003">Sklep</a>
            </li>
            <li class="navbar-right">
                <a href="?idp=998">Kontakt</a>
            </li>
        </ul> 
    </header>

    <?php

        // Wyswietlenie zawrtosci podstrony 
        PokazPodstrone($link, $pageId);
        
        // Wyswietlenie formularza logowania na stronie glownej
        if ($pageId == 1) 
        {
            echo(FormularzLogowania());
        }

        // Wyswietlenie panelu administracyjnego
        if ($pageId == 999)
        {
            panelAdministracyjny();
        }

        // Wyswietlenie panelu kontaktowego      
        if ($pageId == 998)
        {
            panelKontaktowy();
        }

        // Wyswietlenie panelu zarządzania sklepem
        if ($pageId == 1000)
        {
            panelSklepu();
        }

        // Wyswietlenie panelu zarządzania kategoriami
        if ($pageId == 1001)
        {
            panelKategorii();
        }

        // Wyswietlenie panelu zarządzania produktami
        if ($pageId == 1002)
        {
            panelProduktow();
        }

        // Wyswietlenie sklepu
        if ($pageId == 1003)
        {
            shop();
        }
        
    ?>
    
    <!-- Identyfikator -->
    <div class="identifier">
            <?php
                $nr_indeksu = '162602';
                $nrGrupy = '2';
                echo 'Autor: Adam Trentowski - '.$nr_indeksu.', grupa '.$nrGrupy.' <br /><br />';
            ?>
    </div>
</html>
