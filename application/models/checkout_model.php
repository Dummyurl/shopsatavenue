<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to Cart Page
 * @author Teamtweaks
 *
 */
class Checkout_model extends My_Model
{
	/**
	* function to add values to check out
	* Param Array Newdata 
	*/
	public function add_checkout($dataArr=''){
			$this->db->insert(PRODUCT,$dataArr);
	}
	/**
	* function to edit check out 
	* Param Array Newdata 
	* Param Array Condition 
	*/
	public function edit_checkout($dataArr='',$condition=''){
			$this->db->where($condition);
			$this->db->update(PRODUCT,$dataArr);
	}
	/**
	* function to view checkout
	* Param String condition
	*/
	
	public function view_checkout($condition=''){
			return $this->db->get_where(PRODUCT,$condition);
			
	}
	
	/**
	* function to view gift card details
	* Param Int user Id
	*/
	public function mani_gift_total($userid=''){
		
		$giftRes = $this->checkout_model->get_all_details(GIFTCARDS_TEMP,array( 'user_id' => $userid));
		$giftAmt = 0;
		if($giftRes -> num_rows() > 0 ){ 
			
			foreach ($giftRes->result() as $giftRow){
				$giftAmt = $giftAmt + $giftRow->price_value;
			}

		}
		
		return number_format($giftAmt,2,'.','');

	}
	/**
	* function to get check out amount details 
	* Param Int user Id
	*/
	public function mani_checkout_total($userid=''){
		
		
		$checkoutVal = $this->checkout_model->get_all_details(SHOPPING_CART,array( 'user_id' => $userid));
		$checkoutAmt = 0; $checkoutShippingAmt = 0; $checkoutTaxAmt = 0;
		$Shipping_Val = $this->checkout_model->get_all_details(PAYMENT,array( 'user_id' => $userid, 'dealCodeNumber' => $this->session->userdata('randomNo')));
		
		if($checkoutVal -> num_rows() > 0 ){ 
			foreach ($checkoutVal->result() as $CartRow){
				$checkoutAmt = $checkoutAmt + (($CartRow->product_shipping_cost +  ($CartRow->product_tax_cost * 0.01 * $CartRow->price) + $CartRow->price)  * $CartRow->quantity);
			}
			$checkoutSAmt = $Shipping_Val->row()->shippingcost;
			$checkoutTAmt = $Shipping_Val->row()->tax;
			$grantAmt = $checkoutAmt + $checkoutSAmt + $checkoutTAmt ;
			
		}
		
		$this->db->select('discountAmount');
		$this->db->from(SHOPPING_CART);
		$this->db->where('user_id = '.$userid);
		$query = $this->db->get();
		
		if($query->row()->discountAmount !=''){
			$grantAmt = $grantAmt - $query->row()->discountAmount;
		}
		
		return number_format($checkoutAmt,2,'.','').'|'.number_format($checkoutSAmt,2,'.','').'|'.number_format($checkoutTAmt,2,'.','').'|'.number_format($grantAmt,2,'.','').'|'.$countVal.'|'.number_format($query->row()->discountAmount,2,'.','').'|'.$Shipping_Val->row()->shippingid;
		

	}
		/**
	* function to get total check out amount details  
	* Param Int user Id
	*/
	public function mani_user_checkout_total($userid=''){

		$UsercheckoutAmt = 0; $UsercheckoutShippingAmt = 0; $MainTaxCost = $UsercartTAmt = $UsercheckoutTaxAmt = 0; $UserDisAmt = 0; $UserGiftDisAmt = 0;  $UsercheckoutlessAmt = 0;
		$Shipping_Val = $this->checkout_model->get_all_details(USER_PAYMENT,array( 'user_id' => $userid, 'dealCodeNumber' => $this->session->userdata('UserrandomNo')));
		$UsercheckoutVal = $this->checkout_model->get_all_details(USER_SHOPPING_CART,array( 'user_id' => $userid,'sell_id' => $Shipping_Val->row()->sell_id));
		if($UsercheckoutVal -> num_rows() > 0 ){ 
			foreach ($UsercheckoutVal->result() as $UserCartRow){
				$UsercheckoutAmt = $UsercheckoutAmt + ($UserCartRow->price * $UserCartRow->quantity);
				$UsercheckoutSAmt = $UsercheckoutSAmt + ($UserCartRow->product_shipping_cost * $UserCartRow->quantity);
				$UsercheckoutTAmt = $UsercheckoutTAmt + $UserCartRow->product_tax_cost;
			}
			
			$MainTaxCost = $UsercheckoutVal->row()->tax; 
			$UsercartTAmt = ($UsercheckoutAmt * 0.01 * $MainTaxCost);
			$UsercheckoutTAmt = $UsercheckoutTAmt + $UsercartTAmt ;
			
			$UsergrantAmt = $UsercheckoutAmt + $UsercheckoutSAmt + $UsercheckoutTAmt ; 
		}
		
		//$SellDetails = $this->checkout_model->get_all_details(SELLER,array( 'seller_id' => $Shipping_Val->row()->sell_id));
		
		$this->db->select('discountAmount,giftdiscountAmount');
		$this->db->from(USER_SHOPPING_CART);
		$this->db->where('user_id = '.$userid);
		$query = $this->db->get();
		
		$UsercheckoutlessAmt = $UsercheckoutAmt;
		if($query->row()->discountAmount !=''){
			$UserDisAmt = $query->row()->discountAmount;
			$UsergrantAmt = $UsergrantAmt - $UserDisAmt;
			$UsercheckoutlessAmt = $UsercheckoutlessAmt - $UserDisAmt;
		}
		
		if($query->row()->giftdiscountAmount !=''){
			$UserGiftDisAmt = $query->row()->giftdiscountAmount;
			$UsergrantAmt = $UsergrantAmt - $UserGiftDisAmt;
			$UsercheckoutlessAmt = $UsercheckoutlessAmt - $UserGiftDisAmt;
		}

		
		return  number_format($UsercheckoutAmt,2,'.','').'|'.number_format($UsercheckoutSAmt,2,'.','').'|'.number_format($UsercheckoutTAmt,2,'.','').'|'.number_format($UsergrantAmt,2,'.','').'|'.$Shipping_Val->row()->shippingid.'|'.number_format($UserDisAmt,2,'.','').'|'.number_format($UserGiftDisAmt,2,'.','').'|'.number_format($UsercheckoutlessAmt,2,'.','');
		

	}
		/**
	* function to remove gift code value 
	* Param Int user Id
	*/
	
	public function Gift_Code_Val_Remove($userid = ''){

		$excludeArr = array('code');

		$dataArr = array('giftdiscountAmount' => 0,
											'giftcouponID' => 0,
											'giftcouponCode' => '',
											'giftcoupontype' => '',
											'gift_coupon_used' => 'No');
		$condition =array('user_id' => $userid);
		$this->checkout_model->commonInsertUpdate(USER_SHOPPING_CART,'update',$excludeArr,$dataArr,$condition);
		return;
	}
	
		/**
	* function to get subscription amount details 
	* Param Int user Id
	*/
	public function mani_subcribe_total($userid=''){
	
		$SubcribRes = $this->checkout_model->get_all_details(FANCYYBOX_TEMP,array( 'user_id' => $userid));
		$SubcribAmt = 0; $SubcribSAmt = 0; $SubcribTAmt = 0; $SubcribTotalAmt = 0;
		if($SubcribRes -> num_rows() > 0 ){ 
			
			foreach ($SubcribRes->result() as $SubscribRow){
				$SubcribAmt = $SubcribAmt + $SubscribRow->price;
			}
			$SubcribSAmt = $SubcribRes->row()->shipping_cost;
			$SubcribTAmt = $SubcribRes->row()->tax;
			$SubcribTotalAmt = $SubcribAmt + $SubcribSAmt + $SubcribTAmt ;

		}
		
		
		return number_format($SubcribAmt,2,'.','').'|'.number_format($SubcribSAmt,2,'.','').'|'.number_format($SubcribTAmt,2,'.','').'|'.number_format($SubcribTotalAmt,2,'.','');

	}

	public function createOrder( $userid = 0 ) {
		
		$stores = array();
		$store_query = $this->db->query("SELECT DISTINCT sell_id FROM " . USER_SHOPPING_CART . " WHERE user_id = " . (int) $userid );
		$j = 1;
		foreach ($store_query->result_array() as $key => $val) {
			$store = $val['sell_id'];
			$stores[$store] = $j;
			$j++;
		}

		$this->db->select('a.*,p.product_name');
		$this->db->from(USER_SHOPPING_CART.' as a');
		$this->db->join('shopsy_product p', 'a.product_id = p.id', 'left' )
				 ->where( array('a.user_id' => $userid) );
				 //->join(SHIPPING_ADDRESS.' as b' , 'a.user_id = b.user_id and a.user_id = "'.$userid.'" and b.id="'.$this->input->post('Ship_address_val').'"');
		$cartItems = $this->db->get();
		
		//Create Order Record
		$data = array(
			'customer_id'  => $userid,
			'order_status_id' => 0,
			'user_agent'    => $_SERVER['HTTP_USER_AGENT'],
			'ip'  => $_SERVER['REMOTE_ADDR'],
			'date_added'    => date('Y-m-d H:i:s'),
			'date_modified' => date('Y-m-d H:i:s'),
		);
		$this->db->insert('sa_order', $data );
		$order_id = $this->db->insert_id();

		$order_total = 0.0;
		if( (int) $order_id > 0 ) {
			$credit_amount_qry = $this->db->select('credit_id, credit_amount')->from('sa_member_credit')
									  ->where( array( 'user_id' => $userid ) )
									  ->where( "expiry_date <= '" . date('Y-m-d') . "'" )
									  ->get();
			if( $credit_amount_qry->num_rows() ) {
				$member_cr = $credit_amount_qry->first_row();
			} else {
				$member_cr = (object) array( 'credit_id' => 0, credit_amount => 0.0 );
			}
			$seller = $this->db->select('sell_id')->from(USER_SHOPPING_CART)->where( array('user_id' => $userid) )->get()->result_array();
			$sellers = array();
			foreach( $seller as $key => $val ) {
				$sellers[] = $val['sell_id'];
			}
			
			if( is_array( $sellers ) ) {
				$store_credit = $this->db->select('id, max_discount')->from('shopsy_seller')->where_in( 'id', $sellers )->get()->result_array();
				unset( $sellers );
				foreach( $store_credit as $key => $val ) {
					$shop_id = $val['id'];
					$sellers[$shop_id] = (int) $val['max_discount'];
				}
			}

			foreach ($cartItems->result() as $result) {
				$shop_id = $result->sell_id;
				$store_discount = false;
				//check store discount availability
				if ( isset( $sellers[$shop_id]) )  $store_discount = true;
				if ( $store_discount ) {
					$total_discount = ($result->price * $result->quantity ) / 100  *  $sellers[$shop_id];
				} else {
					$total_discount = ($result->price * $result->quantity ) / 100  *  $result->sale_discount_percent;
				}
				
				$total_shipping_cost = ($result->shipping_cost * $result->quantity );
				$total = (float) ($result->price * $result->quantity ) - $total_discount + $total_shipping_cost;
				$order_total += $total;
				$data = array(
					'order_id'    =>  $order_id,
					'store_id'    =>  $shop_id,
					'store_order_id' => str_pad($order_id, 8, "0", STR_PAD_LEFT) . "-" . $stores[$shop_id],
					'orderKey'    =>  str_pad($order_id, 8, "0", STR_PAD_LEFT),
					'product_id'  =>  $result->product_id,
					'name'        =>  $result->product_name,
					'quantity'    => $result->quantity,
					'price'       => $result->price,
					'disc_amount' => $total_discount,
					'shipping_paid' => $total_shipping_cost,
					'store_discount' => 1,
					'total'       => $total
				);
				$this->db->insert('sa_order_product', $data);
			}
			$this->db->update( 'sa_order', array( 'total' => $order_total), array( 'order_id' => $order_id ) );

		}

		if ( $order_id > 0 ) {
			$delete = "delete from " . USER_SHOPPING_CART . " where user_id = " . $userid ;
			$this->ExecuteQuery($delete, 'delete');
			
			$this->session->set_userdata( 'cart_quantity', '0' );
			
		}

		return $order_id;
	}


		/**
	* function to view check out  details 
	* Param String Condition
	*/
	
	
	public function view_checkout_details($condition = ''){
		$select_qry = "select p.*,u.full_name,u.user_name,u.thumbnail from ".PRODUCT." p LEFT JOIN ".USERS." u on u.id=p.user_id ".$condition;
		$checkoutList = $this->ExecuteQuery($select_qry);
		return $checkoutList;
			
	}
		/**
	* function to view attribute details 
	*/
	public function view_atrribute_details(){
		$select_qry = "select * from ".ATTRIBUTE." where status='Active'";
		return $attList = $this->ExecuteQuery($select_qry);
	
	}
	
	/******************** Gift code checkout Function  ********************/
	public function Gift_Check_Code_Val($Code = '',$amount = '',$shipamount = '', $taxamount = '', $discountamount = '', $giftdiscountamount = '', $cartlessamount = '', $userid = ''){
	
		
		$code = $Code;
		$amount = $cartlessamount;
		$amountOrg = $cartlessamount;
		$shipamount = $shipamount;
		$taxamount = $taxamount;
		$discountamount = $discountamount;
		$giftdiscountamount = $giftdiscountamount;
		$cartlessamount = $cartlessamount;						
		
		$GiftRes = $this->checkout_model->get_all_details(GIFTCARDS,array( 'code' => $code));
		$ShopArr = $this->checkout_model->get_all_details(USER_SHOPPING_CART,array( 'user_id' => $userid));

		
		if($GiftRes->num_rows() > 0){

			$curGiftVal = (strtotime($GiftRes->row()->expiry_date) < time());
			if($curGiftVal != '') {
				echo '8';
				exit();
			}

			if($GiftRes->row()->price_value > $GiftRes->row()->used_amount){

				$NewGiftAmt = $GiftRes->row()->price_value - $GiftRes->row()->used_amount;
				if($amount > $NewGiftAmt){
					$amountOrg = $amountOrg - $NewGiftAmt;

					$dataArr = array('giftdiscountAmount' => $NewGiftAmt,
											'giftcouponID' => $GiftRes->row()->id,
											'giftcouponCode' => $code,
											'giftcoupontype' => 'Gift',
											'gift_coupon_used' => 'Yes',
											'total' => $amountOrg);
					$condition =array('user_id' => $userid);
					$this->checkout_model->update_details(USER_SHOPPING_CART,$dataArr,$condition);

				}else{
					$dataArr = array('giftdiscountAmount' => $amountOrg,
											'giftcouponID' => $GiftRes->row()->id,
											'giftcouponCode' => $code,
											'giftcoupontype' => 'Gift',
											'gift_coupon_used' => 'Yes',
											'total' => '0');
					$condition =array('user_id' => $userid);
					$this->checkout_model->update_details(USER_SHOPPING_CART,$dataArr,$condition);

				}

				echo 'Success|'.$GiftRes->row()->id.'|Gift';
				exit();
					
			}else{
				echo '2';
				exit();
			}

		}else{
			echo '1';
			exit();
		}


	}
	
	
}

?>