<?php
  $sql = "SELECT * FROM categories WHERE parent = 0";
  $productQuery = $db->query($sql);
?>
<!-- Navigation Bar -->
<nav class="navbar-default navbar-inverse navbar-fixed-top">
  <div class="container">

    <!-- Mobile Display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Gemporium</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php while($parent = mysqli_fetch_assoc($productQuery)):?>
          <?php
            $parent_id =$parent['id'];
            $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
            $childQuery = $db->query($sql2);
          ?>

          <!-- Menu Items -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category'];?><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <?php while($child = mysqli_fetch_assoc($childQuery)):?>
                <li><a href="category.php?cat=<?php echo $child['id'];?>"><?php echo $child['category'];?></a></li>
              <?php endwhile;?>
            </ul>
          </li>
        <?php endwhile;?>
        <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>My Cart</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>
