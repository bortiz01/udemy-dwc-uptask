<?php
  /* ------------------------------- get values ------------------------------- */
  $fd_project = $POST['project'];
  $fd_action = $_POST['action'];  
  
  // usamos json_encode para poder enviar los datos en formato JSON
  // que es el medio para intercambiar datos
  echo json_encode($_POST);

?>