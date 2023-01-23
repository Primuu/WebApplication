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
            echo "<script>";
            echo 'alert("Widok tylko dla administratora.");';
            echo "window.location.href = http://localhost/projekt/?idp=1;";
            echo "</script>";
        }

        // Jesli uzytkownik jest zalogowany, zostaje wyswietlony mu panel zarzadzania sklepem
        if($_SESSION['loggedIn'] == 1) {

            // Stworzenie panelu z przyciskami
            $panel = '
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

            // Wyswietlenie panelu
            echo($panel);
        }
    }

?>