// todo el codigo js se ejecutara despues de que termine de cargarse todos los elemntos del DOM(HTML)
document.addEventListener("DOMContentLoaded", function () {
  "use strict";

  // verificamos todos los event listener
  eventListeners();

  // funcion que verifica cada evento listener o eventos del proyecto
  function eventListeners() {
    document.querySelector("#formulario").addEventListener("submit", validateUser);
  }

  // validacion de los usuarios
  function validateUser(e) {
    e.preventDefault();

    let user = document.querySelector("#usuario").value;
    let password = document.querySelector("#password").value;
    let action = document.querySelector("#tipo").value;

    // la validacion fallo
    if (user === "" || password === "") {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Ambos campos son obligatorios!",
      });
      // pasa la validacion
    } else {
      // preparar los datos del form para el envio por ajax
      var data = new FormData();
      data.append("usuario", user);
      data.append("password", password);
      data.append("accion", action);

      // mostrar los datos en consola (importante colocar ...)
      // console.log(...data);
      // console.log(data.get("usuario"));

      // pasos para el llamado por AJAX
      // 1. crear el objeto
      const xhr = new XMLHttpRequest();

      // 2. abrir la conexion
      xhr.open("POST", "includes/models/model-admin.php", true);

      // 3. retorno de datos
      xhr.onload = function () {
        if (this.status === 200) {
          // IMPORTANTE: JS trabaja con objetos, por eso debemos transformar
          // el JSON en un objeto con JSON.parse
          // console.log(xhr.responseText); //NO!! - muestra el resultado como json
          console.log(JSON.parse(xhr.responseText)); //SI!! - muestra el resultado como objeto
        }
      };

      // 4.enviar la peticion
      xhr.send(data);
    }
  }
});
