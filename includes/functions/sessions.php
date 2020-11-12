<?php
  function user_authenticated() {
    if (!check_session()) {
      header('Location:login.php');
      exit();
    }
  };

  function check_session() {
    return isset($_SESSION['username']);
  };

  // enter to the session
  session_start();
  user_authenticated();
?>