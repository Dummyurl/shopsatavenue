<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(-1);
/*
 *
 * This model contains all db functions related to support team
 * @author casperon
 *
 */
class Support_model extends My_Model
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	// Create Ticket
	function create_ticket( $data = array() ) {
		
		$this->db->insert('saa_merchant_queries', $data );
		return $this->db->insert_id();
	}
	
}	