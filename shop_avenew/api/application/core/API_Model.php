<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_Model extends CI_Model {

	public function __construct()
	{
		$this->load->database();

		ORM::configure(sprintf('mysql:host=%s;dbname=%s', $this->db->hostname, $this->db->database));
		ORM::configure('username', $this->db->username);
		ORM::configure('password',  $this->db->password);

		//$this->load->library('user_account_provider', NULL, 'user');
	}
}
