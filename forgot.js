 console.log("dom loaded")
 let form = document.getElementById("form")
 let errorbox = document.getElementById("errorBox")
 //let message = document.getElementById("message")
let resetDiv = document.getElementById("resetDiv")
 let resetlink = document.getElementById("resetlink")
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
            resetDiv.style.display = "block"
            resetlink.textContent= `click here to reset`
            resetlink.href= data.resetLink
            return
        }else{
            errorbox.textContent = data.message
            errorbox.style.display = "block"
        }
    } catch (error) {
        errorbox.textContent = error
        errorbox.style.display = "block"
    }
  }