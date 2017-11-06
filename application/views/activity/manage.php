<section class="jumbotron text-center mb-4">
    <div class="container">
        <h1 class="display-4">Manage System Activities</h1>
        <p class="lead text-muted">Add / edit / delete system activities</p>
        <p>
            <a href="<?php echo site_url('activity/add'); ?>" class="btn btn-primary">Add Activity</a>
        </p>
    </div>
</section>

<div class="container">

	<?php if($this->session->flashdata('success_message')): ?>
		<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
			<?php echo $this->session->flashdata('success_message'); ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php endif; ?>

	<?php if($this->session->flashdata('error_message')): ?>
		<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
			<?php echo $this->session->flashdata('error_message'); ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php endif; ?>

	<div class="table-responsive">
		<table class="table table-bordered">
			<thead class="thead-light">
				<tr>
					<th scope="col" class="w-25 text-center">Slug</th>
					<th scope="col" class="w-25 text-center">Text</th>
					<th scope="col" class="w-25 text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($system_activities)): ?>
					<?php foreach($system_activities as $activity): ?>
						<tr>
							<td scope="row" class="text-center"><?php echo $activity['slug']; ?></td>
							<td scope="row" class="text-center"><?php echo $activity['text']; ?></td>
							<td scope="row" class="text-center">
								<a href="<?php echo site_url('activity/edit/'.$activity['id']) ?>" class="btn btn-outline-warning btn-sm">Edit</a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="3" class="text-center">No system activities added</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>