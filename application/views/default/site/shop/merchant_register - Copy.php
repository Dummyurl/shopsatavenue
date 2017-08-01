<?php $this->load->view('site/templates/commonheader');
//$this->load->view('site/templates/shop_header'); 
	
	$this->load->view('site/templates/css_files',$this->data);
	$this->load->view('site/templates/script_files',$this->data);

?>
<style>
.center {
    margin: auto;
    width: 100%;
    padding: 10px;
}
.register_box { margin:auto; width:300px; }

.center img { display:block; margin:auto; }
.page-head { text-align: center; line-height: 150%; letter-spacing: 3px; }
.head { text-align: center; line-height: 150%; letter-spacing: 3px; background-color:#CBEAEA; }

.register { margin:auto; width:150px; height:50px; border:1px solid #3FF; text-decoration:none; font-weight:800; padding-top:10px; border-radius:5px; }

.field_row { padding:10px; }

label { font-size:14px; color:#088278; }

</style>
<header>
     <div class="center">
     		<a href="<?php echo base_url();?>"><img src="images/logo/<?php echo $logo;?>" alt="Shops@Avenue logo" title="Shops@Avenue"  ></a>
     </div>
     <div class="center">
           <h1 class="page-head">Register Your Shop</h1>
     </div>

</header>
<div class="content">
   <div class="register_box">
	<form name="merchant_register" action="" method="post" onsubmit="return validate();" >
    	<input type="hidden" name="plan" value="<?php echo $plan;?>"  >
        <fieldset>
        	<div class="field_row">
            	<label for="store_name">Store name</label>
                <input class="form-control" type="text" name="store_name" value="<?php echo $store_name;?>" placeholder="Shop name"  >
            </div>
        	<div class="field_row">
            	<label for="full_name">First and last name</label>
                <input class="form-control" type="text" name="full_name" value="<?php echo $full_name;?>" placeholder="Full name"  >
            </div>
        	<div class="field_row">
            	<label for="phone_number">Phone number</label>
                <input class="form-control" type="text" name="phone_number" value="<?php echo $phone_number;?>" placeholder="Phone number"  >
            </div>
        	<div class="field_row <?php echo $error_email != '' ? 'has-error' : ''; ?>"  >
            	<label for="email">Email address</label>
                <input class="form-control" type="text" name="email" value="<?php echo $email;?>" placeholder="Email address"  >
                <?php if ( $error_email != '' ) { ?>
                <span class="error-msg"><?php echo $error_email; ?></span>
                <?php } ?>
            </div>
        	<div class="field_row">
            	<label for="pass_code">Password</label>
                <input class="form-control" type="password" name="pass_code" value="" placeholder="password"  >
            </div>
        	<!--<div>
            	<label for="phone_number">You shop URL</label>
                <input class="form-control" type="text" name="email" value="" placeholder="Email address"  >
            </div>-->
            <div  class="field_row" align="center">
                 <button class="btn btn-info" type="submit" name="btn-submit" value="Submit" >Submit</button>
            </div>
            <div class="field_row text-center">
                 <p>By clicking the above you agree to Shops@Avenue's <a target="_blank" href="<?php echo base_url().'pages/terms_and_policy';?>" >terms and privacy policy</a>, including its <a target="_blank" href="<?php echo base_url().'pages/merchant_rules';?>" >Merchant Rules</a> and <a target="_blank" href="<?php echo base_url().'pages/service_agreement';?>" >Quality of Service Agreements</a>.</p>
            </div>
        </fieldset>
    </form>
   </div>
</div>

<script type="text/javascript">
function validate() {
	var isValid = true;
	$('.error-msg').remove();
	$('.has-error').removeClass('has-error');
	
	if( $('input[name=store_name]').val().trim() == '' ) {
		isValid = false;
		$('input[name=store_name]').closest('div').addClass('has-error');
		$('input[name=store_name]').closest('div').append('<span class="error-msg">Invalid store name</span>');
	}
	if( $('input[name=full_name]').val().trim() == '' ) {
		isValid = false;
		$('input[name=full_name]').closest('div').addClass('has-error');
		$('input[name=full_name]').closest('div').append('<span class="error-msg">Invalid name</span>');
	}
	if( $('input[name=phone_number]').val().trim() == '' ) {
		isValid = false;
		$('input[name=phone_number]').closest('div').addClass('has-error');
		$('input[name=phone_number]').closest('div').append('<span class="error-msg">Invalid phone number</span>');
	}
	if( $('input[name=email]').val().trim() == '' ) {
		isValid = false;
		$('input[name=email]').closest('div').addClass('has-error');
		$('input[name=email]').closest('div').append('<span class="error-msg">Invalid email address</span>');
	}
	if( $('input[name=pass_code]').val().trim() == '' ) {
		isValid = false;
		$('input[name=pass_code]').closest('div').addClass('has-error');
		$('input[name=pass_code]').closest('div').append('<span class="error-msg">Password can\'t be empty</span>');
	}
	
	return isValid;
}

</script>

<?php $this->load->view('site/templates/footer'); ?>
