<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "../config/config.inc.php";
@include "../session_member.php";

$id = $_GET['id'];

// Sanitize $_GET parameters to avoid XSS and other attacks
if(strpos(strtolower($id), 'union') || strpos(strtolower($id), 'select') || strpos(strtolower($id), '/*') || strpos(strtolower($id), '*/')) {
   echo "<div class=\"alert alert-warning col-lg-3 col-offset-6 centered col-centered\">
  <strong>Warning!</strong> SQL injection attempt detected.</div>";
   die;
}

$data	= "SELECT * FROM users WHERE id='$id'";
$hasil	= mysqli_query($con,$data);
$row	= mysqli_fetch_array($hasil);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-list"></span> Edit Admin User
    </div>
    <div class="panel-body">
<form class="form-horizontal" action="./Ajax/useractions.php?act=update&id=<?php echo $id; ?>" method="post">
	<fieldset>
		<!-- Form Name -->
		<!-- Prepended text-->
			<div class="form-group">
				<label class="col-md-2 control-label" for="username">Username</label>
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="username" name="username" class="form-control" placeholder="Username" type="text" value="<?php echo $row[username];?>">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="password">Password</label>
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="password" name="password" type="password" class="form-control input-md" value="<?php echo $row[password];?>" required="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="email">E-Mail</label>
				<div class="col-md-4">
					<div class="input-group">
						<input id="email" name="email" class="form-control" placeholder="Email" type="email" value="<?php echo $row[email];?>">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
					</div>
				</div>
			</div>
      <div class="form-group col-lg-3 col-offset-6">
          <button type="edit" class="btn btn-primary btn-md btn-danger"></i>Edit !</button>
      </div>
		</fieldset>
	</div>
</div>
</form>
