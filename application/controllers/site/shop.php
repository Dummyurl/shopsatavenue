<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * 
 * Shop related functions
 * @author Teamtweaks
 *
 */

class Shop extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model(array('product_model','seller_model','user_model','order_model','commission_model','support_model'));

		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['AdminloginCheck'] = $this->checkLogin('A');
		$this->data['likedProducts'] = array();
	 	if ( $this->data['loginCheck'] != '' ) {
	 		//$this->data['likedProducts'] = $this->shop->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
	 	}
		
		$SSeller_details=$this->seller_model->get_all_details(SELLER,array('seller_id'=>$this->checkLogin('U')));				
		$this->data['currentshopurl'] = $SSeller_details->row()->seourl;
		
    }

	/*
	* 
	* Loading the shop page
	* 
	*/
	public function index(){
		$this->data['heading'] = 'Shop';
		$this->data['bannerList'] = $this->shop->get_all_details(BANNER_CATEGORY,array('status'=>'Publish'));
		$this->data['recentProducts'] = $this->shop->view_product_details(" where p.status='Publish' and p.quantity > 0 and u.group='Seller' and u.status='Active' or p.status='Publish' and p.quantity > 0 and p.user_id=0 order by p.created desc limit 4");
		$this->load->view('site/shop/display_shop_list',$this->data);
    }
	
	/** 
	*** Promotions
	***
	**/
	public function promotions( $promotion_period = 'current'  ) {

		//Check Login
		if ( $this->checkLogin('U') == ''  ){
			$this->data['message'] = '<h1>You need to login first!</h1><br><a href="login"><button class="btn btn-block btn-primary">Login</button></a>';
			$this->load->view('site/shop/shop_message',$this->data);
			exit(0);
		}
		if ( $promotion_period == 'current' ) {
			$this->data['promotions'] = $this->product_model->getPromotionsCount( true );
			$this->data['promo_list'] = 'Current';
		} else {
			$this->data['promotions'] = $this->product_model->getPromotionsCount( false );
			$this->data['promo_list'] = 'Past';
		}
		$this->load->view('site/shop/manage_promotions',$this->data);
		exit(0);
	}
	
	/****
	*****  Create Product promotion
	*****
	*****/	
	public function create_promotion( $action=NULL, $product = NULL) {

		//Check Login
		if ( $this->checkLogin('U') == ''  ){
			$this->data['message'] = '<h1>You need to login first!</h1><br><a href="admin"><button class="btn-primary">Login</button></a>';
			$this->load->view('site/shop/shop_message',$this->data);
			exit(0);
		}
		
		if( $product != '' ) 
		   $promo_type = 'product';
		else
		   $promo_type = 'store';
		
		if ( $this->checkLogin('A') != ''){
			$user_id = $this->session->userdata['shopsy_session_admin_id'];
		} elseif ($this->checkLogin('U') != '' ) {
			$user_id = $this->session->userdata['shopsy_session_user_id'];
		}

		//Update Promotion
		if( $this->input->post('submit') != '' &&  $this->input->post('submit') == 'Save_Promotion'  ) {

			$promotion_id  = $this->input->post('promotion_id');
			$date = $this->input->post('promotion_date');
			$promotion_date = substr($date, 6, 4) . "-" . substr($date, 0, 2) . "-" .  substr($date, 3, 2);

			$product_id = $this->input->post('product_id');
			$discount = $this->input->post('discount') ;
			$promotion_date = $promotion_date ;
			$duration = $this->input->post('duration');
			$allow_credit = $this->input->post('allow_credit') == '' ? 0 : 1 ;
			$free_shipping = $this->input->post('free_shipping')  == '' ? 0 : 1 ;

			$error = array();
			if ( $this->input->post('promotion_date') == '' ) {
				$error['promotion_date'] = 'Enter valid date';
			}
			
			$product_id = '';
			if( $promo_type == 'product' && $action = 'edit' ) {
				$product_id = $this->product_model->getProductID($product);
				if( $product_id == '' ) {
					$error['product_id'] = "Invalid product!";
				}
			}
			
			if ( $error ) {
				$this->data['error'] = $error;
				$this->setErrorMessage('error','Please correct the error(s) and goto next step');
				$this->load->view('site/shop/product_promotion',$this->data);
				//$this->data['product_id'] = $this->input->post('product_id');
				$this->data['discount'] = $this->input->post('discount') ;
				$this->data['promotion_date'] = $promotion_date ;
				$this->data['allow_credit'] = $this->input->post('allow_credit') == '' ? 0 : 1 ;
				$this->data['free_shipping'] = $this->input->post('free_shipping')  == '' ? 0 : 1 ;

				exit(0);
			}
			$shop_id = $this->db->query( "SELECT id FROM shopsy_seller WHERE seller_id = " . $this->session->userdata('shopsy_session_user_id') )->row(0)->id;
		    switch ( $duration ){
			   case "12H" :
					$strDuration = "+ 12 Hours";
					break;
			   case "24H" :
					$strDuration = "+ 24 Hours";
					break;
			   case "48H" :
					$strDuration = "+ 48 Hours";
					break;
			   case "7D" :
					$strDuration = "+ 7 Days";
					break;
			   case "2W" :
					$strDuration = "+ 2 Weeks";
					break;
			   case "1M" :
					$strDuration = "+ 1 Month";
					break;
			   case "1Y" :
					$strDuration = "+ 1 Year";
					break;
				default:
		    }			
			
			$condition = array( 'product_id' => $product_id, 'promotion_id' => $promotion_id );
			$dataArr = array(
						//'product_id' => $product_id,
						//'promotion_type'  => 'product',
						'discount_percent' => $discount,
						'duration'			=> $duration,
						'start_date'        => date('Y-m-d H:i:s', strtotime($promotion_date)),
						'end_date'          => date( 'Y-m-d', strtotime( $promotion_date . $strDuration ) ),
						'free_shipping'     => $free_shipping,
						'allow_credit'		=> $allow_credit,
						'status'			=> '1'
					);
			if( $promo_type == 'product'  ) {
			   if ( $action = 'edit' ) {
					$condition['promotion_type'] = 'product';
					$dataArr['date_updated'] = date('Y-m-d H:i:s');
					
					$this->db->update( 'saa_shop_promotions', $dataArr, $condition );
					$this->setErrorMessage('success','Promotion saved successfully!');
				
				} else {
					$dataArr['shop_id']	=  $shop_id;
					$dataArr['user_id']	= $user_id;
					$dataArr['product_id'] = $product_id;
					$dataArr['promotion_type'] = 'product';
					$dataArr['date_created'] = date('Y-m-d H:i:s');
					$dataArr['date_updated'] = date('Y-m-d H:i:s');
					$this->db->insert( 'saa_shop_promotions', $dataArr, $condition );
					$this->setErrorMessage('success','Promotion saved successfully!');
				}
			}
			
			if( $promo_type == 'store' ) {

				if( $promotion_id != '' ) {
					$condition['promotion_type'] = 'store';
					$dataArr['date_updated'] = date('Y-m-d H:i:s');
					
					$this->db->update( 'saa_shop_promotions', $dataArr, $condition );
					$this->setErrorMessage('success','Promotion saved successfully!');
				} else {
					$dataArr['promotion_type'] = 'store';
					$dataArr['shop_id']	=  $shop_id;
					$dataArr['user_id']	= $user_id;
					$dataArr['date_created'] = date('Y-m-d H:i:s');
					$dataArr['date_updated'] = date('Y-m-d H:i:s');
					$this->db->insert( 'shopsy_promotions', $dataArr, $condition );
					$this->setErrorMessage('success','Promotion saved successfully!');
				}
			}

			redirect('site/shop/promotions');
		}
		
		if( $promo_type == 'product' && $action == 'edit' ) {
			$promotion = $this->product_model->getProductPromotion($product);
			//$images = $this->product_model->get_draft_product_images($product_id);
		
			$this->data['promotion'] = $promotion;
			$temp = explode( "|", $promotion['image']  );
			$this->data['image'] = $temp[0];
		
			$this->data['promo_type'] = 'product';
			$this->load->view('site/shop/create_promotion',$this->data);
			exit(0);

		}
		
		if( $promo_type == 'store' ) {
			$shop_id = $this->db->query( "SELECT id FROM shopsy_seller WHERE seller_id = " . $this->session->userdata('shopsy_session_user_id') )->row(0)->id;
			$promotion = $this->product_model->getStorePromotions($shop_id);
		
			$this->data['promotion'] = $promotion;
			//$temp = explode( "|", $promotion['image']  );
			//$this->data['image'] = $temp[0];
		
			$this->data['promo_type'] = 'store';
			$this->load->view('site/shop/create_promotion',$this->data);
			exit(0);
		}

	}

	/*
	**
	**   Draft product list
	**
	*/
	function draft_product_list() {
		if ($this->checkLogin('U') == ''){
			redirect('login');
		} else {
			$this->data['heading'] = 'Manage Listings';
			
			$filter_status = 'Draft';

			$page_no = $this->input->post('page_no');
			$page_size = 25;
			if( $page_no <= 0 ) $page_no = 0;
			$start = $page_no * $page_size;
			
			$this->data['shop_id'] = $this->db->select('*')->from(SELLER)
										   ->where( array('seller_id' => $this->checkLogin('U')) )
										   ->get()->first_row()->id;

			$this->data['total_products'] = $this->db->select('count(*) as total')
													 ->from('shopsy_product')
													 ->where( array('store_id' =>  $this->data['shop_id'] ) )
													 ->where( array('status' => $filter_status ) )
													 ->get()->first_row()->total;

			$total_pages = ( $this->data['total_products'] == 0 ? 0 : $this->data['total_products'] / $page_size) ;
			
			$this->data['products'] = $this->db->select('p.id, p.product_name, p.seourl,p.image, p.price, p.product_featured, p.quantity,p.status, c.cat_name')
											   ->from('shopsy_product p')
											   ->join('shopsy_category c', 'c.id = p.category_id', 'left' )
											   ->where( array('p.store_id' =>  $this->data['shop_id'], 'p.status' => $filter_status ) )
											   ->limit($page_size, $start)
											   ->get()->result_array();

			$this->data['page_no'] = $page_no;
			$this->data['total_pages'] = $total_pages;
			$this->load->view('site/shop/product_setup',$this->data);
		}

	}

	/****
	*****  Load Product setup page
	*****
	*****/	
	public function product_setup( $product_id = NULL ) {
		if ( $this->checkLogin('U') != '' || $this->checkLogin('A') != '' ){

			$user = $this->session->all_userdata();
			if ( $this->checkLogin('A') != ''){
				$user_id = $user['shopsy_session_admin_id'];
			} elseif ($this->checkLogin('U') != '' ) {
				$user_id = $user['shopsy_session_user_id'];
			}
			if ( $user_id == '' ) {
				$this->data['message'] = '<h1>You need to login first!</h1><br><a href="admin"><button class="btn-primary">Login</button></a>';
				$this->load->view('site/shop/shop_message',$this->data);
				exit(0);
			}

			$fields = array('product_title','main_cat_id','product_sort','description', 'product_keyword', 'product_shopify', 'sold_excl', 'custom_prod', 'product_id');
			
			//Save Product info page
			if( $this->input->post('current_step') == 'info' && $this->input->post('submit') != '' ) {

				
				//$user = $this->session->all_userdata();
				$this->load->view('site/shop/add_shop_product_info',$this->data);
				exit(0);
			}
			//End save product info page
			
			//Save Product Video
			if( $this->input->post('current_step') == 'media' && $this->input->post('video_url') != '' ) {
				$error = '';
				if( $this->input->post('product_id') == '' ) {
					$error['product_id'] = 'There is problem with product. Please select product again!';
					echo 'Failure|'.$error;
					exit(0);
				}
				$dataArr = array( 
					'product_id' => $this->input->post('product_id'),
					'video_url' => $this->input->post('video_url'),
					'modified' => date('Y-m-d H:i:s')
				);
				
				$status = $this->product_model->add_product_video($dataArr);
				
				if ( $status )
					echo 'Success|Product video url updated!';
				else
					echo 'Failure|Video URL update failed!';

				exit(0);
			}
			//Remove Image
			if( $this->input->post('current_step') == 'media' && $this->input->post('action') == 'remove_image'  ) {
				if( $product_id != $this->input->post('product_id') ) {
					echo 'Failure~Product id is different!';
					exit(0);
				}

				$sql = "SELECT image FROM shopsy_product WHERE id = " . $product_id . " AND status = 'Draft' AND user_id = " . $user_id;
				$query_sel = $this->db->query( $sql );
				$row = $query_sel->row_array();
				$sel_image_no = '';
				if( $row['image'] != '' ) {
					$images = array();
					$new_images = '';
					$images = explode( "|", $row['image']);
					foreach( $images as $image_no => $image_name ) {
						if( $image_name == $this->input->post('image_name') ) {
							if( file_exists( FCPATH.'images/product/temp_img/'.$image_name ) ) {
								unlink( FCPATH.'images/product/temp_img/'.$image_name );
							}
							continue;
						} else {
							if( $new_images != '' ) { $new_images .= "|"; }
							$new_images .=  $image_name;
						}
					}
					
				}
				$sql = "UPDATE shopsy_product SET image = ? WHERE id = ? AND status = 'Draft' AND user_id = ? ";
				$this->db->query( $sql, array($new_images, $product_id , $user_id) );
				echo 'Success~'. $new_images;
				exit(0);
			}
			//End remove image
			//Save Product Image
			if( $this->input->post('current_step') == 'media' && $_FILES["image_upload"]["name"] != '' ) {
				$error = '';
				if( $this->input->post('product_id') == '' ) {
					$error['product_id'] = 'There is problem with product. Please select product again!';
					echo 'Failure|'.$error;
				}

				list($w, $h) = getimagesize($_FILES["image_upload"]["tmp_name"]);
				if($w >= 225 && $h >= 225){
				
					$path = "images/product/temp_img/"; 
					$imgRnew = @explode('.',$_FILES["image_upload"]["name"]);
					$NewImg = url_title($imgRnew[0], '-', TRUE);
					$ImgTmpName = $product_id . '-' . $NewImg.'.'.$imgRnew[1];
				
					if($ImgTmpName != ''){
						move_uploaded_file($_FILES["image_upload"]["tmp_name"], $path.$ImgTmpName);
						$dataArr = array( 
							'product_id' => $this->input->post('product_id'),
							'image_name' => $ImgTmpName,
							'modified' => date('Y-m-d H:i:s')
						);
						$status = $this->product_model->add_product_image($dataArr);
						if ( $status )
							echo 'Success|'.$path.$ImgTmpName;
						else
							echo 'Failure|Image DB update failed OR Maximum images uploaded!';
					}
				}else{
					$errormessage=addslashes(shopsy_lg('lg_upload_img_too_small','Upload Image Too Small. Please Upload Image Size More than or Equalto 550 X 350 .'));
					echo 'Failure|'.$errormessage;
				}
				exit(0);
			}

			if ( $product_id !== NULL && ( $this->input->get('step') == 'info' || $this->input->get('step') == '' ) ) {
				$product_info = $this->product_model->getProductInfo($product_id);
				if ( $product_info ) {
					$cat_ids = array();
					$sub_cat = array();
					$cat_ids = explode(',', $product_info['category_id']);
					if( count($cat_ids) > 0 ) { 
						$main_cat_id = $cat_ids[0]; 
						unset( $cat_ids[0] ); //remove main category id from sub category list
						foreach( $cat_ids as $key => $val ) {
							$query_sel =  $this->db->query("SELECT cat_name FROM shopsy_category WHERE id = " . (int) $val );
							$row = $query_sel->row_array();
							$sub_cat[] = array (
							      'id' => $val,
								  'cat_name' => $row['cat_name']
							);
						}
					}
					$this->data['product_title'] = $product_info['product_name'] ;
					$this->data['main_cat_id'] = $main_cat_id;
					$this->data['sub_cats'] = $sub_cat;
					$this->data['product_sort'] = $product_info['product_sort'];  
					$this->data['description'] = $product_info['description'];  
					$this->data['product_keyword'] = $product_info['meta_keyword'];
					$this->data['product_shopify'] = $product_info['shopify_url'];  
					$this->data['sold_excl']  = $product_info['sold_exclusive']; 
					$this->data['custom_prod']  = $product_info['maked_on'];
					$this->data['product_id'] = $product_info['id'];
					$this->data['step_url'] = site_url() . 'site/shop/product_setup/' . $product_id . '/' ;
					$this->load->view('site/shop/add_shop_product_info',$this->data);
					exit(0);
				} else {
					echo "Error: product not found: ";
					exit(0);
				}
				
			}
			
			if( $this->input->post('current_step') == 'media' && $this->input->post('submit') != '' ) {
				if( $this->input->post('submit') == 'Previous Step' ) {
					redirect( 'add-product/'. $product_id . "?step=info" );
					exit(0);
				}
				if( $this->input->post('submit') == 'Next Step' ) {
					redirect( 'add-product/'. $product_id . "?step=variation" );
					exit(0);
				}
			}
			
			if( $this->input->get('step') == 'media' ) {
				$this->data['product_id'] = $product_id;
				$images = array();
				$images = $this->product_model->get_draft_product_images($product_id);
				if ( $images ) {
					if( $images['image'] ) {
						$this->data['images'] = $images['image'];
					}
				}
				$this->data['video_url'] = $images['video_url'];
				$this->data['product_name'] = $images['product_name'];
				$this->data['step_url'] = site_url() . 'site/shop/product_setup/' . $product_id . '/' ;
				$this->load->view('site/shop/add_shop_product_media',$this->data);
				exit(0);
			} 
			
			//Save Product options/variations
			if( $this->input->post('current_step') == 'variation' && $this->input->post('submit') != '' ) {
			}
			
			if ( $this->input->get('step') == 'variation' ) {
				$variation = $this->product_model->get_draft_product_variations($product_id);
				if ( $variation ) {
					if( $variation['sku'] == '' ) {
						$variation['sku'] = substr( $this->session->userdata['shopsy_session_user_name'], 0, 6 ). "-" . mt_rand(1000,99999);
					}
					$this->data['variation'] = $variation;
					$this->data['var_data'] = $this->product_model->get_draft_product_variants($product_id);
				}
			
				$this->data['product_id'] = $product_id;
				$this->data['step_url'] = site_url() . 'site/shop/product_setup/' . $product_id . '/' ;
				$this->load->view('site/shop/add_shop_product_variation',$this->data);
				exit(0);
			} 
			
			//Save Product shipping
			if( $this->input->post('current_step') == 'shipping' && $this->input->post('submit') != '' ) {
				
				$error = array();
				if( $this->input->post('ship_weight') == '' || (float) $this->input->post('ship_weight') == 0.0  ) {
					$error['product_price'] = 'Please enter product weight.';
				}
				
				$condition = array (
						'id' => $this->input->post('product_id') ,
						'user_id' => $user_id ,
						'status' => 'Draft' 
					);
				if( $this->input->post('ship_weight') != '' ) {
					$dataArr['weight'] = $this->input->post('ship_weight');
				}
				if( $this->input->post('ship_length') != '' ) {
					$dataArr['ship_length'] = $this->input->post('ship_length');
				}
				if( $this->input->post('ship_width') != '' ) {
					$dataArr['ship_width'] = $this->input->post('ship_width');
				}
				if( $this->input->post('ship_height') != '' ) {
					$dataArr['ship_height'] = $this->input->post('ship_height');
				}
				if( $this->input->post('return_policy') != '' ) {
					$dataArr['return_policy'] = $this->input->post('return_policy');
				}
				if( $this->input->post('ship_detail') != '' ) {
					$dataArr['ship_price_info'] = $this->input->post('ship_detail');
				}
				if( $this->input->post('ship_days') != '' ) {
					$dataArr['ship_days'] = $this->input->post('ship_days');
				}
				
				$this->product_model->edit_product($dataArr,$condition, PRODUCT );
				//Update product shipping cost
				$ship_cost1 = $this->input->post('ship_cost1');
				$ship_cost2 = $this->input->post('ship_cost2');
				
				$this->db->where('product_id', $product_id );
				$this->db->delete('shopsy_product_shipping');
				foreach( $ship_cost1 as $key => $val ) {
					$ship_rec = array();
					$ship_rec['product_id'] = $product_id;
					if ( $key == 0 ) {
						$ship_rec['code'] = 'CUS';
						$ship_rec['description'] = 'Continental United States';
					}
					if ( $key == 1 ) {
						$ship_rec['code'] = 'PUR';
						$ship_rec['description'] = 'Puerto Rico';
					}
					if ( $key == 2 ) {
						$ship_rec['code'] = 'AHW';
						$ship_rec['description'] = 'Alaska & Hawaii';
					}
					if( (float) $val > 0.00 ) {
						$ship_rec['ship_price'] = (float) $val;
						$ship_rec['next_item_price'] = (float) $ship_cost2[$key];
						$this->db->insert('shopsy_product_shipping',$ship_rec);
					}
				}
				
				if( $this->input->post('submit') == 'Previous Step' ) {
					redirect( 'site/shop/product_setup/'. $product_id . "?step=variation" );
					exit(0);
				}
				if( $this->input->post('submit') == 'Next Step' ) {
					redirect( 'site/shop/product_setup/'. $product_id . "?step=final" );
					exit(0);
				}
				if ( $this->input->post('submit') == 'save_later' ) {
					$this->data['message'] = '<h1>Product saved successfully!!</h1>';
					$this->load->view('site/shop/shop_message',$this->data);
					exit(0);
				}
								
			}

			if ( $this->input->get('step') == 'shipping' ) {
				$shipping = $this->product_model->get_draft_product_shipping($product_id);
				$this->data['shipping'] = $shipping;
				$this->data['step_url'] = site_url() . 'site/shop/product_setup/' . $product_id . '/' ;
				$this->data['product_id'] = $product_id;
				$this->load->view('site/shop/add_shop_product_shipping',$this->data);
				exit(0);
			} 

			if ( $this->input->post('current_step') == 'final' && $this->input->post('submit') == '' ) {
					$this->data['message'] = '<h1>You can publish the product later!</h1>';
					$this->load->view('site/shop/shop_message',$this->data);
					exit(0);
			}
			
			//if ( $this->input->post('current_step') == 'final' && $this->input->post('submit') == 'Publish without Promotion' ) {
			if ( $this->input->post('current_step') == 'final' && $this->input->post('submit') != '' ) {
				
				$product_info_flag = true;
				$error = array();
				$product_info = $this->product_model->getProductInfo($product_id);
				
				if( $product_info['product_name'] == '' ) {
					$product_info_flag = false;
					$error[] = 'product_name';
				}
				if( $product_info['category_id'] == '' ) {
					$product_info_flag = false;
					$error[] = 'category_id';
				}
				if( $product_info['description'] == '' ) {
					$product_info_flag = false;
					$error[] = 'description';
				}
				if( $product_info['meta_keyword'] == '' ) {
					$product_info_flag = false;
					$error[] = 'meta_keyword';
				}
				
				$images = array();
				$product_media_flag = true;
				$images = $this->product_model->get_draft_product_images($product_id);
				//if ( ! $images ) {
				//}
				$variation = array();
				$product_variation_flag = true;
				$variation = $this->product_model->get_draft_product_variations($product_id);
				if( $variation['price'] == '' ) {
					$product_variation_flag = false;
					$error[] = 'price';
				}
				
				if( $variation['sku'] == '' ) {
					$product_variation_flag = false;
					$error[] = 'sku';
				}
				if( $variation['quantity'] == '' ) {
					$product_variation_flag = false;
					$error[] = 'quantity';
				}
				if( $product_variation_flag && $product_info_flag && $product_media_flag ) {

					//$seo_url = str_replace(" ","-",$product_info['product_name']);
					$seo_url = url_title($product_info['product_name'], '-', TRUE);
					$condition = array (
							'id' => $product_id ,
							'user_id' => $user_id ,
							'status' => 'Draft' 
						);
					$dataArr = array (
									'seourl' => $seo_url,
									'status' => 'Publish'
								);
					$this->product_model->edit_product($dataArr,$condition, PRODUCT );
					
					$image_names = explode( "|", $images['image'] );
					foreach( $image_names as $image_no => $image_name ) {
						$src_file = FCPATH.'images/product/temp_img/'.$image_name;
						@copy($src_file, './images/product/org-image/'.$image_name);
					
						@copy($src_file, './images/product/mb/'.$image_name);
						$this->ImageCompress('images/product/mb/'.$image_name);
					
						@copy($src_file, './images/product/mb/thumb/'.$image_name);
						$this->ImageResizeWithCrop(350, '', $image_name, './images/product/mb/thumb/');
					
						@copy($src_file, './images/product/mb/crop/'.$image_name);
						$this->ImageResizeWithCropping(350, 350, $image_name, './images/product/mb/crop/');
					
						@copy($src_file, './images/product/'.$image_name);
						$this->ImageResizeWithCrop(550, '', $image_name, './images/product/');
					
						@copy($src_file, './images/product/thumb/'.$image_name);
						$this->ImageResizeWithCrop(175, '', $image_name, './images/product/thumb/');
					
						@copy($src_file, './images/product/list-image/'.$image_name);
						$this->ImageResizeWithCrop(75, '', $image_name, './images/product/list-image/');
					
						@copy($src_file, './images/product/cropsmall/'.$image_name);
						$this->ImageResizeWithCropping(108, 92, $image_name, './images/product/cropsmall/');
					
						@copy($src_file, './images/product/cropmed/'.$image_name);
						$this->ImageResizeWithCropping(285, 215, $image_name, './images/product/cropmed/');
					
						@copy($src_file, './images/product/cropthumb/'.$image_name);
						$this->ImageResizeWithCropping(75, 75, $image_name, './images/product/cropthumb/');
						//Delete temp image
						@unlink( $src_file );
					}

					//$this->session->set_userdata('draft_product_message', 'Product Published successfully!');
					if (  $this->input->post('submit') == 'Publish' ) {
						$this->setErrorMessage('success','Product Published successfully!');
						redirect( 'shop/managelistings' );
						//$this->data['message'] = '<h1>Product Published successfully!</h1>';
						//$this->load->view('site/shop/shop_message',$this->data);
						exit(0);
					}
					
					if ( $this->input->post('submit') == 'Publish_and_Promote' ) {
						redirect('site/shop/create_promotion/' . $product_id);
					}
					
				} else {
					$message = 'Please fill required fields!<br>' . print_r( $error, 1 );
					$this->session->set_userdata('draft_product_message', $message );
				}
				
			}
			
			if ( $this->input->get('step') == 'final' ) {
				$this->data['product_id'] = $product_id;
				$product_info = $this->product_model->getProductInfo($product_id);
				if ( ! $product_info ) {
					$this->data['message'] = '<h1>Product may be published!</h1>';
					$this->load->view('site/shop/shop_message',$this->data);
					exit(0);
				}

				$this->data['product_info'] = $product_info;
				$images = array();
				$images = $this->product_model->get_draft_product_images($product_id);
				if ( $images ) {
					if( $images['image'] ) {
						$this->data['images'] = $images['image'];
					}
				}
				$this->data['video_url'] = $images['video_url'];
				$variation = $this->product_model->get_draft_product_variations($product_id);
				$this->data['variation'] = $variation;
				$this->data['var_data'] = $this->product_model->get_draft_product_variants($product_id);
				
				$shipping = $this->product_model->get_draft_product_shipping($product_id);
				$this->data['shipping'] = $shipping;

				$this->data['step_url'] = site_url() . 'site/shop/product_setup/' . $product_id . '/' ;
				$this->load->view('site/shop/add_shop_product_final',$this->data);
			} else {
				$this->data['step_url'] = site_url() . 'site/shop/product_setup/' . $product_id . '/' ;
				
				$this->load->view('site/shop/add_shop_product_info',$this->data);
			}
		} else {
				$this->data['message'] = '<h1>You need to login first!</h1><br><a href="login"><button class="btn-primary">Login</button></a>';
				$this->load->view('site/shop/shop_message',$this->data);
			//redirect( 'admin' );
		}
		
	}
	
	/*
	*  Product setup - save product information page
	*/
	function saveDraftProductInfo() {
		
		if( $this->checkLogin('U') == '' ) {
			$json = array( 'status' => 'error', 'message' => 'You are not authorized!' );
			echo json_encode( $json );
			return;
		}
		
		$json = array();
		$error_msg = array();
		
		if( $this->input->post('product_title') == '' ) {
			$json = array( 'status' => 'error', 'message' => 'Please enter product name.' );
			echo json_encode( $json );
			return;
		}
		$user_id = $this->checkLogin('U');
		$shop_id = $this->db->select('*')->from(SELLER)
										   ->where( array('seller_id' => $user_id ) )
										   ->get()->first_row()->id;

		$product_keywords = array();
		$product_keywords = explode( "," , $this->input->post('product_keyword') );
				
		$sub_cats = implode( ",", $this->input->post('sub_cats'));
		$category_id = $this->input->post('main_cat_id');
		if ( $sub_cats != '' )  { $category_id .= ',' . $sub_cats;  } 

		try {

		$dataArr = array( 
			'product_name' => $this->input->post('product_title'),
			'category_id' =>   $category_id,
			'product_sort' => $this->input->post('product_sort'),
			'description' => $this->input->post('description'),
			'meta_keyword' => $this->input->post('product_keyword'),
			'shopify_url' => $this->input->post('product_shopify'),
			'sold_exclusive' =>  $this->input->post('sold_excl'),
			'maked_on' =>  $this->input->post('custom_prod') == '1' ? 'made-to-order' : '' ,
			'user_id' => $user_id,
			'store_id' => $shop_id,
			'status' => 'Draft',
			'created' => date('Y-m-d H:i:s'),
			'modified' => date('Y-m-d H:i:s')
		);

		if( $this->input->post('product_id') == '' ) {

			$this->product_model->add_product($dataArr);
			$new_product_id = $this->db->insert_id();

			if( (int) $new_product_id > 0 ) {
				$this->setErrorMessage('success','Product Added Successfully!');
				$next_url = 'add-product/'. $new_product_id . "?step=media";
				$json = array( 'status' => 'success', 'message' => 'Product Added Successfully!', 'next_url' => $next_url );
				echo json_encode( $json );
				return;
			}

		} else { //Update product
			$condition = "id = '" . $this->input->post('product_id') . "' AND user_id = '" . $user_id . "' AND store_id = '" . $shop_id . "'";

			unset( $dataArr['user_id'] );
			unset( $dataArr['store_id'] );
			unset( $dataArr['created'] );
			$this->product_model->edit_product($dataArr, $condition, PRODUCT);

			//Set success message
			//$this->setErrorMessage('success','Product Updated Successfully!');
				$next_url = 'add-product/'. $this->input->post('product_id') . "?step=media";

				$json = array( 'status' => 'success', 'message' => 'Product Updated Successfully!', 'next_url' => $next_url );
				echo json_encode( $json );
				return;
		}

		}
		 catch( Exception $e ) {
			$json = array( 'status' => 'error', 'message' => print_r( $e->getMessage(), 1) );
			echo json_encode( $json );
			return;
		}

		$json = array( 'status' => 'error', 'message' => 'unknown error! Try later!' );
		echo json_encode( $json );
				
	}
	/*
	*   function: save draft product variation
	*/
	function saveDraftProductVariation() {

		$user_id = $this->checkLogin('U');
		$shop_id = $this->db->select('*')->from(SELLER)
										   ->where( array('seller_id' => $user_id ) )
										   ->get()->first_row()->id;
										   
		$variation_flag =  $this->input->post('variation_flag')  == 1 ? 1 : 0   ;
		$product_id = $this->input->post('product_id');
		$product_msrp = $this->input->post('product_msrp');
		
		if( $variation_flag ) {
			$need_sku = $this->input->post('need_sku') == '' ? 0 : 1;
			$need_upc = $this->input->post('need_upc')== '' ? 0 : 1;
			$need_price = $this->input->post('need_price')== '' ? 0 : 1;
			$need_msrp = $this->input->post('need_msrp')== '' ? 0 : 1;
			$need_mpn = $this->input->post('need_mpn')== '' ? 0 : 1;
		} else {
			$need_sku = $need_upc = $need_price = $need_msrp = $need_mpn = 0;
		}

		if ( $variation_flag ) {
			$variant_id = $this->input->post('variant_id');
			$total_rows = count( $variant_id );
			$var_qty = $this->input->post('var_qty');
			$var_price = $this->input->post('var_price');
			$var_sku = $this->input->post('var_sku');
			$var_msrp = $this->input->post('var_msrp');
			$var_upc = $this->input->post('var_upc');
			$var_mpn = $this->input->post('var_mpn');
			for($i=0; $i < $total_rows; $i++ ){
				if ( (int) $var_qty[$i] < 0 ) {
					$error['var_qty'] = 'Please enter valid quantity value.';
				}
			}

		}
				
		$condition = array (
				'id' => $this->input->post('product_id') ,
				'user_id' => $user_id ,
				'store_id' => $shop_id,
				'status' => 'Draft' 
		);
		$dataArr = array (
						'msrp' => $product_msrp,
						'price' => $this->input->post('product_price'),
						'sku' => $this->input->post('product_sku'),
						'quantity' => $this->input->post('stock_qty'),
						'upc' => $this->input->post('product_upc'),
						'part_number' => $this->input->post('product_mpn'),
						'variable_product' => $variation_flag,
						'variable_sku' => $ $need_sku,
						'variable_upc' => $ $need_upc,
						'variable_price' => $need_price,
						'variable_msrp' => $need_msrp,
						'variable_mpn' => $need_mpn
					);
		$this->product_model->edit_product($dataArr,$condition, PRODUCT );

		//save variant
		if( $variation_flag ) {
			$var_sku = $this->input->post('var_sku');
			for( $i =0; $i < count($variant_id); $i++ ) {
				$dataArr = array(
							'quantity' => $var_qty[$i],
							'sku' => $var_sku[$i],
							'price' => ( $need_price ? $var_price[$i] : '' ),
							'msrp'  => ( $need_msrp ? $var_msrp[$i] : '' ),
							'part_number' => ( $need_mpn ? $var_mpn[$i] : '' ),
							'upc' => ( $need_upc ? $var_upc[$i] : '' ),
						);
				$condition = array(
							'product_variant_id' => $variant_id[$i],
							'product_id' => $this->input->post('product_id')
						);
				$this->db->update('shopsy_product_variation',$dataArr, $condition);
			}
		}
		
		if( $variation_flag && $this->input->post('submit') == 'UpdateVariation' ) {
			$total_options = (int) $this->input->post('total_options');
			if ( $total_options > 0 ) {
				 $this->db->delete('shopsy_product_variation', array('product_id' => $this->input->post('product_id') )); 
				 $this->db->delete('shopsy_product_options', array('product_id' => $this->input->post('product_id') )); 
				 $this->db->delete('shopsy_product_option_values', array('product_id' => $this->input->post('product_id') )); 
				
			}
			//insert all Options
			for($i=0; $i < $total_options; $i++ ) {
				$option_seq_id = $i + 1;
				$var_type = (int) $this->input->post('var_'. $option_seq_id);
				$var_name =  $this->input->post('var_'.$option_seq_id.'_name' );
				$var_value = $this->input->post( $var_name );

				$product_option_id = $this->input->post( 'var_option_id_'.$option_seq_id );
				//if( $product_option_id == '' ){
					$dataArr = array (
								'product_id' => $this->input->post('product_id') ,
								'option_type_id' => $var_type,
								'product_option_name' => $var_name,
								'option_seq_id'  => $option_seq_id,
								'date_created' => date('Y-m-d')
							);
					$this->db->insert('shopsy_product_options',$dataArr);
					$product_option_id = $this->db->insert_id();
					if ( $product_option_id > 0 ) { //successfull insert
						if( $var_type == 1 ){
							$color_rgb = $this->input->post( 'color_code' );
						}
						foreach( $var_value as $key => $val ) {
							if( $var_type == 1 ) {  //color
								$color_code = $color_rgb[ $key ];
							} else {
								$color_code = '';
							}

							$dataArr = array(
								'product_id' => $this->input->post('product_id'),
								'product_option_id' => $product_option_id,
								'option_value' => $val,
								'color_code' => $color_code,
								'option_seq_id' => $option_seq_id,
								'user_id' => $user_id,
								'date_created' => date('Y-m-d')
								);
							$this->db->insert('shopsy_product_option_values',$dataArr);
						}
					} // end foreach values
				//} 
				
			} //end for - option level
			
			//Insert Variants
			$options = array();
			$this->db->select( 'product_option_id, product_id, product_option_name, option_seq_id' );
			$this->db->from( 'shopsy_product_options' );
			$this->db->where('product_id', $product_id );
			$this->db->order_by("option_seq_id", "ASC");
			$query = $this->db->get(); 
			if ( $query->num_rows() ) {
				 foreach( $query->result_array() as $option ) {
					$options[] =  $option;
				 }
			}
			//Ger values for all options
			$seq_no =0;
			foreach( $options as $key => $option_row ) {
				$product_option_id = $option_row['product_option_id'];
				$this->db->select( 'product_option_value_id, product_option_id, product_id, option_value, color_code' );
				$this->db->from( 'shopsy_product_option_values' );
				$this->db->where('product_id', $product_id );
				$this->db->where('product_option_id', $product_option_id );
				$query = $this->db->get(); 
				if ( $query->num_rows() ) {
					 foreach( $query->result_array() as $value ) {
						$values[$seq_no][] =  $value['product_option_value_id'] . ":" .$value['option_value'];
					 }
				}
				$seq_no++;
			}
			$total_variants = 1;
			foreach ( $values as $key => $val ) {
				$total_variants = $total_variants * count( $val );
			}

			$variants = array();
			for( $j=0; $j < $total_variants; $j++ ) {
				$variants[$j] = '';
			}
			$total_options = count( $values );

			for( $m=0; $m < $total_options; $m++ ) {
			  for( $j=0; $j < $total_variants;  ) {
					  foreach( $values[$m] as $key => $val ) {
						if( $variants[$j] != '' ) $variants[$j] .= "|";
						$variants[$j] = $variants[$j].$val;
						$j++;
					  }
			  }
			  sort( $variants );
			}

			for( $m=0; $m < $total_variants ; $m++ ) {
				$temp = explode("|", $variants[$m]);
				$variant_name = '';
				$variant_id = '';
				foreach( $temp as $key => $val ) {
					$temp1 = explode(":", $val);
					if ( $variant_name != '' )  $variant_name .= "|";
					if ( $variant_id != '' )  $variant_id .= "|";
					$variant_name .= $temp1[1];
					$variant_id .= $temp1[0];
				}
				$dataArr = array(
					'product_id' => $this->input->post('product_id'),
					'product_variant_name' => $variant_id,
					'product_variant_name1' => $variant_name,
					'date_created' => date('Y-m-d')
					);
				$this->db->insert('shopsy_product_variation',$dataArr);		
			}								
			//End Variants insertion

		}
		
		$json = array( 'status' => 'success', 'message' => 'Variations updated successfully!', 'next_url' => 'merchant-home' );
		echo json_encode( $json );
		
					//redirect( 'site/shop/product_setup/'. $product_id . "?step=media" );
					//redirect( 'site/shop/product_setup/'. $product_id . "?step=shipping" );
				

	}
	
	/*
	* 
	* load add new shop start
	* param String $optionsLoad
	* 
	*/
	public function load_shop_open($optionsLoad){  

	if ($this->checkLogin('U')!='' || $this->checkLogin('A')!=''){
		
		$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,array());
		
		$checkloginIDarr=$this->session->all_userdata(); 
		if ($this->checkLogin('A')!=''){
			$checkUser = $this->user_model->get_all_details(USERS,array('id' => 1));
			#echo '<pre>';print_r($checkUser);die;
			if ($checkUser->num_rows() == 1){ 
					
				$userdata1 = array('shopsy_session_user_id'=>'','shopsy_session_user_name'=>'','shopsy_session_full_name'=>'','shopsy_session_user_email'=>'','shopsy_session_temp_id'=>'');
				$this->session->unset_userdata($userdata1);
				$this->session->unset_userdata('currency_data');
				$this->session->unset_userdata('region');
				//delete_cookie("saa_user");
				$cookie = array(
					'name'   => 'saa_user',
					'value'  => '',
					'expire' => -86400,
					'secure' => FALSE
				);
				$this->input->set_cookie($cookie);
				sleep(2);	
				$userdata = array(
						'shopsy_session_user_id' => $checkUser->row()->id,
						'shopsy_session_user_name' => $checkUser->row()->user_name,
						'shopsy_session_full_name' => $checkUser->row()->full_name,
						'shopsy_session_user_email' => $checkUser->row()->email,
						'userType'=>$checkUser->row()->group
				);
				$this->session->set_userdata($userdata);
				$CookieVal = array(
					'name'   => 'saa_user',
					'value'  => $checkUser->row()->id,
					'expire' => 3600*24*7
				);
				$this->input->set_cookie($CookieVal); 
			}
			$welcome_admin=addslashes('Welcome, Admin');
			$loggeduserID=$checkUser->row()->id;
			$this->setErrorMessage('success',$welcome_admin);		
		}else{
			$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];
		}
		
		$this->data['userIdVal']=$loggeduserID;
		$this->data['countryList'] = $this->product_model->get_all_details(COUNTRY_LIST,array(),array(array('field'=>'name','type'=>'ASC')))->result();
		$this->data['selectUser_details']=$this->seller_model->get_all_details(USER,array('id'=>$loggeduserID))->result_array();
		if($optionsLoad == 'sell' || $optionsLoad == 'reviews'){
		
			if($optionsLoad == 'reviews'){
				if($this->checkLogin('U')!=""){
					$this->product_model->ExecuteQuery("UPDATE ".NOTIFICATIONS." SET `view_mode` = 'No' WHERE activity_id =".$loggeduserID." AND (activity='review' OR activity='review-update')");
				}
			}
			$this->data['selectUser_details']=$this->seller_model->get_all_details(USER,array('id'=>$loggeduserID))->result_array();
			$this->data['shopproductfeed_details']=$shopproductfeed_details = $this->seller_model->get_shopproductfeed_details($loggeduserID,'owner')->result();
			if($this->data['selectSeller_details'][0]['seller_businessname']!=""){
				$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
				#$this->data['shopDetail'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result_array();	
				$product_list=$shop_sec['product_id'];
				$condition1 = " where (u.group='User' or u.group='Seller') and u.status='Active' and p.status = 'Publish'  and p.user_id=".$loggeduserID."  group by p.id order by p.created desc";
		
				$this->data['shopDetail'] =$this->product_model->view_product_details_from_section($condition1)->result_array();		

				$cond=array('seller_id' => $loggeduserID); 
				$this->data['product'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID),array('status'=>'Publish'))->result_array();
				
				$this->data['Unpublished'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID,'status'=>'UnPublish'))->result_array();
				
				$this->data['Paidproduct'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID,'pay_status'=>'Paid'));
				$this->data['shop_section_details']=$this->seller_model->getShopSectionDetails($loggeduserID);
				$this->data['shop_section_count']=count($this->data['shop_section_details']);
					
				$this->data['meta_title'] = $this->data['heading'] = 'Shop';
				
				$this->load->view('site/shop/shop_preview',$this->data);
			}else{
			
				$this->db->select("id,name");
				$this->db->from("shopsy_country");
				$data_country=$this->db->get();
			
				$this->data["country_list"]=$data_country;
				$this->data['meta_title'] = $this->data['heading'] = 'Open new shop';
				   $this->load->view('site/shop/add_new_shop',$this->data);
			}
		} elseif($optionsLoad == 'name'){
			
			$this->db->select("id,name");
			$this->db->from("shopsy_country");
			$data_country=$this->db->get();
			$this->data["country_list"]=$data_country;
			
			$this->db->select("country");
			$this->db->from(USER);
			$this->db->where(array('id' => $loggeduserID)); 
			$country=$this->db->get()->result_array();
			$this->data["country"]=$country[0]["country"];
			$this->data['meta_title'] = $this->data['heading'] = 'Open new shop';
			$this->load->view('site/shop/add_new_shop',$this->data);
		}elseif($optionsLoad == 'listitem'){
		
			$this->data['seller_info']=$this->seller_model->get_sellers_data(SELLER,$condition);
		   	$this->data['variations_result']= $this->product_model->get_all_details(PRODUCT_ATTRIBUTE,array('status'=>'Active'))->result();	   
			$condition = " where (p.status='Publish' or p.status='unpublish') and p.user_id=".$loggeduserID." and (u.group='User' or u.group='Seller') and u.status='Active' or p.status='Publish' and p.user_id=0 group by p.id order by p.created desc";
			$this->data['shopDetail']=$this->product_model->view_product_details($condition)->result();
		   //$this->data['shopDetail'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result();
		   //$this->data['AllmainCategories'] = $this->product_model->get_all_details(CATEGORY,array('rootID'=> 0,'status' => 'Active'))->result();
			#$this->data['countryList'] = $this->product_model->get_all_details(COUNTRY_LIST,array())->result();
			$this->data['meta_title'] = $this->data['heading'] = 'Shop List Items';
		    $this->load->view('site/shop/add_shop_listitems',$this->data);

		} elseif($optionsLoad == 'admin-listitem') { 
			if($this->checkLogin('A')!=''){
				redirect('site/shop/product_setup');
				/*redirect('site/shop/admin_add_product_form');
				
				$this->data['variations_result']= $this->product_model->get_all_details(PRODUCT_ATTRIBUTE,array('status'=>'Active'))->result();
				$condition = " where (p.status='Publish' or p.status='unpublish') and p.user_id=".	$loggeduserID." and (u.group='User' or u.group='Seller') and u.status='Active' or p.status='Publish' and p.user_id=0 group by p.id order by p.created desc";
				$this->data['shopDetail']=$this->product_model->view_product_details($condition)->result();
				$this->data['meta_title'] = $this->data['heading'] = 'Shop List Items';
				$this->load->view('site/shop/add_shop_listitems',$this->data);*/
			}else{
				redirect('admin');	
			}
			   			 
		}elseif($optionsLoad == 'payment'){
			#$this->data['countryList'] = $this->product_model->get_all_details(COUNTRY_LIST,array())->result();
			$this->data['shopDetail'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result();
			$this->data['meta_title'] = $this->data['heading'] = 'Shop Payment';
			$this->load->view('site/shop/add_shop_getpaid',$this->data);
		}elseif($optionsLoad == 'billing'){
			#$this->data['countryList'] = $this->product_model->get_all_details(COUNTRY_LIST,array())->result();
			
			if($this->config->item('membership')=='Yes'){
				
			
				//$this->data['shopDetail'] = $this->product_model->get_all_details(PRODUCT,array('user_id' =>$loggeduserID,'pay_status'=>'Pending','status'=>'Publish'))->result();
				
				$condition = " where (p.status='Publish' or p.status='Unpublish') and p.user_id=".	$loggeduserID." and (u.group='User' or u.group='Seller') and p.pay_status = 'Pending' and u.status='Active' or p.status='Publish' and p.user_id=0 group by p.id order by p.created desc";
				$this->data['shopDetail']= $shopDetail = $this->product_model->view_product_details($condition)->result();
				
				$this->data['userDetails']=$this->seller_model->get_all_details(USER,array('id'=>$loggeduserID))->row();
				
				$this->db->select('status,membership_expiry,membership_status');
				$this->db->from(SELLER);
				$this->db->where('seller_id = '.$loggeduserID);
				$this->data['SellerValShop'] = $this->db->get();
				#echo $this->db->last_query();
				#echo "<pre>"; print_r($this->data['userDetails']->row()->commision); die;
				
				$this->data['products_in_pay']=count($this->data['shopDetail']);
				$this->data['meta_title'] = $this->data['heading'] = 'Shop Billing';
				
				$this->load->view('site/shop/add_shop_member',$this->data);
				
			}else{
				//$this->data['shopDetail'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID,'pay_status'=>'Pending','status'=>'Publish'))->result();
				
				$condition = " where (p.status='Publish' or p.status='Unpublish') and p.user_id=".	$loggeduserID." and (u.group='User' or u.group='Seller') and p.pay_status = 'Pending' and u.status='Active' or p.status='Publish' and p.user_id=0 group by p.id order by p.created desc";
				$this->data['shopDetail']= $shopDetail = $this->product_model->view_product_details($condition)->result();
				
// 				echo "<pre>"; print_r($this->data['shopDetail']);
// 				echo $this->db->last_query()."<br>";
				
				$this->data['userDetails']=$this->seller_model->get_all_details(USER,array('id'=>$loggeduserID))->row();
				$this->data['CardsDetails'] = $this->product_model->get_all_details(CREDITCARDS,array('user_id'=>$loggeduserID))->row();
				$this->data['sellingPayment'] = $this->product_model->get_all_details(ADMIN_SETTINGS,array('id' => 1));
				#echo "<pre>";print_r($this->data['sellingPayment']->row());die;
				$this->db->select('status');
				$this->db->from(SELLER);
				$this->db->where('seller_id = '.$this->data['loginCheck']);
				$this->data['SellerValShop'] = $this->db->get();
				$this->data['products_in_pay']=count($this->data['shopDetail']);
				
// 				print_r($this->data['products_in_pay']);
// 				die;
				
				//$this->data['products_in_pay']=$shopDetail->num_rows();
				$this->data['meta_title'] = $this->data['heading'] = 'Shop Billing';
				#echo "<pre>"; print_r($this->data['userDetails']); die;
				$this->load->view('site/shop/add_shop_billing',$this->data);
			}			
			
			
		}
			
	}else {
	
		redirect('shop-index');
		/* $this->data['next'] = $this->input->get('next');
		$this->data['meta_title'] = $this->data['heading'] =$this->data['title']= 'Shop index';
		$this->load->view('site/shop/add_shop_index',$this->data); */
	}
}
	public function Load_shop_bizinfo() {

		if ($this->checkLogin('U') != '' || $this->checkLogin('A') != '') {
			$user_data = $this->session->all_userdata();
			if( $user_data['userType'] == 'Seller' ) {
				$this->data['seller'] = $this->db->select('*')->from('shopsy_seller')
								   ->where( array('seller_id' => $user_data['shopsy_session_user_id']) )
								   ->get()->first_row();
			}
			$shop_id = $this->data['seller']->id;
			$shop_biz_qry = $this->db->select('*')->from('sa_shop_bizinfo')->where( array('shop_id' => $this->data['seller']->id ) )
									 ->get();
			if ( $shop_biz_qry->num_rows() ) {
				$this->data['shopbiz'] = $shop_biz_qry->first_row('array');
			} else {
				$this->data['shopbiz'] = array(
					'shop_id'  => '',
					'legal_name'  => '',
					'tax_id'  => '',
					'bank_name' =>  '',
					'routing_swift_code' =>  '',
					'ship_address1' =>  '',
					'ship_address2' =>  '',
					'ship_city' =>  '',
					'ship_state'  =>  '',
					'ship_zip' =>  '',
					'owner_email' =>  '',
					'admin_email' =>  '',
					'customer_service_email' =>  '',
					'sales_email' =>  '',
					'marketplace_stores' =>  '',
					'biz_start_year' =>  '',
					'bank_account_no' =>  '',
					'paypal_id' =>  '',
					'contact_phone_no' =>  '',
					'contact_phone_ext' =>  '',
					'cs_phone_no' =>  ''
				);
			}

			if( $this->input->post('btn-save-bizinfo') != '' ) {
				$shopbiz = array(
					'legal_name'  => $this->input->post('legal_biz_name'),
					'tax_id'  => $this->input->post('tax_id'),
					'bank_name' =>  $this->input->post('bank_name'),
					'routing_swift_code' =>  $this->input->post('routing_no'),
					'ship_address1' =>  $this->input->post('address_line1'),
					'ship_address2' =>  $this->input->post('address_line2'),
					'ship_city' =>  $this->input->post('ship_city'),
					'ship_state'  =>  $this->input->post('ship_state'),
					'ship_zip' =>  $this->input->post('ship_zip'),
					'owner_email' =>  $this->input->post('owner_email'),
					'admin_email' =>  $this->input->post('admin_email'),
					'customer_service_email' =>  $this->input->post('cs_email'),
					'sales_email' =>  $this->input->post('sales_email'),
					'marketplace_stores' =>  implode(",",$this->input->post('stores')),
					'biz_start_year' =>  $this->input->post('biz_start_year'),
					'bank_account_no' =>  $this->input->post('bank_account_no'),
					'paypal_id' =>  $this->input->post('paypal_id'),
					'contact_phone_no' =>  $this->input->post('contact_phone'),
					'contact_phone_ext' =>  $this->input->post('contact_phone_ext'),
					'cs_phone_no' =>  $this->input->post('cs_phone_no')
				);
				if ( $shop_biz_qry->num_rows() ) {
					$this->db->update('sa_shop_bizinfo', $shopbiz, array( 'shop_id' => $shop_id ) );
				} else {
					$shopbiz['shop_id'] = $shop_id;
					$this->db->insert( 'sa_shop_bizinfo', $shopbiz );
					$shop_id = $this->db->insert_id();
				}
				$this->data['shopbiz'] = $shopbiz;
				$this->data['message'] = "Business information saved successfully!";
			}

			$states = $this->db->select('state_code, name')->from('shopsy_states')
							   ->where( array('countryid' => 215 ) )
							   ->order_by('name')
							   ->get()->result_array();
			$this->data['states'] = '<option value="">Select state</option>';
			foreach( $states as $key => $state ) {
				if ( $state['state_code'] == $this->data['shopbiz']['ship_state'] ) {
					$this->data['states'] .= '<option value="'. $state['state_code'] .'" selected >'. $state['name'] .'</option>';
				} else {
					$this->data['states'] .= '<option value="'. $state['state_code'] .'">'. $state['name'] .'</option>';
				}
			}
			
			$this->load->view('site/shop/shop_business_info',$this->data);
		}

	}

	/*
	* 
	* load new shop welcome page
	* 
	*/
	public function Load_shop_welcome(){
		$this->data['next'] = $this->input->get('next');
		$this->data['meta_title'] = $this->data['heading'] =$this->data['title']= 'Shop index';
		$this->load->view('site/shop/add_shop_index',$this->data); 
	}

	/*
	* 
	* load the admin add product page
	* 
	*/
	function admin_add_product_form(){
		if($this->checkLogin('A')!='') {		
					$this->data['variations_result']= $this->product_model->get_all_details(PRODUCT_ATTRIBUTE,array('status'=>'Active'))->result();
					$condition = " where (p.status='Publish' or p.status='unpublish') and p.user_id=".	$this->checkLogin('A')." and (u.group='User' or u.group='Seller') and u.status='Active' or p.status='Publish' and p.user_id=0 group by p.id order by p.created desc";
					$this->data['shopDetail']=$this->product_model->view_product_details($condition)->result();				
					$this->data['meta_title'] = $this->data['heading'] = 'Shop List Items';
					$this->load->view('site/shop/add_shop_listitems',$this->data);
		}
		
	}

	
	/*
	* 
	* load the shop preview page
	* 
	*/
	public function load_shop_preview()
	{
		$checkloginIDarr=$this->session->all_userdata(); 
		$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];
		$this->data['selectUser_details']=$this->seller_model->get_all_details(USER,array('id'=>$loggeduserID))->result_array();
		$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
		
		$this->data['countryList'] = $this->product_model->get_all_details(COUNTRY_LIST,array(),array(array('field'=>'name','type'=>'asc')))->result();
		$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
		#$this->data['shopDetail'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result();					 	  
		$cond=array('seller_id' => $loggeduserID); 
		$this->data['product'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result_array();
		
		$this->data['shop_section_details']=$this->seller_model->getShopSectionDetails($loggeduserID);
		$section=$this->uri->segment(4);
		foreach($this->data['shop_section_details'] as $shop_sec)
		{
			if($shop_sec['section_id']==$section)
			{
				$product_list=$shop_sec['product_id'];
				$condition1 = " where u.group='Seller' and FIND_IN_SET(p.id,'".$product_list."') and u.status='Active' and p.user_id=".$loggeduserID." or p.user_id=".$loggeduserID." and FIND_IN_SET(p.id,'".$product_list."') group by p.id order by p.created desc";
			}
			
		}
		
		
		$this->data['shopDetail'] =$this->product_model->view_product_details_from_section($condition1)->result_array();
		#echo $this->db->last_query(); die;
		#echo "<pre>"; print_r($this->data['shopDetail']); die;		
		$this->data['product'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result_array();
		$this->data['Paidproduct'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID,'pay_status'=>'Paid'));
		
		#$this->data['shop_section_details']=$this->seller_model->getShopSectionDetails($loggeduserID);
		$this->data['shop_section_count']=count($this->data['shop_section_details']);
		$this->data['meta_title'] = $this->data['heading'] = 'Your Shop';
		$this->load->view('site/shop/shop_preview',$this->data);
	}
	
	/*
	* 
	* Open a new shop insert and update shop for seller
	* 
	*/
	public function open_new_shop()
	{
	   if ($this->checkLogin('U')!='')
	   {
		#echo "asdfgdsf";die;
	     $checkloginIDarr=$this->session->all_userdata(); 		
		  if($this->input->post('seller_businessname') != '')
		  {
			  $loggeduserID=$checkloginIDarr['shopsy_session_user_id'];
			 # echo $loggeduserID;die;
			  $checkUser_inSellerlist=$this->seller_model->get_sellers_data(SELLER,$condition);
			 # print_r($checkUser_inSellerlist);die;
		      if(count($checkUser_inSellerlist) == 1)  // if count 1 means user details exist in seller table,so we need to update the details else  need to insert details
			     {   
					   $seourl = url_title($this->input->post('seller_businessname'), '-', TRUE);
					   $checkSeo = $this->product_model->get_all_details(SELLER,array('seourl'=>$seourl,'seller_id !='=>$loggeduserID));
					   $seo_count = 1;
						  while ($checkSeo->num_rows()>0)
						  {
						  $seourl = $seourl.'-'.$seo_count;
						  $seo_count++;
						  $checkSeo = $this->product_model->get_all_details(SELLER,array('seourl'=>$seourl,'seller_id !='=>$loggeduserID));
						  }
						  $inputArrval1=array(
					'country' =>$this->input->post("country")		   
					);
					$this->db->where(array("id"=>$loggeduserID));
			        $this->db->update(USER,$inputArrval1);
					
					$data_to_update=array('seller_businessname' => addslashes($this->input->post('seller_businessname')),'seourl' => $seourl);
					 
					$this->db->where(array('seller_id' => $loggeduserID));
			        $this->db->update(SELLER,$data_to_update);
		        
				  }
				  else
				  {
					$this->data['UserVal'] = $this->user_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')))->row();
					#echo $this->db->last_query();die;
					$seourl = url_title($this->input->post('seller_businessname'), '-', TRUE);
			        $checkSeo = $this->product_model->get_all_details(SELLER,array('seourl'=>$seourl,'seller_id !='=>$loggeduserID));
					
			        $seo_count = 1;
			          while ($checkSeo->num_rows()>0)
					  {
			 	      $seourl = $seourl.'-'.$seo_count;
				      $seo_count++;
				      $checkSeo = $this->product_model->get_all_details(SELLER,array('seourl'=>$seourl,'seller_id !='=>$loggeduserID));
			          }
					  
					 // CHECK FOR FRESH DESK STATUS
					 $checkFreshdesk = $this->product_model->get_all_details(USERS,array('id'=>$loggeduserID,'freshdesk_status'=>'Yes'));

//					 echo $this->db->last_query(); //die;
// 					 $qry =  $this->product_model->ExecuteQuery('describe '.USERS); //die;
// 					 echo "<pre>";print_r($qry);
// 					 echo $this->db->last_query(); //die;
// 					 echo "<pre>";var_dump($checkFreshdesk);
// 					 echo "<pre>";print_r($checkFreshdesk);die;
					 
					 
					 if($checkFreshdesk->num_rows() > 0){
							
					 }else{
						$user_email=$this->data['UserVal'] ->email; 
						$user_name=$this->data['UserVal'] ->user_name;
						// Create FRESH DESH ACCOUNT
						$result=$this->support_model->freshdesk_create_user($user_email,$user_name);
					 } 
				  
					$address = str_replace(' ','+',$this->input->post('shop_location'));
					$url = "http://maps.google.com/maps/api/geocode/json?address=".$address;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					$response = curl_exec($ch);
					curl_close($ch);
					$response = json_decode($response);
					$lat = $response->results[0]->geometry->location->lat;
					$long = $response->results[0]->geometry->location->lng; 
					
					$inputArrval=array(
					'seller_id' => $this->data['UserVal']->id,
				    'seller_businessname' => $this->input->post('seller_businessname'),
					'seourl' => $seourl,
					'seller_email' => $this->data['UserVal']->email,
					'seller_firstname' => $this->data['UserVal']->full_name,
					'seller_lastname' => $this->data['UserVal']->last_name,
					//'status' => 'inactive',
					'status' => 'waiting',
					'latitude' => $lat,
					'longitude' => $long,
					'shop_location'=> $this->input->post('shop_location'),
					'created' => date('Y-m-d H:i:s')
					);
					$condition=array();
					$inputArrval1=array(
					'country' =>$this->input->post("country")		   
					);
					$this->db->where(array("id"=> $this->data['UserVal']->id));
			        $this->db->update(USER,$inputArrval1);
					$this->db->insert(SELLER,$inputArrval);
					
					
					////send mail to admin////
					
					$emails=$this->send_confirm_mail($checkloginIDarr);
					
					////send mail to admin////
					
					/**********       Create account with  zendesk    start : place - controller/site/shop/open_new_shop()  *************/
					 if($this->config->item('zendesk_status')==="Active"){
						$url = base_url().'site/zendesk/create_zendesk_user';
						$post_array = array (
								"user_id" => $this->data['UserVal']->id,
								"user_name" => $this->data['UserVal']->full_name,
								"email_id" => $this->data['UserVal']->email
						);
						$this->load->library('curl');
						$this->curl->simple_post($url, $post_array);
					} 
					/**********       Create account with  zendesk    end  *****************************************************/
					
				  }
		    }
		  
		        $this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
				if($this->lang->line('now_shop_name')!='') { $now_shop_name= stripslashes($this->lang->line('now_shop_name')); } else $now_shop_name ="Success! Your shop name is now ";
				
				$this->setErrorMessage('success',$now_shop_name.stripslashes($this->data['selectSeller_details'][0]['seller_businessname']));
		 		//redirect('shop/listitem');
		 		//redirect('public-profile');
		 		redirect('appearance/'.$seourl.'/banner');
				# $this->load->view('site/shop/add_shop_listitems',$this->data);
			}else {
				$this->data['heading'] = 'Sign in'; 
				redirect('site/user/login_user');
			}
	}
	
	public function send_confirm_mail($userDetails=''){
	
		$uid = $userDetails['shopsy_session_user_id'];
		$email = $userDetails['shopsy_session_user_email'];
		$name = $userDetails['shopsy_session_full_name'];
		
		$randStr = $this->get_rand_str('10');
		$condition = array('id'=>$uid);
		$dataArr = array('verify_code'=>$randStr);
		$this->user_model->update_details(USERS,$dataArr,$condition);
		
		$newsid='25';
		$template_values=$this->user_model->get_newsletter_template_details($newsid);
		
		$cfmurl = base_url().'admin/shop/display_shop';
		$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
		$adminnewstemplateArr=array('email_title'=> 'New Shop','logo'=> $this->data['logo'],'footer_content'=> $this->config->item('footer_content'));
		extract($adminnewstemplateArr);
		//$ddd =htmlentities($template_values['news_descrip'],null,'UTF-8');
		$header .="Content-Type: text/plain; charset=ISO-8859-1\r\n";
		
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/><body>';
		include('./newsletter/registeration'.$newsid.'.php');	
		
		$message .= '</body>
			</html>';
		
		/* if($template_values['sender_name']=='' && $template_values['sender_email']==''){
			$sender_email=$this->data['siteContactMail'];
			$sender_name=$this->data['siteTitle'];
		}else{
			$sender_name=$template_values['sender_name'];
			$sender_email=$template_values['sender_email'];
		} */

		$email_values = array('mail_type'=>'html',
							'from_mail_id'=>$email,
							'mail_name'=>$name,
							'to_mail_id'=>$this->config->item('email'),
							'subject_message'=>$template_values['news_subject'],
							'body_messages'=>$message
							);
		#echo "<pre>"; print_r($email_values);				die;
		$email_send_to_common = $this->user_model->common_email_send($email_values);
	}
	

	
	/*
	* 
	* Shop template setting Background
	* 
	*/
	public function shop_template_setting_background()
	{
		if ($this->checkLogin('U')!=''){
			$this->data['SellerVal'] = $this->seller_model->get_userselldetail_data('*',$this->checkLogin('U'));
			$this->data['userVal'] = $this->seller_model->get_userdetail_data('facebook,twitter,google,pinterest,thumbnail,location,full_name');
			//echo '<pre>'; print_r($this->data['SellerVal']); die;
			$this->data['meta_title'] = $this->data['heading'] = 'Shop Setup';
			$this->load->view('site/shop/shop_template_layout.php',$this->data);
			
		}else {
			$this->data['next'] = $this->input->get('next');
			$this->data['meta_title'] = $this->data['heading'] = 'Sigin'; 
			$this->load->view('site/user/signup.php',$this->data);
		}
	}
	

	/*
	* 
	* Seller Store view form
	* 
	*/ 
	public function seller_store_view(){
		 $sellerstore_id = $this->uri->segment(2, 0); 
		 
		 
		 $cat_idname = $this->uri->segment(3, 0); 
	//echo $cat_id; die;
	
	//print_r($cat_idname); die;
	
		 $seller_idexplopde = @explode('-',$sellerstore_id);
		 
		 $seller_id = $seller_idexplopde[0];
		// print_r($seller_id); die;
		$cat_idnameexplopde = @explode('-',$cat_idname);

		$cat_id = $cat_idnameexplopde[0];
		
		//echo $cat_id; die;
		 $this->data['userVal'] = $this->seller_model->get_userselldetail_data('shop_template,seller_businessname,seourl,seller_firstname,seller_id,seller_store_image,seller_email,seller_social_icons',$seller_id);
		 $this->data['userpersonalVal'] = $this->seller_model->get_userdetail_datastore('full_name,city,thumbnail,facebook,twitter,google,pinterest,web_url',$seller_id);
		//echo $this->data['userVal'][0]['shop_template']; die;
		//echo $this->db->last_query(); die;
		$this->data['meta_title'] = $this->data['heading'] = $this->data['userVal'][0]['seller_businessname'];

		    $searchPerPage = 2;
		    $paginationNo = $this->uri->segment('2');  
	     
			if($paginationNo == '')
			{
					$paginationNo = 0;
			}
			else
			{
					$paginationNo = $paginationNo;
			}
			
		$this->data['productVal'] = $this->product_model->get_storedetail_data_store('id,seourl,product_name,sale_price,image,product_featured,user_id',$cat_id,$searchPerPage,$paginationNo,$seller_id);
		
		//echo $this->db->last_query(); die;
		//echo $this->data['productVal'][0]['product_name']; die;
		
		
		
		$this->data['catVal'] = $catVal = $this->product_model->view_cat_details($cat_id);
		if($this->data['catVal'][0]['cat_name'] != ''){
		    $this->data['heading'] = $this->data['catVal'][0]['cat_name'];
			$this->data['meta_title'] = $this->data['catVal'][0]['meta_title'];
			$this->data['meta_keyword'] = $this->data['catVal'][0]['seo_keyword'];
			$this->data['meta_description'] = $this->data['catVal'][0]['seo_description'];
			}
		//echo $this->db->last_query(); die;
		//echo $this->data['catVal']; die;
		if($this->data['userVal'][0]['shop_template'] == 'four'){
		$limit = '4';
		}else {
		
		$limit = '3';
		}
		$this->data['featured'] = $this->product_model->get_storedetail_data_storefeature('id,seourl,product_name,sale_price,image,product_featured,user_id',$cat_id,$searchPerPage,$paginationNo,$seller_id,$limit);
		//echo $this->db->last_query(); die;
		
		$searchbaseUrl = base_url().$this->uri->segment('1').'/';
			$product_routes_name = $this->uri->segment(); 
			$config['prev_link'] = '<img src="images/page_prevt_hover.png" />';
			$config['num_links'] = 3;
			$config['display_pages'] = TRUE; 
			$config['next_link'] = '<img src="images/page_next.png" />';
			$config['base_url'] = $searchbaseUrl;
			$config['total_rows'] = count($blogTotal); 
			$config["per_page"] = $searchPerPage;
			$config["uri_segment"] = 2;
			$config['first_link'] = '';
			$config['last_link'] = '';
			$this->pagination->initialize($config); 
			 $paginationLink = $this->pagination->create_links(); 
			$this->data['paginationLink'] = $paginationLink;
			
			//echo $this->data['catVal'][0]['cat_name']; die;
			
			/*$this->data['meta_keyword'] = $this->data['catVal'][0]['seo_keyword'];
			$this->data['meta_description'] = $this->data['catVal'][0]['seo_description'];*/
	//	echo '<pre>';
	//	print_r($this->data['userVal']); die;
		$this->load->view('site/shop/shop_display.php',$this->data);
			
	}
	
	/*
	* 
	* Shop Feedback view form
	* 
	*/
	public function feedback_store_view(){
		
		 $sellerstore_id = $this->uri->segment(2, 0); 
		 

		 $cat_idname = $this->uri->segment(3, 0); 
		 $seller_idexplopde = @explode('-',$sellerstore_id);
		 
		 $seller_id = $seller_idexplopde[0];
		$cat_idnameexplopde = @explode('-',$cat_idname);

		$cat_id = $cat_idnameexplopde[0];
		
		 $this->data['userVal'] = $this->seller_model->get_userselldetail_data('shop_template,id,seller_businessname,seourl,seller_firstname,seller_id',$seller_id);
				 $this->data['userpersonalVal'] = $this->seller_model->get_userdetail_datastore('full_name,city,thumbnail',$seller_id);

				$this->data['productVal'] = $this->product_model->get_storedetail_data_store('id,seourl,product_name,sale_price,image,product_featured,user_id',$cat_id,$searchPerPage,$paginationNo,$seller_id);

		
		$this->load->view('site/shop/shop_feedback.php',$this->data);
			
	}		
	

	/*
	* 
	* Ajax Image Upload Shop Banner
	* 
	*/
	public function upload_product_image_banner(){
		$returnStr['status_code'] = 0;
		$config['overwrite'] = FALSE;
    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
//	    $config['max_size'] = 2000;
	    $config['upload_path'] = './images/store-banner';
	    $this->load->library('upload', $config);
		if ( $this->upload->do_upload('thefile')){
	    	$imgDetails = $this->upload->data();
	    	$returnStr['image']['url'] = base_url().'images/store-banner/'.$imgDetails['file_name'];
	    	$returnStr['image']['width'] = $imgDetails['image_width'];
	    	$returnStr['image']['height'] = $imgDetails['image_height'];
	    	$returnStr['image']['name'] = $imgDetails['file_name'];
			
			$this->ImageResizeWithCrop(760, 100, $imgDetails['file_name'], './images/store-banner/');
			
	    	//$this->ImageResizeWithCrop(1000, 108, $imgDetails['file_name'], './images/store-banner/');
			//@copy('./images/store-banner/'.$imgDetails['file_name'], './images/store-banner/thumb/'.$imgDetails['file_name']);
			//$this->ImageResizeWithCrop(780, 108, $imgDetails['file_name'], './images/store-banner/thumb/');
			
			$fileDetails = 	$imgDetails['file_name'];
			
			$this->seller_model->update_details(SELLER,array('seller_store_image'=>$fileDetails),array('seller_email'=>$this->session->userdata('shopsy_session_user_email')));
			
	    	$returnStr['status_code'] = 1;
		}else {
			$returnStr['message'] = "Can\'t be upload";
		}
		echo json_encode($returnStr);
	}
	
	/*
	* 
	* Ajax Image Upload Shop profile image
	* 
	*/
	public function upload_product_image_profile(){
		$returnStr['status_code'] = 0;
		$config['overwrite'] = FALSE;
    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
//	    $config['max_size'] = 2000;
	    $config['upload_path'] = './images/users';
	    $this->load->library('upload', $config);
		if ( $this->upload->do_upload('thefile')){
	    	$imgDetails = $this->upload->data();
	    	$returnStr['image']['url'] = base_url().'images/users/'.$imgDetails['file_name'];
	    	$returnStr['image']['width'] = $imgDetails['image_width'];
	    	$returnStr['image']['height'] = $imgDetails['image_height'];
	    	$returnStr['image']['name'] = $imgDetails['file_name'];
	    	$this->ImageResizeWithCrop(600, 600, $imgDetails['file_name'], './images/users/');
			//@copy('./images/store-banner/'.$imgDetails['file_name'], './images/store-banner/thumb/'.$imgDetails['file_name']);
			//$this->ImageResizeWithCrop(780, 108, $imgDetails['file_name'], './images/store-banner/thumb/');
			
			$fileDetails = 	$imgDetails['file_name'];
			
			$this->seller_model->update_details(USERS,array('thumbnail'=>$fileDetails),array('id'=>$this->checkLogin('U')));
			
	    	$returnStr['status_code'] = 1;
		}else {
			$returnStr['message'] = "Can\'t be upload";
		}
		echo json_encode($returnStr);
	}	
	
	/*
	* 
	* Social media update for shop banner page
	* 
	*/
	public function socialmediaupdate(){
		
		//echo '<pre>'; print_r($_POST); die;
		
		$this->seller_model->update_details(USERS,array($this->input->post('id')=>$this->input->post('idval')),array('id'=>$this->checkLogin('U')));
		return 1;
		
	}
	
	/*
	* 
	* Store set up Page 
	* 
	*/
	public function storesetupfirstpage(){
		
		$dataArrVal = array();
		foreach($this->input->post() as $key => $val){
			if(!(in_array($key,$excludeArr))){
				$dataArr[$key] = trim(addslashes($val));
			}
		}
		
		$condition =array('seller_id'=>$this->checkLogin('U'));
		$this->seller_model->update_details(SELLER,$dataArr,$condition);
		$this->setErrorMessage('success','Store Setup Successfully Updated.');
		return 1;
		
	}
	
	/*
	* 
	* Ajax select for shipping country list from add shop list items 
	* 
	*/
	public function load_ajax_shipping_list($i,$selected_country=''){	 
		
		$selected_countryArr=explode(':',urldecode($selected_country));
		#print_r($selected_country); die;
		$selected_countryArr[1]; #die;
		$countryList= $this->product_model->get_all_details(COUNTRY_LIST,array(),array(array('field'=>'name','type'=>'asc')))->result();
		echo '<tr id="tab_'.$i.'"><td><p id="shipping_to_'.$i.'_lab" ></p><select name="shipping_to[]" id="shipping_to_'.$i.'" class="shipping_to" style="width:200px; padding: 3px 4px; box-shadow: none; margin: 0px; border: 1px solid rgb(205, 205, 205);" onchange="display_sel_val(this); toggleDisability(this);">';
		echo '<option value="">Select a location</option>';
		foreach($countryList as $country) 
		{
			if (in_array($country->name,$selected_countryArr, TRUE)){ echo'<option value="'.$country->name.'" disabled>'.$country->name.'</option>';}
			else{echo'<option value="'.$country->id.'|'.$country->name.'">'.$country->name.'</option>';}			
		}			
		echo '</select><input type="hidden" name="ship_to_id[]" id="shipping_to_'.$i.'_id" />
		</td>
		<td><input type="text" value="" placeholder="'.$this->data['dcurrencySymbol'].':" class="form-control shipping_txt_bax"  name="shipping_cost[]" id="shipping_cost_'.$i.'"></td>
		<td><input type="text" value="" placeholder="'.$this->data['dcurrencySymbol'].':" class="form-control shipping_txt_bax"  name="shipping_with_another[]" id="shipping_with_another_'.$i.'"></td>
		<td><a class="close_icon left" onClick="close_shipping('.$i.')" href="javascript:void(0)" style="margin:7px 0 0 5px" id="'.$i.'"></a></td>
		</tr>
		';
	}
	
	
	/*
	* 
	* Ajax load file shop products
	* 
	*/
	public function ajax_load_Files(){	
		$errors='';$ext ="";
		$maxsize    = 2097152; #1048576 Bytes for 1MB
		$acceptable = array('gif','png' ,'jpg', 'bmp','doc','docx','txt','rtf','csv','ppt','pps','pptx','pdf','xls','rar','zip','tar.gz','mp3','wav','wma','3gp','avi','flv','mov','mp4','mpg','rm');
		$filename = $_FILES['file_upload']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(($_FILES['file_upload']['size'] >= $maxsize) || ($_FILES["file_upload"]["size"] == 0)) {
			$errors= 'File too large. File must be less than 2 megabytes.';
		}else if(!in_array($ext, $acceptable) || $ext=="") {
			$errors= 'Invalid file type.';
		}
		if($errors=='') {
			$path = "temp_digital_files/";		
			$file = preg_replace('/\s+/', '_',$_FILES["file_upload"]["name"]);		
			if($_FILES["file_upload"]["name"] != ''){
				move_uploaded_file($_FILES["file_upload"]["tmp_name"], $path.$file);
				echo "Success|".$file;
			}
		}else{
			echo "Errors|".$errors;
		}
	}
	
	/*
	* 
	* Shop appearance settings display
	* 
	*/
	public function shop_appearance_setting()
	{
		if ($this->checkLogin('U')!='')
		{
			$checkloginIDarr=$this->session->all_userdata(); 
			$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];			
			$selectSeller_details=$this->seller_model->get_sellers_data(SELLER,$condition);
												
			if(count($selectSeller_details) == 1)  // if count 1 means user details exist in seller table,so we need to update the details else  need to insert details
			{
				$seourl = url_title(strip_tags($this->input->post('seller_businessname')), '-', TRUE);
				$checkSeo = $this->product_model->get_all_details(SELLER,array('seourl'=>$seourl,'seller_id !='=>$loggeduserID));
				$seo_count = 1;
				while ($checkSeo->num_rows()>0)
				{
					$seourl = $seourl.'-'.$seo_count;
					$seo_count++;
					$checkSeo = $this->product_model->get_all_details(SELLER,array('seourl'=>$seourl,'seller_id !='=>$loggeduserID));
				}
				$inputArrval1=array(
						'country' =>$this->input->post("country")
				);
				$this->db->where(array("id"=>$loggeduserID));
				$this->db->update(USER,$inputArrval1);
				$seller_businessname =  strip_tags($this->input->post('seller_businessname'));
				#echo $seller_businessname;die;
				if($seller_businessname == "" ){
					$shop_appreance=addslashes(shopsy_lg('lg_shop_appreance_error','Please Check with your Shop Name'));
					$this->setErrorMessage('error',$shop_appreance);
					redirect('shop/sell');
				}
				$seller_businessname = preg_replace("/[^A-Za-z0-9_\-]/", '', $seller_businessname);
				if($seller_businessname == "")
				{	
					$shop_appreance=addslashes(shopsy_lg('lg_shop_appreance_error','Please Check with your Shop Name'));
					$this->setErrorMessage('error',$shop_appreance);
					redirect('shop/sell');
				}
				$data_to_update=array('seller_businessname' =>addslashes($seller_businessname),'seourl' => $seourl);
				//print_r($data_to_update);die;
				$this->db->where(array('seller_id' => $loggeduserID));
				$this->db->update(SELLER,$data_to_update);
			
			}
			
			$shop_title=strip_tags ($this->input->post('shop_title'));
			
			$shop_banner=$this->input->post('shop_banner');
			if($this->input->post('local_markets')){$local_markets="Yes";} else{$local_markets="No";}
			if( $this->input->post('hide_review') ) { $hide_review = 1; } else { $hide_review = 0; }
			$shop_announcement=strip_tags($this->input->post('shop_announcement'));
			$msg_to_buyers=strip_tags($this->input->post('msg_to_buyers'));
			$msg_to_buyers_for_digiitem=strip_tags($this->input->post('msg_to_buyers_for_digiitem'));
			
			
			$fb_link=$this->input->post('fb_link');
			$twitter_link=$this->input->post('twitter_link');
			
			
			$config['overwrite'] = FALSE;
			$config['allowed_types'] = 'jpg|jpeg|gif|png';
			#$config['max_size'] = 2000;
			$config['upload_path'] = './images/store-banner';
			$this->load->library('upload', $config);
			
			//if ( $this->upload->do_upload('shop_banner'))
			if ( $this->upload->do_upload('file'))
			{
				$imgDetails = $this->upload->data();
				$returnStr['image']['url'] = base_url().'images/store-banner/'.$imgDetails['file_name'];
				$returnStr['image']['width'] = $imgDetails['image_width'];
				$returnStr['image']['height'] = $imgDetails['image_height'];
				$returnStr['image']['name'] = $imgDetails['file_name'];
				
				//$this->ImageResizeWithCrop(760, 100, $imgDetails['file_name'], './images/store-banner/');
				$this->image_crop_process_auto(760, 100, $_POST['left'], $_POST['top'], $_POST['width'], $_POST['height'], $imgDetails['file_name'], './images/store-banner/');
				
				$fileDetails = 	$imgDetails['file_name'];
				
			}
			
				if($fileDetails==""){
						$inputArrVal=array(
							'shop_title' => $shop_title,
							'local_markets' => $local_markets,
							'hide_review'   => $hide_review,
							'shop_announcement' => $shop_announcement,
							'msg_to_buyers' => $msg_to_buyers,
							'msg_to_buyers_for_digiitem' => $msg_to_buyers_for_digiitem,
							'facebook_link' => $fb_link,
							'twitter_link' => $twitter_link
						);
				}
				else{
						$inputArrVal=array(
							'shop_title' => $shop_title,
							'seller_store_image' => $fileDetails,
							'local_markets' => $local_markets,
							'hide_review'   => $hide_review,
							'shop_announcement' => $shop_announcement,
							'msg_to_buyers' => $msg_to_buyers,
							'msg_to_buyers_for_digiitem' => $msg_to_buyers_for_digiitem,
							'facebook_link' => $fb_link,
							'twitter_link' => $twitter_link
						);			
				}
				
				$condition=array('seller_id' => $loggeduserID);
			
				$this->product_model->commonInsertUpdate(SELLER,'update',array('shop-banner','fb_link','left','top','width','height'),$inputArrVal,$condition);
				#echo $this->db->last_query()."<br>";die;
				
				$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
				
				//print_r($this->data['selectSeller_details']); die;
				$shop_appreance=addslashes(shopsy_lg('lg_shop_appreance_updated','Success! Your Shop Apperances Updated'));
				$this->setErrorMessage('success',$shop_appreance);
				redirect('shop/sell');
				       			
		}
	}
	
	
	/*
	* 
	* Shop Policy settings display
	* 
	*/
	public function shop_policy_setting()
	{
		if ($this->checkLogin('U')!='')
		{
			$checkloginIDarr=$this->session->all_userdata(); 
			$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];			
												
			
			$welcome_message=$this->input->post('welcome_message');
			$payment_policy=$this->input->post('payment_policy');
			$shipping_policy=$this->input->post('shipping_policy');
			$refund_policy=$this->input->post('refund_policy');
			$additional_information=$this->input->post('additional_information');
			$seller_information=$this->input->post('seller_information');
			
						$inputArrVal=array(
							'welcome_message' => $welcome_message,
							'payment_policy' => $payment_policy,
							'shipping_policy' => $shipping_policy,
							'refund_policy' => $refund_policy,
							'additional_information' => $additional_information,
							'seller_information' => $seller_information
						);			
				
				$condition=array('seller_id' => $loggeduserID);
			
				$this->product_model->commonInsertUpdate(SELLER,'update','',$inputArrVal,$condition);
				$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
				$policy_update=addslashes(shopsy_lg('lg_Success_Your_Shop_Policy_Updated','Success! Your Shop Policy Updated'));
				$this->setErrorMessage('success',$policy_update);
				redirect('shop/sell');
			
				       			
		}
	}
	
	/*
	* 
	* Add shop section list
	* 
	*/
	public function add_shop_section_list()
	{
		if ($this->checkLogin('U')!='')
		{
			$checkloginIDarr=$this->session->all_userdata(); 
			
			$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];
						
			$section_name=$this->input->post('name');
			
			$section_id=time();			
			
				$dataArr=array(
					'seller_id' =>$loggeduserID,
					'section_name' => $section_name,
					'section_id' => $section_id,
				);			
				
				$condition=array('seller_id' => $loggeduserID);
				$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
				$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SHOP_SECTION_LIST,$condition);
				if($section_name.trim()==''){
					$this->setErrorMessage('error','Section name cannot be empty');
					redirect('shops/'.$this->data['selectSeller_details'][0]['seourl'].'/sections/All');
				}
				$this->seller_model->simple_insert(SHOP_SECTION_LIST,$dataArr);
				
				$this->setErrorMessage('success','Success! Section Created');
				redirect('shops/'.$this->data['selectSeller_details'][0]['seourl'].'/sections/'.$section_id);
			
				       			
		}
	}
	
	
	
	/*
	* 
	* Display the load shop owner profile page
	* 
	*/
	public function load_shopowner_profile(){
	
		$this->db->select("id,name");
		$this->db->from(COUNTRY_LIST);
		$this->data["data_country"]=$this->db->get();		
		$checkloginIDarr=$this->session->all_userdata(); 
		$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];		   
		$this->data['selectSeller_details']=$this->seller_model->display_seller_view_admin($loggeduserID);
		$this->load->view('site/shop/shop_owner',$this->data);
	}
	
	/*
	* 
	* update the seller profile page
	* 
	*/
	public function update_seller_profile(){
		if ($this->checkLogin('U')==''){
			$this->setErrorMessage('error','You must login');
			redirect('login');
		}
			 $city=addslashes(strip_tags(trim($this->input->post('city'))));
			 $country=addslashes(strip_tags(trim($this->input->post('country'))));
			 $about=addslashes(strip_tags(trim($this->input->post('about'))));
			 
			 if($_FILES['profile_pict']['name']!=""){
				$config['overwrite'] = FALSE;
	    		$config['allowed_types'] = 'jpg|jpeg|gif|png';
	    		$config['upload_path'] = 'images/users';
		    	$this->load->library('upload', $config);
			 	if ($this->upload->do_upload('profile_pict')){
		   			$logoDetails = $this->upload->data(); 
		    		$this->ImageResizeWithCrop(600, 600, $logoDetails['file_name'], './images/users/');
					@copy('./images/users/'.$logoDetails['file_name'], './images/users/thumb/'.$logoDetails['file_name']);
		    		$this->ImageResizeWithCrop(210, 210, $logoDetails['file_name'], './images/users/thumb/');
			 		$profile_image=$logoDetails['file_name'];
				 	$dataArr=array('city'=>$city,'country'=>$country,'about'=>$about,'thumbnail'=>$logoDetails['file_name']);
			 	}
			 	else{
				$problem=addslashes(shopsy_lg('lg_problem','There was a problem with your image'));
					$this->setErrorMessage('error',$problem);
			 		redirect("public-profile");
				}
			}else{
				$dataArr=array('city'=>$city,'country'=>$country,'about'=>$about);
			}
			
			$this->seller_model->update_details(USERS,$dataArr,array('id'=>$this->checkLogin('U')));
			if($this->db->affected_rows()>0){
			$updation=addslashes(shopsy_lg('lg_updation','Your profile successfully updated'));
				$this->setErrorMessage('success',$updation);
			 	redirect("shops/".$this->uri->segment(2, 0)."/profile");	
			}else{
			  $no_updation=addslashes(shopsy_lg('lg_no_updation','No updation on your profile'));
				$this->setErrorMessage('success', $no_updation);
		 		redirect("shops/".$this->uri->segment(2, 0)."/profile");
			}
	}
	
	/*
	* 
	* Load and update the shop policies
	* 
	*/
	public function load_shop_policies(){
	
	
		$checkloginIDarr=$this->session->all_userdata(); 
		$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];		   
		$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
		
			$this->data['userIdVal']=$loggeduserID;
		$this->data['countryList'] = $this->product_model->get_all_details(COUNTRY_LIST,array(),array(array('field'=>'name','type'=>'asc')))->result();
		$this->data['selectUser_details']=$this->seller_model->get_all_details(USER,array('id'=>$loggeduserID))->result_array();
		//echo '<pre>'; print_r($this->data['selectUser_details']);die;
		
		$this->data['selectUser_details']=$this->seller_model->get_all_details(USER,array('id'=>$loggeduserID))->result_array();
			$this->data['shopproductfeed_details']=$shopproductfeed_details = $this->seller_model->get_shopproductfeed_details($loggeduserID)->result();
			
			if($this->data['selectSeller_details'][0]['seller_businessname']!=""){
				$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
				#$this->data['shopDetail'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result_array();	
				$product_list=$shop_sec['product_id'];
				$condition1 = " where (u.group='User' or u.group='Seller') and u.status='Active' and p.user_id=".$loggeduserID." or p.user_id=".$loggeduserID." group by p.id order by p.created desc";
		
				$this->data['shopDetail'] =$this->product_model->view_product_details_from_section($condition1)->result_array();				 	  
				$cond=array('seller_id' => $loggeduserID); 
				$this->data['product'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result_array();
				$this->data['Paidproduct'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID,'pay_status'=>'Paid'));
				$this->data['shop_section_details']=$this->seller_model->getShopSectionDetails($loggeduserID);
				$this->data['shop_section_count']=count($this->data['shop_section_details']);
					
				$this->data['meta_title'] = $this->data['heading'] = 'Shop';
		}
		$this->load->view('site/shop/shop_policies',$this->data);
	}
	
	/*
	* 
	* Load the shop information and appearances
	* 
	*/
	public function load_info_appearance(){
		$checkloginIDarr=$this->session->all_userdata(); 
		$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];		
	  	$condition=array('seller_id' => $loggeduserID); 
		$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
		$this->data['shopDetail'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result();		
		$this->load->view('site/shop/shop_info_appearance',$this->data);
	}
	
	/*
	* 
	* Load the shop sections lists
	* 
	*/
	public function load_shop_sections(){
		
		$section=$this->data['section_id']= $this->uri->segment(4,0); 		
		$checkloginIDarr=$this->session->all_userdata(); 
		$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];		  
		$condition=array('seller_id' => $loggeduserID);  
		$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);		
		$this->data['shop_section_details']=$this->seller_model->getShopSectionDetails($loggeduserID);
		if($section=='All')
		{
			$condition1 = " where u.group='Seller' and u.status='Active' and p.user_id=".$loggeduserID." or p.user_id=".$loggeduserID." group by p.id order by p.created desc";
		}
		else
		{
			foreach($this->data['shop_section_details'] as $shop_sec)
			{
				if($shop_sec['section_id']==$section)
				{
					$product_list=$shop_sec['product_id'];
					$condition1 = " where u.group='Seller' and FIND_IN_SET(p.id,'".$product_list."') and u.status='Active' and p.user_id=".$loggeduserID." or p.user_id=".$loggeduserID." and FIND_IN_SET(p.id,'".$product_list."') group by p.id order by p.created desc";
				}
			}
		}
		
		$this->data['productDetail'] =$this->product_model->view_product_details_from_section($condition1)->result_array();
		#echo $this->db->last_query(); die;
		#echo "<pre>"; print_r($this->data['productDetail']); die;		
		$this->data['product'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result_array();
		$this->data['shop_section_list']=$this->seller_model->get_sellers_data(SHOP_SECTION_LIST,$condition);
		$this->data['shop_section_count']=count($this->data['shop_section_list']);
		$this->data['shop_section_details']=$this->seller_model->getShopSectionDetails($loggeduserID);
		$this->load->view('site/shop/shop_sections',$this->data);
	}
	
	/*
	* 
	* Delete the shop sections
	* 
	*/
	public function delete_shop_sections(){
		if ($this->checkLogin('U')!='')
		{
			$checkloginIDarr=$this->session->all_userdata(); 
			$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];
			$status=$this->input->post('status');
			$section=$this->input->post('section');
			$name=$this->input->post('name');
				$CondArr=array(
					'seller_id' => $loggeduserID,
					'section_id' => $section,
				);			
			$this->seller_model->commonDelete(SHOP_SECTION_LIST,$CondArr);
			$this->setErrorMessage('success','Successfully deleted the section "'.$name.'"');
			redirect('site/shop/load_shop_sections');		
				       			
		}
		
	}
	
	/*
	* 
	* Edit the shop section 
	* 
	*/
	public function edit_shop_section(){
		if ($this->checkLogin('U')!='')
		{
			$checkloginIDarr=$this->session->all_userdata(); 
			$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];
			
			$section=$this->input->post('section');
			$name=$this->input->post('name');
			if($name.trim()==''){
				$this->setErrorMessage('error','Section name cannot be empty');
				redirect('site/shop/load_shop_sections');
			}
			$dataArr = array('section_name' => $name);
			$condition=array('seller_id' => $loggeduserID,'id' => $section);
			$this->seller_model->shopSectionUpdate(SHOP_SECTION_LIST,$condition,$dataArr);
			#echo $this->db->last_query(); die;
			$this->setErrorMessage('success','Successfully Updated the section "'.$name.'"');
			redirect('site/shop/load_shop_sections');		
				       			
		}
		
	}
	
	/*
	* 
	* Edit the shop section List
	* 
	*/
	public function edit_shop_sections_list(){
		if ($this->checkLogin('U')!='')
		{
			$checkloginIDarr=$this->session->all_userdata(); 
			$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];
			$condition=array('seller_id' => $loggeduserID); 
			$Seller_details=$this->seller_model->get_sellers_data(SELLER,$condition);
			$seourl=$Seller_details[0]['seourl'];
			
			$old_sec_id=$this->input->post('old_sec_id');
			$old_sec_prod=$this->input->post('old_sec_prod');
			$old_sec_count=$this->input->post('old_sec_count');
			
			$new_sec_id=$this->input->post('new_sec_id');
			$new_sec_prod=$this->input->post('new_sec_prod');
			$new_sec_count=$this->input->post('new_sec_count');
			
			if($old_sec_id!='All')
			{
				/*Get the Existing products in new Section List*/
				$newList= $this->product_model->get_all_details(SHOP_SECTION_LIST,array('seller_id' => $loggeduserID,'section_id' => $new_sec_id))->result_array();
				$new_sec_prod.=$newList[0]['product_id'];
				$new_sec_count=$new_sec_count+$newList[0]['shop_prod_count'];
				$dataArr = array('product_id' => $old_sec_prod,'shop_prod_count'=>$old_sec_count);
				$condition=array('seller_id' => $loggeduserID,'section_id' => $old_sec_id);
				$this->seller_model->shopSectionUpdate(SHOP_SECTION_LIST,$condition,$dataArr);
				#Update product into new list			
				$dataArr = array('product_id' => $new_sec_prod,'shop_prod_count'=>$new_sec_count);
				$condition=array('seller_id' => $loggeduserID,'section_id' => $new_sec_id);
				$this->seller_model->shopSectionUpdate(SHOP_SECTION_LIST,$condition,$dataArr);
			}
			else
			{
				$prod=explode(',',$new_sec_prod);
				$newProd=explode(',',$new_sec_prod);
				for($i=0;$i<count($prod)-1;$i++)
				{
					$oldList= $this->product_model->shop_section_list_exist($loggeduserID,$prod[$i]);
					$old_sec_prod=str_replace($prod[$i].',','',$oldList[0]['product_id']);
					$old_sec_count=$oldList[0]['shop_prod_count']-1;
					$dataArr = array('product_id' => $old_sec_prod,'shop_prod_count'=>$old_sec_count);
					$condition=array('seller_id' => $loggeduserID,'section_id' => $oldList[0]['section_id']);
					$this->seller_model->shopSectionUpdate(SHOP_SECTION_LIST,$condition,$dataArr);
					/*Get the Existing products in new Section List*/
					$newList= $this->product_model->get_all_details(SHOP_SECTION_LIST,array('seller_id' => $loggeduserID,'section_id' => $new_sec_id))->result_array();
					$new_sec_prod=$newList[0]['product_id'].$newProd[$i].',';
					$new_sec_count=$newList[0]['shop_prod_count']+1;
					#Update product into new list			
					$dataArr = array('product_id' => $new_sec_prod,'shop_prod_count'=>$new_sec_count);
					$condition=array('seller_id' => $loggeduserID,'section_id' => $new_sec_id);
					$this->seller_model->shopSectionUpdate(SHOP_SECTION_LIST,$condition,$dataArr);
				}
			}
			/*$this->setErrorMessage('success','Successfully moved "'.$new_sec_count.'" listing');
			redirect('shops/'.$seourl.'/sections/'.$new_sec_id);	*/	
		}
		
	}

	/*
	* 
	* Add product preview listing page
	* param String $seourl
	* 
	*/
	public function Preview($seourl){
		if ($this->checkLogin('U')!='' || $this->checkLogin('A')== 1){
			$dataArr=$this->data['preview_item_detail']=$this->product_model->get_all_details(PRODUCT,array('seourl'=>$seourl))->result_array();     
			$variation=$this->product_model->get_subproductdetail_Group(SUBPRODUCT,array('product_id'=> $this->data['preview_item_detail'][0]['id']),'attr_name');
	        $this->data['added_item_details']=$dataArr;
			if(count($variation)==0)
			{
				$this->data['variations_one']="";
				$this->data['variations_two']="";
			}
			if(count($variation)==1)
			{
				$this->data['variations_one']=$variation[0]['attr_name'];
				$this->data['variations_two']="";
				$this->data['variations_one_values']=$this->product_model->get_all_details(SUBPRODUCT,array('product_id'=> $this->data['preview_item_detail'][0]['id'],'attr_name'=>$variation[0]['attr_name']))->result_array();
			}
			if(count($variation)==2)
			{
				$this->data['variations_one']=$variation[0]['attr_name'];
				$this->data['variations_two']=$variation[1]['attr_name'];
				$this->data['variations_one_values']=$this->product_model->get_all_details(SUBPRODUCT,array('product_id'=> $this->data['preview_item_detail'][0]['id'],'attr_name'=>$variation[0]['attr_name']))->result_array();
				$this->data['variations_two_values']=$this->product_model->get_all_details(SUBPRODUCT,array('product_id'=> $this->data['preview_item_detail'][0]['id'],'attr_name'=>$variation[1]['attr_name']))->result_array();
			}
			$this->data['shipping_details']=$this->seller_model->get_all_details(SUB_SHIPPING,array('product_id'=> $this->data['preview_item_detail'][0]['id']))->result_array();
			#echo "<pre>"; print_r($this->data['shipping_details']); die;
 			$this->data['selectedSeller_details']=$this->seller_model->get_sellers_data(SELLER,array());	
			$this->load->view('site/shop/listitem_preview',$this->data);
		}			
	}
	
	/*
	* 
	* Check the shop name duplicate function 
	* 
	*/
 function Load_ajax_shopName_check(){  
 //echo $this->input->get('s_name').'ccc'; die;
	 if($this->input->get('s_name') != ''){
	 $getShopname=$this->seller_model->get_shop_name($this->input->get('s_name'));
		 if($getShopname->num_rows() == 0) {
			 echo 'not exist';
		 } else {
		    echo 'exist';
		 }
	 }
 }
 
	/*
	* 
	* Check the ajax gift card status
	* 
	*/
  function ajax_gift_card_status(){  
	 if($this->input->get('status') == 1){
		$status='Yes';
	 } else {
		$status='No';
	 } 
	 $this->seller_model->update_details(SELLER,array('gift_card'=>$status),array('seller_id'=>$this->input->get('sell_id')));	 
	 
  }
  
  
	/*
	* 
	* Promote Shop in Shopsy
	* 
	*/
  public function promote_shop(){
		if ($this->checkLogin('U') == ''){
			redirect('login');
		}else {
		
		$checkloginIDarr=$this->session->all_userdata(); 
		$loggeduserID=$checkloginIDarr['shopsy_session_user_id'];		   
		$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
		$this->data['Seller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);

		
		$this->data['userIdVal']=$loggeduserID;
		$this->data['countryList'] = $this->product_model->get_all_details(COUNTRY_LIST,array(),array(array('field'=>'name','type'=>'asc')))->result();
		$this->data['selectUser_details']=$this->seller_model->get_all_details(USER,array('id'=>$loggeduserID))->result_array();
		//echo '<pre>'; print_r($this->data['selectUser_details']);die;
		
		$this->data['selectUser_details']=$this->seller_model->get_all_details(USER,array('id'=>$loggeduserID))->result_array();
			$this->data['shopproductfeed_details']=$shopproductfeed_details = $this->seller_model->get_shopproductfeed_details($loggeduserID)->result();
			
			if($this->data['selectSeller_details'][0]['seller_businessname']!=""){
				$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
				#$this->data['shopDetail'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result_array();	
				$product_list=$shop_sec['product_id'];
				$condition1 = " where (u.group='User' or u.group='Seller') and u.status='Active' and p.user_id=".$loggeduserID." or p.user_id=".$loggeduserID." group by p.id order by p.created desc";
		
				$this->data['shopDetail'] =$this->product_model->view_product_details_from_section($condition1)->result_array();				 	  
				$cond=array('seller_id' => $loggeduserID); 
				$this->data['product'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID))->result_array();
				$this->data['Paidproduct'] = $this->product_model->get_all_details(PRODUCT,array('user_id' => $loggeduserID,'pay_status'=>'Paid'));
				$this->data['shop_section_details']=$this->seller_model->getShopSectionDetails($loggeduserID);
				$this->data['shop_section_count']=count($this->data['shop_section_details']);
					
				$this->data['meta_title'] = $this->data['heading'] = 'Promote Shop';
		}
		
			   
			$this->data['heading'] = 'Promote Shop';  
			$this->load->view('site/shop/promote_shop',$this->data);
			
		}
	}
	
	/*
	* 
	* insert / update the shop banner
	* 
	*/
	public function insertShopBanner(){
		if ($this->checkLogin('U') == ''){
			redirect('login');
		}else {			
			
			//$config['encrypt_name'] = TRUE;
			$config['overwrite'] = FALSE;
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
			$config['max_size'] = 10000;
			$config['upload_path'] = './images/banner';
			$this->load->library('upload', $config);
			if ( $this->upload->do_upload('image')){
				$imgDetails = $this->upload->data();
				$ImageName = $imgDetails['file_name'];
				$this->ImageResizeWithCrop(1400, 400, $imgDetails['file_name'], './images/banner/');
			}else{
				$imgDetails = $this->upload->display_errors();
				$this->setErrorMessage('error',strip_tags($imgDetails));
				redirect('site/shop/promote_shop');
			}
			$dataArr = array('seller_banner' => $ImageName);
				$condition=array('seller_id'=>$this->checkLogin('U'));
				$this->seller_model->update_details(SELLER,$dataArr,$condition);	
				$this->setErrorMessage('success','Banner Updated successfully for your shop');
						
			redirect('site/shop/promote_shop');
		}
	}
	
	/*
	* 
	* Change the shop as featured or not using ajax
	* 
	*/
	function change_featuredShop_ajax(){
		if($this->input->get('fstatus') == '1'){
			$status='Yes';
		}else {
		  $status='No';
		}
	$this->seller_model->update_details(SELLER,array('featured_shop' => $status),array('seller_id' => $this->input->get('shop_id')));
	echo $this->db->last_query();
	}
	
	/*
	* 
	* Display the shop favorites
	* param String $seourl
	* 
	*/
	public function display_shop_favoriters($seourl){
	
		$this->data['shopInfo']=$shopInfo=$this->seller_model->get_shop_owner_detail($seourl)->result_array();
		$this->data['favUserList']=$favUserList=$this->product_model->getShopFavDetails($shopInfo[0]['seller_id']);
		#echo $this->db->last_query(); die;
		#echo "<pre>"; print_r($shopInfo); die;
		if (count($favUserList)>0){
			foreach ($favUserList as $favUser){
				$this->data['favoritersUserfavDetails'][$favUser['user_id']] = $this->user_model->get_userfav_products($favUser['user_id']);
				$this->data['favoritersUserfavProdDetails'][$favUser['user_id']] = $this->user_model->get_userfav_products($favUser['user_id'])->result_array();
			}
		}
		#echo "<pre>"; print_r($this->data['favoritersUserfavDetails']);die;
		$condition = array('id'=>$this->checkLogin('U'));
		$this->data['userProfileDetails'] = $this->product_model->get_all_details(USERS,$newdata,$condition)->result_array();
		$this->data['title'] = 'People who have favorited '.$prodInfo[0]->product_name.' by '.$prodInfo[0]->shop_name.' - '.$this->config->item('meta_title');
		$this->data['meta_title'] ='People who have favorited '.$prodInfo[0]->product_name.' by '.$prodInfo[0]->shop_name.' - '.$this->config->item('meta_title');	
		$this->data['meta_description'] =$currentcatDetails->seo_description;   	
		
		$this->load->view('site/shop/shop_favorites',$this->data);
	}
	
	
	/*
	* 
	* Report insert function
	* 
	*/
	public function reportReview(){
		if ($this->checkLogin('U') != ''){
			#echo ""; print_r($_POST); die;
			$this->user_model->commonInsertUpdate(REPORT_REVIEW,'insert',array(),array(),'');
			$this->setErrorMessage('success','Your Report has been submitted Successfully!.');
			redirect('shop/reviews');
		}
	}
	
	/*
	* 
	* Check the ajax shop banner size using ajax
	* 
	*/
	public function ajax_check_shop_mainBanner_size(){
		
		if($this->input->post('shop-banner') == 'shop-banner-img') {
			//list($w, $h) = getimagesize($_FILES["shop_banner"]["tmp_name"]);
			list($w, $h) = getimagesize($_FILES["file"]["tmp_name"]);
			if($w >= 760 && $h >= 100){
			echo 'Success';
			} else {
			echo 'Error';
			}
		}else {
	        list($w, $h) = getimagesize($_FILES["image"]["tmp_name"]);
			if($w >= 1400 && $h >= 400){
			echo 'Success';
			} else {
			echo 'Error';
			}
		}
	}
	


	
	/*
	* 
	* Display the shop transaction 
	* 
	*/
	public function display_shop_transaction(){
		if ($this->checkLogin('U') == ''){
			redirect('login');
		}else {
			$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
			$this->data['heading'] = 'Shop Tranactions';
			$shop_id = $this->checkLogin('U');		
			$this->data['shop_trans_details'] = $this->seller_model->getShopTransactionDetails($shop_id);
			$this->load->view('site/shop/display_shop_tranaction',$this->data);
		}
	}
	
	
	/*
	* 
	* Display the shop orders 
	* 
	*/
	public function display_shop_orders(){

		if ($this->checkLogin('U') == ''){
			redirect('login');
			exit(0);
		}

		$this->data['heading'] = 'Shop Orders';
		$user_id = $this->checkLogin('U');
		$this->data['shop'] = $this->db->select('id as shop_id, seller_businessname, seourl')->from('shopsy_seller')
						 ->where( array('seller_id' => $user_id) )
						 ->get()->first_row();

		$status = '';
		$this->data['tab_name'] = $_GET['tab_name'];
		
		$fro = $_GET['from'];
		if($fro!=''){
			$from = date("Y-m-d H:i:s", strtotime($fro));
		}else{
			$from = '';
		}
		
		$t = $_GET['to'];
		if($t !=''){
			$to = date("Y-m-d H:i:s", strtotime($t));
		}else{
			$to = '';
		}
		
		$id = $_GET['id'];
		
		if ( $this->data['tab_name'] == '' ) {
			$this->data['orders'] = $this->db->select('op.*,o.date_added,o.shipping_firstname,o.total,os.order_status_name')->from('sa_order_product op')
											 ->join('sa_order o', 'o.order_id =  op.order_id', 'left' )
											 ->join('sa_order_status os', 'os.order_status_id = o.order_status_id', 'left')
											 ->where( array('op.store_id' => $this->data['shop']->shop_id ) )
											 ->where( array( 'o.order_status_id' => 1 ) )
											 ->order_by('o.date_added desc')
											 ->get()->result_array();
		}

		if ( $this->data['tab_name'] == 'Shipped' ) {
			$this->data['orders'] = $this->db->select('op.*,o.date_added,o.shipping_firstname,o.total,os.order_status_name')->from('sa_order_product op')
											 ->join('sa_order o', 'o.order_id =  op.order_id', 'left' )
											 ->join('sa_order_status os', 'os.order_status_id = o.order_status_id', 'left')
											 ->where( array('op.store_id' => $this->data['shop']->shop_id ) )
											 ->where( array( 'o.order_status_id' => 3 ) ) //shipped
											 ->order_by('o.date_added desc')
											 ->get()->result_array();
		}

		if ( $this->data['tab_name'] == 'Cancelled' ) {
			$this->data['orders'] = $this->db->select('op.*,o.date_added,o.shipping_firstname,o.total,os.order_status_name')->from('sa_order_product op')
											 ->join('sa_order o', 'o.order_id =  op.order_id', 'left' )
											 ->join('sa_order_status os', 'os.order_status_id = o.order_status_id', 'left')
											 ->where( array('op.store_id' => $this->data['shop']->shop_id ) )
											 ->where( array( 'o.order_status_id' => 9 ) ) //shipped
											 ->order_by('o.date_added desc')
											 ->get()->result_array();
		}
		if ( $this->data['tab_name'] == 'returns' ) {
			$this->data['returns'] = $this->db->select( 'r.*' )
											  ->from('sa_order_return r')
											  ->where( array('store_id' => $this->data['shop']->shop_id ) )
											  ->order_by( 'r.rma_id desc' )
											  ->get()->result_array();
		}
		
		//$this->load->view('site/shop/display_shop_orders',$this->data);
		$this->load->view('site/seller/merchant_orders',$this->data);
			
	}
	
	
	
	/*
	* 
	* Update the shop order status
	* 
	*/
	public function shoporder_update(){
		if ($this->checkLogin('U')==''){
			redirect('login');
		}else {
			$dealCode = $this->input->post('dealCodeNumber');
			
			$shipping_status = $this->input->post('shipping_status');
			$dataArr = array('shipping_status'=>$shipping_status);	

			if($shipping_status == 'Delivered'){
				$check = "select * from ".USER_PAYMENT." where sell_id=".$this->checkLogin('U')." and dealCodeNumber ='".$dealCode."' GROUP BY dealCodeNumber";
				$checkstatus = $this->order_model->ExecuteQuery($check)->first_row();
				if($checkstatus->payment_type == 'COD' || $checkstatus->payment_type == 'wire_transfer'|| $checkstatus->payment_type == 'western_union'){
					$dataArr['status'] = 'Paid';
				}
				$dataArr['received_status'] = 'Product received';
			}
			
			$shippingMessage = $this->input->post('shippingMessage');
			if(isset($shippingMessage) && $shippingMessage != ''){
				$dataArr['statusMessage'] = $shippingMessage;
			}
				
			$shippingId = $this->input->post('trackingId');
			if(isset($shippingId) && $shippingId != ''){
				$dataArr['trackingId'] = $shippingId;
			}
				
			$refund = $this->input->post('refund_msg');
			if(isset($refund) && $refund != ''){
				$dataArr['statusMessage'] = $refund;
			}
				
			$estdate = $this->input->post('eventDate');
			if(isset($estdate) && $estdate != ''){
				$dataArr['estDate'] = $estdate;
			}
				
			$condition=array('dealCodeNumber'=>$dealCode);
			$order_details = $this->order_model->update_details(USER_PAYMENT,$dataArr,$condition);
			
			//echo $this->db->last_query();
			
			$orderDetails = $this->order_model->get_all_details(USER_PAYMENT,$condition);
				
			$buyerDetails = $this->order_model->get_all_details(USERS,array('id'=>$orderDetails->row()->user_id));
				
			$sellerDetails = $this->order_model->get_all_details(USERS,array('id'=>$orderDetails->row()->sell_id));
				
			$newsid='35';
				
			$orderid = $dealCode;
			$orderstatus = $shipping_status;
			$content .="";
				
			$content .= "comment : ".$orderDetails->row()->statusMessage."<br>";
				
			if($shipping_status == Shipped){
				$content = 	"Estimated Delivery Date : ".$orderDetails->row()->estDate."<br>".
						"Shiping Id : ".$orderDetails->row()->trackingId."<br>";
			}
				
			$sender_email = $sellerDetails->row()->email;
			$receive_email =  $buyerDetails->row()->email;
			$cc_mail_id = $this->data['siteContactMail'];
				
			$template_values=$this->order_model->get_newsletter_template_details($newsid);
			$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
			
			//$discussionurl = base_url().'discussion/'.$orderid;
			$viewurl = base_url().'view-order-pre/'.$orderDetails->row()->user_id.'/'.$orderid;
			
			$adminnewstemplateArr=array('email_title'=> $this->config->item('email_title'),'logo'=> $this->data['logo'],'footer_content'=> $this->config->item('footer_content'),'orderid'=>$orderid,'orderstatus'=>$orderstatus,'content' => $content,'viewurl'=>$viewurl);
			
			extract($adminnewstemplateArr);
			$header .="Content-Type: text/plain; charset=ISO-8859-1\r\n";
			
			$message .= '<!DOCTYPE HTML>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width"/><body>';
			include('./newsletter/registeration'.$newsid.'.php');
			$message .= '</body>
		</html>';
			$email_values = array('mail_type'=>'html',
					'from_mail_id'=>$sender_email,
					'to_mail_id'=>$receive_email,
					'cc_mail_id'=>$cc_mail_id,
					'bcc_mail_id'=>$sender_email,
					'subject_message'=>$subject,
					'body_messages'=>$message
			);
			/*echo $header;
			 echo $message; exit;*/
			//echo '<pre>'; print_r($email_values);	die;
			$email_send_to_common = $this->order_model->common_email_send($email_values);
			
			if($order_details){
				$this->setErrorMessage('success','Order Status Updated Successfully');
				//echo 'Success';
				redirect('shops/'.$this->data['selectSellershop_details']['0']['seourl'].'/shop-orders');
				
			}else{
				$this->setErrorMessage('error','Order Status Updated Failed');			
				//echo 'error';
				redirect('shops/'.$this->data['selectSellershop_details']['0']['seourl'].'/shop-orders');
				
			}
		}
	}
	
	
	/*
	* 
	* View the particular order for shop 
	* 
	*/
	public function vieworder(){
		if ($this->checkLogin('U') == ''){
			redirect('login');
		}else {
			$this->data['heading'] = 'View Order';
			$user_id = $this->uri->segment(4,0);
			$deal_id = $this->uri->segment(5,0);
			
			if($this->checkLogin('U')!=""){
				$activity_id=$deal_id;
				$this->product_model->ExecuteQuery("UPDATE ".NOTIFICATIONS." SET `view_mode` = 'No' WHERE user_id =".$user_id." AND activity_id=".$activity_id." AND (activity='order')");
			}
			#print_r( $this->db->last_query()); die;
			$this->data['ViewList'] = $this->order_model->view_orders($user_id,$deal_id);
			$this->load->view('admin/order/view_orders',$this->data);
		}
	}
	
	/*
	* 
	* Display the shop product listings 
	* 
	*/
	public function manageListings() {
									   
		if ($this->checkLogin('U') == ''){
			redirect('login');
		} else {
			$this->data['heading'] = 'Manage Listings';
			
			$filter_status = $this->input->post('filter_status');
			$filter_status = $filter_status == '' ? 'Publish' : $filter_status; 

			$page_no = $this->input->post('page_no');
			$page_size = 25;
			if( $page_no <= 0 ) $page_no = 0;
			$start = $page_no * $page_size;
			
			$this->data['shop'] = $this->db->select('*')->from(SELLER)
										   ->where( array('seller_id' => $this->checkLogin('U')) )
										   ->get()->first_row();

			$this->data['total_products'] = $this->db->select('count(*) as total')
													 ->from('shopsy_product')
													 ->where( array('store_id' =>  $this->data['shop']->id ) )
													 ->where( array('status' => $filter_status ) )
													 ->get()->first_row()->total;
			$total_pages = ( $this->data['total_products'] == 0 ? 0 : $this->data['total_products'] / $page_size) ;
			
			$this->data['products'] = $this->db->select('p.id, p.product_name, p.seourl,p.image, p.price, p.product_featured, p.quantity,p.status, c.cat_name')
											   ->from('shopsy_product p')
											   ->join('shopsy_category c', 'c.id = p.category_id', 'left' )
											   ->where( array('p.store_id' =>  $this->data['shop']->id, 'p.status' => $filter_status ) )
											   ->limit($page_size, $start)
											   ->get()->result_array();
											   
			$this->data['page_no'] = $page_no;
			$this->data['total_pages'] = $total_pages;
			$this->data['filter_status'] = $filter_status;
			$this->load->view('site/shop/manage_listings',$this->data);
		}
	}
	
	/*
	* 
	* Add the bill address using ajax
	* 
	*/
	function addBillingAjax(){
		$loginUserId = $this->checkLogin('U');
		$condition =array('id' => $loginUserId);
		$dataArr = array('full_name'=>$this->input->post('full_name'),'address'=>$this->input->post('street'),'city'=>$this->input->post('city'),'state'=>$this->input->post('state'),'country'=>$this->input->post('country'),'postal_code'=>$this->input->post('postalcode'),'phone_no'=>$this->input->post('phone'));
		$this->order_model->update_details(USERS,$dataArr,$condition);
	}
	
	/*
	* 
	* Display the Commision tracking for shop
	* 
	*/
	public function display_commision_log(){
		if ($this->checkLogin('U') == ''){
			redirect('login');
		}else {
			$this->data['heading'] = 'Commision Log';
			$this->data['user_details']=$this->seller_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));		
			$this->data['commision_log']=$this->seller_model->get_all_details(VENDOR_PAYMENT,array('vendor_id'=>$this->checkLogin('U'),'status'=>'success'));	
			$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);
			$this->load->view('site/shop/display_commision_log',$this->data);
		}
	}
	
	/*
	* 
	* send withdraw request for shop
	* 
	*/
	public function send_withdraw_req(){
		if ($this->checkLogin('U') == ''){
			redirect('login');
		}else {
			$this->data['heading'] = 'Withdrawal Request';			
			$shop_id = $this->checkLogin('U');	
			$this->data['selectSeller_details']=$this->seller_model->get_sellers_data(SELLER,$condition);			
			$this->data['user_details']=$this->seller_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
			$this->data['orderDetails'] = $this->seller_model->get_total_order_amount($this->checkLogin('U') )->result();
			$this->data['orderDetails1'] = $this->seller_model->get_total_order_amounts($this->checkLogin('U') )->result();//site earnings
			$this->data['disputeDetail'] = $this->seller_model->get_dispute_order_amount($this->checkLogin('U'))->result();// dispute amount
			$this->data['codorder'] = $this->seller_model->get_cod_order_amount($this->checkLogin('U') )->result();	
			$this->data['claim_amt']=$this->seller_model->get_claim_amount($this->checkLogin('U'))->result();
			$this->data['paidDetails'] = $this->seller_model->get_total_paid_details($this->checkLogin('U') )->result();
			$this->load->view('site/shop/withdraw_req',$this->data);
		}
	}
	
	/*
	* 
	* send withdraw request for shop
	* 
	*/
	public function send_withdraw(){
		//error_reporting(-1);
		if ($this->checkLogin('U') == ''){
			redirect('login');
		}else {
			$condition =array('id' => $this->checkLogin('U'));
			$withdraw_amt=$this->input->post('withdraw_amt');
			if($withdraw_amt<=0){
				$this->setErrorMessage('error','Enter the requested amount as greater than zero');
				redirect($_SERVER['HTTP_REFERER']);
			}else if($withdraw_amt > $this->input->post('balance_amt')){
				$this->setErrorMessage('error','Enter the requested amount Less than Balance Amount');
				redirect($_SERVER['HTTP_REFERER']);
			}
			$default_cur_get=$this->seller_model->get_all_details(CURRENCY,array('default_currency'=>'Yes','status'=>'Active'));
			$user_cur_get=$this->seller_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
			$default_cur=$default_cur_get->row()->currency_code;
			$user_cur=$user_cur_get->row()->currency;
			#echo $default_cur. "  user_cur ".$user_cur;die;
			if($default_cur!=$user_cur)	{		
				$curval=$this->data['currencyValue'];
				$withdraw_amt=$withdraw_amt/$curval;
			}  else {
				$withdraw_amt=$withdraw_amt;
				$curval=1;
				$curCurency=1;
			}
			$dataArr = array('send_req'=>'Yes','withdraw_amt'=>$withdraw_amt);		
			
			//print_r($dataArr);
			$this->seller_model->update_details(USERS,$dataArr,$condition);
			//echo $this->db->last_query();die;
			$this->send_withdraw_requestMail();
			$this->setErrorMessage('success','Your Request Sended Successfully');
			redirect("shop/sell");
		}
	}
	
	/*
	* 
	* sending mail for withdraw request for shop
	* 
	*/
	public function send_withdraw_requestMail(){
		$user_details=$this->seller_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
		$user_name=$user_details->row()->user_name;
		$withdraw_amt=$user_details->row()->withdraw_amt;
		$email=$user_details->row()->email;
		$full_name=$user_details->row()->full_name.' '.$user_details->row()->last_name;
			$newsid='2';
			$template_values=$this->product_model->get_newsletter_template_details($newsid);
			$adminnewstemplateArr=array('logo'=> $this->data['logo'],'user_name'=>$user_name,'footer_content'=> $this->config->item('footer_content'),'email_title'=> $this->config->item('email_title'));
			extract($adminnewstemplateArr);
			$subject = $template_values['news_subject'].' '.$this->config->item('email_title');
			$message .= '<!DOCTYPE HTML>
					<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<meta name="viewport" content="width=device-width"/>
					<title>'.$adminnewstemplateArr['meta_title'].' - Share Things</title>
					<body>';
			include('./newsletter/registeration'.$newsid.'.php');	
							
			$message .= '</body>
					</html>';
			if($template_values['sender_name']=='' && $template_values['sender_email']==''){
				$sender_email=$this->config->item('site_contact_mail');
				$sender_name=$this->config->item('email_title');
			}else{
				$sender_name=$template_values['sender_name'];
				$sender_email=$template_values['sender_email'];
			}
			
			$email_values = array('mail_type'=>'html',
								'from_mail_id'=>$email,
								'mail_name'=>$full_name,		
								'to_mail_id'=>$sender_email,
								'subject_message'=>$subject,
								'body_messages'=>$message
								);
			#echo "<pre>"; print_r($email_values); #die;
			$email_send_to_common = $this->product_model->common_email_send($email_values);
		}
		
		public function gcard_status_change(){
			$seller_id=$this->checkLogin('U');
			$status=$this->input->post('status');
			$this->product_model->update_details(SELLER,array('gift_card'=>$status),array('seller_id'=>$seller_id));
			//echo $this->db->last_query(); die;
			echo "Success";
		}
		
		public function plans( $plan = 0 ) {
			if( $plan != 0 && $this->input->post('btn-submit') == '' ) {
				$this->data['plan'] = $plan;
				$this->data['store_name'] = '';
				$this->data['full_name'] = '';
				$this->data['phone_number'] = '';
				$this->data['email'] = '';
				$this->load->view('site/shop/merchant_register.php',$this->data);
				exit(0);
			}
			
			//Register shop
			if ( $this->input->post('btn-submit') != '' ) {
				$shop_email = $this->input->post('email');
				$email_qry = $this->db->select('email')->from('shopsy_users')->where( array('email' => $shop_email) )->get();
				$isValid = true;
				if ( $email_qry->num_rows() ) {
					$isValid = false;
				}
				if ( ! $isValid ) {
					$this->data['error_email'] = "Email already registered!";
					$this->data['store_name'] = $this->input->post('store_name');
					$this->data['full_name'] = $this->input->post('full_name');
					$this->data['phone_number'] = $this->input->post('phone_number');
					$this->data['email'] = $this->input->post('email');
					$this->data['plan'] = $plan;
					$this->load->view('site/shop/merchant_register.php',$this->data);
					exit(0);
				}
				
				$admin_settings = $this->db->select('site_contact_mail, logo_image')->from('shopsy_admin_settings')
									   ->where( array('id' => 1) )->get()
									   ->first_row();
				$logo_image = $admin_settings->logo_image;
				$from_email = $admin_settings->site_contact_mail;
				$from_name = "Admin";
				$code = md5(uniqid(rand()));
				$data = array( 
					'plan' => $plan,
					'store_name' => $this->input->post('store_name'),
					'full_name' => $this->input->post('full_name'),
					'phone_number' => $this->input->post('phone_number'),
					'email' => $this->input->post('email'),
					'pass_code' => $this->input->post('pass_code'),
					'confirm_code' => $code
				);
				
				$this->db->insert('sa_shop_temp_registration', $data );
				$registration_id =  $this->db->insert_id();
				$url = base_url().'site/shop/confirmation'.'?param1='.base64_encode($registration_id).'&param2='.$code;
				
				$this->load->library('email');
				$this->email->from( $from_email, $from_name );
				$this->email->to( $shop_email );
				//$this->email->set_header('useragent', 'Vistashops');
				$this->email->set_mailtype('html');
				//{unwrap}http://example.com/a_long_link_that_should_not_be_wrapped.html{/unwrap}
				$email_body = $this->db->select('template_content')->from('sa_email_templates')
									->where( array( 'template_name' => 'shop_registration' ) )
									->get()->first_row()->template_content;
				$subject = "Shop Registration confirmation";
				
				$email_body = str_replace( '{LOGO}', $logo_image, $email_body );
				$email_body = str_replace( '{STORE_NAME}', $this->input->post('store_name'), $email_body );
				$email_body = str_replace( '{URL}', $url, $email_body );
				
				$this->email->subject( $subject );
				$this->email->message( $email_body );
				if( $this->email->send() ) {
					redirect('site/shop/merchant_register_thanks');
				} else{
					redirect('site/shop/merchant_register_thanks');
				}
				
			}
			
			//$this->data['logo'] = $this->db->select('logo_image')->from('shopsy_admin_settings')->where( array('id' => 1))
										   //->get()->first_row()->logo_image;
			$this->load->view('site/shop/merchant_plans.php',$this->data);
		}
		
		public function merchant_register_thanks() {
			$this->load->view('site/shop/merchant_register_thanks.php',$this->data);
			exit(0);
		}
		
		public function confirmation() {
			$register_id = $this->input->get('param1');
			$code = $this->input->get('param2');
			$registration = $this->db->select('*')->from('sa_shop_temp_registration')->where( array( 'register_id' => base64_decode( $register_id ), 'confirm_code' => $code ) )
									 ->get();
			if ( $registration->num_rows ) {
				$shop = $registration->first_row();
				$data = array(
					'send_req' => 'No',
					'full_name' => $shop->full_name,
					'user_name' => url_title($shop->store_name, '-', TRUE),
					'last_name' => '',
					'group' => 'Seller',
					'email' => $shop->email,
					'password' => md5( $shop->pass_code ),
					'status' => 'Active',
					'is_verified' => 'Yes',
					'modified' => date('Y-m-d H:i:s')
				);
				$this->db->insert('shopsy_users', $data);
				$user_id = $this->db->insert_id();
				if( $shop->plan == 1 ) $plan = 'STARTER';
				if( $shop->plan == 2 ) $plan = 'PRO';
				if( $shop->plan == 3 ) $plan = 'ELITE';
				if( $shop->plan == 4 ) $plan = 'ENTERPRISE';

				$data = array(
					'seller_id' => $user_id,
					'seller_businessname' => $shop->store_name,
					'seller_email' => $shop->email,
					'seourl' => url_title($shop->store_name, '-', TRUE),
					'status' => 'inactive',
					'membership_expiry' => date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day")),
					'plan_subscription' => $plan,
					'created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('shopsy_seller', $data );
				$from_email = 'admin@shopsatAvenue.net';
				$from_name = 'Admin';

				$this->db->delete('sa_shop_temp_registration', array( 'register_id' => $shop->register_id ) );
				
				$this->load->library('email');
				$this->email->from( $from_email, $from_name );
				$this->email->to( $shop->email );
				//$this->email->set_header('useragent', 'Vistashops');
				$this->email->set_mailtype('html');
				//{unwrap}http://example.com/a_long_link_that_should_not_be_wrapped.html{/unwrap}
				$email_body = $this->db->select('template_content')->from('sa_email_templates')
									->where( array( 'template_name' => 'shop_registration_thanks' ) )
									->get()->first_row()->template_content;
				$subject = "Shop Registration confirmation";
				$url = base_url() . 'login';
				$email_body = str_replace( '{LOGO}', $logo_image, $email_body );
				$email_body = str_replace( '{STORE_NAME}', $this->input->post('store_name'), $email_body );
				$email_body = str_replace( '{URL}', $url, $email_body );
				$email_body = str_replace( '{EMAIL}', $shop->email, $email_body );
				$this->email->subject( $subject );
				$this->email->message( $email_body );
				if( $this->email->send() ) {
					$sent = true;
				} else{
					$sent = false;
				}
				$this->data['confirmation'] =  array(
				   'store_name' => $this->input->post('store_name'),
				   'email' => $shop->email
				);
			} else {
				$this->data['confirmation'] = array(
				    'failed' => 1
				);
			}
			$this->load->view('site/shop/merchant_register_thanks.php',$this->data);
			
		}
		
		public function sales_setting() {
			if( $this->session->userdata['userType'] != 'Seller' ) {
				redirect( base_url() );
				exit(0);
			}

			$this->data['max_discount'] = (int) $this->db->select('max_discount')->from('shopsy_seller')->where( array('seller_id' => $this->checkLogin('U')) )->get()->first_row()->max_discount;
			
			$this->load->view('site/shop/store_discount.php',$this->data);
		}
		
		function save_max_discount() {
			$json = array();
			if( $this->session->userdata['userType'] != 'Seller' ) {
				$json = array('status' => 'error', 'message' => 'You don\'t have access to this!');
				echo json_encode( $json );
				exit(0);
			}
			
			$max_discount = (int) $this->input->post('max_discount');
			$ret_value = $this->seller_model->ExecuteQuery( "UPDATE shopsy_seller SET max_discount = '" . $max_discount . "' WHERE seller_id = '". $this->checkLogin('U') . "' " );
			//$this->db->update( 'shopsy_seller', array('max_discount' => $max_discount ), array('seller_id' => $this->session->user_data['shopsy_session_user_id']) );
			if ( $ret_value ) {
				$json = array('status' => 'success', 'message' =>  'Max. Discount update successful!' );
			} else {
				$json = array('status' => 'error', 'message' => 'Update Failed!' );
			}
			echo json_encode( $json );
			
		}
		
		function merchant_home() {
			if( $this->session->userdata['userType'] != 'Seller' ) {
				redirect( base_url() );
				exit(0);
			}
			
			$user_id = $this->checkLogin('U');
			$shop_id = $this->db->select('id')->from( 'shopsy_seller')->where( array( 'seller_id' => $user_id ) )->get()->first_row()->id;

			$sales_date = date( 'Y-m-d', strtotime( date('Y-m-d') . ' -1 days' ) );
			$sales_qry = $this->db->select('total_sales_amount,total_views, total_likes')->from('saa_shop_sales_history')
								  ->where( array('sales_date' => $sales_date, 'shop_id' => $shop_id) )->get();
			if( $sales_qry->num_rows() ) {
				$this->data['shop'] = $sales_qry->first_row();
			} else {
				$this->data['shop']->total_sales_amount = 0;
				$this->data['shop']->total_views = 0;
				$this->data['shop']->total_likes = 0;
			}
			
			//current pay period
			if ( date('d') < 16 ) {
				$current_start = date('Y-m') . '-01';
				$current_last = date('Y-m') . '-15';
			} else {
				$current_start = date('Y-m') . '-16';
				$current_last = date('Y-m') . '-31';
			}
			
			$current_period_day = date('d') < 16 ? 15 : 31; //period last day
			$current_month = (int) date('m');
			$this->data['sales_current'] = $this->db->select('sum(total_sales_amount) current_period_amount,SUM(total_views) current_period_views, SUM(total_likes) current_period_likes')->from('saa_shop_sales_history')->where( "sales_date BETWEEN  '" . $current_start . "' AND '" . $current_last . "'" )->get()->first_row();

			//Previous pay period
			if ( date('d') < 16 ) {
				$previous_start = date('Y') . '-' . ( date('m') - 1 ). '-16';
				$previous_last = date('Y') . '-' . ( date('m') - 1 ) . '-31';
			} else {
				$previous_start = date('Y-m') . '-01';
				$previous_last = date('Y-m') . '-15';
			}
			$this->data['sales_previous'] = $this->db->select('sum(total_sales_amount) previous_period_amount,SUM(total_views) previous_period_views, SUM(total_likes) previous_period_likes')->from('saa_shop_sales_history')->where( "sales_date BETWEEN  '" . $previous_start . "' AND '" . $previous_last . "'" )->get()->first_row();

			//Top Seller
			$this->data['top_sales'] = $this->db->select('ps.*, p.image, p.product_name')->from('saa_shop_product_sales ps')
								  ->join('shopsy_product p', 'p.id = ps.product_id', 'left')
								  ->where( array('ps.shop_id' => $shop_id ) )->limit(5)->get()->result_array();
			$this->load->view( 'site/seller/merchant_home.php', $this->data );

		}
		function shipstation_help( $product_id = NULL ) {

			if ( $this->checkLogin('U') == '' || $this->session->userdata['userType'] != 'Seller' ){
				$this->setErrorMessage('warning','You are not authorized to access this!');
				redirect( base_url() );
				exit(0);
			}
			$this->load->view( 'site/seller/shipstation_help.php', $this->data );

		}

} 

// Class ends
/*End of file cms.php */
/* Location: ./application/controllers/site/product.php */