    <title><?php echo $pageName?> Page</title>

    <!-- Bootstrap core CSS -->
    <link href="../Bootstrap_files/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../Bootstrap_files/css/jumbotron.css" rel="stylesheet">
    
    	<style type="text/css"></style></head>

  <body style="">
  
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         <!--  <a class="navbar-brand" href="#">Project name</a>  -->
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
             <?php if($pageName=="Home"){echo "<li class=\"active\">";}else{echo "<li>";}?><a href="../main/index.php">Home</a></li>
             <?php if($pageName=="New User"){echo "<li class=\"active\">";}else{echo "<li>";}?><a href="../main/newProfile.php">Register</a></li>
             <?php if($pageName=="Forgot Password"){echo "<li class=\"active\">";}else{echo "<li>";}?><a href="../main/forgotPW.php">Forgot Password</a></li>
          </ul>
       		<form class="navbar-form navbar-right" role="form" action="../main/index.php" onsubmit="return check_email('email')" method="post">";
            	<input type="hidden" name="id" value=
            		<?php if(empty($_SESSION['ID']))
            			echo  "\"_\"";
            		else
            			echo "\"".$_SESSION['ID']."\"";?>
            		/>
            	<div class="form-group">
            		<input type="email" id="email" name="email" placeholder="Email" class="form-control" required>
            	</div>
            	<div class="form-group">
            		<input type="password" id="password" name="password" placeholder="Password" class="form-control" required>
            	</div>
            	<button type="submit" class="btn btn-success">Sign in</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
    
