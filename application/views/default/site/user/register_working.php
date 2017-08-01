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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="css/jasny-bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="css/main-style.css"/>
    <link rel="stylesheet" type="text/css" href="css/prettyPhoto.css"/>
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>	

	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/cd-style.css"> <!-- Resource style -->

<base href="<?php echo base_url(); ?>" />
<meta name="Title" content="<?php if($meta_title=='') { echo $this->config->item('meta_title'); } else { echo $meta_title; } ?>" />
<meta name="keywords" content="<?php if($meta_keyword=='') { echo $this->config->item('meta_keyword'); } else { echo $meta_keyword; } ?>" />
<meta name="description" content="<?php if($meta_description==''){ echo $this->config->item('meta_description');}else{ echo $meta_description;}?>" />
	
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().'images/logo/'.$this->config->item('fevicon_image'); ?>">

<?php //if($this->config->item('google_verification_code')){ echo stripslashes($this->config->item('google_verification_code'));} ?>
	<script src="js/modernizr.js"></script> <!-- Modernizr -->

<script src="js/front/jquery-1.11.1.min.js"></script>
<script src="js/front/bootstrap.min-v3.3.4.js"></script>
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
<body>

<div id="header">
    <div class="container">
        <div class="row-fluid">
            <div class="span12 logo" style="text-align:center !important;">
                  <a href="<?php echo base_url(); ?>"><img src="images/logo/<?php echo $this->config->item('logo_image'); ?>" alt="" style="margin-top:7px; text-align:center;"/></a>
            </div>

<!-- start: Container -->

<div id="sequence"></div>
               
               
<div id="container">
    <div class="container">
		 <div class="row-fluid">
			<section class="span12 page-sidebar">
			<div class="span4 hidden-phone" ></div>
            <div class="span4" style="background-color:#eaeaea; padding:30px 30px 50px 30px;">
			
                	<h2 style="text-align:center;">Sign Up</h2>
                <form id="login-form" name="register-form"  action="" method="post"   >
                      <input type='hidden' value="<?php echo $this->input->get('action');  ?>" name="next_url" id="next_url"/>
                    
                <div class="input-prepend" style="height:45px !important;">
  				<span class="add-on"><i class="icon-user"></i></span>
    			<input id="fullname" name="fullname" required="required" placeholder="First Name" class="input-xlarge"  autofocus="autofocus" type="text"  >
				</div>

                 <div class="input-prepend" style="height:45px !important;">
  				<span class="add-on"><i class="icon-user"></i></span>
    				<input id="lastname" name="lastname" required="required" placeholder="Last Name" class="input-xlarge"  type="text" >
				</div>
                <div class="input-prepend" style="height:45px !important;">
  				<span class="add-on"><i class="icon-envelope"></i></span>
    				<input id="email" name="email" required="required" autocapitalize="off" autocorrect="off" placeholder="Email Address"  class="input-xlarge" type="email"  >
				</div>
                
                 <div class="input-prepend" style="height:45px !important;">
  				<span class="add-on"><i class="icon-key"></i></span>
    				<input id="pwd" name="pwd" required="required" placeholder="Password" class="input-xlarge" type="password" >
				</div>
                    <h5>By clicking below you agree to receive daily special offers and information about your order.</h5>
                    <p style="text-align:center; clear:both; line-height:19px; font-size:12px;">Already a Shopsatavenue.com member? <a href="#">Sign In</a></p>
                <p>
                    <button name="signup" value="signup" class="btn btn-large btn-block btn-primary" type="button" onClick="return register_user(this);" >Sign Up</button>
               </p>
    		</form>

 		</div>
               <div class="span4"></div>
                 <p style="text-align:center; clear:both; line-height:19px; font-size:11px;">By clicking the above you agree to <a href="#">shopsatavenue.com</a><br>
terms and privacy policy.</p>
    

           
		</section>
       	</div>
	</div>
   
</div>
<!-- end: Container -->

</div>
        
<!-- start: Footer menu -->
<section id="footer-menu">
    <div class="container">
        <div class="row-fluid">
            <div class="">
                <p class="copyright text-center">Copyrights © 2017 Shopsatavenue.com</p>
            </div>
        </div>
    </div>
</section>
                    
             <!--<div id="member-login-link" class="member-login text-center" href="/login">
                Already a Shopsatavenue.com member? <a id="member-login-link" class="auth-link member-login-link" href="login">Sign In</a>
            </div>-->
        

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>




<script type="text/javascript">
var baseURL = '<?php echo base_url(); ?>';
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

 