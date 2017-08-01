<?php  $this->load->view('site/templates/merchant_header'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>css/merchant.css">

<style>

</style>
<?php
$shop_name=$seller->seller_businessname; 
$seourl=$seller->seourl;
$stores = explode(",", $shopbiz['marketplace_stores']);

?>

<div class="container" >
    <form  name="frmbizinfo"   action="" method="post" enctype="multipart/form-data" onsubmit="return Validate();" >
	<div class="row">
    	<div class="col-md-6">
 			<div><h4>Business Information</h4></div>
			<div class="field-wrapper">
                 <div class="form-group">
                    <div class="col-md-4 col-xs-12 label-wrap"><label aria-required="true" for="transaction_billing_region">Legal Business Name</label></div>
                    <div class="col-md-8 col-xs-12 input-wrap">
                    	<input class="form-control" type="text"  name="legal_biz_name" value="<?php echo $shopbiz['legal_name']; ?>" placeholder="Legal Name" >
                    </div>
                 </div>
                <div class="form-group" >
                    <div class="col-md-4 col-xs-12 label-wrap"><label aria-required="true" for="transaction_billing_region">Year started:</label></div>
                    <div class="col-md-8 col-xs-12 input-wrap">
                    	<input class="form-control" type="text" maxlength="4" name="biz_start_year" value="<?php echo $shopbiz['biz_start_year']; ?>" placeholder="Year" >
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-4 col-xs-12 label-wrap"><label aria-required="true" >EIN # or SS #:</label></div>
                    <div class="col-md-8 col-xs-12 input-wrap">
                    	<input class="form-control" type="text"  name="tax_id" value="<?php echo $shopbiz['tax_id']; ?>" placeholder="TAX ID" >
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-4 col-xs-12 label-wrap"><label aria-required="true" for="transaction_billing_region">Bank Name</label></div>
                    <div class="col-md-8 col-xs-12 input-wrap">
                    	<input class="form-control" type="text" name="bank_name" value="<?php echo $shopbiz['bank_name']; ?>" placeholder="Bank Name" >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 col-xs-12 label-wrap">
                    <label aria-required="true" for="transaction_billing_region">Bank Account Number <span style="font-size:smaller">(USA)</span></label>
                    </div>
                    <div class="col-md-8 col-xs-12 input-wrap">
                    	<input class="form-control" type="text" name="bank_account_no" value="<?php echo $shopbiz['bank_account_no']; ?>" placeholder="Bank Account number" >
                    </div>
                </div>

                <div class="form-group" style="clear:both;">
                    <div class="col-md-4 col-xs-12 label-wrap"><label aria-required="true" for="transaction_billing_region">Routing/Swift Code (USA)</label></div>
                    <div class="col-md-8 col-xs-12 input-wrap">
                    	<input class="form-control" type="text" name="routing_no" value="<?php echo $shopbiz['routing_swift_code']; ?>" placeholder="Routing/Swift code" >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 col-xs-12 label-wrap"><label aria-required="true" for="transaction_billing_region">Paypal ID <span style="font-size:smaller;">(Optional)</span></label></div>
                    <div class="col-md-8 col-xs-12 input-wrap">
                    	<input  class="form-control"  type="text" name="paypal_id" value="<?php echo $shopbiz['paypal_id']; ?>" placeholder="Paypal ID" >
                    </div>
                </div>

		 	</div>
    	</div>

    	<div class="col-md-6">
            <div><h4>Shipping Address</h4></div>
			<div class="field-wrapper">
                 <div class="form-group" >
                    <div class="col-md-5 col-xs-12 label-wrap"><label aria-required="true" >Primary Contact Name</label></div>
                    <div class="col-md-7 col-xs-12 input-wrap">
                    	<input class="form-control" type="text" name="ship_contact_name" value="<?php echo $shopbiz['ship_contact_name']; ?>" placeholder="Primary contact Name" >
                    </div>
                </div>
                 <div class="form-group" >
                    <div class="col-md-5 col-xs-12 label-wrap"><label aria-required="true" >Address Line 1</label></div>
                    <div class="col-md-7 col-xs-12 input-wrap">
                    	<input class="form-control" type="text" name="address_line1" value="<?php echo $shopbiz['ship_address1']; ?>" placeholder="Address Line 1" >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-5 col-xs-12 label-wrap"><label aria-required="true" >Address Line 2</label></div>
                    <div class="col-md-7 col-xs-12 input-wrap">
                    	<input class="form-control"  type="text" name="address_line2" value="<?php echo $shopbiz['ship_address2']; ?>" placeholder="Address Line 2" >
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-5 col-xs-12 label-wrap"><label aria-required="true" >City</label></div>
                    <div class="col-md-7 col-xs-12 input-wrap">
                    	<input class="form-control"  type="text" name="ship_city" value="<?php echo $shopbiz['ship_city']; ?>" placeholder="City" >
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-5 col-xs-12 label-wrap"><label aria-required="true" for="transaction_billing_region">State</label></div>
                    <div class="col-md-7 col-xs-12 input-wrap">
                    <select  class="ss-select-small"  name="ship_state"  >
                        <?php echo $states; ?>
                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-5 col-xs-12 label-wrap"><label aria-required="true" for="ship_zip">Zip</label></div>
                    <div class="col-md-5 col-xs-12 input-wrap">
                    <input  class="form-control"  type="text" name="ship_zip" value="<?php echo $shopbiz['ship_zip']; ?>" placeholder="Zip code" >
                    </div>
                </div>
                <div><h4 style="padding-top:20px;">Contact Phone</h4></div>
                <div class="form-group" >
                    <div class="col-md-4 col-xs-12 label-wrap">
                    <label aria-required="true" for="contact_phone">Contact Phone #</label>
                    <input type="text" name="contact_phone" value="<?php echo $shopbiz['contact_phone_no']; ?>" placeholder="Phone number" >
                    </div>
                    <div class="col-md-2 col-xs-12 label-wrap">
                    	<label aria-required="true" for="contact_phone_ext">Ext #</label>
                    	<input type="text" name="contact_phone_ext" value="<?php echo $shopbiz['contact_phone_ext']; ?>" placeholder="Extension number" >
                    </div>
                    <div class="col-md-5 col-xs-12 label-wrap">
                    	<label aria-required="true" for="transaction_billing_region">Customer Service Phone</label>
                    	<input type="text" name="cs_phone_no" value="<?php echo $shopbiz['cs_phone_no']; ?>" placeholder="Customer service number" >
                    </div>

                </div>
         	</div>
	 	</div>

       </div> <!-- row -->

       <div class="row">
         <div class="text-center"><h4 style="padding-top:20px;">Contact Email</h4></div>
         <div class="col-md-6">
			<div class="field-wrapper">
            <div class="form-group">
                <div class="col-md-5 col-xs-12 label-wrap"><label aria-required="true" for="owner_email">Owner Email</label></div>
                <div class="col-md-5 col-xs-12 input-wrap">
                <input type="text" name="owner_email" value="<?php echo $shopbiz['owner_email']; ?>" placeholder="Owner email" >
                </div>
            </div>
    
            <div class="form-group">
                <div class="col-md-5 col-xs-12 label-wrap"><label aria-required="true" for="admin_email">Admin Email</label></div>
                <div class="col-md-5 col-xs-12 input-wrap">
                <input class="form-control" type="text" name="admin_email" value="<?php echo $shopbiz['admin_email']; ?>" placeholder="Admin email" >
                </div>
            </div>
            </div>
         </div>
         <div class="col-md-6">
			<div class="field-wrapper">
                <div class="form-group">
                    <div class="col-md-5 col-xs-12 label-wrap"><label aria-required="true" for="cs_email">Customer Service</label></div>
                    <div class="col-md-5 col-xs-12 input-wrap">
                    <input class="form-control"  type="text" name="cs_email" value="<?php echo $shopbiz['customer_service_email']; ?>" placeholder="Customer Service Email" >
                    </div>
                </div>
        
                <div class="form-group">
                    <div class="col-md-5 col-xs-12 label-wrap"><label aria-required="true" for="sales_email">Sales</label></div>
                    <div class="col-md-5 col-xs-12 input-wrap">
                    <input class="form-control"  type="text" name="sales_email" value="<?php echo $shopbiz['sales_email']; ?>" placeholder="Sales email" >
                    </div>
                </div>
            </div>
         </div>
         
       </div>
       
       <div class="row">
       	  <div class="col-md-6">
			<div><h4 style="padding-top:20px;">Your Websites</h4></div>
            <div class="field-wrapper">
                <div class="form-group">
                    <label aria-required="true" for="">Which other market places are selling. please provide Links to your store below:</label>
                    <input class="form-control"  type="text" name="stores[]" value="<?php echo $stores[0]; ?>" placeholder="store link" >
                </div>
                            
            </div>
       	  </div>
       </div>
       <div class="row">
          <div class="col-md-4 col-md-offset-4" >
                  	<button type="submit" value="save"  name="btn-save-bizinfo" class="saa-block-btn" >Save</button>
          </div>
       </div>
          
    </form>

</div> 
 

<script type="text/javascript">
function addStore() {
	var html = '<div class="shop_member" style="width:100%;" ><input class="form-control"  type="text" name="stores[]" value="" placeholder="store link" ></div>';
	$(html).insertAfter( $('button[name=btn-add-link').closest('div') );

}

function Validate() {
	var isValid = true;
	
	$('.has-error').removeClass('has-error');
	$('.error-msg').remove();
	
	if ( $('input[name=legal_biz_name]').val().trim() == '' ) {
		isValid = false;
		$('input[name=legal_biz_name]').closest('div').addClass('has-error');
		$('input[name=legal_biz_name]').closest('div').append( '<div class="error-msg">Invalid business name</div>' );
	}
	if ( $('input[name=tax_id]').val().trim() == '' || $('input[name=tax_id]').val().length < 9 ) {
		isValid = false;
		$('input[name=tax_id]').closest('div').addClass('has-error');
		$('input[name=tax_id]').closest('div').append( '<div class="error-msg">Invalid Tax ID</div>' );
	}
	if ( $('input[name=bank_name]').val().trim() == '' ) {
		isValid = false;
		$('input[name=bank_name]').closest('div').addClass('has-error');
		$('input[name=bank_name]').closest('div').append( '<div class="error-msg">Invalid bank name</div>' );
	}
	if ( $('input[name=routing_no]').val().trim() == '' ) {
		isValid = false;
		$('input[name=routing_no]').closest('div').addClass('has-error');
		$('input[name=routing_no]').closest('div').append( '<div class="error-msg">Invalid rounting/swift code</div>' );
	}

	if ( $('input[name=address_line1]').val().trim() == '' ) {
		isValid = false;
		$('input[name=address_line1]').closest('div').addClass('has-error');
		$('input[name=address_line1]').closest('div').append( '<div class="error-msg">Invalid address line 1</div>' );
	}
	if ( $('input[name=ship_city]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_city]').closest('div').addClass('has-error');
		$('input[name=ship_city]').closest('div').append( '<div class="error-msg">Invalid city</div>' );
	}
	if ( $('select[name=ship_state]').val() == '' ) {
		isValid = false;
		$('select[name=ship_state]').closest('div').addClass('has-error');
		$('select[name=ship_state]').closest('div').append( '<div class="error-msg">Invalid state</div>' );
	}
	if ( $('input[name=ship_zip]').val().trim() == '' ) {
		isValid = false;
		$('input[name=ship_zip]').closest('div').addClass('has-error');
		$('input[name=ship_zip]').closest('div').append( '<div class="error-msg">Invalid zip code</div>' );
	}

	if ( $('input[name=owner_email]').val().trim() == '' ) {
		isValid = false;
		$('input[name=owner_email]').closest('div').addClass('has-error');
		$('input[name=owner_email]').closest('div').append( '<div class="error-msg">Invalid email id</div>' );
	}
	if ( $('input[name=admin_email]').val().trim() == '' ) {
		isValid = false;
		$('input[name=admin_email]').closest('div').addClass('has-error');
		$('input[name=admin_email]').closest('div').append( '<div class="error-msg">Invalid admin email</div>' );
	}
	if ( $('input[name=cs_email]').val().trim() == '' ) {
		isValid = false;
		$('input[name=cs_email]').closest('div').addClass('has-error');
		$('input[name=cs_email]').closest('div').append( '<div class="error-msg">Invalid customer support email</div>' );
	}
	if ( $('input[name=sales_email]').val().trim() == '' ) {
		isValid = false;
		$('input[name=sales_email]').closest('div').addClass('has-error');
		$('input[name=sales_email]').closest('div').append( '<div class="error-msg">Invalid sales email</div>' );
	}
	if ( $('input[name=biz_start_year]').val().trim() == '' ) {
		isValid = false;
		$('input[name=biz_start_year]').closest('div').addClass('has-error');
		$('input[name=biz_start_year]').closest('div').append( '<div class="error-msg">Invalid Year</div>' );
	} else {
		var year = parseInt( $('input[name=biz_start_year]').val() );
		if ( isNaN( year ) ) {
			$('input[name=biz_start_year]').closest('div').addClass('has-error');
			$('input[name=biz_start_year]').closest('div').append( '<div class="error-msg">Invalid Year</div>' );
		}
	}
	
	if ( $('input[name=bank_account_no]').val().trim() == '' ) {
		isValid = false;
		$('input[name=bank_account_no]').closest('div').addClass('has-error');
		$('input[name=bank_account_no]').closest('div').append( '<div class="error-msg">Invalid bank account number</div>' );
	}
	if ( $('input[name=paypal_id]').val().trim() == '' ) {
		isValid = false;
		$('input[name=paypal_id]').closest('div').addClass('has-error');
		$('input[name=paypal_id]').closest('div').append( '<div class="error-msg">Invalid Paypal ID</div>' );
	}
	if ( $('input[name=contact_phone]').val().trim() == '' ) {
		isValid = false;
		$('input[name=contact_phone]').closest('div').addClass('has-error');
		$('input[name=contact_phone]').closest('div').append( '<div class="error-msg">Invalid contact phone number</div>' );
	}
	if ( $('input[name=cs_phone_no]').val().trim() == '' ) {
		isValid = false;
		$('input[name=cs_phone_no]').closest('div').addClass('has-error');
		$('input[name=cs_phone_no]').closest('div').append( '<div class="error-msg">Invalid support phone number</div>' );
	}
	
	if ( ! isValid ) return false;
	
	return true;
}

</script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.ui.totop.js"></script>

<?php $this->load->view('site/templates/footer');?>