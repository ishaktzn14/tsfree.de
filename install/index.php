<?php
	date_default_timezone_set('Europe/Berlin'); //Change Here!
	include 'config.php';

	// Create connection
	$conn = mysqli_connect($host, $user, $pass);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

  if($_SERVER["REQUEST_METHOD"] === "POST"){

if (isset($_POST["create"])) {
// Create database
$cdata = "CREATE DATABASE $db";
if (!mysqli_query($conn, $cdata)) {
		echo "Insert Error: " .mysqli_error($conn);
}
// sql to create table
mysqli_select_db($conn, "$db");
$ctable = "CREATE TABLE $table (
ID int(30) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Slots text(255) NOT NULL,
Servername text(255) NOT NULL,
Port text(255) NOT NULL,
Passwort text(255),
IP text(255) NOT NULL,
Browser text(255) NOT NULL,
Date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
Token text(255) NOT NULL
)";
if (!mysqli_query($conn, $ctable)) {
	echo "Insert Error: " .mysqli_error($conn);
}
}
}

 mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge"></meta>
<meta name="viewport" content="width=device-width, initial-scale=1"></meta>
<meta http-equiv="content-type" content="text/html; charset=utf-8"></meta>
<META HTTP-EQUIV="Pragma" content="cache"></meta>
<META NAME="ROBOTS" CONTENT="all"></meta>
<META HTTP-EQUIV="Content-Language" CONTENT="en"></meta>
<META NAME="description" CONTENT="Free TeamSpeak3 server generator that allow you to create your own server for FREE. Get your own Server today">
<META NAME="keywords" CONTENT="schokolade.gq, schokolade, freets3, ts3free, ts3, hosting teamspeak 3, teamspeak server, free teamspeak 3 server, serwery ts3, teamspeak 3 servers, teamspeak 3 hosting , serwer teamspeak 3, free ts3 server hosting, server generator, russia ts3, moscow ts3, russia free ts">
<meta name="author" content="schokolade.gq">

<title>Server | Schokolade Hosting</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/customers.css" rel="stylesheet">
<link rel="stylesheet" href="css/font-awesome.min.css">
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
</head>
<body>

	<!--START NAVBAR -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar navbar-default" role="navigation">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						 	<span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
						</button><a class="navbar-brand" href="/">Schokolade Hosting Beta 1.1</a>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
	            <li class="active"><a href="/">Install</a></li>
	  				</ul>
					</div>
				</nav>
			</div>
		</div>
	</div>
	<!-- END NAVBAR -->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<p></p>
		</div>
		<div class="col-md-6">
			<div class="alert alert-info" role="alert">
				<center><strong>START THE DATABASE INSTALLATION!
					<br>If you want to start the Database Installation Click the "Install" Button.</strong></center>
			</div>
		</div>
	</div>
</div>
<div class="panel-body">
	<form action="#" method="post">
				<div class="col-xs-12" style="height:10px;"></div>
				<center>
					<button type="submit" class="btn-block btn btn-danger lg" name="create"><b>Install!</b></button>
				</center>
		</form>
	</div>
<?php } ?>

	<!-- START FOOTER -->

	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="copyright">
						By using this and all other Schokolade.gq services you accepting our <a href="/tos">ToS</a>.
						<br>
						Copyright &copy; 2017 Schokolade Hosting - Developed by <a href="#" class="theme-author">panteL</a> | <a href="#">Impressum</a> | <a href="#">Datenschutz</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END FOOTER -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/ga.js"></script>
</body>
</html>
