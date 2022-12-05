<?php
    // Enabling warnings and errors
    
    // error_reporting(-1);
    // ini_set('display_errors', 'On');
    // set_error_handler("var_dump");

    function pokazKontakt(){
        $contact_table = 
        "
        <h2 class='cms-h2'>Napisz nową wiadomość:</h2>
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

    function przypomnijHasloKontakt(){
        $contact_pass_table = 
        "
        <h2 class='cms-h2' style='margin-top: 100px;'>Przypomij hasło:</h2>
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

    function wyslijMailKontakt($odbiorca){

        if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email']))
        {
            echo("Nie wypełniłeś pola");
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

            // if(mail($mail['reciptient'], $mail['subject'], $mail['body'], $header)){
            //     echo("Wiadomość wysłana");
            // }
            // else
            // {
            //     echo("Wiadomość NIE wysłana");
            // }
            
            mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);
            echo("Wiadomość wysłana");
        }
    }

    function przypomnijHaslo(){

        include('cfg.php');

        if (empty($_POST['emailPass']))
        {
            echo("Nie wypełniłeś pola");
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

            // if(mail($mail['reciptient'], $mail['subject'], $mail['body'], $header)){
            //     echo("Wiadomość wysłana");
            // }
            // else
            // {
            //     echo("Wiadomość NIE wysłana");
            // }

            mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);
            echo("Wiadomość wysłana");
        }
    }

    function panelKontaktowy(){

        include('cfg.php');

        pokazKontakt();
        przypomnijHasloKontakt();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            if(isset($_POST['email'])) {
                wyslijMailKontakt($admin_mail);
                exit;
            }
            if(isset($_POST['emailPass'])) {
                przypomnijHaslo();
                exit;
            }
        }
    }

?>
