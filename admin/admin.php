<?php

    //----------------------------------------//
    // Funkcja zwracajaca formularz logowania //
    //----------------------------------------//
    //
    // Funkcja generuje i zwraca tabele html - formularz logowania
    //
    function FormularzLogowania()
    {
        include('cfg.php');

        // Jesli uzytkowni nie jest zalogowany, zostaje wyswietlony mu formularz logowania
        if($_SESSION['loggedIn'] != 1) {

        $wynik = '
        <div>
            <h1 class="heading">Logowanie:</h1>
            <div>
                <form method="post" name="LoginForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
                    <table>
                        <tr><td class="log4_t"></td><td><input type="text" placeholder="Podaj login" name="login_email"/></td></tr>
                        <tr><td class="log4_t"></td><td><input type="password" placeholder="Podaj hasło" name="login_pass"/></td></tr>
                        <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="zaloguj" value="Zaloguj" /></td></tr>
                    </table>
                </form>
            </div>
        </div>
        ';

        return $wynik;
        }

        // Jesli uzytkowni jest zalogowany, zostaje wyswietlony mu panel uzytkownika (przycisk panelu administratora, przycisk wylogowania)
        if($_SESSION['loggedIn'] == 1) {
            $wynik = '
            <div>
                <h1 class="heading">Panel:</h1>
                <div>
                    <table>
                        <tr><td><button class="logout"><a href="?idp=999">Panel Administracyjny</a></button></td></tr>
                        <tr><td><button class="logout"><a href="./admin/logout.php">Wyloguj</a></button></td></tr>
                    </table>
                </div>
            </div>
            ';
            return $wynik;
        }
    }

    //--------------------------------------//
    // Funkcja wyswietlajaca liste podstron //
    //--------------------------------------//
    //
    // Funkcja generuje i wyswietla tabele html - liste wszystkich podstron
    // razem z przyciskami edycji i usuniecia podstrony
    //
    function listaPodstron() {

        include('cfg.php');
        $query = " SELECT * FROM page_list ";
        $result = mysqli_query($link, $query);
        
        while( $row = mysqli_fetch_array($result) ) {
            $id = $row['id'];
            $page_content = htmlspecialchars($row['page_content']);
            $page_title = $row['page_title'];

            $table =
            "
            <table class='cms-table'>
                <tr>
                    <td class='cms-td' style='width: 8%;'>
                        <span class='cms-span'>Id strony</span>
                    </td>
                    <td class='cms-td' style='width: 10%;'>
                        <span class='cms-span'>Tytuł</span>
                    </td>
                    <td class='cms-td'>
                        <span class='cms-span'>Zawartość (HTML)</span>
                    </td>
                </tr>
                <tr>
                    <td class='cms-td'>".$id."</td>
                    <td class='cms-td'>".$page_title."</td>
                    <td class='cms-td'>".$page_content."</td>        
                </tr>
            </table>        

            <div style='display: flex;'>
            <form method='post'>
                <input type='hidden' name='idPage' value='" . $id . "'/>
                <input type='hidden' name='titlePage' value='" . $page_title . "'/>
                <input type='hidden' name='contentPage' value='" . $page_content . "'/>
                <button class='cms-button-table' type='submit'>Edytuj podstronę</button>
            </form>

            <form method='post'>
                <input type='hidden' name='idPageToDelete' value='" . $id . "'/>
                <button class='cms-button-table' type='submit' name='delete' >Skasuj podstronę</button>
            </form>
            </div>
            ";

            echo $table;
        }
    }

    //------------------------------------------------------//
    // Funkcja zwracajaca formularz dodania nowej podstrony //
    //------------------------------------------------------//
    //
    // Funkcja generuje i zwraca tabele html - formularz dodania nowej podstrony
    //
    function dodajNowaPodstrone() {
        $insert_table = 
        "
        <div style='margin-top: 120px;'>
            <h2 class='cms-h2'>Dodaj nową podstronę:</h2>
            <form method='post'>
            <table class='cms-table'>
                <thead>
                    <th>
                        <span class='cms-editor'>Tytuł podstrony</span>
                    </th>
                    <th>
                        <span class='cms-editor'>Zawartość HTML</span>
                    </th>
                </thead>
                <tbody>
                    <tr class='cms-tr'>
                        <td style='width: 30%;'>
                            <input type='text' name='insertTitle'/>
                        </td>
                        <td style='height: 500px;'>
                            <textarea style='height: 99%; width: 99%; margin-bottom: 10px;' name='insertContent'></textarea>
                        </td>
                    </tr>       
                </tbody>
            </table>
            <div style='text-align: center;'>
                <button class='cms-button' type='submit'>Dodaj Podstronę</button>
            </div>
            </form>
        </div>
        ";
        return $insert_table;
    }

    //-----------------------------------------------//
    // Funkcja zwracajaca formularz edycji podstrony //
    //-----------------------------------------------//
    //
    // Funkcja generuje i zwraca tabele html - formularz edycji podstrony
    //
    function edytujPodstrone() {
        // Jesli nie wybrano strony do edycji, formularz nie pojawi sie
        if(empty($_POST['idPage'])) {
            return "";
        }

        $id = $_POST['idPage'];
        $title = $_POST['titlePage'];
        $content = htmlspecialchars($_POST['contentPage']);

        $update_table = 
        "
        <div>
            <h2 class='cms-h2'>Edycja podstrony ''".$title."''   (id = ".$id.")</h2>
            <form method='post'>
            <table class='cms-table'>
                <thead>
                    <th>
                        <span class='cms-editor'>Id podstrony</span>
                    </th>
                    <th>
                        <span class='cms-editor'>Tytuł podstrony</span>
                    </th>
                    <th>
                        <span class='cms-editor'>Zawartość HTML</span>
                    </th>
                </thead>
                <tbody>
                    <tr class='cms-tr'>
                        <td style='width: 7%;'>
                            <input style='height: 100%; width: 95%;' type='text' readonly value='".$id."' name='updateId'/>
                        </td>
                        <td style='width: 30%;'>
                            <input type='text' value='".$title." 'name='updateTitle'/>
                        </td>
                        <td style='height: 500px;'>
                            <textarea style='height: 99%; width: 99%; margin-bottom: 10px;' name='updateContent'>".$content." </textarea>
                        </td>
                    </tr>       
                </tbody>
            </table>
            <div style='text-align: center;'>
                <button class='cms-button' type='submit'>Zapisz Zmiany</button>
            </div>
            </form>
        </div>
        ";
        return $update_table;
    }

    //---------------------------------------------//
    // Funkcja wysylajaca zapytanie do bazy danych //
    //---------------------------------------------//
    //
    // Funkcja na potrzeby funckji " dodajNowaPodstrone() "
    // Funkcja tworzy i wysyla zapytanie o stworzenie nowego rekordu w tabeli page_list
    // na podstawie danych wporwadzonych do formularza dodania nowej podstrony
    //
    function queryInsert() {
        include('cfg.php');

        $title = $_POST['insertTitle'];
        $content = $_POST['insertContent'];

        $query = "INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`) VALUES (NULL, '".$title."', '".htmlspecialchars($content)."', '1')";
        $result = mysqli_query($link, $query);

        return $result;
    }

    //---------------------------------------------//
    // Funkcja wysylajaca zapytanie do bazy danych //
    //---------------------------------------------//
    //
    // Funkcja na potrzeby funckji " edytujPodstrone() "
    // Funkcja tworzy i wysyla zapytanie o edycje rekordu w tabeli page_list
    // na podstawie danych wporwadzonych do formularza edycji podstrony
    //
    function queryUpdate() {
        include('cfg.php');

        $id = $_POST['updateId'];
        $title = $_POST['updateTitle'];
        $content = $_POST['updateContent'];

        $query = "UPDATE `page_list` SET `page_title`='".$title."' , `page_content`=' ".htmlspecialchars($content)." ' WHERE `id`=".$id." LIMIT 1";
        $result = mysqli_query($link, $query);

        return $result;
    }

    //---------------------------------------------//
    // Funkcja wysylajaca zapytanie do bazy danych //
    //---------------------------------------------//
    //
    // Funkcja na potrzeby funckji " listaPodstron() "
    // Funkcja tworzy i wysyla zapytanie o usuniecie rekordu z tabeli page_list
    // na podstawie wybranej do usuniecia strony z listy wszystkich podstron
    //
    function queryDelete() {
        include('cfg.php');

        $id = $_POST['idPageToDelete'];

        $query = "DELETE FROM `page_list` WHERE id=$id LIMIT 1";
        $result = mysqli_query($link, $query);
        
        return $result;
    }

    //-------------------------------------------//
    // Funkcja obslugujaca panel administracyjny //
    //-------------------------------------------//
    //
    // Funkcja wspolpracuje z powyzszymi funkcjami cms'owymi
    // Funkcja wyswietla panel administracyjny (liste podstron, edycje podstrony, dodanie nowej podstrony)
    //
    function panelAdministracyjny(){
        if($_SESSION['loggedIn'] == 1) {

            echo edytujPodstrone();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if(isset($_POST['updateId'])) {
                    $result = queryUpdate();
                    if ($result == 1){
                        echo("Sukces");
                    }
                    else {
                        echo("Niepowodzenie");
                    }
                    exit;
                }

                if(isset($_POST['insertTitle'])) {
                    $result = queryInsert();
                    if ($result == 1){
                        echo("Sukces");
                    }
                    else {
                        echo("Niepowodzenie");
                    }
                    exit;
                }

                if(isset($_POST['idPageToDelete'])) {
                    $result = queryDelete();
                    if ($result == 1){
                        echo("Sukces");
                    }
                    else {
                        echo("Niepowodzenie");
                    }
                    exit;
                }
            }

            listaPodstron();
            echo dodajNowaPodstrone();

        }
        else {
            echo "Dostęp tylko dla administratora";
        }
    }

?>
