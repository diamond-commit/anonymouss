<?php 
include "../config/dbjson.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success"=> false, "message"=> "Invalid request"]);
    exit;
}

//  validate inputs
if (!isset($_POST["message"], $_POST["name"])) {
    echo json_encode(["success"=> false, "message"=> "Missing fields"]);
    exit;
}

$message = trim($_POST["message"]);
$name = trim($_POST["name"]);

//  get user by username
$sqlToGetUser = "SELECT * FROM users WHERE name = ?";
$preparesql = $conn->prepare($sqlToGetUser);

if (!$preparesql) {
    echo json_encode(["success"=> false, "message" => "Prepare failed"]);
    exit;
}

if (!$preparesql->execute([$name])) {
    echo json_encode(["success"=> false, "message" => "Execute failed"]);
    exit;
}

$userInfo = $preparesql->fetch(PDO::FETCH_ASSOC);

if (!$userInfo) {
    echo json_encode(["success"=> false, "message"=> "User does not exist"]);
    exit;
}

$id = $userInfo["id"];
   // insert message into inbox 
$sql = "INSERT INTO inbox (message, user_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["success"=> false, "message" => "Insert prepare failed"]);
    exit;
}

if (!$stmt->execute([$message, $id])) {
    echo json_encode(["success"=> false, "message" => "Insert failed"]);
    exit;
}

echo json_encode(["success"=> true, "message" => "Message sent successfully"]);

$conn = null;
?>