<?php
    // indicamos que omita los mensajes de error por default de conexion
    error_reporting(0);

    // credenciales de la base de datos
    define('DB_HOST', 'localhost');
    define('DB_USER', 'uptask');
    define('DB_PASSWORD', 'uptask123*');    
    define('DB_NAME', 'uptask');
    define('DB_PORT', '3306'); //opcional
  
    // abrimos la conexion
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
    $conn->set_charset('utf-8');

    // hacemos ping a la conexion para verificar si esta correcto
    // true = abierta
    // false = no abierta
    // var_dump($conn->ping());

    // otra forma mas correcta es verificar los errores de conexion
    // en caso no hay error, no muestra nada
    if ($conn->connect_error) {
      echo $conn->connect_error;
    }
?>