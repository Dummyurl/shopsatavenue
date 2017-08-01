<?php 
	$this->load->view('site/templates/merchant_header'); 
?>
<style>
  .error-msg { color:#F00; padding-left:10px; }
select{height:3.7rem;padding:.5rem;border:1px solid #414042;margin:0 0 1rem;font-size:1.5rem;font-family:inherit;line-height:normal;color:#414042;background-color:#fefefe;border-radius:0;-webkit-appearance:none;-moz-appearance:none;background-image:url("images/select_down.svg");background-size:9px 6px;background-position:right -1rem center;background-origin:content-box;background-repeat:no-repeat;padding-right:1.5rem}
label { float:left; }
</style>

	<div class="container" >
    
		<div class="tab-head ">
				<nav class="nav-sidebar">
					<ul class="nav tabs "  style="text-align:left; border:0px !important; ">
					  <!--<li class=""><a href="#tab1" data-toggle="tab">Manage Boosts</a></li>-->
					  <li class="active"><a href="#tab2" data-toggle="tab">Max Discount</a></li> 
					</ul>
				</nav>
				<div class="tab-content tab-content-t ">
					<div class="tab-pane  text-style" id="tab1">
						<div class="con-w3l">
								<div class="product-grid-item-wrapper"><h4>Manage Boosts</h4></div>
						</div>
                     	<div class="clearfix"></div>
					</div>
                    <div class="tab-pane active text-style" id="tab2">
						<div class="con-w3l">
							<div >
                                <h4>Set Your Max. Allowed Store Discount</h4>
                                <p style="margin-top:20px;">Periodically, Shopsatavenue.com runs promotional events with Discounts, Credits and Coupon Codes. Shoppers can use these limited-time incentives to save on eligible products, driving more than 50% of all sales on the marketplace.</p>
                                <p>Opt in to these programs by setting your maximum allowed discount (the most you'd reduce any of your prices during these events). Higher maximums make your product eligible for inclusion in more promotions, increasing their visibility and attracting more customers.</p>
                                <p>
                                How it works: If you set your max discount to 60%, you'll be eligible for inclusion in 20%, 45% or 60% Discount Events but not 70% events, or events with higher percentages.
                                </p>
                                <p><strong>Note:</strong> Discounts, Coupons and Credits can't be combined with each other, so you can set a high maximum with confidence. And you can change your setting at any time.</p>


                            	<div class="" style="margin-top:20px;">
                                <label aria-required="true" for="max_discount" class="required">Maximum Allowed Discount</label>
                                    <span style="padding-left:20px;" >
                                    <select id="max_discount" name="max_discount"  data-required="1">
                                        <option value="0" <?php echo $max_discount == 0 ? 'selected' : ''; ?> >0%</option>
                                        <option value="20" <?php echo $max_discount == 20 ? 'selected' : ''; ?> >20%</option>
                                        <option value="25" <?php echo $max_discount == 25 ? 'selected' : ''; ?>>25%</option>
                                        <option value="30" <?php echo $max_discount == 30 ? 'selected' : ''; ?>>30%</option>
                                        <option value="35" <?php echo $max_discount == 35 ? 'selected' : ''; ?>>35%</option>
                                        <option value="40" <?php echo $max_discount == 40 ? 'selected' : ''; ?>>40%</option>
                                        <option value="45" <?php echo $max_discount == 45 ? 'selected' : ''; ?>>45%</option>
                                        <option value="50" <?php echo $max_discount == 50 ? 'selected' : ''; ?>>50%</option>
                                        <option value="55" <?php echo $max_discount == 55 ? 'selected' : ''; ?>>55%</option>
                                        <option value="60" <?php echo $max_discount == 60 ? 'selected' : ''; ?>>60%</option>
                                        <option value="65" <?php echo $max_discount == 65 ? 'selected' : ''; ?>>65%</option>
                                        <option value="70" <?php echo $max_discount == 70 ? 'selected' : ''; ?>>70%</option>
                                        <option value="75" <?php echo $max_discount == 75 ? 'selected' : ''; ?>>75%</option>
                                        <option value="80" <?php echo $max_discount == 80 ? 'selected' : ''; ?>>80%</option>
                                    </select>
                                   </span>
                                   
                            	</div>
                                <div class="col-md-4"><button type="button" id="btn-save" class="button1" >Save Settings</button></div>
        						
							</div>
						</div>
					</div>
             </div>
		</div>
        
	</div> 
 
 
<script type="text/javascript">
   $('#btn-save').click( function(){
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
