<?php 
$this->load->view('site/templates/header.php');
?>

<link rel="stylesheet" media="all" type="text/css" href="css/default/site/developer.css">
<?php if(isset($active_theme) && $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>User-Profile-page.css" rel="stylesheet">
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>header.css" rel="stylesheet">
<link href="./theme/themecss_<?php echo $active_theme->row()->id;  ?>footer.css" rel="stylesheet">
<?php }?>
<div class="title"><span style="color:#9ab908; font-weight:bold;">Thank you</span> for your order from <span style="color:#1c72af; font-weight:bold;">Shops@Avenue!</span></div>
        <p style="text-align:center;"> We will let you know when your order is <span style="font-style:italic;">shipped.</span><br>
Your payment is confirmed and your order number is <span style="color:#1c72af; font-weight:bold;">#<?php echo $order_id; ?>.</span>
</p>
<!--<div id="profile_div">
  <div class="main">
    <div class="container" style="margin:0">
      <div class="cart_items">
        <h2>Order Completed</h2>
        <div class="clear"></div>
        <div class="cart-list chept2" style="padding: 100px 20px;">
		  <div>Thank you for your order from Shops@Avenue!. We will let you know when your order is shipped.<br />
          Your payment is confirmed and your order number is #<?php echo $order_id; ?>.</div>
          <div class="clear"></div>
		</div>                  
      </div>
    </div>
  </div>
</div>-->
<script type="text/javascript" src="js/site/jquery.validate.js"></script>

<script>
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
</script>
<?php $this->load->view('site/templates/footer'); ?>
