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
              <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
            </div>
          <?php endwhile;?>
          <!-- <div class="col-md-3">
            <h4>Etsy's Family Necklace</h4>
            <img src="images/products/familynecklace.jpg" class="img-thumb" alt="Etsy's Family Necklace">
            <p class="list-price text-danger">List Price <s>₱150</s></p>
            <p class="price">Our Price: ₱100</p>
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
          </div>

          <div class="col-md-3">
            <h4>Yellow Gold Necklace</h4>
            <img src="images/products/yellowgoldnecklace.jpg" class="img-thumb" alt="Yellow Gold Necklace">
            <p class="list-price text-danger">List Price <s>₱100</s></p>
            <p class="price">Our Price: ₱50</p>
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
          </div>

          <div class="col-md-3">
            <h4>Victorian Jewelry Ring</h4>
            <img src="images/products/victorianjewelry.jpg" class="img-thumb" alt="Victorian Jewelry Ring">
            <p class="list-price text-danger">List Price <s>₱100</s></p>
            <p class="price">Our Price: ₱50</p>
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
          </div>

          <div class="col-md-3">
            <h4>Hoop Earring</h4>
            <img src="images/products/hoopearring.jpg" class="img-thumb" alt="Hoop Earring">
            <p class="list-price text-danger">List Price <s>₱100</s></p>
            <p class="price">Our Price: ₱50</p>
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
          </div>

          <div class="col-md-3">
            <h4>Walmart Bracelet</h4>
            <img src="images/products/walmartbracelet.jpeg" class="img-thumb" alt="Walmart Bracelet">
            <p class="list-price text-danger">List Price <s>₱100</s></p>
            <p class="price">Our Price: ₱50</p>
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
          </div>

          <div class="col-md-3">
            <h4>Birthstone Ring</h4>
            <img src="images/products/birthstonering.jpg" class="img-thumb" alt="Birthstone Ring">
            <p class="list-price text-danger">List Price <s>₱100</s></p>
            <p class="price">Our Price: ₱50</p>
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
          </div> -->

        </div>
      </div>

<?php
  include 'includes/detailsmodal.php';
  include 'includes/rightsidebar.php';
  include 'includes/footer.php';
?>
