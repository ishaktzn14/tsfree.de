</style>
<script>
function FunctionDelete(id) {
    var r = confirm("Are You Sure?");
    if (r == true) {
        $.get("./Ajax/bannedactions.php?act=del&id=" + id, function(data, status){
			// alert("Data: " + data + "\nStatus: " + status);
			document.location='./page.php?page=banned';
		});
    }
}
</script>
<div id="page-wrapper">
    <div class="container-fluid main-container">
        <div class="row">
            <div class="col-mg-10">
              <a class="pull-right" data-toggle="modal" data-target="#usuario" href="#">
              <button type="button" class="btn btn-primary %btn-md btn-danger">Add Ban</button>
              </a>
                <h2><i class="fa fa-fw fa-list-alt"></i> Banned IPs</h2>
                <br />
                <div class="panel-responsive" style="border: 0px">
            <table class="table table-list-search" id="test">
				<thead>
					<tr class="bg-primary">
						<th>ID</th>
						<th>IP Address</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$SQLshow = mysqli_query($con,"SELECT * FROM banned ORDER BY id");
					while($row = mysqli_fetch_array($SQLshow)){
					?>
					<tr>
						<td><?php echo $row[id]; ?></td>
						<td><?php echo $row[ipaddr]; ?></td>
						<td>
							<center>
								<a href="#" OnClick="FunctionDelete(<?php echo $row[id]; ?>)">
                  <button type="button" class="btn btn-primary btn-md btn-danger">Delete</button></a></td>
								</a>
							</center>
						</td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
    </div>
</div>
<div class="fade modal" id="usuario">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title" id="myModalLabel">Add new Ban</h2>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" id="myForm" name="myForm" onsubmit="return validateForm()" enctype="multipart/form-data" action="./Ajax/bannedactions.php?act=add">
					<fieldset>
						<!-- Form Name -->
						<!-- Prepended text-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="ipaddr">IP Address</label>
							<div class="col-md-5">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input id="ipaddr" name="ipaddr" class="form-control" placeholder="8.8.8.8" type="text" value="" required="">
								</div>
							</div>
						</div>
						<!-- File Button -->
						<div class="form-group col-lg-3 col-offset-6 pull-left">
							<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>Add !</button>
						</div>
						<!-- Button -->
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
