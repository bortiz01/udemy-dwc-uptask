<?php    
  // debemos enviar la informacion en 
  // formato JSON - formato de intercambio de datos
  // die(json_encode($_POST));

  $accion = $_POST['accion'];
  $usuario = $_POST['usuario'];
  $password = $_POST['password'];

  if ($accion === 'crear') {
    // crear los usuarios

    // hashear password    
    // 1. definimos el costo del hasheo. Default 10. 12 es mas seguro, pero consume mas recurso
    $options = [      
      'cost' => 12
    ];

    // 2. hasheamos la el password
    $hash_password = password_hash($password, PASSWORD_BCRYPT, $options);    

    $output = [
      'pass' => $hash_password
    ];

  }

  if ($accion === 'login') {
    // datos de acceso
    
  }

  echo json_encode($output);

?>