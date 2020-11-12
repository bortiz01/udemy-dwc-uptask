    <!-- cargamos los scripts del proyecto -->
    <script src="js/sweetalert2.all.min.js"></script>
    
    <!-- condicionamos la carga de scripts especificos -->
    <?php
      // obtenemos la pagina actual en que nos encontramos
      $actual = getActualPage();            
      if ($actual === 'crear-cuenta' || $actual === 'login') {
        echo '<script src="js/form.js"></script>';
      } else {
        echo '<script src="js/scripts.js"></script>';
      }
    ?>

  </body>
</html>