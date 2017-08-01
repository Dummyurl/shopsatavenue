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

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>	
	<script src="https://apis.google.com/js/platform.js" async defer></script>


<base href="<?php echo base_url(); ?>" />
<meta name="Title" content="<?php if($meta_title=='') { echo $this->config->item('meta_title'); } else { echo $meta_title; } ?>" />
<meta name="keywords" content="<?php if($meta_keyword=='') { echo $this->config->item('meta_keyword'); } else { echo $meta_keyword; } ?>" />
<meta name="description" content="<?php if($meta_description==''){ echo $this->config->item('meta_description');}else{ echo $meta_description;}?>" />
<meta name="google-signin-client_id" content="748858215739-588c6m08dj10972jl2mmqnlto1idh03g.apps.googleusercontent.com">
	
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().'images/logo/'.$this->config->item('fevicon_image'); ?>">

<?php //if($this->config->item('google_verification_code')){ echo stripslashes($this->config->item('google_verification_code'));} ?>
	<script src="<?php echo base_url();?>js/modernizr.js"></script> <!-- Modernizr -->

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
<body class=" login-page">

    <div class="container">
        <div class="row">
            <div class="col-md-12 logo" style="text-align:center !important;">
                  <a href="<?php echo base_url(); ?>"><img src="images/logo/<?php echo $this->config->item('logo_image'); ?>" alt="" style="margin-top:7px; text-align:center;"/></a>
            </div>
        </div>
	</div>

<div class="login-box">

       		<div style="background-color:#eaeaea; padding:30px 30px 50px 30px;">
                	<h2 style="text-align:center;">Sign In</h2>
                    <p style="margin-top:20px;"><a href="site/user/fb_oauth"><img src="images/facebook.jpg" class="img-responsive"></a></p>
                    <p style="margin-top:20px;"><a href="site/user/google_oauth"><img src="images/google_signin.png" class="img-responsive"></a></p>
                    <!--<div class="g-signin2" data-onsuccess="onSignIn"></div>-->
                    <!--<h4 style="margin-top:20px; text-align:center;">Or</h4>-->
                    <div class="social-auth-links text-center">
                      <p>- OR -</p>
                    </div>
                    
                    <form id="login-form" action="site/user/login_user" method="post">
                      <input type='hidden' value="<?php echo $this->input->get('action');  ?>" name="next_url"/>
                      <div class="form-group has-feedback">
                		<input id="email" class="form-control" name="emailAddr" placeholder="Email Address" autocapitalize="off" autocomplete="off" required="required" autofocus="" type="email" >
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      </div>
                      <div class="form-group has-feedback">
                		<input id="password" class="form-control" name="password" placeholder="Password" autocapitalize="off" value="" required="required" type="password"  >
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <div class="row">
                        <div class="col-xs-8">
                          <div class="checkbox icheck">
                            <label>
                              <input type="checkbox" name="stay_signed_in" value="1" > Stay Signed In
                            </label>
                          </div>
                        </div>
                      </div>
                        <p>
                            <div id="signinbt">
                            <button class="btn btn-large btn-block btn-primary" type="submit">Sign In</button>
                            </div>
                        </p>
                
            			<p><a href="forgot-password">I forgot my password</a></p>
                		<!--<p style="clear:both; font-size:12px; "><a href="#">Forgot Password?</a></p>-->
                        <p>
                            <?php
                                    if($this->session->flashdata('sErrMSG') != '') { ?>
                                    <div class="errorContainer" id="<?php echo $this->session->flashdata('sErrMSGType'); ?>">
                                      <script>setTimeout("hideErrDiv('<?php echo $this->session->flashdata('sErrMSGType'); ?>')", 5000);</script>
                                      <p><span style="color:red;"> <?php echo $this->session->flashdata('sErrMSG');  ?> </span></p>
                                    </div>
                             <?php } ?>
                        </p>
               			<h5 class="text-center" style="margin-top:20px;">New to shopsatavenue.com?</h5>
                
                         <div id="signinbt" style="margin-top:20px; margin-bottom:10px;">
                         <a href="register"><button class="btn btn-large btn-block btn-warning" type="button">Create an Account</button></a>
                         </div>

                    </form>

            </div>
    
          <!--<div class="login-box-body">
          </div>-->
                 <p style="text-align:center; clear:both; line-height:19px; font-size:11px;">By clicking the above you agree to shopsatavenue.com<br>
<a target="_blank" href="pages/terms-conditions" >terms and privacy policy.</a></p>
        <div class="row">
                <p class="copyright text-center">Copyright © 2017 Shopsatavenue.com</p>

        </div>

  <!-- /.login-box-body -->
</div>


<script src="/js/jquery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/bootstrap/js/bootstrap.min.js"></script>


</body>
</html>



 