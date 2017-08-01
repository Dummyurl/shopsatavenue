<?php $this->load->view('site/templates/merchant_header'); ?>
<style>
label{
    width: 100%!important;
}
input[type='text'], input[type='number']{
    width: 100%!important;
    border-radius: 0;
    border: 0.5px solid #4c4a4e;
    color: #4c4a4e;
    height:44px;
    padding: 5px;

}
input[type='text']:focus{
    color: #999;
    border: .0625rem solid #67ccf3
}
.saa-textarea { border: 0.0625rem solid #4c4a4e; border-radius: 0px; }
.saa-select
{
      /*display: block;*/
    border: 1px solid #4c4a4e;
    color: #4c4a4e;
    background-color: #fff;
    box-shadow: none;
    transition: none;
    font-size: 18px;
    font-weight: 600;
    height:44px!important;
    padding: 5px;
    -webkit-appearance: none;
    appearance: none;
    border: 1px solid #28262a;
    background: #fff url('../images/select_down.svg') no-repeat right 10px top 50%;
    background-size: 3%;
    font-weight: 400;
    background-color: #fff;
    -moz-appearance : none!important;
    min-width:80px!important;
}  
.fields-wrapper { margin-top:10px; }
.status-msg { padding-top:10%; padding-bottom:10%; }
</style>
   
<div class="container" >
     <div class="row" >
           <div class="col-md-12">
            <h3>Contact Us</h3>
            <p>We're here to help! We respond to emails as quickly as possible, every day of the week, in the order they're received.</p>
            <p>Find more merchant answers in our <a href="pages/merchant_help">Merchant Help Center.</a></p>
           </div>
     </div>
     <div class="row" style="margin-top:10px;" >
         <div id="send-email" class="col-md-6">
         <h4>Send an email</h4>
         	<form name="support_form" action="" method="post">
         	<div class="fields-wrapper">
             <div class="form-group">
                <label>Your name</label>
                <input class="form-control" maxlength="100" id="merchant_name" name="merchant_name" size="100" value="<?php echo $this->session->userdata['shop_name']; ?>" type="text">
             </div>
             <div class="form-group">
                <label>Your email address</label>
                <input class="form-control" maxlength="100" id="merchant_email" name="merchant_email" size="100" value="<?php echo $this->session->userdata['shopsy_session_user_email']; ?>" type="text">
             </div>
             <div class="form-group">
             	<label>Subject</label>
				<select class="saa-select" name="subject" id="subject" style="width:100%" >
                    <option value="" select="selected">Select a subject…</option>
                    <option value="Returned item (merchant)">Returned item</option>
                    <option value="Cancel an order (merchant)">Cancel an order</option>
                    <option value="Payments, billing, account info (merchant)">Payments, billing, and account info</option>
                    <option value="Products (merchant)">Products (importing, editing, searching)</option>
                    <!--<option value="Boost (merchant)">Boost</option>-->
                    <option value="Password Reset (merchant)">Password Reset</option>
                    <option value="Unsubscribe (merchant)">Unsubscribe</option>
                    <option value="General information (merchant)">General information</option>
				</select>
             </div>
             <div class="form-group">
				<label>Message:</label>
				<textarea class="form-control saa-textarea" cols="40" id="email_body"  name="email_body" rows="5" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"></textarea>
             </div>
             <div class="form-group">
				<label>Order Number (Optional)</label>
				<input class="form-control" maxlength="100" name="query_order_no" value="" type="text">
             </div>
             <div class="form-group">
                  <button class="button1" type="button" name="btn-save" onclick="return validate();" >Save</button>
             </div>
			</div>
            </form>
            
         </div>
     </div>
</div>

<?php $this->load->view('site/templates/footer');?>
<script type="text/javascript">
function validate() {
	var isValid = true;
	if( $('#merchant_name').val().trim() == '' ) {
		isValid = false;
		$('#merchant_name').closest('div').addClass('has-error');
		$('<div class="alert-danger">Invalid name!</div>').appendTo( $('#merchant_name').closest('div') ).fadeTo(20000, 0).slideUp(100, function(){ $(this).remove(); });
	}
	if( $('#merchant_email').val().trim() == '' ) {
		isValid = false;
		$('#merchant_email').closest('div').addClass('has-error');
		$('<div class="alert-danger">Invalid email!</div>').appendTo( $('#merchant_email').closest('div') ).fadeTo(20000, 0).slideUp(100, function(){ $(this).remove(); });
	}
	if( $('#subject').val().trim() == '' ) {
		isValid = false;
		$('#subject').closest('div').addClass('has-error');
		$('<div class="alert-danger">Select a subject!</div>').appendTo( $('#subject').closest('div') ).fadeTo(20000, 0).slideUp(100, function(){ $(this).remove(); });
	}
	if( $('#email_body').val().trim() == '' ) {
		isValid = false;
		$('#email_body').closest('div').addClass('has-error');
		$('<div class="alert-danger">Enter your query!</div>').appendTo( $('#email_body').closest('div') ).fadeTo(20000, 0).slideUp(100, function(){ $(this).remove(); });
	}
	
	if( ! isValid ) return false;
	
	$.ajax({
		url: '<?php echo base_url('site/support/createTicket');?>',
		data: $('input, select, textarea'),
		type: 'POST',
		dataType: 'JSON',
		success: function(response){
			if( response.hasOwnProperty('status') && response.status == 'error' ) {
				alert( JSON.stringify( response ) );
				//$('<div class="alert-danger">' + response.message + '</div>').appendTo( $('input[name=promo_code]').closest('div') ).fadeTo(3000, 0).slideUp(100, function(){ $(this).remove(); });
			}
			if( response.hasOwnProperty('status') && response.status == 'success' ) {
				$('#send-email').hide();
				var html = '';
				$('<div class="col-md-6 status-msg"><h4>Your email is sent!. Your Ticket ID: ' + response.ticket_no +' Support people will get back to you soon!</h4></div>').insertBefore( $('#send-email') );
			}
		},
		error: function(error){
			console.log(error.statusText);
			alert( error.statusText );
		}
	});
}

</script>
