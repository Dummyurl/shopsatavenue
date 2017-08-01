<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_doc extends CI_Controller {

	private $method_names = array('get', 'post', 'put', 'delete');
	function __construct()
    {
		parent::__construct();
    }
	
	public function index()
	{
		$root_controller_folder_path = APPPATH . '/controllers/';
		echo '<!DOCTYPE html>
				<html>
					<head>
						<meta charset="UTF-8">
						<title>API Documentation...</title>
						<style>
							body{width:960px;margin:10px auto;font-family:courier; font-size:8pt}
							.block{border:1px dotted #333; margin-bottom:10px; border-left:3px solid #9e9209; padding:5px}
							.block > div{color:#999}
							h4{color:#2f7786; padding:0; margin:0}
							small{font-size:80%; background:#888; color:#fff; padding:3px}
						</style>
					</head>
					<body>
						<h1>API Documentation</h1>
						';
		$this->loadDocs($root_controller_folder_path);
		echo 		'</body>
				</html>';
	}
	
	private function loadDocs($controller_folder_path)
	{
		$already_added_classes = array();
		$files = scandir($controller_folder_path);
		foreach($files as $file){
			if(strpos($file, '.php')===FALSE || $file=='Api_doc.php') continue;
			$full_file_path = $controller_folder_path . $file;
			if(is_dir($full_file_path))
				loadDocs($full_file_path);
			
			include_once($full_file_path);

			try{
				$target_class_name = str_replace('.php', '', $file);
				if(empty($target_class_name))
					throw new  Exception("File name can't be blank");					

				if(in_array($target_class_name, $already_added_classes))
					throw new Exception(sprintf('Class redeclare %s in %s'), $target_class_name, $full_file_path);

				$class_reflection = new ReflectionClass($target_class_name);
				$already_added_classes[] = $target_class_name;
			}catch(Exception $ex){
				echo $ex->getMessage();
				continue;
			}
			//ignore, if controller is not an API controller
			if(!$class_reflection->isSubclassOf('API_Controller')) continue;
			$class_name = strtolower($class_reflection->getName());
			$methods = $class_reflection->getMethods(ReflectionMethod::IS_PUBLIC);
			foreach($methods as $method){
				if(strpos($method->getName(), '__')  !== FALSE || $method->class != $class_reflection->getName()) continue;
				
				$method_name = strtolower($method->getName());
				$matchs = array();
				if(preg_match('/^(get|post|put|delete)_(.*)/', $method_name, $match)){
					$http_method = $match[1];
					$method_name = preg_replace('/^(get|post|put|delete)_/', '', $method_name);
				}
				else{
					$http_method = 'get';
				}
				
				$params = array();
				foreach($method->getParameters() as $arg){
					if($arg->name == 'data') continue;
					$params[] = sprintf("&lt;%s&gt;", $arg->name);
				}
				
				$param_str = count($params) > 0 ? '/' . implode('/', $params) : '';
				
				
				echo '<div class="block">';
				echo 	"<div>".str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",str_replace("\n\t","<br/>",$method->getDocComment())).'</div>';
				echo 	'<h4><small>' . strtoupper($http_method) . '</small> ' . $class_name . ($method_name=='index'? '' : '/' . $method_name) . $param_str .'</h4>';
				echo '</div>';
			}
		}
	}
}