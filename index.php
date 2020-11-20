<!-- includes php -->
<?php include 'includes\functions\sessions.php'; ?>  
<?php include 'includes\functions\functions.php'; ?>  
<?php include 'includes\templates\header.php'; ?>
<?php include 'includes\templates\bar.php'; ?>

  <!-- obtenemos el id del proyecto -->
  <?php
    if(isset($_GET['id_project'])) {
      $id_project = $_GET['id_project'];
    };
  ?>

  <!-- el body esta incluido en el header.php para indicar dinamicamente el css del body -->
  <div class="contenedor">
    <?php include 'includes\templates\sidebar.php'; ?>

    <main class="contenido-principal">
      <!-- obtenemos el nombre del proyecto -->
      <?php $nameProject = getProjectName($id_project); ?>
      
      <!-- si hay un prpyecto seleccionado -->
      <?php if ($nameProject) { ?>
        <h1>Proyecto actual:
          <span>
            <?php
              // foreach($project as $name) {
              //   echo '<span>' . $name['name'] . '</span>';
              // }              
              
              // $nameProject = $project->fetch_assoc();
              // echo '<span>' . $project['name'] . '</span>';
              
              echo $nameProject;
            ?>
          </span>
        </h1>

        <form action="#" class="agregar-tarea">
          <div class="campo">
            <label for="tarea">Tarea:</label>
            <input type="text" placeholder="Nombre Tarea" class="nombre-tarea" />
          </div>
          <div class="campo enviar">
            <input type="hidden" value="<?php echo $id_project; ?>" id="id_proyecto" />
            <input type="submit" class="boton nueva-tarea" value="Agregar" />
          </div>
        </form>
      <!-- si no hay proyecto seleccionado -->
      <?php } else {
        echo '<p>Selecciona un proyecto a la izquieda</p>';
      }; ?>

      <h2>Listado de tareas:</h2>

      <div class="listado-pendientes">
        <ul>

          <?php
            // <!-- obtiene las tareas del proyecto actual -->
            $db_tasks = getProjectTask($id_project);
            
            // <!-- verificamos si contiene registros -->
            if ($db_tasks->num_rows > 0) {
              
              // <!-- recorremos los registros y obtenemos cada row -->
              foreach($db_tasks as $task) {
                // <!-- insertamos el codigo html por cada loop -->
                echo '<li id="tarea:' . $task["id_task"] . '" class="tarea">';
                  echo '<p>' . $task['name'] . '</p>';
                  echo '<div class="acciones">';
                    echo '<i class="far fa-check-circle ' . ($task['state'] === 1 ? 'completo' : '') . '"></i>';
                    echo '<i class="fas fa-trash"></i>';
                  echo '</div>';
                echo '</li>';
              }
            } else {
              echo '<p class=lista-vacia>';
                echo 'No hay tareas en este proyecto';
              echo '</p>';
            }
          ?>

        </ul>
      </div>
    
      <div class="avance">
        <h2>Avance del proyecto
          <div id="barra-avance" class="barra-avance">
            <div id="porcentaje" class="porcentaje">
            </div>
          </div>
        </h2>
      </div>    
    </main>      
  </div>
  <!--.contenedor-->

<!-- includes php -->
<?php include 'includes\templates\footer.php'; ?>