<?php
class User_account_provider
{
	private $ci;
	private $user_id;
	private $user_name;
	
	public function __construct()
    {
		$this->ci = & get_instance();
		$this->ci->load->library('Token_provider');
		$this->ci->load->model('Users_model');
		$token_provider = &$this->ci->token_provider;
		
		
		$headers = apache_request_headers();
		$authorization_token = str_replace('Bearear ','',isset($headers['Authorization'])?$headers['Authorization']:'');
		
		if(!empty($authorization_token)){
			try{
				$result = $token_provider->parseToken($authorization_token);
				$this->user_id = $result->data->userId;
				$this->user_name = $result->data->userName;
			}catch(Exception $ex){
				log_message('error', $ex->getMessage());
				die($ex->getMessage());
			}
		}
	}
	
	public function getUserId()
	{
		return $this->user_id;
	}
	
	public function getUsername()
	{
		return $this->user_name;
	}

	public function getUserDetail()
	{
		if(empty($this->user_id))
			throw new Exception("User not found");

		return $this->ci->users_model->getUserById($this->user_id)->as_array();
	}
	
	public function getRoles()
	{
		if(empty($this->user_id))
			return array();

		$roles = $this->ci->users_model->getUserRolesByUserId($this->user_id);
		
		$role_names = array();
		foreach($roles as $role){
			$role_names[] = str_replace(' ', '_', strtolower($role->get('role')));
		}

		return $role_names;
	}
}
