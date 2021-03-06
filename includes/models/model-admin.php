<?php      
/* ------------------------------- get values ------------------------------- */
  // debemos enviar la informacion en 
  // formato JSON - formato de intercambio de datos
  $action = $_POST['accion'];
  $usuario = $_POST['usuario'];
  $password = $_POST['password'];

  /* ------------------------------- create user ------------------------------ */
  // crear los usuarios
  if ($action === 'crear') {
    
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
      // definimos la consulta por prepare statement
      // 1. indicamos la consulta con parametros
      $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES  (?, ?)');
      
      // 2. relacionamos los parametros
      $stmt->bind_param('ss', $usuario, $hash_password);
      
      // 3. ejecutamos la consulta
      $stmt->execute();
      
      // 4. procesamos el resultado de la consulta
      // si se inserto un registro
      if ($stmt->affected_rows > 0) {
        // creamos la respuesta a enviar
        $output = [
          'response' => 'success',
          'id' => $stmt->insert_id,
          'action' => $action
        ];
      // si no se modifico ningun registro
      } else {
        // creamos la respuesta a enviar
        $output = [
          'response' => 'error',
          'error' => $stmt->error
        ];
      };   
      
      // 5. cerramos el statement
      $stmt->close();
      
      // 6. cerramos la conexion
      $conn->close();
    }catch(Exception $e) {
      // en caso de error, tomar la exception
      $output = [
        'response' => 'error',
        'error' => $e->getMessage()
      ];
    };
  };

/* ------------------------------- login user ------------------------------- */
// datos de acceso
if ($action === 'login') {  
    // importamos la conexion a la BD
    require '..\functions\db_connect.php';

    try {
      // definimos la consulta por prepare statement
      // 1. indicamos la consulta con parametros
      $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
      
      // 2. relacionamos los parametros
      $stmt->bind_param('s', $usuario);
      
      // 3. ejecutamos la consulta
      $stmt->execute();
      
      // 4. procesamos el resultado de la consulta
      // NOTA: deben de ir en el orden y cantidad definido en el SELECT o TABLA
      $stmt->bind_result($db_id_user, $db_username, $db_password);
      // NOTA: el FETCH es necesario cuando se utiliza el bind_result
      $stmt->fetch();
      
      // verificamos si hay un resultado
      if ($db_id_user) {
        // login correcto
        if (password_verify($password, $db_password)) {
          // abrimos la sesion
          session_start();
          $_SESSION['id_user'] = $db_id_user;
          $_SESSION['username'] = $db_username;          
          $_SESSION['login'] = true;
          // creamos la respuesta a enviar
          $output = [
            'response' => 'success',
            'id_user' => $db_id_user,
            'username' => $db_username,
            'action' => $action
          ]; 
        }else {
          $output = [
            'response' => 'error',
            'error' => 'Password incorrecto'
          ];
        };
      // usuario incorrecto
      }else {
        // creamos la respuesta a enviar
        $output = [
          'response' => 'error',
          'error' => 'Usuario no existe'
        ];
      };
      
      // 5. cerramos el statement
      $stmt->close();
      
      // 6. cerramos la conexion
      $conn->close();
    }catch(Exception $e) {
      // en caso de error, tomar la exception
      $output = [
        'response' => 'error',
        'error' => $e->getMessage()
      ];
    };
  };

/* --------------------------- return the response -------------------------- */
  // convertimos el arreglo en un JSON para el 
  // intercambio de datos entre PHP y AJAX
  echo json_encode($output);

?>