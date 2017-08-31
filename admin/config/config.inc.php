<?php
date_default_timezone_set('Australia/Victoria');

$db_username        = 'root'; //MySql database username
$db_password        = ''; //MySql dataabse password
$db_name            = 'ts'; //MySql database name
$db_host            = 'localhost'; //MySql hostname or IP

$con = mysqli_connect($db_host,$db_username,$db_password,$db_name);
// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$HOST_QUERY = "schokolade.gq";  // Localhost is invalid! You need to add an IP (Otherwise you can't join the created TeamSpeak)
$PORT_QUERY = "10011";
$USER_QUERY = "serveradmin";
$PASS_QUERY = "";

?>
