</div><!-- closing div for container-fluid -->

<!-- Footer -->
<footer class="text-center" id="footer">&copy; Copyright 2017-2018 Gemporium</footer>

<script>
  function detailsmodal(id){
    var data = {"id" : id};
    jQuery.ajax({
      url : "<?php echo BASEURL;?>includes/detailsmodal.php",
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
</script>

</body>
</html>
