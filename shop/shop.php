<?php

//---------------------------------//
// Funkcja zwracajaca widok sklepu //
//---------------------------------//
//
// Funkcja generuje i zwraca sklep
//
function sklepLista() {

    include('cfg.php');
    $query = " SELECT * FROM produkty ";
    $result = mysqli_query($link, $query);

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
    
    while( $row = mysqli_fetch_array($result) ) {
        $id = $row['id'];
        $name = htmlspecialchars($row['nazwa']);
        $desc = htmlspecialchars($row['opis']);
        $date_start = $row['data_utworzenia'];
        $date_mod = $row['data_modyfikacji'];
        $date_end = $row['data_konca'];
        $price = $row['cena_netto']." zł";
        $tax = $row['podatek_vat'];
        $amount = $row['ilosc'];
        $status = $row['status'];
        $category_id = htmlspecialchars($row['kategoria']);
        $dimensions = htmlspecialchars($row['gabaryt']);
        $img = htmlspecialchars($row['zdjecie']);
        
        $status_en = "";
        if($status == 1) $status_en = $status_en."Dostępny";
        else $status_en = $status_en."Niedostępny";

        $category = "";

        $query2 = " SELECT * FROM kategorie WHERE id=".$category_id." LIMIT 1 ";
        $result2 = mysqli_query($link, $query2);
        $row2 = mysqli_fetch_array($result2);

        if($row2['matka'] != 0){
            $query3 = " SELECT * FROM kategorie WHERE id=".$row2['matka']." LIMIT 1 ";
            $result3 = mysqli_query($link, $query3);
            $row3 = mysqli_fetch_array($result3);
            $category = $category.$row3['nazwa']." - ";
        }
        $category = $category.$row2['nazwa'];

        $table = $table . 
        "
        <tr>
            <td class='shop-list-td'>";
        
        if($status == 1) $table = $table."
                <form method='post'>
                    <div style='text-align: center;'>
                        <input type='hidden' value='".$id."' name='itemId'/>
                        <input type='hidden' value='".$name." 'name='itemName'/>
                        <input type='hidden' value='".$price." 'name='itemPrice'/>
                        <input type='hidden' value='".$tax." 'name='itemTax'/>
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


        $table = $table .
            "
            </td>
            <td class='shop-list-td'>".$name."</td>
            <td class='shop-list-td'>".$category."</td>
            <td class='shop-list-td'>".$price."</td>
            <td class='shop-list-td'>".$status_en."</td>
            <td class='shop-list-td' style='width: 100px; border: 1px solid;'>
                <img class='img-product' src=".$img.">
            </td>
        </tr>
        ";

    }
    
    $table = $table . 
    "
    </table>
    ";

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
    
    if (!isset($_SESSION['count']))
    {
        $_SESSION['count'] = 0;
    }
    $_SESSION['count']++;

    $product_id = $_POST['itemId'];

    if (!isset($_SESSION['cart'][$product_id]))
    {
        $_SESSION['cart'][$product_id] = 0;
    } 
    $_SESSION['cart'][$product_id] ++;

        
    $date_start = $_POST['itemDateStart'];
    $date_end = $_POST['itemDateEnd'];
    $amount = $_POST['itemAmount'];
    
    $amount_rest = $amount - 1;

    $status = 0;
    $time1 = strtotime($date_start);
    $time2 = strtotime($date_end);
    if($amount_rest > 0 && $time1 < $time2){
        $status = 1;
    }

    $query = "UPDATE produkty SET ilosc='".$amount_rest."', `status`='".$status."' WHERE id=".$product_id." LIMIT 1";
    $result = mysqli_query($link, $query);

    return $result;
}

//----------------------------//
// Funkcja obslugujaca koszyk //
//----------------------------//
//
// Funkcja pokazująca zawartość koszyka
//
function showCart() {
    include('cfg.php');

    if(empty($_SESSION['cart'])){
        return;
    }

    $sum = 0;

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


    foreach($_SESSION['cart'] as $product_id => $product_quantity){
        $query = " SELECT * FROM produkty WHERE id='".$product_id."' ";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        $img = $row['zdjecie'];
        $name = $row['nazwa'];
        $price = $row['cena_netto'];
        $tax = $row['podatek_vat'];
        $amount = $row['ilosc'];

        $gross_price = ($price + ($price * $tax)) * $product_quantity;
        $gross_price = round($gross_price, 2);

        $sum = $sum + $gross_price;
        $sum = round($sum, 2);

        if($product_quantity > 0){
            $table = $table . 
            "
            <tr>
                <td class='shop-list-td' style='width: 100px; border: 1px solid;'>
                    <img class='img-product' src=".$img.">
                </td>
                <td class='shop-list-td'>".$name."</td>
                <td class='shop-list-td'>".$product_quantity."</td>
                <td class='shop-list-td'>".$gross_price." zł</td>
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

    $table = $table . 
    "    
        <tr>
            <td colspan='5' class='shop-list-td'>
                Ilość produktów: ".$_SESSION['count']." - cena ".$sum." zł
            </td>
        </tr>
    </table>
    ";

    echo $table;

}

//----------------------------//
// Funkcja obslugujaca koszyk //
//----------------------------//
//
// Funkcja usuwająca przedmioty z koszyka
//
function removeFromCart() {
    include('cfg.php');
    
    $_SESSION['count'] = $_SESSION['count'] - 1;

    $product_id = $_POST['itemIdDelete'];

    $_SESSION['cart'][$product_id] = $_SESSION['cart'][$product_id] - 1;
        
    $amount = intval($_POST['itemAmountDelete']);
    
    $amount_in_db = $amount + 1;

    $status = 0;
    if($amount_in_db > 0){
        $status = 1;
    }

    $query = "UPDATE produkty SET ilosc='".$amount_in_db."', `status`='".$status."' WHERE id=".$product_id." LIMIT 1";
    $result = mysqli_query($link, $query);

    return $result;
}

//---------------------------//
// Funkcja obslugujaca sklep //
//---------------------------//
//
// Funkcja wspolpracuje z powyzszymi funkcjami cms'owymi
// Funkcja wyswietla sklep (liste prodoktow, koszyk)
//
function shop(){

    session_start();

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['itemId'])) {
            $result = addToCart();
            if ($result == 1){
                ?>
                <div class="center-message">
                <?php

                echo("Dodano produkt do koszyka");

                ?>
                <?php
            }
            else {
                ?>
                <div class="center-message">
                <?php

                echo("Nie udało się dodać produktu do koszyka");

                ?>
                <?php
            }
            exit;
        }

        if(isset($_POST['itemIdDelete'])) {
            $result = removeFromCart();
            if ($result == 1){
                ?>
                <div class="center-message">
                <?php

                echo("Usunięto produkt z koszyka");

                ?>
                <?php
            }
            else {
                ?>
                <div class="center-message">
                <?php

                echo("Niepowodzenie usuwania produktu z koszyka");

                ?>
                <?php
            }
            exit;
        }
    
    }

    showCart();
    
    sklepLista();
}

?>