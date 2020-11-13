<!-- includes php -->
<?php include 'includes\functions\sessions.php'; ?>  
<?php include 'includes\functions\functions.php'; ?>  
<?php include 'includes\templates\header.php'; ?>
<?php include 'includes\templates\bar.php'; ?>

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
            <input type="hidden" id="<?php echo $id_project; ?>" value="id_proyecto" />
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
          <li id="tarea:<?php echo $tarea['id'] ?>" class="tarea">
            <p>Cambiar el Logotipo</p>
            <div class="acciones">
              <i class="far fa-check-circle"></i>
              <i class="fas fa-trash"></i>
            </div>
          </li>
        </ul>
      </div>
    </main>
  </div>
  <!--.contenedor-->

<!-- includes php -->
<?php include 'includes\templates\footer.php'; ?>