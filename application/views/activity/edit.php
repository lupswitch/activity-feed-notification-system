<section class="jumbotron text-center mb-4">
    <div class="container">
        <h1 class="display-4">Edit Activity</h1>
        <p class="lead text-muted">Update an existing system activity</p>
    </div>
</section>

<div class="container">
	<form method="post">
		<div class="form-group">
			<label for="activitySlug">Slug</label>
			<input type="text" class="form-control" name="slug" id="activitySlug" aria-describedby="slugHelp" placeholder="Enter a unique slug" value="<?php echo ($this->input->post('slug')) ? $this->input->post('slug') : $system_activity['slug']; ?>">
			<small id="slugHelp" class="form-text text-muted">Give it a unique name / slug in capitals so it can be used in code easily e.g <code>NEW_MESSAGE</code></small>
			<?php echo form_error("slug"); ?>
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
			<textarea class="form-control" name="text" id="activityText" aria-describedby="slugHelp" placeholder="Enter activity text / message"><?php echo ($this->input->post('text')) ? $this->input->post('text') : $system_activity['text']; ?></textarea>
			<small id="textHelp" class="form-text text-muted">Type activity text using pre-defined tags or writing custom tags in the format <code>{custom-tag}</code> and sending it along with <code>other_activity_data</code> while calling the create activity function</small>
			<?php echo form_error("text"); ?>
		</div>
  		<button type="submit" class="btn btn-primary">Save</button>
  		<a href="<?php echo site_url('activity/manage'); ?>" class="btn btn-secondary">Back</a>
	</form>
</div>