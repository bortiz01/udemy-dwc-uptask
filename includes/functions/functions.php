<?php
  function getActualPage(){
    $file = basename($_SERVER['PHP_SELF']);
    $page = str_replace(".php", "", $file);
    return $page;
  }  
?>

