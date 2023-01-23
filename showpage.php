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
        // Przypisanie id strony, ktora ma zostac wyswietlona
        $id_clear = htmlspecialchars($id);

        // Stworzenie i wyslanie zapytania o szczegoly strony do wyswietlenia
        $query = "SELECT * FROM page_list WHERE id=$id_clear LIMIT 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        // Jesli strona istnieje, zawartosc jest dekodowana
        if(empty($row['id']))
        {
            $web = '[nie_znaleziono_strony]';
        }
        else
        {
            $web = htmlspecialchars_decode($row['page_content']);
        }

        // Zawartosc strony jest wyswietlana
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
        // Przypisanie id strony, ktorej tytul ma zostac wyswietlony
        $id_clear = htmlspecialchars($id);

        // Stworzenie i wyslanie zapytania o szczegoly strony do wyswietlenia
        $query = "SELECT * FROM page_list WHERE id=$id_clear LIMIT 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        // Jesli strona istnieje, zawartosc jest przypisywana
        if(empty($row['id']))
        {
            $title = '[nie_znaleziono_strony]';
        }
        else
        {
            $title = $row['page_title'];
        }

        // Tytul jest zwracany
        return $title;
    }
    
?>