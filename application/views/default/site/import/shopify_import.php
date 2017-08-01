<?php
$this->load->view('site/templates/merchant_header');
?>
<style>
  .apibox { float:left; width:200px; padding:10px; }
  	.error_msg { color:#F00; text-align:center; }
	.btn-link, .btn-link:active, .btn-link:focus, .btn-link:hover  { 
		cursor: pointer;
		border-color: #28a4c9;
		background-image: linear-gradient(to bottom,#5bc0de 0,#2aabd2 100%);
		color:#FFF;
		padding: 5px;
		border-radius: 5px;
		text-decoration:none !important;
	}
</style>

<div class="clear"></div>
<section class="container">
	<div class="main" style="margin: 50px 50px;">
		<div class="shop_details">   
			<span class="shop_title">SHOPIFY API INFORMATION</span>
			<div class="payment_div"></div>	
            <?php if( ! isset($shopify) ) : ?>
				<form name="shopify_import" method="post" action="site/product_import/shopify_import" onsubmit="return validate();"  enctype="multipart/form-data" >
                	<input type="hidden" name="channel_id" value="<?php echo isset($shopify->channel_id)? $shopify->channel_id :''; ?>"  >
                	<div class="apibox">
                    	<label>API Endpoint (URL)</label>
                        <input class="form-control" type="text" name="api_endpoint" value="" >
                    </div>
                	<div class="apibox">
                    	<label>API User Key</label>
                        <input class="form-control" type="text" name="api_key" value="" >
                    </div>
                	<div class="apibox">
                    	<label>API password</label>
                        <input class="form-control" type="text" name="api_password" value="" >
                    </div>
                    <div class="apibox" style="padding-top:35px;"><button type="submit" class="btn btn-info" name="btn-save-shopify" value="save">Save</button></div>
				</form>
            <?php endif; ?>
		</div>
            <?php if( isset($shopify) ) : ?>
                <div>API ENDPOINT: <?php echo $shopify->api_endpoint;?></div>
                <div>API USER KEY: <?php echo $shopify->api_user;?></div>
                <div>API PASSWORD: <?php echo $shopify->api_password;?></div>

                <div>LAST IMPORT ID: <?php echo $shopify->last_import_id;?></div>
                <div><br /><span style="font-size:smaller">50 Products will be imported since last import</span></div>

                <div style="margin-top:20px;">
                <button type="button" class="btn btn-primary" name="btn-import" style="display:inline-block;" disabled="disabled" >Import Product</button>
                <button type="button" class="btn btn-primary" name="btn-import-selection" style="display:inline-block;" >Select Products</button>
                </div>
                
            <?php endif; ?>
	</div>
</section>

<a data-toggle="modal" href="#load_import" data-keyboard="false" data-backdrop="static" aria-hidden="true" id="loadingPop"></a>
<div class="modal fade" id="load_import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-wrapper" id="popWrapper">
				<div class="text-center" id="popUpLoad">
					<img src="images/ajax-loader/ajax-loader-pop.gif" class="icon" width="50" />
					<h4>Importing Product, Please Wait...</h4>
				</div>
			</div>
		</div>
	</div>
</div>

<style>

#loadingPop {
    display:none;
}
</style>

<?php $this->load->view('site/templates/footer'); ?>

<script type="text/javascript">
$(function() {
	$("button[name=btn-import]").click(function(){
		$("#loadingPop").trigger('click');
		$("button[name=btn-import]").attr('disabled', true);

		$.ajax({
			url: baseURL + 'site/product/import_shopify_products', 
			method: 'post',
			//dataType: 'json',
			//data: ,
			success: function(data){
				var res = data.split('|');
				$('#load_import').modal('hide');
				var html = '';
				if (  res[0] == 'error' ) {
					html +=  '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
					html +=  res[1] +  '</div>';
				} else {
					html +=  '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
					html +=  res[1] +  '</div>';
				}
				$( html ).insertBefore( $(".shop_details") );
			}
		});
	
	});

	$("button[name=btn-import-selection]").click(function() {
		location = 'site/product/shopify_product_selection';
	});

});

function validate() {
	var isValid = true;
	$('.has-error').removeClass('has-error');
	$('.error-msg').remove();
	
	if ( $('input[name=api_endpoint]').val().trim() == '' ) {
		isValid = false;
		$('input[name=api_endpoint]').closest('div').addClass('has-error');
		$('input[name=api_endpoint]').closest('div').append('<div class="error-msg">Invalid API Endpoint</div>');
	}
	if ( $('input[name=api_key]').val().trim() == '' ) {
		isValid = false;
		$('input[name=api_key]').closest('div').addClass('has-error');
		$('input[name=api_key]').closest('div').append('<div class="error-msg">Invalid API KEY</div>');
	}
	if ( $('input[name=api_password]').val().trim() == '' ) {
		isValid = false;
		$('input[name=api_password]').closest('div').addClass('has-error');
		$('input[name=api_password]').closest('div').append('<div class="error-msg">Invalid API PASSWORD</div>');
	}
	
	if( ! isValid ) return false;
	
	return true;
}

</script>
