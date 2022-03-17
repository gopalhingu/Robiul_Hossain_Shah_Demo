<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model
{
	/**
	 * @var boolean
	 */
	protected $soft_delete = TRUE;

	/**
	 * @var string
	 */
	protected $soft_delete_key = 'is_deleted';

	/**
	 * Constructor for the class
	 */
	public function __construct()
	{
		parent::__construct();

	}

	public function get_all_verifed_users(){

		$this->db->select('count(*)');
		$this->db->from('users');
		$this->db->where('is_email_verified', 1);
		$this->db->where('is_active', 1);
		$num_results = $this->db->count_all_results();
	   return $num_results; 
	}

	public function get_all_verifed_active_users_with_products_attch(){

		$this->db->select('count(DISTINCT(ap.user_id)) as count_users_attch');
		$this->db->from('users u');
		$this->db->join('attach_products ap', 'ap.user_id = u.id', 'left');
		$this->db->where('u.is_email_verified', 1);
		$this->db->where('u.is_active', 1);
		$this->db->where('u.is_active', 1);
		$this->db->where('ap.user_id is NOT NULL', NULL, FALSE);
		$num_results = $this->db->get();
	   	   return $num_results->result_array();  
	}
	
}
