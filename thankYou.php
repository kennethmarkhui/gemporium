<?php
  require_once 'core/init.php';

  $full_name = sanitize($_POST['full_name']);
  $email = sanitize($_POST['email']);
  $full_name = sanitize($_POST['full_name']);
  $mobile_number = sanitize($_POST['mobile_number']);
  $address = sanitize($_POST['address']);
  $city = sanitize($_POST['city']);
  $province = sanitize($_POST['province']);
  $zip_code = sanitize($_POST['zip_code']);
  $country = sanitize($_POST['country']);
  $tax = sanitize($_POST['tax']);
  $sub_total = sanitize($_POST['sub_total']);
  $grand_total = sanitize($_POST['grand_total']);
  $cart_id = sanitize($_POST['cart_id']);
  $description = sanitize($_POST['description']);

  function generateOrderId() {
      $s = strtoupper(md5(uniqid(rand(),true)));
      $guidText =
          substr($s,0,8) . '-' .
          substr($s,8,4) . '-' .
          substr($s,12,4). '-' .
          substr($s,16,4). '-' .
          substr($s,20);
      return $guidText;
  }

  $order_id = generateOrderId();
  $txn_type = "Cash on Delivery";

  // adjust inventory
  $itemQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
  $iresults = mysqli_fetch_assoc($itemQ);
  $items = json_decode($iresults['items'],true);
  foreach ($items as $item) {
    $newSizes = array();
    $item_id = $item['id'];
    $productQ = $db->query("SELECT size FROM products WHERE id = '{$item_id}'");
    $product = mysqli_fetch_assoc($productQ);
    $sizes = sizesToArray($product['size']);
    foreach ($sizes as $size) {
      if ($size['size'] == $item['size']) {
        $q = $size['quantity'] - $item['quantity'];
        $t = $size['threshold'];
        $newSizes[] = array('size' => $size['size'], 'quantity' => $q, 'threshold' => $t);
      }else {
        $t = $size['threshold'];
        $newSizes[] = array('size' =>$size['size'], 'quantity' => $size['quantity'], 'threshold' => $t);
      }
    }
    $sizeString = sizesToString($newSizes);
    $db->query("UPDATE products SET size = '{$sizeString}' WHERE id = '{$item_id}'");
  }


// update cart
  $db->query("UPDATE cart SET ordered = 1 WHERE id = '{$cart_id}'");
  $db->query("INSERT INTO transactions
  (order_id,cart_id,full_name,email,mobile_number,address,city,province,zip_code,country,sub_total,tax,grand_total,description,txn_type) VALUES
  ('$order_id','$cart_id','$full_name','$email','$mobile_number','$address','$city','$province','$zip_code','$country','$sub_total','$tax','$grand_total','$description','$txn_type')");

  $domain = ($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST']:false;
  setcookie(CART_COOKIE,'',1,"/",$domain,false);

  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';

?>
<div class="text-center">
  <h1 class="text-success">Thank You!</h1>
  <p>Thank you for ordering on Gemporium Mr./Ms. <strong><?php echo $full_name;?></strong></p>
  <p>Your cart has been ordered! with a total of <strong><?php echo phmoney($grand_total);?></strong></p>
  <p>Your Receipt Number is: <strong><?php echo $cart_id;?></strong></p>
  <p>Your Order ID is: <strong><?php echo $order_id;?></strong></p>
  <p>Your order will be shipped to the address below.</p>
  <address style="font-weight:bold;">
    <?php echo $address;?><br>
    <?php echo $city.', '.$province.' '.$zip_code;?><br>
    <?php echo $country;?>
  </address>
</div>

<?php include 'includes/footer.php';?>
