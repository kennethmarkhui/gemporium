<?php
  require_once '../core/init.php';//To access the $db
  $id = $_POST['id'];
  $id = (int)$id;//Make sure that the id is a integer
  //Get product details based on the id
  $sql = "SELECT * FROM products WHERE id = '$id'";
  $result = $db->query($sql);
  $product = mysqli_fetch_assoc($result);
  //Seperate the strings of size:quantity with comma
  $sizeString = $product['size'];
  $sizeArray = explode(',', $sizeString);
?>

<!-- Details Modal -->
<?php ob_start();?>
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center"><?php echo $product['title'];?></h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <div class="center-block">
                <img src="<?php echo $product['image'];?>" alt="<?php echo $product['title'];?>" class="details img-responsive">
              </div>
            </div>
            <div class="col-sm-6">
              <h4>Details</h4>
              <p><?php echo nl2br($product['description']);?></p><!-- nl2br() preserve line breaks that the users typed -->
              <hr>
              <p>Price: ₱<?php echo $product['price'];?></p>
              <hr />
              <form action="add_cart.php" method="post">
                <div class="form-group">
                  <div class="col-xs-3">
                    <label for="quantity">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="0">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-3">
                    <label for="size">Size:</label>
                    <select name="size" id="size" class="form-control">
                      <option value=""></option>
                      <?php foreach($sizeArray as $string){
                        //Seperate the size and quantity with colon
                        $stringArray = explode(':', $string);
                        $size = $stringArray[0];
                        $quantity = $stringArray[1];
                        echo '<option value="'.$size.'">'.$size.' ('.$quantity.'Available)</option>';
                      } ?>
                    </select>
                  </div>
                </div>
              </form><br><br><br><br><hr>
              <button type="submit" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</button>
              <button type="button" class="btn btn-default btn-block" onclick="closeModal()">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function closeModal(){
    jQuery('#details-modal').modal('hide');
    //Remove id
    setTimeout(function(){
      jQuery('#details-modal').remove();
      jQuery('.modal-backdrop').remove();
    },500);
  }
</script>

<?php echo ob_get_clean();?>
