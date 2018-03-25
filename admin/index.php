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

<div class="row">
  <!-- Sales by month -->
  <?php
    $thisYr = date("Y");
    $lastYr = $thisYr - 1;
    $thisYrQ = $db->query("SELECT grand_total, txn_date FROM transactions WHERE YEAR(txn_date) = '{$thisYr}'");
    $lastYrQ = $db->query("SELECT grand_total, txn_date FROM transactions WHERE YEAR(txn_date) = '{$lastYr}'");
    $current = array();
    $last = array();
    $currentTotal = 0;
    $lastTotal = 0;
    while($x = mysqli_fetch_assoc($thisYrQ)){
      $month = date("m",strtotime($x['txn_date']));
      if (!array_key_exists($month,$current)) {
        $current[(int)$month] = $x['grand_total'];
      }else {
        $current[(int)$month] += $x['grand_total'];
      }
      $currentTotal += $x['grand_total'];
    }
    while($y = mysqli_fetch_assoc($lastYrQ)){
      $month = date("m",strtotime($y['txn_date']));
      if (!array_key_exists($month,$last)) {
        $last[(int)$month] = $y['grand_total'];
      }else {
        $last[(int)$month] += $y['grand_total'];
      }
      $lastTotal += $y['grand_total'];
    }
  ?>
  <div class="col-md-4">
    <h3 class="text-center">Sales by Month</h3>
    <!-- check server time -->
    <!-- <?php echo date("m-d-Y m:i:s");?> -->
    <table class="table table-condensed table-striped table-bordered">
      <thead>
        <th></th><th><?php echo $lastYr;?></th><th><?php echo $thisYr;?></th>
      </thead>
      <tbody>
        <?php for($i = 1;$i <= 12;$i++):
          $dt = DateTime::createFromFormat('!m',$i);
          ?>
          <tr<?php echo ((date('m') == $i)?' class="info"':'');?>>
            <td><?php echo $dt->format("F");?></td>
            <td><?php echo ((array_key_exists($i,$last))?phmoney($last[$i]):phmoney(0));?></td>
            <td><?php echo ((array_key_exists($i,$current))?phmoney($current[$i]):phmoney(0));?></td>
          </tr>
        <?php endfor;?>
        <tr>
          <td>Total</td>
          <td><?php echo phmoney($lastTotal);?></td>
          <td><?php echo phmoney($currentTotal);?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- Inventory -->
</div>
<?php include 'includes/footer.php';?>
