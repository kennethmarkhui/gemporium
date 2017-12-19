<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/gemporium/core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';

  $sql = "SELECT * FROM categories WHERE parent = 0";
  $parentCategory = $db->query($sql);

  $errors = array();

  //Process Form
  if (isset($_POST) && !empty($_POST)) {
    $parent = sanitize($_POST['parent']);
    $category = sanitize($_POST['category']);
    $sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$parent'";
    $formResult = $db->query($sqlform);
    $count = mysqli_num_rows($formResult);
    // If category is blank
    if ($category == '') {
      $errors[] .= 'The category cannot be left blank.';
    }
    // If exist in the database
    if ($count > 0 ) {
      $errors[] .= $category.' already exists.';
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
      $updateSql = "INSERT INTO categories (category, parent) VALUES ('$category','$parent')";
      $db->query($updateSql);
      header('Location: categories.php');
    }
  }
?>
<h2 class="text-center">Categories</h2><hr>
<div class="row">
  <!-- Form -->
  <div class="col-md-6">
    <form class="form" action="categories.php" method="post">
      <legend>Add a Category</legend>
      <div id="errors"></div>
      <div class="form-group">
        <label for="parent">Parent</label>
        <select class="form-control" name="parent" id="parent">
          <option value="0">(New)</option>
          <?php while($parent = mysqli_fetch_assoc($parentCategory)):?>
            <option value="<?php echo $parent['id'];?>"><?php echo $parent['category'];?></option>
          <?php endwhile;?>
        </select>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <input type="text" class="form-control" id="category" name="category">
      </div>
      <div class="form-group">
        <input type="submit" value="Add Category" class="btn btn-success pull-right">
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
            <td>Parent</td>
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
