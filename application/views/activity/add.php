<section class="jumbotron text-center mb-4">
    <div class="container">
        <h1 class="display-4">Add Activity</h1>
        <p class="lead text-muted">Add a new system activity</p>
    </div>
</section>

<div class="container">
	<form method="post">
		<div class="form-group">
			<label for="placeName">Slug</label>
			<input type="text" class="form-control" name="slug" id="activitySlug" aria-describedby="slugHelp" placeholder="Enter a unique slug" value="<?php echo $this->input->post('slug'); ?>">
			<small id="slugHelp" class="form-text text-muted">Give it a unique name / slug in capitals so it can be used in code easily e.g NEW_MESSAGE</small>
			<?php echo form_error("slug"); ?>
		</div>
		<div class="form-group">
			<label for="placeName">Text</label>
			<textarea class="form-control" name="text" id="activityText" aria-describedby="slugHelp" placeholder="Enter activity text / message"><?php echo $this->input->post('text'); ?></textarea>
			<?php echo form_error("text"); ?>
		</div>
  		<button type="submit" class="btn btn-primary">Add</button>
  		<a href="<?php echo site_url('activity/manage'); ?>" class="btn btn-secondary">Back</a>
	</form>
</div>