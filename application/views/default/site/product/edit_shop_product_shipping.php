<?php 
//$this->load->view('site/templates/productheader');
//$this->load->view('site/templates/shop_header'); 
$this->load->view('site/templates/commonheader');

?>

<style>
#When_is{margin:0px !important;}
</style>
<style>
#progressDiv { display:inline-block; margin-left: 20px; width:200px; float:left; }

#progressDiv > div {
	margin-top:10px;
}
#progressDiv > div a {
    font: bold 12px sans-serif;
    text-align: center;
    color: #999;
    line-height: 18px;
}

#progressDiv > div span {
color: #FFF;
vertical-align: middle;
display: inline-block;
border-radius: 9px;
line-height: 18px;
background: #999 none repeat scroll 0% 0%;
margin-right: 10px;
width: 17px;
text-align: center;
}
#progressDiv > div.current span {
	background-color:#000;
}
#progressDiv > div.current a {
	color:#000;
}

</style>
<!--<script type="text/javascript" src="js/site/jquery-1.7.1.min.js"></script>-->
<script type="text/javascript" src="js/site/jquery.1.11.min.js"></script>
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
</head>

<body class="microsite site-kgsinfotech content-page">

                
<header id="header" class="header-sites header-logo-only">
        <div class="row header-top">
        	<div class="small-12 columns site-header-logo">
            <a class="header-logo-link" href="<?php echo base_url(); ?>"><img  src="images/logo/<?php echo $this->config->item('logo_image'); ?>"></a>
            </div>
        </div>            
</header>

<div class="off-canvas-wrapper" style="padding:0px 3rem 0px 3rem; margin-top:50px;">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper="">
    <div class="off-canvas-content" data-off-canvas-content="">
    <div class="main-container outer-wrap">
    <div class="row collapse">
        <div class="small-12 columns">
        <div class="container-fluid">
			
    
    <div class="layout-columns">
        <div class="cms-content">
			<div class="content-top">
				<div class="container">
				<div class="tab-head ">
                    <nav class="nav-sidebar">
                        <ul class="nav tabs" style="text-align:left; border:0px !important; ">
                            <li><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 1:</span>Product Info</li>
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 2:</span>Product Media</li>
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 3:</span>Price and Variation</li> 
                            <li class="active" ><a href="#tab1" data-toggle="tab"><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 4:</span>Product Shipping</a></li> 
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 5:</span>Finalize</li> 
                        </ul>
                    </nav>

					<div class="tab-content tab-content-t">
					<div class="tab-pane active text-style" id="tab1">
						<div class="con-w3l">
                      	<div class="product-grid-item-wrapper">
                            <div class="cart-wrapper row">
                                <div class="checkout-forms-wrapper ">
                                    <div class="row osky-form cart-form">
                                        <div class="table-row">
                            <div class="table-header">


            <form class="form-horizontal" method="post" action="" name="product_shipping" >
                <input type="hidden" name="current_step" value="shipping"  />
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  />
                <div class="col-lg-12 sh_border" >
                   <div><h4>SHIPPING</h4></div>
                   
                  <div class="form-group" style="color:#000"> 
                        <div class="col-lg-4" align="center">
                        <h5><b>Location</b></h5>
                        </div>
                        <div class="col-lg-3" align="center">
                            <h5><b>Shipping cost</b></h5>
                        </div>
                        <div class="col-lg-3" align="center">
                            <h5><b>Next Item cost</b></h5>
                        </div>
                  </div>
                  <div id="location_container">
                      <div class="form-group" > 
                            <div class="col-lg-4" style="color:#000">
                                Continental United States
                            </div>
                            <div class="col-lg-3">
                                <input class="form-control" name="ship_cost1[]" id="ship_cost1" placeholder="0.00" value="<?php echo isset($shipping_rates['CUS']['ship_price']) ? $shipping_rates['CUS']['ship_price'] : ''; ?>" />
                            </div>
                            <div class="col-lg-3"  >
                                <input class="form-control" name="ship_cost2[]" id="ship_cost2" placeholder="0.00"  value="<?php echo isset($shipping_rates['CUS']['next_item_price']) ? $shipping_rates['CUS']['next_item_price'] : ''; ?>"/>
                            </div>
                            <div class="col-lg-2">
                                <a href="javascript:;" onclick="delete_location(this);" ><i class="fa fa-times fa-lg"></i></a>
                                <!--<a href="javascript:;" onclick="addShipping(this);" ><i class="fa fa-plus-circle fa-lg"></i></a>-->
                            </div>
                      </div>
                      <div class="form-group" style="margin-top:10px;"> 
                            <div class="col-lg-4" style="color:#000">
                                  Puerto Rico
                            </div>
                            <div class="col-lg-3">
                                <input class="form-control" name="ship_cost1[]" id="ship_cost1" placeholder="0.00"  value="<?php echo isset($shipping_rates['PUR']['ship_price']) ? $shipping_rates['PUR']['ship_price'] : ''; ?>" />
                            </div>
                            <div class="col-lg-3"  >
                                <input class="form-control" name="ship_cost2[]" id="ship_cost2" placeholder="0.00"  value="<?php echo isset($shipping_rates['PUR']['next_item_price']) ? $shipping_rates['PUR']['next_item_price'] : ''; ?>"/>
                            </div>
                            <div class="col-lg-2">
                                <a href="javascript:;" onclick="delete_location(this);" ><i class="fa fa-times fa-lg"></i></a>
                                <!--<a href="javascript:;" onclick="addShipping(this);" ><i class="fa fa-plus-circle fa-lg"></i> </a>-->
                            </div>
                      </div>
                      <div class="form-group" style="margin-top:10px;" > 
                            <div class="col-lg-4" style="color:#000">Alaska & Hawaii</div>
                            <div class="col-lg-3">
                                <input class="form-control" name="ship_cost1[]" id="ship_cost1" placeholder="0.00" value="<?php echo isset($shipping_rates['AHW']['ship_price']) ? $shipping_rates['AHW']['ship_price'] : ''; ?>" />
                            </div>
                            <div class="col-lg-3"  >
                                <input class="form-control" name="ship_cost2[]" id="ship_cost2" placeholder="0.00"  value="<?php echo isset($shipping_rates['AHW']['next_item_price']) ? $shipping_rates['AHW']['next_item_price'] : ''; ?>" />
                            </div>
                            <div class="col-lg-2">
                                <a href="javascript:;" onclick="delete_location(this);" ><i class="fa fa-times fa-lg"></i></a>
                                <!--<a href="javascript:;" onclick="addShipping( this );" ><i class="fa fa-plus-circle fa-lg"></i> </a>-->
                            </div>
                      </div>
                  </div>
                  
                  <div class="form-group"> 
                    <div class="col-lg-8">
                        <label>Estimated Ship Time, in Business Days</label><br />
                        <p>Number of business days it takes you to ship your product out</p>
                        <div style="width:100px;">
                        <select class="form-control" name="ship_days" id="ship_days">
                            <option value="1" <?php echo $product->ship_days == 1 ? 'selected' : ''; ?> >1</option>
                            <option value="2" <?php echo $product->ship_days == 2 ? 'selected' : ''; ?> >2</option>
                            <option value="3" <?php echo $product->ship_days == 3 ? 'selected' : ''; ?> >3</option>
                            <option value="4" <?php echo $product->ship_days == 4 ? 'selected' : ''; ?>>4</option>
                            <option value="5" <?php echo $product->ship_days == 5 ? 'selected' : ''; ?>>5</option>
                            <option value="6" <?php echo $product->ship_days == 6 ? 'selected' : ''; ?>>6</option>
                            <option value="7" <?php echo $product->ship_days == 7 ? 'selected' : ''; ?>>7</option>
                            <option value="8" <?php echo $product->ship_days == 8 ? 'selected' : ''; ?>>8</option>
                            <option value="9" <?php echo $product->ship_days == 9 ? 'selected' : ''; ?>>9</option>
                            <option value="10" <?php echo $product->ship_days == 10 ? 'selected' : ''; ?>>10</option>
                            <option value="11" <?php echo $product->ship_days == 11 ? 'selected' : ''; ?>>11</option>
                            <option value="12" <?php echo $product->ship_days == 12 ? 'selected' : ''; ?>>12</option>
                            <option value="13" <?php echo $product->ship_days == 13 ? 'selected' : ''; ?>>13</option>
                            <option value="14" <?php echo $product->ship_days == 14 ? 'selected' : ''; ?>>14</option>
                            <option value="15" <?php echo $product->ship_days == 15 ? 'selected' : ''; ?>>15</option>
                        </select>
                        </div>
                     </div>
                   </div>
                  <div class="form-group"> 
                    <div class="col-lg-12">
                        <label>Shipping Price Details</label>
                        <p>If you charge for special packaging or delivery rates, let your customer know. Be transparent about your shipping prices</p>
                        <textarea class="form-control" name="ship_detail" id="ship_detail"><?php echo $product->ship_price_info; ?></textarea>
                     </div>
                   </div>
                  <div class="form-group"> 
                    <div class="col-lg-12">
                        <label>Return Policy</label>
                        <p>If you select "Final Sale", a customer can return a product only if it arrived damaged. If you choose "14 day returns", customer can return any product upto 14 days after it was delivered, as long as it is in sellable condition.</p>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control" name="return_policy" id="return_policy">
                             <option value="Final Sale. No returns" <?php echo $product->return_policy == 'Final Sale. No returns' ? 'selected' : ''; ?> >Final Sale. No returns</option>
                             <option value="14 day returns" <?php echo $product->return_policy == '14 day returns' ? 'selected' : ''; ?> >14 day returns</option>
                             <option value="Holiday returns" <?php echo $product->return_policy == 'Holiday returns' ? 'selected' : ''; ?>>Holiday returns</option>
                        </select>
                     </div>
                   </div>
                  <div class="form-group"> 
                    <div class="col-lg-4">
                        <label>Weight (lbs.)</label>
                        <input class="form-control" name="ship_weight" id="ship_weight" />
                     </div>
                   </div>           
                  <div class="form-group"> 
                    <div class="col-lg-4">
                        <label>Length (in.) <span style="font-size:10px">(optional)</span></label>
                        <input class="form-control" name="ship_length" id="ship_weight" />
                     </div>
                    <div class="col-lg-4">
                        <label>Width (in.) <span style="font-size:10px">(optional)</span></label>
                        <input class="form-control" name="ship_width" id="ship_weight" />
                     </div>
                    <div class="col-lg-4">
                        <label>Height (in.) <span style="font-size:10px">(optional)</span></label>
                        <input class="form-control" name="ship_height" id="ship_weight" />
                     </div>
                   </div>           
                   
                  <div class="form-group" style="padding:20px 0px 0px 0">
                    <div class="col-md-2">
                    <input type="submit" name="btn-variation" class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button"  value="Previous Step"  />
                    </div>
                    <!--<input type="submit" name="btn-info" class="btn btn-info"  value="Next Step"  />-->
                    <div class="col-md-4">
                    <button type="submit" name="submit" class="osky-btn osky-btn-default osky-btn-inline-block" value="save_later" style="float:right;">Save and continue later</button>
                    <!--<input type="submit" name="btn-info" class="btn btn-info"  value="Next Step"  />-->
                  </div>                   
               </div> <!-- sh border -->
            </form>

</div>
</div>
</div>
</div>
</div>
</div>
                            
     
<div class="clearfix"></div>
</div>
					</div>

                    </div>
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

            
            
</div>



<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.ui.totop.js"></script>

<?php $this->load->view('site/templates/footer');?>
