</div><!-- closing div for container-fluid -->

<!-- Footer -->
<footer class="text-center" id="footer">&copy; Copyright 2017-2018 Gemporium</footer>

<script>
  function detailsmodal(id){
    var data = {"id" : id};
    jQuery.ajax({
      url : "/gemporium/includes/detailsmodal.php",
      method : "post",
      data : data,
      success : function(data){
        jQuery('body').append(data);
        jQuery('#details-modal').modal('toggle');
      },
      error : function(error){
        alert("Something went wrong!");
        console.debug(error);
      }
    });
  }

  function add_to_cart(){
    jQuery('#modal_errors').html("");
    var size = jQuery('#size').val();
    var quantity = jQuery('#quantity').val();
    var available = jQuery('#available').val();
    var error = '';
    var data = jQuery('#add_product_form').serialize();
    if (size == '' || quantity == '' || quantity == 0) {
      error += '<p class="text-danger text-center">You must choose a size and quantity.</p>';
      jQuery('#modal_errors').html(error);
      return;
    }else if(quantity>available) {
      error += '<p class="text-danger text-center">There are only '+available+' available.</p>';
      jQuery('#modal_errors').html(error);
      return;
    }else {
      jQuery.ajax({
        url : '/gemporium/admin/parsers/add_cart.php',
        method : 'POST',
        data : data,
        success : function(){
          location.reload();
        },
        error : function(){alert("Somthing went wrong!");}
      });
    }
  }
</script>
</body>
</html>
