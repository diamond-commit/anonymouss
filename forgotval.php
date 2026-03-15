<?php
include "dbjson.php";

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

// Generate token and expiry
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

// Instead of sending email, return JSON with link
try{
$resetLink = "https://anonymous.pxxl.click/reset.php?token=$token";
echo json_encode([
    "success" => true,
    "message" => "Reset link generated!",
    "resetLink" => $resetLink
]);

} catch (\Throwable $th) {
    echo json_encode([
    "success" => false,
    "message" => "Message could not be sent. Mailer Error : $mail->ErrorInfo",
]);
   }
?>