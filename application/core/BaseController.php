<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BaseController
 *
 * @author 	Yash Desai
 * @link   	https://github.com/yashdesai87/activity-feed-notification-system
 */
class BaseController extends CI_Controller {

	/**
	 * Init
	 *
	 * @param 	NULL
	 * @return 	NULL
	 */
	public function __construct()
	{
		parent::__construct();

		// load the Activity_model
		$this->load->model('Activity_model');

		$this->user_id = 2;

		// get user unread notifications
		$vars['activities'] = $this->Activity_model->get_all_activities($this->user_id, 0, 0, 'a.added_on DESC', array('is_read' => 0));
		$vars['total_activities_count'] = $this->Activity_model->count_all_activities($this->user_id);
		$vars['unread_activities_count'] = $this->Activity_model->count_all_unread_activities($this->user_id);

		// set global vars
		$this->load->vars($vars);
	}

}