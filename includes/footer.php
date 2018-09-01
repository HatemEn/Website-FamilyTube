 	<footer class="blog-footer">
      <p>The bolg build by <a href="">hatem</a>, Copyright 2017</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="./includes/js/jquery.js"></script>
  <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./includes/bootstrap/js/bootstrap.min.js?6.2"></script>
    <!-- custom script -->
    <script>
    	function focusFunction () {
			document.getElementById("search_box").style.width = '<?php if ($mobile) echo "100%"; else echo "80%"; ?>';
			document.getElementById("toggle_button").style.paddingRight = '0%';
			document.getElementById("nav_style").style.background = '#428AAC';
		}
		function onblurFunction () {
			document.getElementById("search_box").style.width = '40%';
			document.getElementById("toggle_button").style.paddingRight = '25%';
			document.getElementById("nav_style").style.background = '#428BCA';
		}
    </script>
  </body>
</html>