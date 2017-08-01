<?php $this->load->view('site/templates/merchant_header'); ?>
<style>
.has-error { color:#F00; }
.nav-sidebar ul li { display:inline-block; }
.steps { margin:auto; padding-top:20px; padding-bottom:20px; width:80%; }
.step-bubble {  font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px; }
.field-wrapper { margin-left:15px; margin-top:15px; }
.active  { background-color: skyblue;padding: 8px;border-radius: 4px; }

border-radius: 5px;
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
#location_container > .row { margin-top:15px; }

</style>

<script type="text/javascript">
	function delete_location( obj ) {
		$( obj ).closest('div.form-group').find('#ship_cost1').val('0.00');
		$( obj ).closest('div.form-group').find('#ship_cost2').val('0.00');
	}
	function addShipping() {
		/*if ( $('#location_container > div.form-group').length == 0 ) {
			$('#location_container').append( $('#location_container_temp').html() );
			return false();
		} else {
			alert( $('#location_container > div.form-group:first-child').find('#ship_location').val() );
		}*/
	}
	$( document ).ready( function() {
	});
	
</script>

<div class="container" >
		<div class="steps">
            <nav class="nav-sidebar" >
                <ul class="nav tabs" role="navigation" >
                    <li class=""><span class="step-bubble">Step: 1.</span>Product Info</a></li>
                    <li class=""><span class="step-bubble">Step: 2.</span>Product Media</li>
                    <li class=""><span class="step-bubble" >Step: 3.</span>Price and Variation</li> 
                    <li class="active"><span class="step-bubble">Step: 4.</span>Product Shipping</li> 
                    <li class=""><span class="step-bubble">Step: 5.</span>Finalize</li> 
                </ul>
            </nav>
		</div>

	<div class="row">
        <div class="col-md-12" style="padding-bottom: 10px;">
            <h3><?php echo $shipping['info_fields']['product_name']; ?> (Draft)</h3>	
        </div>
    </div>
    
        <form class="form-horizontal" method="post" action="" name="product_shipping" >
        	<input type="hidden" name="current_step" value="shipping"  />
        	<input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  />
            
    	<div class="row"><div class="col-md-12"><h4>SHIPPING</h4></div></div>
		<div class="row" style="margin-top:15px;">
            	<div class="col-md-4" >
                    <h5><b>Location</b></h5>
                </div>
              	<div class="col-md-4 text-center"> 
                    <h5><b>Shipping cost</b></h5>
                </div>
              	<div class="col-md-3">
                    <h5><b>Next Item cost</b></h5>
                </div>
       </div>
		<div id="location_container" >
				<div class="row">
                        <div class="col-md-4">Continental United States</div>
                        <div class="col-md-3">
                            <input type="text"  name="ship_cost1[]" id="ship_cost1" placeholder="0.00" value="<?php echo isset($shipping['rates']['CUS']['ship_price']) ? $shipping['rates']['CUS']['ship_price'] : ''; ?>" />
                        </div>
						<div class="col-md-3"  >
                            <input type="text" class="form-control" name="ship_cost2[]" id="ship_cost2" placeholder="0.00"  value="<?php echo isset($shipping['rates']['CUS']['next_item_price']) ? $shipping['rates']['CUS']['next_item_price'] : ''; ?>"/>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:;" onclick="delete_location(this);" ><i class="fa fa-times fa-2x"></i></a>
                            <!--<a href="javascript:;" onclick="addShipping(this);" ><i class="fa fa-plus-circle fa-lg"></i></a>-->
                        </div>
				
                </div>        
                <div class="row"> 
                   <div class="col-md-4" >Puerto Rico</div>
                   <div class="col-md-3">
                            <input  type="text" name="ship_cost1[]" id="ship_cost1" placeholder="0.00"  value="<?php echo isset($shipping['rates']['PUR']['ship_price']) ? $shipping['rates']['PUR']['ship_price'] : ''; ?>" />
                   </div>
                   <div class="col-md-3"  >
                            <input type="text" name="ship_cost2[]" id="ship_cost2" placeholder="0.00"  value="<?php echo isset($shipping['rates']['PUR']['next_item_price']) ? $shipping['rates']['PUR']['next_item_price'] : ''; ?>"/>
                   </div>
                   <div class="col-md-2">
                            <a href="javascript:;" onclick="delete_location(this);" ><i class="fa fa-times fa-2x"></i></a>
                            <!--<a href="javascript:;" onclick="addShipping(this);" ><i class="fa fa-plus-circle fa-lg"></i> </a>-->
                  </div>
				</div>
                <div class="row"> 
                    <div class="col-md-4">Alaska & Hawaii</div>
                    <div class="col-md-3">
                        <input type="text" name="ship_cost1[]" id="ship_cost1" placeholder="0.00" value="<?php echo isset($shipping['rates']['AHW']['ship_price']) ? $shipping['rates']['AHW']['ship_price'] : ''; ?>" />
                    </div>
                    <div class="col-md-3" >
                        <input type="text" name="ship_cost2[]" id="ship_cost2" placeholder="0.00"  value="<?php echo isset($shipping['rates']['AHW']['next_item_price']) ? $shipping['rates']['AHW']['next_item_price'] : ''; ?>" />
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:;" onclick="delete_location(this);" ><i class="fa fa-times fa-2x"></i></a>
                        <!--<a href="javascript:;" onclick="addShipping( this );" ><i class="fa fa-plus-circle fa-lg"></i> </a>-->
                    </div>
                </div>
                
		</div>
        <div class="row" style="margin-top:10px;"> 
              	<div class="col-md-12">
                	<div class="form-group">
              		<label>Estimated Ship Time, in Business Days</label><br />
                    <p>Number of business days it takes you to ship your product out</p>
                    <select class="saa-select" name="ship_days" id="ship_days">
                        <option value="1" <?php echo $shipping['info_fields']['ship_days'] == 1 ? 'selected' : ''; ?> >1</option>
                        <option value="2" <?php echo $shipping['info_fields']['ship_days'] == 2 ? 'selected' : ''; ?> >2</option>
                        <option value="3" <?php echo $shipping['info_fields']['ship_days'] == 3 ? 'selected' : ''; ?> >3</option>
                        <option value="4" <?php echo $shipping['info_fields']['ship_days'] == 4 ? 'selected' : ''; ?>>4</option>
                        <option value="5" <?php echo $shipping['info_fields']['ship_days'] == 5 ? 'selected' : ''; ?>>5</option>
                        <option value="6" <?php echo $shipping['info_fields']['ship_days'] == 6 ? 'selected' : ''; ?>>6</option>
                        <option value="7" <?php echo $shipping['info_fields']['ship_days'] == 7 ? 'selected' : ''; ?>>7</option>
                        <option value="8" <?php echo $shipping['info_fields']['ship_days'] == 8 ? 'selected' : ''; ?>>8</option>
                        <option value="9" <?php echo $shipping['info_fields']['ship_days'] == 9 ? 'selected' : ''; ?>>9</option>
                        <option value="10" <?php echo $shipping['info_fields']['ship_days'] == 10 ? 'selected' : ''; ?>>10</option>
                        <option value="11" <?php echo $shipping['info_fields']['ship_days'] == 11 ? 'selected' : ''; ?>>11</option>
                        <option value="12" <?php echo $shipping['info_fields']['ship_days'] == 12 ? 'selected' : ''; ?>>12</option>
                        <option value="13" <?php echo $shipping['info_fields']['ship_days'] == 13 ? 'selected' : ''; ?>>13</option>
                        <option value="14" <?php echo $shipping['info_fields']['ship_days'] == 14 ? 'selected' : ''; ?>>14</option>
                        <option value="15" <?php echo $shipping['info_fields']['ship_days'] == 15 ? 'selected' : ''; ?>>15</option>
                    </select>
                    </div>
                 </div>
              <div class="col-md-12">
              	<div class="form-group"> 
              		<label>Shipping Price Details</label>
                    <span>If you charge for special packaging or delivery rates, let your customer know. Be transparent about your shipping prices</span>
                    <textarea class="saa-textarea" name="ship_detail" id="ship_detail"><?php echo $shipping['info_fields']['ship_price_info']; ?></textarea>
                </div>
              </div>
           
              	<div class="col-md-12">
              		<div class=""> 
              		<label>Return Policy</label>
                    <p>If you select "Final Sale", a customer can return a product only if it arrived damaged. If you choose "14 day returns", customer can return any product upto 14 days after it was delivered, as long as it is in sellable condition.</p>
                	</div>
              		<div class="form-group">
                      <div class="col-md-6">
                        <select class="saa-select" name="return_policy" id="return_policy" style="width:100%;">
                             <option value="Final Sale. No returns" <?php echo $shipping['info_fields']['return_policy'] == 'Final Sale. No returns' ? 'selected' : ''; ?> >Final Sale. No returns</option>
                             <option value="Holiday returns" <?php echo $shipping['info_fields']['return_policy'] == 'Holiday returns' ? 'selected' : ''; ?>>Holiday returns</option>
                        </select>
                      </div>
                 	</div>
              </div>

           </div>
           <div class="row" style="margin-top:15px;">
              	<div class="col-md-4">
              		<label>Weight (lbs.)</label>
                    <input type="text"  name="ship_weight" id="ship_weight" />
                 </div>
              	<div class="col-md-4">
              		<label>Length (in.) <span style="font-size:10px">(optional)</span></label>
                    <input type="text" name="ship_length" id="ship_weight" />
                 </div>
              	<div class="col-md-4">
              		<label>Width (in.) <span style="font-size:10px">(optional)</span></label>
                    <input type="text" name="ship_width" id="ship_weight" />
                 </div>
              	<div class="col-md-4">
              		<label>Height (in.) <span style="font-size:10px">(optional)</span></label>
                    <input type="text" name="ship_height" id="ship_weight" />
                 </div>

          </div>
          
          <div class="row" >
              <div class="col-md-2" >
                <input type="submit" name="submit" class="button1"  value="Previous Step"  />
              </div>
              <div class="col-md-2" >
                <input type="submit" name="submit" class="button1"  value="Next Step"  />
              </div>
              <div class="col-md-4 col-md-push-4" >
                <button type="submit" name="submit" class="button1" value="save_later" >Save and continue later</button>
              </div>       
         </div>            
               
        </form>
        
</div>    
<?php $this->load->view('site/templates/footer');?>
