<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends API_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function post_product($data)
	{
		
		
		$productinfo = ORM::for_table('rkl_product')->create();
		$productinfo->product_name=$data->product_name;
		$productinfo->category=$data->category;
		$productinfo->description=$data->description;
		$sku_prdt = $productinfo->sku;
		$productinfo->sku=$data->sku;
		$productinfo->upc=$data->upc;
		$productinfo->price=$data->price;
		$productinfo->shipping_cost=$data->shipping_cost;
		$productinfo->save();
		
		return true;
		
	
	}

	public function sku_exists($data){

		$productinfo_sku = ORM::for_table('rkl_product')->create();
		$productinfo_sku->sku=$data->sku;
		$sku = $productinfo_sku->sku;
		
		$all_product = ORM::for_table('rkl_product')
		->use_id_column('sku')->find_one($sku);
		
		if(empty($all_product)){
		return 'yes';}
		else{
			return 'no' ;
		}
	}

	public function all_product()
	{
		
		$all_product = ORM::for_table('rkl_product')
		->find_many();

		$productArray=array();
		foreach ($all_product as $product)
		{
			array_push($productArray, $product->as_array());
		}

		return $productArray;

	}

	public function getProductById($product_id)
	{
		$product_detail = ORM::for_table('rkl_product')
			->where('rkl_product.ID', $product_id)
			->find_many();
		
		$productArray=array();
		foreach ($product_detail as $product)
		{
			array_push($productArray, $product->as_array());
		}

		return $productArray;
	}

	public function getProductBySKU($product_sku)
	{
		$product_detail = ORM::for_table('rkl_product')
			->where('rkl_product.sku', $product_sku)
			->find_many();
		
		$productArray=array();
		foreach ($product_detail as $product)
		{
			array_push($productArray, $product->as_array());
		}

		return $productArray;
	}

	public function update_product($data)
	{

	$update_product =ORM::for_table('rkl_product')->use_id_column('ID')->where('ID', $data->ID)->find_one();


		if($update_product)
		{
			$update_product->product_name=$data->product_name;
			$update_product->price=$data->price;
			$update_product->category=$data->category;
			$update_product->description=$data->description;
			$update_product->upc=$data->upc;
			$update_product->shipping_cost=$data->shipping_cost;
		
			$update_product->save();
			return true;
		}
		else{
    			return false;
    		}
		
		
	
	}

	public function update_product_by_sku($data)
	{

	$update_product =ORM::for_table('rkl_product')->use_id_column('ID')->where('sku', $data->sku)->find_one();


		if($update_product)
		{
			$update_product->product_name=$data->product_name;
			$update_product->price=$data->price;
			$update_product->category=$data->category;
			$update_product->description=$data->description;
			$update_product->upc=$data->upc;
			$update_product->shipping_cost=$data->shipping_cost;
		
			$update_product->save();
			return true;
		}
		else{
    			return false;
    		}
		
		
	
	}

		public function delete_product($product_id)
	{

		$delete_product= ORM::for_table('rkl_product')->use_id_column('ID')->find_one($product_id);

    		if($delete_product){
    			$delete_product->delete();
    			return true;
    		}
    		else{
    			return false;
    		}
    		
	}

		public function delete_product_by_sku($product_sku)
	{

		$delete_product= ORM::for_table('rkl_product')->use_id_column('sku')->find_one($product_sku);

    		if($delete_product){
    			$delete_product->delete();
    			return true;
    		}
    		else{
    			return false;
    		}
    		
	}

}
