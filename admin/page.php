<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "./config/config.inc.php";
@include "./session_member.php";
@include "./Ajax/ts3admin.class.php";

// Sanitize $_GET parameters to avoid XSS and other attacks
$AVAILABLE_PAGES = array('dashboard', 'banned', 'log', 'adminlog', 'server', 'users', 'edituser');
$AVAILABLE_PAGES = array_fill_keys($AVAILABLE_PAGES, 1);

$page = $_GET['page'];
if (!$AVAILABLE_PAGES[$page]) {
   header("HTTP/1.0 404 Not Found");
   die('Page not found.');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Panel | Schokolade Hosting</title>
<link href="./bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="./font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
<style type="text/css">
    h1.page-header {
    margin-top: -5px;
}
.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
    color: #fff;
    background-color: #d9534f;
    border-bottom-left-radius:
    0px;
    border-bottom-right-radius:
    0px;
    border-top-left-radius:
    0px;
    border-top-right-radius:
    0px;
}
.btn-primary {
  color: #fff;
  background-color: #d9534f !important;
  border-color: #d9534f !important;
}
.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
  z-index: 2;
  color: #fff;
  cursor: default;
  background-color: #d9534f !important;
  border-color: #d9534f !important;
}
.label-info {
    background-color: #d9534f;
}

.bg-primary {
    color: #fff;
    background-color: #d9534f;
}

.copyright {
		text-align: center;
}

.sidebar {
	padding-left: 0;
  padding-right: 10;
}

.main-container {
	background: #FFF;
	padding-top: 15px;
	margin-top: -20px;
}

.footer {
	width: 100%;
}

:focus {
	outline: none;
}

.side-menu {
	position: relative;
	width: 100%;
	height: 100%;
	background-color: #f8f8f8;
	border-right: 1px solid #e7e7e7;
}
.side-menu .navbar {
	border: none;
}
.side-menu .navbar-header {
	width: 100%;
	border-bottom: 1px solid #e7e7e7;
}
.side-menu .navbar-nav .active a {
	background-color: transparent;
	margin-right: -1px;
	border-right: 5px solid #e7e7e7;

}
.side-menu .navbar-nav li {
	display: block;
	width: 100%;
	border-bottom: 1px solid #e7e7e7;
}
.side-menu .navbar-nav li a {
	padding: 15px;
}
.side-menu .navbar-nav li a .glyphicon {
	padding-right: 10px;
}
.side-menu #dropdown {
	border: 0;
	margin-bottom: 0;
	border-radius: 0;
	background-color: transparent;
	box-shadow: none;
}
.side-menu #dropdown .caret {
	float: right;
	margin: 9px 5px 0;
}
.side-menu #dropdown .indicator {
	float: right;
}
.side-menu #dropdown > a {
	border-bottom: 1px solid #e7e7e7;
}
.side-menu #dropdown .panel-body {
	padding: 0;
	background-color: #f3f3f3;
}
.side-menu #dropdown .panel-body .navbar-nav {
	width: 100%;
}
.side-menu #dropdown .panel-body .navbar-nav li {
	padding-left: 15px;
	border-bottom: 1px solid #e7e7e7;
}
.side-menu #dropdown .panel-body .navbar-nav li:last-child {
	border-bottom: none;
}
.side-menu #dropdown .panel-body .panel > a {
	margin-left: -20px;
	padding-left: 35px;
}
.side-menu #dropdown .panel-body .panel-body {
	margin-left: -15px;
}
.side-menu #dropdown .panel-body .panel-body li {
	padding-left: 30px;
}
.side-menu #dropdown .panel-body .panel-body li:last-child {
	border-bottom: 1px solid #e7e7e7;
}
.side-menu #search-trigger {
	background-color: #f3f3f3;
	border: 0;
	border-radius: 0;
	position: absolute;
	top: 0;
	right: 0;
	padding: 15px 18px;
}
.side-menu .brand-name-wrapper {
	min-height: 50px;
}
.side-menu .brand-name-wrapper .navbar-brand {
	display: block;
}
.side-menu #search {
	position: relative;
	z-index: 1000;
}
.side-menu #search .panel-body {
	padding: 0;
}
.side-menu #search .panel-body .navbar-form {
	padding: 0;
	padding-right: 50px;
	width: 100%;
	margin: 0;
	position: relative;
	border-top: 1px solid #e7e7e7;
}
.side-menu #search .panel-body .navbar-form .form-group {
	width: 100%;
	position: relative;
}
.side-menu #search .panel-body .navbar-form input {
	border: 0;
	border-radius: 0;
	box-shadow: none;
	width: 100%;
	height: 50px;
}
.side-menu #search .panel-body .navbar-form .btn {
	position: absolute;
	right: 0;
	top: 0;
	border: 0;
	border-radius: 0;
	background-color: #f3f3f3;
	padding: 15px 18px;
}
/* Main body section */
.side-body {
	margin-left: 310px;
}
/* small screen */
@media (max-width: 768px) {
	.side-menu {
		position: relative;
		width: 100%;
		height: 0;
		border-right: 0;
	}

	.side-menu .navbar {
		z-index: 999;
		position: relative;
		height: 0;
		min-height: 0;
		background-color:none !important;
		border-color: none !important;
	}
	.side-menu .brand-name-wrapper .navbar-brand {
		display: inline-block;
	}
	/* Slide in animation */
	@-moz-keyframes slidein {
		0% {
			left: -300px;
		}
		100% {
			left: 10px;
		}
	}
	@-webkit-keyframes slidein {
		0% {
			left: -300px;
		}
		100% {
			left: 10px;
		}
	}
	@keyframes slidein {
		0% {
			left: -300px;
		}
		100% {
			left: 10px;
		}
	}
	@-moz-keyframes slideout {
		0% {
			left: 0;
		}
		100% {
			left: -300px;
		}
	}
	@-webkit-keyframes slideout {
		0% {
			left: 0;
		}
		100% {
			left: -300px;
		}
	}
	@keyframes slideout {
		0% {
			left: 0;
		}
		100% {
			left: -300px;
		}
	}
	/* Slide side menu*/
	/* Add .absolute-wrapper.slide-in for scrollable menu -> see top comment */
	.side-menu-container > .navbar-nav.slide-in {
		-moz-animation: slidein 300ms forwards;
		-o-animation: slidein 300ms forwards;
		-webkit-animation: slidein 300ms forwards;
		animation: slidein 300ms forwards;
		-webkit-transform-style: preserve-3d;
		transform-style: preserve-3d;
	}
	.side-menu-container > .navbar-nav {
		/* Add position:absolute for scrollable menu -> see top comment */
		position: fixed;
		left: -300px;
		width: 300px;
		top: 43px;
		height: 100%;
		border-right: 1px solid #e7e7e7;
		background-color: #f8f8f8;
		overflow: auto;
		-moz-animation: slideout 300ms forwards;
		-o-animation: slideout 300ms forwards;
		-webkit-animation: slideout 300ms forwards;
		animation: slideout 300ms forwards;
		-webkit-transform-style: preserve-3d;
		transform-style: preserve-3d;
	}
	@-moz-keyframes bodyslidein {
		0% {
			left: 0;
		}
		100% {
			left: 300px;
		}
	}
	@-webkit-keyframes bodyslidein {
		0% {
			left: 0;
		}
		100% {
			left: 300px;
		}
	}
	@keyframes bodyslidein {
		0% {
			left: 0;
		}
		100% {
			left: 300px;
		}
	}
	@-moz-keyframes bodyslideout {
		0% {
			left: 300px;
		}
		100% {
			left: 0;
		}
	}
	@-webkit-keyframes bodyslideout {
		0% {
			left: 300px;
		}
		100% {
			left: 0;
		}
	}
	@keyframes bodyslideout {
		0% {
			left: 300px;
		}
		100% {
			left: 0;
		}
	}
	/* Slide side body*/
	.side-body {
		margin-left: 5px;
		margin-top: 70px;
		position: relative;
		-moz-animation: bodyslideout 300ms forwards;
		-o-animation: bodyslideout 300ms forwards;
		-webkit-animation: bodyslideout 300ms forwards;
		animation: bodyslideout 300ms forwards;
		-webkit-transform-style: preserve-3d;
		transform-style: preserve-3d;
	}
	.body-slide-in {
		-moz-animation: bodyslidein 300ms forwards;
		-o-animation: bodyslidein 300ms forwards;
		-webkit-animation: bodyslidein 300ms forwards;
		animation: bodyslidein 300ms forwards;
		-webkit-transform-style: preserve-3d;
		transform-style: preserve-3d;
	}
	/* Hamburger */

	.navbar-toggle-sidebar {
		border: 0;
		float: left;
		padding: 18px;
		margin: 0;
		border-radius: 0;
		background-color: #f3f3f3;
	}
	/* Search */
	#search .panel-body .navbar-form {
		border-bottom: 0;
	}
	#search .panel-body .navbar-form .form-group {
		margin: 0;
	}
	.side-menu .navbar-header {
		/* this is probably redundant */
		position: fixed;
		z-index: 3;
		background-color: #f8f8f8;
	}
	/* Dropdown tweek */
	#dropdown .panel-body .navbar-nav {
		margin: 0;
	}
}
</style>
<script src="./JQuery/jquery-3.1.1.min.js"></script>
<script src="./bootstrap-3.3.7/js/bootstrap.min.js"></script>
<body>
<nav class="navbar navbar-default navbar-static-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Admin Panel | Schokolade Hosting</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/index.php">Home</a></li>
        <li><a href="./logout.php">Logout</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
  <style>
.nav-pills .li.active {
  background-color: #d9534f !important;
  border-color: #d9534f !important;
}
  </style>
	<div class="container-fluid main-container">
		<div class="col-md-2 sidebar">
			<ul class="nav nav-pills nav-stacked">
				<li <?php if ($page=='dashboard') { ?>class="active"<?php } ?>><a href="./page.php?page=dashboard" style="active">Home</a></li>
				<li <?php if ($page=='log') { ?>class="active"<?php } ?>><a href="./page.php?page=log">Server Log</a></li>
				<li <?php if ($page=='adminlog') { ?>class="active"<?php } ?>><a href="./page.php?page=adminlog">Admin Log</a></li>
        <li <?php if ($page=='banned') { ?>class="active"<?php } ?>><a href="./page.php?page=banned">Banned IPs</a></li>
				<li <?php if ($page=='server') { ?>class="active"<?php } ?>><a href="./page.php?page=server">Server</a></li>
				<li <?php if ($page=='users') { ?>class="active"<?php } ?>><a href="./page.php?page=users">Users</a></li>
			</ul>
		</div>
		<div class="col-md-10 content">
			<?php
				if ($page=='dashboard'){
					@include './pages/dashboard.php';
				} elseif ($page=='banned'){
					@include './pages/banned.php';
				} elseif ($page=='log'){
					@include './pages/log.php';
				} elseif ($page=='adminlog'){
					@include './pages/adminlog.php';
				} elseif ($page=='server'){
					@include './pages/server.php';
				} elseif ($page=='users'){
					@include './pages/users.php';
				} elseif ($page=='edituser'){
					@include './pages/edituser.php';
				}
			?>
		</div>
		<footer class="copyright footer">
			<p class="col-md-12">
				<hr class="divider">
				Copyright &copy; 2017 Schokolade Hosting - Developed by <a href="#" class="theme-author">panteL</a>
			</p>
		</footer>
	</div>
	<script type="text/javascript">
	$(function () {
  	$('.navbar-toggle-sidebar').click(function () {
  		$('.navbar-nav').toggleClass('slide-in');
  		$('.side-body').toggleClass('body-slide-in');
  		$('#search').removeClass('in').addClass('collapse').slideUp(200);
  	});

  	$('#search-trigger').click(function () {
  		$('.navbar-nav').removeClass('slide-in');
  		$('.side-body').removeClass('body-slide-in');
  		$('.search-input').focus();
  	});
  });
	</script>
  <script type="text/javascript" charset="utf-8">
       $(document).ready(function() {
            $('#test').DataTable({
                 "language": {
                      "url": "//cdn.datatables.net/plug-ins/1.10.10/i18n/English.json"
                 }
            });
       } );
  </script>
  <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
</body>
</html>
