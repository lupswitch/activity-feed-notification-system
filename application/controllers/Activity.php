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
	 * Delete an existing system activity
	 *
	 * @param  integer $activity_type_id (unique id of the activity type)
	 * @return 	NULL
	 */
	public function delete($activity_type_id)
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

		$delete_activity_type = $this->Activity_model->delete_activity_type($activity_type_id);

		// set the success / error flash message
		if($delete_activity_type == TRUE) 
		{
			$this->session->set_flashdata('success_message', 'System activity deleted successfully');
		} 
		else 
		{
			$this->session->set_flashdata('error_message', 'Error occured while deleting the location');
		}

		redirect('activity/manage');
		exit;
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

	/**
	 * List all the notifications
	 *
	 * @param   NULL
	 * @return 	NULL
	 */
	public function notifications()
	{
		// set notification variables used for pagination library
		$notification_count_per_page = NOTIFICATION_COUNT_PER_PAGE; // this value is defined in the constants
		$page_name = 'p'; // change this value as per your need with page string
		$page = ($this->input->get($page_name) > 0) ? $this->input->get($page_name) - 1 : 0;
		$offset = $page * $notification_count_per_page;

		// get all activities count
		$data['total_activity_count'] = $this->Activity_model->count_all_activities($this->user_id);

		// fetch all the logged in user acitivities
		$data['activities'] = $this->Activity_model->get_all_activities($this->user_id, $notification_count_per_page, $offset);

		/* Pagination Class
		 * https://www.codeigniter.com/userguide3/libraries/pagination.html
		 * 
		 * Change these values as per your need
		 */ 
		$config['base_url'] = site_url('activity/notifications');
		$config['total_rows'] = $data['total_activity_count'];
		$config['per_page'] = $notification_count_per_page;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = $page_name;
		$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		$config['full_tag_open'] = '<div class="pagination float-right"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['attributes'] = array('class' => 'page-link');

		// initialize pagination class
		$this->pagination->initialize($config);

		// mark all the unread activities as read
		$this->Activity_model->mark_all_activities_as_read($this->user_id);

		// set layout partial view
		$data['_view'] = 'activity/notifications';

		// set the basetemplate as main view
		$this->load->view('layout/basetemplate', $data);
	}

	/**
	 * Mark all the unread notifications as read
	 *
	 * @param   NULL
	 * @return 	NULL
	 */
	public function mark_notifications_as_read()
	{
		if (!$this->input->is_ajax_request()) 
		{
		   exit('No direct script access allowed');
		}

		// mark all the unread activities as read
		$mark_activities_as_read = $this->Activity_model->mark_all_activities_as_read($this->user_id);

		if($mark_activities_as_read == TRUE) 
		{
			$json_response = array(
				'response' => 'ok',
				'message' => 'Notifications marked as read'
			);
		} 
		else 
		{
			$json_response = array(
				'response' => 'error',
				'message' => 'Error while marking notifications as read'
			);
		}

		$this->output->set_output(json_encode($json_response));
	}

	/**
	 * Sample function to add user activity
	 *
	 * @param   NULL
	 * @return 	NULL
	 */
	public function add_user_activity()
	{
		// set validation rules
		$this->form_validation->set_rules('activity_type_slug', 'Activity slug', 'required|xss_clean');
		$this->form_validation->set_rules('other_activity_data', 'Other activity data', 'xss_clean');

		// set error messages for form validation
		$this->form_validation->set_message('required', '%s is required');

		// set error delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		// check if form is valid
		if($this->form_validation->run())
		{
			$add_user_activity = $this->Activity_model->add_user_activity($this->user_id, $this->input->post('activity_type_slug'), 0, @unserialize($this->input->post('other_activity_data')));

			// set the success / error flash message
			if($add_user_activity == TRUE) 
			{
				$this->session->set_flashdata('success_message', 'Activity added successfully');
			} 
			else 
			{
				$this->session->set_flashdata('error_message', 'Error occured while adding the activity');
			}

			redirect('activity/add_user_activity');
			exit;
		}
		else
		{
			$this->load->model('User_model');

			// get all the system activities
			$data['system_activities'] = $this->Activity_model->get_all_activity_types();

			// get all the users
			$data['users'] = $this->User_model->get_all_users();

			// set layout partial view
			$data['_view'] = 'activity/add_user_activity';

			// set the basetemplate as main view
			$this->load->view('layout/basetemplate', $data);
		}
	}

}