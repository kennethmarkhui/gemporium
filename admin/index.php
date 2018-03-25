<?php
  require_once '../core/init.php';
  if (!is_logged_in()) {
    header('Location: login.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
?>
<!-- Orders to Fill -->
<?php
  $txnQuery = "SELECT t.id, t.order_id, t.cart_id, t.full_name, t.description, t.txn_date, t.grand_total, c.items, c.ordered, c.shipped
    FROM transactions t
    LEFT JOIN cart c ON t.cart_id = c.id
    WHERE c.ordered = 1 AND c.shipped = 0
    ORDER BY t.txn_date";
  $txnResults = $db->query($txnQuery);
?>
<div class="col-md-12">
  <h3 class="text-center">Orders to Ship</h3>
  <table class="table table-condensed table-bordered table-striped">
    <thead>
      <th></th><th>Order ID</th><th>Name</th><th>Description</th><th>Total</th><th>Date</th>
    </thead>
    <tbody>
      <?php while($order = mysqli_fetch_assoc($txnResults)):?>
        <tr>
          <td><a href="orders.php?txn_id=<?php echo $order['id'];?>" class="btn btn-xs btn-info">Details</a></td>
          <td><?php echo $order['order_id'];?></td>
          <td><?php echo $order['full_name'];?></td>
          <td><?php echo $order['description'];?></td>
          <td><?php echo phmoney($order['grand_total']);?></td>
          <td><?php echo formatted_date($order['txn_date']);?></td>
        </tr>
    <?php endwhile;?>
    </tbody>
  </table>
</div>
<?php include 'includes/footer.php';?>
