<?php
  $host = 'db.pxxl.pro'; // or 127.0.0.1
$db   = 'pxxldb_mmqydfh965cb0f1';
$user = 'pxxluser_mmqydfh9c34d26d';
$pass = '98c4557d5ddc3d3e5a4444384c8447c7bda2076daa42dd4f329fb51a50866aae'; // replace this with your actual password
$port = '33123'; // default PostgreSQL port

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    // Set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optional: set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit;
}
   
   /*
$host = '127.0.0.1';
$db   = 'anonymous';
$user = 'postgres';
$pass = '1234';
$port = '5432';

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit;
} */

?>
