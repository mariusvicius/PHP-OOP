"use strick";

const addBtn = document.getElementById("add-register");
const searchBtn = document.getElementById("search");
const searchClear = document.getElementById("clear");
const closeDialog = document.getElementById("dialog-close");
const dialogbg = document.querySelector(".dialog-bg");
const actionURL =  window.location+"/includes/actions.php";

// Add new transport
addBtn.addEventListener("click", function (event) {
  event.preventDefault();

  const xhttp = new XMLHttpRequest();

  openCloseDialog("open");

  xhttp.onload = function () {
    document.getElementById("dialog-content").innerHTML = this.responseText;
    registerForm();
  };

  xhttp.open("POST", actionURL);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=newTransport");
});

// Search transport
searchBtn.addEventListener("submit", function (event) {
  event.preventDefault();
  const FD = new FormData(searchBtn);
  const xhttp = new XMLHttpRequest();
  const inputs = searchBtn.querySelectorAll(".input-text");
  let error = 0;

  for (let i = 0; i < inputs.length; i++) {
    if (inputs[i].value === "") {
      inputs[i].classList.add("error");
      error = 1;
    } else {
      inputs[i].classList.remove("error");
    }
  }

  if (error === 1) {
    return false;
  }

  xhttp.onload = function () {
    document.getElementById("register-list").innerHTML = xhttp.responseText;
    searchClear.style.display = "block";
  };

  xhttp.open("POST", actionURL);
  xhttp.send(FD);
});

// Clear search bar
searchClear.addEventListener("click", function (event) {
  event.preventDefault();

  const xhttp = new XMLHttpRequest();

  xhttp.onload = function () {
    document.getElementById("register-list").innerHTML = this.responseText;
    searchClear.style.display = "none";
    document.getElementById("search-text-input").value = "";
  };

  xhttp.open("POST", actionURL);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=updatelist");
});

// close dialog
dialogbg.addEventListener("click", function () {
  openCloseDialog("close");
  document.getElementById("dialog-content").innerHTML = "";
});

closeDialog.addEventListener("click", function () {
  openCloseDialog("close");
  document.getElementById("dialog-content").innerHTML = "";
});

/*
 ****
 ****
 **** Functions
 ****
 ****
 ****
 */
function edittransport(el) {
  // Edit transport
  const main = el.closest(".transport-row");
  const id = main.getAttribute("data-id");
  const xhttp = new XMLHttpRequest();

  openCloseDialog("open");

  xhttp.onload = function () {
    document.getElementById("dialog-content").innerHTML = this.responseText;
    registerForm();
  };

  xhttp.open("POST", actionURL);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=edittransport&id=" + id);
}

function removetransport(el) {
  const main = el.closest(".transport-row");
  const id = main.getAttribute("data-id");
  const xhttp = new XMLHttpRequest();

  openCloseDialog("open");

  xhttp.onload = function () {
    document.getElementById("dialog-content").innerHTML = this.responseText;
    registerForm();
  };

  xhttp.open("POST", actionURL);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=deletetransport&id=" + id);
}

function registerForm() {
  const formSubmit = document.getElementById("register-form");
  formSubmit.addEventListener("submit", function (event) {
    event.preventDefault();
    const FD = new FormData(formSubmit);
    const xhttp = new XMLHttpRequest();
    const inputs = formSubmit.querySelectorAll(".input-text");
    let error = 0;

    for (let i = 0; i < inputs.length; i++) {
      if (inputs[i].value === "") {
        inputs[i].classList.add("error");
        error = 1;
      } else {
        inputs[i].classList.remove("error");
      }
    }

    if (error === 1) {
      return false;
    }

    xhttp.onload = function () {
      const jsonObj = JSON.parse(xhttp.responseText);

      if (jsonObj.error === false) {
        document.getElementById("dialog-content").innerHTML = jsonObj.text;
        updateList();

        setTimeout(() => {
          openCloseDialog("close");
        }, 900);
      } else {
        document.getElementById("dialog-results").innerHTML = jsonObj.text;
      }
    };

    xhttp.open("POST", actionURL);
    xhttp.send(FD);
  });
}

function updateList() {
  const xhttp = new XMLHttpRequest();

  xhttp.onload = function () {
    document.getElementById("register-list").innerHTML = this.responseText;
  };

  xhttp.open("POST", actionURL);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=updatelist");
}

function clickActionBtn($btn, $function) {
  for (var i = 0; i < $btn.length; i++) {
    $btn[i].addEventListener("click", $function);
  }
}

function openCloseDialog(event) {
  const dialog = document.getElementById("dialog");
  if (event === "open") {
    dialog.classList.add("open");
  } else {
    dialog.classList.remove("open");
  }
}
