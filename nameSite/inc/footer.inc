 <!-- FOOTER -->
      
     </div><!-- /.container -->
    
    <footer class="footer">
      <div class="footer-container">
        <p class="text-muted pull-left">Dallas, Texas</p>
        <p class="text-muted pull-right">&copy; 2014 – 
	   <?php
		date_default_timezone_set('US/Central');
		echo date('Y');
		echo ' ';
		echo $_SERVER['HTTP_HOST'];
	   ?> 
	</p>
      </div><!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../Bootstrap_files/jquery.min.js"></script>
    <script src="../Bootstrap_files/bootstrap.min.js"></script>
    <script src="../Bootstrap_files/docs.min.js"></script>


 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85222026-1', 'auto');
  ga('send', 'pageview');

</script> 

</body></html>
