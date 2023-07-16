<?php

use Dotenv\Dotenv;
use App\services\Env;
use App\services\PostGlobal;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
require '../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable('../../');
$dotenv->load();


if (null !==PostGlobal::get('firstname') && null !==PostGlobal::get('surname') && null !==PostGlobal::get('email')
    && null !==PostGlobal::get('object') && null !==PostGlobal::get('message') && null !==PostGlobal::get('surname')
    && !empty(PostGlobal::get('firstname')) && !empty(PostGlobal::get('email'))
    && !empty(PostGlobal::get('object')) && !empty(PostGlobal::get('message'))
) {
        $firstname = strip_tags(trim(PostGlobal::get('firstname')));
        $surname = strip_tags(trim(PostGlobal::get('surname')));
        $name = $firstname." ".$surname;
        $object = strip_tags(trim(PostGlobal::get('object')));
        $message = strip_tags(trim(PostGlobal::get('message')));

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host ='smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = Env::get('MAIL_ADD');
        $mail->Password = Env::get('MAIL_PASS');
        $mail->SMTP ='tls';
        $mail->Port = 587;
        $mail->setFrom(Env::get('MAIL_ADD'), $name);
        $mail->addReplyTo(PostGlobal::get('email'));
        $mail->addAddress(Env::get('MAIL_SEND'));
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->Subject = $object;
        $mail->WordWrap = 20;
        $mail->Body = $message;

    if (!$mail->send()) {
        throw new \Exception('Mail non envoyé !');
    } else {
        ?>
        <script language="javascript"> 
        alert("Merci de m\'avoir contactée. Je vous répondrai très bientôt.");
        document.location.href = '../../index.php?';</script>
        <?php
    }
} else {
    ?>
    <script language="javascript"> 
    alert("Vous devez remplir tous les champs !");
    document.location.href = '../../index.php?';</script>
    <?php
}
