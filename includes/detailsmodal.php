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
    </div>
  </div>
</div>
