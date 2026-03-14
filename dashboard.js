document.addEventListener("DOMContentLoaded", function () {
  let link = document.getElementById("link");
  let delButtons = document.querySelectorAll(".delete");
  let share = document.getElementById("share");

  share.addEventListener("click", function () {
    copyLink();
  });

  delButtons.forEach(button => {
    button.addEventListener("click", function () {
      let message_id = button.dataset.id;
      del(message_id)
    });
  });

  function copyLink() {
    const temp = document.createElement("input");
    temp.value = link.value;
    document.body.appendChild(temp);
    temp.select();
    document.execCommand("copy");
    document.body.removeChild(temp);
    alert("Link copied to clipboard!");
  }

  async function del(id) {
    try {
      let response = await fetch(`delete.php?id=${id}`);
      let data = await response.json();
      if (data.redirect) {
        window.location.href = data.redirect;
      } else {
        alert("Try deleting again")
      }
    } catch (error) {
      console.log(error);
    }
  }
});