// todo el codigo js se ejecutara despues de que termine de cargarse todos los elementos del DOM(HTML)
document.addEventListener("DOMContentLoaded", function () {
  eventListener();

  // constantes/variables globales
  const listProjects = document.querySelector("ul#proyectos");

  function eventListener() {
    document.querySelector(".crear-proyecto a").addEventListener("click", newProject);
  }

  function newProject(e) {
    // e.preventDefault();

    // crea un <input> para el nombre del nuevo proyecto
    // creamos el elemento 'li'
    let newInput = document.createElement("li");

    // adicionamos al elemto 'li' un '<input>'
    newInput.innerHTML = "<input type='text' id='new-project'>";

    // adicionamos el elemento 'li' creado anteriormente debajo de elemento 'ul#proyectos'
    listProjects.appendChild(newInput);

    // seleccionar el ID del nuevo elemento
    const inputNewProject = document.querySelector("#new-project");
    inputNewProject.focus();

    // al presionar ENTER creamos el proyecto
    inputNewProject.addEventListener("keypress", function (e) {
      // keypress toma el valor de which o keycode del elemento
      const keypress = e.which || e.keycode;
      // verificamos si se presiono ENTER (13)
      if (keypress === 13) {
        // salvamos el nombre del proyecto en la DB
        saveProjectDB(inputNewProject.value);
        // removemos el elemento creado
        listProjects.removeChild(newInput);
      }
    });
  }

  function saveProjectDB(p_projectName) {
    // preparar los datos por FormData
    const data = new FormData();
    data.append("project", p_projectName);
    data.append("action", "crear");

    // pasos para el llamado por AJAX
    // 1. crear el objeto ajax
    const xhr = new XMLHttpRequest();

    // 2. abrir la conexion
    xhr.open("POST", "includes/models/model-project.php", true);

    // 3. procesar la respuesta
    xhr.onload = function () {
      if (this.status === 200) {
        // utilizamos JSON.parse para poder visualizar la respuesta
        // como objeto y no como string
        const response = JSON.parse(xhr.responseText),
          status = response.response,
          projectName = response.project,
          idProject = response.id,
          action = response.action;

        // si todo esta correcto
        if (status === "success") {
          if (action === "crear") {
            // inyectar el proyecto al HTML
            let newProject = document.createElement("li");
            newProject.innerHTML = `
              <a href="index.php?id_project=${idProject}" id = ${idProject}>${projectName}</a>
            `;
            listProjects.appendChild(newProject);

            // enviar el mensaje
            Swal.fire({
              icon: "success",
              title: "Proyecto creado",
              text: `El proyecto: ${projectName} se creo correctamente`,
            }).then((result) => {
              if (result.value) {
                window.location.href = `index.php?id_project=${idProject}`;
              }
            });
          }
          // si ocurrio un erro
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error!",
          });
        }
      }
    };

    // 4. hacer la peticion
    xhr.send(data);

    //   // inyectar el HTML
    //   let newProject = document.createElement("li");
    //   newProject.innerHTML = `<a href='#'>${p_projectName}</a>`;
    //   listProjects.appendChild(newProject);
  }
});
