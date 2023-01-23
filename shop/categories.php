<?php


    //---------------------------------------//
    // Funkcja wyswietlajaca liste kategorii //
    //---------------------------------------//
    //
    // Funkcja generuje liste wszystkich kategorii wraz z podkategoriami
    // oraz przyciskami edycji i usunięcia
    //
    function drzewkoKategorii() {
        include('cfg.php');

        $query = "SELECT * FROM kategorie where matka=0";
        $main_categories = mysqli_query($link, $query);

        $tree="
        <div class='tree'>
            <h2 class='cms-h2'>Pogląd drzewka kategorii:</h2> 
        ";

        while($row = mysqli_fetch_array($main_categories)) {
            $id = $row['id'];
            $mother = $row['matka'];
            $motherCategoryName = $row['nazwa'];

                $tree = $tree ."
                <div style='display: flex; align-items: center;'>
                    <span class='tree-h3'>- $id $motherCategoryName</span>
                    <form method='post'>
                        <input type='hidden' name='idCategory' value='".$id."'/>
                        <input type='hidden' name='idMother' value='".$mother."'/>
                        <input type='hidden' name='categoryName' value='".$motherCategoryName."'/>
                        <button class='tree-button' type='submit'>
                            Edytuj kategorię
                        </button>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='idCategoryToDelete' value='" . $id . "'/>
                        <button class='tree-button-del' type='submit' name='delete' >
                            Usuń kategorię
                        </button>
                    </form>
                </div>
                    ";
            
            $query = "SELECT * FROM kategorie where matka=$id";
            $sub_category = mysqli_query($link, $query);

            while($row = mysqli_fetch_array($sub_category)) {
                $sub_id = $row['id'];
                $sub_mother = $row['matka'];
                $sub_name = $row['nazwa'];

                $tree = $tree ."
                    <div>
                        <span class='sub-h3' style='display: inline-block;'>- - - $sub_id $sub_name</span>
                        <form method='post' style='display: inline-block;'>
                            <input type='hidden' name='idCategory' value='".$sub_id."'/>
                            <input type='hidden' name='idMother' value='".$sub_mother."'/>
                            <input type='hidden' name='categoryName' value='".$sub_name."'/>
                            <button class='tree-button' type='submit'>
                                Edytuj kategorię
                            </button>
                        </form>
                        <form method='post' style='display: inline-block;'>
                            <input type='hidden' name='idCategoryToDelete' value='" . $sub_id . "'/>
                            <button class='tree-button-del' type='submit' name='delete' >
                                Usuń kategorię
                            </button>
                        </form>
                    </div>
                ";
            }

        }

        $tree .= "</div>";

        echo $tree;
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

        $id_mother = htmlspecialchars($_POST['insertMotherId']);
        $category_name = htmlspecialchars($_POST['insertCategoryName']);

        $query = "INSERT INTO kategorie (id, matka, nazwa) VALUES (NULL, '$id_mother', '$category_name')";
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

        $id = htmlspecialchars($_POST['updateId']);
        $id_mother = htmlspecialchars($_POST['updateIdMother']);
        $category_name = htmlspecialchars($_POST['updateCategoryName']);

        $query = "UPDATE kategorie SET matka=$id_mother, nazwa='$category_name' WHERE id=$id LIMIT 1";
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

        $query = "DELETE FROM kategorie WHERE id=$id LIMIT 1";
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
    function panelKategorii(){

        $location = "http://localhost/projekt/?idp=1001";

        if($_SESSION['loggedIn'] == 1) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if(isset($_POST['updateId'])) {
                    $result = queryUpdateCategory();
                    if ($result == 1){
                        echo "<script>";
                        echo 'alert("Edytowano kategorię.");';
                        echo "window.location.href = `$location`;";
                        echo "</script>";
                    }
                    else {
                        echo "<script>";
                        echo 'alert("Niepowodzenie podczas edycji kategorii.");';
                        echo "window.location.href = `$location`;";
                        echo "</script>";
                    }
                    exit;
                }

                if(isset($_POST['insertMotherId'])) {
                    $result = queryInsertCategory();
                    if ($result == 1){
                        echo "<script>";
                        echo 'alert("Dodano kategorię.");';
                        echo "window.location.href = `$location`;";
                        echo "</script>";
                    }
                    else {
                        echo "<script>";
                        echo 'alert("Niepowodzenie podczas dodawania kategorii.");';
                        echo "window.location.href = `$location`;";
                        echo "</script>";
                    }
                    exit;
                }

                if(isset($_POST['idCategoryToDelete'])) {
                    $result = queryDeleteCategory();
                    if ($result == 1){
                        echo "<script>";
                        echo 'alert("Usunięto kategorię.");';
                        echo "window.location.href = `$location`;";
                        echo "</script>";
                    }
                    else {
                        echo "<script>";
                        echo 'alert("Niepowodzenie podczas usuwania kategorii.");';
                        echo "window.location.href = `$location`;";
                        echo "</script>";
                    }
                    exit;
                }
            }

            echo edytujKategorie();

            drzewkoKategorii();

            echo dodajNowaKategorie();

        }
        else {
            echo "<script>";
            echo 'alert("Dostęp tylko dla administratora.");';
            echo "window.location.href = `$location`;";
            echo "</script>";
        }
    }

?>