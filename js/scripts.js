// todo el codigo js se ejecutara despues de que termine de cargarse todos los elementos del DOM(HTML)
document.addEventListener("DOMContentLoaded", function () {
  eventListener();

  updateProgress();

  // constantes/variables globales
  const listProjects = document.querySelector("ul#proyectos");

  /* --------------------- funcion de escucha del proyecto -------------------- */

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

  /* ----------------------------- crear proyecto ----------------------------- */
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

  /* ------------------------ guardar proyecto en la BD ----------------------- */
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

  /* ------------------------- agregar una nueva tarea ------------------------ */
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

              // eliminar el mensaje predefinido del html
              const empty_list = document.querySelector(".lista-vacia");
              if (empty_list) {
                empty_list.remove();
              }

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
              list_task.appendChild(new_task);

              // limpiar el formulario
              document.querySelector(".agregar-tarea").reset();

              // actualizar la barra de progreso
              updateProgress();

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

  /* ------------------------- acciones de las tareas ------------------------- */
  // con e.target podemos acceder al delegation.
  // el cual nos permite verificar con que objeto se ha disparado algun evento
  function actionTask(e) {
    // console.log(e.target);
    if (e.target.classList.contains("fa-check-circle")) {
      if (e.target.classList.contains("completo")) {
        e.target.classList.remove("completo");
        changeStateTask(e.target, 0);
      } else {
        e.target.classList.add("completo");
        changeStateTask(e.target, 1);
      }
    }

    if (e.target.classList.contains("fa-trash")) {
      Swal.fire({
        title: "¿Seguro(a)?",
        text: "!Estas accion no se puede deshacer!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, borrar!",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          // obtenemos la tarea
          const taskDelete = e.target.parentElement.parentElement;
          // borrar de la bd
          deleteTask(taskDelete);
          // borrar del html
          taskDelete.remove();
          // mensaje de notificacion
          Swal.fire("!Borrado!", "La tarea fue eliminada", "success");
        }
      });
    }
  }

  /* --------------- cambiar el estado de la tarea seleccionada --------------- */
  function changeStateTask(p_task, p_state) {
    // obtenemos el id de la tarea
    const id_task = p_task.parentElement.parentElement.id.split(":");

    // crear el FormData
    const data = new FormData();
    data.append("id_task", id_task[1]);
    data.append("action", "actualizar");
    data.append("state", p_state);

    // llamado a ajax
    // 1.crear el objeto
    const xhr = new XMLHttpRequest();

    // 2. abrir la conexion
    xhr.open("POST", "includes/models/model-task.php", true);

    // 3. procesar la respuesta
    xhr.onload = function () {
      if (this.status === 200) {
        // actualizar la barra de progreso
        updateProgress();
      }
    };

    // 4. enviar la peticion
    xhr.send(data);
  }

  /* ------------------ elimina la tarea de la base de datos ------------------ */
  function deleteTask(p_task) {
    // obtenemos el id de la tarea
    const id_task = p_task.id.split(":");

    // crear el FormData
    const data = new FormData();
    data.append("id_task", id_task[1]);
    data.append("action", "eliminar");

    // llamado a ajax
    // 1.crear el objeto
    const xhr = new XMLHttpRequest();

    // 2. abrir la conexion
    xhr.open("POST", "includes/models/model-task.php", true);

    // 3. procesar la respuesta
    xhr.onload = function () {
      if (this.status === 200) {
        const task_list = document.querySelectorAll("li.tarea");
        if (task_list.length == 0) {
          document.querySelector(".listado-pendientes ul").innerHTML = "<p class=lista-vacia> No hay tareas en este proyecto </p>";
        }

        // actualizar la barra de progreso
        updateProgress();
      }
    };

    // 4. enviar la peticion
    xhr.send(data);
  }

  /* ------------------ actualizar el progreso de las tareas ------------------ */
  function updateProgress() {
    // obtener toda slas tareas
    const task = document.querySelectorAll("li.tarea");

    // obtener las tareas completas
    const completed_tasks = document.querySelectorAll("i.completo");

    // determinar el avance
    const percent = Math.round((completed_tasks.length / task.length) * 100);

    const progress = document.querySelector(".porcentaje");
    progress.style.width = percent + "%";

    if (percent == 100) {
      Swal.fire({
        icon: "success",
        title: "Proyecto terminado",
        text: "Ya no tienes tareas pendientes",
      });
    }
  }
});
