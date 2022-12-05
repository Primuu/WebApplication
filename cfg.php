<?php

    session_start();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if(!isset($_SESSION['loggedIn']))
    {
        $_SESSION['loggedIn'] = 0;
    }

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'root';
    $baza = 'moja_strona';

    $login = 'admin';
    $pass = 'admin';

    $username = $_POST['login_email'];
    $password = $_POST['login_pass'];

    $link = new mysqli($dbhost, $dbuser, $dbpass);

    if (!$link) echo '<b>przerwane połączenie </b>';
    if(!mysqli_select_db($link, $baza)) echo 'nie wybrano bazy';

    
      if ( (empty($password) || empty($username) ) && $_SESSION['loggedIn'] != 1) {
        $_SESSION['loggedIn'] = 0;
      }
      if ($username == $login && $password == $pass) {
        $_SESSION['loggedIn'] = 1;
      }

?>
