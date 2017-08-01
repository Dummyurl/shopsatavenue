<?php $this->load->view('site/templates/header'); ?>

<!--selection-->

<section class="container">

    	<div class="main">


                    <div class="col-md-6" >

                 	 <h1>Forgot your password</h1>

                     <div style="margin-top:20px;">

               			<form method="post" action="site/user/forgot_password_user"  name = "target" id = "target"  class="frm clearfix forgot-form">
                         <div class="form-group" >
                         <label>Enter your email address and we'll send you a link to reset your password</label>
                         <input type="text" class="form-control" id="emailids" name ="emailids" >
                         </div>

                 			 <div class="field_account"><span style="color:#F00; margin: 0 0 0 30px;" class="redFont" id="email_warn"></span></div>

          					<button type="submit" class="button" id="forgot_submit" value="Reset Password" >Reset Password</button>

                    	</form>
                    </div>

                </div>	

   		</div>

</section>

    <script type="text/javascript">

			/*Forgot validation start */

	$("#forgot_submit").click(function()

	{

		if(jQuery.trim($("#emailids").val()) == '')

		{

			$("#email_warn").html('');

			$('#email_warn').html('Please enter valid email');	

			$("#emailids").focus();

			return false;

			

		}

		else

		{	

			$("#target").submit();

		}

	});

	

	/** forgot pwd end **/

		</script>

    

<!--selection-->

<?php $this->load->view('site/templates/footer');?>





