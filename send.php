<?php 
if (!isset($_GET["id"])) {
  echo "no user specified";
  exit;
}
$id = $_GET["id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Send Anonymous Message</title>
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-start px-4">

  <!-- Header -->
  <h1 class="text-2xl md:text-3xl font-sans font-bold mt-6 text-center">
    Welcome to anonymous messages 🕺
  </h1>

  <!-- Send Button -->
  <button onclick="overlay.style.display='flex'" 
          class="bg-purple-800 text-white mt-20 md:mt-28 px-8 py-6 rounded-xl text-lg hover:bg-purple-400 transition-colors">
    Send anonymous message
  </button>

  <!-- Overlay Form -->
  <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg flex flex-col gap-4">
      <h2 class="text-2xl font-bold text-center mb-4">Send an Anonymous Message</h2>
      <form id="form" class="flex flex-col gap-3">
        <input type="hidden" name="id" value="<?=htmlspecialchars($id)?>">
        <textarea name="message" placeholder="Type your message here..." required maxlength="200"
                  class="p-3 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-400 resize-none"></textarea>
        <button type="submit" class="bg-purple-800 text-white p-3 rounded-md hover:bg-purple-400 transition-colors">
          Send Message
        </button>
        <button type="button" onclick="overlay.style.display='none'" class="bg-gray-300 text-gray-800 p-3 rounded-md hover:bg-gray-400 transition-colors">
          Cancel
        </button>
      </form>
      <p class="text-center text-gray-500 text-sm mt-2">This message will be sent anonymously 👻</p>
    </div>
  </div>

  <!-- Footer -->
  <p class="text-center text-gray-700 mt-6 text-lg">
    Want your own anonymous link? 
    <a href="index.php" class="text-blue-500 hover:underline">Register here</a>
  </p>

  <!-- JS -->
  <script>
    const form = document.getElementById("form");
    const overlay = document.getElementById("overlay");

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(form);

      try {
        const response = await fetch("sendval.php", {
          method: "POST",
          body: formData
        });

        if (!response.ok) {
          console.log("Error: " + response.status);
          return;
        }

        const data = await response.json();

        if (data.success) {
          alert(data.message);
          overlay.style.display = "none";
          form.reset();
        } else {
          console.log(data.message);
        }

      } catch (error) {
        console.log(error);
      }
    });
  </script>

</body>
</html>