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

  //Philippine currency sign and format number to 2 decimal
  function phmoney($number){
    return '₱'.number_format($number,2);
  }

  //Login user in Admin page
  function login($userID){
    $_SESSION['GPUser'] = $userID;
    //Update Last Login of the user
    global $db;
    $date = date("Y-m-d H:i:s");
    $db->query("UPDATE adminusers SET last_login = '$date' WHERE id = '$userID'");
    $_SESSION['success_flash'] = 'You are now logged in!';
    header("Location: index.php");
  }

  function is_logged_in(){
    if (isset($_SESSION['GPUser']) && $_SESSION['GPUser'] > 0) {
      return true;
    }
    return false;
  }

  //Redirect page if not logged in
  function login_error_redirect($url = 'login.php'){
    $_SESSION['error_flash'] = 'You must be logged in to access that page.';
    header('Location: '.$url);
  }

  //Permission to access a page
  function has_permission($permission = 'admin'){
    global $userData;
    $permissions = explode(',', $userData['permissions']);
    if (in_array($permission, $permissions, true)) {
      return true;
    }
    return false;
  }

  //Redirect if user do not have permission to access
  function permission_error_redirect($url = 'login.php'){
    $_SESSION['error_flash'] = 'You do not have permission to access that page.';
    header('Location: '.$url);
  }

  function formatted_date($date){
    return date("M d, Y h:i A",strtotime($date));
  }

  function get_category($childID){
    global $db;
    $id = sanitize($childID);
    $sql = "SELECT p.id AS 'pid', p.category AS 'parent', c.id AS 'cid', c.category AS 'child'
            FROM categories c
            INNER JOIN categories p
            ON c.parent = p.id
            WHERE c.id = '$id'";
    $query = $db->query($sql);
    $category = mysqli_fetch_assoc($query);
    return $category;
  }

  function sizesToArray($string){
    $sizesArray = explode(',',$string);
    $returnArray = array();
    foreach ($sizesArray as $size) {
      $s = explode(':',$size);
      $returnArray[] = array('size' => $s[0], 'quantity' => $s[1]);
    }
    return $returnArray;
  }

  function sizesToString($sizes){
    $sizeString = '';
    foreach ($sizes as $size) {
      $sizeString .= $size['size'].':'.$size['quantity'].',';
    }
    $trimmed = rtrim($sizeString,',');
    return $trimmed;
  }

?>
