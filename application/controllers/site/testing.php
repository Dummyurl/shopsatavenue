<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
/** 
 * 
 * User related functions
 * @author Teamtweaks
 *
 **/ 

class Testing extends MY_Controller { 

	function __construct(){
		error_reporting(E_ALL ^ (E_NOTICE));
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->library('session');
		$this->load->model(array('user_model','product_model','seller_model','product_attribute_model'));
    }
    
	public function email_setting() {
		$this->load->view('site/user/user_email_setting.php',$this->data);
	}

	public function menu_testing() {
		$this->load->view('site/seller/merchant_menu_testing.php',$this->data);
	}
	
	function test1() {
		
		echo "GV: testing"; exit(0);
	}

}

/* End of file user.php */
/* Location: ./application/controllers/site/user.php */