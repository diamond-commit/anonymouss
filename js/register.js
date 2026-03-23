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
    try {
        let response = await fetch("/auth/confirm_register_email.php", {
            method : "POST",
            body : formData
        })
        if(!response.ok){
            errorbox.textContent = `Error : ${response.status}`
            errorbox.style.display = "block"
            return
        }
        let data = await response.json()
        if(data.success){
          loader.style.display = "none"
          alert(data.message)
          /*  setTimeout(() => {
              window.location.href = data.redirect
            }, 3000); */
             
        }else{
            loader.style.display = "none"
          errorbox.textContent = data.message
            errorbox.style.display = "block"
            console.log(data.message)
          return;
        }
    } catch (error) {
        loader.style.display = "none"
        errorbox.textContent = "sum went wrong"
        errorbox.style.display = "block"
        console.log(error)
    }
  }