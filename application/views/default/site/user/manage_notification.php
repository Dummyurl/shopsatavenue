<?php $this->load->view('site/templates/header'); ?>
		
<?php $this->load->view('site/templates/user_menu'); ?>

<div class="container">
<section class="">
			<div class="row">
				<div class="col-md-8 col-md-offset-4">

						<h2 class="ptit">Manage Notification</h2><hr>
							<form action ="save-notification-changes" method="post">	
								<hr>
								<p><b>I want to get Email notification from Admin</b></p>
								<p style="margin-top:10px;">
										  <?php
											$noty_arr=array();
											if($userDetails->row()->notification_email != "" )	$noty_arr=explode(',',$userDetails->row()->notification_email );
										  ?>
										  <input type="checkbox" class='updateCheckbox' <?php if(in_array('follow',$noty_arr)) echo "checked" ?>  value="follow" id="follow" name ="follow" >Sale on Favourite item or Category<br>
										  <input type="checkbox"  class='updateCheckbox'  <?php if(in_array('msg',$noty_arr)) echo "checked" ?>  value="msg" id="msg" name="msg" >Sale on your Favourite Stores<br>
										  <input type="checkbox"  class='updateCheckbox'  <?php if(in_array('like',$noty_arr)) echo "checked" ?>  value="like" id="like" name="like" >General Shopsatavenue.com sale<br>
										  <input type="checkbox" class='updateCheckbox'  <?php if(in_array('lik_of_like',$noty_arr)) echo "checked" ?> value="lik_of_like" id="lik_of_like" name="lik_of_like" >Special Promotions<br>
										  <!--<input type="checkbox" class='updateCheckbox'  <?php if(in_array('fav_shop_pro',$noty_arr)) echo "checked" ?> value="fav_shop_pro" id="fav_shop_pro" name="fav_shop_pro" >Select All notifications<br>-->
								</p> 
								<div id="notificationUpdate">
								
								</div>
                                <br />
                                <div>
                                    <div class="col-md-3">
                                    <button type="button" class="btn  btn-block btn-primary" name="btn-save" onclick="saveNotification()" value="SAVE">SAVE</button>
                                    </div>
                                    <div id="save-status" class="col-md-2"></div>
                                </div>
							</form>
			</div>
		</div>

        

<div style="height: 20px; clear: both"></div>

</section>   
</div>		

<!-- Section_start -->


<?php $this->load->view('site/templates/footer'); ?>

<script>
function saveNotification() {

   var notification = [];
	$('[class="updateCheckbox"]:checked').each(function(i,e) {
		notification.push(e.value);
	});

	notification = notification.join(',');

	if($("#updates").is(":checked")){
	    updates = "Yes";
	} else {
	   	updates = "No";
	}

 		//$("#notificationUpdate").html('<div class="col-xs-6 alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Unsubscribed All mails. Once done page automatically reload. Please wait a moment.</div><div style="clear:both"></div>');

	$('#save-status').html('<i class="fa fa-spin fa-spinner fa-2x"></i>');
	$('button[name=btn-save]').prop('disabled', true);

          $.ajax({
			  type: "POST",
			  url: "<?php echo base_url(); ?>" + "site/user_settings/save_manage_notification",
			  dataType: 'json',
			  data: {notification: notification, updates: updates},
			  success: function(res) {
				  if (res) {
					 $('#save-status').html('');
					 $('button[name=btn-save]').prop('disabled', false );
					 $("#notificationUpdate").html('<div class="col-xs-6 alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Settings saved! </strong></div><div style="clear:both"></div>');
				  // Show Entered Value
				  }
			  }
          });

   // save_user_email_setting

   
  }
</script>