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

  function getProjectName($id = null){
    // incluimos la conxexion a la bd
    require 'db_connect.php';

    try{
      // return $conn->query("SELECT name FROM projects WHERE id_project = {$id}");

      $stmt = $conn->prepare('SELECT name FROM projects WHERE id_project = ?');
      $stmt->bind_param('i', $id);
      $stmt->execute();
      
      $stmt->bind_result($db_name);
      $stmt->fetch();
      
      $stmt->close();
      $conn->close();
      
      return $db_name;
    }catch(Exception $e){
      echo 'error: ' . $e.getMessage();
      return false;
    };
  }
?>