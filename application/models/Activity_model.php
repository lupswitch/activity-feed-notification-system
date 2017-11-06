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

	/**
	 * Fetch a particular activity type
	 *
	 * @param  integer $activity_type_id (unique id of the activity type)
	 * @return  array (Returns data for a specific activity type)
	 */
	public function get_activity_type_by_id($activity_type_id)
	{
		return $this->db->get_where('activity_types', array('id' => $activity_type_id))->row_array();
	}

	/**
	 * Fetch a particular activity type by multiple parameters
	 *
	 * @param  array $params (array containing filters for activity type)
	 * @return  array (Returns data for a specific activity type)
	 */
	public function get_activity_type_by_params($params = array())
	{
		if(isset($params['slug']))
		{
			$this->db->where('slug', $params['slug']);
		}

		if(isset($params['id_not_equal_to']))
		{
			$this->db->where('id !=', $params['id_not_equal_to']);
		}

		return $this->db->get_where('activity_types')->row_array();
	}

	/**
	 * Check if a activity type is valid
	 *
	 * @param  integer $activity_type_id (unique id of the activity type)
	 * @return  boolean
	 */
	public function check_if_activity_type_is_valid($activity_type_id)
	{
		$this->db->select('id');
		$activity_type = $this->db->get_where('activity_types', array('id' => $activity_type_id))->row_array();

		if(isset($activity_type['id']))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Add a new activity type
	 *
	 * @param  string $slug (unique slug of the activity type)
	 *         string $text (activity text / message)
	 *         
	 * @return  boolean
	 */
	public function add_activity_type($slug, $text)
	{
		$activity_type_data = array(
			'slug' => $slug,
			'text' => $text,
		);

		return $this->db->insert('activity_types', $activity_type_data);
	}

	/**
	 * Edit an existing activity type
	 *
	 * @param  integer $activity_type_id (unique id of the activity type)
	 *         string $slug (unique slug of the activity type)
	 *         string $text (activity text / message)
	 *         
	 * @return  boolean
	 */
	public function update_activity_type($activity_type_id, $slug, $text)
	{
		$activity_type_data = array(
			'slug' => $slug,
			'text' => $text,
		);

		return $this->db->update('activity_types', $activity_type_data, array('id' => $activity_type_id));
	}

}