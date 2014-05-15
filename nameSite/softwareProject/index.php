<?php session_start();

/*begin JAVA_BRIDGE*/
	require_once("./JavaConnect.inc");
	$phpDebugOutput=setBridge("/Java_Bridge/GUIProfile");
/*end JAVA_BRIDGE*/
	$loggedout="";
if (!(empty($_POST["logout"])))
{
	session_destroy();
	$result=""; //java_context()->getServlet()->logout($_SESSION['ID']);
	//ignore result
	if(!empty($_SESSION['EMAIL']))		
	{
		$loggedout= "<br><b>".$_SESSION['EMAIL'].": You have been logged out.</b><hr>";
		$_SESSION['EMAIL'] = null;
		$_SESSION['ID'] = null;
	}
	else
		$loggedout= ""; //<b>You weren't even logged in..</b><br/><i>Why are your even here..?</i>";
}	
else if (!(empty($_POST["email"]))) 
{
	if(($_SESSION['ID'] == $_POST['id']) & ($_SESSION['EMAIL'] == $_POST['email']))  
		$authenticate=Array("","you were already logged on, loggin on again with the same credentials is unnessasary...");
	else
	{
		$id=uniqid($_POST['email'].":", true);			//newID, newEmail, pw, oldID
		$authenticate=java_context()->getServlet()->login($id, $_POST["password"], $_SESSION['ID']);
		if($_SESSION['ID']!=null)
		{
			//if logged in already, distroy that loggin
			session_destroy();
			session_start();
		}
		
		// login...
		if($authenticate[0] == "TRUE")
		{	//logged in, set session and go to home
			$_SESSION['EMAIL'] = $_POST['email'];
			$_SESSION['ID'] = $id;
			//header("Location: home.php?notifyActivity=".$authenticate[1]);
			//exit;
		}
	}
}							               //header debug
getHeader("Home", $_SESSION['ID'], false, $phpDebugOutput);
echo "</head>";
echo "<body>";


echo "<div class=\"container\">";
if($loggedout!=null && $loggedout!="")
{
	echo "<br/>";
	echo $loggedout;
}

if (!(empty($authenticate)))   
{
	//loggin error messages
//	echo $authenticate[1];
	//TODO OPTION TO KICK OUT OLD USERS/OPTION FOR FORGOT PASSWORD
//	echo "<br/>";
//}
//else if($authenticate[0] == "TRUE")
//{	//logged in, set session and go to home
	if($authenticate[1]!=null && $authenticate[1]!="")
	{
		echo "<br/>";
		echo $authenticate[1];
	}
}
	//if (!(empty($_SESSION['EMAIL'])))// && session_status()==PHP_SESSION_ACTIVE)
	//{
		//echo 'You are already logged on as '.$_SESSION['EMAIL'].'.<br>';
		//echo 'You may log on as a different user (which will logout '.$_SESSION['EMAIL'].').';
	//}	
echo "<br/>";
echo "</div>";
	
?>
		
    <!-- Main jumbotron for a primary marketing message or call to action -->

<hr/>
   <div class="container">
  	<p>
		<h4>Sample of the SenQual Project: </h4>
		This is a functionally limited version of the original project until I can host 
		the whole project on a tomcat server, so currently data is hard coded.<br/>
		As part of CS 4311 Software Engineering, this web application 
		lets users specify contstraints over different types of weather 
		sensors and alerts the user if sensor data has exceeded said constraints.<br/>
		It conforms to the layout specified in the Software Requirements Specification Document for the project.<br/>
		<br/>
		For the project I used a Three-Tiered Archetecture using the  
		<a href="http://php-java-bridge.sourceforge.net/pjb/" target="_blank">PHP/Java Bridge</a>, web 2.0 for the presentation layer, 
		and actual Java for the business layer (Tomcat Server), and MySQL for the database. <br/>
			
		Please use this as a very simple example of javascript form interaction. Thank you.<br/>
		<a href="../main/projects.php#SenQual">return to StevenWerner.Name projects</a>
	</p>	
	<hr>
   </div> 
    <div class="jumbotron">
      <div class="container">
      <?php
        if (!(empty($_SESSION['EMAIL'])))
        {
        	echo "<h2>".$_SESSION['EMAIL']."</h2><h3><br/>Welcome back to SenQual</h3>";
        	echo "	<p>The Sensor Quality (SenQual) Monitor System provides
					   users with the ability to specify rules that can be used
					   to monitor data collected in near real time or data that
					   has been stored in files.</p>";
        }
		else
		{	echo "<form action=\"newProfile.php\" method=\"post\" role=\"form\">";
			echo "<h1>Welcome to SenQual</h1>";
			echo "	<p>The Sensor Quality (SenQual) Monitor System provides 
					   users with the ability to specify rules that can be used 
					   to monitor data collected in near real time or data that 
					   has been stored in files.</p>";
			//echo "<p><button type=\"submit\" class=\"btn btn-primary btn-lg\" role=\"button\">New user? Register here »</button></p>";
        	echo "</form>";
		}
      ?>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <?php if (!(empty($_SESSION['EMAIL']))){echo "<h4>Sensors</h4>";} else{echo "<h2>Sensors</h2>";}?>
          <p>Manage registered sensors in a brand new way! Embeded GoogleMaps<sup>&reg;</sup> gives you a geospacial view of all of your sensors. You can add modify sensor metadata, and even search through all metadata to find just what your looking for.</p>
      	<!-- <p><a class="btn btn-default" href="http://getbootstrap.com/examples/jumbotron/#" role="button">View details »</a></p>  -->
        </div>
        <div class="col-md-4">
          <?php if (!(empty($_SESSION['EMAIL']))){echo "<h4>Rules</h4>";} else{echo "<h2>Rules</h2>";}?>
          <p>Formally known as 'Data Properties', SenQual allows you to create anything from a simple 'this must always be true' rule to a highly technical 5 option duration bounded rule, with 4 option definiton. Each formula is capable of multiple computing multiple sensors, and AND/OR/NOT boolean operators.</p>
       <!-- <p><a class="btn btn-default" href="http://getbootstrap.com/examples/jumbotron/#" role="button">View details »</a></p>  -->
       </div>
        <div class="col-md-4">
          <?php if (!(empty($_SESSION['EMAIL']))){echo "<h4>Dashboard Graphs</h4>";} else{echo "<h2>Dashboard Graphs</h2>";}?>
          <p>Once you 'Monitor' your rules, you can not only get notifications of anomallies, but with embedded FusionCharts<sup>&reg;</sup> you can see them too! We provide you monitored data to be graphed, and anomalies are highlited for easy view, and raw data is provided for view and/or download as well.</p>
        <!-- <p><a class="btn btn-default" href="http://getbootstrap.com/examples/jumbotron/#" role="button">View details »</a></p>  --> 
        </div>
      </div>
	<br/><br/>
      <hr>
<?php include("./footer.inc")?>
