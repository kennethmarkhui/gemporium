<?php
  ob_start();
  require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
  if (!is_logged_in()) {
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';

  $sql = "SELECT * FROM products WHERE deleted = 1";
  $archivedResults = $db->query($sql);

  //Restore Deleted Products
  if (isset($_GET['restore'])) {
    $restoreId = (int)$_GET['restore'];
    $restoreSql = "UPDATE products SET deleted = 0 WHERE id ='$restoreId'";
    $db->query($restoreSql);
    header('Location: archived.php');
  }
?>
<h2 class="text-center">Archived</h2><hr>

<table class="table table-condensed table-hover table-bordered" id="archivedTable">
  <thead>
    <th></th><th>Product</th><th>Price</th>
  </thead>
  <tbody>
    <?php while($product = mysqli_fetch_assoc($archivedResults)):?>
      <tr>
        <td>
          <a href="archived.php?restore=<?php echo $product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-refresh"></a>
          </span>
        </td>
        <td><?php echo $product['title'];?></td>
        <td><?php echo phmoney($product['price']);?></td>
      </tr>
    <?php endwhile;?>
  </tbody>
</table>
<?php include 'includes/footer.php';?>
