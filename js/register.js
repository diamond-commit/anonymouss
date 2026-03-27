 console.log("dom loaded")
 let subButton = document.getElementById("submit")
 let form = document.getElementById("form")
 let errorbox = document.getElementById("errorBox")
 let loader = document.getElementById("loader")
 let password = document.getElementById("password")
 let confir = document.getElementById("confirm")
 
console.log("Password:", password.value);
console.log("Confirm:", confir.value);
 form.addEventListener("submit", function(e){
     
    e.preventDefault()
    if(confir.value !== password.value){
      console.log("miss")
      errorbox.textContent="Password must match in both inputs"
     errorbox.style.display="block"
     return
    }
    loader.style.display = "flex"
   let formData = new FormData(form)
    send(formData)

 })
  async function send(formData) {
    console.log("🚀 Sending request...");

    try {
        let response = await fetch("auth/confirm_register_email.php", {
            method: "POST",
            body: formData
        });

        console.log("📡 Status:", response.status);
        console.log("🔗 URL:", response.url);

        // If server responded but with error (like 404, 500)
        if (!response.ok) {
            const text = await response.text(); // get raw response
            console.error("❌ Server error response:", text);

            errorbox.textContent = `Error: ${response.status}`;
            errorbox.style.display = "block";
            return;
        }

        // Try parsing JSON
        let data;
        try {
            data = await response.json();
        } catch (e) {
            const text = await response.text();
            console.error("❌ Not valid JSON:", text);

            errorbox.textContent = "Invalid server response";
            errorbox.style.display = "block";
            return;
        }

        console.log("✅ Response data:", data);

        if (data.success) {
            loader.style.display = "none";
            alert(data.message);

            // optional redirect
            /*
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 3000);
            */

        } else {
            loader.style.display = "none";
            errorbox.textContent = data.message;
            errorbox.style.display = "block";
            console.log("⚠️ Backend message:", data.message);
            return;
        }

    } catch (error) {
        loader.style.display = "none";
        errorbox.textContent = "Something went wrong";
        errorbox.style.display = "block";
        console.error("🔥 Fetch crashed:", error);
    }
}