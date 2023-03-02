<?php


//---------------------------------//
// Funkcja zwracajaca widok sklepu //
//---------------------------------//
//
// Funkcja generuje i zwraca sklep liste przedmiotow
// wraz z przyciskami kupna oraz mozliwoscia przejscia
// do widoku szczegolow przedmiotu
//
function sklepLista() {
    include('cfg.php');

    // Pobranie wszystkich produktow z bd
    $query = "SELECT * FROM produkty";
    $result = mysqli_query($link, $query);

    // Poczatek tabeli, ktora bedzie wyswietlac liste prodoktow (naglowki)
    $table =
    "
    <table class='shop-table'>
        <tr>
            <td class='shop-td' style='width: 220px;'>
                <span>
                    Kup
                </span>
            </td>
            <td class='shop-td'>
                <span>
                    Nazwa produktu
                </span>
            </td>
            <td class='shop-td'>
                <span>
                    Kategoria
                </span>
            </td>
            <td class='shop-td'>
                <span>
                    Cena (netto)
                </span>
            </td>
            <td class='shop-td'>
                <span>
                    Status
                </span>
            </td>
            <td class='shop-td'>
                <span>
                    Zdjęcie
                </span>
            </td>
        </tr>
    ";
    
    // Przypisanie kazdemu wierszowi w tabeli produktu
    while( $row = mysqli_fetch_array($result) ) {
        // Przypisanie pol z bd do zmiennych
        $id = $row['id'];
        $name = $row['nazwa'];
        $desc = $row['opis'];
        $date_start = $row['data_utworzenia'];
        $date_mod = $row['data_modyfikacji'];
        $date_end = $row['data_konca'];
        $price = $row['cena_netto']." zł";
        $tax = $row['podatek_vat'];
        $amount = $row['ilosc'];
        $status = $row['status'];
        $category_id = $row['kategoria'];
        $dimensions = $row['gabaryt'];
        $img = $row['zdjecie'];
        
        // Zmienna do wyswietlania statusu
        $status_en = "";
        if($status == 1) $status_en = $status_en."Dostępny";
        else $status_en = $status_en."Niedostępny";

        // Zmienna do wyswietlania kategorii
        $category = "";

        // Pobranie kategorii z bd dla podanego id produktu
        $query2 = "SELECT * FROM kategorie WHERE id=$category_id LIMIT 1";
        $result2 = mysqli_query($link, $query2);
        $row2 = mysqli_fetch_array($result2);

        // Jesli kategoria ma id matki, pobierana jest rowniez kategoria matka
        if($row2['matka'] != 0){
            // Pobranie kategorii matki z bd
            $query3 = "SELECT * FROM kategorie WHERE id=".$row2['matka']." LIMIT 1 ";
            $result3 = mysqli_query($link, $query3);
            $row3 = mysqli_fetch_array($result3);

            // Przypisanie kategorii matki do zmiennej (jesli jest)
            $category = $category.$row3['nazwa']." - ";
        }
        // Przypisanie kategorii do zmiennej
        $category = $category.$row2['nazwa'];

        // Dalsze tworzenie tabeli
        $table = $table . 
        "
        <tr class='detail'>
            <td class='shop-list-td'>";
        
        // Dodanie przycisku do zamawiania w zaleznosci od statusu
        if($status == 1) $table = $table."
                <form method='post'>
                    <div style='text-align: center;'>
                        <input type='hidden' value='".$id."' name='itemId'/>
                        <input type='hidden' value='".$name."' 'name='itemName'/>
                        <input type='hidden' value='".$price."' 'name='itemPrice'/>
                        <input type='hidden' value='".$tax."' 'name='itemTax'/>
                        <input type='hidden' value='".$amount." 'name='itemAmount'/>
                        <input type='hidden' value='".$status."' name='itemStatus'/>
                        <input type='hidden' value='".$date_start."' name='itemDateStart'/>
                        <input type='hidden' value='".$date_end."' name='itemDateEnd'/>
                        <button class='cms-button' type='submit'>
                            Dodaj do koszyka
                        </button>
                    </div>
                </form>";
        else $table = $table . "
                <div style='text-align: center;'>
                    <button class='cms-button' style='background-color: rgb(132, 134, 134); border-color: rgb(95, 95, 95);'>
                        Produkt niedostępny
                    </button>
                </div>";

        // Dalsze tworzenie tabeli (dodanie wierszow z produktami)
        $table = $table .
            "
            </td>
            <form method='post'>
                <input type='hidden' value=$id name='itemIdDetail'/>
                <td class='shop-list-td'>
                    <button type='submit' class='item-detail'>
                        $name
                    </button>
                </td>
                <td class='shop-list-td'>
                    <button type='submit' class='item-detail'>
                        $category
                    </button>
                </td>
                <td class='shop-list-td'>
                    <button type='submit' class='item-detail'>
                        $price
                    </button>
                </td>
                <td class='shop-list-td'>
                    <button type='submit' class='item-detail'>
                        $status_en
                    </button>
                </td>
                <td class='shop-list-td' style='width: 100px; background-color: rgb(217, 236, 245); border: 1px solid;'>
                    <img class='img-product' src=".$img.">
                </td>
            </form>
        </tr>
        ";

    }

    // Zakonczenie tabeli
    $table = $table . 
    "
    </table>
    ";

    // Wyswietlenie tabeli z produktami
    echo $table;
}


//----------------------------//
// Funkcja obslugujaca koszyk //
//----------------------------//
//
// Funkcja dodajaca przedmioty do koszyka
//
function addToCart() {
    include('cfg.php');
    
    // Ustawienie licznika produktow jesli nie jest jeszcze ustawiony, badz jego inkrementacja
    if (!isset($_SESSION['count']))
    {
        $_SESSION['count'] = 0;
    }
    $_SESSION['count']++;

    // Pobranie id produktu, ktory ma zostac dodany
    $product_id = $_POST['itemId'];

    // Ustawienie licznika ilosci danego produktu jesli nie jest jeszcze ustawiony, badz jego inkrementacja
    if (!isset($_SESSION['cart'][$product_id]))
    {
        $_SESSION['cart'][$product_id] = 0;
    } 
    $_SESSION['cart'][$product_id] ++;

    // Przypisanie dat produktu w celu zaktualizowania statusu
    $date_start = $_POST['itemDateStart'];
    $date_end = $_POST['itemDateEnd'];
    $amount = $_POST['itemAmount'];
    
    // Nowa ilosc produktow na bd
    $amount_rest = $amount - 1;

    // Zaktualizowanie statusu w zalesnoci od ilosci i dat
    $status = 0;
    $time1 = strtotime($date_start);
    $time2 = strtotime($date_end);
    if($amount_rest > 0 && $time1 < $time2){
        $status = 1;
    }

    // Stworzenie i wyslanie zapytania na bd w celu zaktualiwoania statusu i ilosci
    $query = "UPDATE produkty SET ilosc=$amount_rest, status=$status WHERE id=$product_id LIMIT 1";
    $result = mysqli_query($link, $query);

    // Zwrocenie odpowiedzi
    return $result;
}


//----------------------------//
// Funkcja obslugujaca koszyk //
//----------------------------//
//
// Funkcja pokazująca zawartosc koszyka
// wraz z mozliwoscia usuniecia przedmiotu z koszyka
//
function showCart() {
    include('cfg.php');

    // Jesli koszyk nie zostal jeszcze zainicjalizowany to sie nie wyswietli
    if(empty($_SESSION['cart'])){
        return;
    }

    // Zmienna do liczenia wartosci calego koszyka
    $sum = 0;

    // Poczatek tabeli do wyswietlania zawartosci koszyka
    $table =
    "
    <table class='shop-table' style='width: 50%; margin-bottom: 200px;'>
        <tr>
            <td colspan='5' class='shop-list-td'>
                <h1>Koszyk</h1>
            </td>
        </tr>
        <tr>
            <td class='shop-td'>
                <span>
                    Zdjęcie
                </span>
            </td>
            <td class='shop-td'>
                <span>
                    Nazwa produktu
                </span>
            </td>
            <td class='shop-td'>
                <span>
                    Ilość
                </span>
            </td>
            <td class='shop-td'>
                <span>
                    Cena (brutto)
                </span>
            </td>
            <td class='shop-td'>
                <span>
                    Usuń
                </span>
            </td>
        </tr>
    ";

    // Wyswietlanie kazdego produktu w koszyku po kolei za pomoca petli
    foreach($_SESSION['cart'] as $product_id => $product_quantity){
        // Stworzenie i wyslanie zapytania w celu dodania szczegolow danego przedmiotu w koszyku
        $query = "SELECT * FROM produkty WHERE id=$product_id";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        // Przypisanie pol z bd do zmiennych
        $img = $row['zdjecie'];
        $name = $row['nazwa'];
        $price = $row['cena_netto'];
        $tax = $row['podatek_vat'];
        $amount = $row['ilosc'];

        // Wyliczenie ceny brutto
        $gross_price = ($price + ($price * $tax)) * $product_quantity;
        $gross_price = round($gross_price, 2);

        // Dodanie ceny brutto do sumy ogolnej
        $sum = $sum + $gross_price;
        $sum = round($sum, 2);

        // Dodanie szczegolow produktu do tabeli
        if($product_quantity > 0){
            $table = $table . 
            "
            <tr>
                <td class='shop-list-td' style='width: 100px; border: 1px solid;'>
                    <img class='img-product' src=".$img.">
                </td>
                <td class='shop-list-td'>$name</td>
                <td class='shop-list-td'>$product_quantity</td>
                <td class='shop-list-td'>$gross_price zł</td>
                <td class='shop-list-td' style='width: 220px;'>
                    <form method='post'>
                        <div style='text-align: center;'>
                            <input type='hidden' value='".$product_id."' name='itemIdDelete'/>
                            <input type='hidden' value='".$amount." 'name='itemAmountDelete'/>
                            <button class='cms-button' type='submit'>
                                Odejmij z koszyka
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
            ";
        }
    }

    // Dodanie podsumowania (ceny) i zamkniecie tabeli
    $table = $table . 
    "    
        <tr>
            <td colspan='5' class='shop-list-td'>
                Ilość produktów: ".$_SESSION['count']." - cena ".$sum." zł
            </td>
        </tr>
    </table>
    ";

    // Wyswietlenie koszyka
    echo $table;
}


//----------------------------//
// Funkcja obslugujaca koszyk //
//----------------------------//
//
// Funkcja usuwajaca przedmioty z koszyka
//
function removeFromCart() {
    include('cfg.php');

    // Zmniejszenie ogolnej ilosci produktow w koszyku
    $_SESSION['count'] = $_SESSION['count'] - 1;

    // Pobranie id produktu do odjecia z koszyka
    $product_id = $_POST['itemIdDelete'];

    // Zmniejszenie ilosci danego produktu w koszyku
    $_SESSION['cart'][$product_id] = $_SESSION['cart'][$product_id] - 1;
        
    // Pobranie aktualnej ilosci produktu z tabeli
    $amount = intval($_POST['itemAmountDelete']);
    
    // Dodanie produktu (usunietego z koszyka) z powrotem do bd
    $amount_in_db = $amount + 1;

    // Aktualizacja statusu
    $status = 0;
    if($amount_in_db > 0){
        $status = 1;
    }

    // Stworzenie i wyslanie zapytania do zaktualizowania statusu i ilosci
    $query = "UPDATE produkty SET ilosc=$amount_in_db, status=$status WHERE id=$product_id LIMIT 1";
    $result = mysqli_query($link, $query);

    // Zwrocenie odpowiedzi
    return $result;
}


//----------------------------------------//
// Funkcja obslugujaca podglad przedmiotu //
//----------------------------------------//
//
// Funkcja wyswietlajaca szczegoly danego przedmiotu
//
function itemDetail() {
    include('cfg.php');

    // Pobranie id produktu, ktorego szczegoly maja zostac wyswietlone
    $product_id = $_POST['itemIdDetail'];

    // Stworzenie i wyslanie zapytania do bd w celu pobrania danych na temat produktu
    $query = "SELECT * FROM produkty WHERE id=$product_id LIMIT 1";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);

    // Przypisanie pol do zmiennych
    $id = $row['id'];
    $name = $row['nazwa'];
    $desc = $row['opis'];
    $date_start = $row['data_utworzenia'];
    $date_mod = $row['data_modyfikacji'];
    $date_end = $row['data_konca'];
    $price = $row['cena_netto']." zł";
    $tax = $row['podatek_vat'];
    $amount = $row['ilosc'];
    $status = $row['status'];
    $category_id = $row['kategoria'];
    $dimensions = $row['gabaryt'];
    $img = $row['zdjecie'];

    // Zmienna do wyswietlania statusu
    $status_en = "";
    if($status == 1) $status_en = $status_en."Dostępny";
    else $status_en = $status_en."Niedostępny";

    // Zmienna do wyswietlania kategorii
    $category = "";

    // Pobranie kategorii z bd dla podanego id produktu
    $query2 = "SELECT * FROM kategorie WHERE id=$category_id LIMIT 1";
    $result2 = mysqli_query($link, $query2);
    $row2 = mysqli_fetch_array($result2);

    // Jesli kategoria ma id matki, pobierana jest rowniez kategoria matka    
    if($row2['matka'] != 0){
        // Pobranie kategori matki z bd
        $query3 = "SELECT * FROM kategorie WHERE id=".$row2['matka']." LIMIT 1";
        $result3 = mysqli_query($link, $query3);
        $row3 = mysqli_fetch_array($result3);

        // Przypisanie kategorii matki do zmiennej (jesli jest)
        $category = $category.$row3['nazwa']." - ";
    }
    // Przypisanie kategorii do zmiennej
    $category = $category.$row2['nazwa'];

    // Wyliczenie ceny brutto
    $gross_price = ($price + ($price * $tax));
    $gross_price = round($gross_price, 2)." zł";

    // Stworzenie zmiennej do wyswietlania podatku
    $tax_display = ($tax * 100)." %";

    // Stworzenie tabeli ze szczegolami produktu
    $table =
    "
    <div class='container'>
        <div class='image-detail'>
            <img class='img-detail' src=".$img.">
        </div>
        <div class='details'>
            <table class='detail-table'>
                <tr>
                    <th class='detail-th'>
                        Nazwa
                    </th>
                    <td class='detail-td'>
                        $name
                    </td>
                </tr>
                <tr>
                    <th class='detail-th'>
                        Kategoria
                    </th>
                    <td class='detail-td'>
                        $category
                    </td>
                </tr>
                <tr>
                    <th class='detail-th'>
                        Opis
                    </th>
                    <td class='detail-td'>
                        $desc
                    </td>
                </tr>
                <tr>
                    <th class='detail-th'>
                        Cena netto
                    </th>
                    <td class='detail-td'>
                        $price
                    </td>
                </tr>
                <tr>
                    <th class='detail-th'>
                        Podatek vat
                    </th>
                    <td class='detail-td'>
                        $tax_display
                    </td>
                </tr>
                <tr>
                    <th class='detail-th'>
                        Cena brutto
                    </th>
                    <td class='detail-td'>
                        $gross_price
                    </td>
                </tr>
                <tr>
                    <th class='detail-th'>
                        Status
                    </th>
                    <td class='detail-td'>
                        $status_en
                    </td>
                </tr>
                <tr>
                    <th class='detail-th'>
                        Gabaryt
                    </th>
                    <td class='detail-td'>
                        $dimensions
                    </td>
                </tr>
                <tr>
                    <td colspan='2' class='shop-list-td'>
                    ";

    // Wyswietlenie przycisku do zakupu w zaleznosci od dostepnosci
    if($status == 1) $table = $table."
                        <form method='post'>
                            <div style='text-align: center; margin-top:30px;'>
                            <input type='hidden' value='".$id."' name='itemId'/>
                            <input type='hidden' value='".$name."' 'name='itemName'/>
                            <input type='hidden' value='".$price."' 'name='itemPrice'/>
                            <input type='hidden' value='".$tax."' 'name='itemTax'/>
                            <input type='hidden' value='".$amount." 'name='itemAmount'/>
                            <input type='hidden' value='".$status."' name='itemStatus'/>
                            <input type='hidden' value='".$date_start."' name='itemDateStart'/>
                            <input type='hidden' value='".$date_end."' name='itemDateEnd'/>
                            <button class='cms-button' type='submit'>
                                Dodaj do koszyka
                            </button>
                            </div>
                        </form>
                        ";
        
    else $table = $table . "
                        <div style='text-align: center; margin-top:30px;'>
                            <button class='cms-button' style='background-color: rgb(132, 134, 134); border-color: rgb(95, 95, 95);'>
                                Produkt niedostępny
                            </button>
                        </div>
                        ";


    // Dodanie przycisku powrotu i zamkniecie tabeli
    $table = $table."
                        <form method='post'>
                            <div style='margin-top: 30px;'>
                                <button class='cms-button' type='submit'>
                                    Powrót
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
     </div>
    ";

    // Wyswietlenie tabeli
    echo $table;
}

//---------------------------//
// Funkcja obslugujaca sklep //
//---------------------------//
//
// Funkcja wspolpracuje z powyzszymi funkcjami 
// Funkcja wyswietla sklep (liste prodoktow, koszyk)
//
function shop(){

    // Poczatek sesji
    session_start();

    // Zmienna z url do przeladowania strony 
    $location = "http://localhost/projekt/?idp=1003";

    // Inicjalizacja koszyka (jesli go nie bylo)
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }

    // Wyswietlenie komunikatu po dodaniu przedmiotu do koszyka w zaleznosci od powodzenia
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['itemId'])) {
            $result = addToCart();
            if ($result == 1){
                echo "<script>";
                echo 'alert("Dodano do koszyka.");';
                echo "window.location.href = `$location`;";
                echo "</script>";
            }
            else {
                echo "<script>";
                echo 'alert("Niepowodzenie podczas dodawania do koszyka.");';
                echo "window.location.href = `$location`;";
                echo "</script>";
            }
            exit;
        }

        // Wyswietlenie szczegolow przedmiotu
        if(isset($_POST['itemIdDetail'])) {
            itemDetail();
            exit;
        }

        // Wyswietlenie komunikatu po usunieciu przedmiotu z koszyka w zaleznosci od powodzenia
        if(isset($_POST['itemIdDelete'])) {
            $result = removeFromCart();
            if ($result == 1){
                echo "<script>";
                echo 'alert("Usunięto z koszyka.");';
                echo "window.location.href = `$location`;";
                echo "</script>";
            }
            else {
                echo "<script>";
                echo 'alert("Niepowodzenie podczas usuwania z koszyka.");';
                echo "window.location.href = `$location`;";
                echo "</script>";
            }
            exit;
        }
    
    }

    // Wyswietlenie koszyka
    showCart();
    // Wyswietlenie listy produktow
    sklepLista();
}

?>