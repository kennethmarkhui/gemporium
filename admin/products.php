<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/gemporium/core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';

  // If Add product button is clicked
  if (isset($_GET['add'])) {
    $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
    if ($_POST) {
      $title = sanitize($_POST['title']);
      $price = sanitize($_POST['price']);
      $category = sanitize($_POST['parent']);
      $withchildCategory = sanitize($_POST['child']);
      $description = sanitize($_POST['description']);
      $sizes = sanitize($_POST['sqPreview']);
      $dbpath ='';
      $errors = array();
      //Separate the sizes and quantity strings
      if (!empty($_POST['sqPreview'])) {
        $sizeString = sanitize($_POST['sqPreview']);
        $sizeString = rtrim($sizeString,',');//Trim last ','
        $sizesArray = explode(',', $sizeString);//Separete the strings with ','
        $sArray = array();
        $qArray = array();
        foreach ($sizesArray as $ss) {
          //Separate again with ':' and insert size in $sArray, quantity in $qArray
          $s = explode(":", $ss);
          $sArray[] = $s[0];
          $qArray[] = $s[1];
        }
      }else {
        $sizesArray = array();
      }
      $required = array('title','price','parent','sqPreview');
      foreach ($required as $field) {
        if ($_POST[$field] == '') {
          $errors[] = 'All fields with an Asterisk are required.';
          break;
        }
      }
      if (!empty($_FILES)) {
        $photo = $_FILES['photo'];
        $name = $photo['name'];
        $nameArray = explode('.', $name);
        $fileName = $nameArray[0];
        $fileExt = $nameArray[1];
        $mime = explode('/', $photo['type']);
        $mimeType = $mime[0];
        $mimeExt = $mime[1];
        $tmpLoc = $photo['tmp_name'];
        $fileSize = $photo['size'];
        $allowed = array('png','jpg','jpeg','gif');
        $uploadName = md5(microtime()).'.'.$fileExt;
        $uploadPath = BASEURL.'images/products/'.$uploadName;
        $dbpath = '/gemporium/images/products/'.$uploadName;
        if ($mimeType != 'image') {
          $errors[] = 'The file must be an image.';
        }
        if (!in_array($fileExt, $allowed)) {
          $errors[] = 'The file extension must be a PNG, JPG, JPEG or GIF.';
        }
        if ($fileSize > 5000000) {
          $errors[] = 'The file size must be under 5MB';
        }
        if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
          $errors[] = 'The file extension does not match the file.';
        }
      }
      if (!empty($errors)) {
        echo display_errors($errors);
      }else{
        //Upload file and insert into database
        $sizes = rtrim($sizes,',');
        move_uploaded_file($tmpLoc,$uploadPath);
        $insertSql = "INSERT INTO products (`title`, `price`, `categories`, `size`, `image`, `description`)
          VALUES ('$title', '$price', '$withchildCategory', '$sizes', '$dbpath', '$description')";
          if (empty($withchildCategory)) {
            $insertSql = "INSERT INTO products (`title`, `price`, `categories`, `size`, `image`, `description`)
              VALUES ('$title', '$price', '$category', '$sizes', '$dbpath', '$description')";
          }
          $db->query($insertSql);
         header('Location: products.php');
      }
    }
?>
    <h2 class="text-center">Add a new Product</h2><hr>
    <!-- Add Product Form -->
    <form action="products.php?add=1" method="post" enctype="multipart/form-data">
      <div class="form-group col-md-3">
        <label for="title">Title*:</label>
        <input type="text" name="title" class="form-control" id="title" value="<?php echo ((isset($_POST['title']))?sanitize($_POST['title']):'');?>">
      </div>
      <div class="form-group col-md-3">
        <label for="parent">Parent Category*:</label>
        <select class="form-control" id="parent" name="parent">
          <option value=""<?php echo ((isset($_POST['parent']) && $_POST['parent'] == '')?' selected':'');?>></option>
          <?php while($parent = mysqli_fetch_assoc($parentQuery)):?>
            <option value="<?php echo $parent['id'];?>"<?php echo ((isset($_POST['parent']) && $_POST['parent'] == $parent['id'])?' selected':'');?>><?php echo $parent['category'];?></option>
          <?php endwhile;?>
        </select>
      </div>
      <!-- Used ajax request to /admin/parsers/child_categories.php -->
      <div class="form-group col-md-3">
        <label for="child">Child Category:</label>
        <select class="form-control" id="child" name="child">
        </select>
      </div>

      <div class="form-group col-md-3">
        <label for="price">Price*:</label>
        <input type="text" id="price" name="price" class="form-control" value="<?php echo ((isset($_POST['price']))?sanitize($_POST['price']):'')?>">
      </div>
      <div class="form-group col-md-3">
        <label>Quantity & Sizes*:</label>
        <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
      </div>
      <div class="form-group col-md-3">
        <label for="sqPreview">Sizes & Qty Preview:</label>
        <input type="text" class="form-control" name="sqPreview" id="sqPreview" value="<?php echo ((isset($_POST['sqPreview']))?$_POST['sqPreview']:'');?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label for="photo">Product Photo:</label>
        <input type="file" name="photo" id="photo" class="form-control">
      </div>
      <div class="form-group col-md-6">
        <label for="description">Description:</label>
        <textarea name="description" id="description" class="form-control" rows="6"><?php echo((isset($_POST['description']))?sanitize($_POST['description']):'');?></textarea>
      </div>
      <div class="form-group pull-right">
        <input type="submit" value="Add Product" class="form-control btn btn-success">
      </div>
      <div class="clearfix"></div>
    </form>

<!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModalLabel">Size & Quantity</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <?php for($i=1;$i<=12;$i++):?>
            <div class="form-group col-md-4">
              <label for="size<?php echo $i;?>">Size:</label>
              <input type="text" name="size<?php echo $i;?>" id="size<?php echo $i;?>" value="<?php echo ((!empty($sArray[$i-1]))?$sArray[$i-1]:'')?>" class="form-control">
            </div>
            <div class="form-group col-md-2">
              <label for="qty<?php echo $i;?>">Quantity:</label>
              <input type="number" name="qty<?php echo $i;?>" id="qty<?php echo $i;?>" value="<?php echo ((!empty($qArray[$i-1]))?$qArray[$i-1]:'')?>" min="0" class="form-control">
            </div>
          <?php endfor;?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php

  }else {
  $sql = "SELECT * FROM products WHERE deleted != 1";
  $productResult = $db->query($sql);

  // Set Featured On and Off for products
  if (isset($_GET['featured'])) {
    $id = (int)$_GET['id'];
    $featured = (int)$_GET['featured'];
    $featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
    $db->query($featuredSql);
    header('Location: products.php');
  }

  //Delete Products and automatically set featured to 0
  if (isset($_GET['delete'])) {
    $deletedId = (int)$_GET['delete'];
    $deletedSql = "UPDATE products SET deleted = 1, featured = 0 WHERE id = '$deletedId'";
    $db->query($deletedSql);
    header('Location: products.php');
  }
?>
<h2 class="text-center">Products</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-button">Add Product</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
  <thead>
    <th></th><th>Product</th><th>Price</th><th>Featured</th><th>Sold</th>
  </thead>
  <tbody>
    <?php while($product = mysqli_fetch_assoc($productResult)):?>
      <tr>
        <td>
          <a href="products.php?edit=<?php echo $product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
          <a href="products.php?delete=<?php echo $product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
        </td>
        <td><?php echo $product['title'];?></td>
        <td><?php echo phmoney($product['price']);?></td>
        <td>
          <a href="products.php?featured=<?php echo (($product['featured'] == 0)?'1':'0');?>&id=<?php echo $product['id'];?>" class="btn btn-xs btn-default">
            <span class="glyphicon glyphicon-<?php echo (($product['featured'] == 1)?'minus':'plus');?>"></span>
          </a><?php echo (($product['featured'] == 1)?'Featured Product':'');?>
        </td>
        <td>0</td>
      </tr>
    <?php endwhile;?>
  </tbody>
</table>

<?php } include 'includes/footer.php';?>
