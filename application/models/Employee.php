<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Model {

	//Table name related to this model
	private $table = 'employee';
	//Fields needed to create a new record
	public $fields = ['name', 'email', 'address', 'phone'];

	function __construct() {
		// Construct the parent class
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Create a new employee
	 */
	public function create() {
		//Set array for insert fields
		$values = [];
		foreach ($this->fields as $param) {
			//Save value to insert
			$values[$param] = $this->input->post($param);
		}
		//Insert new record
		$result = $this->db->insert($this->table, $values);
		return $result;
	}

	/**
	 * Get employees
	 */
	public function get($id = NULL) {
		//Set fields to select
		$fields = 'id, name, email, address, phone';
		$this->db->select($fields);
		//Set filter by id if it was received
		if(isset($id)) {
			$this->db->where('id', $id);
		}
		//Execute query
		$result = $this->db->get($this->table);
		//Gell all records or unique
		return isset($id) ? $result->row() : $result->result();
	}

	/**
	 * Update employee
	 */
	public function update($id) {
		//Set array for update fields
		$values = ['updated' => gmdate('Y-m-d H:i:s')];
		//Serach for post non empty params
		foreach ($this->fields as $param) {
			$post_param = $this->input->post($param);
			if(!empty($post_param)) {
				//Save value to update
				$values[$param] = $post_param;
			}
		}
		//Update record
		$result = $this->db->update($this->table, $values, ['id' => $id]);
		return $result;
	}

	/**
	 * Delete employee
	 */
	public function delete($id) {
		//Delete record
		$result = $this->db->delete($this->table, ['id' => $id]);
		return $result;
	}
}