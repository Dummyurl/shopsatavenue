<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to Cart Page
 * @author Teamtweaks
 *
 */
class Cart_model extends My_Model
{
	/**
	* function to add value to cart
	* Param Array new data to add
	*/
	public function add_cart($dataArr=''){
			$this->db->insert(PRODUCT,$dataArr);
	}
	/**
	* function to edit cart
	* Param Array new data to add
	* Param String condition 
	*/
	public function edit_cart($dataArr='',$condition=''){
			$this->db->where($condition);
			$this->db->update(PRODUCT,$dataArr);
	}
	/**
	* function to view cart
	* Param String condition 
	*/
	public function view_cart($condition=''){
			return $this->db->get_where(PRODUCT,$condition);
			
	}
	
	public function cart_detailed_view( $user_id ) {

		$this->db->select('a.*,b.product_name,b.max_quantity as mqty,b.seourl,b.image,b.id as prdid,b.price as orgprice,b.ship_days');
		$this->db->from(USER_SHOPPING_CART.' as a');
		$this->db->join(PRODUCT.' as b' , 'b.id = a.product_id');
		//$this->db->join(PRODUCT_ATTRIBUTE.' as c' , 'c.id = a.attribute_values','left');		
		$this->db->where('a.user_id = '.$user_id)
				->order_by('a.sell_id asc');
		$cartVal = $this->db->get();
		
		return $cartVal->result();

	}
	
	/****************************Abandon list by sophia*****************************************/
	public function get_abandon_list()
	{
		$this->db->select('c.*,count("c.*") as countc,u.email,u.full_name');
		$this->db->from(USER_SHOPPING_CART.' as c');
		$this->db->join(USER.' as u ','c.user_id=u.id','left');
		$this->db->group_by('c.user_id');
		$this->db->order_by('c.created','asc');
		$res= $this->db->get();
		//echo "<pre>";print_r($res->result());die;
		return $res;
		 
	}
	public function get_cart_values($user_id)
	{
		$this->db->select('p.*,u.email,u.full_name,u.address,u.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.image,pd.id as PrdID,pAr.attr_name');
		$this->db->from(USER_SHOPPING_CART.' as p');
		$this->db->join(USERS.' as u' , 'p.user_id = u.id','left');
		$this->db->join(PRODUCT.' as pd' , 'pd.id = p.product_id','left');		
		$this->db->join(PRODUCT_ATTRIBUTE.' as pAr' , 'pAr.id = p.attribute_values','left');				
		$this->db->where('p.user_id = "'.$user_id.'"');
		$PrdList = $this->db->get();
		return $PrdList;
	
	}
	
	
	public function view_cart_details($condition = ''){
		$select_qry = "select p.*,u.full_name,u.user_name,u.thumbnail from ".PRODUCT." p LEFT JOIN ".USERS." u on u.id=p.user_id ".$condition;
		$cartList = $this->ExecuteQuery($select_qry);
		return $cartList;
			
	}
	

	public function getProductInfo( $product_id = 0 ) {
		$prod_qry = "SELECT p.msrp, p.price, p.store_id FROM shopsy_product p WHERE p.id = " . $product_id ;
		/*if( $prod_qry->num_rows() ) {
			return $prod_qry->first_row();	
		} else {
			return array();
		}*/
		return $this->ExecuteQuery( $prod_qry )->row();
	}
	
	function updateShoppingCartItemsCount( $user_id = 0 ) {
		$count = $this->db->select( 'count(*) as total' )->from( 'shopsy_user_shopping_carts' )->where( array( 'user_id' => $user_id ) )->get()->first_row()->total;

		$this->session->set_userdata( 'cart_quantity', $count );
	}
	
	/** 
	* 
	* User Ajax Change address for cart page function  
	*
	**/	
	public function ajaxUserShoppingCart($userid=''){
		if($userid != ''){
			$this->db->select('sell_id');
			$this->db->from(USER_SHOPPING_CART);
			$this->db->where(array('user_id'=>$userid));
			$this->db->group_by('sell_id');		
			$UsercartVal = $this->db->get();
			
			if($UsercartVal->num_rows()>0){
				foreach($UsercartVal->result() as $cVal){
					$seller_id=$cVal->sell_id;
					$shopId = 'shopId-'.$seller_id;
					$add_id=$this->session->userdata($shopId);
					if($add_id!=''){
						$ChangeAdds =  $this->cart_model->get_all_details(SHIPPING_ADDRESS,array( 'user_id' => $this->data['common_user_id'],'id' => $add_id));
						$shopCounty = 'ShopCountry-'.$seller_id;
						$this->session->unset_userdata($shopCounty, '');
						$this->session->set_userdata($shopCounty,$ChangeAdds->row()->country);
						
						$this->db->select("*");
						$this->db->where(array("seller_id"=>$seller_id,"state_name"=>$ChangeAdds->row()->state));
						$this->db->from(SELLER_TAX);
						$TaxList=$this->db->get();
						if($TaxList->row()->tax_amount > 0){
							$taxAmt = $TaxList->row()->tax_amount;
						}else{
							$taxAmt = 0;
						}
						
						$ProductVal = $this->cart_model->get_all_details(USER_SHOPPING_CART,array( 'sell_id' => $seller_id, 'user_id' => $this->data['common_user_id']),array(array('field'=>'id','type'=>'Asc')));				
						$s=0;
						
						
						foreach($ProductVal->result_array() as $prodtVal){
							$shipCost = $shipCost1 = 0;
							$SubShipVal = $this->cart_model->get_all_details(SUB_SHIPPING,array( 'product_id' => $prodtVal['product_id'],'ship_name' => $ChangeAdds->row()->country), array(array('field'=>'ship_id','type'=>'Desc')));
							
							if($SubShipVal->num_rows() > 0){
								if($s==0){
									$shipCost = $SubShipVal->row()->ship_cost;
								}else{
									$shipCost = $SubShipVal->row()->ship_other_cost;
								}

								$newshipCost = number_format( ($prodtVal['quantity'] * $shipCost),2,'.','');
								$conditionShip = array('id' => $prodtVal['id']);
								$dataArrShip = array('product_shipping_cost' => $shipCost,'shipping_cost' => $newshipCost,'shipping'=>'Yes','tax'=>$taxAmt);
								$this->cart_model->update_details(USER_SHOPPING_CART,$dataArrShip,$conditionShip); 
								$s++;	
							}else{
								$SubShipValNew = $this->cart_model->get_all_details(SUB_SHIPPING,array( 'product_id' => $prodtVal['product_id'],'ship_name' => 'Everywhere Else'), array(array('field'=>'ship_id','type'=>'Desc')));
								if($SubShipValNew->num_rows() > 0){
									if($s==0){
										$shipCost1 = $SubShipValNew->row()->ship_cost;
									}else{
										$shipCost1 = $SubShipValNew->row()->ship_other_cost;
									}
									$newshipCost1 = number_format( ($prodtVal['quantity'] * $shipCost1),2,'.','');
									$conditionShip1 = array('id' => $prodtVal['id']);
									$dataArrShip1 = array('product_shipping_cost' => $shipCost1,'shipping_cost' => $newshipCost1,'shipping'=>'Yes','tax'=>$taxAmt);	
									$this->cart_model->update_details(USER_SHOPPING_CART,$dataArrShip1,$conditionShip1); 
									$s++;	
								}else{
										$conditionShip1 = array('id' => $prodtVal['id']);
										$dataArrShip1 = array('product_shipping_cost' => '0.00','shipping_cost' => '0.00','shipping'=>'No','tax'=>'0.00');	
										$this->cart_model->update_details(USER_SHOPPING_CART,$dataArrShip1,$conditionShip1); 
								}
							}	
						}
					}
				}
			}	
		}
	}
	
	/*
		Cart Summary Total
	*/
	function cartSummaryTotal( $cart ) {
			$total_msrp = 0.0; $shipping_total=0.0;
            $store_savings_amount = 0.0; $item_total_amount = 0.0; $saa_total_savings_amount = 0.0;
		    $sale_discount_amount = 0;
			for( $i=0; $i < count( $cart ); $i++ ) { 
			  $store_credit = 0;
			  //MSRP
			  $total_msrp += ($cart[$i]->msrp * $cart[$i]->quantity);
			  //SHIPPING COST
			  if( $cart[$i]->quantity > 1 ) {
				  if( $cart[$i]->additional_item_cost == 0.0 ) {
					  $shipping_total += $cart[$i]->shipping_cost * $cart[$i]->quantity;
				  } else {
					$shipping_total += $cart[$i]->shipping_cost + ( ($cart[$i]->quantity - 1 ) * $cart[$i]->additional_item_cost );
				  }
			  } else {
				$shipping_total += $cart[$i]->shipping_cost * $cart[$i]->quantity;
			  }
			  
			  //Discount
			  if ( $cart[$i]->store_discount > 0 && $cart[$i]->store_discount <= $cart[$i]->max_store_discount )  {
				  $sale_discount_amount +=  ( $cart[$i]->price / 100  *  $cart[$i]->store_discount );
			  }
			  //if ( $cart[$i]->max_store_discount > $cart[$i]->sale_discount_percent ) {
				//  $sale_discount = 0;
				//  $store_credit = ($cart[$i]->price * $cart[$i]->quantity ) / 100 * $cart[$i]->max_store_discount;
				//  $total_store_credit += $store_credit;
			  //}
			  
			  //TOTAL SAVINGS - SAA
			  $saa_total_savings_amount +=  ( $cart[$i]->msrp - $cart[$i]->price ) * $cart[$i]->quantity;
			  
			  //TOTAL ITEM COST - without discount
			  $item_total_amount += ( $cart[$i]->price * $cart[$i]->quantity ) - $sale_discount_amount;
			}
			
			$data = array();
			$data['sub_total'] = $item_total_amount;
			$data['total_msrp'] = $total_msrp;
			$data['total_savings_amount'] = $saa_total_savings_amount;
			$data['store_discount'] = $sale_discount_amount;
			$data['shipping_total'] = $shipping_total;
			return $data;

	}
}


?>