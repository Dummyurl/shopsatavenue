
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script>
$('#product_carousel').carousel({
	interval: false
});
$( document ).ready(function() {
	$('[id^=carousel-selector-]').click( function(){
	  var id_selector = $(this).attr("id");
	  var id = id_selector.substr(id_selector.length -1);
	  id = parseInt(id);
	  $('#product_carousel').carousel(id);
	  $('[id^=carousel-selector-]').removeClass('selected');
	  $(this).addClass('selected');
	});
});

</script>
<style>
/*.carousel-inner > .item > img {
	width:auto;
}*/
.selected img {
	opacity:0.5;
}
.nav-tabs {
    border-bottom:none;
}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
	border:none;
	border-bottom:#007FFF 2px solid;
}
.cart-tabs > li > a {
	border:none;
}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
	background:none;
	color:#000000;
}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
	/*border:none;*/
}
#product_carousel   {
	border: thin solid rgba(128, 128, 128, 0.28);
}
.msrp_price {
	text-decoration: line-through;
	padding: 10px 0px 0px;
}
.current_price {
	font-size:18px;
	font-weight:bold;
	color:#F00;
}
.price_info {
	color: red;
	border-bottom: 0.5px solid rgba(0, 0, 0, 0.15);
	padding: 0px 0px 10px;
}
.price_info span {
	float: right;
	margin-right: 100px;
	cursor: pointer;
}


#color_wrapper {
	width:100%;
}
.varbox {    
	 float: left;
    width: 20px;
    height: 20px;
    margin: 5px;
    border-width: 1px;
    border-style: solid;
    border-color: rgba(0,0,0,.2);
	cursor:pointer;
 }
 
 .form-control { margin-left:0px; }
 
 .btn-primary {
background: -moz-linear-gradient(center top , #090909 2%, #121112 8%, #0c0c0c 58%, #090909 95%, #0f0f0f) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;

 }
 .cat-name.cat-price {
    min-height:inherit !important;
}
.info {
	padding:0 0 0 0 !important;
}
.related-listing-inner .realated-brick {
    /*width: 30%;*/
	width: 75px;
}
.related-listing-inner .realated-brick img {
	height: 75px;
	width: 75px;
}
.sell_prod_name {
	padding: 10px;
	border-bottom: 0.5px solid rgba(0, 0, 0, 0.15);
}
.sell_prod_name h1 {
	color:#808080;
	font-family:"Open Sans",Helvetica,Arial,sans-serif;
}
.quantity_box {
	clear:both;
	padding: 10px 0px;
}
#fav-box {
	border-bottom: 0.5px solid rgba(0, 0, 0, 0.15);
	padding: 8px 8px 10px 0px !important;
}
.discount_price {
	float: right;
	color: red;
	margin-right: 150px;
}
.error-msg { width:100%; text-align:center; color:#F00; }
</style>
<div id="product_detail_div">
<section class="container">
  <div class="seller-wrapper">
    <div class="col-md-6 seller"> 
     <div ><?php echo $cat_link; ?></div>
    </div>
    <div class="col-md-6 cart-right-small">
		<div id="close-product-detail-modal" class="close-modal-x" onclick="$('#product_modal').modal('hide');" ><i class="fa fa-times" aria-hidden="true"></i></div>
    </div>
  </div>
  
  <div class="seller-wrapper" style="margin-top:5px;">
  
       <div class="seller-right col-md-7">
           <div id="product_carousel" class="carousel slide" data-ride="carousel" >
                <div class="carousel-inner" style="min-width:0% !important; height:auto !important" >

				<?php 
					$imageArr = explode(',',$preview_item_detail['image']);
					$imgCount = count($imageArr);
					for($i=0; $i < $imgCount; $i++){ 
				?>
                    <div class="<?php echo ($i == 0) ? 'active ' : ''; ?> item" data-slide-number="<?php echo $i;?>" style="width:auto;"  role="listbox" >
                        <img src="<?php echo PRODUCTPATH. $preview_item_detail['id'] ."/". $imageArr[$i]; ?>" class="img-responsive">
                    </div>
				<?php 
					}
				?> 
                </div>           
           </div>
          <div id="slider-thumbs" style="padding: 10px 0px;" >
              <ul class="list-inline" >
				  <?php for($i=0;$i<$imgCount;$i++) {  ?>
                  <li data-target="#product_carousel" data-slide-to="<?php echo $i;?>" > 
                      <a id="carousel-selector-0" class="<?php echo ($i == 0) ? 'selected' : ''; ?>">
                        <img src="<?php echo PRODUCTPATH.$preview_item_detail['id'].'/cropthumb/'. $imageArr[$i]; ?>" class="img-responsive">
                      </a>
                  </li>
				  <?php }  ?>
              </ul>
          </div> <!-- slider thumbs -->

          <div role="tabpanel" class="tab-content"> 
           <!-- Nav tabs -->
            <ul class="nav nav-tabs cart-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#itemdetails" aria-controls="itemdetails" role="tab" data-toggle="tab">Description</a>
                </li>
                <li role="presentation" id="reviewTabbar">
                    <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Shipping</a>
                 </li>
                <li role="presentation">
                        <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Return Policy</a>
                </li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content cart-content">
                <div role="tabpanel" class="tab-pane fade in active" id="itemdetails">
                    <div id="description-text"> 
                    <?php if($preview_item_detail['description'] != ''){ ?>                        
                         <?php echo $preview_item_detail['description'];
                            }
                         ?>
                    </div>
                 </div>
                
                 <div role="tabpanel" class="tab-pane fade" id="profile">
                     <div class="shipping-tab ">
                        <div id="ship_rates">
                        	 <div class="col-md-5"><b>Ship place</b></div>
                             <div class="col-md-2"><b>Cost</b></div>
                             <div class="col-md-3"><b>Additional item</b></div>
                        <?php foreach ( $product_shipping['rates'] as $code => $rate_row ) { 
                        	$rate_row['next_item_price'] = ( (int) $rate_row['next_item_price'] == 0 ) ? $rate_row['ship_price'] : $rate_row['next_item_price'];
						?>
                             <div>
                             <div class="col-md-5"><?php echo $rate_row['description']; ?></div>
                             <div class="col-md-2">$<?php echo number_format($rate_row['ship_price'], 2); ?></div>
                             <div class="col-md-3">$<?php echo number_format($rate_row['next_item_price'], 2); ?></div>
                             </div>
                        <?php } ?>
                        </div>
                        <div style="clear:both">
                           <p><b>This product usually ships in 4 business days and should be delivered in <?php echo $product_shipping['info_fields']['ship_days'];  ?> business days.</b></p>
                        </div>

                    </div>
                    
                </div>
                
                 <div role="tabpanel" class="tab-pane fade" id="messages">
                    <p>
                         <?php echo $product_shipping['info_fields']['return_policy']; ?>
                    </p>
                 </div>
                 
            </div>
      </div>
      
  </div> <!-- seller-right col-md-7 -->

		 <div class="col-md-5" style="float:right;border: thin solid rgba(128, 128, 128, 0.28); border-left:none;">
            <div class="sell_prod_name">
            	<h1 style="font-size: 1.625rem;"><?php echo $preview_item_detail['product_name']; ?></h1>
            </div>
		 	<div class="msrp_price" ><?php echo $currencySymbol; echo number_format( $preview_item_detail['msrp'], 2 ); ?></div>
		 	<div class="current_price" >
			    <?php echo $currencySymbol; echo number_format( $new_price, 2 ); ?>
            </div>
            <div class="price_info" >You save <?php   echo number_format( $new_discount_price,2); ?> (<?php echo number_format($new_discount_percent, 0); ?>% off) <span><i class="fa fa-2x fa-angle-double-down "></i></span></div>
            <div id="price_details" style="display:none">
            <?php if( (float) $msrp_disc_price > 0.0 ) { ?>
            <div><b>Shops At Avenue Savings</b></div>
            <div><?php echo number_format( $msrp_discount_per, 0 ); ?>% off MSRP   <span class="discount_price">$<?php echo number_format($msrp_disc_price,2); ?></span></div>
            <?php } ?>
            <?php if( (float) $store_disc_price > 0.0 ) { ?>
            <div><b>Store Sale Discount</b></div>
            <div><?php echo number_format( $store_disc_percent, 0 ); ?>% off Shops At Avenue price  <span class="discount_price">$<?php echo number_format($store_disc_price,2); ?></span></div>
            <?php } ?>
            <div style=" border-bottom:2px dotted rgba(0, 0, 0, 0.15)"></div>
            </div>
            <?php if ( $preview_item_detail['sold_exclusive'] ) { ?>
                <div style="padding: 10px 0px;"><span>+</span> Shops At Avenue exclusive</div>
            <?php } ?>
			<form name="product_form" class="form-horizontal" role="form">
            <input type="hidden" name="product_id" id="product_id" value="<?php echo $preview_item_detail['id'];?>">
            <input type="hidden" name="seller_id" id="seller_id" value="<?php echo $selectedSeller_details[0]['seller_id']; ?>">
            <input type="hidden" name="price" id="price" value="<?php echo $new_price; ?>">
			<?php //Show variations ?>
			<?php if ( $preview_item_detail['variable_product'] ) { ?>
				<?php 
                      $i=0;
                      foreach ( $options as $opt_id => $opt_row ) {
                 ?>
                        <?php if( $options[$opt_id]['option_type_id'] == 1  ) { 
						?>
                      <div style="width:100%">
                              <div><?php echo $options[$i]['product_option_name']; ?></div>
                              <div id="color_wrapper">
                              <?php foreach( $variations as $key => $row ) { ?>
                                  <div>
                                    <a href="javascript:;" onclick="setColor(this);" > <div class="varbox" style="background-color:<?php echo $row['color_code']; ?>" ></div>
                                    </a>
                                    <input type="radio" name="var_color_1" value="<?php echo $row['product_variant_name1']; ?>" style="display:none;"  >
                                  </div>
                              <?php } ?>
                              </div>
                      </div>
                        <?php }	?>
                        
                        <?php if( $options[$opt_id]['option_type_id'] == 2  ) { 
						?>
                      	<div style="width:100%" >
                              <div>Select <?php echo $options[$opt_id]['product_option_name']; ?></div>
                              <select class="form-control" name="var-color" style="width:50%" >
                              <?php foreach( $option_values as $key => $row ) { 
							         if( $options[$opt_id]['product_option_id'] != $row['product_option_id'] ) continue;
							  ?>
                                  <option value="<?php echo $row['product_option_id']; ?>"><?php echo $row['option_value']; ?></option>
                              <?php } ?>
                              </select>
                      	</div>
                        <?php }	?>
                        <?php if( $options[$opt_id]['option_type_id'] == 3  ) { 

						?>
                      	<div style="width:100%" >
                              <div>Select <?php echo $options[$opt_id]['product_option_name']; ?></div>
                              <select class="form-control" name="var-size" style="width:50%" >
                              <?php foreach( $option_values as $key => $row ) { 
							         if( $options[$opt_id]['product_option_id'] != $row['product_option_id'] ) continue;
							  ?>
                                  <option value="<?php echo $row['product_option_id']; ?>"><?php echo $row['option_value']; ?></option>
                              <?php } ?>
                              </select>
                      	</div>
                        <?php }	?>
                        
                      
                <?php } //foreach options ?>
            <?php } //variable product  ?>

			<div class="quantity_box">
				<?php if( $preview_item_detail['quantity'] > 1 ) { ?>                     	
						<label><b>Quantity</b></label>
						<select class="form-control" name="quantity" id="quantity_list" data-mqty="<?php echo $preview_item_detail['quantity']; ?>" style="width:70px;">
					<?php for($i=1;$i <= 10;$i++) { echo '<option>'.$i.'</option>'; }  ?>
						</select>
				<?php } else if($preview_item_detail['quantity'] == 1) { ?>
						<input type="hidden" id="quantity_list" data-mqty="<?php echo $preview_item_detail['quantity']; ?>"  />
						<label >Only 1 available</label>
				<?php } else if($preview_item_detail['quantity'] <= 0) {?>
						<label ><h2 style="color:#F0F">Out Of Stock!</h2>
						</label>
						
				<?php }?>
			</div>	

			<div class="price_left" style="width:100%">
				<p id="QtyErr"></p><p id="ADDCartErr"></p>
			</div>
            
			<div style="width:100%">
                <div style="width:50%" align="center"  >
			<?php if($preview_item_detail['quantity'] > 0 || $subProduct->row()->digital_item!='') {?> 
					<input class="btn-primary subscribe-link alert-popupcart"  id="add_to_cart" type="submit" value="Add to Cart"  onclick="return ajax_add_cart_new();" <?php if($preview_item_detail['quantity'] <= 0) { echo 'disabled="disabled"'; } ?>  />
			<?php }?>
                </div>
			</div>
			<div id="fav-box" >			   
					 <?php if($loginCheck != ''){ ?>
					 <?php if($preview_item_detail['user_id'] == $loginCheck){ ?>
                            <a href="javascript:void(0);" onclick="return ownProductFav();">
                                <div class="btn-secondary" style="width:50%">
                                    <i class="fa fa-heart"></i>Favorite
                                </div>
                            </a>
						<?php
						}else{
						$favArr = $this->product_model->getUserFavoriteProductDetails(stripslashes($preview_item_detail['id']));
						#print_r($favArr); die;
						if(empty($favArr)){ ?>
						<a href="javascript:void(0);" onclick="return changeProductToFavourite('<?php echo stripslashes($preview_item_detail['id']); ?>','Fresh',this);">
							 <div class="btn-secondary"  style="width:50%"> <i class="fa fa-heart"></i>Favorite</div>
						</a>
						<?php  } else { ?>   
						<a href="javascript:void(0);" onclick="return changeProductToFavourite('<?php echo stripslashes($preview_item_detail['id']); ?>','Old',this);">
							<div class="btn-secondary"  style="width:50%"> <i class="fav-icon-sel"></i>Favorite</div>
						</a>
						<?php }} } else { ?>
						<a href="javascript:void(0);" onclick="return changeProductToFavourite('<?php echo stripslashes($preview_item_detail['id']); ?>','Fresh',this);">
							<div class="btn-secondary"  style="width:50%"> <i class="fa fa-heart"></i>Favorite</div>
						</a>
					<?php  } ?> 
            </div> <!-- favourite -->
            
			<!-- AddThis Button BEGIN -->
			<?php if($loginCheck==''){ $att= current_url(); } else{ $att= current_url()."?aff=".$userDetails->row()->affiliateId;}?>
			<div class="addthis_toolbox addthis_default_style " addthis:url="<?php echo $att;?>">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				<a class="addthis_button_tweet"></a>
				<a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a>
				<a class="addthis_counter addthis_pill_style"></a>
			</div>
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50ab628f64d148de"></script>
			<!-- AddThis Button END -->

			</form>
			<!--more products -->
         
             <div class="shop-info"> 
	<?php if($selectedSeller_details[0]['thumbnail']!=""){ $Pro_pic=$selectedSeller_details[0]['thumbnail']; }else { $Pro_pic='profile_pic.png';} ?>				 
				 <div class="shop-name">
                     <a href="shop-section/<?php echo $selectedSeller_details[0]['seourl']; ?>"><img src="images/users/thumb/<?php echo $Pro_pic; ?>" width="75" height="75" /></a>
                     <a href="shop-section/<?php echo $selectedSeller_details[0]['seourl']; ?>">
                     <span>more products from</span> 
                     <?php echo $selectedSeller_details[0]['seller_businessname']; ?></a>
                 </div>
	         </div>
             <div class="related-listing-inner">
                <?php if(count($shopProductDetails)<4){$c=count($shopProductDetails);}else{ $c=4; } 
                            for($i=0;$i<$c;$i++){ 
                            $imgArry=explode(',',$shopProductDetails[$i]['image']);
                            if($shopProductDetails[$i]['price']!=0 ) {
                                $price=$currencyValue*$shopProductDetails[$i]['price'];
                            } else {
                                $price=$currencyValue*$shopProductDetails[$i]['base_price'].'+';
                            }
                ?>
                    <div class="realated-brick col-md-6 odd"> 
                        <a href="products/<?php echo $shopProductDetails[$i]['seourl']; ?>">
                            <img src="images/product/<?php echo $shopProductDetails[$i]['id'];?>/thumb/<?php echo $imgArry[0] ?>" alt="<?php echo $shopProductDetails[$i]['product_name']; ?>" title="<?php echo $shopProductDetails[$i]['product_name']; ?>" />
                        </a>
                        <!--<div class="info">
                          <h3><a href="products/<?php //echo $shopProductDetails[$i]['seourl']; ?>"><?php echo character_limiter($shopProductDetails[$i]['product_name'],15); ?></a></h3>
                          <span class="cat-name cat-price" ><?php //echo $currencySymbol; echo number_format($price,2);?> <span class="currencyType"><?php //echo $currencyType; ?></span></span> 
                         </div>-->
                    </div>
			    <?php }?>
             </div> <!-- related -->
		</div> <!-- right block -->
		

	  	<div class="col-md-12 realated-this-item">
            <div class="col-md-7">
            <?php if($preview_item_detail['tag']!=''){ ?>
            
            <h2><?php if($this->lang->line('shop_relateditem') != '') { echo stripslashes($this->lang->line('shop_relateditem')); } else echo 'Related to this Item'; ?></h2>
            <ul class="tag">
             <?php $Related=explode(',',$preview_item_detail['tag']) ?>
                    <?php foreach($Related as $tag){?>
                    <li><a href="market/<?php echo url_title($tag); ?>"><?php echo $tag; ?></a></li> 
                    <?php } ?>
            </ul>
            <?php }?>
            </div>
	<div class="col-md-5">
    <div class="clear inner" id="fineprint">
      <ul class="clear">
        <li><?php if($this->lang->line('prod_listed') != '') { echo stripslashes($this->lang->line('prod_listed')); } else echo 'Listed on'; ?> 
		<?php echo date('M d,Y',strtotime($preview_item_detail['created'])); ?></li>
        <li> <?php echo $preview_item_detail['view_count']; ?> <?php if($this->lang->line('shopsec_views') != '') { echo stripslashes($this->lang->line('shopsec_views')); } else echo 'views'; ?> </li>
        <li> 
			<a href="product/<?php echo $preview_item_detail['seourl']; ?>/favoriters"> <?php echo count($ProductFavoriteCount); ?> <?php if($this->lang->line('user_favorites') != '') { echo stripslashes($this->lang->line('user_favorites')); } else echo 'Favorites'; ?> </a> 
		</li>

        <li id="item-reporter">
          <div id="reporter-link-container"> 

				<?php if($this->session->userdata['shopsy_session_user_id'] != '') {
						if($this->session->userdata['shopsy_session_user_id']==$selectedSeller_details[0]['seller_id']){?>
						<a href="#ownshop_report" style="color:rgb(1, 173, 220);" data-toggle="modal"><?php if($this->lang->line('prod_report') != '') { echo stripslashes($this->lang->line('prod_report')); } else echo 'Report this item to'; ?> <?php echo $this->config->item('email_title'); ?></a>
						<?php } else { ?>
					<a href="#detailreport_reg" style="color:rgb(1, 173, 220);" data-toggle="modal"><?php if($this->lang->line('prod_report') != '') { echo stripslashes($this->lang->line('prod_report')); } else echo 'Report this item to'; ?> <?php echo $this->config->item('email_title'); ?></a>
				<?php } } else {?>
					<a href="login?action=<?php echo current_url(); ?>" style="color:rgb(1, 173, 220);"><?php if($this->lang->line('prod_report') != '') { echo stripslashes($this->lang->line('prod_report')); } else echo 'Report this item to'; ?> <?php echo $this->config->item('email_title'); ?></a>
				<?php } ?>

		  </div>
          <div id="reporter-complete-container"> </div>
        </li>
      </ul>
    </div>
	</div>
  </div>
	  
	  
    </div>

</section>

</div>
  

<a href="#product_add_cart_popup" id="product_add_cart" data-toggle="modal"></a>
 <div id='product_add_cart_popup' class="modal language-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				 <div style='background:#fff;'>  
					<div class="conversation" style="width: 64%; margin-left: 191px; margin-top: 171px;">
						<div class="conversation_container">
							<h2 class="conversation_headline" style="margin: 8px;color: #9E612F;"><?php echo shopsy_lg('lg_product_addeed_tocart','Product Added to cart');?> </h2>
							<div class="modal-footer footer_tab_footer">
								<div class="btn-group">
										<a class="btn btn-default submit_btn" data-dismiss="modal" ><?php echo shopsy_lg('lg_continue_shop','Continue Shopping');?></a>
										<a class="btn btn-default submit_btn" href="cart"><?php echo shopsy_lg('lg_go_to_checkout','Go to Checkout');?></a>
								</div>
							</div>		
						</div>
					</div>
				</div>			
			</div>
		</div>
	</div>
<style>
span.label{
color:#000;
}
.quant-input .arrows {
	height: 100%;
	position: absolute;
	right: -100;
	top: -4;
	z-index: 2;
}
.arrows .arrow {
	box-sizing: border-box;
	cursor: pointer;
	display: block;
	margin-left:10px;
	text-align: center;
	width: 40px;
}
#zoom{
	position: fixed !important;
	z-index: 9999 !important;
	 top: 50px !important;
}
#content #primary {
    float: left;
    padding-top: 0;
    width: 100%;
}

</style>

<script src="js/front/jquery.fancyzoom.js"></script> 
<script type="text/javascript" src="js/validation.js"></script> 
<script type="text/javascript">
function ajax_add_cart_new() {

	$('.error-msg').remove();
	
	if( $('input[type=radio][name=var_color_1]').length > 0 && $('input[type=radio][name=var_color_1]:checked').length == 0 ) {
		$('#color_wrapper').append('<div class="error-msg">Select Color</div>');
		return false;
	}
	var data = $('select[name=quantity], #product_id, #seller_id, #price ').add('input[type=radio][name=var_color_1]:checked' );

		$.ajax({
			type: 'POST',
			url: baseURL+'site/cart/userAddToCart',
			data: $( data ).serialize() + "&mqty=" + $('#quantity_list').data('mqty') + "&shop_name=<?php echo $selectedSeller_details[0]['seller_businessname'];?>" ,
			success: function(response){
				var arr = response.split('|');
				if(arr[0] =='login'){
					window.location.href= baseURL+"login";	
				}else if(arr[0] == 'Error'){
					if($.isNumeric(arr[1])==true){
						$('#ADDCartErr').html('<font color="red">Maximum Purchase Quantity: '+mqty+'. Already in your cart: '+arr[1]+'.</font>');
					}else{
						$('#ADDCartErr').html('<font color="red">'+arr[1]+'.</font>');
					}					
						$('#ADDCartErr').show().delay('2000').fadeOut();
				}else{
					//alert(arr[1]);
					$('#CartCount').html(arr[1]);
					$('.CartCount1').html(arr[1]);
					$('#product_add_cart').trigger('click');
				}
		
			}
		});
		return false;
		
}
function setColor( obj ){
	$( obj ).closest('div').find('input[type=radio]').prop('checked', true);
	$('div.varbox').css( 'border-color','#fff' );
	$( obj ).closest('div').find('div.varbox').css( 'border-color','#5F0000' );
	//$('input[type=radio][value=<?php //echo $row['product_variant_id']; ?>]').attr('checked', true);
}

$( document ).on( 'click', ".price_info span i",  function () {
		$('#price_details').slideToggle();
		if ( $('.price_info span i').hasClass('fa-angle-double-down') ) {
			$('.price_info span i').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
		} else {
			$('.price_info span i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
		}
	} );   

jQuery(document).ready(function() {
	
	jQuery("#prodZoom").fancyZoom();
	jQuery('[data-toggle="tooltip"]').tooltip();  
	jQuery('[data-countdown]').each(function() {
	   var $this = $(this), finalDate = jQuery(this).data('countdown');
	   $this.countdown(finalDate, function(event) {
		 $this.html(event.strftime('%D days %H:%M:%S'));
	   });
	 });
}); 
	

/*jQuery(window).load(function(){
	jQuery('.flexslider').flexslider({
		animation: "slide",
		controlNav: "thumbnails",
		start: function(slider){
			jQuery('body').removeClass('loading');
		}
	});
});
function change_variationone(evt){
	var split_val = evt.value;
	var variation1 = split_val.split('[<?php //echo $currencySymbol?>');
	var variation = variation1[1].split(']');
	var currencyVal = '<?php //echo $currencyValue?>';
	var price = (parseFloat(variation[0])/parseFloat(currencyVal)).toFixed(2);
	
	$('#price').val($.trim(price));
}
var loading = true;
jQuery(window).scroll(function(){
	if(loading==true){
		if(($(document).scrollTop()+$(window).height())>($(document).height()-200)){
			//wall.fitWidth();
			$url = $(document).find('.landing-btn-more').attr('href');
			console.log($url);
			if($url){
				loading = false;
				$(document).find('#load_ajax_img').append('<img id="theImg" src="<?php //echo base_url(); ?>images/loader64.gif" />');
				$.ajax({
					type : 'get',
					url : $url,
					dataType : 'html',
					success : function(html){
						
						$html = $($.trim(html));
						//console.log($html);
						$(document).find('.landing-btn-more').remove();
						$(document).find('#tiles').append($html.find('#tiles').html());
						$(document).find('#tiles').after($html.find('.landing-btn-more'));
						
						
					},
					error : function(a,b,c){
						console.log(c);
					},
					complete : function(){
						//alert("Asdf");
						$("#load_ajax_img img:last-child").remove();
						loading = true;
						
					}
				});
			}
		}
	}
});*/
</script>
