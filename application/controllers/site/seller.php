<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * 
 * User related functions
 * @author 
 *
 **/

class Seller extends MY_Controller { 

	function __construct()
	{
	
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model(array('user_model','seller_model','product_model'));
		
		
				
		$this->data['loginCheck'] = $this->checkLogin('U');
		
		$this->data['likedProducts'] = array();
	 	//if ($this->data['loginCheck'] != ''){
	 		//$this->data['likedProducts'] = $this->user_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
	 	//}
	
     }
    

	/**
	 * 
	 * This function is used for seller shop registration
	 * 
	 */
	public function seller_register_form()
	{
			$sellName =  @explode('-',$this->uri->segment(1)); 
		$this->data['heading'] = 'Seller '.ucfirst($sellName[1]).' - '.$this->config->item('meta_title');

		if ($this->checkLogin('U')!=''){

		$this->data['sellerVal'] = $this->seller_model->get_sellers_data(SELLER,$condition);
		$this->data['CatogoryVal'] = $this->seller_model->get_all_details(CATEGORY,$condition);
		//echo '<pre>'; print_r($this->data['CatogoryVal']->result());die;
		$this->data['UserVal'] = $this->user_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
		$this->load->view('site/seller/seller_register.php',$this->data);
			
		}else {
			$this->data['next'] = $this->input->get('next');
			//echo $this->data['next'];die;
			$this->data['heading'] = 'Sign in'; 
			$this->load->view('site/user/signup.php',$this->data);
		}
	}
	
	
	
	
	/**
	 * 
	 * This function is used for seller product details view
	 * 
	 */

	public function seller_product_view()
	{
		$product_seourl = $this->uri->segment(3, 0); 
		$seller_id = $this->uri->segment(2, 0);

		$this->data['userVal'] = $this->seller_model->get_userselldetail_data('product_template,seller_businessname,seourl,seller_id,seller_store_image,seller_email',$seller_id);
		$this->data['productVal'] = $productVal = $this->product_model->get_productdetail_data($product_seourl);
		 $_SESSION['product_name'] = '';
		 $_SESSION['prd_id'] ='';
		 $_SESSION['product_name'] =  $productVal[0]['product_name']; 
		 $_SESSION['prd_id'] = $prd_id = $productVal[0]['id']; 
		
		 $this->data['productFeedback'] = $productFeedback = $this->seller_model->get_product_feedback($prd_id);
		 $nametemp = $userVal[0]['product_template'];		
		 $pid = $this->data['productVal'][0]['id'];
		
		$this->data['PrdAttrName'] = $this->product_model->view_subproduct_details_group($pid);
		$this->data['PrdAttrVal'] = $this->product_model->view_subproduct_details_join($pid);

		$this->data['heading'] = $this->data['productVal'][0]['product_name'];
		$this->data['meta_title'] = $this->data['productVal'][0]['meta_title'];
		$this->data['meta_keyword'] = $this->data['productVal'][0]['meta_keyword'];
		$this->data['meta_description'] = $this->data['productVal'][0]['meta_description'];
		$this->load->view('site/shop/productshop_template.php',$this->data);
			
		
	}	

	/** 
	*
	*   Shop Billing
	*/
	function billing() {
		
		$user_id = $this->data['loginCheck'];
		$shop_id = $this->db->select('id')->from('shopsy_seller')->where( array('seller_id' => $user_id) )->get()->first_row()->id;
		$this->data['billing'] = $this->db->select('*')->from('saa_merchant_billing')->where( array( 'shop_id' => $shop_id ) )->get()->result();

		$plan_qry = $this->db->select('p.*, sp.plan_name')->from('saa_merchant_plans p')
							 ->join('sa_sales_plan sp', 'sp.plan_id = p.plan_id', 'left')
							 ->where( array( 'p.shop_id' => $shop_id, 'p.status' => 1 ) )->get();

		if ( $plan_qry->num_rows() ) {
			$this->data['current_plan'] = $plan_qry->first_row();
		}

		$this->load->view('site/seller/merchant_billing',$this->data);

	}
	
	function plans() {
		
		if ( $this->data['loginCheck'] == '' ) {
			redirect('login');
			return;
		}
		
		$user_id = $this->data['loginCheck'];
		$shop_id = $this->db->select('id')->from('shopsy_seller')->where( array('seller_id' => $user_id) )->get()->first_row()->id;

		$plan_qry = $this->db->select('p.*, sp.plan_name')->from('saa_merchant_plans p')
							 ->join('sa_sales_plan sp', 'sp.plan_id = p.plan_id', 'left')
							 ->where( array( 'p.shop_id' => $shop_id, 'p.status' => 1 ) )->get();

		if ( $plan_qry->num_rows() ) {
			$this->data['current_plan'] = $plan_qry->first_row();
		}
		$this->load->view('site/seller/merchant_plans',$this->data);
		
	}
	
	function payments() {
		if ( $this->data['loginCheck'] == '' ) {
			redirect('login');
			return;
		}
		
		$user_id = $this->data['loginCheck'];
		$shop_id = $this->db->select('id')->from('shopsy_seller')->where( array('seller_id' => $user_id) )->get()->first_row()->id;
		
		$this->load->view('site/seller/merchant_payments',$this->data);
	}
	
	function penaltys() {
		if ( $this->data['loginCheck'] == '' ) {
			redirect('login');
			return;
		}
		
		$user_id = $this->data['loginCheck'];
		$shop_id = $this->db->select('id')->from('shopsy_seller')->where( array('seller_id' => $user_id) )->get()->first_row()->id;
		
		$this->load->view('site/seller/merchant_penaltys',$this->data);
	}
	
	function merchant_support() {
		$this->load->view('site/seller/merchant_support',$this->data);
	}

	function product_import_history() {
		if ( $this->data['loginCheck'] == '' ) {
			redirect('login');
			return;
		}
		$user_id = $this->checkLogin('U');
		$shop_id = $this->db->select('id')->from('shopsy_seller')->where( array('seller_id' => $user_id) )->get()->first_row()->id;
		$this->data['imports'] = $this->db->select('*')->from('saa_csv_import_history')->where( array('shop_id' => $shop_id ) )->get()->result_array();

		$this->load->view('site/seller/product_import_history',$this->data);
	}

} // class ends

/* End of file seller.php */
/* Location: ./application/controllers/site/seller.php */