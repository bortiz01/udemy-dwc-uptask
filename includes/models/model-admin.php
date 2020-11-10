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

    // importamos la conexion a la BD
    require '..\functions\db_connect.php';

    try {
      // realizar la consulta a la BD
      $stmt = $conn->prepare('INSERT INTO user (username, password) VALUES  (?, ?)');
      $stmt->bind_param('ss', $usuario, $hash_password);
      $stmt->execute();

      $output = [
        'response' => 'success',
        'id' => $stmt->insert_id,
        'action' => $accion
        // 'error' => $stmt->error
      ];

      $stmt->close();
      $conn->close();
    }catch(Exception $e) {
      // en caso de error, tomar la exception
      $output = [
        'response' => $e->getMessage()
      ];
    };
  };

  if ($accion === 'login') {
    // datos de acceso    
  }

  echo json_encode($output);

?>