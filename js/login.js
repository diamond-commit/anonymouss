 console.log("dom loaded")
  let form = document.getElementById("form")
  let errorbox = document.getElementById("errorBox")
  let loader = document.getElementById("loader")
  form.addEventListener("submit", function(e){
    e.preventDefault()
    loader.style.display = "flex"
    let formData = new FormData(form)
    send(formData)
  })
     async function send(formData) {
        try {
            let response = await fetch("/anonymous/auth/logval.php", {
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
            window.location.href = data.redirect
            }else{
                loader.style.display = "none"
            errorbox.textContent = data.message
            errorbox.style.display = "block"
            return
            }
        } catch (error) {
          loader.style.display = "none"
        errorbox.textContent = error
        errorbox.style.display = "block"
        }
     }