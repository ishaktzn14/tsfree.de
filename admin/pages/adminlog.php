<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-mg-10">
                <h2><i class="fa fa-fw fa-list-alt"></i> Admin Log</h2>
                <br />
                <div class="panel-responsive" style="border: 0px">
            <table class="table table-list-search" id="test">
				<thead>
					<tr class="bg-primary">
						<th>ID</th>
						<th>Username</th>
						<th>IP Address</th>
						<th>Location</th>
						<th>Login Time</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$SQLshow = mysqli_query($con,"SELECT * FROM ipslog ORDER BY id");
					while($row = mysqli_fetch_array($SQLshow)){
					?>
					<tr>
						<td><?php echo $row[id]; ?></td>
						<td><?php echo $row[username]; ?></td>
						<td><a href="http://ipinfo.io/<?php echo $row[ipaddr]; ?>" target="_blank"><?php echo $row[ipaddr]; ?></a></td>
						<td><?php echo $row[location]; ?></td>
						<?php $date = date_create($row[login]); ?>
						<td><?php echo date_format($date,"M dS h:i:sa"); ?></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
    </div>
  </div>
</div>
</div>
