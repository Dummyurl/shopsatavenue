<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(E_ALL);
/**
 * 
 * User related functions
 * @author Teamtweaks
 *
 */

class Product extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email','text'));
		$this->load->library(array('encrypt','form_validation','currencyget'));		
		$this->load->model(array('product_model','user_model','seller_model','product_attribute_model','currency_model','multilanguage_model','order_model'));
		$this->load->library("session");
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['AdminloginCheck'] = $this->checkLogin('A');
		$this->data['likedProducts'] = array();
	 	if ($this->data['loginCheck'] != ''){
	 		$this->data['likedProducts'] = $this->product_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
	 	}	 	

    }

	public function get_category_list( ) {

		if($this->checkLogin('U') != '' || $this->checkLogin('A') != '') {

			$cat_id = $this->input->post('cat_id');

			$query_sel =  $this->db->query("SELECT GetCategoryTree(" .$cat_id . ") AS cat_tree FROM shopsy_category WHERE id = " . $cat_id);
			$row = $query_sel->row_array();

			$cat_tree = explode( '^', $row['cat_tree']);
			$cat_ids = explode(',', $cat_tree[0]);
			$cat_names = explode(':', $cat_tree[1]);
			$cat_crumb = '';
			for( $i=count($cat_names)-1; $i >= 0; $i-- ) {
				if ( $cat_crumb != '' ) $cat_crumb .= ' <i class="fa fa-arrow-right"></i> ';
				$cat_crumb .= '<b>' . $cat_names[$i] . '</b>';
			}
			$query_sel = $this->db->query("SELECT id, cat_name FROM shopsy_category WHERE rootID = " . $cat_id );
			$cat_options = '';
			foreach( $query_sel->result_array() as $row_cat ) {
				if( $cat_options == '' ) $cat_options .= '<option value="'.$cat_id.'">Select a category</option>';;
				$cat_options .= '<option value="'. $row_cat['id'] . '">' . $row_cat['cat_name'] . '</option>';
			}
			$json = array (
						'cat_crumb' => $cat_crumb,
						'cat_options' => $cat_options
					);
			//header('Content-Type: application/json');
			echo json_encode(  $json );
			exit(0);
		}
	}

	/**
	 * 
	 * This function add the product
	 * 
	 * return Array
	 */
	public function add_shop_product(){	
		//echo "<pre>"; print_r($_POST); 
		
		if($this->checkLogin('U') != '' || $this->checkLogin('A') == 1){
			
			
			if($this->input->post('price_status') == 1)
			{
				$price = $this->input->post('price');	
			} else {
				$price = '';	
			}
				
			$default_cur_get=$this->product_model->get_all_details(CURRENCY,array('default_currency'=>'Yes','status'=>'Active'));
			$user_cur_get=$this->product_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
			$default_cur=$default_cur_get->row()->currency_code;
			$user_cur=$user_cur_get->row()->currency;
			#echo $default_cur. "  user_cur ".$user_cur;die;
			if($default_cur!=$user_cur)	{		
				$curval=$this->data['currencyValue'];
				#echo $curval;die;
				$curCurency=$this->currencyget->currency_conversion(1,$default_cur,$user_cur);
				$price=$price/$curval;
			}  else {
				$price=$price;
				$curval=1;
				$curCurency=1;
			}
			
			//for multilanguage products
			$tablename = $_POST['tablename'];
			if(isset($tablename)){					
				$dataArr['product_name'] = $_POST['product_name'];
				$dataArr['description'] = $_POST['description'];
				$UPDATE_product_Seourl = $_POST['edit_product_id'];
					
				$this->product_model->update_details($tablename,$dataArr,array('seourl' => $UPDATE_product_Seourl));			
					
				if($this->input->post('AdminEditProduct')=='admin-edit-product'){
					//redirect('admin-preview/'.$UPDATE_product_Seourl);
					if($_POST['redirect_status'] == 'UnPublish'){
						redirect('shop/billing');
					}else{
						redirect('products/'.$UPDATE_product_Seourl);
					}
					
				}else{
					//redirect('preview/'.$UPDATE_product_Seourl);
					if($_POST['redirect_status'] == 'UnPublish'){
						redirect('shop/billing');
					}else{
						redirect('products/'.$UPDATE_product_Seourl);
					}
				}
			}
			
			//for multilanguage products//

	if($this->checkLogin('A') == 1){
		$status="Publish";
		$pay_status='Paid';
	}else if(($this->checkLogin('U')!='') && ($this->input->post('product_edit_status')!='')){
		if($this->input->post('product_edit_status') =='Publish'){
			$status="Publish";
			$pay_status='Paid';
		}else{
			$status="UnPublish";
			$pay_status='Pending';
		}	
	} else {
		$status="UnPublish";
		$pay_status='Pending';
	} 
			
			
			
			if($this->checkLogin('U') != ''){
				$userID=$this->checkLogin('U');
			} else {
				$userID=1;
			}
			
			if($this->config->item('membership') =='Yes'){
				
				$this->db->select("membership_status");
				$this->db->from(SELLER);
				$this->db->where(array("seller_id"=>$userID));
				$SellerList=$this->db->get();
				if($SellerList->row()->member_status==1){
					$status="Publish";
					$pay_status='Paid';	
					$pay_type='Free';
					$pay_date=date("Y-m-d H:i:s");
				}else{
					$pay_type='';
					$pay_date='';
				}			
			}else{
			
				if($this->config->item('product_cost') <= 0.00){
					$status="Publish";
					$pay_status='Paid';
					$pay_type='Free';
					$pay_date=date("Y-m-d H:i:s");#date('Y-m-d');
				}else{
					$pay_type='';
					$pay_date='';
				}
			}			
			if($this->input->post('edit_product_id')==''){
				if($this->input->post('image_upload') == ''){ redirect($_SERVER['HTTP_REFERER']);}
			}
				$dir = getcwd()."/images/product/temp_img/";//dir absolute path
				$interval = strtotime('-24 hours');//files older than 24hours
				foreach (glob($dir."*.*") as $file) 
    			{
    			if (filemtime($file) <= $interval ) {unlink($file);}
				}				
				$dir = getcwd()."/temp_digital_files/";//dir absolute path
				$interval = strtotime('-24 hours');//files older than 24hours
				foreach (glob($dir."*.*") as $file) 
    			{
    			if (filemtime($file) <= $interval ) {unlink($file);}
				}
		
		$UPDATE_product_Seourl =  $this->input->post('edit_product_id');
		$made_by =  $this->input->post('about_item');
		$product_condition = $this->input->post('what_item');
		$maked_on = $this->input->post('when_made');
		$category1 =  $this->input->post('main_cat_id');
		$category_id = $category1;
		if($this->input->post('level1_sub_cat') != ''){
		$category2 =  $this->input->post('level1_sub_cat');
		$category_id.= ','.$category2;
		}
		if($this->input->post('level2_sub_cat') != ''){
		$category3 =  $this->input->post('level2_sub_cat');
		$category_id.= ','.$category3;
		}
		#echo $category_id;die;
		$product_name =  $this->input->post('product_name');		
		if($this->input->post('image_upload')!=''){
			$imgRnew0 = @explode('.',$this->input->post('image_upload'));
			$NewImg0 = url_title($imgRnew0[0], '-', TRUE);
			$image_upload0 = $NewImg0.'.'.$imgRnew0[1];
		}
		
		if($this->input->post('image_upload1')!=''){
			$imgRnew1 = @explode('.',$this->input->post('image_upload1'));
			$NewImg1 = url_title($imgRnew1[0], '-', TRUE);
			$image_upload1 = $NewImg1.'.'.$imgRnew1[1];
		}
		
		if($this->input->post('image_upload2')!=''){
			$imgRnew2 = @explode('.',$this->input->post('image_upload2'));
			$NewImg2 = url_title($imgRnew2[0], '-', TRUE);
			$image_upload2 = $NewImg2.'.'.$imgRnew2[1];
		}
		
		if($this->input->post('image_upload3')!=''){
			$imgRnew3 = @explode('.',$this->input->post('image_upload3'));
			$NewImg3 = url_title($imgRnew3[0], '-', TRUE);
			$image_upload3 = $NewImg3.'.'.$imgRnew3[1];
		}
		
		
		if($this->input->post('image_upload4')!=''){
			$imgRnew4 = @explode('.',$this->input->post('image_upload4'));
			$NewImg4 = url_title($imgRnew4[0], '-', TRUE);
			$image_upload4 = $NewImg4.'.'.$imgRnew4[1];
		}
				
		$timeImg=time();
			if($image_upload0 != '' || $this->input->post('existImage0') != ''){
				if($image_upload0 != ''){
				
					@copy('./images/product/temp_img/'.$image_upload0, './images/product/org-image/'.$timeImg.'-'.$image_upload0);
					
					@copy('./images/product/temp_img/'.$image_upload0, './images/product/mb/'.$timeImg.'-'.$image_upload0);
					$this->ImageCompress('images/product/mb/'.$timeImg.'-'.$image_upload0);
					
					@copy('./images/product/temp_img/'.$image_upload0, './images/product/mb/thumb/'.$timeImg.'-'.$image_upload0);
					$this->ImageResizeWithCrop(350, '', $timeImg.'-'.$image_upload0, './images/product/mb/thumb/');
					
					@copy('./images/product/temp_img/'.$image_upload0, './images/product/mb/crop/'.$timeImg.'-'.$image_upload0);
					$this->ImageResizeWithCropping(350, 350, $timeImg.'-'.$image_upload0, './images/product/mb/crop/');
					
					@copy('./images/product/temp_img/'.$image_upload0, './images/product/'.$timeImg.'-'.$image_upload0);
					$this->ImageResizeWithCrop(550, '', $timeImg.'-'.$image_upload0, './images/product/');
					
					@copy('./images/product/'.$timeImg.'-'.$image_upload0, './images/product/thumb/'.$timeImg.'-'.$image_upload0);
					$this->ImageResizeWithCrop(175, '', $timeImg.'-'.$image_upload0, './images/product/thumb/');
					
					@copy('./images/product/temp_img/'.$image_upload0, './images/product/list-image/'.$timeImg.'-'.$image_upload0);
					$this->ImageResizeWithCrop(75, '', $timeImg.'-'.$image_upload0, './images/product/list-image/');
					
					@copy('./images/product/temp_img/'.$image_upload0, './images/product/cropsmall/'.$timeImg.'-'.$image_upload0);
					$this->ImageResizeWithCropping(108, 92, $timeImg.'-'.$image_upload0, './images/product/cropsmall/');
					
					@copy('./images/product/temp_img/'.$image_upload0, './images/product/cropmed/'.$timeImg.'-'.$image_upload0);
					$this->ImageResizeWithCropping(285, 215, $timeImg.'-'.$image_upload0, './images/product/cropmed/');
					
					@copy('./images/product/temp_img/'.$image_upload0, './images/product/cropthumb/'.$timeImg.'-'.$image_upload0);
					$this->ImageResizeWithCropping(75, 75, $timeImg.'-'.$image_upload0, './images/product/cropthumb/');
					
					//$this->thumbimage_resize('images/product/mb/','images/product/mb/thumb/','350');

					$imagesVal=$timeImg.'-'.$image_upload0;
					
				}else if($this->input->post('existImage0') != ''){
					$imagesVal=$this->input->post('existImage0');	
				}
			}
			  
			if($image_upload1 != '' || $this->input->post('existImage1') != ''){
				if($image_upload1 != ''){
					@copy('./images/product/temp_img/'.$image_upload1, './images/product/org-image/'.$timeImg.'-'.$image_upload1);
					
					@copy('./images/product/temp_img/'.$image_upload1, './images/product/mb/'.$timeImg.'-'.$image_upload1);
					$this->ImageCompress('images/product/mb/'.$timeImg.'-'.$image_upload1);
					
					@copy('./images/product/temp_img/'.$image_upload1, './images/product/mb/thumb/'.$timeImg.'-'.$image_upload1);
					$this->ImageResizeWithCrop(350, '', $timeImg.'-'.$image_upload1, './images/product/mb/thumb/');
						
					@copy('./images/product/temp_img/'.$image_upload1, './images/product/mb/crop/'.$timeImg.'-'.$image_upload1);
					$this->ImageResizeWithCropping(350, 350, $timeImg.'-'.$image_upload1, './images/product/mb/crop/');
					
					@copy('./images/product/temp_img/'.$image_upload1, './images/product/'.$timeImg.'-'.$image_upload1);
					$this->ImageResizeWithCrop(550, '', $timeImg.'-'.$image_upload1, './images/product/');
					
					@copy('./images/product/'.$timeImg.'-'.$image_upload1, './images/product/thumb/'.$timeImg.'-'.$image_upload1);
					$this->ImageResizeWithCrop(175, '', $timeImg.'-'.$image_upload1, './images/product/thumb/');
					
					@copy('./images/product/temp_img/'.$image_upload1, './images/product/list-image/'.$timeImg.'-'.$image_upload1);
					$this->ImageResizeWithCrop(75, '', $timeImg.'-'.$image_upload1, './images/product/list-image/');
					
					@copy('./images/product/temp_img/'.$image_upload1, './images/product/cropsmall/'.$timeImg.'-'.$image_upload1);
					$this->ImageResizeWithCropping(108, 92, $timeImg.'-'.$image_upload1, './images/product/cropsmall/');
					
					@copy('./images/product/temp_img/'.$image_upload1, './images/product/cropmed/'.$timeImg.'-'.$image_upload1);
					$this->ImageResizeWithCropping(285, 215, $timeImg.'-'.$image_upload1, './images/product/cropmed/');
					
					@copy('./images/product/temp_img/'.$image_upload1, './images/product/cropthumb/'.$timeImg.'-'.$image_upload1);
					$this->ImageResizeWithCropping(75, 75, $timeImg.'-'.$image_upload1, './images/product/cropthumb/');
					
					$imagesVal .=','.$timeImg.'-'.$image_upload1;
				}else if($this->input->post('existImage1') != ''){
					$imagesVal .=','.$this->input->post('existImage1');	
				}
			  }
			  
			  if($image_upload2 != '' || $this->input->post('existImage2')){
                  if($image_upload2 != ''){
						@copy('./images/product/temp_img/'.$image_upload2, './images/product/org-image/'.$timeImg.'-'.$image_upload2);
						@copy('./images/product/temp_img/'.$image_upload2, './images/product/mb/'.$timeImg.'-'.$image_upload2);
						$this->ImageCompress('images/product/mb/'.$timeImg.'-'.$image_upload2);
						
						
						@copy('./images/product/temp_img/'.$image_upload2, './images/product/mb/thumb/'.$timeImg.'-'.$image_upload2);
						$this->ImageResizeWithCrop(350, '', $timeImg.'-'.$image_upload2, './images/product/mb/thumb/');
						
						@copy('./images/product/temp_img/'.$image_upload2, './images/product/mb/crop/'.$timeImg.'-'.$image_upload1);
						$this->ImageResizeWithCropping(350, 350, $timeImg.'-'.$image_upload2, './images/product/mb/crop/');
						
						
						@copy('./images/product/temp_img/'.$image_upload2, './images/product/'.$timeImg.'-'.$image_upload2);
						$this->ImageResizeWithCrop(550, '', $timeImg.'-'.$image_upload2, './images/product/');
						@copy('./images/product/'.$timeImg.'-'.$image_upload2, './images/product/thumb/'.$timeImg.'-'.$image_upload2);
						$this->ImageResizeWithCrop(175, '', $timeImg.'-'.$image_upload2, './images/product/thumb/');
						@copy('./images/product/temp_img/'.$image_upload2, './images/product/list-image/'.$timeImg.'-'.$image_upload2);
						$this->ImageResizeWithCrop(75, '', $timeImg.'-'.$image_upload2, './images/product/list-image/');
						
						@copy('./images/product/temp_img/'.$image_upload2, './images/product/cropsmall/'.$timeImg.'-'.$image_upload2);
						$this->ImageResizeWithCropping(108, 92, $timeImg.'-'.$image_upload2, './images/product/cropsmall/');
						@copy('./images/product/temp_img/'.$image_upload2, './images/product/cropmed/'.$timeImg.'-'.$image_upload2);
						$this->ImageResizeWithCropping(285, 215, $timeImg.'-'.$image_upload2, './images/product/cropmed/');
						
						@copy('./images/product/temp_img/'.$image_upload2, './images/product/cropthumb/'.$timeImg.'-'.$image_upload2);
						$this->ImageResizeWithCropping(75, 75, $timeImg.'-'.$image_upload2, './images/product/cropthumb/');
						
						$imagesVal.=','.$timeImg.'-'.$image_upload2;
					} 
					else if($this->input->post('existImage2') != '')
					{
						$imagesVal .=','.$this->input->post('existImage2');	
					}
			  }
			  
			  if($image_upload3 != '' || $this->input->post('existImage3')){
				   	if($image_upload3 != ''){
						@copy('./images/product/temp_img/'.$image_upload3, './images/product/org-image/'.$timeImg.'-'.$image_upload3);
						@copy('./images/product/temp_img/'.$image_upload3, './images/product/mb/'.$timeImg.'-'.$image_upload3);
						$this->ImageCompress('images/product/mb/'.$timeImg.'-'.$image_upload3);
						
						@copy('./images/product/temp_img/'.$image_upload3, './images/product/mb/thumb/'.$timeImg.'-'.$image_upload3);
						$this->ImageResizeWithCrop(350, '', $timeImg.'-'.$image_upload3, './images/product/mb/thumb/');
						
						@copy('./images/product/temp_img/'.$image_upload3, './images/product/mb/crop/'.$timeImg.'-'.$image_upload3);
						$this->ImageResizeWithCropping(350, 350, $timeImg.'-'.$image_upload3, './images/product/mb/crop/');
						
						@copy('./images/product/temp_img/'.$image_upload3, './images/product/'.$timeImg.'-'.$image_upload3);
						$this->ImageResizeWithCrop(550, '', $timeImg.'-'.$image_upload3, './images/product/');
						@copy('./images/product/'.$timeImg.'-'.$image_upload3, './images/product/thumb/'.$timeImg.'-'.$image_upload3);
						$this->ImageResizeWithCrop(175, '', $timeImg.'-'.$image_upload3, './images/product/thumb/');
						@copy('./images/product/temp_img/'.$image_upload3, './images/product/list-image/'.$timeImg.'-'.$image_upload3);
						$this->ImageResizeWithCrop(75, '', $timeImg.'-'.$image_upload3, './images/product/list-image/');
						
						@copy('./images/product/temp_img/'.$image_upload3, './images/product/cropsmall/'.$timeImg.'-'.$image_upload3);
						$this->ImageResizeWithCropping(108, 92, $timeImg.'-'.$image_upload3, './images/product/cropsmall/');
						@copy('./images/product/temp_img/'.$image_upload3, './images/product/cropmed/'.$timeImg.'-'.$image_upload3);
						$this->ImageResizeWithCropping(285, 215, $timeImg.'-'.$image_upload3, './images/product/cropmed/');
						
						@copy('./images/product/temp_img/'.$image_upload3, './images/product/cropthumb/'.$timeImg.'-'.$image_upload3);
						$this->ImageResizeWithCropping(75, 75, $timeImg.'-'.$image_upload3, './images/product/cropthumb/');
						
						$imagesVal.=','.$timeImg.'-'.$image_upload3;
					}else if($this->input->post('existImage3') != ''){
						$imagesVal .=','.$this->input->post('existImage3');	
					}
			  }                        
			  
			  if($image_upload4 != '' || $this->input->post('existImage4')){
					if($image_upload4 != ''){ 
						@copy('./images/product/temp_img/'.$image_upload4, './images/product/org-image/'.$timeImg.'-'.$image_upload4);
						@copy('./images/product/temp_img/'.$image_upload4, './images/product/mb/'.$timeImg.'-'.$image_upload4);
						$this->ImageCompress('images/product/mb/'.$timeImg.'-'.$image_upload4);
						
						@copy('./images/product/temp_img/'.$image_upload4, './images/product/mb/thumb/'.$timeImg.'-'.$image_upload4);
						$this->ImageResizeWithCrop(350, '', $timeImg.'-'.$image_upload4, './images/product/mb/thumb/');
						
						@copy('./images/product/temp_img/'.$image_upload4, './images/product/mb/crop/'.$timeImg.'-'.$image_upload4);
						$this->ImageResizeWithCropping(350, 350, $timeImg.'-'.$image_upload4, './images/product/mb/crop/');
						
						@copy('./images/product/temp_img/'.$image_upload4, './images/product/'.$timeImg.'-'.$image_upload4);
						$this->ImageResizeWithCrop(550, '', $timeImg.'-'.$image_upload4, './images/product/');
						@copy('./images/product/'.$timeImg.'-'.$image_upload4, './images/product/thumb/'.$timeImg.'-'.$image_upload4);
						$this->ImageResizeWithCrop(175, '', $timeImg.'-'.$image_upload4, './images/product/thumb/');
						@copy('./images/product/temp_img/'.$image_upload4, './images/product/list-image/'.$timeImg.'-'.$image_upload4);
						$this->ImageResizeWithCrop(75, '', $timeImg.'-'.$image_upload4, './images/product/list-image/');
						
						
						@copy('./images/product/temp_img/'.$image_upload4, './images/product/cropsmall/'.$timeImg.'-'.$image_upload4);
						$this->ImageResizeWithCropping(108, 92, $timeImg.'-'.$image_upload4, './images/product/cropsmall/');
						@copy('./images/product/temp_img/'.$image_upload4, './images/product/cropmed/'.$timeImg.'-'.$image_upload4);
						$this->ImageResizeWithCropping(285, 215, $timeImg.'-'.$image_upload4, './images/product/cropmed/');
						
						@copy('./images/product/temp_img/'.$image_upload4, './images/product/cropthumb/'.$timeImg.'-'.$image_upload4);
						$this->ImageResizeWithCropping(75, 75, $timeImg.'-'.$image_upload4, './images/product/cropthumb/');
						
						$imagesVal.=','.$timeImg.'-'.$image_upload4;
					}else if($this->input->post('existImage4') != ''){
						$imagesVal .=','.$this->input->post('existImage4');	
					}
			  }
			  
		//$imagesVal=$timeImg.'-'.$image_upload0.','.$Imgname1.','.$timeImg.'-'.$image_upload2.','.$timeImg.'-'.$image_upload3.','.$timeImg.'-'.$image_upload4;
		//echo $imagesVal; echo "<br>"; 
		$imagesVal = trim($imagesVal,",");
		//die;
		
		
		$description = $this->input->post('description');
		$tags = $this->input->post('jquery-tagbox-tags');
		$materials = $this->input->post('jquery-tagbox-materials'); 
        /*
         * Get product type and set price
         */
		
                $quantity = $this->input->post('quantity');
				$price_type =  $this->input->post('pricing_type');
                    //$price = $this->input->post('price');
                    $pricing_type = 'Fixed';
                    $auction_level = ''; 

			
		$giftcard='false';
		if($this->input->post('giftcard') == 'on'){
		$giftcard='true';
		} 
		
		$ship_duration = $this->input->post('ship_duration'); 
		if($ship_duration == 'custom')
		{
			$ship_duration=$this->input->post('processing_min').'-'.$this->input->post('processing_max').' '.$this->input->post('processing_time_units');
		}
		
			$ship_from=explode('|',$this->input->post('shipping_from'));
			$product_seller_id = rand(1111, 999999);
			
			$seourlBase = $seourl = url_title($product_name, '-', TRUE);
			
			if ($seourlBase == ''){
				$seourlBase = $seourl = $product_seller_id;
			}
			
			$seourl_check = '0';
			$duplicate_url = $this->product_model->get_all_details(PRODUCT,array('seourl'=>$seourl));
			if ($duplicate_url->num_rows()>0){
				$seourl = $seourlBase.'-'.$duplicate_url->num_rows();
			}else {
				$seourl_check = '1';
			}
			$urlCount = $duplicate_url->num_rows();
			while ($seourl_check == '0'){
				$urlCount++;
				$duplicate_url = $this->product_model->get_all_details(PRODUCT,array('seourl'=>$seourl));
				if ($duplicate_url->num_rows()>0){
					$seourl = $seourlBase.'-'.$urlCount;
				}else {
					$seourl_check = '1';
				}
			}
			$pro_seo=$productsEo=$seourl;
			
			if($UPDATE_product_Seourl != ''){
				$modifyDate=date('Y-m-d H:i:s');	
				$createdDate=date('Y-m-d H:i:s');
			} else {
				$modifyDate=date('Y-m-d H:i:s');	
				$createdDate=date('Y-m-d H:i:s');
			}
		if($this->config->item('deal_of_day')=='Yes'){
			if($this->input->post('deal_date_from')!='')
			{
			$dealstartdate=date('Y-m-d',strtotime($this->input->post('deal_date_from')));
			
			}
			else
			{
			$dealstartdate=NULL;
			}
			if($this->input->post('deal_date_to')!='')
			{
			$dealenddate=date('Y-m-d',strtotime($this->input->post('deal_date_to')));
			}
			else
			{
			$dealenddate=NULL;
			}
			if($this->input->post('deal_time_from')!='')
			{
			$dealstarttime=date('H:i',strtotime($this->input->post('deal_time_from')));
			}
			else
			{
			$dealstarttime=NULL;
			}
			if($this->input->post('deal_time_to')!='')
			{
			$dealstimeto=date('H:i',strtotime($this->input->post('deal_time_to')));
			}
			else
			{
			$dealstimeto=NULL;
			}
			if($this->input->post('discount')!='')
			{
			$discount=$this->input->post('discount');
			}
			else
			{
			$discount=NULL;
			}
			if($dealstartdate && $dealenddate && $discount && $dealstimeto && $dealstarttime!=NULL)
			{
			$dodstatus='DOD';
			}
			}
			
			$shopDetails = $this->product_model->get_all_details(SELLER,array('seller_id'=>$userID));
			//print_r($shopDetails->result());
			 
			if($shopDetails->num_rows()>0){
				$address = str_replace(' ','+',$shopDetails->row()->shop_location);
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
				
			}else{
				$lat = '';
				$long = '';
			}
			

			$dataArr = array(
			            'made_by' => $made_by,
						'product_condition' => $product_condition,						
						'modified' => $modifyDate,
						'created' => $createdDate,
						'maked_on' => $maked_on,
			            'product_name' => $product_name,
						'description' => $description,
						'price' => $price,
						'quantity' => $quantity,
						'image' => $imagesVal,
						'category_id' => $category_id,
						'tag' => $tags,
						'action'=>$dodstatus,
						'discount' =>$discount,
						'deal_date'=>$dealstartdate,
						'deal_date_to'=>$dealenddate,
						'deal_time_from' =>$dealstarttime,
						'deal_time_to' =>$dealstimeto,
						'materials' => $materials,
						'status' => $status, 
						'pay_status' => $pay_status, 
						'seourl' => $seourl,
						'gift_card' => $giftcard,
						'user_id' => $userID,
						'seller_product_id' => $product_seller_id,
						'ship_duration' => $ship_duration,
						'ship_from' => $ship_from[1],
						'pay_type' => $pay_type,
						'pay_date' => $pay_date,
                        'price_type' => $pricing_type,
						'product_type' => $this->input->post('item_name'),
                        'auction_level' => $auction_level,	
						'latitude' =>$lat,	
						'longitude' =>$long,
						'pickup_option' => $this->input->post('pickup_option')
						//'ship_details' => $shippingVal
						);
						#echo $this->data['currencyValue'];
						#echo "<pre>"; print_r($dataArr);  die;
			if($UPDATE_product_Seourl != ''){
				$redirect_status = $dataArr['status']; // for redirecting only
				unset($dataArr['seourl']);
				unset($dataArr['created']);
				unset($dataArr['user_id']);	
				unset($dataArr['status']);	
				unset($dataArr['pay_status']);	
				unset($dataArr['pay_type']);	
				unset($dataArr['pay_date']);	
				$prod_name_tmp = $dataArr['product_name'];
				$prod_desc_tmp = $dataArr['description'];
				
				if($this->session->userdata('language_code') != 'en'){
					unset($dataArr['product_name']);
					unset($dataArr['description']);
				}
				
				
				$this->product_model->edit_product($dataArr,array('seourl' => $UPDATE_product_Seourl));
				
				$productsEo=$UPDATE_product_Seourl;
				
				$redirect_seo = $productsEo;// for redirecting only
				
				$languages = $this->multilanguage_model->get_language_list()->result_array();
				//print_r($languages);
				//$this->session->userdata('language_code');
				
				foreach($languages as $lang){
						
					$ln = $lang['lang_code'];
				
					$table = PRODUCT_EN;
					$ln_table = $table."_".$ln;
						
					//echo $ln_table."####";
					//if()
					if($this->session->userdata('language_code') == $lang['lang_code']){
						$dataArr['product_name'] = $prod_name_tmp;
						$dataArr['description'] = $prod_desc_tmp;
					}else{
						unset($dataArr['product_name']);
						unset($dataArr['description']);
					}
						
					$this->product_model->edit_product($dataArr,array('seourl' => $UPDATE_product_Seourl),$ln_table);
					//echo $this->db->last_query()."<br>";
				}
				
			} else {
			   
				$this->product_model->add_product($dataArr);
			   //echo $this->db->last_query()."<br>";
			   
			   $insert_id = $this->db->insert_id();
			   $redirect_status = $dataArr['status'];// for redirecting only
			   
			   
			   //$insert_array = $this->product_model->get_all_details(PRODUCT,array('id'=>$insert_id))->result();
			   $insert_array = $this->product_model->get_all_details(PRODUCT_EN,array('id'=>$insert_id))->result();
			   
			   $redirect_seo = $insert_array[0]->seourl;// for redirecting only
			   
			   $languages = $this->multilanguage_model->get_language_list()->result_array();
			   
// 			   foreach($languages as $lang){
// 			   	$ln = $lang['lang_code'];
// 			   	$table = PRODUCT;
// 			   	$ln_table = $table."_".$ln;
// 			   	$this->product_model->simple_insert($ln_table,$insert_array[0]);
// 			   }
			   
			   
			   foreach($languages as $lang){
				   	//echo "<br>#######<br>";
				   	$ln = $lang['lang_code'];
				   		
				   	$table = PRODUCT_EN;
				   	$ln_table = $table."_".$ln;
				   	
				   	//echo $ln_table."<br>";
				   	
				   	$this->product_model->simple_insert($ln_table,$insert_array[0]);
				   	//echo $this->db->last_query()."<br>";
				   	
				   	$product_name = "product_name_".$ln;
				   	$description = "description_".$ln;
				   
				   	$lndataArr['product_name'] = $_POST[$product_name];
				   	$lndataArr['description'] = $_POST[$description];
				   
				   	if($lndataArr['product_name'] !='' || $lndataArr['description'] != ''){
				   		$this->product_model->update_details($ln_table,$lndataArr,array('id' => $insert_id));
				   	}
				   	//echo $this->db->last_query()."<br>";
			   }
			   
			}	
			//DIE;
			$product_id = $insert_id;
			
			
		

		if($this->input->post('pickup_option') !='collection'){
			
			if($this->input->post('item_name')=='physical'){
				if($this->input->post('shipping_to') != ''){	
					   if($UPDATE_product_Seourl != ''){
								$product_id=$this->input->post('edit_id');
								$this->product_model->commonDelete(SUB_SHIPPING,array('product_id' => $this->input->post('edit_id')));
									
					   }
						$ship_to = $this->input->post('shipping_to');  
						$ship_to_id = $this->input->post('ship_to_id');   //print_r($ship_to_id); die;
						$cost_individual = $this->input->post('shipping_cost');	
						$cost_with_another = $this->input->post('shipping_with_another');
						for($i=0; $i < sizeof($ship_to); $i++)
						{
								
								
								
							$ship_name=@explode('|', $ship_to[$i]);
							if($ship_to[$i] == 'Everywhere Else'){
								$shipName='Everywhere Else';
								$shipId=232; 
								
							} else {
							$shipName=$ship_name[1];
							$shipId=$ship_to_id[$i];
							}
							$seourlBase = $seourl = url_title($shipName, '-', TRUE);
							$seourl_check = '0';
							$duplicate_url = $this->product_model->get_all_details(SUB_SHIPPING,array('ship_seourl'=>$seourl));
							if ($duplicate_url->num_rows()>0){
								$seourl = $seourlBase.'-'.$duplicate_url->num_rows();
							}else {
								$seourl_check = '1';
							}
							$urlCount = $duplicate_url->num_rows();
							while ($seourl_check == '0'){
								$urlCount++;
								$duplicate_url = $this->product_model->get_all_details(SUB_SHIPPING,array('ship_seourl'=>$seourl));
								if ($duplicate_url->num_rows()>0){
									$seourl = $seourlBase.'-'.$urlCount;
								}else {
									$seourl_check = '1';
								}
							}		
								
								$cost_individual[$i]=$cost_individual[$i]/$curval;
								$cost_with_another[$i]=$cost_with_another[$i]/$curval;
								
							 $dataArrShip=array('product_id' => $product_id,'ship_id' => $shipId,'ship_name' => $shipName,'ship_cost' => $cost_individual[$i],'ship_seourl' => $seourl,'ship_other_cost' => $cost_with_another[$i]);
							//print_r( $dataArrShip); die;
							 $this->product_model->simple_insert(SUB_SHIPPING,$dataArrShip);
							
						}
				}
			}else if($this->input->post('item_name')=='digital'){
				if($UPDATE_product_Seourl != ''){
					$product_id=$this->input->post('edit_id');
					$this->product_model->commonDelete(SUB_SHIPPING,array('product_id' => $this->input->post('edit_id')));								
				}
				$shipName='Everywhere Else';
				$seourlBase = $seourl = url_title($shipName, '-', TRUE);
				$seourl_check = '0';
				$duplicate_url = $this->product_model->get_all_details(SUB_SHIPPING,array('ship_seourl'=>$seourl));
				if ($duplicate_url->num_rows()>0){
					$seourl = $seourlBase.'-'.$duplicate_url->num_rows();
				}else {
					$seourl_check = '1';
				}
				$urlCount = $duplicate_url->num_rows();
				while ($seourl_check == '0'){
					$urlCount++;
					$duplicate_url = $this->product_model->get_all_details(SUB_SHIPPING,array('ship_seourl'=>$seourl));
					if ($duplicate_url->num_rows()>0){
						$seourl = $seourlBase.'-'.$urlCount;
					}else {
						$seourl_check = '1';
					}
				}
				$dataArrShip=array('product_id'=> $product_id,'ship_id' => '232','ship_name' => 'Everywhere Else','ship_cost' => '0','ship_seourl' => $seourl,'ship_other_cost' => '0');
				$this->product_model->simple_insert(SUB_SHIPPING,$dataArrShip);
			}
	  	}else{
			if($UPDATE_product_Seourl != ''){
				$product_id=$this->input->post('edit_id');
				$this->product_model->commonDelete(SUB_SHIPPING,array('product_id' => $this->input->post('edit_id')));
				$this->product_model->update_details(PRODUCT,array('ship_from'=>''),array('id' => $this->input->post('edit_id')));
			}
		}
		$item_name = $this->input->post('item_name');  //physical or digital
		if($UPDATE_product_Seourl != ''){ 
			$product_id=$this->input->post('edit_id');
		    $this->product_model->delete_subproduct_all(array('product_id' => $this->input->post('edit_id')));
		}
		if($item_name == 'physical'){  //if is it physical item we should add the attributes to the sub products table else add digital file/ 
			if($UPDATE_product_Seourl != ''){
				
				if($this->input->post('exist_property_level')!=""){
					if($this->input->post('property_level')==''){
					$variation_name1 = $this->input->post('exist_property_level');
					}
					else{
						$variation_name1 = $this->input->post('property_level');
					}
				}
				else{
					$variation_name1 = $this->input->post('property_level');
				}
				
				/*If variation two existing*/
				if($this->input->post('exist_property_level1')!=""){
					if($this->input->post('property_level1')==''){
					$variation_name2 = $this->input->post('exist_property_level1');
					}
					else{
						$variation_name2 = $this->input->post('property_level1');
					}
				}
				else{
					$variation_name2 = $this->input->post('property_level1');
				}
								
			}
			else{
			$variation_name1 = $this->input->post('property_level');
			$variation_name2 = $this->input->post('property_level1');
			}			
			$variation_value1 = $this->input->post('variation_value');
			if($this->input->post('variation_scale1') != ''){
			    $variation_scale1 = $this->input->post('variation_scale1');
			}
			else{
				$variation_scale1='';
			}
			if($this->input->post('variation_scale2') != ''){
			    $variation_scale2 = $this->input->post('variation_scale2');
			}
			else{
				$variation_scale2='';
			}
				
			$variation_value2 =  $this->input->post('variation_value1');
				if($this->input->post('price_status') == 0){
					for($i=0;$i<sizeof($this->input->post('pricing'));$i++){
						$tpric = $this->input->post('pricing');
						$pricing1[] = $tpric[$i]/ $curval;
					}	
				}else{
					$pricing1 = array();
				}
				#echo "<pre>";print_r($this->input->post('pricing'));
			#print_r($pricing1); #die;
			$stock1 = $this->input->post('listing_variation');						
			$stock2 = $this->input->post('listing_variation1');			
					if($variation_name1 != '' && count($this->input->post('DigiFiles')) == 1 && $variation_value1 != ''){
							for($i=0; $i< sizeof($variation_value1); $i++){
								if($pricing1[$i] == 0) { $prcg=NULL; } else { $prcg= $pricing1[$i]; }					
								  $attr_array1 = array('attr_name' => $variation_name1,
													'attr_value' => $variation_value1[$i],
													//'attr_seourl' => $seourl,
													'pricing' => $prcg,
													'stock_status' => $stock1[$i],
													'product_id' => $product_id,
													'attr_scale' => $variation_scale1);
													
								  $this->product_model->add_subproduct_insert($attr_array1);
								  }
								/*   echo '<pre>'; print_r($attr_array1); //die;
								$attr_details = $this->product_model->get_sorted_array_values($attr_array1,'pricing','asc');	


								
									for($i=0; $i< sizeof($attr_array1); $i++){
									     $attr_data_arr = array('attr_name' => $attr_array1[$i]['attr_name'],
															'attr_value' => $attr_array1[$i]['attr_value'],
															//'attr_seourl' => $seourl,
															'pricing' =>(int)$attr_array1[$i]['pricing'],
															'stock_status' => $attr_array1[$i]['stock_status'],
															'product_id' => $product_id,
															'attr_scale' => $attr_array1[$i]['attr_scale']);
															
															echo '<pre>'; print_r($attr_data_arr); 
									     $this->product_model->add_subproduct_insert($attr_data_arr);	 							  
								    } */		
							# die;
					}
					if($variation_name2 != '' && count($this->input->post('DigiFiles')) == 1 && $variation_value2 != ''){
						    
							for($i=0; $i< sizeof($variation_value2); $i++){
								$attr_array2 = array('attr_name' => $variation_name2,
													'attr_value' => $variation_value2[$i],
													//'attr_seourl' => $seourl,
													//'pricing' => $pricing2[$i],
													'stock_status' => $stock2[$i],
													'product_id' => $product_id,
													'attr_scale' => $variation_scale2);
												//echo "<pre>";  print_r($attr_array2); die;
													//echo $this->db->last_query();
							$this->product_model->add_subproduct_insert($attr_array2);
							}
					} 
		}
		else if(count($this->input->post('DigiFiles')) > 1){  // if is it digital item  
					
			$digitalfile =  $this->input->post('DigiFiles');
			//echo "<pre>"; print_r($digitalfile); die;
			if($product_id == ''){
				$timeFile=time();
			} else {
				$timeFile='';
			}
			for($i=1; $i < sizeof($digitalfile); $i++){
			@copy('./temp_digital_files/'.$digitalfile[$i], './digital_files/'.$timeFile.$digitalfile[$i]);
			$digitalValues .=$timeFile.$digitalfile[$i].',';
			}
			$attr_digital = array('digital_item' => $digitalValues,'product_id' => $product_id); 
			$this->product_model->add_subproduct_insert($attr_digital);
		}
		
			
			/***********Set minimum base price in product table for sorting purpose*************/
			
			
			if($this->input->post('price_status') == 0){
				$subproduct_detail=$this->product_model->get_subproduct_minPrice_value($product_id);	
				#echo "<pre>";print_r($subproduct_detail->result());
				$base_price=$subproduct_detail->row()->pricing;
			} else {
				$base_price=$price/$curval;
			}
			#echo $base_price;
			$this->product_model->update_details(PRODUCT,array('base_price' => $base_price),array('id' => $product_id));
            $languages = $this->multilanguage_model->get_language_list()->result_array();	
		   	foreach($languages as $lang){
			   	$ln = $lang['lang_code'];
			   		
			   	$table = PRODUCT_EN;
			   	$ln_table = $table."_".$ln;

		   		$this->product_model->update_details($ln_table,array('base_price' => $base_price),array('id' => $product_id));
		   	}			
			#echo $this->db->last_query();die;
		
			$shop_fav_list=$this->product_model->get_all_details(FAVORITE,array('shop_id'=>$userID));
			$shopdet=$this->product_model->get_all_details(SELLER,array('seller_id'=>$userID));
			#echo "<pre>";print_r($shopdet->result());die;
			foreach($shop_fav_list->result() as $Shp_fav)
			{
				$sentfav_list=$this->product_model->get_all_details(USERS, array('id'=>$Shp_fav->user_id));//'like_of_like'=>'Yes'));						
						$noty_email_arr=explode(',',$sentfav_list->row()->notification_email);
						#echo "<pre>";print_r($noty_email_arr);#die;
						if(in_array('fav_shop_pro',$noty_email_arr)){
								
							
								#echo "<pre>";print_r($this->data['userDetails']);die;
								$shop_Name=$shopdet->row()->seller_businessname;
								//$pro_seo=$seourl;
								
								$newsid='32';
								
								$template_values=$this->user_model->get_newsletter_template_details($newsid);

								$adminnewstemplateArr=array('email_title'=> $this->config->item('email_title'),'logo'=> $this->data['logo']);
								extract($adminnewstemplateArr);
								$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
								$message .= '<!DOCTYPE HTML>
									<html>
									<head>
									<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
									<meta name="viewport" content="width=device-width"/>
									<title>'.$template_values['news_subject'].'</title>
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
													'from_mail_id'=>$sender_email,
													'mail_name'=>$sender_name,
													'to_mail_id'=>$sentfav_list->row()->email,
													'subject_message'=>'Favourite',
													'body_messages'=>$message
												);
													
								#echo '<pre>'; print_r($email_values); die;

								$email_send_to_common = $this->product_model->common_email_send($email_values);#die;
						}
			}//die;
			if($redirect_status == 'UnPublish'){
				$this->setErrorMessage('success','Product Added Successfully. Continue Payment to publish the product');
			}else{
				$this->setErrorMessage('success','Product Published Successfully');
			}
			
			if($this->input->post('AdminEditProduct')=='admin-edit-product'){
				//redirect('admin-preview/'.$productsEo);	
				//redirect('shop/sell');
				if($redirect_status == 'UnPublish'){	
					redirect('shop/billing');	
				}else{
					redirect('products/'.$redirect_seo);
				}
				
				
			}else{
				//redirect('preview/'.$productsEo);
				//redirect('shop/sell');
				if($redirect_status == 'UnPublish'){
					redirect('shop/billing');
				}else{
					redirect('products/'.$redirect_seo);
				}
			}
			//$this->load->view('site/shop/listitem_preview',$this->data);
		} else {
		$this->setErrorMessage('error','You Must Login First');
		redirect('');
		}
		
	}

	/**
	 * 
	 * This function edit the product view listing
	 * @param String $seourl
	 * 
	 * return Array
	 */	
	public function reviews($pType=''){
		if ($this->checkLogin('U') == ''){
			$lg_login=addslashes(shopsy_lg('lg_login','You must login'));
			$this->setErrorMessage('error',$lg_login);
			redirect(base_url());
		}
		$search_date =  date("Y-m-d H:i:s");
		if(isset($_GET['month'])){
			$search_month=$_GET['month'];
			$search_date= date("Y-m-d H:i:s", strtotime("-".$search_month." months"));
			//echo $search_date;die;
		}
		//echo $search_date;die;
		$shop_id=$this->user_model->get_all_details(SELLER,array('seller_id'=>$this->checkLogin('U')))->row()->id;		
		$this->data['user_review'] = array();
		if($shop_id != ""){
			$this->data['user_review']= $this->user_model->get_my_product_review($shop_id,$search_date);
		}
		//echo $this->db->last_query();die;
		$this->data['my_review']=$this->user_model->get_my_reviews($this->checkLogin('U'),$search_date);
		
		$this->data['all_feedback']=$this->user_model->get_all_reviews($this->checkLogin('U'),$search_date,$shop_id);		
		$this->data['heading'] = $this->config->item('email_title').' - Review';
	
		$this->load->view("site/user/reviews",$this->data);
	}
	
   //Edit Product
   public function edit_shop_items($seourl){

	   if( $this->checkLogin('U') == '' ) {
			$this->setErrorMessage('error','You Must Login First');
			redirect('login');
	   }
	   
	   $user_id = $this->checkLogin('U');
	   $shop_id = $this->db->select('id')->from('shopsy_seller')->where( array('seller_id' => $user_id) )->get()->first_row()->id;
	   $product_qry = $this->db->select('id')->from('shopsy_product')->where( array('store_id' => $shop_id, 'seourl' => $seourl) )
	   						  ->get();
	   if ( ! $product_qry->num_rows() ) {
			$this->setErrorMessage('error',"You can't edit this product!");
			redirect('shop/managelistings');
			exit(0);
	   }
	   
	   $product_id = $product_qry->first_row()->id;
	   $current_page = '';
	   if ( $this->input->post('btn-media') != '' ) $current_page = 'media'; 
	   if ( $this->input->post('btn-info') != '' ) $current_page = 'info'; 
	   if ( $this->input->post('btn-variation') != '' ) $current_page = 'variation' ;
	   if ( $this->input->post('btn-shipping') != '' ) $current_page = 'shipping' ;
	   
	   switch ( $current_page ) {

		   case 'media' :
		   		$this->data['product'] = $this->db->select('id,image')->from('shopsy_product')->where( array('id' => $product_id ) )
												  ->get()->first_row();
		   		$this->load->view('site/product/edit_shop_product_media',$this->data);
				break;
		   case 'variation' :
		   		$this->data['product'] = $this->db->select('id,image,msrp, price,quantity, variable_product, variable_upc, variable_price, variable_msrp, variable_mpn')
												  ->from('shopsy_product')
												  ->where( array('id' => $product_id ) )
												  ->get()->first_row();
		   		$options_qry = $this->db->select('*')->from('shopsy_product_options')->where( array('product_id' => $product_id ) )
										->order_by( 'option_seq_id asc' )
										->get();
				$this->data['options'] = array();
				if( $options_qry->num_rows() ) {
					$this->data['options'] = $options_qry->result_array();
					foreach( $this->data['options'] as $key => $option ) {
						$ID = $option['product_option_id'];
						$this->data['values'][$ID] =  $this->db->select('*')->from('shopsy_product_option_values')
											   ->where( array(  'product_option_id' => $option['product_option_id'], 'product_id' => $product_id ) )
											   ->order_by('option_seq_id')
											   ->get()->result_array();
					}
				}
				
				$this->data['variations'] = array();
				if ( $this->data['product']->variable_product ) {
					$this->data['variations'] = $this->db->select('*')->from('shopsy_product_variation')
														->where( array('product_id' => $product_id) )
														->order_by('product_variant_id asc')
														->get()
														->result_array();
				}
				
		   		$this->load->view('site/product/edit_shop_product_variation',$this->data);
		   		break;		
		   case 'shipping' :
		   		$this->data['product'] = $this->db->select('id,product_name,ship_days, return_policy,ship_price_info')
												  ->from('shopsy_product')
												  ->where( array('id' => $product_id ) )
												  ->get()->first_row();

		   		$shipping_rates = $this->db->select('*')
										->from('shopsy_product_shipping')->where( array('product_id' => $product_id ) )
										->get()->result_array();
				foreach( $shipping_rates as $key => $val ) {
					$code = $val['code'];
					$this->data['shipping_rates'][$code] = array( 'ship_price' => $val['ship_price'], 
																  'next_item_price' => $val['next_item_price'] );
				}
				
		   		$this->load->view('site/product/edit_shop_product_shipping',$this->data);
		   		break;		

		   default:
		   
		   		$this->data['product_info'] = $this->db->select('*')->from('shopsy_product')->where( array('id' => $product_id ) )
												  ->get()->first_row();
		   		$this->data['step_url'] = site_url() . 'site/product/product_setup/' . $product_id . '/' ;
		   		$this->load->view('site/product/edit_shop_product_info',$this->data);
				break;
	   }

   }
	
	
	/**
	 * 
	 * This function load the category list 
	 * 
	 * return Array
	 */	
	public function load_category_Listpage(){ 
		$rootCat=explode('-',$this->uri->segment(2)); 
		if(is_numeric($rootCat[0])){
			$sortArr2 = array('field'=>'cat_position','type'=>'asc');
			$sortArr1 = array($sortArr2);
			$this->data['subCategories']=$this->product_model->get_all_details(CATEGORY,array('rootID'=>$rootCat[0],'status'=>'Active'),$sortArr1);
			$this->data['currentMainCategory']=$this->product_model->get_all_details(CATEGORY,array('id' => $rootCat[0],'status'=>'Active'))->row();
			
			if($this->data['currentMainCategory']->rootID == 0){
			$condition = " where p.status='Publish' and p.category_id LIKE '%".$rootCat[0]."' and u.group='Seller' and u.status='Active' or p.status='Publish' and p.user_id=0 group by p.id order by p.created desc";
			$this->data['Main_cat_product_list']=$this->product_model->view_product_details($condition);
			
			$this->data['meta_title'] =$this->data['currentMainCategory']->seo_title;
			$this->data['title'] =$this->data['currentMainCategory']->seo_title;
			$this->data['meta_keyword'] =$this->data['currentMainCategory']->seo_keyword; 
			$this->data['meta_description'] =$this->data['currentMainCategory']->seo_description;   
			//echo $this->db->last_query(); 
			//echo "<pre>"; print_r($this->data['Main_cat_product_list']->result_array()); die; 
			
			}
			$this->load->view('site/list/category_listpage',$this->data);
		}else{
			show_404();
		}
	}	
	
	
	/**
	 * 
	 * This function load the product list 
	 * @param String $seourl
	 * 
	 * return Array
	 */	
	public function load_product_Listpage(){	
		if(isset($_SERVER['HTTPS'])){
        	$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https://" : "http://";
	    }else{
			$protocol = 'http://';
	    }	
		$CUrurl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		#$curUrl = @explode('?pg=',$CUrurl);
		if(substr_count($CUrurl,'?pg=') == 0){
			$curUrl = @explode('&pg=',$CUrurl);
		} else {
			$curUrl = @explode('?pg=',$CUrurl);
		}

		if($this->input->get('pg') != ''){
			$paginationVal = $this->input->get('pg') * 8;
			$limitPaging = $paginationVal.',8 ';
		} else {
			$limitPaging = ' 8';
		}
		$newPage = $this->input->get('pg')+1;
		#$qry_str = $curUrl[0].'?pg='.$newPage;
		if(substr_count($curUrl[0],'?') >= 1){
			$qry_str = $curUrl[0].'&pg='.$newPage;
		} else {
			$qry_str = $curUrl[0].'?pg='.$newPage;
		}
		$segmentArr=$this->uri->segment_array();
		$Catid=explode('-',$this->uri->segment(count($segmentArr))); 
		$sortArr2 = array('field'=>'cat_position','type'=>'asc');
		$sortArr1 = array($sortArr2);
		$currentcatDetails=$this->product_model->get_all_details(CATEGORY,array('id' => $Catid[0],'status'=>'Active'))->row();
		if($currentcatDetails->rootID == 0){
			if(!isset($_GET['ref'])){
				redirect('category-list/'.$this->uri->segment(count($segmentArr)));
			}
		}
		$this->data['currentsubCategory']=$currentcatDetails;
		$this->data['subCats']=$this->product_model->get_all_details(CATEGORY,array('rootID'=>$Catid[0],'status'=>'Active'),$sortArr1);
		$this->data['super_sub_catStatus']='Yes';
		$this->data['super_sub_catID']=$Catid[0];
		if($this->data['subCats']->num_rows() == 0){
			$this->data['super_sub_catStatus']='No';
			$this->data['subCats']=$this->product_model->get_all_details(CATEGORY,array('rootID'=>$currentcatDetails->rootID,'status'=>'Active'),$sortArr1);   
		}
		$Catid1=explode('-',$this->uri->segment(2)); 
		$this->data['footerSubcatList']=$this->product_model->get_all_details(CATEGORY,array('rootID'=>$Catid1[0],'status'=>'Active'),$sortArr1);
		$made_by='';
		if($this->input->get('marketplace') == 'handmade'){
		$filterid=1;
		$made_by="and p.made_by='".$filterid."'";
		} else if($this->input->get('marketplace') == 'vintage'){
		$filterid=2;
		$made_by="and p.made_by='".$filterid."'";
		}
		$minprice='';
		$maxprice='';
		if($this->input->get('max_price') != '' || $this->input->get('min_price') != ''){
			$minVal = $this->input->get('min_price')/$this->data['currencyValue']; $maxVal = $this->input->get('max_price')/$this->data['currencyValue'];  
			if($maxVal == ''){
				$price="and (p.base_price >= '".$minVal."')"; 
			}else { 
				$price="and (p.base_price >= '".$minVal."' and p.base_price <= '".$maxVal."')";
			}
		}
		$shipto='';  
		if($this->input->get('shipto') != ''){
			$shipto="and (ss.ship_id ='".$this->input->get('shipto')."' or ss.ship_id ='232')";
		}
		$shipfrom='';
		$location=mysql_real_escape_string($this->input->get('location'));
		if($location != ''){
			$shipfrom="and (u.city LIKE '%".$location."%' or u.district LIKE '%".$location."%' or u.state LIKE '%".$location."%' or u.country LIKE '%".$location."%')";
		}
		$gift_cards=''; 
			if($this->input->get('gift_cards') != ''){
			$gift_cards="and s.gift_card ='Yes'"; 
		} 
		//p.category_id LIKE '%,".$Catid[0]."'
		
		$subattr = '';
		if($this->input->get('color') != ''){
			$color = $this->input->get('color');
			$subattr = "and sub.attr_value='".$color."' ";
		}
		
		$condition = " where p.status='Publish' and p.pay_status='Paid' and FIND_IN_SET('".$Catid[0]."',p.category_id) ".$made_by." ".$gift_cards." ".$price." ".$prcing." ".$shipto." ".$shipfrom." and u.group='Seller' ".$subattr." and u.status='Active' or p.status='Publish' and p.user_id=0 group by p.id order by p.created desc limit ".$limitPaging;
		
		$this->data['product_list']=$this->product_model->view_product_details($condition);
		
		#echo $this->db->last_query(); echo '<pre>'; print_r($this->data['product_list']->num_rows());die;
		
		if($this->data['product_list']->num_rows() > 0){
			$paginationDisplay  = '<a title="'.$newPage.'" class="landing-btn-more" href="'.$qry_str.'" style="display: none;">See More Products</a>';
		}else{
			$paginationDisplay  = '<a title="'.$newPage.'" class="landing-btn-more" style="display: none;">No More Products</a>';
		}	
		$this->data['paginationDisplay'] = $paginationDisplay;
	    $this->data['countryList'] = $this->product_model->get_all_details(COUNTRY_LIST,array(),array(array('field'=>'name','type'=>'asc')))->result();
		$this->data['heading'] =$currentcatDetails->seo_title;
		$this->data['meta_title'] =$currentcatDetails->seo_title;		
		$this->data['meta_keyword'] =$currentcatDetails->seo_keyword; 
		$this->data['meta_description'] =$currentcatDetails->seo_description;   
		$this->data['colorfilter'] = $this->product_model->ExecuteQuery("SELECT * FROM (`shopsy_subproducts`) WHERE `attr_name` = 'color' GROUP BY attr_value")->result();		
		if($this->uri->segment(2)){
			$this->data['lnk']="browse/".$this->uri->segment(2)."/";
		}
		$this->load->view('site/list/product_listpage',$this->data);
	}	
	
	/**
	***   Product display (AJAX)
	**/
	public function display_product_detail_ajax($seourl){

			$dataArr = $this->data['preview_item_detail'] = $this->product_model->view_published_product_detail( $seourl )->row_array();
			if(count($dataArr) == 0){
				show_404();
			}else{
				if($dataArr['status'] == 'UnPublish' || $dataArr['status'] == 'Pending' || $dataArr['status'] == 'Draft' ){ 
					if($dataArr['user_id'] == $this->checkLogin('U') || $this->checkLogin('U') == 1 || $this->checkLogin('A') != '') {
					} else {
						show_404();
					}
				}
			}
			
			if( $this->checkLogin('U') ) {
				$this->data['showPriceDiscount'] = true;
			} else {
				$this->data['showPriceDiscount'] = false;
			}
			
			/* update View Count*/
			$dataArrw = array('view_count'=>$this->data['preview_item_detail']['view_count']+1);
			$conditionw = array('seourl'=>$seourl);
			$this->product_model->update_details(PRODUCT,$dataArrw,$conditionw);
			if($this->checkLogin('U')!=""){
				$activity_id=$this->data['preview_item_detail']['id'];
				$this->product_model->ExecuteQuery("UPDATE ".NOTIFICATIONS." SET `view_mode` = 'No' WHERE activity_id=".$activity_id." AND (activity='favorite item' OR activity='unfavorite item')");
			}

			$this->data['cat_link'] = $this->product_model->get_category_link( $this->data['preview_item_detail']['id']);
			if( $this->data['preview_item_detail']['variable_product'] ) {
				$variation_new = array();
				$options = array();
				$options = $this->product_model->get_cart_product_options($this->data['preview_item_detail']['id']);
//file_put_contents('d:/serveglobal/shopsatavenue/gvtest.txt', print_r( $options, 1) );
				$variation_new = $this->product_model->get_cart_product_variations($this->data['preview_item_detail']['id']);
				$this->data['options'] = $options;
				$this->data['option_values'] = $this->product_model->get_product_option_values( $this->data['preview_item_detail']['id'] );
				$this->data['variations'] = $variation_new;
			}
			
			$this->data['product_shipping'] = $this->product_model->get_product_shipping($this->data['preview_item_detail']['id']);

			$sellerid=$dataArr['user_id'];
			//get promotions
			$this->data['prod_promo'] = $this->product_model->getPromotionsByID($this->data['preview_item_detail']['id']);
			$this->data['store_promo'] = $this->product_model->getStorePromotions($sellerid);
			
			//Price Calculation
			//simple product (without variation)
			
			//Store discount
			$pro_disc_price = 0.0;
			$sotre_disc_price = 0.0;
			if( isset($this->data['prod_promo']) ||  isset($this->data['msrp_discount_per']) )  {
				if(  strtotime($this->data['prod_promo']['start_date'] ) <= strtotime( date('Y-m-d')  ) 
				   && strtotime( date('Y-m-d') ) <= strtotime($this->data['prod_promo']['end_date']) ) {
					$pro_disc_price = ( $dataArr['price'] / 100 * $this->data['prod_promo']['discount_percent']);
				}
				if(  strtotime($this->data['store_promo']['start_date'] ) <= strtotime( date('Y-m-d') ) 
				   && strtotime( date('Y-m-d') ) <= strtotime($this->data['store_promo']['end_date']) ) {
					$store_disc_price = ( $dataArr['price'] / 100 * $this->data['store_promo']['discount_percent']);
				}
			}
			//sale is available then calculate price
			if ( $pro_disc_price > 0.0 || $store_disc_price > 0.0 ) {
				 if ( $pro_disc_price > $store_disc_price ) {
				 	$this->data['new_price'] = $dataArr['price'] - $pro_disc_price;
					$this->data['store_disc_price'] = $pro_disc_price;
					$this->data['store_disc_percent'] = $this->data['prod_promo']['discount_percent'];
				 } else {
 				 	$this->data['new_price'] = $dataArr['price'] - $store_disc_price;
					$this->data['store_disc_price'] = $store_disc_price;
					$this->data['store_disc_percent'] = $this->data['store_promo']['discount_percent'];
				 }
			} else {
			 	$this->data['new_price'] = $dataArr['price'];
			}
			$this->data['new_discount_price'] =  $dataArr['msrp'] - $this->data['new_price']; 
			$this->data['new_discount_percent'] = ( $this->data['new_discount_price'] * 100 ) / $dataArr['msrp'];

			//msrp discount
			if ( (float) $dataArr['msrp'] == (float) $dataArr['price'] ) {
				$this->data['msrp_disc_price'] = 0.0;
			} else {
				$this->data['msrp_disc_price'] = $dataArr['msrp'] - $dataArr['price'];
				$this->data['msrp_discount_per'] = ( $this->data['msrp_disc_price'] * 100 ) / $dataArr['msrp'];
			}

			$columns='*';
			$product_id=$this->data['preview_item_detail']['id'];
			
			$this->data['selectedSeller_details']=$this->seller_model->display_seller_view_admin($sellerid);
		$condition = " where p.quantity>0 and p.status='Publish' and u.group='Seller' and u.status='Active' and p.id!='".$product_id."' and p.user_id='".$sellerid."' group by p.id order by p.created desc";
			$this->data['shopProductDetails'] = $this->product_model->view_product_details($condition)->result_array();	
			$this->data['ProductFavoriteCount']= $this->product_model->getUserFavoriteProductCount($product_id);

			$this->data['productReview']=$this->product_model->get_productfeed_details($this->data['preview_item_detail']['user_id'])->result_array();
			

		 	$imgArr = explode(',', $this->data['preview_item_detail']['image']);
			$img = '';
			foreach ($imgArr as $imgVal){
				if ($imgVal != ''){
					$img = $imgVal;
					break;
				}
			}

			$this->data['heading'] = $this->data['preview_item_detail']['product_name'].' by '.$this->data['selectedSeller_details']['seller_businessname'].' on '.$this->config->item('email_title');
			$this->data['meta_title'] =$this->data['preview_item_detail']['product_name'].' by '.$this->data['selectedSeller_details']['seller_businessname'].' on '.$this->config->item('email_title');
			$this->data['meta_keyword'] = $this->data['preview_item_detail']['tag'];
			$this->data['meta_description'] =substr($this->data['preview_item_detail']['description'],0,150);
			$this->data['meta_product_img'] = $img;
			$this->data['meta_product_url'] = 'products/'.$this->data['preview_item_detail']['seourl'];
			$order=' order by fp.id desc';
			$condition = " where fp.expire_date >='".date('Y-m-d')."'and fp.start_date <= '".date('Y-m-d')."' and fp.page='product detail' and p.status='Publish' and p.pay_status='Paid'  and u.group='Seller' and u.status='Active'  group by p.id ".$order." limit 12";
			$this->data['product_list'] = $this->product_model->view_product_details($condition,'opt');
			
			/*$qry_str1 = base_url();
			$qry_str = $qry_str1.'site/product/featureProPaginamtion?pg=2';

			if( $this->data['product_list']->num_rows() > 0){
				$paginationDisplay  = '<a title="'.$newPage.'" class="landing-btn-more" href="'.$qry_str.'" style="display: none;">See More Products</a>';
			}else{
				$paginationDisplay  = '<a title="'.$newPage.'" class="landing-btn-more" style="display: none;"></a>';
			}
			
			$this->data['paginationDisplay'] = $paginationDisplay;*/
			$this->data['related_items'] = $this->product_model->getRelatedProducts( $this->data['preview_item_detail']['category_id'] );

			$this->load->view('site/product/product_detail_ajax',$this->data);
	}
	
	/**
	 * 
	 * This function load the product detail page
	 * @param String $seourl
	 * 
	 * return Array
	 */
	 
	public function display_product_detail($seourl){
	
			$dataArr=$this->data['preview_item_detail']=$this->product_model->view_published_product_detail($seourl)->result_array();   

			if(count($dataArr) == 0){
				show_404();
			}else{
				if($dataArr[0]['status'] == 'UnPublish' || $dataArr[0]['status'] == 'Pending'){ 
					if($dataArr[0]['user_id'] == $this->checkLogin('U') || $this->checkLogin('U')==1 || $this->checkLogin('A') != ''){					
					} else {
						show_404();
					}
				}
			}


			/* update View Count*/
			$dataArrw = array('view_count'=>$this->data['preview_item_detail'][0]['view_count']+1);
			$conditionw = array('seourl'=>$seourl);
			$this->product_model->update_details(PRODUCT,$dataArrw,$conditionw);
			if($this->checkLogin('U')!=""){
				$activity_id=$this->data['preview_item_detail'][0]['id'];
				$this->product_model->ExecuteQuery("UPDATE ".NOTIFICATIONS." SET `view_mode` = 'No' WHERE activity_id=".$activity_id." AND (activity='favorite item' OR activity='unfavorite item')");
			}

			$columns='*';
			$sellerid=$dataArr['0']['user_id'];
			$product_id=$this->data['preview_item_detail'][0]['id'];
			$this->data['selectedSeller_details']=$this->seller_model->display_seller_view_admin($sellerid);
		$condition = " where p.quantity>0 and p.status='Publish' and u.group='Seller' and u.status='Active' and p.id!='".$product_id."' and p.user_id='".$sellerid."' group by p.id order by p.created desc";
			$this->data['shopProductDetails'] = $this->product_model->view_product_details($condition)->result_array();	
			$this->data['ProductFavoriteCount']= $this->product_model->getUserFavoriteProductCount($product_id);

			$this->data['shipping_details']=$this->product_model->get_all_details(SUB_SHIPPING,array('product_id'=> $this->data['preview_item_detail'][0]['id']))->result_array();
			$this->data['productReview']=$this->product_model->get_productfeed_details($this->data['preview_item_detail'][0]['user_id'])->result_array();
			//print_r($this->data['productReview']);die;
			$this->data['subProduct']=$this->product_model->get_all_details(SUBPRODUCT,array('product_id'=> $this->data['preview_item_detail'][0]['id'],'digital_item !='=>''));
		 $imgArr = explode(',', $this->data['preview_item_detail'][0]['image']);
			$img = '';
			foreach ($imgArr as $imgVal){
				if ($imgVal != ''){
					$img = $imgVal;
					break;
				}
			}
			$this->data['heading'] = $this->data['preview_item_detail'][0]['product_name'].' by '.$this->data['selectedSeller_details'][0]['seller_businessname'].' on '.$this->config->item('email_title');
			$this->data['meta_title'] =$this->data['preview_item_detail'][0]['product_name'].' by '.$this->data['selectedSeller_details'][0]['seller_businessname'].' on '.$this->config->item('email_title');
			$this->data['meta_keyword'] =$this->data['preview_item_detail'][0]['tag'];
			$this->data['meta_description'] =substr($this->data['preview_item_detail'][0]['description'],0,150);
			$this->data['meta_product_img'] = $img;
			$this->data['meta_product_url'] = 'products/'.$this->data['preview_item_detail'][0]['seourl'];
			$order=' order by fp.id desc';
			$condition = " where fp.expire_date >='".date('Y-m-d')."'and fp.start_date <= '".date('Y-m-d')."' and fp.page='product detail' and p.status='Publish' and p.pay_status='Paid'  and u.group='Seller' and u.status='Active'  group by p.id ".$order." limit 12";
			$this->data['product_list'] = $this->product_model->view_product_details($condition,'opt');

			
			if( $this->data['preview_item_detail'][0]['variable_product'] ) {
				$variation_new = array();
				$options = array();
				$options = $this->product_model->get_cart_product_options($this->data['preview_item_detail'][0]['id']);
				$variation_new = $this->product_model->get_cart_product_variations($this->data['preview_item_detail'][0]['id']);
				$this->data['options'] = $options;
				$this->data['option_values'] = $this->product_model->get_product_option_values( $this->data['preview_item_detail'][0]['id'] );
				$this->data['variations'] = $variation_new;
			}

			$this->data['product_shipping'] = $this->product_model->get_product_shipping($this->data['preview_item_detail'][0]['id']);

			//get promotions
			$this->data['prod_promo'] = $this->product_model->getPromotionsByID($this->data['preview_item_detail'][0]['id']);
			$this->data['store_promo'] = $this->product_model->getStorePromotions($sellerid);

			//Price Calculation
			//simple product (without variation)
			
			//Store discount
			$pro_disc_price = 0.0;
			$sotre_disc_price = 0.0;
			$dataArr = $this->data['preview_item_detail'][0];
			if( isset($this->data['prod_promo']) ||  isset($this->data['msrp_discount_per']) )  {
				if(  strtotime($this->data['prod_promo']['start_date'] ) <= strtotime( date('Y-m-d')  ) 
				   && strtotime( date('Y-m-d') ) <= strtotime($this->data['prod_promo']['end_date']) ) {
					$pro_disc_price = ( $dataArr['price'] / 100 * $this->data['prod_promo']['discount_percent']);
				}
				if(  strtotime($this->data['store_promo']['start_date'] ) <= strtotime( date('Y-m-d') ) 
				   && strtotime( date('Y-m-d') ) <= strtotime($this->data['store_promo']['end_date']) ) {
					$store_disc_price = ( $dataArr['price'] / 100 * $this->data['store_promo']['discount_percent']);
				}
			}
			//sale is available then calculate price
			if ( $pro_disc_price > 0.0 || $store_disc_price > 0.0 ) {
				 if ( $pro_disc_price > $store_disc_price ) {
				 	$this->data['new_price'] = $dataArr['price'] - $pro_disc_price;
					$this->data['store_disc_price'] = $pro_disc_price;
					$this->data['store_disc_percent'] = $this->data['prod_promo']['discount_percent'];
				 } else {
 				 	$this->data['new_price'] = $dataArr['price'] - $store_disc_price;
					$this->data['store_disc_price'] = $store_disc_price;
					$this->data['store_disc_percent'] = $this->data['store_promo']['discount_percent'];
				 }
			} else {
			 	$this->data['new_price'] = $dataArr['price'];
			}
			$this->data['new_discount_price'] =  $dataArr['msrp'] - $this->data['new_price']; 
			$this->data['new_discount_percent'] = ( $this->data['new_discount_price'] * 100 ) / $dataArr['msrp'];

			//msrp discount
			if ( (float) $dataArr['msrp'] == (float) $dataArr['price'] ) {
				$this->data['msrp_disc_price'] = 0.0;
			} else {
				$this->data['msrp_disc_price'] = $dataArr['msrp'] - $dataArr['price'];
				$this->data['msrp_discount_per'] = ( $this->data['msrp_disc_price'] * 100 ) / $dataArr['msrp'];
			}

			$this->data['related_items'] = $this->product_model->getRelatedProducts( $this->data['preview_item_detail'][0]['category_id'] );
			$this->load->view('site/product/product_detail',$this->data);
				
	}
	


	/**
	 * 
	 * This function delete the product in seller list
	 * 
	 */
	public function delete_product(){
		$pid = $this->uri->segment(2,0);
		if ($this->checkLogin('U')==''){
			redirect('login');
		}else {
			$productDetails = $this->product_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$pid));
			if ($productDetails->num_rows()==1){
				if ($productDetails->row()->user_id == $this->checkLogin('U')){
					$this->product_model->commonDelete(USER_PRODUCTS,array('seller_product_id'=>$pid));
					$productCount = $this->data['userDetails']->row()->products;
					$productCount--;
					$this->product_model->update_details(USERS,array('products'=>$productCount),array('id'=>$this->checkLogin('U')));
					$this->product_model->commonDelete(SUBPRODUCT,array('product_id' => $productDetails->row()->id));
					$this->setErrorMessage('success','Product deleted successfully');
					redirect('user/'.$this->data['userDetails']->row()->user_name.'/added');
				}else {
					show_404();
				}
			}else {
				$productDetails = $this->product_model->get_all_details(PRODUCT,array('seller_product_id'=>$pid));
				if ($productDetails->num_rows()==1){
					if ($productDetails->row()->user_id == $this->checkLogin('U')){
						$this->product_model->commonDelete(PRODUCT,array('seller_product_id'=>$pid));
						$productCount = $this->data['userDetails']->row()->products;
						$productCount--;
						$this->product_model->update_details(USERS,array('products'=>$productCount),array('id'=>$this->checkLogin('U')));
						$this->product_model->commonDelete(SUBPRODUCT,array('product_id' => $productDetails->row()->id));
						$this->setErrorMessage('success','Product deleted successfully');
						redirect('user/'.$this->data['userDetails']->row()->user_name.'/added');
					}else {
						show_404();
					}
				}else {
					show_404();
				}
			}
		}
	}

	
	/**
	 * 
	 * This function load the level 1 subcategorty from add shop list items usign ajax
	 * 
	 */

	public function select_ajax_level1_subcategory(){
	  if($this->lang->line('shop_sub_selectcategory') != '') { 
			$sel_cat= stripslashes($this->lang->line('shop_sub_selectcategory')); 
		} 
		else {
			$sel_cat= "Select a sub category";
		}
	  
		$selectSubcatval = $this->product_model->get_all_details(CATEGORY,array('rootID'=>$this->input->get('main_cat_id'),'status'=> 'Active'));
		if($selectSubcatval->num_rows() > 0){
		 echo '<option value="">'.$sel_cat.'</option>';
		 foreach($selectSubcatval->result() as $MaincatValues) {
			 
         echo '<option value="'.$MaincatValues->id.'">'.$MaincatValues->cat_name.'</option>'; 
		 } } else {
		 
		 echo 'Nocat';}
		
	}
	

	/**
	 * 
	 * This function check the image1 width and size, copy the image to temp folder
	 * 
	 */
	public function ajax_load_images(){
		
			list($w, $h) = getimagesize($_FILES["image_upload"]["tmp_name"]);
			if($w >= 550 && $h >= 350){
			
				$path = "images/product/temp_img/"; 
				$imgRnew = @explode('.',$_FILES["image_upload"]["name"]);
			    $NewImg = url_title($imgRnew[0], '-', TRUE);
		    	$ImgTmpName = $NewImg.'.'.$imgRnew[1];
			
				if($ImgTmpName != ''){
			 		move_uploaded_file($_FILES["image_upload"]["tmp_name"], $path.$ImgTmpName);
					echo 'Success|'.$path.$ImgTmpName;
		   		}
			}else{
				$errormessage=addslashes(shopsy_lg('lg_upload_img_too_small','Upload Image Too Small. Please Upload Image Size More than or Equalto 550 X 350 .'));
				echo 'Failure|'.$errormessage;
			}
				
	}
	
	
	/**
	 * 
	 * This function check the image2 width and size, copy the image to temp folder
	 * 
	 */
	public function ajax_load_images1(){
		   list($w, $h) = getimagesize($_FILES["image_upload1"]["tmp_name"]);
		if($w >= 550 && $h >= 350){
			
				$path = "images/product/temp_img/"; 
				$imgRnew = @explode('.',$_FILES["image_upload1"]["name"]);
				$NewImg = url_title($imgRnew[0], '-', TRUE);
				$ImgTmpName = $NewImg.'.'.$imgRnew[1];
				if($ImgTmpName != ''){
					move_uploaded_file($_FILES["image_upload1"]["tmp_name"], $path.$ImgTmpName);
					echo 'Success|'.$path.$ImgTmpName;
			   }
			}else{
			$errormessage=addslashes(shopsy_lg('lg_upload_img_too_small','Upload Image Too Small. Please Upload Image Size More than or Equalto 550 X 350 .'));
				echo 'Failure|'.$errormessage;
			}				   
	}
	
	/**
	 * 
	 * This function check the image3 width and size, copy the image to temp folder
	 * 
	 */
	public function ajax_load_images2(){
		 list($w, $h) = getimagesize($_FILES["image_upload2"]["tmp_name"]);
			if($w >= 550 && $h >= 350){
			
				$path = "images/product/temp_img/"; 
				$imgRnew = @explode('.',$_FILES["image_upload2"]["name"]);
				$NewImg = url_title($imgRnew[0], '-', TRUE);
				$ImgTmpName = $NewImg.'.'.$imgRnew[1];
				if($ImgTmpName != ''){
					move_uploaded_file($_FILES["image_upload2"]["tmp_name"], $path.$ImgTmpName);
					echo 'Success|'.$path.$ImgTmpName;
			   }
			}else{
				$errormessage=addslashes(shopsy_lg('lg_upload_img_too_small','Upload Image Too Small. Please Upload Image Size More than or Equalto 550 X 350 .'));
				echo 'Failure|'.$errormessage;
			}	
	}
	
	/**
	 * 
	 * This function check the image4 width and size, copy the image to temp folder
	 * 
	 */
	public function ajax_load_images3(){
		   list($w, $h) = getimagesize($_FILES["image_upload3"]["tmp_name"]);
			if($w >= 550 && $h >= 350){
			
				$path = "images/product/temp_img/"; 
				$imgRnew = @explode('.',$_FILES["image_upload3"]["name"]);
				$NewImg = url_title($imgRnew[0], '-', TRUE);
				$ImgTmpName = $NewImg.'.'.$imgRnew[1];
				if($ImgTmpName != ''){
					move_uploaded_file($_FILES["image_upload3"]["tmp_name"], $path.$ImgTmpName);
					echo 'Success|'.$path.$ImgTmpName;
			   }  
			}else{
				$errormessage=addslashes(shopsy_lg('lg_upload_img_too_small','Upload Image Too Small. Please Upload Image Size More than or Equalto 550 X 350 .'));
				echo 'Failure|'.$errormessage;
			}	
		
	}
	
	/**
	 * 
	 * This function check the image5 width and size, copy the image to temp folder
	 * 
	 */
	public function ajax_load_images4(){
		    list($w, $h) = getimagesize($_FILES["image_upload4"]["tmp_name"]);
			if($w >= 550 && $h >= 350){
			
				$path = "images/product/temp_img/"; 
				$imgRnew = @explode('.',$_FILES["image_upload4"]["name"]);
				$NewImg = url_title($imgRnew[0], '-', TRUE);
				$ImgTmpName = $NewImg.'.'.$imgRnew[1];
				if($ImgTmpName != ''){
					move_uploaded_file($_FILES["image_upload4"]["tmp_name"], $path.$ImgTmpName);
					echo 'Success|'.$path.$ImgTmpName;
			   }
			 }else{
			$errormessage=addslashes(shopsy_lg('lg_upload_img_too_small','Upload Image Too Small. Please Upload Image Size More than or Equalto 550 X 350 .'));
				echo 'Failure|'.$errormessage;
			}	
	}
	

	/**
	 * 
	 * This function search the products 
	 * @param String $item
	 * 
	 */
	
	public function search_product($item1 = '', $item2 = ''){

		if(isset($_SERVER['HTTPS'])){
        	$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https://" : "http://";
	    } else {
			$protocol = 'http://';
	    }	
		
		$CUrurl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$curUrl = @explode('&pg=',$CUrurl);
		

		$item_search='';  $s_key='';
		//$s_key=strip_tags( mysql_real_escape_string($this->input->get('item') ) ); 
		
		if ( $item1 ==  'cat' ) {
			$category = explode( '-', $item2);
			$this->data['product_list'] = $this->db->select('id,product_name,seourl, image, user_id, store_id, price')->from('shopsy_product')
												//->like('product_name', $s_key, 'both' )
												->where( array('status' => 'Publish', 'category_id' => $category[0] ) )
												->limit(52)
												->get()->result_array();
		} else {
		
			$s_key = strip_tags( $this->input->get('item') );
			if( $s_key != '' ) {
				$this->data['product_list'] = $this->db->select('id,product_name,seourl, image, user_id, store_id, price')->from('shopsy_product')
													->or_like('product_name', $s_key, 'both' )
													->or_like('description', $s_key, 'both' )
													->where( array('status' => 'Publish') )
													->limit(52)
													->get()->result_array();
			} else {
				$this->data['product_list'] = $this->db->select('id,product_name,seourl, image, user_id, store_id, price')->from('shopsy_product')
													->where( array('status' => 'Publish') )
													->limit(52)
													->get()->result_array();
			}
		}

		$this->data['main_cat_qry'] = $this->db->select('id,cat_name,seourl')->from('shopsy_category')
								 ->where( array( 'status' => 'Active', 'rootID' => 0 ) )
								 ->get();
                
		$this->load->view('site/product/product_search',$this->data);
	}
	
	
	/**
	 * 
	 * Upload the product form for csv file upload
	 * 
	 */
	public function upload_product_form(){
		if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
    		$this->data['heading'] = 'Upload CSV';
    		$this->data['countryList'] = $this->user_model->get_all_details(COUNTRY_LIST,array(),array(array('field'=>'name','type'=>'asc')));
	    	$this->data['shippingList'] = $this->user_model->get_all_details(SHIPPING_ADDRESS,array('user_id'=>$this->checkLogin('U')));
    		$this->load->view('site/shop/upload_csv',$this->data);
    	}
	}
	
	
	/**
	 * 
	 * Custom Field Selection while Uploading CSV File
	 * 
	 */
	public function custom_upload_product_form(){
		if ($this->checkLogin('U')==''){
    		redirect(base_url().'login');
    	}else {
    		$this->data['heading'] = 'Upload CSV';
			$this->data['Coloums'] =array('');
    		$this->load->view('site/shop/custom_upload_csv',$this->data);
    	}
	}
	
	/**
	 * 
	 * Custom Uploading File for CSV upload
	 * 
	 */
	public function custom_uploading_file(){
		$file = $this->input->post('upload_csv');
		$fileDirectory ='./images/csv';
		if(!is_dir($fileDirectory)){
			mkdir($fileDirectory,0777);
		}
		$config['overwrite'] = FALSE;
		$config['remove_spaces'] = TRUE;
		$config['upload_path'] = $fileDirectory;
		$config['allowed_types'] = 'csv';

		$this->load->library('upload', $config);

		$file_element_name = 'upload_csv';
		if( $this->upload->do_upload('upload_csv')){
			$fileDetails = $this->upload->data();
			$coun = 0; $row = 1;
			$handle = fopen($fileDirectory."/".$fileDetails['file_name'],"r");
			$data1 = fgetcsv($handle, 10000, ",");
#			if(sizeof($data1)>2){
			if(($data1 = fgetcsv($handle, 10000, ",")) !== FALSE){
				echo 'Success|'.$fileDetails['file_name'];
			}else{
				echo 'Failure|CSV File cannot uploaded';
			}
		}else {
			echo 'Failure|'.strip_tags($this->upload->display_errors());
		}
		fclose($handle);
	}
	public function get_coloum_names($file_name=''){
		$fileDirectory ='./images/csv';
		$handle = fopen($fileDirectory."/".$file_name,"r");
		$data = fgetcsv($handle, 10000, ",");
		#echo implode('|^|',$data);
		if(!empty($data)){
			$select='<select><option value="">Select Column</option>';
			foreach($data as $cols){
				$select.='<option>'.$cols.'</option>';
			}
			$select.='</select>';
		}else{
			$select='';
		}
		echo $select;
		fclose($handle);
	}
	
	public function images_resize(){
		echo "############";
//  		$this->thumbimage_resize('images/product/org-image/','images/product/thumb/','245');
//  		$this->thumbimage_resize('images/product/org-image/','images/product/','550');
//  		$this->thumbimage_resize('images/product/org-image/','images/product/list-image/','75');
		$this->thumbimage_resize('images/product/org-image/','images/product/mb/thumb/','350');
		echo "############";
	}
	
	public function images_crop(){
		echo "############";
// 			$this->thumbimage_resize('images/product/org-image/','images/product/cropsmall/','108','92');
// 			$this->thumbimage_resize('images/product/org-image/','images/product/cropmed/','285','215');
// 			$this->thumbimage_resize('images/product/org-image/','images/product/cropthumb/','75','75');
			
// 		if( is_dir('images/product/mb/crop/') ) {
// 			echo "The Directory {$new_path} exists";
// 		}else{
// 			echo "The Directory {$new_path} not exists";
// 			mkdir('images/product/mb/crop/');
// 		}
// 		die;

		$this->thumbimage_resize('images/product/org-image/','images/product/mb/crop/','350','350');
		echo "############";
	}
	

	function shopify_product_selection() {
		set_time_limit(0);
		$user_id =  $this->checkLogin('U');
		$shop_qry = $this->db->select('id')->from('shopsy_seller')->where( array('seller_id' => $user_id ) )->get();
		if( ! $shop_qry->num_rows() ) {
			echo "error|Invalid shop";
			exit(0);
		}
		$shop_id = $shop_qry->first_row()->id;
		$api_info = $this->db->select('*')->from('sa_sales_channels')
							->where( array( 'shop_id' => $shop_id, 'channel_name' => 'shopify' ) )
							->get()->first_row();

		$page_no = $this->input->post('page_no');
		if ( $page_no <= 0 ) $page_no = 1;

		//Live
		$baseUrl = "https://" . $api_info->api_user . ":" . $api_info->api_password . "@" . $api_info->api_endpoint;

		//Test
		//$baseUrl = "https://7201911da6b2de2da133b75beb09a706:e1a93855a6e0784d18682999aee0bb8d@vistashops-test-store.myshopify.com/admin/";

		//Add trailing slash if not there
		if ( substr( $baseUrl, -1) != '/' ) $baseUrl .= '/';
		
		$response = json_decode( $this->ShopifyAPICall( $baseUrl.'products/count.json' ) ); //request it from the shopify api
		$productCount = $response->count; //get the count parameter
		$this->data['total_pages'] = $productCount > 0 ? ceil( $productCount / 50 ) : 0;

		$url = $baseUrl. "products.json?page=" . $page_no ."&fields=id,image,title";

		$this->data['result'] = json_decode( $this->ShopifyAPICall( $url ) );
		if ( count( $this->data['result']->products ) > 0 ) {
			$products = $this->data['result']->products;
			$import_products = $products[0]->id;
			for( $i=1; $i < count($products); $i++ )   {
				$import_products .= ',' . $products[$i]->id;
			}
			
			$product_exist = $this->db->select('shopify_id')->from('shopify_product_import')
					 				  			->where( array( 'shop_id' => $shop_id ) )
									  			->where( 'shopify_id in ( ' . $import_products . ' ) ' )
									  			->get()->result();
			foreach( $product_exist as $product ) {
				$this->data['product_exist'][] = $product->shopify_id;
			}
		}
		$this->data['page_no'] = $page_no;
   		$this->load->view('site/import/shopify_import_selection',$this->data);

	}
	
	function import_shopify_products() {

		set_time_limit(0);
		$json = array();
		$user_id =  $this->checkLogin('U');
		$shop_qry = $this->db->select('id')->from('shopsy_seller')->where( array('seller_id' => $user_id ) )->get();
		if( ! $shop_qry->num_rows() ) {
			echo json_encode( $json = array( 'status' => "error" , 'message' => 'Invalid Shop' ) );
			exit(0);
		}
		$selected_products = $this->input->post('selProducts');

		$shop_id = $shop_qry->first_row()->id;
		$api_info = $this->db->select('*')->from('sa_sales_channels')
							->where( array( 'shop_id' => $shop_id, 'channel_name' => 'shopify' ) )
							->get()->first_row();
		$baseUrl = "https://" . $api_info->api_user . ":" . $api_info->api_password . "@" . "vista-shops.myshopify.com/admin/";

		
		//Test
		//$baseUrl = "https://7201911da6b2de2da133b75beb09a706:e1a93855a6e0784d18682999aee0bb8d@vistashops-test-store.myshopify.com/admin/";
		
		//Live
		//$baseUrl = "https://5008d05889e3e460249c8002f77fa0f2:edd972ada7e6c58cee873f0ec1e866a5@vista-shops.myshopify.com/admin/";
		//$url = $baseUrl. "products.json?limit=1&since_id=3140866693";

		//$headers = get_headers($baseUrl.'shop.json', 1); //this will fetch the headers from Shopify and the second parameter specifies the function to parse it into an array structure

		//$apiLimit = (int) str_replace('/500', '', $headers['HTTP_X_SHOPIFY_SHOP_API_CALL_LIMIT']); //since Shopify returns the API limit as x/500 I remove the /500 and convert the call value to integer.  Now you can use this to identify how many calls you have left.
	  

		//$response = json_decode(file_get_contents($baseUrl.'products/count.json')); //request it from the shopify api
		//$productCount = $response->count; //get the count parameter
		//$pages = ceil($productCount/250); //get the amount of pages with max 250 products per page


		$current_page = 1;
		//while ( $current_page <= 3 ) { 
		
			//$response = json_decode(file_get_contents( $url.'?page=1'. ( $api_info->last_import_id > 0 ? '&since_id=' . $api_info->last_import_id : '' ) ) ); 
			//$response = json_decode( $this->ShopifyAPICall( $url.'?page=1'. ( $api_info->last_import_id > 0 ? '&since_id=' . $api_info->last_import_id : '' )  ) );
			//file_put_contents( FCPATH."logs/shopify_import.txt",  print_r( $response, 1)  );
		try {

			for ( $m=0; $m < count($selected_products) ; $m++  ) {
				$url = $baseUrl. "products/";
				$url .=  $selected_products[$m] . '.json' ;
				$response = json_decode( $this->ShopifyAPICall( $url ) );

				$product = $response->product;

				$shopify = $this->db->select( 'count(*) as total' )->from('shopify_product_import')->where( array( 'shopify_id' => $product->id, 'shop_id' => $shop_id ))->get()->first_row();

				if ( $shopify->total > 0 ) { 
					//file_put_contents( FCPATH."logs/shopify_import_log.txt",  $product->id . "\r\n", FILE_APPEND );
					$fp = fopen( FCPATH."logs/shopify_import_log.txt", 'a' );
					fwrite($fp, "Product already exist: " . $product->id . "\r\n");
					fclose($fp);
					continue; 
				}

				$cat_id = 0;
				if( $product->tags != '' ) {
					$cat_qry = $this->db->select('id')->from('shopsy_category')->where( array( 'cat_name' => $product->tags ) )->get();
					if( $cat_qry->num_rows() ) {
						$cat_id = $cat_qry->first_row()->id;
					}
				}

				$data = array(
					'product_name' => $product->title,
					'seourl' => $product->handle,
					'description' => $product->body_html,
					'category_id' => $cat_id,
					'store_id' => $shop_id,
					'user_id'  => $user_id,
					'status' => ( $product->published_at != '' ? 'Publish' : 'Draft' ),
					'price' => $product->variants[0]->price, //base price
					'msrp' => (float) $product->variants[0]->compare_at_price, //base msrp price
					'variable_product' =>  (count($product->options) == 1 && $product->options[0]->values == 'Default Title' ) ? 0 : 1,
					'tag' => $product->tags,
					'created' => date('Y-m-d H:i:s'),
					'modified' => date('Y-m-d H:i:s')
				);
				$this->db->insert('shopsy_product', $data );
				$product_id = $this->db->insert_id();
				
				//images
				$image = '';
				$j=1;
				for($i=0; $i < count($product->images); $i++ ) {
					$image_path = FCPATH."images/product/" . $product_id;
					if ( ! file_exists($image_path)) {
						@mkdir($image_path, 0777, true);
					}
					$file_name = $product->handle . "_" . $j . ".jpg";
					//file_put_contents( $image_path."/".$file_name, file_get_contents( $product->images[$i]->src ) );
					$this->grab_image( $product->images[$i]->src, $image_path."/".$file_name ); 
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

					//
					$image .= $image != '' ? ',' : '';
					$image .= $file_name;
					$j++;
				}
				$this->db->update('shopsy_product', array( 'image' => $image ), array( 'id' => $product_id ) );

				$this->db->insert('shopify_product_import', array( 'product_id' => $product_id, 'shopify_id' => $product->id, 'product_name' => $product->title, 'shop_id' => $shop_id ) );
				
				//insert default shipping cost
				$data = array( 
					'product_id' => $product_id, 
					'code' => 'CUS', 
					'description' => 'Continental United States', 
					'ship_price' => '2.95', 
					'next_item_price' => '2.95'
				);
				$this->db->insert('shopsy_product_shipping', $data );
				
				//simple product - no variations
				if( count($product->options) == 1 && $product->options[0]->values == 'Default Title' ) {
					$data = array(
					   'product_id' => $product_id,
					   'quantity' => $product->variants[0]->inventory_quantity,
					   'price' => $product->variants[0]->price,
					   'msrp' => (float) $product->variants[0]->compare_at_price,
					   'sku' => $product->variants[0]->sku,
					   'upc' => $product->variants[0]->barcode,
					   'date_created' => date('Y-m-d H:i:s')
					);
					$this->db->insert('shopsy_product_variation' , $data);
				} else {
					$options = array();
					$option_values =  array();
					
					for($i=0; $i < count( $product->options ); $i++ ) {
						if (  $product->options[$i]->name == 'Color' ) $option_type_id = 2;
						else if (  $product->options[$i]->name == 'Size' ) $option_type_id = 3;
						else $option_type_id = 4;
						$data = array(
							'product_id' => $product_id,
							'option_type_id' => $option_type_id,
							'product_option_name' => $product->options[$i]->name,
							'option_seq_id' => ($i + 1 )
						);
						$this->db->insert('shopsy_product_options', $data );
						$product_option_id = $this->db->insert_id();
						$option = $product->options[$i]->name;
						$options[] = $option;
						//insert values for option
						for($j=0; $j < count( $product->options[$i]->values ); $j++ ) {
							$data = array(
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
							$option_values[ $i ][] = $product->options[$i]->values[$j];
						}
	
					}
					
					//$variants = $this->generate_variants( $option_values );
					
					for( $i=0; $i < count($product->variants); $i++ ) {
						$data = array(
						   'product_id' => $product_id,
						   'option1' => $product->variants[$i]->option1,
						   'option2' => $product->variants[$i]->option2,
						   'option3' => $product->variants[$i]->option3,
						   'quantity' => $product->variants[$i]->inventory_quantity,
						   'price' => $product->variants[$i]->price,
					   	   'msrp' => (float) $product->variants[$i]->compare_at_price,
						   'sku' => $product->variants[$i]->sku,
						   'upc' => $product->variants[$i]->barcode,
						   'date_created' => date('Y-m-d H:i:s')
						);
						$this->db->insert('shopsy_product_variation' , $data);
					}
				}

				//$this->db->update("sa_sales_channels", array( 'last_import_id' => $product->id ), array( 'channel_name' => 'shopify', 'shop_id' => $shop_id ) );

			} //for product loop
			
		} catch(Exception $e) {
  			echo json_encode( $json = array( 'status' => "error" , 'message' => $e->getMessage() ) );
		}
		//}
		
		echo json_encode( $json = array( 'status' => "success" , 'message' =>  "Products Imported successfully!" ) );
	}

	function ShopifyAPICall( $url ) {

		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_TIMEOUT, 300);
		curl_setopt($ch, CURLOPT_HTTPHEADER, 
			array(
				'Accept: application/json', 
				'Content-type: application/json'
				)
		); 

		$response = curl_exec($ch); 
		if( curl_error($ch) )
		{
			//file_put_contents( FCPATH."logs/import_log.txt", date('m-d-Y') . "\t" . $response ."\t" . curl_error($ch) ."\r\n", FILE_APPEND );
			$fp = fopen( FCPATH."logs/import_log.txt", 'a' );
			fwrite($fp, date('m-d-Y') . "\t" . $response ."\t" . curl_error($ch) . "\r\n");
			fclose($fp);
		}
		
		curl_close($ch);
		
		return   $response ;

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
	
	function createImages() {
		$image_qry = $this->db->query("SELECT id, image FROM shopsy_product WHERE id > 27" );

		
		foreach ( $image_qry->result() as $key => $row ) {
			$images = explode(";" , $row->image ) ;
			$product_id = $row->id;
			$image_path = FCPATH."images/product/" . $product_id;
			
			@mkdir($image_path.'/mb', 0777, true);
			@mkdir($image_path.'/mb/thumb', 0777, true);
			@mkdir($image_path.'/mb/crop', 0777, true);
			@mkdir($image_path.'/thumb', 0777, true);
			@mkdir($image_path.'/list-image', 0777, true);
			@mkdir($image_path.'/cropsmall', 0777, true);
			@mkdir($image_path.'/cropmed', 0777, true);
			@mkdir($image_path.'/cropthumb', 0777, true);
			if( is_array( $images ) ) {
				
				//@copy('./images/product/temp_img/'.$image_upload1, './images/product/org-image/'.$timeImg.'-'.$image_upload1);
				for($m=0; $m < count( $images ); $m++ ) {
					$file_name = $image_path . "/" . $images[$m];
					@copy( $file_name, $image_path.'/mb/'.$images[$m] );
					$this->ImageCompress($image_path.'/mb/'.$images[$m]);
						
					@copy( $file_name,  $image_path . '/mb/thumb/' . $images[$m] );
					$this->ImageResizeWithCrop(350, '', $images[$m], './images/product/'. $product_id.'/mb/thumb/');
							
					@copy($file_name, $image_path . '/mb/crop/'. $images[$m]);
					$this->ImageResizeWithCropping(350, 350, $images[$m], './images/product/'. $product_id . '/mb/crop/');
						
					//@copy($file_name, './images/product/'.$timeImg.'-'.$image_upload1);
					//$this->ImageResizeWithCrop(550, '', $timeImg.'-'.$image_upload1, './images/product/');
						
					@copy($file_name, $image_path . '/thumb/'.$images[$m]);
					$this->ImageResizeWithCrop(175, '', $images[$m], './images/product/'. $product_id . '/thumb/');
						
					@copy($file_name, $image_path . '/list-image/'. $images[$m]);
					$this->ImageResizeWithCrop(75, '', $images[$m], './images/product/'. $product_id .'/list-image/');
						
					@copy($file_name, $image_path .'/cropsmall/'.$images[$m]);
					$this->ImageResizeWithCropping(108, 92, $images[$m], './images/product/'. $product_id .'/cropsmall/');
						
					@copy($file_name, $image_path .'/cropmed/'.$images[$m]);
					$this->ImageResizeWithCropping(285, 215, $images[$m], './images/product/'.$product_id . '/cropmed/');
						
					@copy($file_name, $image_path.'/cropthumb/'.$images[$m]);
					$this->ImageResizeWithCropping(75, 75, $images[$m], './images/product/'.$product_id . '/cropthumb/');
				}
			} else {
					$file_name = $image_path . "/" . $row->image;
					@copy( $file_name, $image_path.'/mb/'.$row->image );
					$this->ImageCompress($image_path.'/mb/'.$row->image);
						
					@copy( $file_name,  $image_path . '/mb/thumb/' . $row->image );
					$this->ImageResizeWithCrop(350, '', $row->image, './images/product/'. $product_id.'/mb/thumb/');
							
					@copy($file_name, $image_path . '/mb/crop/'. $row->image);
					$this->ImageResizeWithCropping(350, 350, $row->image, './images/product/'. $product_id . '/mb/crop/');
						
					//@copy($file_name, './images/product/'.$timeImg.'-'.$image_upload1);
					//$this->ImageResizeWithCrop(550, '', $timeImg.'-'.$image_upload1, './images/product/');
						
					@copy($file_name, $image_path . '/thumb/'.$row->image);
					$this->ImageResizeWithCrop(175, '', $row->image, './images/product/'. $product_id . '/thumb/');
						
					@copy($file_name, $image_path . '/list-image/'. $row->image);
					$this->ImageResizeWithCrop(75, '', $row->image, './images/product/'. $product_id .'/list-image/');
						
					@copy($file_name, $image_path .'/cropsmall/'.$row->image);
					$this->ImageResizeWithCropping(108, 92, $row->image, './images/product/'. $product_id .'/cropsmall/');
						
					@copy($file_name, $image_path .'/cropmed/'.$row->image);
					$this->ImageResizeWithCropping(285, 215, $row->image, './images/product/'.$product_id . '/cropmed/');
						
					@copy($file_name, $image_path.'/cropthumb/'.$row->image);
					$this->ImageResizeWithCropping(75, 75, $row->image, './images/product/'.$product_id . '/cropthumb/');
			}
		}
	}
	
	function generate_variants($arrays, $i = 0) {
		if (!isset($arrays[$i])) {
			return array();
		}
		if ($i == count($arrays) - 1) {
			return $arrays[$i];
		}
	
		// get combinations from subsequent arrays
		$tmp = $this->generate_variants($arrays, $i + 1);
	
		$result = array();
	
		// concat each array from tmp with each element from $arrays[$i]
		foreach ($arrays[$i] as $v) {
			foreach ($tmp as $t) {
				$result[] = is_array($t) ? 
					array_merge(array($v), $t) :
					array($v, $t);
			}
		}
	
		return $result;
	}

	public function ajax_load_more() {

		$page_no = (int) $this->input->post('page_no');
		$total_pages = (int) $this->input->post('total_pages');
		$recs_per_page = 52;
		if ( $page_no >=  $total_pages ) $page_no = 0;
		$start = $recs_per_page * $page_no;
		
		if( $page_no == 0 ) {
			$total_recs = $this->db->select('count(*) as total')->from('shopsy_product')
												->where( array('status' => 'Publish') )
												->get()->first_row()->total;
			$this->data['total_pages'] = $total_recs > 0 ? ceil( $total_recs / $recs_per_page ) : 0 ;
		}
		
		$product_list = $this->db->select('id,product_name,seourl, image, user_id, store_id, price')->from('shopsy_product')
												->where( array('status' => 'Publish') )
												->limit( $recs_per_page, $start  )
												->get()->result_array();
		$json = array();
		$json = array( 'status' => 'success', 'product_list' => $product_list, 'page_no' => $page_no, 'total_pages' => $total_pages );
		echo json_encode( $json );
	}
	
	//
}

/*End of file product.php */
/* Location: ./application/controllers/site/product.php */
