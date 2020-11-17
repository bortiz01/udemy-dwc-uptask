<?php
  /* ------------------------------- get values ------------------------------- */
  $task_name = $_POST['task_name'];
  $id_project = (int) $_POST['id_project']; //indicamos que el valor sera un entero
  $action = $_POST['action'];  

  /* ----------------------------- create task ----------------------------- */
  // crear los proyectos
  if ($action === 'crear') {
    
    // importamos la conexion a la BD
    require '..\functions\db_connect.php';

    try {
      // definimos la consulta por prepare statement      
      // 1. indicamos la consulta con parametros
      $stmt = $conn->prepare('INSERT INTO tasks (id_project, name) VALUES  (?, ?)');
      
      // 2. relacionamos los parametros
      $stmt->bind_param('is', $id_project, $task_name);
      
      // 3. ejecutamos la consulta
      $stmt->execute();
      
      // 4. procesamos el resultado de la consulta
      // si se inserto un registro
      if ($stmt->affected_rows > 0) {
        // creamos la respuesta a enviar
        $output = [
          'status' => 'success',
          'newID' => $stmt->insert_id,
          'action' => $action,
          'taskName' => $task_name
        ];
      // si no se modifico ningun registro
      } else {
        // creamos la respuesta a enviar
        $output = [
          'status' => 'error',
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

  /* --------------------------- return the response -------------------------- */
  // convertimos el arreglo en un JSON para el 
  // intercambio de datos entre PHP y AJAX
  echo json_encode($output);

?>