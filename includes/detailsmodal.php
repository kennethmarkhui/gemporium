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
            <span id="modal_errors" class="bg-danger"></span>

            <div class="col-sm-6 fotorama">
              <?php $photos = explode(',',$product['image']);
              foreach ($photos as $photo): ?>
                <?php
                $info = pathinfo($photo);
                if ($info["extension"] != "mp4"): ?>
                  <img src="<?php echo $photo;?>" alt="<?php echo $product['title'];?>" class="details img-responsive">
                <?php else: ?>
                  <!-- <div class="player">
                     <video>
                        <source type="video/mp4" src="//mydomain.com/video.mp4">
                     </video>
                  </div> -->
                  <div class="embed-responsive embed-responsive-4by3">
                    <video autoplay loop muted class="embed-responsive-item">
                      <source src="<?php echo $photo;?>" type="video/mp4">
                    </video>
                  </div>
                <?php endif; ?>
              <?php endforeach;?>
            </div>

            <div class="col-sm-6">
              <h4>Details</h4>
              <p><?php echo nl2br($product['description']);?></p><!-- nl2br() preserve line breaks that the users typed -->
              <hr>
              <p>Price: ???<?php echo $product['price'];?></p>
              <hr />
              <form action="add_cart.php" method="post" id="add_product_form">
                <input type="hidden" name="product_id" value="<?php echo $id;?>">
                <input type="hidden" name="available" id="available" value="">
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
                        $available = $stringArray[1];
                        if ($available > 0) {
                          echo '<option value="'.$size.'" data-available="'.$available.'">'.$size.' ('.$available.'Available)</option>';
                        }
                      } ?>
                    </select>
                  </div>
                </div>
              </form><br><br><br><br><hr>
              <button class="btn btn-warning btn-block" onclick="add_to_cart();return false;"><span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</button>
              <button type="button" class="btn btn-default btn-block" onclick="closeModal()">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  jQuery('#size').change(function(){
    var available = jQuery('#size option:selected').data("available");
    jQuery("#available").val(available);
  });

  $(function () {
  $('.fotorama').fotorama({'loop':true,'autoplay':true});
  });

  function closeModal(){
    jQuery('#details-modal').modal('hide');
    //Remove id
    setTimeout(function(){
      jQuery('#details-modal').remove();
      jQuery('.modal-backdrop').remove();
    },500);
  }

//   $(function () {
//
//    // install flowplayer into all elements with CSS class="player"
//    $(".player").flowplayer();
//
// });
</script>

<?php echo ob_get_clean();?>
