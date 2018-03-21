<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';
  include 'includes/leftsidebar.php';

  if (isset($_GET['cat'])) {
    $catID = sanitize($_GET['cat']);
  }else {
    $catID = '';
  }

  $sql = "SELECT * FROM products WHERE categories = '$catID'";
  $productQ = $db->query($sql);
  $category = get_category($catID);
?>

      <!-- Main Content -->
      <div class="col-md-8">
        <div class="row">
          <h2 class="text-center"><?php echo $category['parent']. ' - ' . $category['child'];?></h2>
          <?php while($product = mysqli_fetch_assoc($productQ)):?>
            <div class="col-md-3 text-center">
              <h4><?php echo $product['title'];?></h4>
              <?php $photos = explode(',',$product['image']);?>
              <img src="<?php echo $photos[0];?>" class="img-thumb" alt="<?php echo $product['title'];?>">
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
