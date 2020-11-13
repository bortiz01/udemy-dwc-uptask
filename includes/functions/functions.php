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
?>