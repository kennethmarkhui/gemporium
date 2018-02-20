<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/gemporium/core/init.php';
  unset($_SESSION['GPUser']);
  header('Location: login.php');
?>
