<?php

    // Pakiet funkcji, wlaczajacych pokazywanie bledow oraz ostrzezen, przydatny w testowaniu

    // Enabling warnings and errors
    // error_reporting(-1);
    // ini_set('display_errors', 'On');
    // set_error_handler("var_dump");


    //-----------------------------------------//
    // Funkcja pokazujaca formularz kontaktowy //
    //-----------------------------------------//
    //
    // Funkcja generuje i wyswietla tabele html - formularz kontaktowy
    //
    function pokazKontakt(){
        $contact_table = 
        "
        <h2 class='cms-h2'>Napisz nową wiadomość</h2>
        <div class='contact-form'>
            <form method='post'>
                <label for='email'>Email</label>
                <input type='text' id='email' name='email' placeholder='Twój email'>

                <label for='subject'>Temat</label>
                <input type='text' id='subject' name='temat' placeholder='Temat'>
                
                <label for='body'>Treść</label>
                <textarea id='body' name='tresc' placeholder='Napisz...' style='height:400px'></textarea>
                </div>
                <div style='text-align: center;'>
                    <button class='cms-button' style='margin-top: 30px;' type='submit'>Wyślij</button>
                </div>
            </form>
        ";
        echo($contact_table);
    }

    //--------------------------------------------------//
    // Funkcja pokazujaca formularz przypomnienia hasla //
    //--------------------------------------------------//
    //
    // Funkcja generuje i wyswietla tabele html - formularz przypomnienia hasla
    //
    function przypomnijHasloKontakt(){
        $contact_pass_table = 
        "
        <h2 class='cms-h2' style='margin-top: 100px;'>Przypomij hasło</h2>
        <div class='contact-form'>
            <form method='post'>
                <label for='emailPass'>Email</label>
                <input type='text' id='emailPass' name='emailPass' placeholder='Twój email do przypomnienia hasła'>
                </div>
                <div style='text-align: center;'>
                    <button class='cms-button' style='margin-top: 30px;' type='submit'>Wyślij hasło</button>
                </div>
            </form>
        ";
        echo($contact_pass_table);
    }

    //--------------------------//
    // Funkcja wysylajaca maile //
    //--------------------------//
    //
    // Funkcja wspolpracuje z funkcja " pokazKontakt() "
    // Funkcja pobiera w argumencie adres e-mail do administratora
    // i wysyla mail, wypelniony trescia z formularza kontaktowego (funkcji " pokazKontakt() ")
    //
    function wyslijMailKontakt($odbiorca){

        if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email']))
        {
            return 0;
        }
        else
        {
            $mail['subject'] = $_POST['temat'];
            $mail['body'] = $_POST['tresc'];
            $mail['sender'] = $_POST['email'];
            $mail['reciptient'] = $odbiorca;

            $header = "From: Formularz kontaktowy <".$mail['sender'].">\n";
            $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\n";
            $header .= "X-Sender: <".$mail['sender'].">\n";
            $header .= "X-Mailer: PRapWWW mail 1.2\n";
            $header .= "X-Priority: 3\n";
            $header .= "Return-Path: <".$mail['sender']."\n";

            // Warunki do testowania, czy mail zostal wyslany

            // if(mail($mail['reciptient'], $mail['subject'], $mail['body'], $header)){
            //     echo("Wiadomość wysłana");
            // }
            // else
            // {
            //     echo("Wiadomość NIE wysłana");
            // }
            
            mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);
            return 1;

        }
    }

    //-----------------------------------//
    // Funkcja wysylajaca maile z haslem //
    //-----------------------------------//
    //
    // Funkcja wspolpracuje z funkcja " przypomnijHasloKontakt() "
    // Funkcja wysyla mail z haslem do konta administratora na adres,
    // podany w formularzu do przypominania hasla (funkcji " przypomnijHasloKontakt() ")
    //
    function przypomnijHaslo(){

        include('cfg.php');

        if (empty($_POST['emailPass']))
        {
            return 0;
        }
        else
        {
            $mail['subject'] = "Przypomnienie hasla";
            $mail['body'] = "Haslo do konta adminisratora: ".$pass."";
            $mail['sender'] = $admin_mail;
            $mail['reciptient'] = $_POST['emailPass'];

            $header = "From: Formularz kontaktowy <".$mail['sender'].">\n";
            $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\n";
            $header .= "X-Sender: <".$mail['sender'].">\n";
            $header .= "X-Mailer: PRapWWW mail 1.2\n";
            $header .= "X-Priority: 3\n";
            $header .= "Return-Path: <".$mail['sender']."\n";

            // Warunki do testowania, czy mail zostal wyslany

            // if(mail($mail['reciptient'], $mail['subject'], $mail['body'], $header)){
            //     echo("Wiadomość wysłana");
            // }
            // else
            // {
            //     echo("Wiadomość NIE wysłana");
            // }

            mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);
            return 1;
        }
    }

    //-------------------------------------------//
    // Funkcja obslugujaca formularze kontaktowe //
    //-------------------------------------------//
    //
    // Funkcja wspolpracuje z funkcjami " pokazKontakt() " i " przypomnijHasloKontakt() "
    // Funkcja wyswietla formularz kontaktowy oraz formularz do przypomnienia hasla
    // i obsluguje przyciski wysylania maili oraz wysyla (badz nie) maile
    //
    function panelKontaktowy(){

        include('cfg.php');

        $location = "http://localhost/projekt/index.php?idp=998";
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            if(isset($_POST['email'])) {
                $result = wyslijMailKontakt($admin_mail);
                if ($result == 1){
                    echo "<script>";
                    echo 'alert("Wiadomosc wysłano.");';
                    echo "window.location.href = `$location`;";
                    echo "</script>";
                }
                else {
                    echo "<script>";
                    echo 'alert("Uzupełnij pole Email/Temat/Treść.");';
                    echo "window.location.href = `$location`;";
                    echo "</script>";
                }
                exit;
            }

            if(isset($_POST['emailPass'])) {
                $result = przypomnijHaslo();
                if ($result == 1){
                    echo "<script>";
                    echo 'alert("Wiadomosc wysłano.");';
                    echo "window.location.href = `$location`;";
                    echo "</script>";
                }
                else {
                    echo "<script>";
                    echo 'alert("Uzupełnij pole Email.");';
                    echo "window.location.href = `$location`;";
                    echo "</script>";
                }
                exit;
            }
        }

        pokazKontakt();
        przypomnijHasloKontakt();

    }

?>
