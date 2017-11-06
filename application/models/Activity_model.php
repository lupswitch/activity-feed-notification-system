<?php

/**
 * Activity_model
 *
 * @author 	Yash Desai
 * @link   	https://github.com/yashdesai87/activity-feed-notification-system
 */
class Activity_model extends CI_Model {

	/**
	 * Fetch all the system activities
	 *
	 * @param 	NULl
	 * @return  array (Returns all activity data)
	 */
	public function get_all_activity_types()
	{
		return $this->db->get('activity_types')->result_array();
	}

}