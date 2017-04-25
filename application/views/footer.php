</body>
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo APP_URL?>/assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="<?php echo APP_URL?>/assets/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function(){ 
    $(".nav a").each(function(){ 
	  $this = $(this); 
	  if($this[0].href==String(window.location)){ 
	    $this.parent().addClass("active"); 
	  } 
	}); 
  });
</script>
</html>