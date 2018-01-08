<?php
  $db = mysqli_connect('127.0.0.1','root','root','gemporium');//Connection to the database
  // Check if there are errors while connecting to the database
  if (mysqli_connect_errno()) {
    echo 'Database connection failed with the following errors: '.mysqli_connect_error();
    die();
  }
  require_once $_SERVER['DOCUMENT_ROOT'].'/gemporium/config.php';
  require_once BASEURL.'functions/functions.php';
?>
