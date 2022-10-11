<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/mainheader.php';
  include 'includes/leftsidebar.php';

  $sql = "SELECT * FROM products WHERE featured = 1";
  $featuredProducts = $db->query($sql);

?>

   <div class="col-md-8">
     <div class="row">
       <h2 class="text-center">Featured Products</h2><hr>
       <?php while($product = mysqli_fetch_assoc($featuredProducts)):?>
         <div class="col-md-4 text-center">
           <h4><?php echo (strlen($product['title']) > 17) ? substr($product['title'], 0, 17) . '...' : $product['title'];?></h4>
           <?php $photos = explode(',',$product['image']); ?>
           <img src="<?php echo $photos[0];?>" class="img-thumb img-thumbnail" alt="<?php echo $product['title'];?>">
           <p class="price">Our Price: ₱<?php echo $product['price'];?></p>
           <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?php echo $product['id'];?>)">Details</button>
         </div>
       <?php endwhile;?>
       </div>
       <!-- <div class="center">
         <div class="pagination">
            <a href="#">&laquo;</a>
            <a href="#">1</a>
            <a class="active" href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">5</a>
            <a href="#">6</a>
            <a href="#">&raquo;</a>
         </div>
       </div> -->
   </div>


<?php
  include 'includes/rightsidebar.php';
  include 'includes/footer.php';
?>
