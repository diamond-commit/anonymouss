<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register here </title>
  <!-- Tailwind CDN -->
     <script src="https://cdn.tailwindcss.com"></script>

   <meta property="og:title" content="Send anonymous messages to friends or family">
<meta property="og:description" content="Drop a message anonymously 👀">
<meta property="og:image" content="https://anonymous.pxxl.click/images/anony.jpeg">
<meta property="og:url" content="https://anonymous.click">
 

</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-start">

  <!-- Header -->
  <h1 class="text-xl mt-4 md:text-3xl font-sans text-black font-bold">
    Welcome to anonymous messages 🕺
  </h1>

  <!-- Container -->
  <div class="bg-white mt-8 p-8 rounded-xl shadow-md w-11/12 max-w-md">
    <h2 class="text-2xl text-center text-gray-800 mb-6 font-semibold">Create Account</h2>

    <!-- Form -->
    <form id="form" class="flex flex-col gap-4">
      <input type="text" name="name" placeholder="Your Name" required
             class="p-3 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-400">
      <input type="email" name="email" placeholder="Email Address" required
             class="p-3 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-400">
      <input type="password" id="password" name="password" placeholder="Create Password" required
             class="p-3 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-400">
      <input type="password" id="confirm" placeholder="Confirm Password" required
             class="p-3 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-400">
      <button type="submit" id="submit"
              class="p-3 bg-purple-800 text-white rounded-md text-lg hover:bg-purple-400 transition-colors">
        Register
      </button>
    </form>

    <!-- Footer -->
    <div class="text-center text-gray-600 text-sm mt-4">
      Already have an account? 
      <a href="login.php" class="text-blue-500 hover:underline">Login</a>
    </div>
  </div>

  <!-- Loader -->
  <div id="loader" class="fixed inset-0 bg-white bg-opacity-70 flex items-center justify-center hidden">
    <div class="w-6 h-6 border-4 border-gray-300 border-t-black rounded-full animate-spin"></div>
  </div>

  <!-- Error Box -->
  <div id="errorBox" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-md text-center mt-4 w-11/12 max-w-md"></div>

  <!-- JS -->
  <script src="js/register.js"></script>

</body>
</html>