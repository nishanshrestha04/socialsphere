<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

function sendVCode($email, $subject, $vCode)
{
    global $mail;
    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = "spheresocial0@gmail.com";
        $mail->Password   = "wvqs azbk xkmt ouow";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('spheresocial0@gmail.com', 'Social Sphere');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        if ($subject == 'Verify Your Email') {
            $mail->Body    = '<html><body style="font-family: Verdana, Geneva, sans-serif; color: black; line-height: 1.6;">';
            $mail->Body   .= '<h1 style="text-align:center; color:#ffa827; letter-spacing: .25rem;">Social Sphere</h1>';
            $mail->Body   .= '<p>Dear user,</p>';
            $mail->Body   .= '<p>Thank you for registering with Social Sphere. Please use the following code to verify your email address:</p>';
            $mail->Body   .= '<div style="text-align: center; margin: 20px 0;">';
            $mail->Body   .= '<span style="display: inline-block; padding: 10px 20px; widht:100px; background-color:#ccc; font-size: 24px; letter-spacing: 2.4px; font-weight:bold;">' . $vCode . '</span>';
            $mail->Body   .= '</div>';
            $mail->Body   .= '<p>If you did not request this verification, please ignore this email.</p>';
            $mail->Body   .= '<p>Best regards,<br>Social Sphere Team</p>';
            $mail->Body   .= '</body></html>';
        } elseif ($subject == 'Reset your password') {
            $mail->Body    = '<html><body style="font-family: Verdana, Geneva, sans-serif; color: black; line-height: 1.6;">';
            $mail->Body   .= '<h1 style="text-align:center; color:#ffa827; letter-spacing: .25rem;">Social Sphere</h1>';
            $mail->Body   .= '<p>Dear user,</p>';
            $mail->Body   .= '<p>We received a request to reset your password. Please use the following code to reset your password:</p>';
            $mail->Body   .= '<div style="text-align: center; margin: 20px 0;">';
            $mail->Body   .= '<span style="display: inline-block; padding: 10px 20px; widht:100px; background-color:#ccc; font-size: 24px; letter-spacing: 2.4px; font-weight:bold;">' . $vCode . '</span>';
            $mail->Body   .= '</div>';
            $mail->Body   .= '<p>If you did not request a password reset, please ignore this email.</p>';
            $mail->Body   .= '<p>Best regards,<br>Social Sphere Team</p>';
            $mail->Body   .= '</body></html>';
        }
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
