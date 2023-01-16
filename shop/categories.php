<?php

    //---------------------------------------//
    // Funkcja wyswietlajaca liste kategorii //
    //---------------------------------------//
    //
    // Funkcja generuje liste wszystkich kategorii wraz z podkategoriami,
    // służy tylko do podglądu
    //
    function drzewkoKategorii() {
        include('cfg.php');

        $query = "SELECT `id`, `nazwa` FROM `kategorie` where `matka` = 0";
        $main_categories = mysqli_query($link, $query);

        $tree='
        <div style="margin: auto; text-align: center; width: 25%;">
            <h2 class="cms-h2">Pogląd drzewka kategorii:</h2> 
        ';

        while($row = mysqli_fetch_array($main_categories)) {
            $id = $row['id'];
            $motherCategoryName = $row['nazwa'];
                    $tree = $tree .'
                    <h3 style="margin-top: 10px; text-align: justify; font-size: 25px;">-'.$motherCategoryName.'</h3>
                    ';
            
            $query = "SELECT `nazwa` FROM `kategorie` where `matka` = '$id'";
            $sub_category = mysqli_query($link, $query);
            while($row = mysqli_fetch_array($sub_category)) {
                $sub_name = $row['nazwa'];
                $tree = $tree .'
                <h3 style="margin: auto; text-align: justify; font-size: 20px;">- - - '.$sub_name.'</h3>
                ';
            }

        }
        $tree .= '</div>';

        echo $tree;
    }


    //--------------------------------------------------------//
    // Funkcja wyswietlajaca liste do zarządzania kategoriami //
    //--------------------------------------------------------//
    //
    // Funkcja generuje i wyswietla tabele html - liste wszystkich kategorii
    // razem z przyciskami edycji i usuniecia kategorii
    //
    function listaKategorii() {

        include('cfg.php');
        $query = " SELECT * FROM kategorie ";
        $result = mysqli_query($link, $query);
        
        while( $row = mysqli_fetch_array($result) ) {
            $id = $row['id'];
            $mother = $row['matka'];
            $category_name = htmlspecialchars($row['nazwa']);

            $table =
            "
            <table class='cms-table'>
                <tr>
                    <td class='cms-td' style='width: 8%;'>
                        <span class='cms-span'>
                        Id kategorii
                        </span>
                    </td>
                    <td class='cms-td' style='width: 10%;'>
                        <span class='cms-span'>
                        Id matki
                        </span>
                    </td>
                    <td class='cms-td'>
                        <span class='cms-span'>
                        Nazwa kategorii
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class='shop-td'>".$id."</td>
                    <td class='shop-td'>".$mother."</td>
                    <td class='shop-td'>".$category_name."</td>        
                </tr>
            </table>        

            <div style='display: flex;'>
            <form method='post'>
                <input type='hidden' name='idCategory' value='".$id."'/>
                <input type='hidden' name='idMother' value='".$mother."'/>
                <input type='hidden' name='categoryName' value='".$category_name."'/>
                <button class='cms-button-table' type='submit'>
                Edytuj kategorię
                </button>
            </form>

            <form method='post'>
                <input type='hidden' name='idCategoryToDelete' value='" . $id . "'/>
                <button class='cms-button-table' type='submit' name='delete' >
                Usuń kategorię
                </button>
            </form>
            </div>
            ";

            echo $table;
        }
    }

    //------------------------------------------------------//
    // Funkcja zwracajaca formularz dodania nowej kategorii //
    //------------------------------------------------------//
    //
    // Funkcja generuje i zwraca tabele html - formularz dodania nowej kategorii
    //
    function dodajNowaKategorie() {
        $insert_table = 
        "
        <div style='margin-top: 120px;'>
            <h2 class='cms-h2'>
            Dodaj nową kategorię
            </h2>
            <form method='post'>
            <table class='cms-table'>
                <thead>
                    <th>
                        <span class='cms-editor'>
                        Id matki
                        </span>
                    </th>
                    <th>
                        <span class='cms-editor'>
                        Nazwa kategorii
                        </span>
                    </th>
                </thead>
                <tbody>
                    <tr class='cms-tr'>
                        <td style='width: 30%;'>
                            <input type='text' value='0' name='insertMotherId'/>
                        </td>
                        <td style='width: 30%;'>
                            <input type='text' name='insertCategoryName'/>
                        </td>
                    </tr>       
                </tbody>
            </table>
            <div style='text-align: center; margin-top: 10px;'>
                <button class='cms-button' type='submit'>
                Dodaj Kategorię
                </button>
            </div>
            </form>
        </div>
        ";
        return $insert_table;
    }

    //-----------------------------------------------//
    // Funkcja zwracajaca formularz edycji kategorii //
    //-----------------------------------------------//
    //
    // Funkcja generuje i zwraca tabele html - formularz edycji kategorii
    //
    function edytujKategorie() {
        // Jesli nie wybrano kategorii do edycji, formularz nie pojawi sie
        if(empty($_POST['idCategory'])) {
            return "";
        }

        $id = $_POST['idCategory'];
        $id_mother= $_POST['idMother'];
        $category_name = htmlspecialchars($_POST['categoryName']);

        $update_table = 
        "
        <div style='margin-bottom: 50px;'>
            <h2 class='cms-h2' style='margin-top: 30px;'>
            Edycja kategorii
            </h2>
            <form method='post'>
                <table class='cms-table'>
                    <thead>
                        <th>
                            <span class='cms-editor'>
                            Id kategorii
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                            Id matki
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                            Nazwa kategorii
                            </span>
                        </th>
                    </thead>
                    <tbody>
                        <tr class='cms-tr'>
                            <td style='width: 7%;'>
                                <input style='height: 100%; width: 95%;' type='text' readonly value='".$id."' name='updateId'/>
                            </td>
                            <td style='width: 30%;'>
                                <input type='text' value='".$id_mother." 'name='updateIdMother'/>
                            </td>
                            <td style='width: 30%;'>
                                <input type='text' value='".$category_name." 'name='updateCategoryName'/>
                            </td>
                        </tr>       
                    </tbody>
                </table>
                <div style='text-align: center; margin-top: 10px;'>
                    <button class='cms-button' type='submit'>
                    Zapisz Zmiany
                    </button>
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
    // Funkcja na potrzeby funckji " dodajNowaKategorie() "
    // Funkcja tworzy i wysyla zapytanie o stworzenie nowego rekordu w tabeli kategorie
    // na podstawie danych wporwadzonych do formularza dodania nowej kategorii
    //
    function queryInsertCategory() {
        include('cfg.php');

        $id_mother = $_POST['insertMotherId'];
        $category_name = $_POST['insertCategoryName'];

        $query = "INSERT INTO `kategorie` (`id`, `matka`, `nazwa`) VALUES (NULL, '".$id_mother."', '".htmlspecialchars($category_name)."')";
        $result = mysqli_query($link, $query);

        return $result;
    }

    //---------------------------------------------//
    // Funkcja wysylajaca zapytanie do bazy danych //
    //---------------------------------------------//
    //
    // Funkcja na potrzeby funckji " edytujKategorie() "
    // Funkcja tworzy i wysyla zapytanie o edycje rekordu w tabeli kategorie
    // na podstawie danych wporwadzonych do formularza edycji kategorii
    //
    function queryUpdateCategory() {
        include('cfg.php');

        $id = $_POST['updateId'];
        $id_mother = $_POST['updateIdMother'];
        $category_name = $_POST['updateCategoryName'];

        $query = "UPDATE `kategorie` SET `matka`='".$id_mother."' , `nazwa`=' ".htmlspecialchars($category_name)." ' WHERE `id`=".$id." LIMIT 1";
        $result = mysqli_query($link, $query);

        return $result;
    }

    //---------------------------------------------//
    // Funkcja wysylajaca zapytanie do bazy danych //
    //---------------------------------------------//
    //
    // Funkcja na potrzeby funckji " listaKategorii() "
    // Funkcja tworzy i wysyla zapytanie o usuniecie rekordu z tabeli kategorie
    // na podstawie wybranej do usuniecia kategorii z listy wszystkich kategorii
    //
    function queryDeleteCategory() {
        include('cfg.php');

        $id = $_POST['idCategoryToDelete'];

        $query = "DELETE FROM `kategorie` WHERE id=$id LIMIT 1";
        $result = mysqli_query($link, $query);
        
        return $result;
    }

    //----------------------------------//
    // Funkcja obslugujaca panel sklepu //
    //----------------------------------//
    //
    // Funkcja wspolpracuje z powyzszymi funkcjami cms'owymi
    // Funkcja wyswietla panel zarządzania sklepem (liste kategorii, edycje kategorii, dodanie nowej kategorii, usunięcia kategorii)
    //
    function panelSklepu(){
        if($_SESSION['loggedIn'] == 1) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if(isset($_POST['updateId'])) {
                    $result = queryUpdateCategory();
                    if ($result == 1){
                        ?>
                        <div class="center-message">
                        <?php

                        echo("Pomyślnie zmieniono kategorię");

                        ?>
                        <?php
                    }
                    else {
                        ?>
                        <div class="center-message">
                        <?php

                        echo("Niepowodzenie podczas edycji kategorii");

                        ?>
                        <?php
                    }
                    exit;
                }

                if(isset($_POST['insertMotherId'])) {
                    $result = queryInsertCategory();
                    if ($result == 1){
                        ?>
                        <div class="center-message">
                        <?php

                        echo("Pomyślnie dodano kategorię");

                        ?>
                        <?php
                    }
                    else {
                        ?>
                        <div class="center-message">
                        <?php

                        echo("Niepowodzenie podczas dodawania kategorii");

                        ?>
                        <?php
                    }
                    exit;
                }

                if(isset($_POST['idCategoryToDelete'])) {
                    $result = queryDeleteCategory();
                    if ($result == 1){
                        ?>
                        <div class="center-message">
                        <?php

                        echo("Pomyślnie usunięto kategorię");

                        ?>
                        <?php
                    }
                    else {
                        ?>
                        <div class="center-message">
                        <?php

                        echo("Niepowodzenie podczas usuwania kategorii");

                        ?>
                        <?php
                    }
                    exit;
                }
            }

            echo edytujKategorie();

            drzewkoKategorii();

            listaKategorii();
            echo dodajNowaKategorie();

        }
        else {
            ?>
            <div class="center-message">
            <?php

            echo("Dostęp tylko dla administratora");

            ?>
            <?php
        }
    }

?>