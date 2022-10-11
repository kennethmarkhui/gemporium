<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
  unset($_SESSION['GPUser']);
  header('Location: login.php');
?>
