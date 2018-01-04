<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/gemporium/core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';

  // If Add product button is clicked
  if (isset($_GET['add'])) {
    $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
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
        <label for="sizes">Sizes & Qty Preview</label>
        <input type="text" class="form-control" name="sizes" id="sizes" value="<?php echo ((isset($_POST['sizes']))?$_POST['sizes']:'');?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label for="photo">Product Photo:</label>
        <input type="file" name="photo" id="photo" class="form-control">
      </div>
      <div class="form-group col-md-6">
        <label for="description">Description:</label>
        <textarea name="description" id="description" class="form-control" rows="6">
          <?php echo((isset($_POST['description']))?sanitize($_POST['description']):'');?>
          </textarea>
      </div>
      <div class="form-group pull-right">
        <input type="submit" value="Add Product" class="form-control btn btn-success">
      </div>
      <div class="clearfix"></div>
    </form>

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
