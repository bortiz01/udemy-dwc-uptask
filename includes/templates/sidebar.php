<aside class="contenedor-proyectos">
  <div class="panel crear-proyecto">
    <a href="#" class="boton">Nuevo Proyecto <i class="fas fa-plus"></i> </a>
  </div>

  <div class="panel lista-proyectos">
    <h2>Proyectos</h2>
    <ul id="proyectos">
    <?php
      $projects = getProjects();
      // echo '<pre>';
      // print_r($projects->fetch_all(MYSQLI_ASSOC));
      // echo '</pre>';
      if ($projects) {
        foreach($projects as $project) {
          echo '<li>';
            echo "<a href=index.php?id_project=" . $project['id_project'] . " id=proyecto:" . $project['id_project'] .">";
            echo $project['name'];
            echo '</a>';
          echo '</li>';
        }
      }
    ?>
    </ul>
  </div>
</aside>