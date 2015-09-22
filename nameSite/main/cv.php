<?php
$pageTitle="Steven:résumé";
$pageName="resume";
require_once("../inc/header.inc");
?>


 <!-- static Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide">
      <div class="carousel-inner">
        <div class="item active">
          <div class="container">
            <div class="carousel-caption">
	      <p><a href="http://www.isca-speech.org/archive/interspeech_2013/i13_1569.html"  target="_blank"><img
    src="../img/square/interspeech.jpg" width="200" height="200" class="img-circle"
    title="Interspeech 2013 Lyon, France"></a></p>
              <a href="../documents/Werner-Resume.pdf" target="_blank"><p style="font-size:40px">curriculum<b>vitae</b></p></a>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.carousel -->        

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- START THE FEATURETTES -->

	<br/><br/>

	<div class="row">
	  <div class="center-block">
	 <object data="../documents/Werner-Resume.pdf" type="application/pdf" width="100%" height="2145">
  		<p>Your device is unable to view embedded PDFs :( <a href="../documents/Werner-Resume.pdf">Click to open cv</a>)</p>
	</object>
	</div>
	</div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->


<?php include_once("../inc/footer.inc"); ?>    
