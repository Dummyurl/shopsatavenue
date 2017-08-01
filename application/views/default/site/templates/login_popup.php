<?php

if (is_file('google-login-mats/index.php')){
	require_once 'google-login-mats/index.php';
}

//echo $authUrl;die;
//echo $this->session->userdata('rUrl');

if($this->session->userdata('rUrl') != ''){
	$reUrl = $this->session->userdata('rUrl');
	$this->session->unset_userdata('rUrl');
	redirect ($reUrl);
}
?>
<style>
.popup_google  {
    background: url("images/fb1.png") no-repeat scroll 25px 6px #ff6a6f;
    border: 1px solid #c4c4c4;
    color: #fff;
    cursor: pointer;
    float: left;
    font-family: opensansbold;
    padding: 12px 0;
    font-size: 14px;
    width: 229px;
}
.popup_login { width:35% !important }
</style>
<?php if($this->uri->segment(1) != 'login' && $this->session->userdata('shopsy_session_user_id') == ''){?> 
<div id="signin" class="modal sign-popup in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="tabbable-panel">
				<div class="tabbable-line">
					<ul class="nav nav-tabs ">
						<li class="active">
							<a href="#tab_default_3" id="loginTab" data-toggle="tab">
							<?php if($this->lang->line('headind_sign_in') != '') { echo stripslashes($this->lang->line('headind_sign_in')); } else echo 'Sign In '; ?></a>
						</li>
						<li>
							<a href="#tab_default_4" data-toggle="tab" id="registerTab">
							<?php if($this->lang->line('user_register') != '') { echo stripslashes($this->lang->line('user_register')); } else echo 'Register'; ?></a>
						</li>	
						
						<li style="margin-bottom:0 !important;">
							<a class="btn btn-default " href="javascript:void(0);" data-dismiss="modal"><?php if($this->lang->line('X') != '') { echo stripslashes($this->lang->line('X')); } else echo 'X'; ?></a>
						</li>
							
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_default_3">
						
							<div class="tab-content">
							<div class="tab_box">
							
								<div class="popup_tab_content" style="padding: 20px 0px;">
									
									<?php if ($this->config->item('facebook_app_id') != '' && $this->config->item('facebook_app_secret') != '') { ?> 
										<div class="fb_div">
											<a style="margin:0" id="fbsignin" class="" href="<?php echo base_url().'facebooklogin'; ?>">
											<img src="images/facebook_login.png" alt="facebook">
											</a>
										</div>
										
										<?php } ?>
										<?php if($this->config->item('google_client_id') != '' && $this->config->item('google_redirect_url') != '' && $this->config->item('google_client_secret') != '') { ?>
										<div class="fb_div">
											<a href="javascript:void(0);" class="" onclick="window.location.href='<?php echo $authUrl; ?>'"><img src="images/google_login.png" alt="google"></a>
										</div>	
										<?php } ?>	
										<p class="sign-register-text">                            
											<?php $user_wo_ur_permis = str_replace("{SITENAME}",$siteTitle,$this->lang->line('user_wo_ur_permis')); ?> 
											<?php /* if($this->lang->line('user_wo_ur_permis') != '') { echo stripslashes($user_wo_ur_permis); } else echo 'Signing up will allow your friends to find you on '.stripslashes($siteTitle).". We'll never post without your permission"; */ ?>. 
										</p>
										<div class="or_div">
											<span>OR</span>
										</div>
									
									<form method="post" action="site/user/login_user" class="frm clearfix" onSubmit="return loginVal();">
										<div class="popup_login">
											<label><?php echo "Email or Username"; ?></label><span style="color:#F00;" class="redFont" id="emailAddr_Warn"></span> 
											<input type="text" class="search" style="margin:0" name="emailAddr" id="emailAddr"/>
										</div> 
										<div class="popup_login">
											<label><?php if($this->lang->line('user_password') != '') { echo stripslashes($this->lang->line('user_password')); } else echo "Password"; ?></label><span style="color:#F00;" class="redFont" id="password_Warn"></span>  
											<input type="password" class="search" style="margin:0" name="password" id="password"/>
										</div>
										<div class="popup_login">
											<input  style="margin: 0px 5px 0px 0px;" type="checkbox" name="stay_signed_in" value="yes" checked/><?php if($this->lang->line('stay_sign') != '') { echo stripslashes($this->lang->line('stay_sign')); } else echo "Stay Signed in"; ?>
										</div>
										<div class="popup_login" style="margin-bottom:15px">
											<input type="submit" class="submit_btn" value="<?php if($this->lang->line('user_signin') != '') { echo stripslashes($this->lang->line('user_signin')); } else echo "Sign In"; ?>" />
											 <span id="loginloadErr" style="display:none;padding: 12px;"><img src="images/indicator.gif" alt="Loading..."></span>									 									 
										</div>
									</form>
									
									<div style=" margin: 0 0 10px 45px;" class="div_line"></div>
									<a href="forgot-password" style="float:left;font-size: 12px; width:100%;    line-height: 23px; margin:0 0 0px 44px;"><?php if($this->lang->line('user_fgt_pwd') != '') { echo stripslashes($this->lang->line('user_fgt_pwd')); } else echo "Forgot your password?"; ?></a>
									<a href="reopen-account" style="float:left;font-size: 12px; width:100%;    line-height: 13px; margin:0 0 0px 44px;"><?php if($this->lang->line('land_reopenacc') != '') { echo stripslashes($this->lang->line('land_reopenacc')); } else echo "Reopen your account?"; ?></a>
								</div>
									
							</div>
						</div>
							
						</div>
						<div class="tab-pane" id="tab_default_4">
							 <div class="tab-content">				 
								<div class="popup_tab_content">
									<?php if ($this->config->item('facebook_app_id') != '' && $this->config->item('facebook_app_secret') != '') { ?> 
										<div class="fb_div">
											<a style="margin:0" id="fbsignin" class="" href="<?php echo base_url().'facebooklogin'; ?>">
											<img src="images/facebook_login.png" alt="facebook">
											</a>
										</div>
										
										<?php } ?>
										<?php if($this->config->item('google_client_id') != '' && $this->config->item('google_redirect_url') != '' && $this->config->item('google_client_secret') != '') { ?>
										<div class="fb_div">
											<a href="javascript:void(0);" class="" onclick="window.location.href='<?php echo $authUrl; ?>'"><img src="images/google_login.png" alt="google"></a>
										</div>	
										<?php } ?>	
										<p class="sign-register-text">                            
											<?php $user_wo_ur_permis = str_replace("{SITENAME}",$siteTitle,$this->lang->line('user_wo_ur_permis')); ?> 
											<?php /* if($this->lang->line('user_wo_ur_permis') != '') { echo stripslashes($user_wo_ur_permis); } else echo 'Signing up will allow your friends to find you on '.stripslashes($siteTitle).". We'll never post without your permission"; */ ?>. 
										</p>
										<div class="or_div">
											<span><?php if($this->lang->line('user_or') != '') { echo stripslashes($this->lang->line('user_or')); } else echo 'OR'; ?></span>
										</div>
									
									
									<form  method="post" action=""  onSubmit="return register_user(this);">
                                        <div style="width:100%">
                                            <div class="popup_login">
                                                <label>First Name</label><span style="color:#F00;" class="redFont" id="fullnameErr"></span> 											<input type="text" class="search" style="margin:0" name="fullname" id="fullname"/>
                                            </div>
                                            <div class="popup_login">
                                                <label>Last Name</label><span style="color:#F00;" class="redFont" id="lastnameErr"></span> 
                                                <input type="text" class="search" style="margin:0" name="lastname" id="lastname"/>
                                            </div>
                                        </div>
										<div class="popup_login">
											<input type="radio" style="float:left;margin: 6px 6px 0 2px;" name="gender" value="Male" checked/><span class="gen_check">Male</span>
											<input type="radio" style="float:left;margin: 6px 6px 0 12px;" name="gender" value="Female"/><span class="gen_check">Female</span>
											<input type="radio" style="float:left;margin: 6px 6px 0 12px;" name="gender" value="Unspecified"/><span class="gen_check">Rather not say</span>
										</div>
										<div class="div_line" style="margin:20px 0 0px 45px"></div>
									   
										<div class="popup_login">
											<label>Email</label><span style="color:#F00;" class="redFont" id="emailErr"></span> 
											<input type="text" class="search" style="margin:0" name="email" id="email"/>
										</div>
										<div class="popup_login">
												<label>Username</label>
												<span style="color:#F00;" class="redFont" id="usernameErr"></span> 
												<input type="text" class="search" style="margin:0" name="username" id="username" >
										</div>
										<div class="popup_login">
											<label>Password</label><span style="color:#F00;" class="redFont" id="user_passwordErr"></span> 
											<input type="password" class="search" style="margin:0" name="pwd" id="pwd"/>
										</div>
										<div class="popup_login">
											<label>Confirm Password</label><span style="color:#F00;" class="redFont" id="user_ConfirmpasswordErr"></span> 
											<input type="password" class="search" style="margin:0" name="Confirmpwd" id="Confirmpwd"/>
										</div>
										
										<p style="font-size:12px;  margin: 5px 0 4px 42px; color:#666; width:auto; float:left">								
										  <span style=" color: #999999;font-size: 11px;margin: 12px 0 5px;"> 
										  <input type="checkbox" name="privacychecking" id="privacychecking"  checked/> 
										  By clicking Register, you confirm that you accept our 
											<a href="pages/terms-conditions" target="_blank">Terms of Use</a> and <a href="pages/privacy-policy" target="_blank"> Privacy Policy</a></span>
											<br />
											
											 <input type="checkbox" name="subscription" id="subscription" style="display:none;" />
											<span class="error" id="PrivacyErr"></span>
										</p>
										
										<div class="popup_login" style="margin-bottom:15px">
											<input type="submit" class="submit_btn" value="Register" >
											<span id="loadErr"></span>
										</div>
									</form>
								</div>						
							</div>			
							<!--<div class="modal-footer footer_tab_footer">
								<div class="btn-group">
									<a class="btn btn-default submit_btn" data-dismiss="modal"  href="javascript:void(0);">Cancel</a>
								</div>
							</div>-->					
						</div>
					</div>
				</div>
			</div>          
		</div>
	</div>
</div>



<script type="text/javascript">
function loginVal(){ 
	$('#loginloadErr').show();
	$("#emailAddr_Warn").html('');
	$("#password_Warn").html('');
	
	var emailAddr = $("#emailAddr").val();
	var password = $("#password").val();
	
	if(emailAddr.length==0){
	$("#emailAddr_Warn").html(lg_required_field);
	$('#loginloadErr').hide();
	return false;
	}else if(password==''){
	$("#password_Warn").html(lg_required_field);
	$('#loginloadErr').hide();
	return false;
	}
	//return false;
}

function register_user(evt){
//	alert("Asdf");
	
	$('#loadErr').html('<span class="loading"><img src="images/indicator.gif" alt="Loading..."></span>');
	//window.location.href='www.google.com';
	var fullname = $('#fullname').val();
	var lastname = $('#lastname').val();
	var email = $('#email').val();
	var pwd = $('#pwd').val();
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
		
	}else {
		/*Check the email address is already used or no*/		
		$.ajax({
	        type: 'POST',
	        url: baseURL+'site/user/emailExists/',
	        data: {"email":email},
			dataType: 'json',
	        success: function(response)
	        {	
	        	if(response.msg==0) {
					$('#emailErr').show();
					$('#emailErr').html(lg_email_reg_already);	
					$('#loadErr').html('');
				}else if(response.msg==1){
					$.ajax({
						type: 'POST',
						url: baseURL+'site/user/registerUser',
						data: {"fullname":fullname,"username":username,"lastname":lastname,"email": email,"pwd":pwd,"gender":gender,"subscription":subscription},
						dataType: 'json',
						success: function(response)
						{	
							if(response.success == 0) {
								//$('#SpecialErr').html(response.msg);
								if(response.msg=='User name not valid'){
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
								}
								if(response.msg=='Email id already exists'){
									$('#emailErr').show();
									$('#emailErr').html(lg_email_reg_already);
									$('#loadErr').html('');
									return false;
								}
								
								window.location.href = baseURL+'register';				
								return false;
							 } else {
								 $('input[type=submit][value=Register]').prop('disabled', true);
								 $('#loadErr').html('<span style="color:red">Registration is success!. Please check your Email and confirm the registration!</span>');
								 //window.location.href = baseURL;
								 return true;
							 }
						}
					});
				}
	        }
	    });
	}
	return false;
}

</script>


<?php }?>