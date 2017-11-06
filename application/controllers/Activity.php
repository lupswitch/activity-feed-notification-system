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
		// set layout partial view
		$data['_view'] = 'activity/index';

		// set the basetemplate as main view
		$this->load->view('layout/basetemplate', $data);
	}

	/**
	 * Manage all the system activities
	 *
	 * @param 	NULL
	 * @return 	NULL
	 */
	public function manage()
	{
		// get all the system activities
		$data['system_activities'] = $this->Activity_model->get_all_activity_types();

		// set layout partial view
		$data['_view'] = 'activity/manage';

		// set the basetemplate as main view
		$this->load->view('layout/basetemplate', $data);
	}
}