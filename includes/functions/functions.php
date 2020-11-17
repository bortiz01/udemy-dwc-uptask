<?php
  // obtiene la pagina actual que se esta ejecutando
  function getActualPage(){
    $file = basename($_SERVER['PHP_SELF']);
    $page = str_replace(".php", "", $file);
    return $page;
  }  

  // obtener todos los proyectos
  function getProjects(){
    // incluimos la conxexion a la bd
    require 'db_connect.php';
    
    try{
      return $conn->query('SELECT * FROM projects');
    }catch(Execption $e){
      echo 'error: ' . $e.getMessage();
      return false;
    };
  };

  // obtener el nombre del proyecto
  function getProjectName($id = null){
    // incluimos la conxexion a la bd
    require 'db_connect.php';

    try{
      // return $conn->query("SELECT name FROM projects WHERE id_project = {$id}");

      // definimos la consulta con statment
      $stmt = $conn->prepare('SELECT name FROM projects WHERE id_project = ?');
      // vinculamos los parametros
      $stmt->bind_param('i', $id);
      // ejecutamos la consulta
      $stmt->execute();
      // asigamos la variable para cada campo de respuesta
      $stmt->bind_result($db_name);
      // comvertimos el resultado en un string
      $stmt->fetch();      
      // cerramos conexiones
      $stmt->close();
      $conn->close();      
      // retornamos el nombre como resultado
      return $db_name;
    // en caso de error
    }catch(Exception $e){
      echo 'error: ' . $e.getMessage();
      return false;
    };
  }

  function getProjectTask($id_project = null) {
    // incluimos la conxexion a la bd
    require 'db_connect.php';

    try{
      // return $conn->query("SELECT name FROM projects WHERE id_project = {$id}");

      // definimos la consulta con statment
      $stmt = $conn->prepare('SELECT * FROM tasks WHERE id_project = ?');
      // vinculamos los parametros
      $stmt->bind_param('i', $id_project);
      // ejecutamos la consulta
      $stmt->execute();

      // retornamos el nombre como resultado      
      return $stmt->get_result();
      // $result = $stmt->get_result();
      // return $result->fetch_all(MYSQLI_ASSOC);

      // cerramos conexiones
      $stmt->close();
      $conn->close();            

    // en caso de error
    }catch(Exception $e){
      echo 'error: ' . $e.getMessage();
      return false;
    };
  }
?>