<?php
  ob_start();
  require_once '../core/init.php';
  if (!is_logged_in()) {
    header('Location: login.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';

  //complete order
  if (isset($_GET['complete']) && $_GET['complete'] == 1) {
    $cart_id = sanitize((int)$_GET['cart_id']);
    $db->query("UPDATE cart SET shipped = 1 WHERE id = '{$cart_id}'");
    $_SESSION['success_flash'] = "The order has been completed";
    header("Location: index.php");
  }

  $txn_id = sanitize((int)$_GET['txn_id']);
  $txnQuery = $db->query("SELECT * FROM transactions WHERE id = '{$txn_id}'");
  $txn = mysqli_fetch_assoc($txnQuery);
  $cart_id = $txn['cart_id'];
  $cartQuery = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
  $cart = mysqli_fetch_assoc($cartQuery);
  $items = json_decode($cart['items'],true);
  $idArray = array();
  $products = array();
  foreach ($items as $item) {
    $idArray[] = $item['id'];
  }
  $ids = implode(',',$idArray);
  $productQ = $db->query(
    "SELECT i.id as 'id', i.title as 'title', c.id as 'cid', c.category as 'child', p.category as 'parent'
    FROM products i
    LEFT JOIN categories c ON i.categories = c.id
    LEFT JOIN categories p ON c.parent = p.id
    WHERE i.id IN ({$ids})");

    while ($p = mysqli_fetch_assoc($productQ)) {
      foreach ($items as $item) {
        if ($item['id'] = $p['id']) {
          $x = $item;
          continue;
        }
      }
      $products[] = array_merge($x,$p);
    }
?>
<h2 class="text-center">Items Ordered</h2>
<table class="table table-condensed table-bordered table-striped">
  <thead>
    <th>Quantity</th><th>Title</th><th>Category</th><th>Size</th>
  </thead>
  <tbody>
    <?php foreach($products as $product):?>
      <tr>
        <td><?php echo $product['quantity'];?></td>
        <td><?php echo $product['title'];?></td>
        <td><?php echo $product['parent'];?></td>
        <td><?php echo $product['size'];?></td>
      </tr>
    <?php endforeach;?>
  </tbody>
</table>

<div class="row">
  <div class="col-md-6">
    <h3 class="text-center">Order Details</h3>
    <table class="table table-condensed table-striped table-bordered">
      <tbody>
        <tr>
          <td>Sub Total</td>
          <td><?php echo phmoney($txn['sub_total']);?></td>
        </tr>
        <tr>
          <td>Tax</td>
          <td><?php echo phmoney($txn['tax']);?></td>
        </tr>
        <tr>
          <td>Grand Total</td>
          <td><?php echo phmoney($txn['grand_total']);?></td>
        </tr>
        <tr>
          <td>Order Date</td>
          <td><?php echo formatted_date($txn['txn_date']);?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="col-md-6 text-center">
    <h3>Shipping Address</h3>
    <address>
      <strong><?php echo $txn['full_name'];?></strong><br>
      <?php echo $txn['mobile_number'];?><br>
      <?php echo $txn['address'];?><br>
      <?php echo $txn['city'].', '.$txn['province'].' '.$txn['zip_code'];?><br>
      <?php echo $txn['country'];?>
    </address>
  </div>
</div>

<div class="pull-right">
  <a href="index.php" class="btn btn-lg btn-default">Cancel</a>
  <a href="orders.php?complete=1&cart_id=<?php echo $cart_id?>" class="btn btn-lg btn-primary">Complete Order</a>
</div>
<?php include 'includes/footer.php';?>
