<?php 
   include "db.php";
  session_start();
  if (!isset($_SESSION["id"])) {
    header("Location: login.php");
}
  $user_id = $_SESSION["id"];
  
   $nameSql = "SELECT name FROM users WHERE id = ?";
$nameStmt = $conn->prepare($nameSql);
if(!$nameStmt){
        die("failedee");
    }
if(!$nameStmt->execute([$user_id])){
        die("Failed to execute");
    }
$nameRow = $nameStmt->fetch(PDO::FETCH_ASSOC);
if(count($nameRow) ==0){
        die("user not found");
    }

 
$sql = "SELECT inbox.id AS inbox_id, message 
        FROM inbox 
        WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if(!$stmt){
        die("failed");
    }
    if(!$stmt->execute([$user_id])){
        die("Failed to execute");
    }
    $results = $stmt->fetchAll(pdo::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
    <link rel="icon" href="anon.png" type="image/png">
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-yellow-100 min-h-screen flex flex-col items-center">

  <!-- Header -->
  <header class="w-full bg-gray-900 text-white py-6 text-center">
    <h1 class="text-3xl md:text-5xl font-sans font-bold">
      Welcome back, <?=htmlspecialchars($nameRow["name"])?>
    </h1>
  </header>

  <!-- Main Content -->
  <main class="w-11/12 max-w-3xl mt-6 flex flex-col gap-4 mb-24">
    <?php if (count($results) > 0): ?>
      <?php foreach($results as $row): ?>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between bg-white p-4 rounded-xl shadow-md transition hover:shadow-lg">
          <p class="text-gray-800 text-base md:text-lg break-words mb-2 md:mb-0">
            <?= htmlspecialchars($row["message"]) ?>
          </p>
          <button  data-id="<?= htmlspecialchars($row["inbox_id"]) ?>"
                  class="delete bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded-md text-sm md:text-base transition">
            Delete
          </button>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-gray-600 text-lg md:text-2xl mt-8">
        No messages yet... 😴
      </p>
    <?php endif; ?>
  </main>

  <!-- Copy Link Button -->
  <div class="fixed bottom-6 md:bottom-8 w-full flex justify-center">
    <button id="share" class="bg-gray-900 hover:bg-gray-700 text-white py-2 px-6 md:py-3 md:px-8 rounded-full text-lg transition">
      Copy Link
    </button>
  </div>

  <!-- Hidden Input for Link -->
  <input type="hidden" id="link" value="https://anonymous.pxxl.click/send.php?id=<?= htmlspecialchars($_SESSION['id']) ?>">

  <!-- JS -->
  <script src="dashboard.js"></script>
</body>
</html>