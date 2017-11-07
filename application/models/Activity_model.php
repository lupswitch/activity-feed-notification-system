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

	/**
	 * Fetch all the user activities
	 *
	 * @param  integer $user_id (id of current user)
	 *         integer $limit (limit activities per page)
	 *         integer $offset (offset for the activities)
	 *         string  $order_by (set the order of the activities)
	 *         array   $params (set optional parameters to filter from)
	 *         
	 * @return  array (Returns data all the user activities)
	 */
    public function get_all_activities($user_id, $limit = 0, $offset = 0, $order_by = 'a.added_on DESC, a.id DESC', $params = array())
    {
        $limit_condition = "";

        if($limit && $offset) 
        {
            $limit_condition = " LIMIT " . $offset . ", " . $limit;
        } 
        else if($limit) 
        {
            $limit_condition = " LIMIT " . $limit;
        }

        $is_read_condition = "";
        if(isset($params['is_read']))
        {
        	$is_read_condition = " AND a.is_read = " . (int)$params['is_read'];
        }

        $sql = "
            SELECT
                a.*,
                IFNULL(u1.first_name, 'System') as from_user_first_name,
                IFNULL(u1.last_name, 'System') as from_user_last_name,
                IFNULL(CONCAT(u1.first_name,' ', u1.last_name), 'System') as from_user_name,
                u2.first_name as to_user_first_name,
                u2.last_name as to_user_last_name,
                CONCAT(u2.first_name,' ', u2.last_name) as to_user_name,
                at.text as activity_text
            FROM
                activities a
                    LEFT JOIN users u1 ON a.from_user_id = u1.id
                    LEFT JOIN users u2 ON a.to_user_id = u2.id
                    INNER JOIN activity_types at ON a.activity_type_id = at.id
            WHERE
                1 = 1
            AND 
                u2.id = ?
            	$is_read_condition
            ORDER BY
	            $order_by
	            $limit_condition
        ";

        $activities = $this->db->query($sql, array($user_id))->result_array();

        if(!empty($activities))
        {
            foreach($activities as $key => $activity)
            {
                $activities[$key]['activity_text'] = $this->_build_activity_text($activity);
            }
        }

        return $activities;
    }

    /**
	 * Count all user activities
	 *
	 * @param  integer $user_id (id of current user)
	 * @return  array (Returns data all the user activities)
	 */
    public function count_all_activities($user_id)
    {
        $sql = "
            SELECT
                a.id
            FROM
                activities a
                    LEFT JOIN users u ON a.to_user_id = u.id
                    INNER JOIN activity_types at ON a.activity_type_id = at.id
            WHERE
                1 = 1
            AND 
                u.id = ?
        ";

        return count($this->db->query($sql, array($user_id))->result_array());
    }

   /**
	 * Count all user unread activities
	 *
	 * @param  integer $user_id (retrieve unread activities for a specific user)
	 * @return  array (Returns data all the user activities)
	 */
    public function count_all_unread_activities($user_id)
    {
        $sql = "
            SELECT
                a.id
            FROM
                activities a
                    LEFT JOIN users u ON a.to_user_id = u.id
                    INNER JOIN activity_types at ON a.activity_type_id = at.id
            WHERE
                1 = 1
            AND
                a.is_read = 0
            AND 
                u.id = ?
        ";

        return count($this->db->query($sql, array($user_id))->result_array());
    }

    /**
	 * Add a new activity for user
	 *
	 * @param  integer $to_user_id (id of the user for whom activity is added)
	 *         string $activity_type_slug (unique slug of the activity type)
	 *         integer $from_user_id (id of the user who called the activity - 0 if the activity is performed by the system)
	 *         array $other_activity_data (optional data containing custom tag values)
	 *         
	 * @return  boolean
	 */
	public function add_user_activity($to_user_id, $activity_type_slug, $from_user_id = 0, $other_activity_data = array())
	{
		$activity_type = $this->get_activity_type_by_params(array('slug' => $activity_type_slug));

		if(empty($activity_type))
		{
			return FALSE;
		}

		$activity_data = array(
			'to_user_id' => $to_user_id,
			'activity_type_id' => $activity_type['id'],
			'from_user_id' => $from_user_id,
			'other_activity_data' => serialize($other_activity_data),
			'added_on' => date('Y-m-d H:i:s')
		);

		return $this->db->insert('activities', $activity_data);
	}

	/**
	 * Mark all unread activities for a user as read
	 *
	 * @param  integer $user_id (id of current user)
	 * @return  boolean
	 */
	public function mark_all_activities_as_read($user_id)
    {
        $data = array(
            'is_read' => 1
        );
        $this->db->where('to_user_id', $user_id);
        return $this->db->update('activities', $data);
    }

    /**
	 * Build the activity text based on the templates set
	 *
	 * @param  array $activity_data (complete activity data in db)
	 * @return  string (Returns string parsed from activitity template)
	 */
    private function _build_activity_text($activity_data)
    {
        $activity_text = $activity_data['activity_text'];

        // add predefined tags
        $tags = array(
            'sender-first-name' => $activity_data['from_user_first_name'],
            'sender-last-name' => $activity_data['from_user_last_name'],
            'sender-full-name' => $activity_data['from_user_name'],
            'receipient-first-name' => $activity_data['to_user_first_name'],
            'receipient-last-name' => $activity_data['to_user_last_name'],
            'receipient-full-name' => $activity_data['to_user_name'],
        );

        $other_tags = @unserialize($activity_data['other_activity_data']);

        if(!empty($other_tags))
        {
            $tags = array_merge($tags, $other_tags);
        }

        foreach ($tags as $oldtext => $newtext) {
            $xoldtext = mb_ereg_replace(' ', '_', $oldtext);
            $xoldtext = '{'.strtolower($xoldtext).'}';
            $activity_text = mb_ereg_replace($xoldtext, $newtext, $activity_text);
        }

        $activity_text = mb_ereg_replace('{{([A-z0-9 _]*)}}', '', $activity_text);

        return $activity_text;
    }

}