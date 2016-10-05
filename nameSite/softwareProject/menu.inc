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
         <a class="navbar-brand" href="index.php">SenQual</a>
          <ul class="nav navbar-nav">
            <?php if($pageName=="Home"){echo "<li class=\"active\">";}else{echo "<li>";}?><a href="index.php">Home</a></li>
            <?php if($pageName=="Dashboard"){echo "<li class=\"active\">";}else{echo "<li>";}?><a href="#">Dashboard~</a></li>
            <?php if($pageName=="Monitor"){echo "<li class=\"active\">";}else{echo "<li>";}?><a href="#">Monitor~</a></li>
            <?php if($pageName=="Rule"){echo "<li class=\"active\">";}else{echo "<li>";}?><a href="rule.php">Rules</a></li>
            <?php if($pageName=="Sensor"){echo "<li class=\"active\">";}else{echo "<li>";}?><a href="sensors.php">Sensors</a></li>
            <?php if($pageName=="Profile"){echo "<li class=\"active\">";}else{echo "<li>";}?><a href="#">Profile~</a></li>
          </ul>
        </div>
        <div class="navbar-collapse collapse">
       		<form class="navbar-form navbar-right" role="form" action="index.php" method="post">
       			<input type="hidden" name="logout" value="logout"/>
            	<button type="submit" class="btn btn-success">log out</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
    
