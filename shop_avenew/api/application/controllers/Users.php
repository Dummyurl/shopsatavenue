<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('RANDOM_CHARS', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
define('RANDOM_PASS_LENGTH', 10);

class Users extends API_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->library('email');
    }

	
	
	public function post_authenticate($data)
	{
		//data validation
		if(empty($data->email) || empty($data->password))
			throw new Exception("Email & password is required.");
			
		//login detail validation
		if(!$this->users_model->validate($data->email, $data->password))
			throw new Exception("Invalid username or password.");
			
		$user_detail = $this->users_model->getUserByEmail($data->email);

		if($user_detail->get('is_active') != 1)
			throw new Exception("Your account is not yet activated.");

		if($user_detail->get('is_blocked') != 0)
			throw new Exception("Your account is blocked. Please contact with admin.");

		return $this->token_provider->getToken($user_detail->id, $user_detail->email, 5*60);
	}
}
?>