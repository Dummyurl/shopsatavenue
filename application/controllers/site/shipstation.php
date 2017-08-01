<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(-1);
/**
 * 
 * User related functions
 * @author Casperon
 *
 */

class Shipstation extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email','text'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->library("session");
		$this->load->model(array("import_model",'seller_model'));
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['AdminloginCheck'] = $this->checkLogin('A');
    }   
	
	/**
	* 
	* Load the options to import items
	* 
	**/
	public function orders() {
		echo "<h4>You can't access this page directly!</h4>";
	}
	
		
}
/*End of file shipstation.php */
/* Location: ./application/controllers/site/shipstation.php */
