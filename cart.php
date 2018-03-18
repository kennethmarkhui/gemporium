<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';

  if ($cart_id != '') {
    $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
    $result = mysqli_fetch_assoc($cartQ);
    $items = json_decode($result['items'],true);
    $i = 1;
    $sub_total = 0;
    $item_count = 0;
  }
?>

<div class="col-md-12">
  <div class="row">
    <h2 class="text-center">My Shopping Cart</h2><hr>
    <?php if ($cart_id == ''): ?>
      <div class="bg-danger">
        <p class="text-center text-danger">Your Shopping cart is empty!</p>
      </div>
    <?php else:?>
      <table class="table table-bordered table-condensed table-striped">
        <thead>
          <th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Size</th><th>Sub Total</th>
        </thead>
        <tbody>
          <?php
            foreach ($items as $item) {
              $product_id = $item['id'];
              $productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
              $product = mysqli_fetch_assoc($productQ);
              $sArray = explode(',',$product['size']);
              foreach ($sArray as $sizeString ) {
                $s = explode(':',$sizeString);
                if ($s[0] == $item['size']) {
                  $available = $s[1];
                }
              }
              ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $product['title'];?></td>
                <td><?php echo phmoney($product['price']);?></td>
                <td>
                  <button class="btn btn-xs btn-default" onclick="update_cart('removeone','<?php echo $product['id'];?>','<?php echo $item['size'];?>');"> - </button>
                  <?php echo $item['quantity'];?>
                  <?php if($item['quantity'] < $available):?>
                    <button class="btn btn-xs btn-default" onclick="update_cart('addone','<?php echo $product['id'];?>','<?php echo $item['size'];?>');"> + </button>
                  <?php else:?>
                    <span class="text-danger">Max</span>
                  <?php endif;?>
                </td>
                <td><?php echo $item['size'];?></td>
                <td><?php echo phmoney($item['quantity'] * $product['price']);?></td>
              </tr>
              <?php
                $i++;
                $item_count += $item['quantity'];
                $sub_total += ($product['price'] * $item['quantity']);
              }
              $tax = TAXRATE * $sub_total;
              $tax = number_format($tax,2);
              $grand_total = $tax + $sub_total;
              ?>
        </tbody>
      </table>
      <table class="table table-bordered table-condensed text-right">
        <legend>Totals</legend>
        <thead class="totals-table-header">
          <th>Total Items</th><th>Sub Total</th><th>Tax</th><th>Grand Total</th>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $item_count;?></td>
            <td><?php echo phmoney($sub_total);?></td>
            <td><?php echo phmoney($tax);?></td>
            <td class="bg-success"><?php echo phmoney($grand_total);?></td>
          </tr>
        </tbody>
      </table>
      <!-- checkout button -->
      <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#checkoutModal">
        <span class="glyphicon glyphicon-shopping-cart"></span> Check Out
      </button>

      <!-- Modal -->
      <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
              <h4 class="modal-title" id="checkoutModalLabel">Shipping Address</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form action="thankYou.php" method="post" id="payment-form">
                  <span class="bg-danger" id="payment-errors"></span>
                  <input type="hidden" name="tax" value="<?php echo $tax;?>">
                  <input type="hidden" name="sub_total" value="<?php echo $sub_total;?>">
                  <input type="hidden" name="grand_total" value="<?php echo $grand_total;?>">
                  <input type="hidden" name="cart_id" value="<?php echo $cart_id;?>">
                  <input type="hidden" name="description" value="<?php echo $item_count.' item'.(($item_count>1)?'s':'').' from Gemporium';?>">
                  <div id="checkout">
                    <div class="form-group col-md-6">
                      <label class="control-label">Full Name</label>
                      <div class="inputGroupContainer">
                      <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                      <input name="full_name" placeholder="First & Last Name" class="form-control" id="full_name" type="text">
                        </div>
                      </div>
                    </div>
                    <!-- <div class="form-group col-md-6">
                      <label for="full_name">Full Name:</label>
                      <input class="form-control" id="full_name" type="text" name="full_name" placeholder="First & Last Name">
                    </div> -->
                    <div class="form-group col-md-6">
                      <label class="control-label">Email</label>
                        <div class="inputGroupContainer">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input name="email" placeholder="E-Mail Address" class="form-control" id="email" type="email">
                          </div>
                      </div>
                    </div>
                    <!-- <div class="form-group col-md-6">
                      <label for="email">Email:</label>
                      <input class="form-control" id="email" type="email" name="email">
                    </div> -->
                    <div class="form-group col-md-6">
                      <label class="control-label">Mobile Number</label>
                      <div class="inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            <input name="mobile_number" placeholder="(+63)xxxxxxxxxx" class="form-control" id="mobile_number" type="text">
                        </div>
                      </div>
                    </div>
                    <!-- <div class="form-group col-md-6">
                      <label for="mobileNumber">Mobile Number:</label>
                      <input class="form-control" id="mobile_number" type="text" name="mobile_number" placeholder="Phone Number" maxlength="20">
                    </div> -->
                    <div class="form-group col-md-6">
                      <label class="control-label">Complete Address</label>
                      <div class="inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input name="address" placeholder="Address" class="form-control" id="address" type="text">
                        </div>
                      </div>
                    </div>
                    <!-- <div class="form-group col-md-6">
                      <label for="street">Complete Address:</label>
                      <input class="form-control" id="street" type="text" name="street">
                    </div> -->
                    <div class="form-group col-md-6">
                      <label class="control-label">City</label>
                      <div class="inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input name="city" placeholder="City" class="form-control" id="city" type="text">
                        </div>
                      </div>
                    </div>
                    <!-- <div class="form-group col-md-6">
                      <label for="city">City:</label>
                      <input class="form-control" id="city" type="text" name="city">
                    </div> -->
                    <div class="form-group col-md-6">
                      <label class="control-label">Province</label>
                      <div class="inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input name="province" placeholder="Province" class="form-control" id="province" type="text">
                        </div>
                    </div>
                    </div>
                    <!-- <div class="form-group col-md-6">
                      <label for="state">Province:</label>
                      <input class="form-control" id="province" type="text" name="province">
                    </div> -->
                    <div class="form-group col-md-6">
                      <label class="control-label">Zip Code</label>
                      <div class="inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input name="zip_code" placeholder="Zip Code" class="form-control" id="zip_code" type="text">
                        </div>
                    </div>
                    </div>
                    <!-- <div class="form-group col-md-6">
                      <label for="zip_code">Zip Code:</label>
                      <input class="form-control" id="zip_code" type="text" name="zip_code">
                    </div> -->
                    <div class="form-group col-md-6">
                      <label class="control-label">Country</label>
                      <div class="inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                            <input name="country" class="form-control" id="country" type="text" value="Phillipines" readonly>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="form-group col-md-6">
                      <label for="country">Country:</label>
                      <input class="form-control" id="country" type="text" name="country" value="Phillipines" readonly>
                    </div> -->
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="check_address();" id="continue_button">Verify</button>
              <button type="submit" class="btn btn-primary" id="checkout_button" style="display:none;">Check Out</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endif;?>
  </div>
</div>

<script>
    function check_address(){
      var data = {
        'full_name' : jQuery('#full_name').val(),
        'email' : jQuery('#email').val(),
        'address' : jQuery('#address').val(),
        'city' : jQuery('#city').val(),
        'province' : jQuery('#province').val(),
        'zip_code' : jQuery('#zip_code').val(),
        'country' : jQuery('#country').val(),
        'mobile_number' : jQuery('#mobile_number').val(),
      };
      jQuery.ajax({
        url : '/gemporium/admin/parsers/check_address.php',
        method : 'POST',
        data : data,
        success : function(data){
          if (data != 'passed') {
            jQuery('#payment-errors').html(data);
          }
          if (data == 'passed') {
            jQuery('#payment-errors').html("");
            jQuery('#continue_button').css("display","none");
            jQuery('#checkout_button').css("display","inline-block");
          }
        },
        error : function(){alert("Something went wrong!");},
      });
    }
</script>

<?php include 'includes/footer.php';?>
