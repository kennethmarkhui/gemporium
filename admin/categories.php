<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/gemporium/core/init.php';
  if (!is_logged_in()) {
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';

  $sql = "SELECT * FROM categories WHERE parent = 0";
  $parentCategory = $db->query($sql);

  $errors = array();
  $postCategory = '';
  $postParent = '';

  //Edit Category
  if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $editId = sanitize($editId);
    $editSql = "SELECT * FROM categories WHERE id = '$editId'";
    $editResult = $db->query($editSql);
    $editCategory = mysqli_fetch_assoc($editResult);
  }

  //Delete Category
  if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    $deleteId = sanitize($deleteId);
    $deleteSql = "DELETE FROM categories WHERE id = '$deleteId' OR parent ='$deleteId'";//OR delete child category if parent is deleted
    $db->query($deleteSql);
    header('Location: categories.php');
  }

  //Process Form
  if (isset($_POST) && !empty($_POST)) {
    $postParent = sanitize($_POST['parent']);
    $postCategory = sanitize($_POST['category']);
    $sqlform = "SELECT * FROM categories WHERE category = '$postCategory' AND parent = '$postParent'";
    if (isset($_GET['edit'])) {
      $id = $editCategory['id'];
      $sqlform = "SELECT * FROM categories WHERE category = '$postCategory' AND parent = '$postParent' AND id != '$id'";
    }
    $formResult = $db->query($sqlform);
    $count = mysqli_num_rows($formResult);
    // If category is blank
    if ($postCategory == '') {
      $errors[] .= 'The category cannot be left blank.';
    }
    // If exist in the database
    if ($count > 0 ) {
      $errors[] .= $postCategory.' already exists.';
    }
    // Display errors or Update database
    if (!empty($errors)) {
      // Display errors
      $display = display_errors($errors); ?>
      <script>
        jQuery('document').ready(function(){
          jQuery('#errors').html('<?php echo $display;?>');
        });
      </script>
      <?php
      }else{
      //Update Database
      $updateCategory = "INSERT INTO categories (category, parent) VALUES ('$postCategory','$postParent')";
      if (isset($_GET['edit'])) {
        $updateCategory = "UPDATE categories SET category = '$postCategory', parent = '$postParent' WHERE id = '$editId'";
      }
      $db->query($updateCategory);
      header('Location: categories.php');
    }
  }

  //Edit Form Category Value
  $categoryValue = '';
  $parentValue = 0;
  if (isset($_GET['edit'])) {
    $categoryValue = $editCategory['category'];
    $parentValue = $editCategory['parent'];
  }else {
    if (isset($_POST)) {
      $categoryValue = $postCategory;//Keep the value when there an error
      $parentValue = $postParent;
    }
  }
?>
<h2 class="text-center">Categories</h2><hr>
<div class="row">
  <!-- Form -->
  <div class="col-md-6">
    <form class="form" action="categories.php<?php echo ((isset($_GET['edit']))?'?edit='.$editId:'');?>" method="post">
      <legend><?php echo((isset($_GET['edit']))?'Edit':'Add a');?> Category</legend>
      <div id="errors"></div>
      <div class="form-group">
        <label for="parent">Parent</label>
        <select class="form-control" name="parent" id="parent">
          <option value="0"<?php echo (($parentValue == 0)?'selected=selected':'');?>>Parent</option>
          <?php while($parent = mysqli_fetch_assoc($parentCategory)):?>
            <option value="<?php echo $parent['id'];?>"<?php echo (($parentValue == $parent['id'])?' selected=selected':'');?>><?php echo $parent['category'];?></option>
          <?php endwhile;?>
        </select>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <input type="text" class="form-control" id="category" name="category" value="<?php echo $categoryValue;?>">
      </div>
      <div class="form-group">
        <input type="submit" value="<?php echo ((isset($_GET['edit']))?'Edit':'Add');?> Category" class="btn btn-success pull-right">
      </div>
    </form>
  </div>
  <!-- Category Table -->
  <div class="col-md-6">
    <table class="table table-bordered">
      <thead>
        <th>Category</th><th>Parent</th><th></th>
      </thead>
      <tbody>
        <?php
          $sql = "SELECT * FROM categories WHERE parent = 0";
          $parentCategory = $db->query($sql);
          while($parent = mysqli_fetch_assoc($parentCategory)):
            $parentId = (int)$parent['id'];
            $sql2 = "SELECT * FROM categories WHERE parent = '$parentId'";
            $subCategory = $db->query($sql2);
          ?>
          <tr class="bg-primary">
            <td><?php echo $parent['category'];?></td>
            <td>Main Category</td>
            <td>
              <a href="categories.php?edit=<?php echo $parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
              <a href="categories.php?delete=<?php echo $parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
            </td>
          </tr>
          <?php while($child = mysqli_fetch_assoc($subCategory)):?>
            <tr>
              <tr class="bg-info">
                <td><?php echo $child['category'];?></td>
                <td><?php echo $parent['category'];?></td>
                <td>
                  <a href="categories.php?edit=<?php echo $child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                  <a href="categories.php?delete=<?php echo $child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
                </td>
              </tr>
            </tr>
          <?php endwhile;?>
        <?php endwhile;?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php';?>
