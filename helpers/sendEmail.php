<?php
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($recipient, $subject, $message, $filePath, $name_file) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'estradaisaac168@gmail.com'; // Replace with your email
        $mail->Password   = 'uimycmxvllhcepqp'; // Use an App Password from Google
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('estradaisaac168@gmail.com', 'Chatbot RRHH');
        $mail->addAddress($recipient);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->addAttachment($filePath, $name_file); 

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Error sending email: {$mail->ErrorInfo}";
    }
}
?>
