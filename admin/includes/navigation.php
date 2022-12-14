<!-- Navigation Bar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">

    <!-- Mobile Display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/admin/index.php">Gemporium Admin</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          <!-- Menu Items -->
          <li><a href="index.php">My Dashboard</a></li>
          <li><a href="categories.php">Categories</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="archived.php">Archived</a></li>
          <?php if(has_permission('admin')):?>
            <li><a href="users.php">Users</a></li>
          <?php endif;?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $userData['first'];?><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="change_password.php">Change Password</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
          <!-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#"></a></li>
            </ul>
          </li> -->
      </ul>
    </div>
  </div>
</nav>
