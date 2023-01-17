<?php

    //---------------------------------//
    // Funkcja zwracajaca panel sklepu //
    //---------------------------------//
    //
    // Funkcja generuje i zwraca panel zarzadzania sklepem
    //
    function panelSklepu()
    {
        include('cfg.php');

        // Jesli uzytkownik nie jest zalogowany, zostaje wyswietlony mu komunikat o dostepnosci
        if($_SESSION['loggedIn'] != 1) {

            ?>
            <div class="center-message">
            <?php

            echo("Dostęp tylko dla administratora");

            ?>
            <?php
        }

        // Jesli uzytkownik jest zalogowany, zostaje wyswietlony mu panel zarzadzania sklepem
        if($_SESSION['loggedIn'] == 1) {
            $wynik = '
            <div>
                <h1>Opcje</h1>
                <div>
                    <table>
                        <tr>
                            <td>
                                <button class="admin-button" style="margin-top: 20px;">
                                    <a href="?idp=1001">
                                    Zarządzaj Kategoriami
                                    </a>
                                </button>
                            </td>
                        </tr>
                        <tr >
                            <td>
                                <button class="admin-button" style="margin-top: 20px;">
                                    <a href="?idp=1002">
                                    Zarządzaj Produktami
                                    </a>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            ';
            echo($wynik);
        }
    }

?>