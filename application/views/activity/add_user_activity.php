<section class="jumbotron text-center mb-4">
    <div class="container">
        <h1 class="display-4">Add User Activity</h1>
        <p class="lead text-muted">Add a new activity for user</p>
    </div>
</section>

<div class="container">
	<form method="post">
		<div class="form-group">
			<div class="form-row">
				<div class="col-md-6">
					<label for="activityToUser">To user</label>
					<select class="form-control" id="activityToUser" name="to_user_id">
						<option value="0">All</option>
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
			<label for="activityText">Text</label>
			<div class="jumbotron p-2 mb-3">
				<p class="mb-1 lead">Available tags</p>
				<span class="badge badge-dark p1">{sender-first-name}</span>
				<span class="badge badge-dark p1">{sender-last-name}</span>
				<span class="badge badge-dark p1">{sender-full-name}</span>
				<span class="badge badge-dark p1">{receipient-first-name}</span>
				<span class="badge badge-dark p1">{receipient-last-name}</span>
				<span class="badge badge-dark p1">{receipient-full-name}</span>
			</div>
			<textarea class="form-control" name="text" id="activityText" aria-describedby="slugHelp" placeholder="Enter activity text / message"><?php echo $this->input->post('text'); ?></textarea>
			<small id="textHelp" class="form-text text-muted">Type activity text using pre-defined tags or writing custom tags in the format <code>{custom-tag}</code> and sending it along with <code>other_activity_data</code> while calling the create activity function</small>
			<?php echo form_error("text"); ?>
		</div>
  		<button type="submit" class="btn btn-primary">Add</button>
  		<a href="<?php echo site_url('activity/manage'); ?>" class="btn btn-secondary">Back</a>
	</form>
</div>