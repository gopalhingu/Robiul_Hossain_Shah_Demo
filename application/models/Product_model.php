<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends MY_Model
{
	/**
	 * @var mixed
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

	public function get_all_active_products(){
		$this->db->select('count(*)');
		$this->db->from('products');
		$this->db->where('status', 1);
		$num_results = $this->db->count_all_results();
	   return $num_results; 
	}

	public function get_all_active_products_not_attch(){
		$this->db->select('count(p.*)');
		$this->db->from('products p');
		$this->db->where('p.status', 1);
		$this->db->join('attach_products ap', 'ap.product_id = p.id', 'left');
		$this->db->where('ap.user_id is NULL', NULL, FALSE);
		$num_results = $this->db->count_all_results();
	   return $num_results; 
	}

	public function get_all_active_total_products_count(){
		$this->db->select('SUM(ap.qty) as total');
		$this->db->from('attach_products ap');
		$this->db->join('products p', 'ap.product_id = p.id', 'left');
		$this->db->where('p.status', 1);
		$num_results = $this->db->get();
   	    return $num_results->result_array();   
	}

	public function summarize_attach_products_price_count(){
		$this->db->select('SUM(ap.qty * p.price) as total');
		$this->db->from('attach_products ap');
		$this->db->join('products p', 'ap.product_id = p.id', 'left');
		$this->db->where('p.status', 1);
		$num_results = $this->db->get();
   	    return $num_results->result_array();   
	}

	public function summarize_price_for_user(){
		$this->db->select('ap.*,CONCAT(u.firstname,u.lastname) AS name,p.price,SUM(p.price * ap.qty) as total,p.status');
		$this->db->from('users u');
		$this->db->join('attach_products ap', 'ap.user_id = u.id', 'left');
		$this->db->join('products p', 'p.id = ap.product_id', 'left');
		$this->db->where('u.is_active', 1);
		$this->db->where('u.is_email_verified', 1);
		$this->db->where('p.status', 1);
		$this->db->where('ap.user_id is NOT NULL', NULL, FALSE);
		$this->db->group_by('u.id'); 
		$num_results = $this->db->get();
   	    return $num_results->result_array();   
	}
}
