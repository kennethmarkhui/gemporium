<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/gemporium/core/init.php';
  $name = sanitize($_POST['full_name']);
  $email = sanitize($_POST['email']);
  $address = sanitize($_POST['address']);
  $city = sanitize($_POST['city']);
  $province = sanitize($_POST['province']);
  $zip_code = sanitize($_POST['zip_code']);
  $country = sanitize($_POST['country']);
  $mobile_number = sanitize($_POST['mobile_number']);
  $errors = array();
  $required = array(
    'full_name' => 'Full Name',
    'email' => 'Email',
    'address' => 'Complete Address',
    'city' => 'City',
    'province' => 'Province',
    'zip_code' => 'Zip Code',
    'country' => 'Country',
    'mobile_number' => 'Mobile Number',
  );

  //check if all required fields are filled out
  foreach ($required as $f => $d) {
    if (empty($_POST[$f]) || $_POST[$f] == '') {
      $errors[] = $d.' is required.';
    }
  }

  //check if valid email address
  if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email.";
  }


  if (!empty($errors)) {
    echo display_errors($errors);
  }else {
    echo 'passed';
  }
?>
