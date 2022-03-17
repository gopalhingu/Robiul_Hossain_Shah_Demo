<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class attachproducts extends Admin_Controller
{
	/**
	 * Constructor for the class
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('product_model', 'attachproducts');
	}

	/**
	 * Loads the list of attachproducts.
	 */
	public function index()
	{
		$this->set_page_title(_l('attachproducts'));

		if (!has_permissions('attachproducts', 'view'))
		{
			$this->access_denied('attachproducts', 'view');
		}
		else
		{
			$data['attachproducts'] = $this->attachproducts->get_all();
			$data['content']  = $this->load->view('admin/attachproducts/index', $data, TRUE);
			$this->load->view('admin/layouts/index', $data);
		}
	}


	/**
	 * Deletes the single project record
	 */
	public function delete()
	{
		$project_id = $this->input->post('project_id');
		$deleted    = $this->attachproducts->delete($project_id);

		if ($deleted)
		{
			log_activity("Project Deleted [ID:$project_id]");
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}

	/**
	 * Deletes multiple project records
	 */
	public function delete_selected()
	{
		$where   = $this->input->post('ids');
		$deleted = $this->attachproducts->delete_many($where);

		if ($deleted)
		{
			$ids = implode(',', $where);
			log_activity("attachproducts Deleted [IDs: $ids]");
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}
}
