<?php
 include "db.php";
$token = $_GET['token'] ?? null;

if (!$token && $_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Token is missing";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPass = $_POST['password'] ?? '';
    $confirmPass = $_POST['confirm_password'] ?? '';
    $token = $_POST['token'] ?? '';

    if ($newPass !== $confirmPass) {
        echo  "Passwords do not match";
        exit;
    }

    // 1. Get email from reset table
    $sql = "SELECT email, expire FROM reset WHERE token = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
    echo  "DB query failed";
    exit;
}
    if (!$stmt->execute($token)) {
    echo  "DB execution failed";
    exit;
}
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (count($row) === 0) {
        echo  "Invalid token";
        exit;
    }

    $expire = strtotime($row['expire']);
    if ($expire < time()) {
        echo  "Token has expired";
        exit;
    }

    $email = $row['email'];
    // 2. Update password
    $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
    $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");

    if ($update->execute([$hashedPass, $email])) {
        // 3. Delete used token
        $delete = $conn->prepare("DELETE FROM reset WHERE token = ?");
        $delete->execute($token);
        echo  "Password updated successfully";
    } else {
        echo  "Failed to update password";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Password</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/png" href="anon.png">
  <style>
    * {
      box-sizing: border-box;
      font-family: sans-serif;
    }

    body {
      background: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }
    .form-container {
      background: #fff;
      padding: 30px 25px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #444;
    }

    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #4a90e2;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background: #3a76c3;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Reset Your Password</h2>
    <form method="POST" action="update_pass.php">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

      <label for="password">New Password</label>
      <input type="password" id="password" name="password" required>

      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" required>

      <button type="submit">Update Password</button>
    </form>
  </div>
</body>
</html>
