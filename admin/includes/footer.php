</div><!-- closing div for container-fluid -->

<!-- Footer -->
<footer class="text-center" id="footer">&copy; Copyright 2017-2018 Gemporium</footer>

<script>
  //Onclick event for 'Save changes' button
  function updateSizes(){
    var sizeString = '';
    for (var i = 1; i <= 12; i++) {
      if (jQuery('#size'+i).val()!='') {
        sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
      }
    }
    jQuery('#sqPreview').val(sizeString);
  }

  // products.php Add product Form get Child Category function
  function get_child_options(){
    var parentID = jQuery('#parent').val();
    jQuery.ajax({
      url: '/gemporium/admin/parsers/child_categories.php',
      type: 'POST',
      data: {parentID : parentID},
      success: function(data){
        jQuery('#child').html(data);
      },
      error: function(){alert("Something went wrong with the child options.")},
    });
  }
  // Listener for Parent Category <select></select>
  jQuery('select[name="parent"]').change(get_child_options);
</script>
</body>
</html>
