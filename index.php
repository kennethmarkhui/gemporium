<!DOCTYPE html>
<html>
  <head>
    <title>Gemporium</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>

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
          <a class="navbar-brand" href="#">Gemporium</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="#">Necklaces</a></li>
            <li><a href="#">Bracelets</a></li>
            <li><a href="#">Earrings</a></li>
            <li><a href="#">Rings</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Others <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Watches</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Header -->
    <div id="headerWrapper"></div>

    <div class="container-fluid">
      <!-- Left Side Bar -->
      <div class="col-md-2">
        Left Side Bar
      </div>
      <!-- Main Content -->
      <div class="col-md-8">
        <div class="row">
          <h2 class="text-center">Featured Products</h2>
          <div class="col-md-3">
            <h4>Tiffany's Necklace</h4>
            <img src="images/products/necklace.jpg" class="img-thumb" alt="Tiffany's Necklace">
            <p class="list-price text-danger">List Price <s>₱100</s></p>
            <p class="price">Our Price: ₱50</p>
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
          </div>

          <div class="col-md-3">
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
          </div>
        </div>
      </div>

      <!-- Right Side Bar -->
      <div class="col-md-2">
        Right Side Bar
      </div>
    </div>

    <!-- Footer -->
    <footer class="text-center" id="footer">&copy; Copyright 2017-2018 Gemporium</footer>

    <!-- Details Modal -->
    <div class="modal fade details-1" id="details-1" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal" aria-labe="Close">
              <span aria-hidden="true">&times;</span>
            </button> -->
            <h4 class="modal-title text-center">Tiffany's Necklace</h4>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">
                  <div class="center-block">
                    <img src="images/products/necklace.jpg" alt="Tiffany's Necklace" class="details img-responsive">
                  </div>
                </div>
                <div class="col-sm-6">
                  <h4>Details</h4>
                  <p>Shiny Cheap Necklace</p>
                  <hr>
                  <p>Price: ₱50</p>
                  <p>Brand: Tiffany</p>
                  <hr />
                  <form action="add_cart.php" method="post">
                    <div class="form-group">
                      <div class="col-xs-3">
                        <label for="quantity">Quantity:</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="0">
                      </div>
                      <!-- <p>Available: 3</p> -->
                    </div>
                    <div class="form-group">
                      <div class="col-xs-3">
                        <label for="size">Size:</label>
                        <select name="size" id="size" class="form-control">
                          <option value=""></option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                        </select>
                      </div>
                    </div>
                  </form><br><br><br><br><hr>
                  <button type="submit" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</button>
                  <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="modal-footer">


          </div> -->
        </div>
      </div>
    </div>

  </body>
</html>
