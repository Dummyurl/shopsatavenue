<?php $this->load->view('site/templates/commonheader'); ?>
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
</head>

<body class="microsite site-kgsinfotech content-page">

                
<header id="header" class="header-sites header-logo-only">
        <div class="row header-top">
        	<div class="small-12 columns site-header-logo"><a class="header-logo-link" href="<?php echo base_url(); ?>"><img  src="images/logo/<?php echo $this->config->item('logo_image'); ?>"></a></div>
        </div>            
</header>

<div class="off-canvas-wrapper">
        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper="">
         	<div class="off-canvas-content" data-off-canvas-content="">
                <div class="main-container outer-wrap">
                    <div class="row auth-page login-page">
						<div class="auth-wrap">
        					<div class="auth-header">Register Your Shop</div>
                            <div class="auth-forms-wrap">
                                <form id="login-form" name="merchant_register" class="auth-form auth-form-login osky-form" action="" method="post"  onsubmit="return validate();" >
                                    <div class="fields-wrap collapse">
                                    	<input type="hidden" name="plan" value="<?php echo $plan;?>"  >
                                        <div class="osky-input-group " style="margin-bottom:10px; border-bottom:1px solid #000;">
                                            <i class="field-icon fa fa-building" aria-hidden="true"></i>
                                                <input  class="auth-form-field" name="store_name" value="<?php echo $store_name;?>" placeholder="Shop Name" autocapitalize="off" autocomplete="off" required="required" autofocus="" type="text">
                                            <i class="feedback-icon is-valid fa fa-check-circle" aria-hidden="true"></i>
                                            <i class="feedback-icon is-invalid fa fa-exclamation-triangle " aria-hidden="true"></i>
                                        </div>
                            
                                        <div class="osky-input-group" style="margin-bottom:10px; border-bottom:1px solid #000;">
                                           <i class="field-icon fa fa-user" aria-hidden="true"></i>
                                                <input  class="auth-form-field " name="full_name" placeholder="First and Last Name" autocapitalize="off" value="<?php echo $full_name;?>" required="required" type="text">
                                            <i class="feedback-icon is-valid fa fa-check-circle" aria-hidden="true"></i>
                                            <i class="feedback-icon is-invalid fa fa-exclamation-triangle " aria-hidden="true"></i>
                                        </div>
                                    
                                         <div class="osky-input-group " style="margin-bottom:10px; border-bottom:1px solid #000;">
                                            <i class="field-icon fa fa-phone" aria-hidden="true"></i>
                                                <input class="auth-form-field" name="phone_number" value="<?php echo $phone_number;?>" placeholder="Phone Number" autocapitalize="off" autocomplete="off" required="required" autofocus="" type="text">
                                            <i class="feedback-icon is-valid fa fa-check-circle" aria-hidden="true"></i>
                                            <i class="feedback-icon is-invalid fa fa-exclamation-triangle " aria-hidden="true"></i>
                                        </div>
                            
                                        <div class="osky-input-group" style="margin-bottom:10px; border-bottom:1px solid #000;">
                                           <i class="field-icon fa fa-envelope" aria-hidden="true"></i>
                                                <input  class="auth-form-field " name="email" placeholder="Email Address" autocapitalize="off" value="<?php echo $email;?>" required="required" type="email">
                                            <i class="feedback-icon is-valid fa fa-check-circle" aria-hidden="true"></i>
                                            <i class="feedback-icon is-invalid fa fa-exclamation-triangle " aria-hidden="true"></i>
                                        </div>
                            
                                        <div class="osky-input-group" style="margin-bottom:10px; border-bottom:1px solid #000;">
                                           <i class="field-icon fa fa-key" aria-hidden="true"></i>
                                                <input  class="auth-form-field " name="pass_code" placeholder="Password" autocapitalize="off" value="" required="required" type="password">
                                            <i class="feedback-icon is-valid fa fa-check-circle" aria-hidden="true"></i>
                                            <i class="feedback-icon is-invalid fa fa-exclamation-triangle " aria-hidden="true"></i>
                                        </div>
                                        
                                    </div>
                                    
									<button  class="osky-btn btn-auth " type="submit" name="btn-submit" value="Submit" >Register Shop</button>

                                    </form>
        					</div>
    					</div>
						<div id="terms-and-conditions-link" class="auth-join-terms">By clicking the above you agree to Shops@Avenue's <a target="_blank" href="<?php echo base_url().'pages/terms_and_policy';?>" >terms and privacy policy</a>, including its <a target="_blank" href="<?php echo base_url().'pages/merchant_rules';?>" >Merchant Rules</a> and <a target="_blank" href="<?php echo base_url().'pages/service_agreement';?>" >Quality of Service Agreements</a>.</div>

					</div>                                            
				</div>
           </div>
        </div>


</div><!-- end -->

</body>
</html>
<?php //$this->load->view('site/templates/footer'); ?>
