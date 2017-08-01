<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * User related functions
 * @author Teamtweaks
 *
 */

class Cart extends MY_Controller { 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('cart_model');
		$this->load->library('user_agent');
		$this->data['loginCheck'] = $this->checkLogin('U');
		
    }
    
  
	/**
	 * 
	 * Loading Cart Page
	 */
	
	public function index(){
		//if ($this->data['loginCheck'] != ''){
			$uid=$this->session->userdata['shopsy_session_user_id'];
			$this->data['user_id'] = $uid;
			$this->data['meta_title'] = $this->data['heading'] = 'Cart'; 
			/*$this->data['cart'] = $this->cart_model->cart_detailed_view($this->data['common_user_id']);
			
			$this->data['relatedPersons'] =$relatedPersons= $this->cart_model->relatedPurchases($this->data['common_user_id']);
			$relatedPurchasesPrd = array();
			foreach($relatedPersons as $neighbours){
				$relatedPurchasesPrd[$neighbours->neighbourId]=$this->product_model->get_all_details(USER_PAYMENT,array('user_id'=>$neighbours->neighbourId))->result_array();
			}
			foreach($relatedPurchasesPrd as $neighboursprd){
				foreach($neighboursprd as $products){
					$condition = " where p.status='Publish' and p.id=".$products['product_id']." or p.status='Publish' and p.id=".$products['product_id']." group by p.id order by p.created desc";
				$relatedPurchases[]=$this->product_model->view_product_details($condition)->row();
				}
			}*/
			
			/*Remove the duplication products*/
			/*$newPrdArr[]=$relatedPurchases[0]->id;
			$newrelatedPurchases[$relatedPurchases[0]->id]=$relatedPurchases[0];
			$j=0;$l=1;
			for($k=1;$k<count($relatedPurchases);$k++){
				if(!in_array($relatedPurchases[$k]->id,$newPrdArr)){
					$j++;$l++;
					$newPrdArr[]=$relatedPurchases[$k]->id;
					$newrelatedPurchases[$relatedPurchases[$k]->id]=$relatedPurchases[$k];
				}
			}

			foreach($relatedPersons as $neighbours){
				unset($newrelatedPurchases[$neighbours->productId]);
			}
			if(!empty($relatedPersons))
			$this->data['relatedPurchases'] = $newrelatedPurchases;
			
		 	$this->load->view('site/cart/cart.php',$this->data);*/
		/*}else{
			redirect('login');
		}*/	
	} 

	public function makeFeatrue()
	{
		//print_r($this->input->post());die;
		$this->data['p_seo']=$this->uri->segment(4);
		#echo $this->data['p_seo'];die;
		$this->data['product_feature']=$this->product_model->get_all_details(FEATURE_PRODUCT,array('product_seo'=>$this->data['p_seo']))->result_array();
		$this->data['feature_list']=$this->product_model->get_all_details(FEATURE_PACK,array('status'=>'Active'))->result();
		$this->load->view('site/cart/pay_feature',$this->data);
	}


	//
	//  New Add to cart functionality
	//
	public function userAddToCart() {
		if ($this->checkLogin('U') == '' ) {
				echo 'Error|You need to login to buy the product!.'; die;
		}

		$product_id = $this->input->post('product_id');
		$shop_name = $this->input->post('shop_name');
		$total = ( $this->input->post('price') * $this->input->post('quantity') );
		$order_type = 'Normal';
		$mqty = $this->input->post('mqty');
		$user_id = $this->checkLogin('U');
		$options = '';
		if ( $this->input->post('var_color_1') != '' ) {
			$options .= "Color:" . $this->input->post('var_color_1');
		}
		if ( $this->input->post('var-color') != '' ) {
			$option = $this->db->select('option_value')->from('shopsy_product_option_values')
							   ->where( array( 'product_option_value_id' => $this->input->post('var-color') ) )
							   ->get()->first_row()->option_value;
			$options .= $options != '' ? ';' : '';
			$options .= "Color:" . $option;
		}
		if ( $this->input->post('var-size') != '' ) {
			$option = $this->db->select('option_value')->from('shopsy_product_option_values')
							   ->where( array( 'product_option_value_id' => $this->input->post('var-size') ) )
							   ->get()->first_row()->option_value;
			$options .= $options != '' ? ';' : '';
			$options .= "Size:" . $option;
		}

		$product = $this->cart_model->getProductInfo( $product_id );
		$shop_id = $product->store_id;
		
		$data = array();
		$store_disc_percent = 0;
		
		//store promotions
		$promo_qry = $this->db->select('discount_percent')->from('saa_shop_promotions')
							  ->where( "promotion_type = 'store' " )
							  ->where( "start_date <= '" . date('Y-m-d H:i:s') . "' AND end_date >= '" . date('Y-m-d H:i:s') ."'" )
							  ->where( 'shop_id = ' . $shop_id )
							  ->get();

		if ( $promo_qry->num_rows ) {
			 $store_disc_percent = $promo_qry->first_row()->discount_percent;
		}
		
		//Product Promotions
		$promo_qry = $this->db->select('discount_percent')->from('saa_shop_promotions')
							  ->where( "promotion_type = 'product' " )
							  ->where( "start_date <= '" . date('Y-m-d H:i:s') . "' AND end_date >= '" . date('Y-m-d H:i:s') ."'" )
							  ->where( array('shop_id' => $shop_id, 'product_id' => $product_id ) )
							  ->get();

		if ( $promo_qry->num_rows ) {
			 $product_disc_percent = $promo_qry->first_row()->discount_percent;
		} else $product_disc_percent = 0.0;

		$shipping_qry = $this->db->select( 'ship_price, next_item_price' )->from('shopsy_product_shipping')
							 ->where( array( 'code' => 'CUS') )->get();
		$shipping_cost = 0.0;
		$shipping_addl = 0.0;
		if( $shipping_qry->num_rows() ) {
			$shipping_cost = $shipping_qry->first_row()->ship_price;
			$shipping_addl = $shipping_qry->first_row()->next_item_price;
		}

		$store_credit = $this->db->select('max_discount')->from('shopsy_seller')->where( array('id' => $shop_id) )->get()->first_row();

		$data = array(
			'product_id' => $this->input->post('product_id'),
			'price' => $product->price,
			'msrp' => $product->msrp,
			'quantity' => $this->input->post('quantity'),
			'created' => date('Y-m-d H:i:s'),
			'user_id' => $user_id,
			'sell_id' => $shop_id,
			'shop_name' => $shop_name,
			'shipping_cost' => $shipping_cost,
			'additional_item_cost' => $shipping_addl,
			'total' => $total,
			'options' => $options,
			'store_discount' => $store_disc_percent,
			'product_discount' => $product_disc_percent,
			'max_store_discount' => (int) $store_credit->max_discount
		);


		/*$cart = $this->cart_model->get_all_details(USER_SHOPPING_CART,array( 'user_id' => $user_id));
		if($cart->num_rows() > 0 ){
			foreach($cart->result() as $item){
				$this->cart_model->update_details(USER_SHOPPING_CART,$data1,array('id'=> $item->id ));
			}
		}*/
		
		//$condition = array( 'user_id' => $user_id, 'product_id' => $product_id );
		$condition = '';
		//$cart = $this->cart_model->get_all_details( USER_SHOPPING_CART );
		$cart = $this->db->get_where( USER_SHOPPING_CART, array('product_id' => $product_id) );
		//
		if( $cart->num_rows > 0 ){
			$newQty = $cart->row()->quantity + $this->input->post('quantity');
			if ( $newQty <= $mqty ){
				$total = $this->input->post('price') * $newQty ; 
				$dataArr = array('quantity' => $newQty, 'total' => $total);
				$condition =array('id' => $cart->row()->id);
				$this->cart_model->update_details(USER_SHOPPING_CART,$dataArr,$condition); 
			}else{
				echo 'Error|'.$cart->row()->quantity; die;
			} 	

		} else {
			$this->cart_model->simple_insert(USER_SHOPPING_CART,$data );
		}
		$this->cart_model->updateShoppingCartItemsCount($user_id); 
		echo 'Success|' . "Product added to cart!"; 

	}
	/** 
	 * 
	 * User Cart Checkout function
	 *
	 */		
	public function placeOrder() {

		if ($this->checkLogin('U')==''){
    		redirect('login');
    	}

		$userid = $this->checkLogin('U');
		if ( (int) $userid <= 0 ) {
			$this->setErrorMessage('error', "Can't create Order, Please try later!");		
			redirect("home");
		} else {
			$this->data['cart'] = $this->cart_model->cart_detailed_view($this->data['common_user_id']);
			if( empty( $this->data['cart'] ) ) {
				$this->load->view('site/checkout/empty_cart', $this->data );
				return;
			}
			
			$this->data['cust_address'] = $this->db->select('full_name,last_name, email,phone_no, address, address2, city, state,postal_code')
									 ->from('shopsy_users')
									 ->where( array( 'id' => $userid ) )
									 ->get()->first_row();

			$states = $this->db->select('state_code, name')->from('shopsy_states')
							   ->where( array('countryid' => 215 ) )
							   ->order_by('name')
							   ->get()->result_array();
			/*$site_promo_qry = $this->db->select('*')->from('sa_site_promotions')
								   ->where( array( 'promotion_type' => 'code', 'status' => '1') )
								   ->where(" ( NOW() BETWEEN start_date AND end_date ) " )
								   ->get();*/
			$site_promo_qry = $this->db->query( "SELECT * FROM `sa_site_promotions` WHERE `promotion_type` = 'code' AND ( NOW() BETWEEN start_date and end_date )");
			
			if( $site_promo_qry->num_rows() ) {
				$this->data['site_promo'] = $site_promo_qry->result_array();
			} else {
				$this->data['site_promo'] = array();
			}
								   
			$this->data['states'] = '<option value="">Select state</option>';
			foreach( $states as $key => $state ) {
				if( $state['state_code'] == $this->data['cust_address']->state ) $selected = 'selected';
				else $selected = '';
				$this->data['states'] .= '<option value="'. $state['state_code'] .'" ' .$selected . ' >'. $state['name'] .'</option>';
			}
			$this->data['cart_summary'] = $this->cart_model->cartSummaryTotal( $this->data['cart'] );
			
			/*$this->data['sub_total'] = $item_total_amount;
			$this->data['total_msrp'] = $total_msrp;
			$this->data['total_savings_amount'] = $total_savings_amount;
			$this->data['shipping_total'] = $shipping_total;*/
							
			$this->load->view('site/checkout/checkout.php',$this->data);
		}

	}
	
	
	/** 
	 * 
	 * Cart Ajax Update function
	 *
	 */
	public function ajaxUpdate(){
		$excludeArr = array('id','qty','updval');
	
		$productVal = $this->cart_model->get_all_details(SHOPPING_CART,array( 'user_id' => $this->data['common_user_id'],'id' => $this->input->post('updval')));	
		
		$newQty = $this->input->post('qty');
		$indTotal = ( $productVal->row()->price + $productVal->row()->product_shipping_cost + ($productVal->row()->price * 0.01 * $productVal->row()->product_tax_cost) ) * $newQty ;
			
		$dataArr = array('quantity' => $newQty, 'indtotal' => $indTotal, 'total' => $indTotal);
		$condition =array('id' => $productVal->row()->id);
		$this->cart_model->commonInsertUpdate(SHOPPING_CART,'update',$excludeArr,$dataArr,$condition);
		
		echo number_format($indTotal,2,'.','').'|'.$this->data['CartVal'] = $this->cart_model->mani_cart_total($this->data['common_user_id']); 
		
		return;
	}
	
	/** 
	 * 
	 * User Cart Ajax Update function
	 *
	 */
	public function ajaxUserUpdate(){
		$excludeArr = array('id','qty','updval','selid');
		
		$productVal = $this->cart_model->get_all_details(USER_SHOPPING_CART,array( 'user_id' => $this->data['common_user_id'],'id' => $this->input->post('updval')));

		$newQty = $this->input->post('qty');
		$total = $productVal->row()->price * $newQty;
		//$indTotal = $productVal->row()->price * $newQty ;
		//$shipcost = $productVal->row()->product_shipping_cost * $newQty ;
			
		//$dataArr = array('quantity' => $newQty, 'indtotal' => $indTotal, 'shipping_cost' => $shipcost, 'total' => $indTotal);
		$dataArr = array( 'quantity' => $this->input->post('qty'), 'total' => $total  );
		$condition =array('id' => $this->input->post('updval') );
		$this->cart_model->update_details(USER_SHOPPING_CART,$dataArr,$condition);
		
		//echo number_format($indTotal,2,'.','').'|'.$this->data['CartVal'] = $this->cart_model->mani_user_cart_total($this->data['common_user_id'],$this->input->post('selid')); 
		
		return;
	}
	
	/** 
	 * 
	 * Cart Ajax Delete function
	 *
	 */
	public function ajaxDelete(){
		
		$json = array();
		try {
			$cart_id = base64_decode( $this->input->post('cart-item') ); 
			$user_id = $this->checkLogin('U'); 
			$this->db->delete( USER_SHOPPING_CART, array('id' => $cart_id, 'user_id' => $user_id )); 
			$this->cart_model->updateShoppingCartItemsCount($user_id); 
			
			$json = array( 'status' => 'success', 'message' => 'Product Removed From Your Cart successfully', 'cart_item_count' => $this->session->userdata( 'cart_quantity') );
		} catch( Exception $e ) {
			$json = array( 'status' => 'error', 'message' => $e->getMessage() );
		}
		echo json_encode( $json	);
	}
	
	
	
}

/* End of file user.php */
/* Location: ./application/controllers/site/user.php */