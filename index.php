<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/mainheader.php';
  include 'includes/leftsidebar.php';

  $sql = "SELECT * FROM products WHERE featured = 1";
  $featuredProducts = $db->query($sql);
?>

      <!-- Main Content -->
      <div class="col-md-8">
        <div class="row">
          <h2 class="text-center">Featured Products</h2>
          <?php while($product = mysqli_fetch_assoc($featuredProducts)):?>
            <div class="col-md-3 text-center">
              <h4><?php echo $product['title'];?></h4>
              <img src="<?php echo $product['image'];?>" class="img-thumb" alt="<?php echo $product['title'];?>">
              <p class="price">Our Price: ₱<?php echo $product['price'];?></p>
              <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?php echo $product['id'];?>)">Details</button>
            </div>
          <?php endwhile;?>
        </div>
      </div>

<?php
  include 'includes/rightsidebar.php';
  include 'includes/footer.php';
?>
