<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller {

	function __construct() {
		// Construct the parent class
		parent::__construct();
		$this->load->model('employee');
	}

	/**
	 * Loads employees view
	 */
	public function index() {
		$data = [
			'employees' => $this->employee->get()
		];
		$this->load->view('employees', $data);
	}

	/**
	 * Starts create employee proccess
	 */
	public function create() {
		//Make sure of receive all required params
		foreach ($this->employee->fields as $param) {
			//Show error view if some param has not beet sent
			if(is_null($this->input->post($param))) {
				show_error('mesagge', 400);
			}
		}
		//Create new employee
		$result = $this->employee->create();
		//Show error view if creation fails
		if(!$result) {
			show_error('mesagge', 400);
		}
		//If all ok, redirect to index() to show employees view
		$this->output->set_header('Location: http://codeigniter.local/employees/');
	}

	/**
	 * Starts update employee proccess
	 */
	public function update() {
		//Show error view if 'employee_id' param has not beet sent
		$employee_id = $this->input->post('employee_id');
		if(is_null($employee_id)) {
			show_error("The 'employee_id' param is required", 400);
		}
		//Validate existent employee
		$employee = $this->employee->get($employee_id);
		if(is_null($employee)) {
			show_error('Employee not found', 400);
		}
		//Update employee
		$result = $this->employee->update($employee_id);
		//Show error view if update fails
		if(!$result) {
			show_error('Error ocurred when updating employee', 400);
		}
		//If all ok, redirect to index() to show employees view
		$this->output->set_header('Location: http://codeigniter.local/employees/');
	}

	/**
	 * Starts delete employee proccess
	 */
	public function delete() {
		//Show error view if 'employee_id' param has not beet sent
		$employee_id = $this->input->post('employee_id');
		if(is_null($employee_id)) {
			show_error("The 'employee_id' param is required", 400);
		}
		//Validate existent employee
		$employee = $this->employee->get($employee_id);
		if(is_null($employee)) {
			show_error('Employee not found', 400);
		}
		//Delete employee
		$result = $this->employee->delete($employee_id);
		//Show error view if delete fails
		if(!$result) {
			show_error('Error ocurred when deleting employee', 400);
		}
		//If all ok, redirect to index() to show employees view
		$this->output->set_header('Location: http://codeigniter.local/employees/');
	}
}