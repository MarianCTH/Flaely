<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strip_tags(trim($_POST["name"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $subject = trim($_POST["subject"]);
        $message = trim($_POST["message"]);

        if ( empty($name) OR empty($subject) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo "Vă rugăm să completați formularul și să încercați din nou.";
            exit;
        }
        $recipient = "office@flaely.com";
        $subjectname = "Subiect: $subject";

        $email_content = "Trimis de : $name , de pe email-ul: $email \r\n\n";
        $email_content .= "Subiect: $subject \r\n\n";
        $email_content .= "Mesaj: $message \r\n\n";

        $email_headers = "From: $name <$email>";

        if (mail($recipient, $subjectname, $email_content, $email_headers)) {
            http_response_code(200);
            echo "Mulțumesc! Mesajul tau a fost trimis.";
        } else {
            http_response_code(500);
            echo "Oops! Ceva nu a mers bine și nu am putut trimite mesajul.";
        }

    } 
    else {
        http_response_code(403);
        echo "A apărut o problemă cu trimiterea dvs., vă rugăm să încercați din nou.";
    }

?>