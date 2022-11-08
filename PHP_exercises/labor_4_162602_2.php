<?php
    $nr_indeksu = '162602';
    $nrGrupy ='2';

    echo 'Adam Trentowski'.$nr_indeksu.' grupa '.$nrGrupy.'<br /><br />';
    
    echo 'Zastosowanie metody include() <br />';
    include 'inny_plik.php';
    echo "To są $dane_z_innego_pliku";
    
    echo '<br /><br />Zastosowanie metody require_once() <br />';
    require_once 'inny_plik2.php';
    echo "To są $dane_z_innego_pliku2";

    echo '<br /><br />Warunki if, else, elseif, switch <br />';
    $zmienna1 = 5;
    $zmienna2 = 6;
    if ($zmienna1 > $zmienna2)
    echo 'Zmienna1 jest większa od zmiennej2';
    elseif ($zmienna1 < 4)
    echo 'Zmienna1 jest mniejsza od 4';
    else
    echo 'Niewiadomo co';

    echo '<br /><br />Warunki if, else, elseif, switch <br />';
    $i = 1;
    switch ($i) {
        case 0:
            echo 'i = 0';
            break;
        case 1:
            echo 'i = 1';
            break;
        case 2:
            echo 'i = 2';
            break;
        default:
            echo 'i nie jest równe 0, 1 ani 2';
    }

    echo '<br /><br />Pętla while() i for() <br />';
    while ($i <= 10) {
        echo $i++;
    }
    echo '<br />';
    for ($j = 1; $j <= 10; $j++) {
        echo $j;
    }

    echo '<br /><br />Typy zmiennych  $_GET, $_POST, $_SESSION <br />';
    echo '<br /><br />Po url dopisz /name=Adam <br />';
    echo 'Cześć ' . htmlspecialchars($_GET["name"]) . '!';
?>
