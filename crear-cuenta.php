<!-- includes php -->
<?php include 'includes\functions\db_connect.php'; ?>
<?php include 'includes\functions\functions.php'; ?>
<?php include 'includes\templates\header.php'; ?>

  <!-- el body esta incluido en el header.php para indicar dinamicamente el css del body -->
  <div class="contenedor-formulario">
    <h1>UpTask <span>Crear Cuenta</span></h1>
    <form id="formulario" class="caja-login" method="post">
      <div class="campo">
        <label for="usuario">Usuario: </label>
        <input type="text" name="usuario" id="usuario" placeholder="Usuario" />
      </div>
      <div class="campo">
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" placeholder="Password" />
      </div>
      <div class="campo enviar">
        <input type="hidden" id="tipo" value="crear" />
        <input type="submit" class="boton" value="Crear cuenta" />
      </div>
      <div class="campo">
        <a href="login.html">Inicia Sesión Aquí</a>
      </div>
    </form>
  </div>

<!-- includes php -->
<?php include 'includes\templates\footer.php'; ?>
