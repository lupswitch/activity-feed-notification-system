<?php

/**
 * User_model
 *
 * @author 	Yash Desai
 * @link   	https://github.com/yashdesai87/activity-feed-notification-system
 */
class User_model extends CI_Model {

	/**
	 * Fetch all the users
	 *
	 * @param 	NULl
	 * @return  array (Returns all user data)
	 */
	public function get_all_users()
	{
		$this->db->select("users.*, CONCAT(users.first_name,' ', users.last_name) as full_name");
		return $this->db->get('users')->result_array();
	}

}