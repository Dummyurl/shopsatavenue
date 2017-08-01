<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('RANDOM_CHARS', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
define('RANDOM_PASS_LENGTH', 10);

class Product extends API_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('product_model');
		
    }

	/**
	* Insert Product
	*
	*
	* @authorize(admin)
	*
	*
	* @param object $data (see below)
	*	{
	*		"product_parameter1":string				// required 
	*		"product_parameter2":string				// required 
	*		"product_parameter3":string 				// required 
	*		"product_parameter4":string				// required 
	*	}
	*
	* @return object
	*	{
	*		"save":true	or false		//product
	*	}
	*/
	public function post_index($data)
	{	
		$productinfo_sku = $this->product_model->sku_exists($data);
		//print_r($productinfo_sku); exit();
		if($productinfo_sku == "no")
			throw new Exception("This SKU is already exist.");

		if(empty($data->product_name) || empty($data->category) || empty($data->description) || empty($data->sku) || empty($data->upc) || empty($data->price) || empty($data->shipping_cost))

			throw new Exception("All Fields are required.");

		$postproduct = $this->product_model->post_product($data);


		//print_r($post_product);
		return array("message" => "Your Product is added Successfully .");
	}

	/**
	* Product Listing
	*
	* @authorize(admin)
	*
	*
	* @return object
	*	{
	*		list of Product
	*	}
	*/
	public function get_all()
	{
		
		$product_list = $this->product_model->all_product();	
		return 	$product_list;	
	}

	/**
	* Get Product Detail
	* @authorize(admin)
	*
	* @param object $data (see below)
	*	{
	*		"product_id":integer			//id of property
	*	}
	*
	* @return object
	*	{
	*		product Detail
	*	}
	*/
	public function get_index($product_id)
	{
		if(!empty($product_id)||$product_id!=""){
		$product_detail = $this->product_model->getProductById($product_id);
		//print_r($product_detail);
		return $product_detail;
		}
		else{
			return array("message" => "This ID doesn't exists.");
		}
	}

	public function get_productbySKU($product_sku)
	{
		if(!empty($product_sku)||$product_sku!=""){
		$product_detail = $this->product_model->getProductBySKU($product_sku);

		return $product_detail;
		}
		
		else{
			return array("message" => "This SKU doesn't exists.");
		}
	}




		/**
	* Edit product details
	*
	*
	* @authorize(admin)
	*
	*
	* @param object $data (see below)
	*	{
	*		"product_id":integer						//id of product not editable	
	*		"product_parameter1":string				// required 
	*		"product_parameter2":string				// required 
	*		"product_parameter3":string 				// required 
	*		"product_parameter4":string				// required 
	*	}
	*
	* @return object
	*	{
	*		"product":true	or false							
	*	}
	*/
	
	public function put_index($data)
	{	
		//data validation
		if(empty($data->product_name)|| empty($data->category) || empty($data->upc)|| empty($data->price)||empty($data->shipping_cost))
			throw new Exception("Product Name,category,SKU ,UPC, Price & Shipping cost fields are required.");

		$update_product = $this->product_model->update_product($data);
		if($update_product=="true")	{
		return array("message" => "Your Product Details Updated Successfully.");
		}
		else{
			return array("message" => "This Product Does not exist.");
		}
	}
	
	public function put_product_by_sku($data)
	{	
		//data validation
		if(empty($data->product_name)|| empty($data->category) || empty($data->upc)|| empty($data->price)||empty($data->shipping_cost))
			throw new Exception("Product Name,category,SKU ,UPC, Price & Shipping cost fields are required.");

		$update_product = $this->product_model->update_product_by_sku($data);
		if($update_product=="true")	{
		return array("message" => "Your Product Details Updated Successfully.");
		}
		else{
			return array("message" => "This SKU Does not exist.");
		}
	}

		public function delete_index($product_id)
	{
		
		$product_delete = $this->product_model->delete_product($product_id);
		
		if($product_delete=="true")	{
		return array("message" => "Product Deleted Successfully.");
		}
		else{
			return array("message" => "This Product Does not exist.");
		}
		
	}
		public function delete_product_by_sku($product_sku)
	{
		
		$product_delete = $this->product_model->delete_product_by_sku($product_sku);
		
		if($product_delete=="true")	{
		return array("message" => "Product Deleted Successfully.");
		}
		else{
			return array("message" => "This Product Does not exist.");
		}
		
	}
}
?>