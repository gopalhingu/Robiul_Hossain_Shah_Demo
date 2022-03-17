<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class products extends Admin_Controller
{
	/**
	 * Constructor for the class
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('product_model', 'products');
	}

	/**
	 * Loads the list of products.
	 */
	public function index()
	{
		$this->set_page_title(_l('products'));

		if (!has_permissions('products', 'view'))
		{
			$this->access_denied('products', 'view');
		}
		else
		{
			$data['products'] = $this->products->get_all();
			$data['content']  = $this->load->view('admin/products/index', $data, TRUE);
			$this->load->view('admin/layouts/index', $data);
		}
	}

	/**
	 * Add new project
	 */
	public function add()
	{
		$this->set_page_title(_l('products').' | '._l('add'));

		if (!has_permissions('products', 'create'))
		{
			$this->access_denied('products', 'create');
		}
		else

		if ($this->input->post())
		{
			$data = array
				('project_id' => 'PROJECT_'.rand(10, 100),
				'name'        => $this->input->post('name'),
				'details'     => $this->input->post('details'),
				'created'     => date('Y-m-d H:i:s')
			);

			$insert = $this->products->insert($data);

			if ($insert)
			{
				set_alert('success', _l('_added_successfully', _l('project')));
				log_activity("New Project Created [ID:$insert]");
				redirect('admin/products');
			}
		}
		else
		{
			$data['content'] = $this->load->view('admin/products/create', '', TRUE);
			$this->load->view('admin/layouts/index', $data);
		}
	}

	/**
	 * Updates the project record
	 *
	 * @param int  $id  The project id
	 */
	public function edit($id = '')
	{
		$this->set_page_title(_l('products').' | '._l('edit'));

		if (!has_permissions('products', 'edit'))
		{
			$this->access_denied('products', 'edit');
		}
		else

		if ($id)
		{
			$data['project'] = $this->products->get($id);

			if ($this->input->post())
			{
				$data = array
					('project_id' => 'PROJECT_'.rand(10, 100),
					'name'        => $this->input->post('name'),
					'details'     => $this->input->post('details'),
					'updated'     => date('Y-m-d H:i:s')
				);

				$update = $this->products->update($id, $data);

				if ($update)
				{
					set_alert('success', _l('_updated_successfully', _l('project')));
					log_activity("Project Updated [ID:$id]");
					redirect('admin/products');
				}
			}
			else
			{
				$data['content'] = $this->load->view('admin/products/edit', $data, TRUE);
				$this->load->view('admin/layouts/index', $data);
			}
		}
		else
		{
			redirect('admin/products');
		}
	}

	/**
	 * Deletes the single project record
	 */
	public function delete()
	{
		$project_id = $this->input->post('project_id');
		$deleted    = $this->products->delete($project_id);

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
		$deleted = $this->products->delete_many($where);

		if ($deleted)
		{
			$ids = implode(',', $where);
			log_activity("products Deleted [IDs: $ids]");
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}
}
