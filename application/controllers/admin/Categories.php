<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends Admin_Controller
{
	/**
	 * Constructor for the class
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('category_model', 'categories');
		$this->load->model('user_permission_model', 'user_permissions');
	}

	/**
	 * Loads the list of categories.
	 */
	public function index()
	{
		$this->set_page_title(_l('categories'));

		if (!has_permissions('categories', 'view'))
		{
			$this->access_denied('categories', 'view');
		}
		else
		{
			$data['categories'] = $this->categories->get_all();
			$data['content']    = $this->load->view('admin/categories/index', $data, TRUE);
			$this->load->view('admin/layouts/index', $data);
		}
	}

	/**
	 * Adds new category
	 */
	public function add()
	{
		$this->set_page_title(_l('categories').' | '._l('add'));

		if (!has_permissions('categories', 'create'))
		{
			$this->access_denied('categories', 'create');
		}
		else

		if ($this->input->post())
		{
			$data = array
				('name'     => $this->input->post('name'),
				'user_id'   => get_loggedin_user_id(),
				'is_active' => 1,
				'created'   => date('Y-m-d H:i:s')
			);
			$insert = $this->categories->insert($data);

			log_activity("New Category Created [ID: $insert]");

			if ($insert)
			{
				set_alert('success', _l('_added_successfully', _l('category')));
				redirect('admin/categories');
			}
		}
		else
		{
			$data['content'] = $this->load->view('admin/categories/create', '', TRUE);
			$this->load->view('admin/layouts/index', $data);
		}
	}

	/**
	 * Updates the category record
	 *
	 * @param int  $id  The categoy id
	 */
	public function edit($id = '')
	{
		$this->set_page_title(_l('categories').' | '._l('edit'));

		if (!has_permissions('categories', 'edit'))
		{
			$this->access_denied('categories', 'edit');
		}
		else

		if ($id)
		{
			if ($this->input->post())
			{
				$data = array
					('name'     => $this->input->post('name'),
					'is_active' => ($this->input->post('is_active')) ? 1 : 0,
					'user_id'   => get_loggedin_user_id(),
					'updated'   => date('Y-m-d H:i:s')
				);

				$update = $this->categories->update($id, $data);

				if ($update)
				{
					log_activity("Category Updated [ID: $id]");

					set_alert('success', _l('_updated_successfully', _l('category')));
					redirect('admin/categories');
				}
			}
			else
			{
				$data['category'] = $this->categories->get($id);
				$data['content']  = $this->load->view('admin/categories/edit', $data, TRUE);
				$this->load->view('admin/layouts/index', $data);
			}
		}
		else
		{
			redirect('admin/categories');
		}
	}

	/**
	 * Toggles the category status to Active or Inactive
	 */
	public function update_status()
	{
		$category_id = $this->input->post('category_id');
		$data        = [
			'is_active' => $this->input->post('is_active'),
			'updated'   => date('Y-m-d H:i:s')
		];

		$update = $this->categories->update($category_id, $data);

		if ($update)
		{
			if ($this->input->post('is_active') == 1)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}

		log_activity("Category Status Updated [ID: $category_id]");
	}

	/**
	 * Deletes the single category record
	 */
	public function delete()
	{
		$category_id = $this->input->post('category_id');
		$deleted     = $this->categories->delete($category_id);

		if ($deleted)
		{
			log_activity("Category Deleted [ID: $category_id]");
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}

	/**
	 * Deletes multiple category records
	 */
	public function delete_selected()
	{
		$where   = $this->input->post('ids');
		$deleted = $this->categories->delete_many($where);

		if ($deleted)
		{
			$ids = implode(',', $where);
			log_activity("Categories Deleted [IDs: $ids] ");

			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}
}
