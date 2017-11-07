<section class="jumbotron text-center">
    <div class="container">
        <h1 class="display-4">Admin Section</h1>
    </div>
</section>

<div class="container">
	<p class="lead">Manage system activities: <a href="<?php echo site_url('activity/manage'); ?>" class="btn btn-primary btn-sm">Manage</a></p>
	<p class="lead">Test user activity: <a href="<?php echo site_url('activity/add_user_activity'); ?>" class="btn btn-primary btn-sm">Add</a></p>
	<p class="lead">
		<label class="d-block">Usage:</label>
		<code class="d-block p-2 mb-2">
			$this->load->model('Activity_model');
		</code>
		<code class="d-block p-2 mb-2">
			$this->Activity_model->add_user_activity(34, 'INVITE_USER', 45, array('user-email' => 'user1@example.com'));
		</code>
		<stron>Parameter explaination,</stron>
		<dl class="row">
			<dt class="col-sm-4">To User <small>(34)</small></dt>
			<dd class="col-sm-8">The user who is receiving the activity (receipient)</dd>
			<dt class="col-sm-4">Activity Slug <small>('INVITE_USER')</small></dt>
			<dd class="col-sm-8">The slug used for the activity message to define the type of activity that is being sent</dd>
			<dt class="col-sm-4">From User <small>(45)</small></dt>
			<dd class="col-sm-8">The user who is sending the activity (sender),<br>Can be 0 if system is sending the activity</dd>
			<dt class="col-sm-4">Other Activity Data <br><small>(array('user-email' => 'user1@example.com'))</small></dt>
			<dd class="col-sm-8">This parameter should be an array consisting of the custom tags in <code>key: value</code> pairs that are needed to be replaced in the activity text<br>e.g <code>array('user-joining-date' => '24/11/2017');</code></dd>
		</dl>
	</p>
</div>