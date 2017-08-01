<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php');
/**
 * 
 * User related functions
 * @author Casperon
 *
 */

class Checkout extends MY_Controller { 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('checkout_model');
		$this->load->model('cart_model');
		
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['countryList'] = $this->checkout_model->get_all_details(COUNTRY_LIST,array(),array(array('field'=>'name','type'=>'asc')));
    }
    
  
	/**
	 * 
	 * Loading Cart Page
	 */
	
	public function index(){
		if ($this->data['loginCheck'] != ''){
			$user_id = $this->session->userdata['shopsy_session_user_id'];

			$this->data['meta_title'] = $this->data['heading'] = 'Checkout'; 
		
			//$this->data['CheckoutVal'] = $this->checkout_model->get_all_details(USER_PAYMENT,array('dealCodeNumber'=>$this->session->userdata('UserrandomNo')));
			//$this->data['SellerDetails'] = $this->checkout_model->get_all_details(SELLER,array('seller_id'=>$this->data['CheckoutVal']->row()->sell_id));
			
			$this->data['cart'] = $this->cart_model->cart_detailed_view($this->data['common_user_id']);
			

			//$this->data['shipValDetails'] = $this->checkout_model->get_all_details(SHIPPING_ADDRESS,array( 'id' => $this->data['CheckoutVal']->row()->shippingid));

			//$this->data['UserCheckoutResults'] = $this->checkout_model->mani_user_checkout_total($this->data['common_user_id']);				

			//$this->data['discountQuery'] = $this->checkout_model->get_all_details(USER_SHOPPING_CART,array('user_id'=>$this->data['common_user_id']));
			//$this->data['countryList'] = $this->checkout_model->get_all_details(COUNTRY_LIST,array(),array(array('field'=>'name','type'=>'asc')));	

			$states = $this->db->select('state_code, name')->from('shopsy_states')
							   ->where( array('countryid' => 215 ) )
							   ->order_by('name')
							   ->get()->result_array();
			$this->data['states'] = '<option value="">Select state</option>';
			foreach( $states as $key => $state ) {
				$this->data['states'] .= '<option value="'. $state['state_code'] .'">'. $state['name'] .'</option>';
			}

			//$shipVal = $this->cart_model->get_all_details(SHIPPING_ADDRESS,array( 'user_id' => $user_id));
			//if( $shipVal->num_rows() ) {
				//$this->data['ship_address'] = $shipVal->first_row();
			//}

			$this->load->view('site/checkout/checkout.php',$this->data);

		}else{
			redirect('login');
		}	
	}
	
	function checkout() {
		if ($this->data['loginCheck'] != '') {
			$user_id = $this->session->userdata['shopsy_session_user_id'];

			$this->data['meta_title'] = $this->data['heading'] = 'Checkout'; 

			$this->data['order'] = $this->db->select( 'o.*')->from('sa_order o')
							  ->where( array( 'o.order_id' => $this->session->userdata('order_id') ) )
							  ->get()->first_row();
			$this->data['order_product'] = $this->db->select( 'op.*')->from('sa_order_product op')
							  ->where( array( 'op.order_id' => $this->session->userdata('order_id') ) )
							  ->get()->result_array();

			$states = $this->db->select('state_code, name')->from('shopsy_states')
							   ->where( array('countryid' => 215 ) )
							   ->order_by('name')
							   ->get()->result_array();
			$this->data['states'] = '<option value="">Select state</option>';
			foreach( $states as $key => $state ) {
				if( $state['state_code'] == $this->data['order']->shipping_zone ) $selected = 'selected';
				else $selected = '';
				$this->data['states'] .= '<option value="'. $state['state_code'] .'" ' .$selected . ' >'. $state['name'] .'</option>';
			}

			$this->load->view('site/checkout/checkout.php',$this->data);

		}else{
			redirect('login');
		}	
	}
	
	public function completeOrder() { //stripe payment

		if( (int) $this->input->post('card_number') == '' ) {
			echo json_encode( array('error' => 1, 'message' => "checkout error" ) );
			exit(0);
		}
		$user_id = $this->checkLogin('U');

		//Credit car payment processing
		$payment_type = 'Sale';
		$paypal_pro_payment_mode = false; //false is test mode
		$card_number = $this->input->post('card_number');
		$exp_month = $this->input->post('exp_month');
		$exp_year = $this->input->post('exp_year');
		$card_cvv = $this->input->post('card_cvv');
		$card_name = $this->input->post('card_name');
		$access_token = $this->input->post('access_token');

		$bill_same_as_ship = (int) $this->input->post('same_as_shipping');

		$order_id =  $this->checkout_model->createOrder( $user_id );
		if( (int) $order_id == 0 ) {
			echo json_encode( array('error' => 1, 'message' => "Can't create Order" ) ); 
			exit(0);
		}

		$payment_status = false;
		$order_total = 0.0;
		$order_info = $this->db->select('total')->from('sa_order')->where( array('order_id' => $order_id) )->get();
		if( $order_info->num_rows() ) {
			$order_total = $order_info->first_row()->total;
		}
		if( $order_total == 0 ) {
			redirect('site/cart');
			exit(0);
		}

		if ( $bill_same_as_ship ) {
			$data = array(
				'shipping_firstname' => $this->input->post('ship_name'),
				'shipping_address_1' => $this->input->post('ship_address_line1'),
				'shipping_address_2' => $this->input->post('ship_address_line2'),
				'shipping_city' => $this->input->post('ship_city'),
				'shipping_postcode' => $this->input->post('ship_zipcode'),
				'shipping_zone' => $this->input->post('ship_state'),
				'payment_firstname' => $card_name,
				'payment_address_1' => $this->input->post('ship_address_line1'),
				'payment_address_2' => $this->input->post('ship_address_line2'),
				'payment_city' => $this->input->post('ship_city'),
				'payment_postcode' => $this->input->post('ship_zipcode'),
				'payment_zone' => $this->input->post('ship_state'),
				'telephone' => $this->input->post('ship_phone'),
				'email'     => $this->input->post('ship_email'),
				'order_status_id' => 0
			);
		} else {
			$data = array(
				'shipping_firstname' => $this->input->post('ship_name'),
				'shipping_address_1' => $this->input->post('ship_address_line1'),
				'shipping_address_2' => $this->input->post('ship_address_line2'),
				'shipping_city' => $this->input->post('ship_city'),
				'shipping_postcode' => $this->input->post('ship_zipcode'),
				'shipping_zone' => $this->input->post('ship_state'),
				'payment_firstname' => $card_name,
				'payment_address_1' => $this->input->post('bill_address_line1'),
				'payment_address_2' => $this->input->post('bill_address_line2'),
				'payment_city' => $this->input->post('bill_city'),
				'payment_postcode' => $this->input->post('bill_zipcode'),
				'payment_zone' => $this->input->post('bill_state'),
				'telephone' => $this->input->post('ship_phone'),
				'email'     => $this->input->post('ship_email'),
				'order_status_id' => 0
			);
		}
		
		$this->db->update('sa_order', $data, array('order_id' => $order_id ) );

		try {
            Stripe::setApiKey('sk_test_fQbU9NKh8YJAGNgp5WFGZy3i');
            $charge = Stripe_Charge::create(array(
                        "amount" => str_replace('.','',number_format($order_total,2)),
                        "currency" => "USD",
                        "card" => $access_token,
                        "description" => $order_id
            ));

            // this line will be reached if no error was thrown above

				$data = array(
					'order_id' => $order_id,
					'transaction_id' => $charge->id,
					'pay_from' => 'Stripe',
					'amount_paid' => $order_total,
					'date_modified' => date('Y-m-d H:i:s'),
					'date_created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('sa_order_payments', $data );
				$this->db->update('sa_order', array('order_status_id' => 1), array('order_id' => $order_id) );
				
				file_put_contents( FCPATH."logs/checkout_log.txt", $order_id . " - " . print_r( $charge,1) . "\r\n" , FILE_APPEND );
				//file_put_contents( FCPATH."logs/checkout_log.txt", $order_id . " - " . print_r( $response_info, 1) . "\r\n" , FILE_APPEND );
			
				$stores = $this->db->select("op.store_id, op.store_order_id, s.seller_email, s.seller_businessname")
								   ->from('sa_order_product op')
								   ->join('shopsy_seller s', 's.id = op.store_id', 'left' )
								   ->where( array( 'op.order_id' => $order_id ) )
								   ->get()->result_array();

				//Store Notification
				foreach( $stores as $key => $store ) {
					$this->load->library('email');
					
					$body = "Hi " . $store['seller_businessname'] . "\r\n";
					$body .= "Congrats! You received a new order #" . $store['store_order_id'];
					$this->email->from('admin@shopsatavenue.net', 'Admin');
					$this->email->to($store['seller_email']);
					//$this->email->cc('another@another-example.com');
					//$this->email->bcc('them@their-example.com');
					
					$this->email->subject('Order notification!');
					$this->email->message($body);
		
					$this->email->send();
				}
			
				//redirect('site/checkout/order_thanks/'. $order_id);

                echo json_encode(array('status' => 200, 'success' => 1, 'message' => 'Payment successfully completed.', 'order_id' => $order_id ));
			/*else {
                echo json_encode(array('status' => 500, 'error' => 'Something went wrong. Try after some time.'));
                exit();
            }*/
        } catch (Stripe_CardError $e) {
            echo json_encode(array('status' => 500, 'error' => 1, 'message' => STRIPE_FAILED));
			//file_put_contents( FCPATH."logs/checkout_log.txt", STRIPE_FAILED  . "\r\n" , FILE_APPEND );
            exit();
        } catch (Stripe_InvalidRequestError $e) {
            // Invalid parameters were supplied to Stripe's API
            echo json_encode(array('status' => 500, 'error' => 1, 'message' => $e->getMessage()));
			//file_put_contents( FCPATH."logs/checkout_log.txt", $e->getMessage()  . "\r\n" , FILE_APPEND );
            exit();
        } catch (Stripe_AuthenticationError $e) {
            // Authentication with Stripe's API failed
            echo json_encode(array('status' => 500, 'error' => 1, 'message' => AUTHENTICATION_STRIPE_FAILED));
			//file_put_contents( FCPATH."logs/checkout_log.txt", AUTHENTICATION_STRIPE_FAILED . "\r\n" , FILE_APPEND );
            exit();
        } catch (Stripe_ApiConnectionError $e) {
            // Network communication with Stripe failed
            echo json_encode(array('status' => 500, 'error' => 1, 'message' => NETWORK_STRIPE_FAILED));
			//file_put_contents( FCPATH."logs/checkout_log.txt", NETWORK_STRIPE_FAILED  . "\r\n" , FILE_APPEND );
            exit();
        } catch (Stripe_Error $e) {
            // Display a very generic error to the user, and maybe send
            echo json_encode(array('status' => 500, 'error' => 1, 'message' => STRIPE_FAILED));
			//file_put_contents( FCPATH."logs/checkout_log.txt", STRIPE_FAILED  . "\r\n" , FILE_APPEND );
            exit();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            echo json_encode(array('status' => 500, 'error' => 1, 'message' => STRIPE_FAILED));
			//file_put_contents( FCPATH."logs/checkout_log.txt", STRIPE_FAILED  . "\r\n" , FILE_APPEND );
            exit();
        }
		
 
	}
	
	function validatePromoCode() {
		$json = array();
		$promo_code = $this->input->post('promo_code');
		try {
			$promo_qry = $this->db->query("SELECT * FROM `sa_site_promotions` WHERE `promotion_type` = 'code' AND ( NOW() BETWEEN start_date and end_date )");
			if( $promo_qry->num_rows() ) {
				$promo = $promo_qry->first_row();
				if( $promo->promo_code == $promo_code ) {
					$promo_discount = (float) $promo->percent_off;
					$user_id = $this->checkLogin('U');
					$cart = $this->cart_model->cart_detailed_view( $user_id );
					$cart_summary = $this->cart_model->cartSummaryTotal( $cart );
					$promo_discount_amount = $cart_summary['sub_total'] / 100 * $promo_discount;
					$cart_summary['promo_discount_amount'] = $promo_discount_amount;
					$cart_summary['promo_discount'] = $promo_discount;
					$cart_summary['cart_total'] = ($cart_summary['sub_total'] - $promo_discount_amount ) + $cart_summary['shipping_total'];
					$json = array('status' => 'success', 'message' => 'Promo code applied!', 'cart_summary' => $cart_summary );
				} else {
					$json = array('status' => 'error', 'message' => 'Invalid promo code!' );
				}
			} else {
				$json = array('status' => 'error', 'message' => 'Invalid promo code!' );
			}
		} catch( Exception $e ) {
            echo json_encode(array('status' => 'error' , 'message' => $e->getMessage() ));
		}
		
		echo json_encode( $json );
	}
	
	/*public function completeOrder() {  // with paypal

		if( (int) $this->input->post('card_number') == '' ) {
			echo "checkout error";
			exit(0);
		}
		$user_id = $this->checkLogin('U');
		
		//Credit car payment processing
		$payment_type = 'Sale';
		$paypal_pro_payment_mode = false; //false is test mode
		$card_number = $this->input->post('card_number');
		$exp_month = $this->input->post('exp_month');
		$exp_year = $this->input->post('exp_year');
		$card_cvv = $this->input->post('card_cvv');
		$card_name = $this->input->post('card_name');
	
		$bill_same_as_ship = (int) $this->input->post('same_as_shipping');

		$order_id =  $this->checkout_model->createOrder( $user_id );
		$payment_status = false;
		
		if( (int) $order_id == 0 ) {
			echo "Can't create Order";
			exit(0);
		}
		$order_total = 0.0;
		$order_info = $this->db->select('total')->from('sa_order')->where( array('order_id' => $order_id) )->get();
		if( $order_info->num_rows() ) {
			$order_total = $order_info->first_row()->total;
		}

		if ( $bill_same_as_ship ) {
			$data = array(
				'shipping_firstname' => $this->input->post('ship_name'),
				'shipping_address_1' => $this->input->post('ship_address_line1'),
				'shipping_address_2' => $this->input->post('ship_address_line2'),
				'shipping_city' => $this->input->post('ship_city'),
				'shipping_postcode' => $this->input->post('ship_zipcode'),
				'shipping_zone' => $this->input->post('ship_state'),
				'payment_firstname' => $card_name,
				'payment_address_1' => $this->input->post('ship_address_line1'),
				'payment_address_2' => $this->input->post('ship_address_line2'),
				'payment_city' => $this->input->post('ship_city'),
				'payment_postcode' => $this->input->post('ship_zipcode'),
				'payment_zone' => $this->input->post('ship_state'),
				'telephone' => $this->input->post('ship_phone'),
				'email'     => $this->input->post('ship_email'),
				'order_status_id' => 0
			);
		} else {
			$data = array(
				'shipping_firstname' => $this->input->post('ship_name'),
				'shipping_address_1' => $this->input->post('ship_address_line1'),
				'shipping_address_2' => $this->input->post('ship_address_line2'),
				'shipping_city' => $this->input->post('ship_city'),
				'shipping_postcode' => $this->input->post('ship_zipcode'),
				'shipping_zone' => $this->input->post('ship_state'),
				'payment_firstname' => $card_name,
				'payment_address_1' => $this->input->post('bill_address_line1'),
				'payment_address_2' => $this->input->post('bill_address_line2'),
				'payment_city' => $this->input->post('bill_city'),
				'payment_postcode' => $this->input->post('bill_zipcode'),
				'payment_zone' => $this->input->post('bill_state'),
				'telephone' => $this->input->post('ship_phone'),
				'email'     => $this->input->post('ship_email'),
				'order_status_id' => 0
			);
		}
		
		$this->db->update('sa_order', $data, array('order_id' => $order_id ) );
		if( $order_total == 0 ) {
			redirect('site/cart');
			exit(0);
		}
		
		$stores = $this->db->select("op.store_id, op.store_order_id, s.seller_email, s.seller_businessname")
						   ->from('sa_order_product op')
						   ->join('shopsy_seller s', 's.id = op.store_id', 'left' )
						   ->where( array( 'op.order_id' => $order_id ) )
						   ->get()->result_array();

		$request  = 'METHOD=DoDirectPayment';
		$request .= '&VERSION=78';
		$request .= '&USER=' . 'sandbox_api1.shopsatavenue.net';
		$request .= '&PWD=' . 'KUXQMAYT6J6C5LEP';
		$request .= '&SIGNATURE=' . 'AFcWxV21C7fd0v3bYYYRCpSSRl31ATRGjhQHUjjomxSzOTtN-dHoguTH';
		$request .= '&CUSTREF=' . $order_id ;
		$request .= '&PAYMENTACTION=' . $payment_type;
		$request .= '&AMT=' . number_format( $order_total, 2, '.', '');
		//$request .= '&CREDITCARDTYPE=' . 'Visa';
		$request .= '&ACCT=' . urlencode(str_replace(' ', '', $card_number ));
		//$request .= '&CARDSTART=' . urlencode($this->request->post['cc_start_date_month'] . $this->request->post['cc_start_date_year']);
		$request .= '&EXPDATE=' . urlencode($exp_month . $exp_year);
		$request .= '&CVV2=' . urlencode($card_cvv);
		
		$request .= '&FIRSTNAME=' . urlencode( $data['payment_firstname']);
		//$request .= '&LASTNAME=' . urlencode('tester');
		$request .= '&EMAIL=' . urlencode( $this->input->post('ship_email') );
		$request .= '&PHONENUM=' . urlencode( $this->input->post('ship_phone') );
		$request .= '&IPADDRESS=' . urlencode( $_SERVER['REMOTE_ADDR'] );
		$request .= '&STREET=' . urlencode( $data['payment_address_1'] );
		$request .= '&CITY=' . urlencode( $data['payment_city'] );
		$request .= '&STATE=' . urlencode($data['payment_zone']);
		$request .= '&ZIP=' . urlencode( $data['payment_zone']);
		$request .= '&COUNTRYCODE=' . urlencode('US');
		$request .= '&CURRENCYCODE=' . urlencode('USD');
		
        /*if ($this->cart->hasShipping()) {
			$request .= '&SHIPTONAME=' . urlencode($order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname']);
			$request .= '&SHIPTOSTREET=' . urlencode($order_info['shipping_address_1']);
			$request .= '&SHIPTOCITY=' . urlencode($order_info['shipping_city']);
			$request .= '&SHIPTOSTATE=' . urlencode(($order_info['shipping_iso_code_2'] != 'US') ? $order_info['shipping_zone'] : $order_info['shipping_zone_code']);
			$request .= '&SHIPTOCOUNTRYCODE=' . urlencode($order_info['shipping_iso_code_2']);
			$request .= '&SHIPTOZIP=' . urlencode($order_info['shipping_postcode']);
        } else {
			$request .= '&SHIPTONAME=' . urlencode($order_info['payment_firstname'] . ' ' . $order_info['payment_lastname']);
			$request .= '&SHIPTOSTREET=' . urlencode($order_info['payment_address_1']);
			$request .= '&SHIPTOCITY=' . urlencode($order_info['payment_city']);
			$request .= '&SHIPTOSTATE=' . urlencode(($order_info['payment_iso_code_2'] != 'US') ? $order_info['payment_zone'] : $order_info['payment_zone_code']);
			$request .= '&SHIPTOCOUNTRYCODE=' . urlencode($order_info['payment_iso_code_2']);
			$request .= '&SHIPTOZIP=' . urlencode($order_info['payment_postcode']);			
		}*/		
		
		/*if (  $paypal_pro_payment_mode ) {
			$curl = curl_init('https://api-3t.paypal.com/nvp');
		} else {
			$curl = curl_init('https://api-3t.sandbox.paypal.com/nvp');
		}
		
		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

		$response = curl_exec($curl);

		curl_close($curl);
 
		if (! $response ) {
			file_put_contents( FCPATH."logs/checkout_log.txt", 'DoDirectPayment failed: ' . $order_id . " - "  . curl_error($curl) . '(' . curl_errno($curl) . ')'. "\r\n" , FILE_APPEND );
			$payment_status = false;
		} else {
			$response_info = array();
	 
			parse_str($response, $response_info);
			$json = array();
			
			if (($response_info['ACK'] == 'Success') || ($response_info['ACK'] == 'SuccessWithWarning')) {
				
				$payment_status = true;
				$message = '';
				
				if (isset($response_info['AVSCODE'])) {
					$message .= 'AVSCODE: ' . $response_info['AVSCODE'] . "\n";
				}
	
				if (isset($response_info['CVV2MATCH'])) {
					$message .= 'CVV2MATCH: ' . $response_info['CVV2MATCH'] . "\n";
				}
	
				if (isset($response_info['TRANSACTIONID'])) {
					$message .= 'TRANSACTIONID: ' . $response_info['TRANSACTIONID'] . "\n";
				}
				$data = array(
					'order_id' => $order_id,
					'transaction_id' => $response_info['TRANSACTIONID'],
					'pay_from' => 'paypal_pro',
					'amount_paid' => $response_info['AMT'] ,
					'date_modified' => date('Y-m-d H:i:s'),
					'date_created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('sa_order_payments', $data );
				$this->db->update('sa_order', array('order_status_id' => 1), array('order_id' => $order_id) );
				
				file_put_contents( FCPATH."logs/checkout_log.txt", $order_id . " - " . $message . "\r\n" , FILE_APPEND );
				file_put_contents( FCPATH."logs/checkout_log.txt", $order_id . " - " . print_r( $response_info, 1) . "\r\n" , FILE_APPEND );
			} else {
				file_put_contents( FCPATH."logs/checkout_log.txt", $order_id . " - Error - " . $response_info['L_LONGMESSAGE0']. "\r\n" , FILE_APPEND );
				$payment_status = false;
			}
		}
		if( $payment_status ) {
			//Store Notification
			foreach( $stores as $key => $store ) {
				$this->load->library('email');
				
				$body = "Hi " . $store['seller_businessname'] . "\r\n";
				$body .= "Congrats! You received a new order #" . $store['store_order_id'];
				$this->email->from('admin@shopsatavenue.net', 'Admin');
				$this->email->to($store['seller_email']);
				//$this->email->cc('another@another-example.com');
				//$this->email->bcc('them@their-example.com');
				
				$this->email->subject('Order notification!');
				$this->email->message($body);
	
				$this->email->send();
			}
			
			redirect('site/checkout/order_thanks/'. $order_id);
		} else {
			redirect('site/checkout/pay_failed/'. $order_id);
		}
	}*/

	public function pay_failed( $order_id = 0 ) {
		$this->data['order_id'] = $order_id;
	    $this->load->view('site/checkout/order_pay_failed.php',$this->data);
	}
	
	public function order_thanks( $order_id = 0 ) {
		$this->data['order_id'] = $order_id;
	    $this->load->view('site/checkout/order_thanks.php',$this->data);
	}
	
	

	
}

/* End of file checkout.php */
/* Location: ./application/controllers/site/checkout.php */