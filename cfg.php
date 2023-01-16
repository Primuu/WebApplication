<?php

    session_start();

    // Wywietlenie bledow oraz ostrzezen
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Warunek startowy "zabezpieczajacy" logowanie 
    if(!isset($_SESSION['loggedIn']))
    {
        $_SESSION['loggedIn'] = 0;
    }

    // Dane dla bazy danych
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'root';
    $baza = 'moja_strona';

    // Dane do zalogowania
    $login = 'admin';
    $pass = 'admin';

    // Emial do kontaktu (tu sa kierowane maile z formularza kontaktowego)
    $admin_mail = "testowy.mail.www@test.com";

    // Dane pobierane podczas proby zalogowania
    $username = $_POST['login_login'];
    $password = $_POST['login_pass'];

    // Polaczenie z baza danych
    $link = new mysqli($dbhost, $dbuser, $dbpass);

    if (!$link) echo '<b>przerwane połączenie </b>';
    if(!mysqli_select_db($link, $baza)) echo 'nie wybrano bazy';


    // Warunki logowania
    if ( (empty($password) || empty($username) ) && $_SESSION['loggedIn'] != 1) {
      $_SESSION['loggedIn'] = 0;
    }
    
    if ($username == $login && $password == $pass) {
      $_SESSION['loggedIn'] = 1;
    }

?>
