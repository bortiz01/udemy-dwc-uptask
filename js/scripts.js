// todo el codigo js se ejecutara despues de que termine de cargarse todos los elementos del DOM(HTML)
document.addEventListener("DOMContentLoaded", function () {
  eventListener();

  // constantes/variables globales
  const listProjects = document.querySelector("ul#proyectos");

  // funcion de escucha del proyecto
  function eventListener() {
    // 'submit' boton de formularios
    // 'click' para otros elementos (boton)

    // boton para crear proyectos
    document.querySelector(".crear-proyecto a").addEventListener("click", newProject);

    // boton para crear tareas
    document.querySelector(".nueva-tarea").addEventListener("click", addTask);

    // botones para las tareas
    document.querySelector(".listado-pendientes").addEventListener("click", actionTask);
  }

  // crear proyecto
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

  // guardar proyecto en la BD
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
              <a href="index.php?id_project=${idProject}" id=proyecto:${idProject}>${projectName}</a>
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
  }

  // agregar una nueva tarea
  function addTask(e) {
    // prevenimos la redireccion por default
    e.preventDefault();

    // obtenemos el valor del campo
    const taskName = document.querySelector(".nombre-tarea").value;

    // validamos que no este vacio
    if (!taskName) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Una tarea no puede ir vacia",
      });
      // si la tarea esta correcta
    } else {
      // creamos el FormData
      const data = new FormData();
      data.append("task_name", taskName);
      data.append("action", "crear");
      data.append("id_project", document.querySelector("#id_proyecto").value);

      // realizamos el llamado por ajax
      // 1. crear el objeto
      const xhr = new XMLHttpRequest();

      // 2. abrir la conexion
      xhr.open("POST", "includes/models/model-task.php", true);

      // 3. procesar la respuesta
      xhr.onload = function () {
        // todo correcto
        if (this.status === 200) {
          // obtenemos el valor de json enviado
          // (JSON.parse nos permite obteber la respuesta como objeto y no como string)
          const response = JSON.parse(xhr.responseText);

          // asignar valores
          const status = response.status,
            new_id = response.new_id,
            action = response.action,
            task_name = response.task_name;

          // si esta correcto
          if (status === "success") {
            // si la accion es crear
            if (action === "crear") {
              Swal.fire({
                icon: "success",
                title: "Tarea Creada",
                text: `La tarea: ${task_name} se asigno correctamente`,
              });

              // construir el template
              const new_task = document.createElement("li");
              new_task.id = "tarea:" + new_id;
              new_task.classList.add("tarea");

              new_task.innerHTML = `
                <p>${task_name}</p>
                <div class="acciones">
                  <i class="far fa-check-circle"></i>
                  <i class="fas fa-trash"></i>
                </div>                
              `;

              // agregarlo al HTML
              const list_task = document.querySelector(".listado-pendientes ul");
              list_task.appendChild(newTask);

              // limpiar el formulario
              document.querySelector(".agregar-tarea").reset();

              // si la accion es modificar
            } else {
            }
          } else {
            // si hubo un erro
          }

          // error
        } else {
        }
      };

      // 4. hacer la peticion
      xhr.send(data);
    }
  }

  // con e.target podemos acceder al delegation.
  // el cual nos permite verificar con que objeto se ha disparado algun evento
  function actionTask(e) {
    // console.log(e.target);
    if (e.target.classList.contains("fa-check-circle")) {
      console.log("hiciste click en el icono de check");
    }

    if (e.target.classList.contains("fa-trash")) {
      console.log("hiciste click en el icono de borrar");
    }
  }
});
