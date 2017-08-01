<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//error_reporting(-1);
/**
 * 
 * Offer related functions
 * @author 
 *
 */

class Support extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model(array('support_model'));

		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['AdminloginCheck'] = $this->checkLogin('A');
    }
	
	
	// FUNCTION TO CREATE TICKET
	public function createTicket(){
		$user_id = $this->checkLogin('U');
		if ( $user_id == ''){
			redirect('login');
			return;
		}
		
		$json = array();
		$merchant_name = $this->input->post('merchant_name');
		$merchant_email = $this->input->post('merchant_email');
		$subject = $this->input->post('subject');
		$email_body = $this->input->post('email_body');
		$query_order_no = $this->input->post('query_order_no');

		//Server side validation
		/*$this->form_validation->set_rules('merchant_name', 'Merchant name', 'required');
		$this->form_validation->set_rules('merchant_email', 'Merchant email address', 'required');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('email_body', 'email body', 'required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == FALSE){
			$json = array( 'status' => 'error', 'message' => 'error ' );
		}*/
		
		$isValid = true;
		$message = '';
		if ( $merchant_name == '' ) {
			$isValid = false;
		}
		if( $merchant_email == '' ) {
			$isValid = false;
		}
		if( $subject == '' ) {
			$isValid = false;
		}
		if( $email_body == '' ) {
			$isValid = false;
		}
		if( ! $isValid ) {
			$json = array( 'status' => 'error', 'message' => "Required field(s) are empty!" );
		} else {
			$data = array(
						'user_id' => $user_id,
						'merchant_name' => $merchant_name,
						'merchant_email' => $merchant_email,
						'subject' => $subject,
						'email_body' => $email_body,
						'order_number' => $query_order_no,
						'date_added' => date('Y-m-d H:i:s')
					);
			$ticket_no = $this->support_model->create_ticket( $data );
			if( $ticket_no > 0 ) {
				$json = array( 'status' => 'success', 'message' => 'Ticket Created successfully!', 'ticket_no' => $ticket_no );
			} else {
				$json = array( 'status' => 'error', 'message' => 'Promblem creating ticket. Try after sometime!' );
			}
		}
		
		echo json_encode( $json );
	}
	
	
}