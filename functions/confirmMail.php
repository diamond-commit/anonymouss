 <?php

require_once   __DIR__ .  '/../PHPMailer/PHPMailer.php';
require_once   __DIR__ . '/../PHPMailer/SMTP.php';
require_once   __DIR__ . '/../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $token, $resetLink){
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'fawasdiamond2007@gmail.com'; // your Gmail
    $mail->Password = 'rfwoefnxgpvbyjmq'; // generated app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port =465;

    $mail->setFrom('fawasdiamond2007@gmail.com', 'Anonymous App');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Email confirmation';
    $mail->Body = "
    <html>
    <head>
      <style>
        .btn {
          display: inline-block;
          padding: 12px 24px;
          background-color: #7c3aed;
          color: white;
          text-decoration: none;
          border-radius: 6px;
          font-weight: bold;
          font-size: 16px;
        }
        .container {
          font-family: Arial, sans-serif;
          line-height: 1.6;
          color: #333333;
          padding: 20px;
        }
        h2 {
          color: #7c3aed;
        }
      </style>
    </head>
    <body>
      <div class='container'>
        <h2>Email confirmation Request</h2>
        <p>Hello,</p>
        <p>We need to confirm this is your email. Click the button below to conirm it's ur email:</p>
        <p><a href='$resetLink' class='btn'>confrim email</a></p>
        <p>If you didn’t request this, just ignore this email.</p>
        <p>— Anonymous App Team</p>
      </div>
    </body>
    </html>
    ";

    $mail->send();
   return true;

} catch (Exception $e) {
 return false;   
}
  }
  ?>