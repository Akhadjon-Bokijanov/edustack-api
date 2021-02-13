<?php


namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailSender
{

    public static function sendVerificationCode(int $code, string $email, string $name=""){
        try {

            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output OFF
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'akhadjan2000@gmail.com';                     // SMTP username
            $mail->Password   = 'A3913556b';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            $mail->setFrom("abokijanov@students.wiut.uz", "EduStack mailer");
            $mail->addAddress($email, $name);

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'EduStack.uz verification code';
            $mail->Body    = 'Hello '.$name.',<br/>Code: <b>'.$code.'</b>';
            $mail->AltBody = 'Hello '.$name.'. Code: '.$code;

            $mail->send();

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

}
