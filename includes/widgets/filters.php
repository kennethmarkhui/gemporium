<?php
  $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
  $price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
  $min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
  $max_price = ((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']):'');
?>
<h3 class="text-center">Sort By:</h3><hr>
<h4 class="text-center">Price</h4>
<form action="search.php" method="post" class="text-center">
  <input type="hidden" name="cat" value="<?php echo $cat_id;?>">
    <input type="hidden" name="price_sort" value="0 ">
  <input type="radio" name="price_sort" value="low"<?php echo (($price_sort == 'low')?' checked':'');?>>Low to High<br>
  <input type="radio" name="price_sort" value="high"<?php echo (($price_sort == 'high')?' checked':'');?>>High to Low<br><br>
  <div class="form-group">
    <div class="input-group">
          <input type="text" name="min_price" class="form-control" placeholder="Min ₱" value="<?php echo $min_price;?>">
          <div class="input-group-addon">To</div>
          <input type="text" name="max_price" class="form-control" placeholder="Max ₱" value="<?php echo $max_price;?>">
    </div>
  </div>
  <input type="submit" class="btn btn-sm btn-primary" value="Search">
</form>
