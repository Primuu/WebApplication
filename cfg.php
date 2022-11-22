<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'qwerty0987654321';
    $baza = 'moja_strona';

    $link = new mysqli($dbhost, $dbuser, $dbpass);

    if (!$link) echo '<b>przerwane połączenie </b>';
    if(!mysqli_select_db($link, $baza)) echo 'nie wybrano bazy';
?>
