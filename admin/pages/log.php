

<div class="panel panel-default">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-list"></span> Server Creation Log
    </div>
    <div class="panel-body">
		<div class="table-responsive">
			<?php include './pages/loginpagging.php'; ?>
            <table class="table table-bordered table-hover">
				<thead>
					<tr class="bg-primary">
						<th>ID</th>
						<th>Servername</th>
            <th>Port</th>
						<th>IP Address</th>
						<th>Creation Time</th>
            <th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$SQLshow = mysqli_query($con,"SELECT * FROM ts ORDER BY ID DESC limit $offset, $dataperPage");
					$noUrut = 1;
					while($row = mysqli_fetch_array($SQLshow)){
					?>
					<tr>
						<td><?php echo $row[ID]; ?></td>
						<td><?php echo $row[Servername]; ?></td>
            <td><?php echo $row[Port]; ?></td>
						<td><a href="http://ipinfo.io/<?php echo $row[IP]; ?>" target="_blank"><?php echo $row[IP]; ?></a></td>
						<td><?php echo $row[Date]; ?></td>
            <td><a href="ts3server://<?php echo "schokolade.gq"; ?>:<?php echo $row[Port]; ?>"><button type="button" class="btn btn-primary btn-md btn-danger">Connect</button></a></td>
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
				$query = mysqli_query($con,"SELECT COUNT(*) jumData from ts");
				$data = mysqli_fetch_array($query);
				$jumlahData = $data["jumData"];
				?>
                <h5>Total Count <span class="label label-info"><?php echo $jumlahData; ?></span></h5>
            </div>
            <div class="col-md-6">
                <ul class="pagination pagination-sm pull-right">
					<?php include './pages/loginviewpage.php';?>
                </ul>
            </div>
        </div>
    </div>
</div>
