<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"><!--<![endif]-->
<head>
    <title>Shops at Avenue</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;"/>

    <!-- Styles -->
      <!-- Bootstrap 3.3.6 -->
      <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="<?php echo base_url();?>font-awesome-4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>css/style.css">
      <link rel="stylesheet" href="<?php echo base_url();?>css/login.css">

	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>	


<base href="<?php echo base_url(); ?>" />
<meta name="Title" content="<?php if($meta_title=='') { echo $this->config->item('meta_title'); } else { echo $meta_title; } ?>" />
<meta name="keywords" content="<?php if($meta_keyword=='') { echo $this->config->item('meta_keyword'); } else { echo $meta_keyword; } ?>" />
<meta name="description" content="<?php if($meta_description==''){ echo $this->config->item('meta_description');}else{ echo $meta_description;}?>" />
	
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().'images/logo/'.$this->config->item('fevicon_image'); ?>">

<?php //if($this->config->item('google_verification_code')){ echo stripslashes($this->config->item('google_verification_code'));} ?>
	<!--<script src="js/modernizr.js"></script>--> <!-- Modernizr -->
<style>
.form-control-validation {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 2;
    display: block;
    width: 34px;
    height: 34px;
    line-height: 34px;
    text-align: center;
    pointer-events: auto;
}
.error-msg { color:#F00; }
.popover.bottom .arrow {
	left:90% !important;
}
.popover { left: 63px; }
</style>
</head>

<?php 

//if (is_file('google-login-mats/index.php')) {
//	require_once 'google-login-mats/index.php';
//}

if($this->session->userdata('rUrl') != '')
{
	$reUrl = $this->session->userdata('rUrl');
	$this->session->unset_userdata('rUrl');
	redirect ($reUrl);
}
?>
<body class="login-page">

    <div class="container">
        <div class="row">
            <div class="col-md-12 logo" style="text-align:center !important;">
                  <a href="<?php echo base_url(); ?>"><img src="images/logo/<?php echo $this->config->item('logo_image'); ?>" alt="" style="margin-top:7px; text-align:center;"/></a>
            </div>
        </div>
	</div>

<div class="login-box">
       		<div style="background-color:#eaeaea; padding:30px 30px 50px 30px;">
                	<h2 style="text-align:center;padding-bottom:20px;">Sign Up</h2>
                <form id="login-form" name="register-form"  action="" method="post"   >
                      <input type='hidden' value="<?php echo $this->input->get('action');  ?>" name="next_url" id="next_url"/>
                      <div class="form-group has-feedback">
                		<input id="fullname" class="form-control" name="fullname" placeholder="First Name" autocapitalize="off" autocomplete="off" required="required" autofocus="" type="text" >
                        <span class="glyphicon glyphicon-user form-control-feedback feedback-left"></span>
                      </div>
                    
                      <div class="form-group has-feedback">
                		<input id="lastname" class="form-control" name="lastname" placeholder="Last Name" autocapitalize="off" autocomplete="off" required="required" autofocus="" type="text" >
                        <span class="glyphicon glyphicon-user form-control-feedback feedback-left"></span>
                      </div>
                      <div class="form-group has-feedback">
                		<input id="email" class="form-control" name="email" placeholder="Email Address" autocapitalize="off" autocomplete="off" required="required" autofocus="" type="email" >
                        <span class="glyphicon glyphicon-envelope form-control-feedback feedback-left"></span>
                        <!--<span class="glyphicon glyphicon-remove form-control-feedback" ></span>-->
                        <a href="javascript:;" onClick="checkEmail(this);" title="check email"><span class="glyphicon glyphicon-search form-control-validation" ></span></a>
                        
                      </div>

                      <div class="form-group has-feedback">
                		<input id="pwd" class="form-control" name="pwd" placeholder="Password" autocapitalize="off" value="" required="required" type="password"  >
                        <span class="glyphicon glyphicon-lock form-control-feedback feedback-left"></span>
                        <a href="javascript:;"  title="Password Rule" data-toggle="popover" data-placement="bottom"  data-content="Enter 6 to 12 characters length password mixed with alphabet and numbers" >
                        <span class="glyphicon glyphicon-question-sign form-control-validation" ></span>
                        </a>
                      </div>
                
                    <p style="padding-top:10px;"><h5>By clicking below you agree to receive daily special offers and information about your order.</h5></p>
                    <p style="text-align:center; clear:both; line-height:19px; font-size:12px;padding-top:10px;">Already a Shopsatavenue.com member? <a href="login">Sign In</a></p>
                <p style="padding-top:10px;">
                    <button name="signup" value="signup" class="btn btn-large btn-block btn-primary" type="button" onClick="return register_user(this);" >Sign Up</button>
               </p>

    			</form>
            
            </div>
                 <p style="text-align:center; clear:both; line-height:19px; font-size:11px;">By clicking the above you agree to shopsatavenue.com<br>
<a target="_blank" href="pages/terms-conditions">terms and privacy policy.</a></p>
                <p class="copyright text-center">Copyrights © 2017 Shopsatavenue.com</p>

</div>
        
                    
<script src="/js/jquery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/bootstrap/js/bootstrap.min.js"></script>



<script type="text/javascript">
var baseURL = '<?php echo base_url(); ?>';

$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
	/*$('[data-toggle="popover"]').popover({
						 trigger: 'manual',
						 placement: 'bottom',
						 html: true
					  }).hover(function (e) {
						 e.preventDefault();
						 // Exibe o popover.
						 $(this).popover('toggle');
						$('.popover').css('left', '63px');
					  });*/
	
	});

function checkEmail( obj ) {
	$('.error-msg').remove();
	$('.has-error').removeClass('has-error');
	$('.has-success').removeClass('has-success');
	
	if( $('input[name=email]').val().trim() == '' ) {
		$(obj).closest('.form-group').append('<span class="error-msg">Invalid email!</span>');
		return false;
	}
	if( ! /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test( $('input[name=email]').val().trim() ) ) {
		$(obj).closest('.form-group').append('<span class="error-msg">Invalid email!</span>');
		return false;
	}

	$.ajax({
		type: 'POST',
		url: baseURL+'site/user/emailExists/',
		data: $('input[name=email]'),
		dataType: 'json',
		success: function(response)
		{	
			if( response.msg == 0 ) {
				$('#email').closest('div').addClass('has-error');
				$(obj).closest('.form-group').append('<span class="error-msg">Email already exist!</span>');
				
			} else {
				$('#email').closest('div').addClass('has-success');
			}
		}
	});

}

function register_user(evt){

	var fullname = $('#fullname').val();
	var lastname = $('#lastname').val();
	var email = $('#email').val();
	var pwd = $('#pwd').val();
	var isValid = true;
	
	$('.error-msg').remove();
	if ( fullname == '' ) {
		$('#fullname').closest('div').addClass('has-error');
		$('<div class="error-msg">Invalid First name</div>').insertAfter( $('#fullname').closest('div') );
		isValid = false;
	}
	if ( lastname == '' ) {
		$('#lastname').closest('div').addClass('has-error');
		$('<div class="error-msg">Invalid Last name</div>').insertAfter( $('#lastname').closest('div') );
		isValid = false;
	}
	if ( pwd == '' ) {
		$('#pwd').closest('div').addClass('has-error');
		$('<div class="error-msg">Invalid password</div>').insertAfter( $('#pwd').closest('div') );
		isValid = false;
	}
	
	if( ! isValid ) return false;


	/*$('#loadErr').html('<span class="loading"><img src="images/indicator.gif" alt="Loading..."></span>');
	var Confirmpwd = $('#Confirmpwd').val();

	var username = $(evt).find('#username').val();
	//alert(username);
	var gender=$('input[type="radio"]:checked').val();
	//var priTerm=$('input[type="checkbox"]:checked').val();
	var priTerm=$('#privacychecking').is(':checked');
	
	if($('#subscription').is(':checked')){
		subscription = 'on';
	}else{
		subscription = 'off';
	}
	
	var status=0;
	
	$('#fullnameErr').html('');
	$('#lastnameErr').html('');
	$('#emailErr').html('');
	$('#user_passwordErr').html('');
	$('#user_ConfirmpasswordErr').html('');
	$('#usernameErr').html('');
	$('#PrivacyErr').html('');
	
	$('#fullnameErr').hide();
	$('#lastnameErr').hide();
	$('#emailErr').hide();
	$('#user_passwordErr').hide();
	$('#user_ConfirmpasswordErr').hide();
	$('#usernameErr').hide();
	$('#PrivacyErr').hide();
	
	$('#SpecialErr').html('');
	if(fullname==''){
		$('#fullnameErr').show();
		$('#fullnameErr').html(lg_required_field);
		$('#loadErr').html('');
	}else if(validateAlphabet(fullname)==false){
			$('#fullnameErr').show();
			$('#fullnameErr').html(lg_alphabets);
			$('#loadErr').html('');
	}else if(fullname.length > 25){
		$('#fullnameErr').show();
		$('#fullnameErr').html(lg_firstname_25_max);
		$('#loadErr').html('');			
	}else if(lastname==''){
		$('#lastnameErr').show();
		$('#lastnameErr').html(lg_required_field);
		$('#loadErr').html('');
	}else if(validateAlphabet(lastname)==false){
			$('#lastnameErr').show();
			$('#lastnameErr').html(lg_alphabets);
			$('#loadErr').html('');
	}else if(lastname.length > 25){
		$('#lastnameErr').show();
		$('#lastnameErr').html(lg_lastname_25_max);
		$('#loadErr').html('');				
	}else if( !IsEmail(email)) { 
		$('#emailErr').show();
		$('#emailErr').html(lg_invalid_email);	
		$('#loadErr').html('');
	}else if(email==''){
		$('#emailErr').show();
		$('#emailErr').html(lg_required_field);
		$('#loadErr').html('');
	}else if( !IsEmail(email)) { 
		$('#emailErr').show();
		$('#emailErr').html(lg_invalid_email);	
		$('#loadErr').html('');
	}else if(pwd==''){
		$('#user_passwordErr').show();
		$('#user_passwordErr').html(lg_required_field);
		$('#loadErr').html('');
	}else if(pwd.length < 6){
		$('#user_passwordErr').show();
		$('#user_passwordErr').html(lg_pwd_6_char);
		$('#loadErr').html('');
	}else if(pwd.length > 12){
		$('#user_passwordErr').show();
		$('#user_passwordErr').html(lg_pwd_12_char);
		$('#loadErr').html('');		
	}else if(Confirmpwd==''){
		$('#user_ConfirmpasswordErr').show();
		$('#user_ConfirmpasswordErr').html(lg_required_field);
		$('#loadErr').html('');
	}else if(pwd != Confirmpwd)	{
		$('#user_ConfirmpasswordErr').show();
		$('#user_ConfirmpasswordErr').html(lg_pwd_not_match);
		$('#loadErr').html('');
	
	}else if(username==''){
		$('#usernameErr').show();
		$('#usernameErr').html(lg_required_field);	
		$('#loadErr').html('');
	}else if(username.length > 25){
		$('#usernameErr').show();
		$('#usernameErr').html(lg_username_25_max);
		$('#loadErr').html('');		
		
	}else if(pwd==fullname){
		$('#user_passwordErr').show();
		$('#user_passwordErr').html(lg_pwd_firstname_notsame);
		$('#loadErr').html('');
	}else if(pwd==username){
		$('#user_passwordErr').show();
		$('#user_passwordErr').html(lg_pwd_username_notsame);
		$('#loadErr').html('');
	}else if(pwd==email){
		$('#user_passwordErr').show();
		$('#user_passwordErr').html(lg_email_pwd_notsame);
		$('#loadErr').html('');	
			
	}else if(!priTerm){
		$('#PrivacyErr').show();
		$('#PrivacyErr').html(lg_accept_terms_policy);
		$('#loadErr').html('');	
		
	}else {*/
		/*Check the email address is already used or no*/		
		$.ajax({
	        type: 'POST',
	        url: baseURL+'site/user/emailExists/',
	        data: {"email":email},
			dataType: 'json',
	        success: function(response)
	        {	
	        	if(response.msg==0) {
					$('#email').closest('div').addClass('has-error');
					$('<div class="error-msg">Email already exist</div>').insertAfter( $('#email').closest('div') );
					
				}else if(response.msg==1){
					$.ajax({
						type: 'POST',
						url: baseURL+'site/user/registerUser',
						data: {"fullname":fullname, "lastname":lastname,"email": email,"pwd":pwd },
						dataType: 'json',
						success: function(response)
						{	
							if(response.success == 0) {
								/*if(response.msg=='User name not valid'){
									$('#usernameErr').show();
									$('#usernameErr').html(lg_user_name_not_valid);
									$('#loadErr').html('');
									return false;
								}
								if(response.msg=='User name already exists'){
									$('#usernameErr').show();
									$('#usernameErr').html(lg_user_name_already);
									$('#loadErr').html('');
									return false;
								}*/
								if(response.msg=='Email id already exists'){
									$('#email').closest('div').addClass('has-error');
									$('<div class="error-msg">Email already exist</div>').insertAfter( $('#email').closest('div') );
									return false;
								}
								
								//window.location.href = baseURL+'register';				
								return false;
							 } else {
								 $('#join-button').prop('disabled', true);
								 alert('Registration is success!. Please check your Email and confirm the registration!');
								 window.location.href = baseURL;
								 return false;
							 }
						}
					});
				}
	        }
	    });
	//}
	return false;
}

</script>

</body>
</html>

 