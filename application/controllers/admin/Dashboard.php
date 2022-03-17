<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
	/**
	 * Constructor for the class
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'users');
		$this->load->model('product_model', 'products');
	}

	/**
	 * Loads the admin dashboard
	 */
	public function index()
	{
		$this->set_page_title(_l('dashboard'));
		$all_data['count_verified'] = $this->users->get_all_verifed_users();
		$all_data['count_users_attch'] = $this->users->get_all_verifed_active_users_with_products_attch();
		$all_data['active_products'] = $this->products->get_all_active_products();
		$all_data['active_products_not_attch'] = $this->products->get_all_active_products_not_attch();
		$all_data['all_active_total_products_count'] = $this->products->get_all_active_total_products_count();
		$all_data['summarize_prices_for_all'] = $this->products->summarize_attach_products_price_count();
		$all_data['summarize_price_for_user'] = $this->products->summarize_price_for_user();


		$data['content'] = $this->load->view('admin/dashboard/index', $all_data, TRUE);
		$this->load->view('admin/layouts/index', $data);

	}
}
