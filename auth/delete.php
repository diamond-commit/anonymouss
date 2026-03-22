<?php
   include "../config/dbjson.php";
session_start();

if (!isset($_SESSION["id"])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

if (!isset($_GET["id"])) {
    echo json_encode(["status" => "error", "message" => "Missing message ID"]);
    exit;
}

$message_id = $_GET["id"];
$user_id = $_SESSION["id"];



// Optional: check if message belongs to this user before deleting
$sql = "DELETE FROM inbox WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Prepare failed"]);
    exit;
}

if ($stmt->execute([$message_id, $user_id])) {
    echo json_encode(["status" => "success", "message" => "Message deleted", "redirect"=> "../dashboard.php"]);
} else {
    echo json_encode(["status" => false, "message" => "Delete failed"]);
}
$conn = null;
?>