<?php
include "../config/dbjson.php"; // your PDO connection

require "../functions/resetMail.php"; // the send mail function is in here 

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Go to the login page"]);
    exit;
}

$email = $_POST["email"] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Input a valid email"]);
    exit;
}

// Check if user exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
if (!$stmt) exit(json_encode(["success"=>false,"message"=>"DB query failed"]));
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) exit(json_encode(["success"=>false,"message"=>"User does not exist"]));
 

// Generate token and expiry
$token = bin2hex(random_bytes(32));
$expire = date("Y-m-d H:i:s", strtotime("+1 hour"));

$stmt = $conn->prepare("INSERT INTO reset(email, token, expire) VALUES (?, ?, ?)");
if (!$stmt->execute([$email, $token, $expire, ])) {
    exit(json_encode(["success"=>false,"message"=>"DB execution failed"]));
}

  $resetLink = "https://anonymous.pxxl.click/auth/reset.php?token=$token";
   //$resetLink = "http://localhost/anonymous/auth/reset.php?token=$token";


// Send email via Gmail SMTP
   if( sendMail($email, $token, $resetLink)){
echo json_encode(["success"=> true, "message"=> "Email has been sent successfully"]);
exit;
  }else{
   echo json_encode(["success"=> false, "message"=> "Email has not been sent successfully"]);
   exit;
  }