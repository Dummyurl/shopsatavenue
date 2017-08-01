<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends API_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	
	


	public function getUserByEmail($email)
	{

		$current_user = ORM::for_table('rkl_users')
			->where('rkl_users.email', $email)
			->find_one();
		return $current_user;		
	}

	

	public function validate($username, $password)
	{
		$user = ORM::for_table('rkl_users')
			->where(array('email' => $username,'password' => md5($password)))
			->find_one();

		return $user!=NULL;
	}

	public function getUserRolesByUserId($user_id)
	{
		$current_user = ORM::for_table('rkl_users_role')
			->select('rkl_role.id', 'id')
			->select('rkl_role.name', 'role')
			->join('rkl_role', 'rkl_users_role.role_id = rkl_role.id')
			->where('rkl_users_role.user_id', $user_id)
			->find_many();

		return $current_user;
	}


}
