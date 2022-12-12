<?php

    //----------------------------------------//
    // Funkcja pokazujaca zawartosc podstrony //
    //----------------------------------------//
    //
    // Funkcja w argumencie przyjmuje id podstrony, ktora ma wyswietlic,
    // nastepnie pobiera dane z bazy danych i je wyswietla
    //
    function PokazPodstrone(mysqli $link, $id)
    {
        $id_clear = htmlspecialchars($id);

        $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        if(empty($row['id']))
        {
            $web = '[nie_znaleziono_strony]';
        }
        else
        {
            $web = $row['page_content'];
        }

        echo $web;
    }

    //------------------------------------//
    // Funkcja pokazujaca tytul podstrony //
    //------------------------------------//
    //
    // Funkcja w argumencie przyjmuje id podstrony, ktorej tytul ma wyswietlic,
    // nastepnie pobiera dane z bazy danych i je zwraca
    //
    function PokazTytul(mysqli $link, $id)
    {
        $id_clear = htmlspecialchars($id);

        $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        if(empty($row['id']))
        {
            $title = '[nie_znaleziono_strony]';
        }
        else
        {
            $title = $row['page_title'];
        }

        return $title;
    }
    
?>