<h3 class="text-center">Shopping Cart</h3>
<div class="text-center">
  <?php if (empty($cart_id)):?>
    <p>Your shopping cart is empty.</p>
  <?php else:
    $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
    $results = mysqli_fetch_assoc($cartQ);
    $items = json_decode($results['items'],true);
    $sub_total = 0;
  ?>
  <table class="table table-condensed" id="cart_widget">
    <tbody>
      <?php foreach ($items as $item):
        $productQ = $db->query("SELECT * FROM products WHERE id = '{$item['id']}'");
        $product = mysqli_fetch_assoc($productQ);
      ?>
      <tr>
        <td><?php echo $item['quantity'];?></td>
        <td><?php echo substr($product['title'],0,15);?></td>
        <td><?php echo phmoney($item['quantity'] * $product['price']);?></td>
      </tr>
      <?php
        $sub_total += ($item['quantity'] * $product['price']);
      endforeach;?>
      <tr>
        <td></td>
        <td>Sub Total</td>
        <td><?php echo phmoney($sub_total);?></td>
      </tr>
    </tbody>
  </table>
  <a href="cart.php" class="btn btn-xs btn-primary pull-right">View Cart</a>
  <div class="clearfix"></div>

  <?php endif;?>
</div>
