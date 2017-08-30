<?php
	//
	// AGAINST SPAMMERS
	//

	/*
  // SESSION BANN
 if (!isset($_SESSION)) {
         session_start();
}
 if($_SESSION['last_session_request'] > (time() - 300)){
   if(empty($_SESSION['last_request_count'])) {
     $_SESSION['last_request_count'] = 1;
}
    elseif($_SESSION['last_request_count'] < 7){
    $_SESSION['last_request_count'] = $_SESSION['last_request_count'] + 1;
    }elseif($_SESSION['last_request_count'] >= 7){
    exit ("The owner of this website has banned your IP address.");
}
} else {
  $_SESSION['last_request_count'] = 1;
}
  $_SESSION['last_session_request'] = time();
 	// END SESSION BANN
	*/

	date_default_timezone_set('Europe/Berlin'); //Change Here!
	require_once("libraries/TeamSpeak3/TeamSpeak3.php");
	include 'config.php';

	// ANTI SPAM
 function create_new_key()
 {
   $_SESSION['_oldkey'] = @$_SESSION['_newkey'];
   $_SESSION['_newkey'] = uniqid();
 }
 function check_key($key)
 {
   return ($key === @$_SESSION['_oldkey']);
 }
 function current_key()
 {
   return $_SESSION['_newkey'];
 }
 session_start();
 create_new_key();

 if (isset($_POST["create"])) {
 if(!check_key($_POST['actionkey']))
 die("Your TeamSpeak Server is already created!");
 }
	// END ANTI SPAM

  //SERVERDATABASE CONNECTION
  $database = "ts";
  $table ="ts";

  $conn[0] = mysqli_connect($DB_IP, $DB_USER, $DB_PASS);
  if (!$conn[0]) {
    echo "MYSQL Serverdatabase Error: " .mysqli_error($conn[0]);
}
  mysqli_select_db($conn[0], "$database");
  // END SERVERDATABASE CONNECTION

  // TSDATABASE CONNECTION
  $connect = "serverquery://".$USER_QUERY.":".$PASS_QUERY."@".$HOST_QUERY.":".$PORT_QUERY."";
  $ts3 = TeamSpeak3::factory($connect);
  // END TSDATABASE CONNECTION

  if($_SERVER["REQUEST_METHOD"] === "POST")
  {

		//
		// AGAINST SPAMMERS IN FORM (Might be broken at the moment)
		//

	/*  //verify captcha
	  $recaptcha_secret = "YOUR SECRETKEY";
	  $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
	  $response = json_decode($response, true);
	  if($response["success"] === true)  {
	*/

  if (isset($_POST["create"])) {
  $id = $_SESSION['id'];
  $ip = $_SERVER['REMOTE_ADDR'];
  $browser = $_SERVER['HTTP_USER_AGENT'];
  $dateTime = date('Y/m/d G:i:s');

  // SERVERDATABASE SELECT
  $select = "SELECT IP FROM $table WHERE IP = '".$_SERVER['REMOTE_ADDR']."'";
  $result = mysqli_query($conn[0], $select);
  if (mysqli_num_rows($result) > 1) {
  while($row = mysqli_fetch_assoc($result)) {
  // END SERVERDATABASE SELECT
}
} else {

  $servername = $_POST['servername'];
  $slots = $_POST['slots'];
  $unixTime = time();
  $realTime = date('[Y-m-d]-[H:i]',$unixTime);
  $serverpassword = $_POST['serverpassword'];
  $hostbanner_url = $_POST['hostbanner_url'];

  // HTML CHANGES
  if(strlen($servername) > 25) {
  exit ("The owner of this website has banned your IP address.");
}
  if(empty($_POST['servername'])) {
  exit ("The owner of this website has banned your IP address.");
}
  if(strlen($slots) > 2) {
  exit ("The owner of this website has banned your IP address.");
}
  // END HTML CHANGES

  // TEAMSPEAK CREATE
  if(empty($_POST['port'])) {
  try {
  $new_ts3 = $ts3->serverCreate(array(
  "virtualserver_name" => $servername,
  "virtualserver_maxclients" => $slots,
  "virtualserver_name_phonetic" => $realTime,
  "virtualserver_password" => $serverpassword,
  "virtualserver_hostbanner_gfx_url" => $hostbanner_url,
  ));

  $token = $new_ts3['token'];
  $portran = $new_ts3['virtualserver_port'];
}
  catch(Exception $e) {
  echo "Error (ID " . $e->getCode() . ") <b>" . $e->getMessage() . "</b>";
}
}
  // END TEAMSPEAK CREATE

  // SERVERDATABASE INSERT
  $insert = "INSERT INTO $table (Slots, Servername, Port, Passwort, IP, Browser, Date, Token)
  VALUES ('$slots', '$servername', '$portran', '$serverpassword', '$ip', '$browser', '$dateTime', '$token')";
  if (!mysqli_query($conn[0], $insert)) {
  echo "Insert Error: " .mysqli_error($conn[0]);
  // END SERVERDATABASE INSERT
}
}
}

	//
	// NEEDED FOR CAPTCHA (Might be broken at the moment)
	//

	/*
	if(!$response["success"] === true)  {
	echo '<script language="javascript">';
	echo 'alert("Check the Captcha Box!")';
	echo '</script>';
	header("Refresh:0");
	}
	*/
}

 // SERVER SCHON VORHANDEN
	$table1 ="ts";
	$conn[0] = mysqli_connect($DB_IP, $DB_USER, $DB_PASS);
	if (!$conn[0]) {
	  echo "MYSQL Serverdatabase Error: " .mysqli_error($conn[0]);
}
	mysqli_select_db($conn[0], "$database");
	$sql = "SELECT Servername, Port, Passwort, Token FROM $table1 WHERE IP = '".$_SERVER['REMOTE_ADDR']."'";
	$result1 = $conn[0]->query($sql);
 // END SERVER SCHON VORHANDEN
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
					</button><a class="navbar-brand" href="/">TeamSpeak Hosting Script v1.1</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
				<!--		<li class="inactive"><a href="/home">Home</a></li>
						<li class="inactive"><a href="/faq">FAQ</a></li>
            <li class="inactive"><a href="/news">News</a></li> -->
            <li class="active"><a href="/">Create Server</a></li>
  				</ul>
				</div>
			</nav>
		</div>
	</div>
</div>
<!-- END NAVBAR -->

<!-- START BANNER -->

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron"><center><strong>
        <h1><center>Schokolades Server <strong><span style="color:rgb(196, 84, 84);">Creator</span></strong></center></h1>
        <h3><center>The Idea behind this service is sharing free TeamSpeak servers for everyone.
          <br>Waste no time and create your own <strong>now!</strong></center></h3>
      </div>
    </div>
  </div>
</div>

<!-- STOP BANNER -->

<?php if (mysqli_num_rows($result) > 1) { ?>

	<!--
	IF IP IS IN DATABASE
	-->
  <!-- START OUTPUT SECTION -->

  <div class="container-fluid">
    <div class="row">
  		<div class="col-md-3">
  			<p></p>
  		</div>
  		<div class="col-md-6">
  			<div class="alert alert-danger" role="alert">
          <center><strong>YOU ALREADY CREATED A TEAMSPEAK SERVER!
            <br>YOU CAN CREATE ANOTHER SERVER AFTER DELETING THE OLD ONE.</strong></center>
        <!--  <center><strong>Your TeamSpeak Server get deleted if nobody connects to it for more than 7 Days. (You can create a new one if you need them)
            <br>Your TeamSpeak get deleted if nobody connects within 30 Minutes after creation. (You can create a new one if you need them)</strong></center> -->
        </div>
  		</div>
  	</div>
  </div>
  <div class="container-fluid">
  	<div class="row">
  		<div class="col-md-12">
  			<div class="row">
  				<div class="col-md-3">
  					<p></p>
  				</div>
  				<div class="col-md-6">
  					<div class="panel-body">
<?php while($row = mysqli_fetch_object($result1)) { ?>
              <div class="panel-heading">
                <h3 style="border-bottom: 1px solid #c5c5c5;">
                    <center>Your TeamSpeak Server Details!</span>
                  </h3>
                <!-- <h3><span class="glyphicon glyphicon-exclamation-sign"></span><center>Create your Server for <strong>Free</strong></center><span class="glyphicon glyphicon-exclamation-sign"></span></h3>-->
              </div>
  						<div class="panel-body">
  							<form action="#" method="post">
  								<fieldset class="form-group has-error">
  									<label for="servername">Server Name</label>
  										<div class="form-group">
  											<div class="input-group">
  												<span class="input-group-addon"><i class="fa fa-server"></i></span>
  												<input readonly type="text" name="servername" class="form-control" value="<?php echo $row->Servername; ?>"/>
  											</div>
  										</div>
  									</fieldset>
  									<fieldset class="form-group has-error">
  										<label for="servername">Server Admin Token</label>
  											<div class="form-group">
  												<div class="input-group">
  													<span class="input-group-addon"><i class="fa fa-key"></i></span>
  													<input readonly type="text" name="servername" class="form-control" value="<?php echo $row->Token; ?>"/>
  												</div>
  											</div>
  										</fieldset>
  										<fieldset class="form-group has-error">
  											<label for="servername">Server IP</label>
  												<div class="form-group">
  													<div class="input-group">
  														<span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
  														<input readonly type="text" name="servername" class="form-control" value="<?php echo $HOST_QUERY; ?>:<?php echo $row->Port; ?>"/>
  													</div>
  												</div>
  											</fieldset>
												<fieldset class="form-group has-error">
													<label for="servername">Server Password</label>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon"><i class="fa fa-key"></i></span>
																<input readonly type="text" name="servername" class="form-control" value="<?php echo $row->Passwort; ?>"/>
															</div>
															<span>Just work if you have the same password as when creating the server on our website.</span>
														</div>
													</fieldset>
  												<center>
														<a href="ts3server://<?php echo $HOST_QUERY; ?>:<?php echo $row->Port; ?>?token=<?php echo $row->Token; ?>"><button type="button" class="btn btn-primary btn-md btn-danger">Connect with Admin Token (First Connection only).</button></a>
  													<a href="ts3server://<?php echo $HOST_QUERY; ?>:<?php echo $row->Port; ?>"><button type="button" class="btn btn-primary btn-md btn-danger">Connect as Normal User.</button></a>
  												</center>
  										</form>
  									</div>
<?php } ?>
  								</div>
  							</div>
  						</div>
  					</div>
  				</div>
  			</div>
  <div class="col-xs-12" style="height:15px;"></div>
  <div class="col-md-3">
  	<p></p>
  </div>
  <div class="col-md-3">
  	<p></p>
</div>

  <!-- END OUTPUT SECTION -->

<?php } elseif (isset($_POST["create"])) { ?>

	<!--
	IF CREATE BUTTON IS PRESSED
	-->
<!-- START OUTPUT SECTION -->

<div class="container-fluid">
  <div class="row">
		<div class="col-md-3">
			<p></p>
		</div>
		<div class="col-md-6">
			<div class="alert alert-danger" role="alert">
        <center><strong>WE WILL DELETE YOUR SERVER IF THERE ARE NO CONNECTIONS WITHIN SEVEN DAYS!
          <br>YOU CAN HAVE TWO SERVERS AT THE SAME TIME - IF YOU NEED MORE CONTACT ME!</strong></center>
      </div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3">
					<p></p>
				</div>
				<div class="col-md-6">
					<div class="panel-body">
            <div class="panel-heading">
              <h3 style="border-bottom: 1px solid #c5c5c5;">
                  <center>Your <b>TeamSpeak 3 Server</b> is ready!</span>
                </h3>
              <!-- <h3><span class="glyphicon glyphicon-exclamation-sign"></span><center>Create your Server for <strong>Free</strong></center><span class="glyphicon glyphicon-exclamation-sign"></span></h3>-->
            </div>
						<div class="panel-body">
							<form action="#" method="post">
								<fieldset class="form-group has-error">
									<label for="servername">Server Name</label>
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-server"></i></span>
												<input readonly type="text" name="servername" class="form-control" value="<?php if(empty($_POST['servername'])) { echo "Change Name to avoid autodelete!"; } else { echo $servername; } ?>"/>
											</div>
										</div>
									</fieldset>
									<fieldset class="form-group has-error">
										<label for="servername">Server Admin Token</label>
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-key"></i></span>
													<input readonly type="text" name="servername" class="form-control" value="<?php echo $token; ?>"/>
												</div>
											</div>
										</fieldset>
										<fieldset class="form-group has-error">
											<label for="servername">Server IP</label>
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
														<input readonly type="text" name="servername" class="form-control" value="<?php echo $HOST_QUERY; ?>:<?php echo $portran; ?>"/>
													</div>
												</div>
											</fieldset>
												<center>
													<a href="ts3server://<?php echo $HOST_QUERY; ?>:<?php echo $portran; ?>?token=<?php echo $token; ?>"><button type="button" class="btn btn-primary btn-md btn-danger">Connect with Admin Token (First Connection only).</button></a>
													<a href="ts3server://<?php echo $HOST_QUERY; ?>:<?php echo $portran; ?>"><button type="button" class="btn btn-primary btn-md btn-danger">Connect as Normal User.</button></a>
												</center>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<div class="col-xs-12" style="height:15px;"></div>
<div class="col-md-3">
	<p></p>
</div>
<div class="col-md-3">
	<p></p>
</div>
<!-- END OUTPUT SECTION -->

<?php }
else{
?>

<!--
FIRST LOOK OF THE SITE
-->
<!-- START IMPORTANT INFOS RESULT PAGE -->

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-2">
					<p></p>
				</div>
				<div class="col-md-8">
          <p>
          </p>
				</div>
				<div class="col-md-2">
					<p></p>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- END IMPORTANT INFOS RESULT PAGE -->

<!-- START INPUT -->

<!-- START ALERT CUSTOM -->
<div class="col-md-3">
	<p></p>
</div>
<div class="col-md-6">
	<div class="alert alert-info" role="alert">
		<center><strong>PLEASE NOTE: THIS PROJECT IS FOR TEST PURPOSES ONLY AS LONG AS IT IS IN THE BETA!
			<br>YOU WILL HAVE NO RIGHTS AFTER CREATING A SERVER!</strong></center>
	</div>
</div>
<div class="col-md-3">
	<p></p>
</div>
<!-- STOP ALERT CUSTOM -->


<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3">
					<p></p>
				</div>
				<div class="col-md-6">
				<link href="css/font-awesome.min.css" rel="stylesheet">
				</div>
				<div class="col-md-6">
					<div class="pantel-body">
      				<div class="panel-heading">
                <h3 style="border-bottom: 1px solid #c5c5c5;">
                    <center>Create your <b>TeamSpeak 3 Server</b> for free!</span>
                  </h3>
								<!-- <h3><span class="glyphicon glyphicon-exclamation-sign"></span><center>Create your Server for <strong>Free</strong></center><span class="glyphicon glyphicon-exclamation-sign"></span></h3>-->
							</div>
      				<div class="panel-body">
								<form action="#" method="post">
									<fieldset class="form-group has-error">
										<label for="servername">Server Name</label>
											<div class="form-group">
  											<div class="input-group">
  												<span class="input-group-addon"><i class="fa fa-server"></i></span>
            								<input type="text" name="servername" class="form-control" placeholder="Give your Server an unique Name..." minlength="1" maxlength="25" required>
   		 									</div>
 											</div>
										</fieldset>
												<fieldset class="form-group has-error">
													<label for="slots">Server Slots</label>
														<div class="form-group">
			  											<div class="input-group">
			  												<span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
			            								<input type="number" name="slots" class="form-control" placeholder="Choose your Slots (1-75)..." min="1" max="75" step="1" required>
															</div>
															<span> You can choose up to 75 Slots.</span>
			 											</div>
													</fieldset>
                          <fieldset class="form-group has-error">
                          <div class="panel panel-default">
                            <div class="panel-heading" href="#collapse3">
                              <h6 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse3"> <strong>Optional Options</strong></a></h6>
                            </div>
                          <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">
                              <fieldset class="form-group">
            										<label for="serverpassword">Server Password</label>
            											<div class="form-group">
              											<div class="input-group">
              												<span class="input-group-addon"><i class="fa fa-server"></i></span>
                        								<input type="password" name="serverpassword" class="form-control" placeholder="Add your personal Password..." maxlength="20">
               		 									</div>
             											</div>
            										</fieldset>
                                <fieldset class="form-group">
                                  <label for="hostbanner_url">Host Banner URL</label>
                                    <div class="form-group">
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-server"></i></span>
                                          <input type="url" name="hostbanner_url" class="form-control" placeholder="Add your personal Hostbanner..." maxlength="200">
                                      </div>
                                    </div>
                                  </fieldset>
                            </div>
                          </div>
                        </div>
                      </fieldset>

										<center>
											<fieldset>
										    <legend>Choose a Datacenter which is closer to you</legend>
													<div class="btn-group radio-group" data-toggle="buttons">
														<label class="btn btn-default active">
															<input type="radio" name="servereu" id="option4" value="eu">
															<span>Middle Europe/France <img src="flags/European-Union.png" autofocus="true"></span>
										        </label>
														<label class="btn btn-default">
															<input type="radio" name="serverca" id="option2" value="ca">
															<span>North America/USA <img src="flags/united_states_of_america.png"></span>
										        </label>
													</div>
										    </fieldset>
											</center>

											<div class="col-xs-12" style="height:10px;"></div>
 											<center>
										<!-- NEEDED FOR CAPTCHA -->
                      <!--  <div class="g-recaptcha" data-sitekey="6LcQhRkUAAAAAPGr0xDvbnbdC7MdCfGrKoM9aX_s"></div> -->
										<!-- NEEDED FOR CAPTCHA -->
                        <br>
                        <input type="hidden" name="actionkey" value="<?php echo current_key() ?>" />
  											<button type="submit" class="btn-block btn btn-danger lg" name="create"><b>Create !</b></button>
											</center>
									</form>
								</div>
							</div>
							<div class="col-xs-12" style="height:15px;"></div>
					</div>
					<div class="col-md-3">
						<p></p>
					</div>
			</div>
		</div>
	</div>
</div>
<!-- END INPUT -->
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
<!-- NEEDED FOR CAPTCHA -->
	<!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
<!-- NEEDED FOR CAPTCHA -->
</body>
</html>
