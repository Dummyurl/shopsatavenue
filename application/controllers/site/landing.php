<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Landing page functions
 * @author Teamtweaks
 *
 */

class Landing extends MY_Controller {
	function __construct(){
	
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library('session');
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('product_model');
		$this->load->model('user_model');
		
			$this->load->database();
		//echo $this->checkLogin('U'); die;
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
	 	if ($this->data['loginCheck'] != ''){
	 		$this->data['likedProducts'] = $this->product_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
	 	}
		
		/*
		$UserCookieData = $this->input->cookie("saa_user");
		if($UserCookieData != ''){
			$condition = array('id'=>$UserCookieData);
			$checkUser = $this->user_model->get_all_details(USERS,$condition);
			if ($checkUser->num_rows() == 1){ 
				$userdata = array(
								'shopsy_session_user_id' => $checkUser->row()->id,
								'shopsy_session_user_name' => $checkUser->row()->user_name,
								'shopsy_session_full_name' => $checkUser->row()->full_name,
								'shopsy_session_user_email' => $checkUser->row()->email,
								'shopsy_session_user_confirm' => $checkUser->row()->is_verified,
								'userType'=>$checkUser->row()->group
							);
				
				$this->session->set_userdata($userdata);
			}
		}
		*/
		
		
		
		
		
				
    }
    
    /**
     * Site Index Page
     * 
     */
   	public function index(){	 

		$this->data['page_no'] = (int) $this->input->post('page_no');
		$this->data['total_pages'] = (int) $this->input->post('total_pages');
		$recs_per_page = 52;
		if ( $this->data['page_no'] >=  $this->data['total_pages'] ) $this->data['page_no'] = 0;
		$start = $recs_per_page * $this->data['page_no'];
		
		if( $this->data['page_no'] == 0 ) {
			$total_recs = $this->db->select('count(*) as total')->from('shopsy_product')
												->where( array('status' => 'Publish') )
												->get()->first_row()->total;
			$this->data['total_pages'] = $total_recs > 0 ? ceil( $total_recs / $recs_per_page ) : 0 ;
		}
		
		$this->data['product_list'] = $this->db->select('id,product_name,seourl, image, user_id, store_id, price')->from('shopsy_product')
												->where( array('status' => 'Publish') )
												->limit( $recs_per_page, $start  )
												->get()->result_array();
												
		$this->data['main_cat_qry'] = $this->db->select('id,cat_name,seourl')->from('shopsy_category')
								 ->where( array( 'status' => 'Active', 'rootID' => 0 ) )
								 ->get();

		
		$this->load->view('site/landing/landing',$this->data);
	}
	
	
}

/* End of file landing.php */
/* Location: ./application/controllers/site/landing.php */