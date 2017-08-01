<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(-1);
/**
 * 
 * User related functions
 * @author Casperon
 *
 */

class Product_import extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email','text'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->library("session");
		$this->load->model(array("import_model",'seller_model','multilanguage_model'));
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['AdminloginCheck'] = $this->checkLogin('A');
    }   
	
	/**
	* 
	* Load the options to import items
	* 
	**/
	public function upload_form(){
		if ($this->checkLogin('U')==''){
    		redirect('login');
    	}else {
    		$this->data['heading'] = 'Import Items';
    		$this->load->view('site/import/import_list',$this->data);
    	}
	}
	
	function upload_csv_form() {
		if ( $this->checkLogin('U') == '' ) { redirect('login'); return; }

		$this->data['heading'] = 'Upload CSV Files';
		$this->load->view('site/import/upload_csv',$this->data);

	}
	function csv_product_import() {
		$json = array();
		
		if ( $this->checkLogin('U') == '' ) { 
			$json = array( 'status' => 'error', 'message' => 'Not logged in!' );
			echo json_encode( $json );
			return; 
		}

		$user_id = $this->checkLogin('U');
		$shop_qry = $this->db->select('id')->from('shopsy_seller')->where( array('seller_id' => $user_id ) )->get();
		if( ! $shop_qry->num_rows() ) {
			echo json_encode( $json = array( 'status' => "error" , 'message' => 'Invalid Shop' ) );
			exit(0);
		}
		$shop_id = $shop_qry->first_row()->id;
		
		if ( isset( $_FILES['csv_file'] ) ) {
			$target_dir = FCPATH . "uploads/csvimport/";
			$target_file = $target_dir . basename($_FILES["csv_file"]["name"]);

			$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
			$check = filesize($_FILES["csv_file"]["tmp_name"]);
			if($check !== false) {
				 move_uploaded_file( $_FILES['csv_file']['tmp_name'], $target_file );
			} else {
				$json = array( 'status' => 'error', 'message' => 'File upload error! try after some time!' );
				echo json_encode( $json );
				return; 
			}

			$handle = fopen( $target_file, "r");
			$csv_row = fgetcsv($handle, 10000, ",");
			if( $csv_row === FALSE || empty($csv_row) || count($csv_row) != 39 ) {
				$json = array( 'status' => 'error', 'message' => 'CSV File error OR Invalid file format!' );
				echo json_encode( $json );
				return;
			}
			try {
				$row_count = 0;
				$csv_continue = true;
				$item_id = '';
				$read_main_rec = true;
				while( $csv_continue ) { //Loop thru CSV FILE

					if( $read_main_rec ) { //Already read Product Record when reading variant records
						$csv_row = fgetcsv($handle, 10000, ",");
						$row_count++;
					}

					$variant_rec = false;
					$status = true;
					$color = false;
					$size = false;
					$variant1 = $variant2 = $variant3 = false;

					$data = array();
					$data['store_id'] = $shop_id;
					$data['user_id']  = $user_id;
					$data['created'] = date('Y-m-d H:i:s');
					$data['modified'] = date('Y-m-d H:i:s');
					
					//Product ID
					$item_id = $csv_row[0];
					//Variant indicator 
					if( $csv_row[1] == '' ) {
						$variant_rec = true;
					}
					
					//title
					if( isset($csv_row[2]) && $csv_row[2] != '' ) {
						$data['product_name'] = $csv_row[2];
					} else {
						$status = false;
					}
					//Description
					if( isset($csv_row[3]) && $csv_row[3] != '' ) {
						$data['description'] = $csv_row[3];
					} else {
						$status = false;
					}
					//Quantity
					$qty = (int) $csv_row[4];
					
					//Category
					$category = $csv_row[5];
					//Price
					$data['price'] = (float) $csv_row[6];
					//MSRP
					$data['msrp'] = (float) $csv_row[7];
					
					//Max Product Discount 
					//$data['max_product_discount'] = $csv_row[8];
					//Max discount locked
					//$data['max_discount_locked'] = $csv_row[9];
					$data['variable_product'] = 0;
					//color?
					if( strtolower($csv_row[10]) == 'yes' ) { $color = true; $data['variable_product'] = 1; }
					//size?
					if( strtolower($csv_row[11]) == 'yes' ) { $size = true; $data['variable_product'] = 1; }
					//custom attributes?
					if( trim($csv_row[12]) != '' ) { $variant1 = true;$data['variable_product'] = 1; }
					if( trim($csv_row[13]) != '' ) { $variant2 = true;$data['variable_product'] = 1; }
					if( trim($csv_row[14]) != '' ) { $variant3 = true;$data['variable_product'] = 1; }
					
					if( $data['variable_product'] == 0 ) $read_main_rec = true;  //Read next product row in next cycle

					//Shipping Cost
					$shipping = array();
					$shipping['CUS'] = array( 'ship_price' => (float) $csv_row[15], 'next_item_price' => (float) $csv_row[16] );
					$shipping['AHW'] = array( 'ship_price' => (float) $csv_row[17], 'next_item_price' => (float) $csv_row[18] );
					$shipping['PUR'] = array( 'ship_price' => (float) $csv_row[19], 'next_item_price' => (float) $csv_row[20] );
					
					$data['ship_days'] = (int) $csv_row[21];
					$data['sold_exclusive'] = strtolower($csv_row[22]) == 'yes' ? 1 : 0;
					//$data['made_to_order'] = strtolower( $csv_row[23]) == 'yes' ? 1 : 0;
					$data['upc'] = $csv_row[24];
					$data['part_number'] = $csv_row[25];
					$data['shopify_url'] = $csv_row[26];
					//$data['brand'] = $csv_row[27];
					$data['image'] = '';
					if( $csv_row[28] == '' ) { $status = false; }
					if( $csv_row[28] != '' ) $data['image'] =  ( $data['image'] != '' ? ',' : '' ) . $csv_row[28];
					if( $csv_row[29] != '' ) $data['image'] =  ( $data['image'] != '' ? ',' : '' ) . $csv_row[29];
					if( $csv_row[30] != '' ) $data['image'] =  ( $data['image'] != '' ? ',' : '' ) . $csv_row[30];
					if( $csv_row[31] != '' ) $data['image'] =  ( $data['image'] != '' ? ',' : '' ) . $csv_row[31];
					if( $csv_row[32] != '' ) $data['image'] =  ( $data['image'] != '' ? ',' : '' ) . $csv_row[32];
					$data['video_url'] = $csv_row[33];
					$data['weight'] = (float) $csv_row[34];
					$data['ship_length'] = (float) $csv_row[35];
					$data['ship_width'] = (float) $csv_row[36];
					$data['ship_height'] = (float) $csv_row[37];
					$data['seourl'] = url_title($csv_row[2], '-', TRUE);
					//$data['status'] => ( $status ? 'Publish' : 'Draft' ),
					
					//$this->db->insert('shopsy_product_test', $data );
					$this->db->insert('shopsy_product', $data );
					$product_id =  $this->db->insert_id();
					
					if( $csv_row[28] != '' ) {
						$image_path = FCPATH."images/product/" . $product_id;
						if ( ! file_exists($image_path)) {
							@mkdir($image_path, 0777, true);
						}
						$file_name = $product_id . "_" . $j . ".jpg";
						$this->grab_image( $csv_row[28], $image_path."/".$file_name ); 
						//generate additional images
						@mkdir($image_path.'/mb', 0777, true);
						@mkdir($image_path.'/mb/thumb', 0777, true);
						@mkdir($image_path.'/mb/crop', 0777, true);
						@mkdir($image_path.'/thumb', 0777, true);
						@mkdir($image_path.'/list-image', 0777, true);
						@mkdir($image_path.'/cropsmall', 0777, true);
						@mkdir($image_path.'/cropmed', 0777, true);
						@mkdir($image_path.'/cropthumb', 0777, true);
						
						//@copy( $image_path."/".$file_name, $image_path.'/mb/'.$file_name );
						//$this->ImageCompress($image_path.'/mb/'.$file_name);
							
						@copy( $image_path."/".$file_name,  $image_path . '/mb/thumb/' . $file_name );
						//$this->ImageResizeWithCrop(350, '', $file_name, './images/product/'. $product_id.'/mb/thumb/');
						$this->ImageResizeWithCrop(350, '', $file_name, $image_path.'/mb/thumb/');
								
						@copy($image_path."/".$file_name, $image_path . '/mb/crop/'. $file_name);
						$this->ImageResizeWithCropping(350, 350, $file_name, $image_path. '/mb/crop/');
							
							
						@copy($image_path."/".$file_name, $image_path . '/thumb/'.$file_name);
						$this->ImageResizeWithCrop(175, '', $file_name, $image_path . '/thumb/');
							
						@copy($image_path."/".$file_name, $image_path . '/list-image/'. $file_name);
						$this->ImageResizeWithCrop(75, '', $file_name, $image_path .'/list-image/');
							
						@copy($image_path."/".$file_name, $image_path .'/cropsmall/'.$file_name);
						$this->ImageResizeWithCropping(108, 92, $file_name, $image_path .'/cropsmall/');
							
						@copy($image_path."/".$file_name, $image_path .'/cropmed/'.$file_name);
						$this->ImageResizeWithCropping(285, 215, $file_name, $image_path . '/cropmed/');
							
						@copy($image_path."/".$file_name, $image_path.'/cropthumb/'.$file_name);
						$this->ImageResizeWithCropping(75, 75, $file_name, $image_path . '/cropthumb/');
	
						$j++;
					}
					//$this->db->update('shopsy_product', array( 'image' => $image ), array( 'id' => $product_id ) );

					if( $shipping && $product_id ) {
						$ship_data = array( 
							'product_id' => $product_id, 
							'code' => 'CUS',
							'description' => 'Continental United States', 
							'ship_price' => (float)$shipping['CUS']['ship_price'] ,
							'next_item_price' => (float)$shipping['CUS']['next_item_price'] ,
						);
						//$this->db->insert('shopsy_product_shipping_test', $ship_data );
						$this->db->insert('shopsy_product_shipping', $ship_data );
						
						$ship_data = array( 
							'product_id' => $product_id, 
							'code' => 'AHW',
							'description' => 'Alaska and Hawaii', 
							'ship_price' => (float)$shipping['AHW']['ship_price'] ,
							'next_item_price' => (float)$shipping['AHW']['next_item_price'] ,
						);
						$this->db->insert('shopsy_product_shipping', $ship_data );
						
						$ship_data = array( 
							'product_id' => $product_id, 
							'code' => 'PUR',
							'description' => 'Puerto Rico', 
							'ship_price' => (float)$shipping['PUR']['ship_price'] ,
							'next_item_price' => (float)$shipping['PUR']['next_item_price'] ,
						);
						$this->db->insert('shopsy_product_shipping', $ship_data );
						
					}
					
					if ( ! $data['variable_product'] ) { $read_main_rec = true; continue; } 
					
					//Read Variant Records
					if( $data['variable_product'] ) {
						$read_variant_recs = true;
						$options = array();
						$product_option_id = array();
						$option_values =  array();
						$i = 1;
						if( $color ) { 
							$data = array(
								'product_id' => $product_id,
								'option_type_id' => 2,
								'product_option_name' => 'Color',
								'option_seq_id' => $i 
							);
							$this->db->insert('shopsy_product_options', $data );
							$product_option_id['color'] = $this->db->insert_id();
							$options[] = 'Color';
							$i++;
						}
						if( $size ) { 
							$data = array(
								'product_id' => $product_id,
								'option_type_id' => 3,
								'product_option_name' => 'Size',
								'option_seq_id' => $i
							);
							$this->db->insert('shopsy_product_options', $data );
							$product_option_id['size'] = $this->db->insert_id();
							$options[] = 'Size';
							$i++;
						}
						if( $variant1 ) {
							$data = array(
								'product_id' => $product_id,
								'option_type_id' => 4,
								'product_option_name' => $csv_row[12],
								'option_seq_id' => $i
							);
							$this->db->insert('shopsy_product_options', $data );
							$product_option_id['var1'] = $this->db->insert_id();
							$options[] = $csv_row[12];
							$i++;
						}
						if( $variant2 ) {
							$data = array(
								'product_id' => $product_id,
								'option_type_id' => 4,
								'product_option_name' => $csv_row[13],
								'option_seq_id' => $i
							);
							$this->db->insert('shopsy_product_options', $data );
							$product_option_id['var2'] = $this->db->insert_id();
							$options[] = $csv_row[13];
							$i++;
						}
						if( $variant3 ) {
							$data = array(
								'product_id' => $product_id,
								'option_type_id' => 4,
								'product_option_name' => $csv_row[14],
								'option_seq_id' => $i
							);
							$this->db->insert('shopsy_product_options', $data );
							$options[] = $csv_row[14];
							$product_option_id['var3'] = $this->db->insert_id();
							$i++;
						}
						
						$option_values['color'] = array();
						$option_values['size'] = array();
						$option_values['var1'] = array();
						$option_values['var2'] = array();
						$option_values['var3'] = array();


						while ( $read_variant_recs ) {
							$csv_row = fgetcsv($handle, 10000, ",");
							if ( empty( $csv_row ) ) { $csv_continue = false; $read_variant_recs = false; }
							if( isset($csv_row[1]) && $csv_row[1] == $item_id ) {
								$qty += (int) $csv_row[4];

								//insert values for option
								$j=1;
								if( $color && ! in_array( $csv_row[10], $option_values['color'] ) ) {
									$opt_data = array(
										'product_option_id' => $product_option_id['color'],
										'product_id' => $product_id,
										'option_value' => $csv_row[10],
										'option_seq_id' =>  $j,
										'user_id' => $user_id,
										'date_created' => date('Y-m-d H:i:s'),
										'date_modified' => date('Y-m-d H:i:s')
									);
									$j++;
									$option_values['color'][] = $csv_row[10];
									$this->db->insert('shopsy_product_option_values', $opt_data );
								}
								if( $size && ! in_array( $csv_row[11], $option_values['size'] ) ) {
									$opt_data = array(
										'product_option_id' => $product_option_id['size'],
										'product_id' => $product_id,
										'option_value' => $csv_row[11],
										'option_seq_id' =>  $j,
										'user_id' => $user_id,
										'date_created' => date('Y-m-d H:i:s'),
										'date_modified' => date('Y-m-d H:i:s')
									);
									$j++;
									$option_values['size'][] = $csv_row[11];
									$this->db->insert('shopsy_product_option_values', $opt_data );
								}
								if( $variant1 && ! in_array( $csv_row[12], $option_values['var1'] ) ) {
									$opt_data = array(
										'product_option_id' => $product_option_id['var1'],
										'product_id' => $product_id,
										'option_value' => $csv_row[12],
										'option_seq_id' =>  $j,
										'user_id' => $user_id,
										'date_created' => date('Y-m-d H:i:s'),
										'date_modified' => date('Y-m-d H:i:s')
									);
									$j++;
									$option_values['var1'][] = $csv_row[12];
									$this->db->insert('shopsy_product_option_values', $opt_data );
								}
								if( $variant2 && ! in_array( $csv_row[13], $option_values['var2'] ) ) {
									$opt_data = array(
										'product_option_id' => $product_option_id['var2'],
										'product_id' => $product_id,
										'option_value' => $csv_row[13],
										'option_seq_id' =>  $j,
										'user_id' => $user_id,
										'date_created' => date('Y-m-d H:i:s'),
										'date_modified' => date('Y-m-d H:i:s')
									);
									$j++;
									$option_values['var2'][] = $csv_row[13];
									$this->db->insert('shopsy_product_option_values', $opt_data );
								}
								if( $variant3 && ! in_array( $csv_row[14], $option_values['var3'] ) ) {
									$opt_data = array(
										'product_option_id' => $product_option_id['var3'],
										'product_id' => $product_id,
										'option_value' => $csv_row[14],
										'option_seq_id' =>  $j,
										'user_id' => $user_id,
										'date_created' => date('Y-m-d H:i:s'),
										'date_modified' => date('Y-m-d H:i:s')
									);
									$j++;
									$option_values['var3'][] = $csv_row[14];
									$this->db->insert('shopsy_product_option_values', $opt_data );
								}

								/*$data = array(
									'product_option_id' => $product_option_id,
									'product_id' => $product_id,
									'option_value' => $product->options[$i]->values[$j],
									'option_seq_id' => ( $j + 1),
									'user_id' => 1,
									'date_created' => date('Y-m-d H:i:s'),
									'date_modified' => date('Y-m-d H:i:s')
								);
								$this->db->insert('shopsy_product_option_values', $data );
								$product_option_value_id = $this->db->insert_id();
								$option_values[ $i ][] = $product->options[$i]->values[$j];*/

								$var_data = array(
								   'product_id' => $product_id,
								   'option1' => $csv_row[10],
								   'option2' => $csv_row[11],
								   'option3' => $csv_row[12],
								   'option4' => $csv_row[13],
								   'option5' => $csv_row[14],
								   'quantity' => $csv_row[4],
								   'price' => $csv_row[6],
								   'msrp' => (float) $csv_row[7],
								   'sku' => $csv_row[24],
								   'upc' => $csv_row[24],
								   'date_created' => date('Y-m-d H:i:s')
								);
								$this->db->insert('shopsy_product_variation' , $var_data);
								
							} else {
								$read_variant_recs = false;
								$read_main_rec = false;
							}
						} // end while
					}
					
					
					//$csv_continue = false;
				}

			} catch(Exception $e) {
  				echo json_encode( $json = array( 'status' => "error" , 'message' => $e->getMessage() ) );
				return;
			}

			fclose( $handle );
			$data = array(
						'file_name' => basename( $target_file ),
						'user_name' => $user_id,
						'import_time' => time(),
						'shop_id' => $shop_id,
						'date_added' => date('Y-m-d')
					);
			$this->db->insert('saa_csv_import_history', $data);
			
			$json = array( 'status' => 'success', 'message' => 'Imported successfully' );
			echo json_encode( $json );
			return;

		}
		
		$json = array( 'status' => 'error', 'message' => 'unknown error!' );
		echo json_encode( $json );
		
	}
	
	public function shopify_import() {
		$shop_qry = $this->db->select('id')->from('shopsy_seller')->where( array('seller_id' => $this->checkLogin('U') ) )
							->get();
		$shop_id = 0;
		if( $shop_qry->num_rows() ) {
			$shop_id  = $shop_qry->first_row()->id; 
		}
		if ( $shop_id == 0 ) {
			echo "invalid shop";
			exit(0);
		}
		$update = false;
		$shopify_qry = $this->db->select('*')->from('sa_sales_channels')->where( array('channel_name' => 'shopify', 'shop_id' => $shop_id) )->get();
		if( $shopify_qry->num_rows ) {
			$this->data['heading'] = 'Import Products form Shopify';
			$this->data['shopify'] = $shopify_qry->first_row();
			$update = true;
		}
		
		if ( $this->input->post('btn-save-shopify') == 'save' ) {
			$channel_id = (int) $this->input->post('channel_id');
			$data = array(
				'api_endpoint' => $this->input->post('api_endpoint'),
				'api_user' => $this->input->post('api_key'),
				'api_password' => $this->input->post('api_password'),
			);
			if( $update ) {
				$this->db->update('sa_sales_channels', $data, array('channel_id' => $channel_id ) );
			} else {
				$data['shop_id'] = $shop_id;
				$data['channel_name'] = 'shopify';
				$this->db->insert('sa_sales_channels', $data);
			}

		}

   		$this->load->view('site/import/shopify_import',$this->data);
	}

	function grab_image($url,$saveto){

		$ch = curl_init ($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$raw=curl_exec($ch);
		curl_close ($ch);

		if(file_exists($saveto)){
			unlink($saveto);
		}

		$fp = fopen($saveto,'x');
		fwrite($fp, $raw);
		fclose($fp);
	}	
		
}
/*End of file product_import.php */
/* Location: ./application/controllers/site/product_import.php */
