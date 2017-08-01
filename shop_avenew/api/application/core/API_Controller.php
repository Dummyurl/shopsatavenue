<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("../api/application/third_party/idiorm/idiorm.php");
abstract class API_Controller extends CI_Controller 
{

	public function __construct()
    {
		parent::__construct();
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Methods: *');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
		
		header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description, Authorization');
		$this->load->library('user_account_provider', NULL, 'user');
    }
	
	private function parseDocComment($str) 
	{
		$matches = array(); 
		preg_match_all("/@(.[^\(\*]*)[\(]?(.[^\)]*)/", $str, $matches, PREG_SET_ORDER); 
		
		$results = array();
		foreach($matches as $match){
			$results[trim($match[1])] = isset($match[2])?$match[2]:'';
		}
		
		return $results;
	}
	
	private function authorize($method_name)
	{
		$method_reflector = new ReflectionMethod($this, $method_name);
		$method_meta = $this->parseDocComment($method_reflector->getDocComment());
		if(isset($method_meta['authorize'])){			
			$allowed_roles = explode(',',$method_meta['authorize']);
			$current_user_roles = $this->user->getRoles();
			$common_roles = array_intersect($current_user_roles, $allowed_roles);
			if(count($common_roles) == 0)
				return false;
		}
		return true;
	}
	
	public function _remap($method_name, $arguments)
	{
		try{
			$http_method = $this->input->method(FALSE);
			if(!method_exists($this, $method_name)){
				$http_method_specific_function = strtolower($http_method) . '_' . $method_name;
				if(method_exists($this, $http_method_specific_function))
				{
					$method_name = $http_method_specific_function;
				}
				else
				{
					$arguments[] = $method_name;
					$method_name = $http_method . '_index';
				}
			}
					
			$input_string = file_get_contents('php://input');
			if(!empty($input_string)){
				$input_object = json_decode($input_string);
				$arguments[] = $input_object;
			}
			
			$reflector = new ReflectionClass($this);
			if(!$reflector->hasMethod($method_name))
				$method_name = 'index';
			
			$arg_count = $reflector
						->getMethod($method_name)
						->getNumberOfParameters();
			
			if($arg_count != count($arguments))
				die("Invalid parameter count - " . get_class($this) . '->' . $method_name);
			
			if(!$this->authorize($method_name)){
				header('HTTP/1.0 403 Forbidden');
				die('You are not authorize');
			}
			
			$responce = call_user_func_array(array($this, $method_name), $arguments);
			echo json_encode($responce);
			
		}catch(Exception $ex){
			log_message('error', $ex->getMessage());
			//echo json_encode(array('error_code'=>0, 'error_message'=>'Somthing is wrong. please check server log'));
			echo json_encode(array('error_code'=>0, 'error_message'=>$ex->getMessage()));
		}
	}
	
}