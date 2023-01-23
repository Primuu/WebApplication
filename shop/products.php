<?php


    //-------------------------------------------------------//
    // Funkcja wyswietlajaca liste do zarzadzania produktami //
    //-------------------------------------------------------//
    //
    // Funkcja generuje i wyswietla tabele html - liste wszystkich produktow
    // razem z przyciskami edycji i usuniecia produktu
    //
    function listaProduktow() {
        include('cfg.php');

        $query = "SELECT * FROM produkty";
        $result = mysqli_query($link, $query);
        
        while( $row = mysqli_fetch_array($result) ) {
            $id = $row['id'];
            $name = $row['nazwa'];
            $desc = $row['opis'];
            $date_start = $row['data_utworzenia'];
            $date_mod = $row['data_modyfikacji'];
            $date_end = $row['data_konca'];
            $price = $row['cena_netto'];
            $tax = $row['podatek_vat'];
            $amount = $row['ilosc'];
            $status = $row['status'];
            $category = $row['kategoria'];
            $dimensions = $row['gabaryt'];
            $img = $row['zdjecie'];

            $table =
            "
            <table class='cms-table'>
                <tr>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Id
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Produkt
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Opis
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Utworzono
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Modyfikowano
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Wygasa
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Cena netto
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Podatek
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Ilość
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Status
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Kategoria
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Gabaryt
                        </span>
                    </td>
                    <td class='pro-td'>
                        <span class='pro-span'>
                            Zdjęcie
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class='pro-td'>$id</td>
                    <td class='pro-td'>$name</td>
                    <td class='pro-td'>$desc</td>
                    <td class='pro-td'>$date_start</td>
                    <td class='pro-td'>$date_mod</td>
                    <td class='pro-td'>$date_end</td>
                    <td class='pro-td'>$price</td>
                    <td class='pro-td'>$tax</td>
                    <td class='pro-td'>$amount</td>
                    <td class='pro-td'>$status</td>
                    <td class='pro-td'>$category</td>
                    <td class='pro-td'>$dimensions</td>
                    <td class='pro-td' style='width: 106px;'>
                        <img class='img-product' src=".$img.">
                        </td>
                </tr>
            </table>        

            <div style='display: flex;'>
            <form method='post'>
                <input type='hidden' name='idProduct' value=$id >
                <input type='hidden' name='nameProduct' value=$name />
                <input type='hidden' name='descProduct' value=$desc />
                <input type='hidden' name='dateStart' value=$date_start />
                <input type='hidden' name='dateEnd' value=$date_end />
                <input type='hidden' name='priceProduct' value=$price />
                <input type='hidden' name='taxProduct' value=$tax />
                <input type='hidden' name='amountProduct' value=$amount />
                <input type='hidden' name='statusProduct' value=$status />
                <input type='hidden' name='categoryProduct' value=$category />
                <input type='hidden' name='dimensionsProduct' value=$dimensions />
                <input type='hidden' name='imgProduct' value='".$img."'/>
                <button class='cms-button-table' type='submit'>
                    Edytuj produkt
                </button>
            </form>

            <form method='post'>
                <input type='hidden' name='idProductToDelete' value=$id />
                <button class='cms-button-table' type='submit' name='delete' >
                    Usuń produkt
                </button>
            </form>
            </div>
            ";

            echo $table;
        }
    }

        //------------------------------------------------------//
    // Funkcja zwracajaca formularz dodania nowego produktu //
    //------------------------------------------------------//
    //
    // Funkcja generuje i zwraca tabele html - formularz dodania nowego produktu
    //
    function dodajNowyProdukt() {
        $insert_table = 
        "
        <div style='margin-top: 120px;'>
            <h2 class='cms-h2'>
                Dodaj nowy produkt
            </h2>
            <form method='post'>
            <table class='cms-table'>
                <thead>
                    <th>
                        <span class='cms-editor'>
                            Produkt
                        </span>
                    </th>
                    <th>
                        <span class='cms-editor'>
                            Opis
                        </span>
                    </th>
                    <th>
                        <span class='cms-editor'>
                            Wygasa
                        </span>
                    </th>
                    <th>
                        <span class='cms-editor'>
                            Cena netto
                        </span>
                    </th>
                    <th>
                        <span class='cms-editor'>
                            Podatek
                        </span>
                    </th>
                    <th>
                        <span class='cms-editor'>
                            Ilość
                        </span>
                    </th>
                    <th>
                        <span class='cms-editor'>
                            Kategoria
                        </span>
                    </th>
                    <th>
                        <span class='cms-editor'>
                            Gabaryt
                        </span>
                    </th>
                    <th>
                        <span class='cms-editor'>
                            Ścieżka zdjęcia
                        </span>
                    </th>
                </thead>
                <tbody>
                    <tr class='cms-tr'>
                        <td>
                            <input type='text' name='insertProductName'/>
                        </td>
                        <td>
                            <input type='text' name='insertProductDesc'/>
                        </td>
                        <td style='width: 60px'>
                            <input type='date' name='insertProductDateEnd' style='height: 33px'/>
                        </td>
                        <td style='width: 120px'>
                            <input type='number' step='0.01' min='0' name='insertProductNetto' style='width: 150px; height: 33px;'/>
                        </td>
                        <td style='width: 100px'>
                            <input type='number' step='0.01' min='0' name='insertProductTax' style='width: 150px; height: 33px;'/>
                        </td>
                        <td style='width: 100px'>
                            <input type='number' step='1' min='0' name='insertProductAmount' style='width: 150px; height: 33px;'/>
                        </td>
                        <td style='width: 100px'>
                            <input type='number' step='1' min='0' placeholder='id' name='insertProductCategory' style='width: 150px; height: 33px;'/>
                        </td>
                        <td>
                            <input type='text' name='insertProductDimensions'/>
                        </td>
                        <td>
                            <input type='text' placeholder='./img/img.jpg' name='insertProductImg'/>
                        </td>
                    </tr>       
                </tbody>
            </table>
            <div style='text-align: center; margin-top: 10px;'>
                <button class='cms-button' type='submit'>
                Dodaj Produkt
                </button>
            </div>
            </form>
        </div>
        ";
        return $insert_table;
    }

    //----------------------------------------------//
    // Funkcja zwracajaca formularz edycji produktu //
    //----------------------------------------------//
    //
    // Funkcja generuje i zwraca tabele html - formularz edycji produktu
    //
    function edytujProdukt() {
        // Jesli nie wybrano produktu do edycji, formularz nie pojawi sie
        if(empty($_POST['idProduct'])) {
            return "";
        }

        $id = $_POST['idProduct'];

        $name = $_POST['nameProduct'];
        $desc = $_POST['descProduct'];
        $date_start = $_POST['dateStart'];
        $date_end = $_POST['dateEnd'];
        $price = $_POST['priceProduct'];
        $tax = $_POST['taxProduct'];
        $amount = $_POST['amountProduct'];

        $status = $_POST['statusProduct'];

        $category = $_POST['categoryProduct'];
        $dimensions = $_POST['dimensionsProduct'];
        $img = $_POST['imgProduct'];

        $update_table = 
        "
        <div style='margin-bottom: 50px;'>
            <h2 class='cms-h2' style='margin-top: 30px;'>
                Edycja produktu
            </h2>
            <form method='post'>
                <table class='cms-table'>
                    <thead>
                        <th>
                            <span class='cms-editor'>
                                Id
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                                Produkt
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                                Opis
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                                Wygasa
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                                Cena netto
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                                Podatek
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                                Ilość
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                                Status
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                                Kategoria
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                                Gabaryt
                            </span>
                        </th>
                        <th>
                            <span class='cms-editor'>
                                Ścieżka zdjęcia
                            </span>
                        </th>
                    </thead>
                    <tbody>
                        <tr class='cms-tr'>
                            <td style='width: 50px'>
                                <input type='text' readonly value='".$id."' name='updateId'/>
                            </td>
                            <td>
                                <input type='text' value='".$name." 'name='updateName'/>
                            </td>
                            <td>
                                <input type='text' value='".$desc." 'name='updateDesc'/>
                            </td>
                            <td style='width: 60px'>
                                <input type='date' value='".$date_end." 'name='updateDateEnd' style='height: 33px'/>
                            </td>
                            <td style='width: 120px'>
                                <input type='number' step='0.01' min='0' value='".$price." 'name='updatePrice' style='width: 150px; height: 33px;'/>
                            </td>
                            <td style='width: 100px'>
                                <input type='number' step='0.01' min='0' value='".$tax." 'name='updateTax' style='width: 150px; height: 33px;'/>
                            </td>
                            <td style='width: 100px'>
                                <input type='number' step='1' min='0' value='".$amount." 'name='updateAmount' style='width: 150px; height: 33px;'/>
                            </td>
                            <td style='width: 50px'>
                                <input type='text' readonly value='".$status."' name='updateStatus'/>
                            </td>
                            <td style='width: 100px'>
                                <input type='number' step='1' min='0' value='".$category." 'name='updateCategory'  style='width: 150px; height: 33px;'/>
                            </td>
                            <td>
                                <input type='text' value='".$dimensions."' name='updateDimensions'/>
                            </td>
                            <td>
                                <input type='text' value='".$img."' name='updateImg'/>
                            </td>
                            <input type='hidden' value='".$date_start." 'name='updateDateStart'/>
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
    // Funkcja na potrzeby funckji " dodajNowyProdukt() "
    // Funkcja tworzy i wysyla zapytanie o stworzenie nowego rekordu w tabeli produkty
    // na podstawie danych wporwadzonych do formularza dodania nowego produktu
    //
    function queryInsertProduct() {
        include('cfg.php');

        $name = htmlspecialchars($_POST['insertProductName']);
        $desc = htmlspecialchars($_POST['insertProductDesc']);
        $date_start = date("Y-m-d");
        $date_end = htmlspecialchars($_POST['insertProductDateEnd']);
        $price = htmlspecialchars($_POST['insertProductNetto']);
        $tax = htmlspecialchars($_POST['insertProductTax']);
        $amount = htmlspecialchars($_POST['insertProductAmount']);

        $status = 0;
        $time1 = strtotime($date_start);
        $time2 = strtotime($date_end);
        if($amount > 0 && $time1 < $time2){
            $status = 1;
        }

        $category = htmlspecialchars($_POST['insertProductCategory']);
        $dimensions = htmlspecialchars($_POST['insertProductDimensions']);
        $img = htmlspecialchars($_POST['insertProductImg']);

        $query = "INSERT INTO produkty (nazwa, opis, data_utworzenia, data_konca, cena_netto, podatek_vat, ilosc, `status`, kategoria, gabaryt, zdjecie)
                  VALUES ($name, $desc, '".$date_start."', '".$date_end."', $price, $tax, $amount, $status, $category, $dimensions, '$img')";
        $result = mysqli_query($link, $query);

        return $result;
    }

    //---------------------------------------------//
    // Funkcja wysylajaca zapytanie do bazy danych //
    //---------------------------------------------//
    //
    // Funkcja na potrzeby funckji " edytujProdukt() "
    // Funkcja tworzy i wysyla zapytanie o edycje rekordu w tabeli produkty
    // na podstawie danych wporwadzonych do formularza edycji produktow
    //
    function queryUpdateProducts() {
        include('cfg.php');
        
        $id = htmlspecialchars($_POST['updateId']);
        $name = htmlspecialchars($_POST['updateName']);
        $desc = htmlspecialchars($_POST['updateDesc']);
        $date_start = $_POST['updateDateStart'];
        $date_mod = date("Y-m-d H:i:s");
        $date_end = $_POST['updateDateEnd'];
        $price = htmlspecialchars($_POST['updatePrice']);
        $tax = htmlspecialchars($_POST['updateTax']);
        $amount = htmlspecialchars($_POST['updateAmount']);
        
        $status = 0;
        $time1 = strtotime($date_start);
        $time2 = strtotime($date_end);
        if($amount > 0 && $time1 < $time2){
            $status = 1;
        }

        $category = htmlspecialchars($_POST['updateCategory']);
        $dimensions = htmlspecialchars($_POST['updateDimensions']);
        $img = htmlspecialchars($_POST['updateImg']);


        $query = "UPDATE produkty SET nazwa='$name', opis='$desc', data_modyfikacji='".$date_mod."', data_konca='".$date_end."',
                                      cena_netto=$price, podatek_vat=$tax, ilosc=$amount, `status`=$status, kategoria=$category,
                                      gabaryt=$dimensions, zdjecie='$img'
                                      WHERE id=$id LIMIT 1";
        $result = mysqli_query($link, $query);

        return $result;
    }

    //---------------------------------------------//
    // Funkcja wysylajaca zapytanie do bazy danych //
    //---------------------------------------------//
    //
    // Funkcja na potrzeby funckji " listaProduktow() "
    // Funkcja tworzy i wysyla zapytanie o usuniecie rekordu z tabeli produkty
    // na podstawie wybranego do usuniecia produktu z listy wszystkich produktow
    //
    function queryDeleteProduct() {
        include('cfg.php');

        $id = $_POST['idProductToDelete'];

        $query = "DELETE FROM produkty WHERE id=$id LIMIT 1";
        $result = mysqli_query($link, $query);
        
        return $result;
    }

    //----------------------------------//
    // Funkcja obslugujaca panel sklepu //
    //----------------------------------//
    //
    // Funkcja wspolpracuje z powyzszymi funkcjami cms'owymi
    // Funkcja wyswietla panel zarządzania produktami (liste prodoktow, edycje, dodanie nowego produktu, usunięcia)
    //
    function panelProduktow(){

        $location = "http://localhost/projekt/?idp=1002";

        if($_SESSION['loggedIn'] == 1) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if(isset($_POST['updateId'])) {
                    $result = queryUpdateProducts();
                    if ($result == 1){
                        echo "<script>";
                        echo 'alert("Edytowano produkt.");';
                        echo "window.location.href = `$location`;";
                        echo "</script>";
                    }
                    else {
                        echo "<script>";
                        echo 'alert("Niepowodzenie podczas edytowania produktu.");';
                        echo "window.location.href = `$location`;";
                        echo "</script>";
                    }
                    exit;
                }

                if(isset($_POST['insertProductName'])) {
                    $result = queryInsertProduct();
                    if ($result == 1){
                        echo "<script>";
                        echo 'alert("Dodano produkt.");';
                        echo "window.location.href = `$location`;";
                        echo "</script>";
                    }
                    else {

                        echo "<script>";
                        echo 'alert("Niepowodzenie podczas dodawania produktu.");';
                        echo "window.location.href = `$location`;";
                        echo "</script>";
                    }
                    exit;
                    }

                    if(isset($_POST['idProductToDelete'])) {
                        $result = queryDeleteProduct();
                        if ($result == 1){
                            echo "<script>";
                            echo 'alert("Usunięto produkt.");';
                            echo "window.location.href = `$location`;";
                            echo "</script>";
                        }
                        else {
                            echo "<script>";
                            echo 'alert("Niepowodzenie podczas usuwania produktu.");';
                            echo "window.location.href = `$location`;";
                            echo "</script>";
                        }
                        exit;
                    }
       
                }

            echo edytujProdukt();

            listaProduktow();

            echo dodajNowyProdukt();

        }
        else {
            echo "<script>";
            echo 'alert("Widok tylko dla administratora.");';
            echo "window.location.href = `$location`;";
            echo "</script>";
        }
    }

?>