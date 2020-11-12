// todo el codigo js se ejecutara despues de que termine de cargarse todos los elementos del DOM(HTML)
document.addEventListener("DOMContentLoaded", function () {
  eventListener();
  const listProjects = document.querySelector("ul#proyectos");

  function eventListener() {
    document.querySelector(".crear-proyecto a").addEventListener("click", newProject);
  }

  function newProject(e) {
    // e.preventDefault();

    // crea un <input> para el nombre del nuevo proyecto
    // creamos el elemento 'li'
    let newProject = document.createElement("li");

    // adicionamos al elemto 'li' un '<input>'
    newProject.innerHTML = "<input type='text' id='new-project'>";

    // adicionamos el elemento 'li' creado anteriormente debajo de elemento 'ul#proyectos'
    listProjects.appendChild(newProject);

    // seleccionar el ID del nuevo elemento
    const inputNewProject = document.querySelector("#new-project");

    // al presionar ENTER creamos el proyecto
    inputNewProject.addEventListener("keypress", function (e) {
      // keypress toma el valor de which o keycode del elemento
      const keypress = e.which || e.keycode;
      // verificamos si se presiono ENTER (13)
      if (keypress === 13) {
        // salvamos el nombre del proyecto en la DB
        saveProjectDB(inputNewProject.value);
        // removemos el elemento creado
        listProjects.removeChild(newProject);
      }
    });
  }

  function saveProjectDB(p_projectName) {
    console.log(p_projectName);
  }
});
