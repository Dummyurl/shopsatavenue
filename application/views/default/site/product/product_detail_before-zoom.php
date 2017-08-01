<?php $this->load->view('site/templates/commonheader'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>css/product-detail.css" >
<link rel="stylesheet" href="css/etalage.css">

<style>
.msrp-price { text-decoration:line-through; }
.normal-price { color:#F00; font-size:large; font-weight:600; }
.price-block { color:#F00; font-size:14px; }
.price-block span { margin-left:10px; cursor:pointer; }
.discount_price { float:right; padding-right:100px; color:#F00; }
.option-label { float:left; text-align:left; color:#000; width:100%;font-size: 14px; }
.form-control { margin:0px; }
select{height:3.7rem;padding:.5rem;border:1px solid #414042;margin:0 0 1rem;font-size:1.5rem;font-family:inherit;line-height:normal;color:#414042;background-color:#fefefe;border-radius:0;-webkit-appearance:none;-moz-appearance:none;background-image:url("images/select_down.svg");background-size:9px 6px;background-position:right -1rem center;background-origin:content-box;background-repeat:no-repeat;padding-right:1.5rem}
</style>

<?php $this->load->view('site/templates/header2'); ?>

	<div class="container" >
    <section class="product-single" >
			<div class="row">
				<div class="col-md-6">
				
						<div >
                                <ul id="etalage">
									<?php
										$imageArr = explode(',',$preview_item_detail[0]['image']);
										$imgCount = count($imageArr);
										for($i=0; $i < $imgCount; $i++) { 
                                    ?>
                                        <li>
                                        <!-- This is the large (zoomed) image source: -->
                                        <img class="etalage_source_image" src="<?php echo 'images/product/'.$preview_item_detail[0]['id'].'/'.$imageArr[$i]; ?>"
                                        title="Optionally, your description goes here." /> 
                                        
                                        <!-- This is the thumb image source (if not provided, it will use the large image source and resize it): -->
                                        <img class="etalage_thumb_image" src="<?php echo 'images/product/'.$preview_item_detail[0]['id'].'/'.$imageArr[$i]; ?>" />
                                        </li>
									<?php } ?> 
                  			</ul>
							
						</div>
                                
						<div class="product-desc-tab">
							
							<ul role="tablist" class="nav nav-tabs">
								<li class="active">
                                <a aria-expanded="true" href="javascript:;" aria-controls="descreption" onclick="show_tab('descreption', this);" role="tab" data-toggle="tab" style="padding-left:20px;" >Description</a>
                                </li>
								<li class="" >
                                <a aria-expanded="false" href="javascript:;" aria-controls="reviews" onclick="show_tab('reviews', this);" role="tab" data-toggle="tab">Shipping</a>
                                </li>
                                <li class="" >
                                <a aria-expanded="false" href="javascript:;" aria-controls="return" onclick="show_tab('return', this);" role="tab" data-toggle="tab">Return Policy</a>
                                </li>
							</ul>
							
							<div class="tab-content">
							   	<div role="tabpanel" class="tab-pane active" id="descreption">
							   		<?php if($preview_item_detail[0]['description']!=''){ echo $preview_item_detail[0]['description']; }?>
							   	</div>

							   	<div role="tabpanel" class="tab-pane" id="reviews">
									<?php 
                                        foreach ( $product_shipping['rates'] as $code => $rate_row ) { 
                                            $rate_row['next_item_price'] = ( (int) $rate_row['next_item_price'] == 0 ) ? $rate_row['ship_price'] : $rate_row['next_item_price'];
                                    ?>
                                     <div>
                                         <div class="col-md-5"><?php echo $rate_row['description']; ?></div>
                                         <div class="col-md-2">$<?php echo number_format($rate_row['ship_price'], 2); ?></div>
                                         <div class="col-md-3">$<?php echo number_format($rate_row['next_item_price'], 2); ?></div>
                                     </div>
                                    <?php } ?>
							   	</div>
                                
                                <div role="tabpanel" class="tab-pane" id="return">
							   		<p>Return Policy</p>
								</div>
							</div>
						</div>

					</div><!-- main-content -->
		
                
				<div class="col-md-6">
					<div id="sidebar">
						<div class="product-detail">
							<div class="dotted-title">
                            <input type="hidden" name="product_id" id="product_id" value="<?php echo $preview_item_detail[0]['id'];?>">
                            <input type="hidden" name="seller_id" id="seller_id" value="<?php echo $selectedSeller_details[0]['seller_id']; ?>">
                            <input type="hidden" name="price" id="price" value="<?php echo $new_price; ?>">
                            
                            <!--<h4><i class="fa fa-question" style="padding-right:10px;"></i><a data-toggle="modal" href="#ask_reg" >Ask a Question</a></h4>-->
				 				 <h3><?php echo $preview_item_detail[0]['product_name']; ?></h3>
                                 <p style="text-decoration:line-through;">MSRP $<?php echo number_format( $preview_item_detail[0]['msrp'], 2 ); ?></p>
                                 <div class="dotted-price" >$<?php echo number_format( $new_price, 2 ); ?></div>
							</div><!-- dotted-title -->
										
                             <p style="color:#0770bd; ">You save <?php echo number_format( $new_discount_price,2); ?> (<?php echo number_format($new_discount_percent, 0); ?>% off)</p>
                             <p>
                                <?php if( (float) $msrp_disc_price > 0.0 ) { ?>
                                <div><b>Shops At Avenue Savings</b></div>
                                <div><?php echo number_format( $msrp_discount_per, 0 ); ?>% off MSRP <span style="color:red">$<?php echo number_format($msrp_disc_price,2); ?></span>	</div>
                                <?php } ?>
                                <?php if( (float) $store_disc_price > 0.0 ) { ?>
                                <div><b>Store Sale Discount</b></div>
                                <div><?php echo number_format( $store_disc_percent, 0 ); ?>% off Shops @ Avenue price  <span class="discount_price">$<?php echo number_format($store_disc_price,2); ?></span></div>
                                <?php } ?>
                                <?php if ( $preview_item_detail['sold_exclusive'] ) { ?>
                                    <div style="padding: 10px 0px;"><span>+</span> Shops @ Avenue exclusive</div>
                                <?php } ?>
                             </p>
										
                        <div >
								<?php if ( $preview_item_detail[0]['variable_product'] ) { 
                                          $i=0;
                                          foreach ( $options as $opt_id => $opt_row ) {
                                ?>
                                            <?php if( $options[$opt_id]['option_type_id'] == 1  ) { 
                                            ?>
                                          <div style="width:100%;margin-left: 10px;">
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
                                            <div style="width:100%; margin-top:10px;" >
                                                  <div>Select <?php echo $options[$opt_id]['product_option_name']; ?></div>
                                                  <select   name="var-color" style="width:50%" >
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
                                            <div style="width:100%; margin-top:10px;" >
                                                  <div>Select <?php echo $options[$opt_id]['product_option_name']; ?></div>
                                                  <select   name="var-size" style="width:50%" >
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

                                <p>
                                    <?php if( $preview_item_detail[0]['quantity'] > 1 ) { ?>                     	
                                            <label style="width:100%"><b>Quantity</b></label>
                                            <select   name="quantity" id="quantity_list" data-mqty="<?php echo $preview_item_detail[0]['quantity']; ?>" style="width:70px;">
                                        		<?php for($i=1;$i <= 10;$i++) { echo '<option>'.$i.'</option>'; }  ?>
                                            </select>
                                    <?php } else if($preview_item_detail[0]['quantity'] == 1) { ?>
                                            <input type="hidden" id="quantity_list" data-mqty="<?php echo $preview_item_detail[0]['quantity']; ?>"  />
                                            <label >Only 1 available</label>
                                    <?php } else if($preview_item_detail[0]['quantity'] <= 0) {?>
                                            <h2 style="color:#F0F;" >Out Of Stock!</h2>
                                            
                                    <?php }?>
                                </p>	
        						<div class="price_left" style="width:100%">
										<p id="QtyErr"></p><p id="ADDCartErr"></p>
								</div>

					</div>
										<!-- product-counter-area -->
										<p class="add-cart" style="margin-top:10px;" >
											<button type="button" onclick="return ajax_add_cart_new();" class="button">
                                            <i class="fa fa-shopping-cart" style="padding-right:10px;"></i>Add to Cart</button>
										</p>
                                        <p class="add-cart" style="margin-top:10px;">
											<button type="button" onclick="return  addFavourite();" class="button"><i class="fa fa-heart" style="padding-right:10px;"></i>Add to Wishlist</button>
										</p>
									</div>
						<div class="widget">
						<?php if ( count($related_items) > 0 ) { ?>
                        <h1 style="margin-top:30px;">You May Also Love</h1>
						<h2 class="widget-title" style="margin-top:20px;" >Related Items</h2>
                            <div class="pricing-wrapper">

								<?php  for($i=0; $i < count($related_items); $i++ ) {
											$imageArr = explode(',',$related_items[$i]['image']); ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="related-item-table">
                                        <div class="pricing-img">
                                        	<a href="products/<?php echo $related_items[$i]['seourl'];?>"  class="offer-img">
                                            <img src="<?php echo 'images/product/'.$related_items[$i]['id'].'/thumb/'.$imageArr[0]; ?>" alt="" class="img-responsive">
                                        	</a>
                                        </div>
                                    </div><!-- pricing-table -->
                                </div>
                            	<?php } ?>
                                
              				</div>
                      	<?php } //for ?>
						</div><!-- widget -->

					</div><!-- sidebar -->
				</div>
			</div>
	</section>
    <div class="row">
    	<div style="col-md-12" >
			<h1 class="text-center">More Products offers from other sellers</h1>
            <div class="widget">
            <?php if ( count($related_items) > 0 ) { ?>
            <div class="pricing-wrapper">

                    <?php  for($i=0; $i < count($related_items); $i++ ) {
                                $imageArr = explode(',',$related_items[$i]['image']); ?>
                    <div class="col-md-2 col-sm-3">
                        <div class="other-seller-table">
                            <div class="pricing-img">
                                <a href="products/<?php echo $related_items[$i]['seourl'];?>"  class="offer-img">
                                <img src="<?php echo 'images/product/'.$related_items[$i]['id'].'/thumb/'.$imageArr[0]; ?>" alt="" class="img-responsive">
                                </a>
                            </div>
                        </div><!-- pricing-table -->
                    </div>
                    <?php } ?>
                    
                </div>
            <?php } //for ?>
            </div><!-- widget -->

        </div>
    </div>
	</div> <!-- container -->

               
                            

	<!-- Modal -->
	<div id="ask_reg" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
				<form name="contactshopowener" id="contactshopowener" method="post" action="site/user/prddetailaskQues">
					<div style='background:#fff;'>  
						<div class="conversation">							
							<div style="margin:20px 20px">
                                <a class="close-modal" onclick="$('#ask_reg').modal('hide');" style="float:right; margin-right:10px;"  >
                                	<i class="fa fa-times fa-2x" aria-hidden="true"></i>
                                </a>
								<h2  class="checkout-sub-header">Please post your question  - <?php echo ucfirst($selectedSeller_details[0]['seller_businessname']); ?></h2>
								<!--<div class="conversation_thumb">
									<img width="75" height="75" src="images/users/thumb/<?php //echo $Pro_pic; ?>">
								</div>-->
								<div class="conversation_right">
								
									<input type="hidden" name="productseourl" id="productseourl" value="<?php echo $preview_item_detail[0]['seourl']; ?>" >
									<input class="conversation-subject" type="text" name="subject" placeholder="Subject" value="<?php echo $preview_item_detail[0]['product_name']; ?>">
									<textarea class="conversation-textarea" rows="11" name="message_text" placeholder="Message text"><?php echo base_url().'products/'. $preview_item_detail[0]['seourl']; ?></textarea>
									<input type="hidden" name="productid" id="productid" value="<?php echo $preview_item_detail[0]['id']; ?>" >
									<input type="hidden" name="productname" id="productname" value="<?php echo $preview_item_detail[0]['product_name']; ?>" >
									<input type="hidden" name="username" id="username" value="<?php echo $this->session->userdata['shopsy_session_user_name']; ?>" >
									<input type="hidden" name="useremail" id="useremail" value="<?php echo $this->session->userdata['shopsy_session_user_email']; ?>" >
									<input type="hidden" name="userid" id="userid" value="<?php echo $this->session->userdata['shopsy_session_user_id']; ?>" >
									<input type="hidden" name="selleremail" id="selleremail" value="<?php echo $selectedSeller_details[0]['seller_email']; ?>" >
									<input type="hidden" name="sellerid" id="sellerid" value="<?php echo $selectedSeller_details[0]['seller_id']; ?>" >
									<input type="hidden" name="subject_name" id="subject_name" value="New conversation with <?php echo ucfirst($selectedSeller_details[0]['full_name']); ?>' from <?php echo ucfirst($selectedSeller_details[0]['seller_businessname']); ?>">									
								</div> 
							</div>						
							<div class="modal-footer footer_tab_footer">
								<div class="btn-group">
										<input class="submit_btn" type="submit" value="send" />
										<a class="btn btn-default submit_btn" data-dismiss="modal" id="ask-cancel">Cancel</a>
								</div>
							</div>		
							
							
						</div>
					</div>												
				</form>		
			</div>
		</div>
	</div>
                        



     
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
					$('#cart-total-qty').html(arr[1]);
					location = 'placeOrder';
					//$('#product_add_cart').trigger('click');
				}
		
			}
		});
		return false;
		
}
</script>

<script type="text/javascript">
	$( document ).on( 'click', ".price-block span i",  function () {
		$('#price_details').slideToggle();
		if ( $('.price-block span i').hasClass('fa-angle-double-down') ) {
			$('.price-block span i').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
		} else {
			$('.price-block span i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
		}
	});
	
	function show_tab( tab, obj ) {
		$('.product-desc-tab li.active').removeClass('active');
		$( obj ).closest('li').addClass('active');
		$('.product-desc-tab .tab-content .tab-pane').removeClass('active');
		$( '#' + tab ).addClass('active');
	}
	
</script>

<?php $this->load->view('site/templates/product_detail_footer'); ?>


