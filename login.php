<!-- includes php -->
<?php include 'includes\functions\functions.php'; ?>
<?php include 'includes\templates\header.php'; ?>

<?php
// abrimos la sesion
  session_start();
  // verificamos si la sesion debe de cerrarse
  if (isset($_GET['cerrar_sesion'])) {
    $_SESSION = [];
  };
?>

  <!-- el body esta incluido en el header.php para indicar dinamicamente el css del body -->
  <div class="contenedor-formulario">
    <h1>UpTask</h1>
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
        <input type="hidden" id="tipo" value="login" />
        <input type="submit" class="boton" value="Iniciar Sesión" />
      </div>

      <div class="campo">
        <a href="crear-cuenta.php">Crea una cuenta nueva</a>
      </div>
    </form>
  </div>  

<!-- includes php -->
<?php include 'includes\templates\footer.php'; ?>