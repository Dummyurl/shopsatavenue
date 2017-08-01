<?php $this->load->view('site/templates/header.php');	?>
<?php if(isset($active_theme) &&  $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>Cart-page.css" rel="stylesheet">
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>Empty-Cart-page.css" rel="stylesheet">
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>header.css" rel="stylesheet">
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>footer.css" rel="stylesheet">
<?php }?>
<style>
.product-line { width:100%; float:left; }
.col-lbl { display:inline-block; width:140px; color:#000; }
.col-amount {  display:inline-block; width:100px; color:#000; text-align:right; }
.msrp-price { color:#A0A0A4; text-decoration: line-through; }

.address-block { width:50%; padding-left:20px; padding-right:20px; padding-bottom:20px; }
.two-column { width:45%; display:inline-block; }
.two-column .form-control { margin-left:0px; }
.block-head { font-size:14px; font-weight:500; color:#2A0000; }
.error-msg { color:#F00; }

</style>
<div id="cart_div">
	<section class="container">
		<div class="s-cart">
			<!-- Cart Content Starts-->
				<?php //echo $cartViewResults; ?>
<?php if ( count($cart) == 0 ) { // empty cart ?>
<div class="cart_items" id="EmptyCart" style="display:block;">
   	<h2><span class="shop-name"><span class="shop-name1">Your Shopping Cart is Empty</span></span>
        <span class="cart_icons"></span></h2>
 	<div class="cart_details">
		 <div class="empty-alert card_for_temp">
			  <p style="text-align:center;"><img src="images/site/shopping_empty.jpg" alt="Shopping Cart Empty"></p>
			  <p style="text-align:center;"><b></b></p>
			  <p style="text-align:center;">Don`t miss out on awesome sales right here on Shopsatavenue. Let`s fill that cart, shall we?</p>
		</div>
	</div>
</div>
<?php } else {  ?>
<div class="">
      	<h1><span id="Shop_id_count"><?php echo count($cart); ?></span> Items in Your Cart </h1>
       	<a href="home" class="search-bt col-md-6 col-xs-4 op-bt s-cart-button">Keep Shopping</a>
</div>

<div id="UserCartTable" class="s-cart-bl">
    <div class="s-cart-bl-header">
        <h2>Finish your Order
            <span class="cart_icons"><a href="javascript:void(0);" class="close-btn" onclick="sellerCartdelete();"></a>
            </span>
        </h2>
    </div>

	<form method="post" name="cartSubmit" id="cartSubmit" class="continue_payment" onsubmit="return validate();" enctype="multipart/form-data" action="site/cart/placeOrder">
        <input name="payment_value" value="Paypalpro" type="hidden" >
    <!--<div style="float:left; width:100%">
        <div class="address-block" style="float:left;">
            <div class="block-head">Shipping Address</div>
    		<input name="Ship_address_val" id="User_Ship_address_val_1" value="<?php echo $ship_address->id;?>" type="hidden">
            <div>
                <label>Full Name</label>
                <input class="form-control" type="text" name="ship_name" value="<?php echo $ship_address->full_name; ?>" >
            </div>
            <div>
                <label>Address</label>
                <input class="form-control" type="text" name="ship_address_line1" value="<?php echo $ship_address->address1; ?>" >
                <input class="form-control" type="text" name="ship_address_line2" style="margin-top:10px;"  value="<?php echo $ship_address->address2; ?>">
            </div>
            <div>
                <label>City</label>
                <input class="form-control" type="text" name="ship_city" value="<?php echo $ship_address->city; ?>" >
            </div>
            <div>
                <div class="two-column">
                    <label>State</label>
                    <select class="form-control" name="ship_state" style="margin-left:0px" >
                    <?php echo $states; ?>
                    </select>
                </div>
                <div class="two-column" style="float:right;">
                    <label>Zip code</label>
                    <input class="form-control" type="text" name="ship_zipcode" value="<?php echo $ship_address->postal_code; ?>" />
                </div>
            </div>
            <div>
                <div class="two-column">
                    <label>Phone number</label>
                    <input class="form-control" type="text" name="ship_phone" value="<?php echo $ship_address->phone; ?>" style="margin-left:0px" >
                </div>
            </div>
    
        </div>
        <div class="address-block" style="float:right;">
            <div class="block-head">Billing Address
               <span style="margin-left:20px;"> <input type="checkbox" name="same_as_shipping" checked >&nbsp;&nbsp;Same as shipping Address</span>
            </div>
            <div id="bill-addr-block" style="display:none;">
                <div>
                    <label>Full Name</label>
                    <input class="form-control" type="text" name="bill_name" />
                </div>
                <div>
                    <label>Address</label>
                    <input class="form-control" type="text" name="bill_address_line1" />
                    <input class="form-control" type="text" name="bill_address_line2" style="margin-top:10px;" />
                </div>
                <div>
                    <label>City</label>
                    <input class="form-control" type="text" name="bill_city" />
                </div>
                <div>
                    <div class="two-column">
                        <label>State</label>
                        <select class="form-control" name="bill_state" >
                        <?php echo $states; ?>
                        </select>
                    </div>
                    <div class="two-column" style="float:right;">
                        <label>Zip code</label>
                        <input class="form-control" type="text" name="bill_zipcode" />
                    </div>
                </div>
    		</div>
        </div>
    </div>
    <div style="float:left; width:100%">
        <div class="address-block" style="float:left;">
    		<div class="block-head">Credit Cary Payment</div>
            <div>
                <label>Name on Card</label>
                <input class="form-control" type="text" name="card_name" />
            </div>
            <div>
                <label>Card number</label>
                <input class="form-control" type="text" name="card_number" />
            </div>
            <div>
                <div class="two-column">
                    <label>Card Expiry</label>
                    <select class="form-control" name="exp_month" >
                    	<option value="">Select Month</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="two-column" style="float:right;">
                    <label></label>
                    <select class="form-control" name="exp_year" >
                    	<option value="">Select Year</option>
                        <?php $year = date('Y');
							  for($i=0; $i < 15; $i++) : ?>
                              <option value="<?php echo  ($year + $i);?>"><?php echo  ($year + $i);?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div style="width:40%">
                <label>CVV</label>
                <input class="form-control" type="text" name="card_cvv" />
            </div>
        </div>
    </div>-->
	<div class="order-wrapper card_for_temp">
         <div class="order-wrapper-left col-md-9 card_for_temp">
         	  <!--<div   style="font-weight:bold; color:#000; width:100%;">
                   <div class="col-md-6" align="center">Product</div>
                   <div class="col-md-2">Quantity</div>
                   <div class="col-md-2">Price</div>
                   <div class="col-md-2">Total</div>
              </div>-->
              <?php $order_total=0.0; $item_total_amount = 0.0; $shipping_total=0.0;
			  		$total_savings_amount = 0.0; $total_msrp = 0.0; $total_store_credit = 0.0;
			  		for( $i=0; $i < count( $cart ); $i++ ) { 
					  $images = explode("," , $cart[$i]->image);
					  
					  $sale_discount = 0; $store_discount = 0; $sa_savings = 0; $msrp = 0; $store_credit = 0;
					  $promo_qry = $this->db->select('discount_percent')->from('shopsy_promotions')
											  ->where( "promotion_type = 'store' " )
											  ->where( "start_date <= '" . date('Y-m-d H:i:s') . "' AND end_date >= '" . date('Y-m-d H:i:s') ."'" )
											  ->where( 'shop_id = ' . $cart[$i]->sell_id )
											  ->get();
						if ( $promo_qry->num_rows ) {
							 $store_discount = $promo_qry->first_row()->discount_percent;
					  }

					  $msrp = $cart[$i]->msrp * $cart[$i]->quantity;
					  $total_msrp += $msrp;
					  if ( $store_discount > 0 )  $sale_discount = $cart[$i]->price / 100  *  $store_discount;
					  if ( $cart[$i]->max_store_discount > $cart[$i]->sale_discount_percent ) {
						  $sale_discount = 0;
						  $store_credit = ($cart[$i]->price * $cart[$i]->quantity ) / 100 * $cart[$i]->max_store_discount;
						  $total_store_credit += $store_credit;
					  }

					  if ( $cart[$i]->msrp > 0 )  $sa_savings = $cart[$i]->msrp  - $cart[$i]->price;
					  $savings_amount = $sa_savings  + $sale_discount;
					  $total_savings_amount += ($savings_amount * $cart[$i]->quantity) ;
					  $item_total_amount += $cart[$i]->total;
					  $net_amount = ($cart[$i]->price  - $sale_discount) * $cart[$i]->quantity;
					  $shipping_total += $cart[$i]->shipping_cost *  $cart[$i]->quantity;
					  $order_total += $item_total_amount;

					  $options = explode(";", $cart[$i]->options );
					  $option_str = '';
					  foreach( $options as $key => $option ) {
						  $option_str .=  $option_str != '' ?  "<br>" : '' ;
						  $option_str .= str_replace( ":", " - ", $option );
					  }
			  ?>
              <div  id="UsercartdivId" style="border-bottom: 1px solid #e5e3df; overflow:hidden; width:100%">
                    <div class="row">
                        <div class="col-md-2" style="float:left">
                        <a href="<?php echo $cart[$i]->seourl; ?>" class="">
                            <img src="images/product/<?php echo $cart[$i]->product_id; ?>/thumb/<?php echo $images[0]; ?>" alt="item">
                        </a>
                        </div>
                        <div class="col-md-8" style="float:left">
                           <div class="product-line" >
                          		<h5><a href="<?php echo $cart[$i]->seourl; ?>"><?php echo $cart[$i]->product_name; ?></a></h5>
                           </div>
                           <div class="product-line" >
                          		<div><?php echo $cart[$i]->shop_name; ?></div>
                           </div>
                           <?php if ( $cart[$i]->options != '' ) { ?>
                           <div class="product-line" >
                          		<div><?php echo $option_str; ?></div>
                           </div>
                           <?php } ?>
                           <div class="product-line">
                                <div class="col-md-1" style="padding-left:0px;">Qty:</div>
                                <div class="col-md-3">
                                    <select class="form-control" name="userquantity" id="userquantity<?php echo $i;?>" data-mqty="10" onchange="javascript:update_cart_qty(<?php echo $cart[0]->id .',' .$i .',' . $cart[$i]->sell_id; ?>)">
                                    <?php for($j=1; $j <= 10; $j++ ) { ?>
                                    <option <?php echo $j == $cart[$i]->quantity ? 'selected' : ''; ?> value="<?php echo $j; ?>"><?php echo $j; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                      <ul>
                                      <li><a href="javascript:void(0);" onclick="javascript:delete_cart_user(<?php echo $cart[$i]->id.",".$i.",".$cart[$i]->sell_id; ?>)">Remove</a></li>
                                      </ul>
                                </div>
                                <div class="col-amount"><b>Net Total: $<?php echo number_format($net_amount,2);?></b></div>
                           </div>
                           <div class="product-line">
                           		<div class="col-lbl msrp-price">MSRP:</div>
                                <div class="col-amount msrp-price">$<?php echo number_format($cart[$i]->msrp,2); ?></div>
                           </div>
                           <div class="product-line">
                               <div class="col-lbl">Shops@Avenue savings:</div>
                               <div class="col-amount">$<?php echo number_format( $sa_savings,2 ) ; ?></div>
                           </div>
                           <?php if( $sale_discount > 0 ) : ?>
                           <div class="product-line">
                               <div class="col-lbl">Sale Discount:</div>
                               <div class="col-amount">$<?php echo number_format( $sale_discount,2 ); ?></div>
                           </div>
                           <?php endif; ?>
                           <?php if( $store_credit > 0 ) : ?>
                           <div class="product-line">
                               <div class="col-lbl">Store Credit:</div>
                               <div class="col-amount">$<?php echo number_format( $store_credit,2 ); ?></div>
                           </div>
                           <?php endif; ?>
                           <div class="product-line">
                               <div class="col-lbl">Shops@Avenue Price:</div>
                               <div class="col-amount">$<?php echo $cart[$i]->price; ?></div>
                           </div>

                        </div>
                        <div class="product-line" style="margin-left:20px;">This product usually ships in 4 business days and should be delivered in <?php echo $cart[$i]->ship_days;?> business days.</div>

                    </div>
             </div>
             <?php } ?>
       		<div class="s-opninon-box" style="width:100%;">
				<label>Note to Admin Shop Optional</label>
				<textarea name="note" data-id="cart-note" placeholder="You can enter any info needed to complete your order or write a note to the shop"></textarea>
			</div>
             
		</div> <!-- left block wrapper -->
														
<div class="col-md-3 order-summay">

    <p style="display:block" class="default_addr"><span id="Chg_Add_Val_1"></span></p>
    <span style="color:#FF0000;" id="User_Ship_err_1"></span>
    <!--<a style="display:block" href="settings/cart-shipping-address" class="add_addr add_" onclick="shipping_address_cart();">Add new shipping address</a>-->
                        
	<div class="order-payment">
		<h4>ORDER SUMMARY</h4>
			<div class="clear"></div>
            <table class="payment-total" id="payment-total" width="100%">
                 <tbody>
                    <tr class="msrp-price">
                       	<td>MSRP:</td>
                        <td class="text-right">$<?php echo number_format($total_msrp,2); ?></td>
                    </tr>
                    <tr>
                       	<td>Savings:</td>
                        <td class="text-right">-$<?php echo number_format( $total_savings_amount,2); ?></td>
                    </tr>
                    <?php if( $total_store_credit > 0 ) : ?>
                    <tr>
                       	<td>Store Credit:</td>
                        <td class="text-right">-$<?php echo number_format( $total_store_credit,2); ?></td>
                    </tr>
                    <?php endif; ?>
                    <!--<tr>									
                       	<td>Tax (<span id="UsercarTamt_1">0</span>%) of $<span id="UserCartAmtDup_1">11.48</span></td>
                        <td class="txt_right">$<span id="UserCartTAmt_1">0.00</span> USD</td>
                    </tr>-->
                    <tr class="divider">
						<td colspan="2"></td>
					</tr>
					<tr class="grand-total">
							<td>Sub total</td>
							<td class="monetary text-right"><strong>$<?php echo number_format($total_msrp - $total_savings_amount - $total_store_credit,2); ?></strong></td>
					</tr>
                    <tr class="divider">
						<td colspan="2"></td>
					</tr>
                    <tr>
                      	<td>Shipping:</td>
                        <td class="text-right">$<?php echo number_format($shipping_total,2); ?></td>
                    </tr>
                    <tr>
                      	<td>Handling:</td>
                        <td class="text-right">$<?php echo number_format(0,2); ?></td>
                    </tr>
                    <tr class="divider">
						<td colspan="2"></td>
					</tr>
                    <tr>
                      	<td>Tax:</td>
                        <td class="text-right">---</td>
                    </tr>
                    <tr class="divider">
						<td colspan="2"></td>
					</tr>
					<tr class="grand-total">
							<td>Order total</td>
							<td class="monetary text-right"><strong>$<?php echo number_format(($total_msrp - $total_savings_amount - $total_store_credit)+$shipping_total, 2); ?></strong></td>
					</tr>
				</tbody>
			</table>
            <input class="order-submit btn-transaction" name="cartPayment" id="button-submit-merchant" value="Place Order" type="submit">
   </div>
						</div>
								</div>
			</form>
			</div>
			<!-- Cart Content Ends-->
<?php } // cart not empty  ?>
				<!-- Related Itrem Starts-->
			<?php if(!empty($relatedPurchases)){ ?>
				<h1><?php if($this->lang->line('cart_like') != '') { echo stripslashes($this->lang->line('cart_like')); } else echo 'You might also like… ';?> </h1>
				<ul class="suggestion-list">					 
							<?php $count=0; foreach($relatedPurchases as $relatedItems){ $count++; ?>
										<?php if(!empty($relatedItems->product_name)){ ?>
											<li class="suggestion col-md-4">																					
												<div class="listing-details"> 												
													<?php $imgA=@explode(',',$relatedItems->image); ?>
													<a href="<?php echo base_url().'products/'.$relatedItems->seourl; ?>">
														<img alt="<?php echo $imgA[0];?>" src="<?php echo PRODUCTPATHTHUMB.$imgA[0];?>">
													</a>
													<div class="listing-text">												
														<div class="title">
															<a href="<?php echo base_url().'products/'.$relatedItems->seourl; ?>">
																<?php echo character_limiter($relatedItems->product_name,20); ?>
															</a>
														</div>
														<div class="shop-name">By 
															<a href="<?php echo base_url().'shop-section/'.$relatedItems->seller_businessname; ?>"><?php echo character_limiter($relatedItems->seller_businessname,20); ?></a>
														</div>
													</div>
												</div>
												<div class="cart-tools">
													<div class="price"> 
														<?php echo $currencySymbol; ?>
															<?php  if($relatedItems->price != 0.00) { 
																			echo round($currencyValue*$relatedItems->price,2); 
																		} else { 
																			echo round($currencyValue*$relatedItems->pricing,2); echo '+'; 
																		}?> 
														<?php echo $currencyType;?> 
													</div>
													<a class="btn-transaction order-submit cart-btn" href="<?php echo base_url().'products/'.$relatedItems->seourl; ?>"> <?php if($this->lang->line('cart_detail') != '') { echo stripslashes($this->lang->line('cart_detail')); } else echo 'Detail'; ?> </a>
												</div>
											</li>
										<?php } ?>
							<?php if($count == 6)break; } ?> 
						
				</ul>
			<?php } ?>
			<!-- Related Item Ends-->
		</div>
	</section>
</div>

<script type="text/javascript">

$('input[name=same_as_shipping]').change(function() {
	if( $(this).is(":checked") ) {
		$('#bill-addr-block').hide();
	} else {
		$('#bill-addr-block').show();
	}
});

$(document).ready(function(){
	<?php if( isset( $ship_address->state ) ) : ?>
	    $('select[name=ship_state]').val('<?php echo $ship_address->state; ?>');
	<?php endif; ?>
});

function validate() {
	var isValid =  true;
	$('.has-error').removeClass('has-error');
	$('.error-msg').remove();
	
	//shipping address validation
	if( $('input[name=ship_name]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_name]').closest('div').addClass('has-error');
		$('input[name=ship_name]').closest('div').append('<div class="error-msg">Invalid name!</div>');
	}
	if( $('input[name=ship_address_line1]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_address_line1]').closest('div').addClass('has-error');
		$('input[name=ship_address_line1]').closest('div').append('<div class="error-msg">Invalid address line 1!</div>');
	}
	if( $('input[name=ship_city]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_city]').closest('div').addClass('has-error');
		$('input[name=ship_city]').closest('div').append('<div class="error-msg">Invalid shipping city!</div>');
	}
	if( $('select[name=ship_state]').val().trim() == '' ) {
		isValid = false;
		$('select[name=ship_state]').closest('div').addClass('has-error');
		$('select[name=ship_state]').closest('div').append('<div class="error-msg">Select shipping state!</div>');
	}
	if( $('input[name=ship_zipcode]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_zipcode]').closest('div').addClass('has-error');
		$('input[name=ship_zipcode]').closest('div').append('<div class="error-msg">Invalid shipping zip code!</div>');
	}
	if( $('input[name=ship_phone]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_phone]').closest('div').addClass('has-error');
		$('input[name=ship_phone]').closest('div').append('<div class="error-msg">Invalid phone number!</div>');
	}

	if( $('input[name=same_as_shipping]:checked').length == 0 ) {
		//billing address validation
		if( $('input[name=bill_name]').val().trim() == '' ) {
			isValid = false;
			$('input[name=bill_name]').closest('div').addClass('has-error');
			$('input[name=bill_name]').closest('div').append('<div class="error-msg">Invalid name!</div>');
		}
		if( $('input[name=bill_address_line1]').val().trim() == '' ) {
			isValid = false;
			$('input[name=bill_address_line1]').closest('div').addClass('has-error');
			$('input[name=bill_address_line1]').closest('div').append('<div class="error-msg">Invalid address line 1!</div>');
		}
		if( $('input[name=bill_city]').val().trim() == '' ) {
			isValid = false;
			$('input[name=bill_city]').closest('div').addClass('has-error');
			$('input[name=bill_city]').closest('div').append('<div class="error-msg">Invalid city!</div>');
		}
		if( $('select[name=bill_state]').val().trim() == '' ) {
			isValid = false;
			$('select[name=bill_state]').closest('div').addClass('has-error');
			$('select[name=bill_state]').closest('div').append('<div class="error-msg">Select state!</div>');
		}
		if( $('input[name=bill_zipcode]').val().trim() == '' ) {
			isValid = false;
			$('input[name=bill_zipcode]').closest('div').addClass('has-error');
			$('input[name=bill_zipcode]').closest('div').append('<div class="error-msg">Invalid zip code!</div>');
		}
	}

	//CC validation
	if( $('input[name=card_name]').val().trim() == '' ) {
		isValid = false;
		$('input[name=card_name]').closest('div').addClass('has-error');
		$('input[name=card_name]').closest('div').append('<div class="error-msg">Invalid name!</div>');
	}
	if( $('input[name=card_number]').val().trim() == '' ) {
		isValid = false;
		$('input[name=card_number]').closest('div').addClass('has-error');
		$('input[name=card_number]').closest('div').append('<div class="error-msg">Invalid card number!</div>');
	}
	if( $('select[name=exp_month]').val().trim() == '' ) {
		isValid = false;
		$('select[name=exp_month]').closest('div').addClass('has-error');
		$('select[name=exp_month]').closest('div').append('<div class="error-msg">Select card expiry month!</div>');
	}
	if( $('select[name=exp_year]').val().trim() == '' ) {
		isValid = false;
		$('select[name=exp_year]').closest('div').addClass('has-error');
		$('select[name=exp_year]').closest('div').append('<div class="error-msg">Select card expiry year!</div>');
	}
	if( $('input[name=card_cvv]').val().trim() == '' ) {
		isValid = false;
		$('input[name=card_cvv]').closest('div').addClass('has-error');
		$('input[name=card_cvv]').closest('div').append('<div class="error-msg">Invalid card CVV!</div>');
	}

	if ( ! isValid ) {
		 $('input[name=card_name]').focus();
		 return false;
	}
	
	return true;
}

function update_cart_qty(val,cid,selid) {
	var qty  = parseInt( $('#userquantity'+cid).val() );
	var mqty = parseInt( $('#userquantity'+cid).data('mqty') );
	
	if( qty == 0 || isNaN( qty ) ){
		alert('Invalid quantity');
		return false;
	}
	
	if( qty > mqty){
		$('#quantity'+cid).val(mqty);
		qty = mqty;
		alert('Maximum stock available for this product is '+mqty);
	}
		$.ajax({
			type: 'POST',   
			url:baseURL+'site/cart/ajaxUserUpdate',
			data:{'updval':val,'qty':qty,'selid':selid},
			success:function(response){
				window.location.reload();
			}
		});
}

</script>


<?php $this->load->view('site/templates/footer'); ?>