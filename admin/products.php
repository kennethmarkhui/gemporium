<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/gemporium/core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';

  $sql = "SELECT * FROM products WHERE deleted != 1";
  $productResult = $db->query($sql);

  if (isset($_GET['featured'])) {
    $id = (int)$_GET['id'];
    $featured = (int)$_GET['featured'];
    $featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
    $db->query($featuredSql);
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

<?php include 'includes/footer.php';?>
