<style>
.carousel-inner {
  position: relative;
  width: 100%;
  min-height: 300px;
  }
 
 .carousel-control.right {
  right: 0;
  left: auto;
  background-image: none !important;
  background-repeat: repeat-x;
}
 .carousel-control.left {
  left: 0;
  right: auto;
  background-image: none !important;
  background-repeat: repeat-x;
}
#carousel-example-generic {
    margin: 20px auto;
    width: 100%;
}

#carousel-custom {
    margin: 20px auto;
    width: 400px;
}
#carousel-custom .carousel-indicators {
    margin: 10px 0 0;
    overflow: auto;
    position: static;
    text-align: left;
    white-space: nowrap;
    width: 100%;
    overflow:hidden;
}
#carousel-custom .carousel-indicators li {
    background-color: transparent;
    -webkit-border-radius: 0;
    border-radius: 0;
    display: inline-block;
    height: auto;
    margin: 0 !important;
    width: auto;
}
#carousel-custom .carousel-indicators li img {
    display: block;
    opacity: 0.5;
}
#carousel-custom .carousel-indicators li.active img {
    opacity: 1;
}
#carousel-custom .carousel-indicators li:hover img {
    opacity: 0.75;
}
#carousel-custom .carousel-outer {
    position: relative;
}
.carousel-indicators li img {
  height: 66px;
  width: 52px;}
  
</style>

<div id="product_detail_div">
<section class="container1">
  <div class="seller-wrapper">
    <div class="col-md-6 seller"> 
     	<div ><?php echo $cat_link == '' ? '&nbsp;' : '&nbsp;'; ?></div>
    </div>
    <!--<div class="col-md-6">
		<div id="close-product-detail-modal" class="close-modal" onclick="$('#product_modal').modal('hide');"  ><i class="fa fa-times fa-2x" aria-hidden="true"></i></div>
    </div>-->
  </div>
  
  <div class="seller-wrapper" style="margin-top:5px;">
  
       <div class="seller-right col-md-7">
<div id='carousel-custom' class='carousel slide' data-ride='carousel'>
    <div class='carousel-outer'>
        <!-- me art lab slider -->
        <div class='carousel-inner '>
			<?php 
                $imageArr = explode(',',$preview_item_detail['image']);
                $imgCount = count($imageArr);
                for($i=0; $i < $imgCount; $i++){ 
            ?>
        
            <div class="item <?php echo $i == 0 ? 'active' : ''; ?>" >
                <img src="<?php echo PRODUCTPATH. $preview_item_detail['id'] ."/". $imageArr[$i]; ?>" alt=''id="zoom_05"  data-zoom-image="<?php echo PRODUCTPATH. $preview_item_detail['id'] ."/". $imageArr[$i]; ?>"/>
            </div>
				<?php 
					}
				?> 
                
        </div>
            
        <!-- sag sol -->
        <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
            <span class='glyphicon glyphicon-chevron-left'></span>
        </a>
        <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
            <span class='glyphicon glyphicon-chevron-right'></span>
        </a>
    </div>
    
    <!-- thumb -->
    <ol class='carousel-indicators mCustomScrollbar meartlab'>
	   <?php for($i=0;$i<$imgCount;$i++) {  ?>
        <li data-target='#carousel-custom' data-slide-to="<?php echo $i;?>" class='active'><img src="<?php echo PRODUCTPATH.$preview_item_detail['id'].'/cropthumb/'. $imageArr[$i]; ?>" alt='' /></li>
	   <?php }  ?>
    </ol>
</div>

									<!--<div class="content-top ">
										<div class="container ">-->
                                            <div class="tab-head ">
                                                <nav class="nav-sidebar">
                                                    <ul class="nav tabs "  style="text-align:left; border:0px !important; ">
                                                      <li class="active"><a href="#tab1" data-toggle="tab">Description</a></li>
                                                      <li ><a href="#tab2" data-toggle="tab">Shipping</a></li> 
                                                       <li ><a href="#tab3" data-toggle="tab">Return Policy</a></li> 
                                                    
                                                     </ul>
                                                </nav>

                                                <div class="tab-content  tab-content-t ">
                                                    <div class="tab-pane active  text-style" id="tab1">
                                                        <div class="con-w3l">
                                                            <div class="product-grid-item-wrapper">
                                                            <?php if($preview_item_detail['description']!=''){ echo $preview_item_detail['description']; }?>																		                                                            </div>
														</div>
														<div class="clearfix"></div>
													</div>
                                                    <div class="tab-pane text-style" id="tab2">
                                                        <div class="con-w3l">
                                                            <div class="product-grid-item-wrapper">
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
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane  text-style" id="tab3">
                                                        <div class="con-w3l">
                                                            <div class="product-grid-item-wrapper">
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
                                                    </div>


                                            </div>
                                            </div>
                                        <!--</div>
                                   </div>-->
<!--
          <div role="tabpanel" class="tab-content"> 
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
                         <?php //echo $product_shipping['info_fields']['return_policy']; ?>
                    </p>
                 </div>
                 
            </div>
      </div>
-->      
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
            <div id="price_details" style="display:none; padding-left:10px; padding-bottom:10px;">
            <?php if( (float) $msrp_disc_price > 0.0 ) { ?>
            <div><b>Shops At Avenue Savings</b></div>
            <div><?php echo number_format( $msrp_discount_per, 0 ); ?>% off MSRP   <span class="discount_price">$<?php echo number_format($msrp_disc_price,2); ?></span></div>
            <?php } ?>
            <?php if( (float) $store_disc_price > 0.0 ) { ?>
            <div><b>Store Sale Discount</b></div>
            <div><?php echo number_format( $store_disc_percent, 0 ); ?>% off Shops @ Avenue price  <span class="discount_price">$<?php echo number_format($store_disc_price,2); ?></span></div>
            <?php } ?>
            <div style=" border-bottom:2px dotted rgba(0, 0, 0, 0.15);"></div>

            <?php if ( $preview_item_detail['sold_exclusive'] ) { ?>
                <div style="padding: 10px 0px;"><span>+</span> Shops @ Avenue exclusive</div>
            <?php } ?>

            </div>
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
                      	<div style="width:100%;margin-left: 10px;" >
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
                      	<div style="width:100%;margin-left: 10px;" >
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
            
			<div style="width:80%; margin:auto;" >
                <!--<div style="width:50%" align="center"  >-->
                    <button  class="button" type="submit" name="btn-submit" id="add_to_cart" value="Add to Cart" onclick="return ajax_add_cart_new();" <?php if($preview_item_detail['quantity'] <= 0) { echo 'disabled="disabled"'; } ?> >Add to Cart</button>
                <!--</div>-->
			</div>
            

			</form>
            
         
		</div> <!-- right block -->

    <div style="clear: both"></div>
		

	  	<div class="col-md-12 realated-this-item">
            
	<div class="col-md-5">
    <div class="clear inner" id="fineprint">
      <ul class="clear">
        <li><?php if($this->lang->line('prod_listed') != '') { echo stripslashes($this->lang->line('prod_listed')); } else echo 'Listed on'; ?> 
		<?php echo date('M d,Y',strtotime($preview_item_detail['created'])); ?></li>
        <li> <?php echo $preview_item_detail['view_count']; ?> <?php if($this->lang->line('shopsec_views') != '') { echo stripslashes($this->lang->line('shopsec_views')); } else echo 'views'; ?> </li>
        <li> 
			<a href="product/<?php echo $preview_item_detail['seourl']; ?>/favoriters"> <?php echo count($ProductFavoriteCount); ?> Favorites</a> 
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



<script type="text/javascript" src="js/validation.js"></script> 
<script type="text/javascript" src="js/elevatezoom.js"></script> 

<script type="text/javascript">

function setColor( obj ){
	$( obj ).closest('div').find('input[type=radio]').prop('checked', true);
	$('div.varbox').css( 'border-color','#fff' );
	$( obj ).closest('div').find('div.varbox').css( 'border-color','#5F0000' );
	//$('input[type=radio][value=<?php //echo $row['product_variant_id']; ?>]').attr('checked', true);
}


/*jQuery(document).ready(function() {
	
	jQuery("#prodZoom").fancyZoom();
	jQuery('[data-toggle="tooltip"]').tooltip();  
	jQuery('[data-countdown]').each(function() {
	   var $this = $(this), finalDate = jQuery(this).data('countdown');
	   $this.countdown(finalDate, function(event) {
		 $this.html(event.strftime('%D days %H:%M:%S'));
	   });
	 });
}); */
	

</script>
