<?php
  $db = mysqli_connect('localhost','root','','gemporium');//Connection to the database
  // Check if there are errors while connecting to the database
  if (mysqli_connect_errno()) {
    echo 'Database connection failed with the following errors: '.mysqli_connect_error();
    die();
  }
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
  require_once BASEURL.'functions/functions.php';

  $cart_id = '';
  if (isset($_COOKIE[CART_COOKIE])) {
    $cart_id = sanitize($_COOKIE[CART_COOKIE]);
  }

  if (isset($_SESSION['GPUser'])) {
    $userID = $_SESSION['GPUser'];
    $query = $db->query("SELECT * FROM adminusers WHERE id = '$userID'");
    $userData = mysqli_fetch_assoc($query);
    $fn = explode(' ', $userData['full_name']);
    $userData['first'] = $fn[0];
    $userData['last'] = $fn[1];
  }

  if (isset($_SESSION['success_flash'])) {
    echo '<div class="bg-success"><p class="text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
    unset($_SESSION['success_flash']);
  }

  if (isset($_SESSION['error_flash'])) {
    echo '<div class="bg-danger"><p class="text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
    unset($_SESSION['error_flash']);
  }
?>
