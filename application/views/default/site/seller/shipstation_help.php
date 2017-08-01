<?php 
	$this->load->view('site/templates/commonheader'); 
	$this->load->view('site/templates/merchant_header'); 
?>
<link rel="stylesheet" href="css/default/front/etalage.css">
<style>
  .error-msg { color:#F00; padding-left:10px; }
</style>
<!--content-->
<div class="content-top ">
	<div class="container ">
    
		<div class="tab-head ">
				<!--<nav class="nav-sidebar">
					<ul class="nav tabs "  style="text-align:left; border:0px !important; ">
					  <li class="active"><a href="#tab2" data-toggle="tab">Max Discount</a></li> 
					</ul>
				</nav>-->
				<div class="tab-content tab-content-t ">
                    <div class="tab-pane active text-style" id="tab2">
						<div class="con-w3l">
							<div>
                                <h4>Ship Station Integration</h4><br />
                                <h5>Learn how to fetch Shops@Avenue orders in your Shipstation account.</h5>
								<br />
                                <ul style="list-style:none; line-height:28px;">
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Login into your shipstation account.</li>
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Go to Account Settings -> Selling Channels -> Store Setup.</li>
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Click on "Connect to Store or Marketplace" button.</li>
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Select "Custom Store" from the list of available store.</li>
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Fill out the details as displayed in below image.</li>
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>URL to Custom XML Page: 
                                    		<a href="site/shipstation/orders/" target="_blank">https://shopsatavenue.com/shipstation/orders/</a> (Make sure to use https://)
                                    </li>
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Username / Password that you use for login into Shopsatavenue.com.</li>
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Paid Status: Append "processing" status after "paid" seperated by comma.</li></ul>
                                    <p><img src="images/ship1.jpg"></p>
                                    <ul style="list-style:none; line-height:28px;">
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Click on "Test Connection" to test your connection with shopsatavenue.com.</li>
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Click on "Connect".</li>
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>After successful connection, you'll see "New Custom Store" added into list of selling channels.</li>
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Click on Edit and change the store name.</li></ul>
                                    <p><img src="images/ship2.jpg"></p>
                                    <ul style="list-style:none; line-height:28px;">
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Now you're ready to fetch orders from shopsatavenue.com.</li>
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>Go to "Orders" tab and click on "Update all stores" to fetch new orders.</li></ul>
                                    <p><img src="images/ship3.jpg"></p>
                                    <ul style="list-style:none; line-height:28px;">
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>When you mark any order as shipped by adding tracking details, AiMarket will receive the
                                    tracking details automatically and your buyers will receive the email notification with tracking
                                    details.</li>
                                    
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>You can configure your packing slips and email notifications templates in Settings -> Templates section on Shipstaion.</li>
                                    
                                    <li><i class="fa fa-arrow-circle-right" style="padding-right:5px; color:#0291da;"></i>For more details about shipstation, go to https://help.shipstation.com.</li></ul>

                                
        						
							</div>
						</div>
					</div>
             </div>
		</div>
        
	</div> 
</div>
 
 
	<div class="end-of-page-container"></div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
   $('#apply-coupon-btn').click( function(){
	    $('<i class="fa fa-spin fa-spinner"></i>').insertAfter( $('select[name=max_discount]') );
		$.ajax({
			url: '<?php echo base_url();?>' + 'site/shop/save_max_discount' , 
            type: 'post',
			data: $('select[name=max_discount]'),
			dataType: 'json',
			success: function(result){
	    		$('.fa-spinner').remove();
				if( result.hasOwnProperty('status') && result.status == 'error' ) {
					$('<span class="error-msg">' + result.message + '</span>').insertAfter( $('select[name=max_discount]').closest('span') );
					removeNotification();
					//alert( result.message );
				}
				if ( result.status == 'success' ) {
					$('<span class="error-msg">' + result.message + '</span>').insertAfter( $('select[name=max_discount]').closest('span') );
					removeNotification();
					//alert( result.message );
				}
				//$('.fa-spin').remove();
			}
		});

   });
   
   function removeNotification() {
	   setTimeout(function() { $(".error-msg").remove(); }, 5000);
   }
</script>
<?php $this->load->view('site/templates/footer'); ?>
