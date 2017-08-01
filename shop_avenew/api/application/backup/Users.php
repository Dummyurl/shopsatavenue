<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends API_Controller {



	function __construct()
    {
		parent::__construct();
		//$this->load->model('users_model');
    }

    private function validateToken()
    {
    	$headers = apache_request_headers();
		list($token) = sscanf(isset($headers['Authorization'])?$headers['Authorization']:'', 'Bearer %s');
		if(!empty($token)){

			$date = date_create();
			$currnt_time = date_timestamp_get($date);
			$result=$this->token_provider->parseToken($token);

			if($result->exp<$currnt_time){
				return null;
			}
			else{
					return "";
				}

		}else{

			return null;

		}
    }


    function generateRandomString($length = 10) {
		    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		    return $randomString;
		}

	/**
	* Get Current User
	*
	* @param object $data (see below)
	*	{
	*		
	*		"user_id":"integer",		
	*	
	*	}
	*
	* @return object
	*	{	
	*		Get Current User Detail
	*		
	*	}
	*/
	public function get_index($data)
	{	


		$headers = apache_request_headers();
		list($token) = sscanf(isset($headers['Authorization'])?$headers['Authorization']:'', 'Bearer %s');

		if(!empty($token)){

			$date = date_create();
			$currnt_time = date_timestamp_get($date);
			$result=$this->token_provider->parseToken($token);

			if($result->exp<$currnt_time){
				return null;
			}else{
            
            $current_user = ORM::for_table('rkl_users')
				->join('rkl_users_role', 'rkl_users.id = rkl_users_role.user_id')
				->join('rkl_role', 'rkl_users_role.role_id = rkl_role.id')
				->where('rkl_users.id' ,$data->user_id)
				->find_one();
            
			//$current_user = ORM::for_table('rkl_users')->where('id',$result->data->userId)->find_one();

			
			return $current_user->as_array();
			
			}

		}else{

			return null;

		}
	
	}

	/**
	* Fetch login details & check in database user exit or not
	*
	* @param object $data (see below)
	*	{
	*		"email":"string@gmail.com",		// required
	*		"password":string 				//required 
	*	}
	*
	* @return object
	*	{
	*		"token":string,
	*		"expiry":timestamp
	*	}
	*/
	
	public function post_authenticate($data)
	{

		$obj = new stdClass;
		$user = ORM::for_table('rkl_users')->where(array('email' => $data->email,'password' => md5( $data->password)))->find_one();

		if($user==null)
		{
			$obj->token = null;
			$obj->expiry = null;
			return $obj;
		}
		else
		{
			return $this->token_provider->getToken($user->id, $user->email, 5*60);
		}
		
	}


	/**
	* Register new user
	*
	* @param object $data (see below)
	*	{
	*		"first_name":string				// required and valid First Name of New user
	*		"last_name":string				// required and valid Last Name of New user
	*		"password":string 				//required and alphanumaric; minimum 5 char long
	*		"email":string					// required and alphanumaric; minimum 5 char long of New user
	*		"phone":"integer",				// required and atleast 10 digit long
	*		"address":"string"				// required of New user Address
	*		"user_type":"string"				// required of New user type
	*	}
	*
	* @return object
	*	{
	*		true or false
	*	}
	*/
	public function post_register($data)
	{
		ORM::get_db()->beginTransaction();
		$userinfo = ORM::for_table('rkl_users')->create();
		$userinfo->firstname=$data->firstname;
		$userinfo->lastname=$data->lastname;
		$userinfo->password=md5( $data->password);
		$userinfo->email=$data->email;
		$userinfo->phone=$data->phone;
		$userinfo->create_datetime=date('Y-m-d H:i:s');
		$userinfo->save();

		$userrole = ORM::for_table('rkl_users_role')->create();
		$userrole->user_id=$userinfo->id;
		$userrole->role_id=$data->user_type;
		$userrole->create_datetime=date('Y-m-d H:i:s');
		$userrole->save();

		$token=$this->token_provider->getToken($userinfo->id, 1*60);

		$tbluser = ORM::for_table('rkl_users')->where('id',$userinfo->id)->find_one();
		$tbluser->token=$token;
		$tbluser->save();
		ORM::get_db()->commit();

		$user_info = ORM::for_table('rkl_users')->where('id', $userinfo->id)->find_one();

				$to = $user_info->email;
				$subject = "HTML email";
				$message = "
				<html>
				<head>
				<title>Rack Land New User Registration</title>
				</head>
				<body>
				<p>This mail is valid only for one hour</p>
				<table>
				<tr>
				<th>Your User Id</th>
				<th>Link to click on log in</th>
				</tr>
				<tr>
				<td>".$user_info->email."</td>
				<td>".$user_info->$token."&active=1</td>
				</tr>
				</table>
				</body>
				</html>
				";

				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				// More headers
				$headers .= 'From: <webmaster@example.com>' . "\r\n";
				$headers .= 'Cc: myboss@example.com' . "\r\n";
				mail($to,$subject,$message,$headers);


		return true;
		
	}


	/**
	* User Listing
	*
	*
	* @param object $data (see below)
	*	{
	*		"user_type": string;
	*	}
	*
	* @return object
	*	{
	*		user listing
	*	}
	*/

	public function get_all($data)
	{

		
		$headers = apache_request_headers();
		list($token) = sscanf(isset($headers['Authorization'])?$headers['Authorization']:'', 'Bearer %s');
		if(!empty($token)){

			$date = date_create();
			$currnt_time = date_timestamp_get($date);
			$result=$this->token_provider->parseToken($token);

				if($result->exp<$currnt_time){
					return null;

					}else{
							if(!empty($data)){		

									$userArray=array();
									$all_users = ORM::for_table('rkl_users')
									->join('rkl_users_role', 'rkl_users.id = rkl_users_role.user_id')
									->join('rkl_role', 'rkl_users_role.role_id = rkl_role.id')
									->where('rkl_role.name' ,$data->user_type)
									->find_many();

									foreach ($all_users as $usr) {
											array_push($userArray, $usr->as_array());
									}

									return $userArray;
							}else{

									$userArray=array();
									$all_users = ORM::for_table('rkl_users')
									->join('rkl_users_role', 'rkl_users.id = rkl_users_role.user_id')
									->join('rkl_role', 'rkl_users_role.role_id = rkl_role.id')
									->where_not_equal('rkl_role.name','Admin')
									->find_many();

									foreach ($all_users as $usr) {
											array_push($userArray, $usr->as_array());
									}

									return $userArray;

							}
					}

			}else{

				return null;
		}

		
	}



	/**
	* User info update
	*
	* @param object $data (see below)
	*	{
	*		"user_id":integer				//id of new user	
	*		"fname":"string",				// required and valid First Name of user
	*		"lname":"string",				// required and valid Last Name of user
	*		"email":"string@gmail.com",		// required and valid Email of user
	*		"phone":"integer",				// required and valid Phone of user
	*		"address":"string"				// required of user Address
	*	}
	*
	* @return object
	*	{
	*		"fname":"string",				// required and valid First Name of user
	*		"lname":"string",				// required and valid Last Name of user
	*		"email":"string@gmail.com",		// required and valid Email of user
	*		"phone":"integer",				// required and valid Phone of user
	*		"address":"string"				// required of user Address
	*	}
	*/
	
	public function put_index($data)
	{
		
		$headers = apache_request_headers();
		list($token) = sscanf(isset($headers['Authorization'])?$headers['Authorization']:'', 'Bearer %s');
		$date = date_create();
			$currnt_time = date_timestamp_get($date);
			$result=$this->token_provider->parseToken($token);

		if(!empty($token)){

			if($result->exp<$currnt_time){
				return null;
			}
			else
			{
				
				$current_user = ORM::for_table('rkl_users')->where('id',$data->user_id)->find_one();
				$current_user->firstname=$data->firstname;
				$current_user->lastname=$data->lastname;
				$current_user->password=md5( $data->password);
				$current_user->email=$data->email;
				$current_user->phone=$data->phone;
				$current_user->modify_datetime=date('Y-m-d H:i:s');
				$current_user->save();
				
				return true;
			}



		}else{

			return null;
		}


	}



	/**
	* Forgot password request
	*
	* @param object $data (see below)
	*	{
	*		
	*		"email":"string@gmail.com",		// required and valid Email of user
	*	}
	*
	* @return object
	*	{
	*		true or false
	*	}
	*/
	
	public function post_forget_password($data)
	{
		
		$forgetpassword = ORM::for_table('rkl_users')->where('email',$data->email)->find_one();

	
		if(!empty($forgetpassword)){


				$idstring="";
				//$idstring.=generateRandomString(4);
				$idstring.= '123456789';
				$randnumber=$idstring;

				$fpass = ORM::for_table('rkl_users')->where('id',$forgetpassword->id)->find_one();
				$fpass->password=md5($randnumber);
				$fpass->save();


				$to = $forgetpassword->email;
				$subject = "HTML email";
				$message = "
				<html>
				<head>
				<title>Rack Land New User Registration</title>
				</head>
				<body>
				<p>This mail is valid only for one hour</p>
				<table>
				<tr>
				<th>Your User Id</th>
				<th>Your Password</th>
				</tr>
				<tr>
				<td>".$forgetpassword->email."</td>
				<td>".$randnumber."</td>
				</tr>
				</table>
				</body>
				</html>
				";

				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				// More headers
				$headers .= 'From: <webmaster@example.com>' . "\r\n";
				$headers .= 'Cc: myboss@example.com' . "\r\n";
				mail($to,$subject,$message,$headers);


		return true;

				
			}else{

			return false;

		}

		
	}

	


	/**
	* User save property as wishlist.
	*
	* @param object $data (see below)
	*	{
	*		"user_type":integer			//integer
	*	}
	*
	* @return object
	*	{
	*		property Listing"			
	*	}
	*/
	
	public function get_wishlist($data)
	{		
		$headers = apache_request_headers();
		list($token) = sscanf(isset($headers['Authorization'])?$headers['Authorization']:'', 'Bearer %s');
		$date = date_create();
		$currnt_time = date_timestamp_get($date);
		$result=$this->token_provider->parseToken($token);

		if(!empty($token)){

				$wishlistarray=array();
				$userwishlist = ORM::for_table('rkl_user_wishlist')->where('user_id', $result->data->userId)->find_many();


			if(!empty($userwishlist)){

					foreach ($userwishlist as $usr) 
					{
						array_push($wishlistarray, $usr->as_array());
					}
					return $wishlistarray;
			}else{

					return null;

			}


		}else{
				return null;

		}
	}



	/**
	* Change user's status with respective users (active, block)
	*
	* @param object $data (see below)
	*	{
	*		"user_id":integer
	*		"is_blocked": integer
	*		
	*	}
	*
	* @return object
	*	{
	*		return:true or false					
	*	}
	*/
	
	public function put_status($data)
	{
		
		$headers = apache_request_headers();
		list($token) = sscanf(isset($headers['Authorization'])?$headers['Authorization']:'', 'Bearer %s');
		$date = date_create();
			$currnt_time = date_timestamp_get($date);
			$result=$this->token_provider->parseToken($token);

		if(!empty($token)){

			if($result->exp<$currnt_time){
				return null;
			}
			else
			{
					echo $data->user_id;
				$userstatus = ORM::for_table('rkl_users')->where('id',$data->user_id)->find_one();
				$userstatus->is_blocked=0;
				$userstatus->save();


				return true;
			}

				
		}else{

				return null;
		}

	}
}
?>