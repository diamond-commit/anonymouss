<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <link rel="icon" href="images/anon.png" type="image/x-icon">
  
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">

  <!-- Container -->
<div class="flex flex-col gap-2">
  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
    <form id="form" class="flex flex-col gap-4">
      <h2 class="text-2xl text-center text-gray-800 font-semibold">Forgot Password</h2>
      <p class="text-center text-gray-600 text-sm">Enter your email and we’ll send a reset link</p>

      <!-- Message box for errors/success -->
      <div id="errorBox" class="hidden text-red-600 text-sm text-center"><p></p></div>

      <input type="email" id="email" name="email" placeholder="Email address" required
             class="p-3 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-400">

      <button type="submit"
              class="p-3 bg-purple-800 text-white rounded-md text-lg hover:bg-purple-400 transition-colors">
        Send Reset Link
      </button>
    </form>
  </div>
   
   
</div>

</body>
<script src="js/forgot.js"></script>
</html>