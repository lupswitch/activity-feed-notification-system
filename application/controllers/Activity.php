<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Location
 *
 * @author 	Yash Desai
 * @link   	https://github.com/yashdesai87/activity-feed-notification-system
 */
class Activity extends CI_Controller {

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
	}

	/**
	 * Lists all the activities
	 *
	 * @param 	NULL
	 * @return 	NULL
	 */
	public function index()
	{
		$data['_view'] = 'activity/index';

		$this->load->view('layout/basetemplate', $data);
	}
}