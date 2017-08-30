<script>
function FunctionDelete(id) {
    var r = confirm("Are You Sure?");
    if (r == true) {
        $.get("./Ajax/useractions.php?act=del&id=" + id, function(data, status){
			// alert("Data: " + data + "\nStatus: " + status);
			document.location='./page.php?page=users';
		});
    }
}
</script>
<div class="panel panel-default">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-list"></span> Users
        <a class="pull-right" data-toggle="modal" data-target="#usuario" href="#" class="btn btn-primary">Add User<i class="fa fa-plus"></i></a>
    </div>
    <div class="panel-body">
		<div class="table-responsive">
			<?php include './pages/userspagging.php'; ?>
            <table class="table table-bordered table-hover">
				<thead>
					<tr class="bg-primary">
						<th>ID</th>
						<th>Username</th>
						<th>Email</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$SQLshow = mysqli_query($con,"SELECT * FROM users ORDER BY id ASC limit $offset, $dataperPage");
					$noUrut = 1;
					while($row = mysqli_fetch_array($SQLshow)){
					?>
					<tr>
						<td><?php echo $row[id]; ?></td>
						<td><?php echo $row[username]; ?></td>
						<td><?php echo $row[email]; ?></td>
						<td><a href="./page.php?page=edituser&id=<?php echo $row[id]; ?>"><button type="button" class="btn btn-primary btn-md btn-danger">Edit</button></a>
						<a href="#" OnClick="FunctionDelete(<?php echo $row[id]; ?>)"><button type="button" class="btn btn-primary btn-md btn-danger">Delete</button></a></td>
					</tr>
					<?php
					$noUrut++;
					}
					?>
				</tbody>
			</table>
		</div>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-6">
				<?php
				$query = mysqli_query($con,"SELECT COUNT(*) jumData from users");
				$data = mysqli_fetch_array($query);
				$jumlahData = $data["jumData"];
				?>
                <h5>Total Count <span class="label label-info"><?php echo $jumlahData; ?></span></h5>
            </div>
			<div class="col-md-6">
                <ul class="pagination pagination-sm pull-right">
					<?php include './pages/usersviewpage.php';?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="fade modal" id="usuario">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title" id="myModalLabel">Add new Admin User</h2>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" id="myForm" name="myForm" onsubmit="return validateForm()" enctype="multipart/form-data" action="./Ajax/useractions.php?act=add">
					<fieldset>
						<!-- Form Name -->
						<!-- Prepended text-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="username">Username</label>
							<div class="col-md-5">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input id="username" name="username" class="form-control" placeholder="Insert a Username" type="text" value="" required="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="password">Password</label>
							<div class="col-md-5">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input id="password" name="password" type="password" placeholder="Insert a Password" class="form-control input-md" value="" required="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="email">E-Mail</label>
							<div class="col-md-5">
								<div class="input-group">
									<input id="email" name="email" class="form-control" placeholder="Insert an E-Mail Address" type="email" value="">
									<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								</div>
							</div>
						</div>
						<!-- File Button -->
						<div class="form-group col-lg-3 col-offset-6">
							<center>
                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>Create !</button>
              </center>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
