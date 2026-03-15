<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

   include "dbjson.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Go to the login page"]);
    exit;
}

$email = $_POST["email"];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Input valid email"]);
    exit;
}

// Check if user exists
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "DB query failed"]);
    exit;
}

if (!$stmt->execute([$email])) {
    echo json_encode(["success" => false, "message" => "DB execution failed"]);
    exit;
}
$results = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$results) {
    echo json_encode(["success" => false, "message" => "User does not exist"]);
    exit;
}


// All clear: create new reset token
$token = bin2hex(random_bytes(32));
$expire = date("Y-m-d H:i:s", strtotime("+1 hour"));

$sql1 = "INSERT INTO reset(email, token, expire) VALUES (?, ?, ?)";
$stmt1 = $conn->prepare($sql1);
if (!$stmt1) {
    echo json_encode(["success" => false, "message" => "DB query failed"]);
    exit;
}
if (!$stmt1->execute([$email, $token, $expire])) {
    echo json_encode(["success" => false, "message" => "DB execution failed"]);
    exit;
}
   try {
    // smtp settings 
    $mail = new PHPMailer(true);
            $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'fawasdiamond2007@gmail.com';
        $mail->Password = 'zmku wone skum zzpk'; // app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Email setup
        $mail->setFrom('fawasdiamond2007@gmail.com', "Diamond");
        $mail->addAddress($email);

         $mail->isHTML(true);
         $mail->Subject = "Reset your password";
$resetLink = "https://anonymous.pxxl.click/reset.php?token=$token";

$mail->Body = "
    <h2>Password Reset</h2>
    <p>Click the button below to reset your password:</p>
    <a href='$resetLink' style='
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        margin-top: 10px;
    '>Reset Password</a>
    <p>If you didn’t request this, just ignore it.</p>
";
  $mail->send();
    echo json_encode([
    "success" => true,
    "message" => "Reset link has been sent to the email you provided",
]);
   } catch (\Throwable $th) {
    echo json_encode([
    "success" => false,
    "message" => "Message could not be sent. Mailer Error : $mail->ErrorInfo",
]);
   }
?>