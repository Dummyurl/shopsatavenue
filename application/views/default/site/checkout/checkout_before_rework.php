<?php $this->load->view('site/templates/checkoutheader'); ?>

<style>
    .site-header-logo
    {
        text-align: center!important;
        padding: 15px 0px;
        border-bottom: 1px solid #efefef;
        margin-bottom: 20px;

    }
    .floatright50
    {
        float: right;
        width: 50%;
    }
    .floatleft50
    {
        float: left;
        width: 50%;
    }

    .text-right
    {
        text-align: right!important;
    }
    .vermiddle
    {
        padding: 5px 0px!important;
    }
    .left-side
    {
        float: left!important;
    }
    .right-side
    {
        float: right!important;
    }

    .saa-checkout-summary,.ssa-price-row
    {
        padding: 5px!important;

    }

    .saa-checkout-summary:hover,.ssa-price-row:hover
    {
        background-color: #f5f5f5!important;

    }

    .show-msrp .msrp-column ,  .show-msrp div{
        text-decoration:line-through!important;
    }
    .dashedbottom
    {
        border-bottom: dotted thin #444;
    }
    .saa-checkout-summary-btn {
    display: block;
    width: 100%;
    padding:20px;
    margin-bottom: 10px;
    font-weight: 700;
    font-size: 18px;
    line-height: 1;
    text-align: center;
    color: #fff;
    background: #28262a;
    border: 2px solid #28262a;
    cursor: pointer;
    -webkit-appearance: none;
    -webkit-transition: all .25s ease;
    transition: all .25s ease
}
.saa-checkout-summary-btn:hover,
.saa-checkout-summary-btn:focus,
.saa-checkout-summary-btn:active {
    background-color: transparent;
    border-color: #28262a;
    color: #28262a;
    outline: 0
}
.is-hidden
{
    display: none!important;
}

.ssa-form label{
    width: 100%!important;
}

.ssa-form input[type='text'],.ssa-form input[type='number']{
    width: 100%!important;
    border-radius: 0;
    border: 1px solid #4c4a4e;
    color: #4c4a4e;
    height:44px;
    padding: 5px;

}

.ssa-form input[type='text']:focus{
    color: #999;
    border: .0625rem solid #67ccf3
}

.ssa-form .select
{
      /*display: block;*/
    border: 1px solid #4c4a4e;
    color: #4c4a4e;
    background-color: #fff;
    box-shadow: none;
    transition: none;
    font-size: 18px;
    font-weight: 600;
    height:44px!important;
    padding: 5px;
    -webkit-appearance: none;
    appearance: none;
    border: 1px solid #28262a;
    background: #fff url('../images/select_down.svg') no-repeat right 5px top 50%;
    background-size: 30px;
    font-weight: 400;
    border-color: #ef3a5c;
    background-color: #fff;
    -moz-appearance : none!important;
    min-width:80px!important;
}

.ssa-form .cc-expiration-month,.ssa-form .cc-expiration-year,.ssa-form .ssa-state
{
    border: 1px solid #4c4a4e;
    color: #4c4a4e;
    background: #fff url('../images/select_down.svg') no-repeat right 5px top 50%;
    background-size: 10px;
    box-shadow: none;
    transition: none;
    font-size: 18px;
     height:44px!important;
    font-weight: 600;
       -moz-appearance : none!important;
 min-width:80px!important;
}

.ssa-form .nopaddmar
{
    padding: 0px!important;
    margin: 0px!important;
}
.ssa-checkout-item-container
{
    padding: 5px;
    margin: 5px;
    
    border-radius: 5px!important;
    background-color: #f5f5f5!important;
}
.height20px
{
    height: 20px!important;
    border-bottom: dotted thin #ccc;
}
.redcolor
{
    color: red!important;
}
.checkout-sub-header
{
    font-size: 20px!important;
    margin:20px 0px!important;
}
</style>
<?php 
	// $this->load->view('site/templates/css_files',$this->data);s
	// $this->load->view('site/templates/script_files',$this->data);

?>

<!--[if lt IE 9]>
<script src="js/html5shiv/dist/html5shiv.js"></script>
<![endif]-->
<?php if($this->config->item('google_verification_code')){ echo stripslashes($this->config->item('google_verification_code'));} ?>

<!--header-->

<!--<script src="js/assets/jquery-v11.js"></script>
<script src="js/assets/bootstrap.min.js"></script>-->


<style>
  .has-error { border-color:#F00 !important; }
  label.errors{ color:#F00 !important;}
  .error-msg { color:#F00; }
</style>

<script type="text/javascript" >

	/*$(function() {
		var $form = $('#transaction');
		Stripe.setPublishableKey('pk_test_xd1ggvkNRvibp03fX7OtaB42');

		$form.submit(function(event) {

			// Disable the submit button to prevent repeated clicks:
			$('button[name=place-order-button]').prop('disabled', true);
			//$form.find('.submit').val('Please wait...');
			// Request a token from Stripe:
			Stripe.card.createToken($form, stripeResponseHandler);
			// Prevent the form from being submitted:
			return false;
		});
	});*/

	$(document).ready(function() {
		$("#card_number").keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A, Command+A
				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
				 // Allow: home, end, left, right, down, up
				(e.keyCode >= 35 && e.keyCode <= 40)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
	});

</script>
</head>

<body class="content-page">
  <div class="container">
                
    <header id="header" class="header-sites header-logo-only">
      
                <div class="row">
                	<div class="col-md-12 site-header-logo">
                    <a class="header-logo-link" href="<?php echo base_url(); ?>"><img  src="/images/logo/<?php echo $this->config->item('logo_image'); ?>"></a>
                    </div>
                </div>    
              
    </header>
 <div class="row">
<div class="col-md-12">
                    <div class="floatleft50">
                        <h1 class="order-main-header">Complete Your Order</h1>
                        <div class="subhead"></div>
                    </div>
                    <div class="floatright50 text-right vermiddle">
                        <a href="<?php echo base_url(); ?>" class="float-right"><i class="fa fa-angle-left" aria-hidden="true"></i> Keep Shopping</a>
                    </div>
 </div>
                
 </div>

 <div class="row">
	<div class="col-md-12">
    	<div class="col-md-4 col-md-push-8">
        
                        
                        <div class="place-order-actions">
                            <input name="place-order" id="place-order" value="Continue" type="submit" style="display:none;">
                            <button id="place-order-button" name="place-order-button" class="saa-checkout-summary-btn btn-place-order" onClick="return validate();" >
                            <i class="fa fa-lock" aria-hidden="true"></i> &nbsp; Place Order</button>
                        </div>
 
                       <div class="row collapse summary-header">
                            <div class="small-6 columns"><h3 class="sub-header">Order Summary</h3></div>
                            <div class="small-6 columns hide-for-medium">
                                    <a href="#anchor-for-order-details" class="float-right cart-items-details-link">View Order Details</a>
                            </div>
                       </div>
                      <?php $order_total=0.0; $item_total_amount = 0.0; $shipping_total=0.0;
                            $total_savings_amount = 0.0; $total_msrp = 0.0; $msrp = 0.0;
                            $total_store_credit = 0.0;
                            for( $i=0; $i < count( $cart ); $i++ ) { 
                              $sale_discount = 0;
                              $store_credit = 0;
                              $total_msrp += $cart[$i]->msrp * $cart[$i]->quantity;
                              $shipping_total += $cart[$i]->shipping_cost * $cart[$i]->quantity;
                              if ( $cart[$i]->sale_discount_percent > 0 )  $sale_discount = $cart[$i]->price / 100  *  $cart[$i]->sale_discount_percent;
                              if ( $cart[$i]->max_store_discount > $cart[$i]->sale_discount_percent ) {
                                  $sale_discount = 0;
                                  $store_credit = ($cart[$i]->price * $cart[$i]->quantity ) / 100 * $cart[$i]->max_store_discount;
                                  $total_store_credit += $store_credit;
                              }
                                
                              $savings_amount = (($cart[$i]->msrp - $cart[$i]->price) + $sale_discount ) * $cart[$i]->quantity;
                              $total_savings_amount += $savings_amount;
                              $item_total_amount += $cart[$i]->total - ($sale_discount * $cart[$i]->quantity);
                              $sub_total += $total_msrp - $total_savings_amount - $total_store_credit;
                            }
                      ?>

                        <div id="checkout-summary-breakdown" class="row order-summary">
                            <div class="small-12 columns">
                                <div class="saa-checkout-summary show-msrp" data-row-type="price">
                                    <div id="cart-totalMsrp" class="msrp-column right-side">
                                        <span class="symbol">$</span><span class="dollars"><?php echo number_format($total_msrp,2);?></span><!--<span class="period">.</span>
                                        <span class="cents">99</span>-->
                                    </div>
                                    <div class="msrp-column left-side">MSRP:</div>
                                    <div class="clearfix"></div>
                                </div>
                                
                    
                                <div class="saa-checkout-summary order-summary-savings price-discounted discounted" data-row-type="price">
                                    <div id="cart-oskyDiscount" class="msrp-column right-side redcolor">
                                        <span class="symbol">$</span><span class="dollars"><?php echo number_format($total_savings_amount,2);?></span><!--<span class="period">.</span><span class="cents">00</span>-->
                                    </div><span class="right-side">-</span>
                                    <div class="msrp-column left-side">Savings:</div>
                                 <div class="clearfix"></div></div>
                               
                                <div class="saa-checkout-summary order-summary-discounts price-discounted discounted is-hidden" data-row-type="discount">
                                    <div id="cart-discounts" class="msrp-column right-side redcolor">
                                        <span class="symbol">$</span><span class="dollars">0</span><span class="period">.</span><span class="cents">00</span>
                                    </div><span class="right-side">-</span>
                                    <div class="msrp-column left-side discounted">
                                        Discount:<a href="#" target="_blank" title="How discounts work"><i aria-hidden="true" data-icon="¿" class="help-question-mark"></i></a>
                                    </div>
                                <div class="clearfix"></div>   </div>
                                                             
                                <div class="saa-checkout-summary order-summary-credit price-discounted discounted is-hidden" data-row-type="credit">
                                    <span id="cart-credit" class="msrp-column right-side"><span class="symbol">$</span><span class="dollars"><?php echo $total_savings_amount; ?></span>
                                    <!--<span class="period">.</span><span class="cents">00</span>--></span><span class="right-side">-</span>
                                    <div class="msrp-column left-side">
                                        Credit:<a href="#" target="_blank" title="How credits work"><i aria-hidden="true" data-icon="¿" class="help-question-mark"></i></a>
                                    </div>
                             <div class="clearfix"></div>   </div>
                                
                                <div class="saa-checkout-summary order-summary-subtotal" data-row-type="subtotalWithDiscounts">
                                    <div id="cart-subtotalWithDiscounts" class="msrp-column right-side">
                                        <span class="symbol">$</span><span class="dollars"><?php echo $sub_total; ?></span><!--<span class="period">.</span>
                                                                <span class="cents">99</span>-->
                                    </div>
                                    <div class="msrp-column left-side">Subtotal:</div>
                                    <div class="clearfix dashedbottom"></div>
                                </div>
                                
                                <div class="horizontal-dashed-divider"></div>
                                <div class="saa-checkout-summary order-summary-shipping" data-row-type="shipping">
                                    <div id="cart-shipping" class="msrp-column right-side">
                                        <span class="symbol">$</span><span class="dollars"><?php echo number_format($shipping_total,2); ?></span>
                                        <!--<span class="period">.</span><span class="cents">99</span>-->
                                    </div>
                                    <div class="msrp-column left-side">Shipping:</div>
                                         <div class="clearfix"></div>   </div>
                    
                                <div class="saa-checkout-summary " data-row-type="handling">
                                    <div id="cart-handling" class="msrp-column right-side">
                                        <span class="symbol">$</span><span class="dollars">0</span><span class="period">.</span><span class="cents">00</span>
                                    </div>
                                    <div class="msrp-column left-side">Handling:</div>
                               <div class="clearfix"></div> </div>
                                
                                <div class="saa-checkout-summary order-summary-tax" data-row-type="tax">
                                    <div id="cart-tax" class="msrp-column right-side">
                                                                …
                                    </div>
                                    <div class="msrp-column left-side">Tax:</div>
                                <div class="clearfix"></div> </div>
                               
                                <div class="saa-checkout-summary order-summary-total" data-row-type="total-price">
                                    <div id="cart-total" class="msrp-column right-side" >
                                    <span style="font-size:large;"><strong>$<?php echo number_format( $sub_total + $shipping_total, 2);?></strong></span><!--<span class="period">.</span><span class="cents">97</span>-->
                                    </div>
                                    <div class="msrp-column left-side"><strong>Order Total:</strong></div>

                                 <div class="clearfix"></div></div>
                               
                            </div>
                        </div>
                        
                        <div id="coupon-code-applied-callout" class="coupon-code-callout coupon-callout-bottom  is-hidden clearfix" data-code="">
                            <a href="#" id="remove-coupon-btn" class="remove-coupon">Remove</a>
                            <div class="coupon-message">
                                <i class="coupon-icon fa fa-check-circle" aria-hidden="true"></i><span class="coupon-text">
                                        Code Applied: <span id="applied-code" class="coupon-code-name"></span></span>
                            </div>
                        </div>
                
    </div>




    <div class="col-md-8 col-md-pull-4">
   
                <form class="ssa-form" id="transaction" method="post" action="#"  novalidate="novalidate">
                    
                        <div class="credit-card checkout-section">

                        <h2 class="checkout-sub-header">
                            <i class="fa fa-lock"></i>
                            Secure Payment Information
                        </h2>



                        <div class="col-md-4">
                        <img class="credit-cards-img"  height="70px" src="images/stripe_credit-card-logos.png" alt="Accept All Major Credit Cards">
                            
                        </div>
                        <div class="col-md-5" class="text-align:right">

<img class="ssl-badge" align="right" src="images/comodo_secure_100x85_transp.png" alt="SSL Secure Transaction" border="0" width="100px">
          


                        </div>
                         <div class="col-md-3" class="text-align:right;">

<p style=" padding-top:40px">*Required Field</p>
</div>
         <div class="clearfix"></div>
                        
        
                        <div class="inner">
                    
        
                    <div aria-required="true" class="name required has-errors">
                        <label aria-required="true" for="card_name" class="required">Name on card</label>
                        <span class="field-wrap ">
                        <input id="card_name" name="card_name" class="ssa-text-input" type="text"  >
                        </span>
                        <label for="card_name" class="errors"></label>
                    </div>
        
                    <div aria-required="true" class="number required has-errors">
                        <label aria-required="true" for="card_number" class="required">Card number</label>
                            <span class="field-wrap ">
                            <input id="card_number" name="card_number" autocapitalize="off"  pattern="[0-9]*" class="ssa-text-input" type="text" data-stripe="number">
                            </span>
                        <label for="card_number" class="errors"></label>

                    </div>
        
                    <div aria-required="true" class="state required col-md-4" style="padding: 0px; margin: 0px">
                    <div class="form-item expiration-date">
                        <label aria-required="true" for="exp_month" class="required">Expiration date</label>
                            <span class="field-wrap">
                                <select id="exp_month" name="exp_month"  class="cc-expiration-month ssa-form" data-stripe="exp_month" >
                                <option selected="selected" value="01">01</option>
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
                            </span>
                            <span class="field-wrap">
                                <select id="exp_year" name="exp_year" class="cc-expiration-year ssa-select" data-stripe="exp_year" >
                                <?php 
                                    $year = (int) date('Y');
                                    for($j=0; $j <= 13; $j++ ) { 
                                ?>
                                <option value="<?php echo $year+$j;?>"><?php echo $year+$j;?></option>
                                <?php } ?>
                                </select>
                            </span>

                        <label for="exp_year" class="errors"></label>
                    </div>
                    </div>
        
                    <div aria-required="true" class="zip required has-errors col-md-8"  style="padding: 0px; margin: 0px">
                        <span class="form-input-cvv">
                            <label aria-required="true" for="card_cvv" class="required" >CVV</label>
                            <span class="field-wrap ">
                            <input id="card_cvv" name="card_cvv" autocapitalize="off" autocorrect="off" pattern="[0-9]*" class="ssa-text-input cvv-input" type="text" style="max-width:126px;" data-stripe="cvc" >
                            </span>
                        <label for="card_cvv" class="errors"></label>
                        </span>
                    </div>
                </div>
                    </div>
        
                        <div class="billing-address checkout-section">
                <h2 class="checkout-sub-header">Billing Address</h2>
                <div class="billing-shipping-address">
                    <input id="use-shipping" class="same-as-billing" name="same_as_shipping" onClick="use_shipping_click();" checked="checked" type="checkbox">
                    <span for="use-shipping" class="same-as-billing-label">Same as shipping.</span>
                </div>
                <div  class="name required inner" style="padding-bottom:0; display:none;">
                     <label for="bill_name">Full name</label>
                     <span class="field-wrap ">
                     <input id="bill_name" name="bill_name" data-required="" autocorrect="off" class="ssa-text-input" value="" type="text">
                     </span>
                     <label for="bill_name" class="errors"></label>
                </div>
                <div style="display: none;" class="inner">
                    <div class="address-fields-wrapper">
                    <div class="country is-hidden ">
                        <label aria-required="true" for="billing_country" class="required">Country</label>
                        <span class="field-wrap">
                        <select id="billing_country" name="billing_country" class="ssa-select ssa-country" data-required="1">
                            <option value="">Select a location...</option>
                            <option value="United States of America" selected="selected">United States of America</option>
                        </select>
                        </span>
                        <label for="billing_country" class="errors"></label>
                    </div>
                    <div aria-required="true" class="address required ">
                                                <label aria-required="true" for="ship_address_line1" class="required">Address</label>
                                                <span class="field-wrap ">
                                                    <input id="bill_address_line1" name="ship_address_line1" data-required="1" autocorrect="off" class="ssa-text-input" type="text">
                                                </span>
                                                <label for="bill_address_line1" class="errors"></label>
                                            </div>
                                            <div class="address2 ">
                                                <span class="field-wrap "><input id="bill_address_line2" name="bill_address_line2" data-required="" autocorrect="off" class="ssa-text-input" type="text">
                                                </span>
                                                <label for="bill_address_line2" class="errors"></label>
                                            </div>
                   <div aria-required="true" class="city required col-md-4 nopaddmar" style="width:39% !important; display:inline-block; margin-right: 10px;">
                        <label aria-required="true" for="bill_city" class="required">City</label>
                        <span class="field-wrap ">
                            <input id="bill_city" name="bill_city" data-required="1" class="ssa-text-input" type="text">
                        </span>
                        <label for="bill_city" class="errors"></label>
                    </div>
                    <div  aria-required="true" class="state col-md-4 " style="width:39% !important">
                        <label aria-required="true" for="bill_state" class="required">State / Province</label>
                        <span class="field-wrap">
                       <select id="bill_state" name="bill_state" class="ssa-select ssa-state" data-required="1">
                                                    <option value="" selected="selected">Choose a state</option>
                                                    <?php echo $states; ?>
                                                    </select>
                        </span>
                    </div>
                    <div aria-required="true" class="zip required col-md-4 nopaddmar" style="width:20% !important; float:right;">
                        <label aria-required="true" for="bill_zipcode" class="required">ZIP code</label>
                        <span class="field-wrap ">
                            <input id="bill_zipcode" name="bill_zipcode" data-required="1" pattern="[0-9]*" class="ssa-text-input form-input-cvv" type="text">
                        </span>
                    </div>
                    <div class="state-zip-errors">
                        <label for="bill_zipcode" class="errors"></label>
                    </div>
        </div>
                </div>
            </div>
            
                 
                
                </form>





<form class="ssa-form" id="transaction" method="post" action="#"  novalidate="novalidate">






                <div class="shipping-information-inner-wrap">
                                      <section class="checkout-section shipping-address-form ">
                                        <h2 class="checkout-sub-header">Shipping Information</h2>
    
                                        <div class="address-form-holder address-fields-wrapper">
                                            <div aria-required="true" class="name required ">
                                                 <label for="ship_name">Full name</label><span class="field-wrap ">
                                                 <input id="ship_name" name="ship_name" data-required="" autocorrect="off" class="ssa-text-input" value="" type="text">
                                                 </span>
                                                 <label for="ship_name" class="errors"></label>
                                            </div>
                                            <div class="country is-hidden ">
                                                <label aria-required="true" for="cart_shippingAddress_country" class="required">Country</label>
                                                <span class="field-wrap">
                                                    <select id="ship_country" name="ship_country" class="ssa-select ssa-country" data-required="1">
                                                        <option value="237" selected="selected">United States of America</option>
                                                    </select>
                                                </span>
                                                <label for="cart_shippingAddress_country" class="errors"></label>
                                            </div>
                                            <div class="slug is-hidden">
                                                 <input id="cart_shippingAddress_slug" name="cart[shippingAddress][slug]" value="" type="hidden">
                                            </div>
                                            <div aria-required="true" class="address required ">
                                                <label aria-required="true" for="ship_address_line1" class="required">Address</label>
                                                <span class="field-wrap ">
                                                    <input id="ship_address_line1" name="ship_address_line1" data-required="1" autocorrect="off" class="ssa-text-input" type="text">
                                                </span>
                                                <label for="ship_address_line1" class="errors"></label>
                                            </div>
                                            <div class="address2 ">
                                                <span class="field-wrap "><input id="ship_address_line2" name="ship_address_line2" data-required="" autocorrect="off" class="ssa-text-input" type="text">
                                                </span>
                                                <label for="ship_address_line2" class="errors"></label>
                                            </div>
                                            <div aria-required="true" class="city required col-md-4 nopaddmar" style="width:39% !important; display:inline-block; margin-right: 10px;">
                                                <label aria-required="true" for="ship_city" class="required">City</label>
                                                <span class="field-wrap "><input id="ship_city" name="ship_city" data-required="1" autocorrect="off" class="ssa-text-input" type="text"></span>
                                                <label for="ship_city" class="errors"></label>
                                            </div>
                                            <div  aria-required="true" class="state col-md-4 " style="width:39% !important">
                                                <label aria-required="true" for="ship_state" class="required">State / Province</label>
                                                    <span class="field-wrap">
                                                    <select id="ship_state" name="ship_state" class="ssa-select ssa-state" data-required="1">
                                                    <option value="" selected="selected">Choose a state</option>
                                                    <?php echo $states; ?>
                                                    </select>
                                                    </span>
                                            </div>
                                            <div aria-required="true" class="zip required col-md-4 nopaddmar" style="width:20% !important; float:right;">
                                                <label aria-required="true" for="ship_zipcode" class="required">ZIP code</label>
                                                <span class="field-wrap ">
                                                    <input id="ship_zip" name="ship_zipcode" data-required="1" pattern="[0-9]*" class="ssa-text-input" type="text">
                                                </span>
                                            </div>
                                            <div class="state-zip-errors">
                                                <label for="ship_state" class="errors"></label>
                                                <label for="ship_zip" class="errors"></label>
                                    
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="phone-number">
                                                <label for="ship_phone">Phone number (in case of shipping problems)</label>
                                                <span class="field-wrap ">
                                                    <input id="ship_phone" name="ship_phone" class="ssa-text-input" type="text">
                                                </span>
                                            </div>
                                            <div class="phone-ext">
                                                <label for="ship_phone_ext">Extension (optional)</label>
                                                <span class="field-wrap ">
                                                    <input id="ship_phone_ext" name="cart[shippingAddress][phone][ext]" class="ssa-text-input" type="text">
                                                </span>
                                            </div>
                                            <div class="phone-errors">
                                                <label for="ship_phone" class="errors"></label>
                                                <label for="ship_phone_ext" class="errors"></label>
                                            </div>
                                            <div class="phone-number">
                                                <label for="ship_email">Email (in case of shipping problems)</label>
                                                <span class="field-wrap ">
                                                    <input id="ship_email" name="ship_email" class="ssa-text-input" type="text">
                                                </span>
                                            </div>

                                        </div>
    
                                    </section>
                                 </div>
                    </form>



                            <div id="cart-items-holder" class="cart-items-wrapper">
                    <span id="anchor-for-order-details" class="pseudo-anchor"></span>
                    <h2 class="checkout-sub-header">Order Details</h2>
                    <div class="order-item-wrapper" data-sellable-id="5678757e8b3d6fb53e8b49dc">
                    <div class="row item-summary-info">
                      <?php $order_total=0.0; $item_total_amount = 0.0; $shipping_total=0.0;
                            $total_savings_amount = 0.0; $total_msrp = 0.0; $msrp = 0.0;
                            $total_store_credit = 0.0;
                            for( $i=0; $i < count( $cart ); $i++ ) { 
                              $sale_discount = 0;
                              $store_credit = 0;
                              $total_msrp += $cart[$i]->msrp * $cart[$i]->quantity;
                              $shipping_total += $cart[$i]->shipping_cost * $cart[$i]->quantity;
                              if ( $cart[$i]->sale_discount_percent > 0 )  $sale_discount = $cart[$i]->price / 100  *  $cart[$i]->sale_discount_percent;
                              if ( $cart[$i]->max_store_discount > $cart[$i]->sale_discount_percent ) {
                                  $sale_discount = 0;
                                  $store_credit = ($cart[$i]->price * $cart[$i]->quantity ) / 100 * $cart[$i]->max_store_discount;
                                  $total_store_credit += $store_credit;
                              }
                                
                              $savings_amount = (($cart[$i]->msrp - $cart[$i]->price) + $sale_discount ) * $cart[$i]->quantity;
                              $total_savings_amount += $savings_amount;
                              $item_total_amount += $cart[$i]->total - ($sale_discount * $cart[$i]->quantity);
                              $sub_total += $total_msrp - $total_savings_amount - $total_store_credit;
                              
                              $images = explode( ',' , $cart[$i]->image );
                              $options = explode(";", $cart[$i]->options );
        
                      ?>
                    <div class="ssa-checkout-item-container">
                        <div class="col-md-2 columns">
                            <a href="<?php echo $cart[$i]->seourl; ?>">
                                <img alt="<?php echo $cart[$i]->product_name; ?>" src="images/product/<?php echo $cart[$i]->product_id; ?>/thumb/<?php echo $images[0]; ?>" width="80x">
                            </a>
                        </div>
                        <div class="col-md-8 columns">
                            <div class="sellable-name" data-sellable-slug="4-piece-set-super-soft-1800-series-bamboo-fiber-bed-sheets">
                                <?php echo $cart[$i]->product_name; ?>
                            </div>
                            <div class="sellable-configurable-options">
                            <?php foreach( $options as $key => $option ) { ?>
                                        <div class="option"><?php echo $option ?></div>
                            <?php  } ?>
                            </div>
                            
                            <div class="sellable-quantity">
                                    <span class="qty-text">QTY:</span>
                                    <span class="qty">
                                        <span class="field-wrap ">
                                        <input id="cart_quoteItems_0_quantity" name="ship_qty" min="1" max="99" class="item-qty" data-current-qty="1"  value="<?php echo $cart[$i]->quantity; ?>" type="number"></span>
                                        <label for="cart_quoteItems_0_quantity" class="errors"></label>
                
                                        <a class="remove-quote-item hide-for-medium" href="#" >Remove</a>
                                    </span>
                            </div>
                
                        </div>
                        <div class="clearfix"></div>
                        <div class="row item-copy-holder">
                            <div class="col-md-12 columns">
                                <div>
                                  
                                    <div class="shipping-copy-message">
                                         <i class="fa fa-info-circle" aria-hidden="true"></i> This product usually ships in 4 business days and should be delivered in 10 business days.
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div> <!-- item summary info -->
    
                        <div class="row ssa-item-details">
                        <div class="small-12 columns details-trigger">
                            <a  data-toggle="collapse" data-target="#ssaitem-details-<?php echo ($i+1);?>" aria-controls="details-trigger-<?php echo ($i+1);?>" data-toggle="details-trigger-<?php echo ($i+1);?>">
                                Details
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </a>
                            <hr>
                        </div>
                        <div aria-expanded="false" id="ssaitem-details-<?php echo ($i+1);?>" class=" collapse small-12 columns sellable-price" data-toggler=".expanded">
                            <div class="ssa-price-row show-msrp">
                                <div class="price-label floatleft50">MSRP:</div>
                                <div class="detail floatright50"> <span class="symbol">$</span><span class="dollars"><?php echo number_format($cart[$i]->msrp, 2);?></span><!--<span class="period">.</span><span class="cents">99</span>-->
                                </div>
                                <div class="clearfix"></div>
                            </div>
                
                            <div class="ssa-price-row osky-savings discounted" data-row-type="savings">
                                    <div class="price-label floatleft50">Shops @ Avenue Savings:</div>
                                    <div class="detail floatright50 redcolor"><span>-</span><span class="symbol">$</span><span class="dollars"><?php echo number_format($savings_amount, 2);?></span>
                                    <!--<span class="period">.</span><span class="cents">00</span>-->
                                    </div>
                                      <div class="clearfix"></div>

                            </div>
                            <div class="ssa-price-row osky-savings discounted" data-row-type="savings">
                                    <div class="price-label floatleft50">Store Credit:</div>
                                    <div class="detail floatright50 redcolor"><span>-</span><span class="symbol">$</span><span class="dollars"><?php echo number_format($store_credit, 2);?></span>
                                    <!--<span class="period">.</span><span class="cents">00</span>-->
                                    </div>
                                      <div class="clearfix"></div>
                            </div>
                            
                            <div class="ssa-price-row osky-price" data-row-type="price">
                                <div class="price-label floatleft50">Shops @ Avenue Price:</div>
                                <div class="detail floatright50"><span class="symbol">$</span><span class="dollars"><?php echo number_format( $cart[$i]->total - ($sale_discount * $cart[$i]->quantity) - $store_credit , 2); ?></span><!--<span class="period">.</span><span class="cents">99</span>-->
                            </div>
                              <div class="clearfix"></div>
                            </div>
                            
                            <div class="ssa-price-row shipping" data-row-type="shipping">
                                 <div class="price-label  floatleft50">Shipping:</div>
                                 <div class="detail floatright50 "><span class="symbol">$</span><span class="dollars"><?php echo number_format($cart[$i]->shipping_cost * $cart[$i]->quantity, 2); ?></span>
                                 <!--<span class="period">.</span><span class="cents">99</span>-->
                                 </div>
                                   <div class="clearfix"></div>
                            </div>
                
                            <div class="ssa-price-row handling" data-row-type="handling">
                                <div class="price-label floatleft50">Handling:</div>
                                 <div class="detail floatright50"><span class="symbol">$</span>
                                 <span class="dollars">0</span><span class="period">.</span><span class="cents">00</span></div>
                                   <div class="clearfix"></div>
                            </div>
                
                            <div class="ssa-price-row item-tax" data-row-type="tax">
                                <div class="price-label floatleft50 ">Tax:</div>
                                <div class="detail floatleft50"> … </div>
                                  <div class="clearfix"></div>
                            </div>
                        </div>        
                    </div>  <!-- item breakdown -->

                        <div class="row clearfix ssa-price-row sellable-total">
                            <div class="small-6 columns price-label floatleft50">
                                <strong>Item Total:</strong>
                            </div>
                            <div class="small-6 columns detail floatright50">
                                <strong class="float-right"><span style="font-size:large; font-weight:800;">$<?php echo number_format( $cart[$i]->total - ($sale_discount * $cart[$i]->quantity) - $store_credit + $shipping_total, 2) ;?> </span>
                                <!--<span class="period">.</span><span class="cents">97</span>--></strong>
                            </div>
                              <div class="clearfix"></div>
                        </div>
<div class="clearfix height20px"></div>
                        </div>
                         

                    <?php } ?>
    

    
                    </div> <!-- item wrapper -->
            </div> <!-- order items wrapper -->
<div class="clearfix"></div>

            <div class="row">
<div class="clearfix"></div>
 
                <div class="col-md-4 col-md-push-8 columns">
                    
                                    <div class="billing-shipping-address">
                                        <input  class="same-as-billing" name="terms_accept" value="I agreed to terms and condition of sale"   type="checkbox" style="margin-top:4px !important;">
                                        <label style="font-weight:normal; font-size:12px;">I agree to terms and condition of sale</label>
                                    </div>                                    

    <div class="place-order-actions">
        <!--<input name="place-order" id="place-order" value="Continue" type="submit">-->
        <button id="place-order-button" name="place-order-button" class="saa-checkout-summary-btn btn-place-order" onClick="return validate();" >
                            <i class="fa fa-lock" aria-hidden="true"></i> &nbsp; Place Order</button>
    </div>

                    <a data-toggle="collapse" data-target="#needhelp" aria-controls="need-help" href="#" class="need-help" >
                        Need help with your order?
                    </a>

                    <div aria-expanded="false" id="needhelp" class="cart-help-wrapper collapse" data-toggler=".expanded">
                    <p>Our customer support team will be happy to answer any questions about:</p>
                        <ul>
                        <li>Placing an order</li>
                        <li>Billing or shipping questions</li>
                        <li>Returning an eligible product</li>
                        </ul>
                    <p>
                    <a href="#" style="color:#000000;font-weight:600;">Contact us online</a><br>
                    Click <a href="#"><strong>here</strong></a> to send us an email.<br>

                    </p>
                    </div>
                
                </div>
                <div class="col-md-8 col-md-pull-4">&nbsp;
 </div>
            </div>
  
          
    </div>


<div class="clearfix" style="height: 50px"></div>

</div></div>
<div class="clearfix" style="height: 50px"></div>

 </div> 
   
<script type="text/javascript">
	$('.fa-chevron-down').click( function() {
		  if( $( this ).closest('.item-price-breakdown').find( $('[id^=details-trigger-]') ).hasClass('expanded')  ) {
		  	$( this ).closest('.item-price-breakdown').find( $('[id^=details-trigger-]') ).removeClass('expanded');
			$( this ).addClass( 'fa-chevron-up' );
			$( this ).removeClass( 'fa-chevron-down' );
		  } else {
		  	$( this ).closest('.item-price-breakdown').find( $('[id^=details-trigger-]') ).addClass('expanded');
			$( this ).addClass( 'fa-chevron-down' );
			$( this ).removeClass( 'fa-chevron-up' );
		  }
	});
	
	function use_shipping_click() {
		if ( $( '#use-shipping' ).prop('checked') ) {
			$('#use-shipping').closest( $('.checkout-section') ).find('div.inner').hide();
		} else {
			$('#use-shipping').closest( $('.checkout-section') ).find('div.inner').show();
		}
	}
	
function validate() {
	var isValid =  true;
	$('.has-error').removeClass('has-error');
	$('.errors').text('');
	$('.error-msg').remove();
	
	//shipping address validation
	if( $('input[name=ship_name]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_name]').closest('div').addClass('has-error');
		$('input[name=ship_name]').closest('div').find('.errors').text('Invalid name!');
	}
	if( $('input[name=ship_address_line1]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_address_line1]').closest('div').addClass('has-error');
		$('input[name=ship_address_line1]').closest('div').find('.errors').text('Invalid address line 1');
	}
	if( $('input[name=ship_city]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_city]').closest('div').addClass('has-error');
		$('input[name=ship_city]').closest('div').find('.errors').text('Invalid shipping city!');
	}
	if( $('select[name=ship_state]').val().trim() == '' ) {
		isValid = false;
		$('select[name=ship_state]').closest('div').addClass('has-error');
		$('select[name=ship_state]').closest('div').find('.errors').text('Select shipping state!');
	}
	if( $('input[name=ship_zipcode]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_zipcode]').closest('div').addClass('has-error');
		$('input[name=ship_zipcode]').closest('div').find('.errors').text('Invalid shipping zip code!');
	}
	if( $('input[name=ship_phone]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_phone]').closest('div').addClass('has-error');
		$('input[name=ship_phone]').closest('div').find('.errors').text('Invalid phone number!');
	}

	if( $('input[name=same_as_shipping]:checked').length == 0 ) {
		//billing address validation
		if( $('input[name=bill_name]').val().trim() == '' ) {
			isValid = false;
			$('input[name=bill_name]').closest('div').addClass('has-error');
			$('input[name=bill_name]').closest('div').find('.errors').text('Invalid name!');
		}
		if( $('input[name=bill_address_line1]').val().trim() == '' ) {
			isValid = false;
			$('input[name=bill_address_line1]').closest('div').addClass('has-error');
			$('input[name=bill_address_line1]').closest('div').find('.errors').text('Invalid address line 1!');
		}
		if( $('input[name=bill_city]').val().trim() == '' ) {
			isValid = false;
			$('input[name=bill_city]').closest('div').addClass('has-error');
			$('input[name=bill_city]').closest('div').find('.errors').text('Invalid city!');
		}
		if( $('select[name=bill_state]').val().trim() == '' ) {
			isValid = false;
			$('select[name=bill_state]').closest('div').addClass('has-error');
			$('select[name=bill_state]').closest('div').find('.errors').text('Select state!');
		}
		if( $('input[name=bill_zipcode]').val().trim() == '' ) {
			isValid = false;
			$('input[name=bill_zipcode]').closest('div').addClass('has-error');
			$('input[name=bill_zipcode]').closest('div').find('.errors').text('Invalid zip code!');
		}
	}

	//CC validation
	if( $('input[name=card_name]').val().trim() == '' ) {
		isValid = false;
		$('input[name=card_name]').closest('div').addClass('has-error');
		$('input[name=card_name]').closest('div').find('.errors').text('Invalid name!');
	}
	if( $('input[name=card_number]').val().trim() == '' ) {
		isValid = false;
		$('input[name=card_number]').closest('div').addClass('has-error');
		$('input[name=card_number]').closest('div').find('.errors').text('Invalid card number!');
	}
	if( $('select[name=exp_month]').val().trim() == '' ) {
		isValid = false;
		$('select[name=exp_month]').closest('div').addClass('has-error');
		$('select[name=exp_month]').closest('div').find('.errors').text('Select card expiry month!');
	}
	if( $('select[name=exp_year]').val().trim() == '' ) {
		isValid = false;
		$('select[name=exp_year]').closest('div').addClass('has-error');
		$('select[name=exp_year]').closest('div').find('.errors').text('Select card expiry year!');
	}
	if( $('input[name=card_cvv]').val().trim() == '' ) {
		isValid = false;
		$('input[name=card_cvv]').closest('div').addClass('has-error');
		$('input[name=card_cvv]').closest('div').find('.errors').text('Invalid card CVV!');
	}
	if( $('input[name=terms_accept]:checked').length == 0 ) {
		isValid = false;
		$('input[name=terms_accept]').closest('div').append('<span class="error-msg">Please accept Terms of sale!</span>');
	}
	
	if ( ! isValid ) {
		 $('input[name=card_name]').focus();
		 return false;
	}
	
	$('button[name=place-order-button]').prop('disabled', true);
	

	//$('#place-order').trigger('click');

	// Request a token from Stripe:
	Stripe.setPublishableKey('pk_test_xd1ggvkNRvibp03fX7OtaB42');
	var $form = $('#transaction');
	Stripe.card.createToken($form, stripeResponseHandler);

	return false;
}

function stripeResponseHandler(status, response) {

	 if (response.error) {
		alert(response.error.message);
		$('button[name=place-order-button]').prop('disabled', false);
	 } else {

		$('input[name=access_token]').val(response.id);
	
		$.ajax({
			url: '<?php echo base_url('site/checkout/completeOrder');?>',
			data: $('input, select, textarea'),
			type: 'POST',
			dataType: 'JSON',
			success: function(response){
				if( response.hasOwnProperty('error') ) {
					alert(response.message);
					$('button[name=place-order-button]').prop('disabled', false);
					return;
				}
				if( response.hasOwnProperty('success') ) {
					window.location.href="<?php echo base_url('site/checkout/order_thanks/'); ?>" + response.order_id;
				} else {
					window.location.href="<?php echo base_url('site/checkout/pay_failed/'); ?>" + response.order_id;
				}
			},
			error: function(error){
				window.location.href = "<?php echo base_url('site/checkout/pay_failed/0000'); ?>";
			}
		});
		//console.log(response.id);
	}
}

</script>

<?php $this->load->view('site/templates/footer'); ?>
