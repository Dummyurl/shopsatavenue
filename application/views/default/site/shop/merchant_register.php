<?php $this->load->view('site/templates/commonheader'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>css/login.css">
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

<body class="login-page">

    <div class="container">
        <div class="row">
            <div class="col-md-12 logo" style="text-align:center !important;">
                  <a href="<?php echo base_url(); ?>"><img src="images/logo/<?php echo $this->config->item('logo_image'); ?>" alt="" style="margin-top:7px; text-align:center;"/></a>
            </div>
        </div>
	</div>

		<div class="login-box">

        					<h2 class="text-center">Register Your Shop</h2>
                            <br>
                                <form id="login-form" name="merchant_register" class="" onSubmit="return validate();" action="" method="post"  >
                                    	<input type="hidden" name="plan" value="<?php echo $plan;?>"  >

                                        <div class="form-group  has-feedback">
                                                <input class="form-control" name="store_name" value="<?php echo $store_name;?>" placeholder="Shop Name" autocapitalize="off" autocomplete="off" required="required" autofocus="" type="text">
                                            <span class="glyphicon glyphicon-shopping-cart form-control-feedback feedback-left" aria-hidden="true" ></span>
                                            <!--<span class="glyphicon glyphicon-ok-sign form-control-feedback" aria-hidden="true"></span>
                                            <span class="is-invalid fa fa-exclamation-triangle form-control-feedback" aria-hidden="true"></span>-->
                                        </div>
                            
                                        <div class="form-group has-feedback" >
                                                <input  class="form-control" name="full_name" placeholder="First and Last Name" autocapitalize="off" value="<?php echo $full_name;?>" required="required" type="text">
                                            <span class="glyphicon glyphicon-user  form-control-feedback feedback-left" aria-hidden="true"></span>
                                            <!--<span class="feedback-icon is-valid fa fa-check-circle" aria-hidden="true"></span>
                                            <span class="feedback-icon is-invalid fa fa-exclamation-triangle " aria-hidden="true"></span>-->
                                        </div>
                                    
                                         <div class="form-group has-feedback" >
                                                <input class="form-control" name="phone_number" value="<?php echo $phone_number;?>" placeholder="Phone Number" autocapitalize="off" autocomplete="off" required="required" autofocus="" type="text">
                                            <span class="glyphicon glyphicon-phone form-control-feedback feedback-left" aria-hidden="true"></span>
                                            <!--<span class="fa fa-check-circle" aria-hidden="true"></span>
                                            <span class="fa fa-exclamation-triangle " aria-hidden="true"></span>-->
                                        </div>
                            
                                        <div class="form-group has-feedback" >
                                                <input  class="form-control" name="email" placeholder="Email Address" autocapitalize="off" value="<?php echo $email;?>" required="required" type="email">
                                           <span class="glyphicon glyphicon-envelope form-control-feedback feedback-left" aria-hidden="true"></span>
                                            <!--<span class="feedback-icon is-valid fa fa-check-circle" aria-hidden="true"></span>
                                            <span class="feedback-icon is-invalid fa fa-exclamation-triangle " aria-hidden="true"></span>-->
                                        </div>
                            
                                        <div class="form-group has-feedback" >
                                                <input  class="form-control" name="pass_code" placeholder="Password" autocapitalize="off" value="" required="required" type="password">
                                           <span class="glyphicon glyphicon-lock form-control-feedback feedback-left" aria-hidden="true"></span>
                                            <!--<span class="fa fa-check-circle" aria-hidden="true"></span>
                                            <span class="fa fa-exclamation-triangle " aria-hidden="true"></span>-->
                                        </div>
                                        
                                    
									<button  class="btn btn-large btn-block btn-primary" type="submit" name="btn-submit" value="Submit" >Register Shop</button>

                                    </form>
						<div id="terms-and-conditions-link" style="margin-top:10px;" >By clicking the above you agree to Shops@Avenue's <a target="_blank" href="<?php echo base_url().'pages/terms_and_policy';?>" >terms and privacy policy</a>, including its <a target="_blank" href="<?php echo base_url().'pages/merchant_rules';?>" >Merchant Rules</a> and <a target="_blank" href="<?php echo base_url().'pages/service_agreement';?>" >Quality of Service Agreements</a>.</div>


</div>                                            

</body>
</html>
<?php //$this->load->view('site/templates/footer'); ?>
