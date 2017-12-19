<?php
  // Display errors in an unordered list
  function display_errors($errors){
    $display = '<ul class="bg-danger">';
    foreach ($errors as $error) {
      $display .= '<li class="text-danger">'.$error.'</li>';
    }
    $display .= '</ul>';
    return $display;
  }

  // Make tags into html entities, ENT_QUOTES for single and double quotes
  function sanitize($dirtyString){
    return htmlentities($dirtyString,ENT_QUOTES,"UTF-8");
  }
?>
