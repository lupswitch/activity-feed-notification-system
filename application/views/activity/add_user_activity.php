<section class="jumbotron text-center mb-4">
    <div class="container">
        <h1 class="display-4">Add User Activity</h1>
        <p class="lead text-muted">Add a new activity for user</p>
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

	<form method="post">
		<div class="form-group">
			<div class="form-row">
				<div class="col-md-6">
					<label for="activityToUser">To user</label>
					<select class="form-control" id="activityToUser" name="to_user_id">
						<?php foreach($users as $user): ?>
							<option value="<?php echo $user['id']; ?>"><?php echo $user['full_name']; ?></option>
						<?php endforeach; ?>
					</select>
					<small id="toUserHelp" class="form-text text-muted">Receiver should be a system user</small>
					<?php echo form_error("to_user_id"); ?>
				</div>
				<div class="col-md-6">
					<label for="activityFromUser">From user</label>
					<select class="form-control" id="activityFromUser" name="from_user_id">
						<option value="0">System</option>
						<?php foreach($users as $user): ?>
							<option value="<?php echo $user['id']; ?>"><?php echo $user['full_name']; ?></option>
						<?php endforeach; ?>
					</select>
					<small id="fromUserHelp" class="form-text text-muted">Send as a system activity or as a user</small>
					<?php echo form_error("from_user_id"); ?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="activityToUser">Activity Slug</label>
			<select class="form-control" id="activityTypeSlug" name="activity_type_slug">
				<?php foreach($system_activities as $activity_type): ?>
					<option value="<?php echo $activity_type['slug']; ?>"><?php echo $activity_type['slug']; ?></option>
				<?php endforeach; ?>
			</select>
			<small id="slugHelp" class="form-text text-muted">Send the unique name so its easy to understand which activity you are creating for the user</small>
			<?php echo form_error("activity_type_slug"); ?>
		</div>
		<div class="form-group">
			<label for="activityOtherData">Other Activity Data</label>
			<textarea class="form-control" name="other_activity_data" id="activityOtherData" aria-describedby="otherDataHelp" placeholder="Enter serialized data of custom tags for activity message"><?php echo $this->input->post('other_activity_data'); ?></textarea>
			<small id="otherDataHelp" class="form-text text-muted">Send serialized data built from custom tags array needed in the activity message</small>
			<?php echo form_error("other_activity_data"); ?>
		</div>
  		<button type="submit" class="btn btn-primary">Add</button>
  		<a href="<?php echo site_url(); ?>" class="btn btn-secondary">Back</a>
	</form>
</div>