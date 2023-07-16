<?php

use Dotenv\Dotenv;
use App\services\Env;
use App\services\PostGlobal;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
require '../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable('../../');
$dotenv->load();


if (null !==PostGlobal::get('firstname') && null !==PostGlobal::get('name') && null !==PostGlobal::get('email')
     && null !==PostGlobal::get('message') && null !==PostGlobal::get('name')
    && !empty(PostGlobal::get('firstname')) && !empty(PostGlobal::get('email'))
    && !empty(PostGlobal::get('message'))
) {
        $firstname = strip_tags(trim(PostGlobal::get('firstname')));
        $name = strip_tags(trim(PostGlobal::get('name')));
        $message = strip_tags(trim(PostGlobal::get('message')));
        $email = strip_tags(trim(PostGlobal::get('email')));

        // PHPMailer configuration
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = Env::get('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = Env::get('MAIL_USERNAME');
        $mail->Password = Env::get('MAIL_PASSWORD');
        $mail->SMTPSecure = Env::get('MAIL_SMTPSECURE');
        $mail->Port = Env::get('MAIL_PORT');
        $mail->setFrom(PostGlobal::get('email'), $name);
        $mail->addAddress(Env::get('MAIL_DESTINATION'));
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64'; 
        $mail->Subject = 'Un message de mon blog';
        $mail->WordWrap = 20;
        $mail->Body = "Name: $name\n\nEmail: $email\n\nMessage: $message";

    if (!$mail->send()) {
        throw new \Exception('Mail non envoyé, veuillez réessayer');
    } else {
        ?>
        <script language="javascript"> 
        alert("Merci de m\'avoir contactée. Je vous répondrai très bientôt.");
        document.location.href = '../../';</script>
        <?php
    }
} else {
    ?>
    <script language="javascript"> 
    alert("Merci de remplir tous les champs !");
    document.location.href = '../../';</script>
    <?php
}
