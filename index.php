<!-- includes php -->
<?php include 'includes\functions\sessions.php'; ?>  
<?php include 'includes\functions\functions.php'; ?>  
<?php include 'includes\templates\header.php'; ?>
<?php include 'includes\templates\bar.php'; ?>

  <!-- el body esta incluido en el header.php para indicar dinamicamente el css del body -->
  <div class="contenedor">
    <?php include 'includes\templates\sidebar.php'; ?>

    <main class="contenido-principal">
      <h1>
        <span>Diseño de Página Web</span>
      </h1>

      <form action="#" class="agregar-tarea">
        <div class="campo">
          <label for="tarea">Tarea:</label>
          <input type="text" placeholder="Nombre Tarea" class="nombre-tarea" />
        </div>
        <div class="campo enviar">
          <input type="hidden" id="id_proyecto" value="id_proyecto" />
          <input type="submit" class="boton nueva-tarea" value="Agregar" />
        </div>
      </form>

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