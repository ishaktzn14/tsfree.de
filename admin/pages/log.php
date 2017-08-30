<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-mg-10">
                <h2><i class="fa fa-fw fa-list-alt"></i> Server Log</h2>
                <br />
                <div class="panel-responsive" style="border: 0px">
            <table class="table table-list-search" id="test">
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
					$SQLshow = mysqli_query($con,"SELECT * FROM ts ORDER BY ID");

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
					}
					?>
				</tbody>
			</table>
		</div>
    </div>
</div>
