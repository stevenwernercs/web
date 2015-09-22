<?php
$pageTitle="Steven:projects";
$pageName="projects";
require_once("../inc/header.inc");
?>

 <!-- static Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide">
      <div class="carousel-inner">
        <div class="item active">
          <div class="container">
            <div class="carousel-caption">
	      <p><img
    src="../img/square/workin.jpg" width="200" height="200" class="img-circle"></p>
              <p style="font-size:40px">some<b>projects</b></p>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.carousel -->

    <br/>
    <br/>
        

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img class="img-circle" src="../img/square/minecraft.png" style="width: 140px; height: 140px;">
          <h2>Minecraft ANN</h2>
          <p>NPC (non-player characters) controlled by artificial neural networks. A sort of genetic
		expieriement using the minecraft universe as the learning stage.</p>
          <!-- <p><a class="btn btn-default" href="http://getbootstrap.com/examples/carousel/#" role="button">View details »</a></p> -->
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="../img/square/xcode.png" style="width: 140px; height: 140px;">
          <h2>iOS Development</h2>
          <p>One man app development, realizing a few app ideas I've kept to myself. See 
	<a href="http://www.trifidEarth.com" target="_blank">trifidEarth.com</a> for more information.</p>
          <!-- <p><a class="btn btn-default" href="http://getbootstrap.com/examples/carousel/#" role="button">View details »</a></p> -->
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="../img/square/openworm.jpg" style="width: 140px; height: 140px;">
          <h2><a href="www.openworm.org" target="_blank" title="OpenWorm.org">OpenWorm</a></h2>
          <p>OpenWorm aims to build the first comprehensive computational 
	model of the C. elegans, a microscopic roundworm. I am helping in 
	order to better understand neural networks from a biological perspective.</p>
          <!-- <p><a class="btn btn-default" href="http://getbootstrap.com/examples/carousel/#" role="button">View details »</a></p> -->
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
	  <h2 class="featurette-heading">So Many Ideas: <span class="text-muted">so little time</span></h2>
          <p class="lead">With money left over from my time in Iraq, I am at a unique postion
		to follow my own passions. Reading, practice, trial and error. Will make for 
		a better self.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive" src="../img/square/labtop.jpg" style="width: 500px; height: 500px;">
        </div>
      </div>  

	<hr class="featurette-divider">

	<div class="row">
		<div class="col-lg-4">
			<h1> </h1>
		</div>
		<div class="col-lg-4">
			<h1>Past Projects</h1>
		</div>
		<div class="col-lg-4">
			<h1> </h1>
		</div>
	</div>

    <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-5">
		<img class="featurette-image img-responsive" src="../img/square/senqual.jpg" style="width: 500px;">
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading">SenQual: <span class="text-muted">Anomaly Detection</span></h2>
          <p class="lead">As part of CS 4311 Software Engineering, this web 
			application lets users specify contstraints over different types of weather sensors
			and alerts the user if sensor data has exceeded said constraints.<br/>
			<a href="../softwareProject/index.php" target="_blank" name="SenQual">This is a sample until I manage a Tomcat Server</a>
			</p>
        </div>
      </div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->

<?php include_once("../inc/footer.inc"); ?>     
