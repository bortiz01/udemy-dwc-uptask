eventListeners();

function eventListeners() {
  document.querySelector("#formulario").addEventListener("submit", validateUser);
}

function validateUser(e) {
  e.preventDefault();

  let usuario = document.querySelector("#usuario").value;
  let password = document.querySelector("#password").value;

  if (usuario === "" || password === "") {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Ambos campos son obligatorios!",
    });
  } else {
  }
}
