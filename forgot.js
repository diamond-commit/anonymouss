 console.log("dom loaded")
 let form = document.getElementById("form")
 let errorbox = document.getElementById("errorBox")
 let message = document.getElementById("message")
 form.addEventListener("submit", function(e){
    e.preventDefault()
    let formData = new FormData(form)
    send(formData)
 })
  async function send(formData) {
    try {
        let response = await fetch("forgotval.php", {
            method: "POST",
            body: formData
        })
        if(!response.ok){
            errorbox.textContent = `Error : ${response.status}`
            errorbox.style.display = "block"
            return
        }
        let data = await response.json()
        if(data){
            alert(data.message)
            return
        }else{
            errorbox.textContent = data.message
            errorbox.style.display = "block"
        }
    } catch (error) {
                 errorbox.textContent = "something wrong, try again later"
            errorbox.style.display = "block"
    }
  }