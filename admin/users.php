<?php
  ob_start();
  require_once '../core/init.php';
  if (!is_logged_in()) {
    login_error_redirect();
  }
  if (!has_permission('admin')) {
    permission_error_redirect('index.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
  //Delete user
  if (isset($_GET['delete'])) {
    $deleteID = sanitize($_GET['delete']);
    $db->query("DELETE FROM adminusers WHERE id = '$deleteID'");
    $_SESSION['success_flash'] = "User has been deleted!";
    header("Location: users.php");
  }
  //if add/edit button is clicked
  if (isset($_GET['add']) || isset($_GET['edit'])) {
    $name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
    $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
    $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
    $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
    $permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
    // repopulate the fields when editing a user
    if (isset($_GET['edit'])) {
      $editUserID = (int)$_GET['edit'];
      $usersEdit = $db->query("SELECT * FROM adminusers WHERE id = '$editUserID'");
      $userEdit = mysqli_fetch_assoc($usersEdit);

      $name = ((isset($_POST['name']))?sanitize($_POST['name']):$userEdit['full_name']);
      $email = ((isset($_POST['email']))?sanitize($_POST['email']):$userEdit['email']);
      $permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):$userEdit['permissions']);
    }
    // Validation
    $errors = array();
    if ($_POST) {
      if (isset($_GET['add'])) {
        $emailQuery = $db->query("SELECT * FROM adminusers WHERE email = '$email'");
        $emailCount = mysqli_num_rows($emailQuery);
        if ($emailCount != 0) {
          $errors[] = 'That email already exist in our database.';
        }
      }
      $required = array('name', 'email', 'password', 'confirm', 'permissions');
      foreach ($required as $adduserfield) {
        if(empty($_POST[$adduserfield])){
          $errors[] = 'You must fill out all the field';
          break;
        }
      }
      if (strlen($password) < 6) {
        $errors[] = 'Your password must be at least 6 characters.';
      }
      if ($password != $confirm) {
        $errors[] = 'Your passwords do not match.';
      }
      if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'You must enter a valid email.';
      }
      if (!empty($errors)) {
        echo display_errors($errors);
      }else{
        //Add user to database
        $hashed = password_hash($password,PASSWORD_DEFAULT);
        if (isset($_GET['add'])) {
          $db->query("INSERT INTO adminusers (full_name,email,password,permissions) VALUES ('$name','$email','$hashed','$permissions')");
          $_SESSION['success_flash'] = 'User has been added!';
        } elseif (isset($_GET['edit'])) {
          $db->query("UPDATE adminusers SET full_name = '$name', email = '$email', password = '$hashed', permissions = '$permissions' WHERE id ='$editUserID'");
          $_SESSION['success_flash'] = 'User has been updated!';
        }
        header("Location: users.php");
      }
    }
    ?>
    <h2 class="text-center"><?php echo ((isset($_GET['edit']))?'Edit':'Add a New');?> User</h2><hr>
    <form action="users.php?<?php echo ((isset($_GET['edit']))?'edit='.$editUserID:'add=1');?>" method="post">
      <div class="form-group col-md-6">
        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name" class="form-control" value="<?php echo $name;?>">
      </div>
      <div class="form-group col-md-6">
        <label for="name">Email:</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo $email;?>">
      </div>
      <div class="form-group col-md-6">
        <label for="password">Password:</label>
        <input type="password" name="password" id="email" class="form-control" value="<?php echo $password;?>">
      </div>
      <div class="form-group col-md-6">
        <label for="confirm">Retype Password:</label>
        <input type="password" name="confirm" id="confirm" class="form-control" value="<?php echo $confirm;?>">
      </div>
      <div class="form-group col-md-6">
        <label for="permissions">Permissions:</label>
        <select class="form-control" name="permissions">
          <option value=""<?php echo(($permissions == '')?' selected':'');?>></option>
          <option value="editor"<?php echo(($permissions == 'editor')?' selected':'');?>>Editor</option>
          <option value="admin,editor"<?php echo(($permissions == 'admin,editor')?' selected':'');?>>Admin</option>
        </select>
      </div>
      <div class="form-group col-md-6 text-right" id="add-user-submit-button">
        <a href="users.php" class="btn btn-default">Cancel</a>
        <input type="submit" value="<?php echo ((isset($_GET['edit']))?'Edit':'Add');?> User" class="btn btn-primary">
      </div>
    </form>
    <?php
  } else {
  $userQuery = $db->query("SELECT * FROM adminusers ORDER BY full_name");
?>
<h2>Users</h2>
<a href="users.php?add=1" class="btn btn-default btn-success pull-right" id="add-user-button">Add New User</a>
<hr>
<table class="table table-bordered table-hover table-condensed">
  <thead>
    <th></th>
    <th>Name</th>
    <th>Email</th>
    <th>Join Date</th>
    <th>Last Login</th>
    <th>Permissions</th>
  </thead>
  <tbody>
    <?php while($user = mysqli_fetch_assoc($userQuery)):?>
      <tr>
        <td>
          <?php if($user['id'] != $userData['id']):?>
            <a href="users.php?edit=<?php echo $user['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
            <a href="users.php?delete=<?php echo $user['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span></a>
          <?php endif;?>
        </td>
        <td><?php echo $user['full_name'];?></td>
        <td><?php echo $user['email'];?></td>
        <td><?php echo formatted_date($user['join_date']);?></td>
        <td><?php echo (($user['last_login'] == '0000-00-00 00:00:00')?'Never':formatted_date($user['last_login'])) ;?></td>
        <td><?php echo $user['permissions'];?></td>
      </tr>
    <?php endwhile;?>
  </tbody>
</table>
<?php } include 'includes/footer.php';?>
