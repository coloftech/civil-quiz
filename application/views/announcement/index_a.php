<div class="col-md-12">
	<div class="panel announcement">
		<div class="panel-heading"><h4><?php echo isset($title) ? $title : '';?>  <a href="announcement/create" class="btn btn-info">New</a></h4></div>
		<div class="panel-body">
			<table class="table table-bordered">
				<thead><tr><th>Title</th><th>Date</th><th>End</th><th>Status</th><th>Action</th></tr></thead>
				<tbody>
					<?php if (isset($listAnnouncement)): ?>
						<?php foreach ($listAnnouncement as $key): ?>
							<tr><td>$key->title</td><td>$key->date_created</td><td>$key->date_end</td><td>$key_status</td><td><a href="javscript:void(0)" class="btn brn-default"><i class="fa fa-eye"></i></a> <a href="javscript:void(0)" class="btn brn-default"><i class="fa fa-edit"></i></a> <a href="javscript:void(0)" class="btn brn-default"><i class="fa fa-remove"></i></a></td></tr>
						<?php endforeach ?>
					<?php endif ?>
				</tbody>
			</table>

		</div>
	</div>
</div>