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
    die("Connection failed: " . $e->getMessage());
} 
 

 /*$host = '127.0.0.1'; // or 'localhost'
$db   = "anonymous";
$user = 'postgres'; // default postgres user
$pass = '1234'; // your local postgres password
$port = '5432'; // default PostgreSQL port

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);

    // Error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch mode
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}   
?> */
