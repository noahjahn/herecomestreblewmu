<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		$this->load->view('login');
	}

	public function login()
	{
		// form validation library https://www.codeigniter.com/userguide3/libraries/form_validation.html
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');

		if ($this->form_validation->run() == TRUE) { // return true if the rules applied successfully
			// true
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$this->load->model("auth_model"); // where the query is run.
			if ($this->auth_model->can_login($username, $password)) {
				$session_data = array (
					'username'	=> $username
				);
				$this->session->set_userdata($session_data);
				redirect(base_url() . 'auth/enter');

			} else {
				$this->session->set_flashdata('error', 'Invalid username and password');
				redirect(base_url() . 'login');
			}

		} else {
			// false
			$this->index();

		}
	}

	public function enter()
	{
		if ($this->session->userdata('username') != '') {
			$this->load->model("auth_model");
			if ($this->auth_model->is_bios_complete($this->session->userdata('username'))) {
				redirect(base_url() . 'main');
			} else {
				redirect(base_url() . 'profile/add');
			}
		} else {
			redirect(base_url() . 'main/login');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('username');
		redirect(base_url() . 'main');
	}

}
