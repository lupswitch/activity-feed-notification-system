<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Activity
 *
 * @author 	Yash Desai
 * @link   	https://github.com/yashdesai87/activity-feed-notification-system
 */
class Activity extends BaseController {

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

	/**
	 * Add new system activity
	 *
	 * @param 	NULL
	 * @return 	NULL
	 */
	public function add()
	{
		// set validation rules
		$this->form_validation->set_rules('slug', 'Activity slug', 'required|is_unique[activity_types.slug]|xss_clean');
		$this->form_validation->set_rules('text', 'Activity text', 'required|xss_clean');

		// set error messages for form validation
		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('is_unique', '%s should be unique');

		// set error delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		// check if form is valid
		if($this->form_validation->run())
		{
			$add_activity_type = $this->Activity_model->add_activity_type($this->input->post('slug'), $this->input->post('text'));

			// set the success / error flash message
			if($add_activity_type == TRUE) 
			{
				$this->session->set_flashdata('success_message', 'System activity added successfully');
			} 
			else 
			{
				$this->session->set_flashdata('error_message', 'Error occured while adding the system activity');
			}

			redirect('activity/manage');
			exit;
		}
		else
		{
			// set layout partial view
			$data['_view'] = 'activity/add';

			// set the basetemplate as main view
			$this->load->view('layout/basetemplate', $data);
		}
	}

	/**
	 * Edit an existing system activity
	 *
	 * @param  integer $activity_type_id (unique id of the activity type)
	 * @return 	NULL
	 */
	public function edit($activity_type_id)
	{
		// check if activity type exists in db
		// if not then redirect with error message
		if(!$this->Activity_model->check_if_activity_type_is_valid($activity_type_id))
		{
			// set the success / error flash message
			$this->session->set_flashdata('error_message', 'System activity not found');
			redirect('activity/manage');
			exit;
		}

		// set validation rules
		$this->form_validation->set_rules('slug', 'Activity slug', 'required|callback_check_slug['.$activity_type_id.']|xss_clean');
		$this->form_validation->set_rules('text', 'Activity text', 'required|xss_clean');

		// set error messages for form validation
		$this->form_validation->set_message('required', '%s is required');

		// set error delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		// check if form is valid
		if($this->form_validation->run())
		{
			$edit_activity_type = $this->Activity_model->update_activity_type($activity_type_id, $this->input->post('slug'), $this->input->post('text'));

			// set the success / error flash message
			if($edit_activity_type == TRUE) 
			{
				$this->session->set_flashdata('success_message', 'System activity updated successfully');
			} 
			else 
			{
				$this->session->set_flashdata('error_message', 'Error occured while updating the system activity');
			}

			redirect('activity/manage');
			exit;
		}
		else
		{
			// get the particular system activity
			$data['system_activity'] = $this->Activity_model->get_activity_type_by_id($activity_type_id);

			// set layout partial view
			$data['_view'] = 'activity/edit';

			// set the basetemplate as main view
			$this->load->view('layout/basetemplate', $data);
		}
	}

	/**
	 * Check if slug exists
	 *
	 * @param  string $slug (unique string of the activity type)
	 * @return 	boolean
	 */
	public function check_slug($slug, $activity_type_id)
	{
		$activity_type = $this->Activity_model->get_activity_type_by_params(array('slug' => $slug, 'id_not_equal_to' => $activity_type_id));

		if(empty($activity_type))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_slug', '%s should be unique');
			return FALSE;
		}
	}
}