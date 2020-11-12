// todo el codigo js se ejecutara despues de que termine de cargarse todos los elementos del DOM(HTML)
document.addEventListener("DOMContentLoaded", function () {
  eventListener();

  function eventListener() {
    document.querySelector(".crear-proyecto a").addEventListener("click", newProject);
  }

  function newProject(e) {
    // e.preventDefault();
    console.log("presionaste un nuevo proyecto");
  }
});
