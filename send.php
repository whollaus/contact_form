<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

header('Content-type:application/json;charset=utf-8');

// Eingabe der Pflichfelder überprüfen - Fehler wenn ungültig
if (empty($_POST["firstname"]) or empty($_POST["lastname"]) or empty($_POST["email"]) or empty($_POST["message"]) or empty($_POST["privacy_checkbox"])) {
    http_response_code(500);
    exit();
}

// Eingabe ob die angegebene E-Mail Adresse gültig ist - Fehler wenn ungültig
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    http_response_code(500);
    exit();
}

// PHPMailer Klassen einbinden
require 'PHPMailer.php';
require 'SMTP.php';

//Erstelle eine Instanz der PHPMailer Klasse
$mail = new PHPMailer(false);

//Mail Server Einstellungen
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Ausführliche Debug-Ausgabe einschalten
$mail->isSMTP();                                            //Senden über SMTP
$mail->Host = 'xxxxxxxxxxx';                     //SMTP-Servers
$mail->SMTPAuth = true;                                   //SMTP-Authentifizierung einschalten
$mail->Username = 'xxxxxxxxxxx';                     //SMTP Benutzer
$mail->Password = 'xxxxxxxxxxx';                               //SMTP Passwort
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //TLS-Verschlüsselung aktivieren
$mail->Port = 465;                                    //SMTP Port 465 bei SSL bzw. 587 bei STARTTLS

//Absender - Die E-Mail Adresse sollte/muss die gleiche Domain wie der SMTP Server haben / Je nach SPF Einstellungen...
$mail->setFrom('xxxxxxxxxxx@xxxxxxxxxxx.xx', 'Max Muster');

// Empfänger
$mail->addAddress('xxxxxxxxxxx@xxxxxxxxxxx.xx', 'Max Muster');

// Antwort Adresse = Adresse der Formulareingabe
$mail->addReplyTo($_POST['email'], $_POST['lastname'] . ' ' . $_POST['firstname']);

// E-Mail Betreff
$mail->Subject = 'xxxxxxxxxxx xxxxxxxxxx';

//E-Mail Inhalt
$mail->isHTML(false);
$mail->CharSet = 'UTF-8';
$mail->Body = <<<EOT
Firma: {$_POST['company']}
Vorname: {$_POST['firstname']}
Nachname: {$_POST['lastname']}
E-Mail: {$_POST['email']}
Telefon: {$_POST['phone']}
Nachricht: {$_POST['message']}
EOT;

// Sende die E-Mail
if (!$mail->send()) {
    http_response_code(500);
} else {
    http_response_code(200);
}

exit();
