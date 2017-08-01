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
</style>

<div class="container" >
		<div class="steps">
            <nav class="nav-sidebar" >
                <ul class="nav tabs" role="navigation" >
                    <li class=""><span class="step-bubble">Step: 1.</span>Product Info</a></li>
                    <li class=""><span class="step-bubble">Step: 2.</span>Product Media</li>
                    <li class=""><span class="step-bubble" >Step: 3.</span>Price and Variation</li> 
                    <li class=""><span class="step-bubble">Step: 4.</span>Product Shipping</li> 
                    <li class="active"><span class="step-bubble">Step: 5.</span>Finalize</li> 
                </ul>
            </nav>
		</div>

    <form class="form-horizontal" method="post" action="" name="product_review" >
	<div class="row">
    <div class="col-md-8 col-xs-12" >

        	<input type="hidden" name="current_step" value="final"  />
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  />
               <?php if(  $this->session->userdata('draft_product_message') != '' ) { ?>
                   <div style="background-color:#F00; color:#FFF;" align="center"><b>
                        <?php 
							echo $this->session->userdata('draft_product_message');
							$this->session->unset_userdata('draft_product_message');
						 ?></b>
                   </div>
               <?php } ?>
               
              <div style="margin-bottom:10px;"><h3>Review Product</h3></div>
              <div><h4>1. Product Info&nbsp; <a href="<?php echo $step_url; ?>?step=info"><i class="fa fa-edit"></i> Edit</a></h4></div>
              <h6 style="margin-top:10px;">Product name</h6>
              <p><?php echo $product_info['product_name']; ?></p>
              <p><?php echo $product_info['cat_name']; ?></p>
              <h6 style="margin-top:10px;">Product sort</h6>
              <p><?php echo $product_info['product_sort']; ?></p>
              <h6 style="margin-top:10px;">Product description</h6>
              <p><?php echo $product_info['description']; ?></p>
              <h6 style="margin-top:10px;">ShopsAtAvenue exclusive?</h6>
              <p><?php echo $product_info['sold_exclusive'] ? 'Yes' : 'No'; ?></p>
              <!--<h6>Meta description</h6>
              <p><?php //echo $product_info['meta_description']; ?></p>-->
              <h6 style="margin-top:10px;">Meta keywords</h6>
              <p><?php echo $product_info['meta_keyword']; ?></p>
              <h6 style="margin-top:10px;">Shopify Product URL</h6>
              <p><?php echo ( $product_info['shopify_url'] != '' )? $product_info['shopify_url'] : 'N/A'; ?></p>
              <br />
              <h5>2. Images and Video&nbsp;<a href="<?php echo $step_url; ?>?step=media"><i class="fa fa-edit"></i> Edit</a></h5>
                    <div id="image_container" class="col-lg-12"  style="margin-top:10px;">

					<?php
                      if( $images != '' ) {
                          $imagesArr = explode( "|", $images );
                          foreach( $imagesArr as $key => $val ) {
                    ?>
                        <div class="col-lg-2">
                            <img class="upload-img1" src="/images/product/temp_img/<?php echo $val;?>" id="loadedImg" width="90px" height="71px" > </img>
                        </div>

					<?php      
                        }
                      }
                    ?>
                    <?php if( $video_url != '' ) {  ?>
                        <div class="col-lg-2">
                        <?php if( strpos($video_url, "youtube" ) !== false ) { ?>
						 <iframe width="90" height="71" src="<?php echo $video_url; ?>">
						</iframe>
                        <?php } else { ?>
                        <video width="320" height="240" controls src="<?php echo $video_url; ?>">
                          Your browser does not support the video tag.
                        </video>         
                        <?php } ?>           
                        </div>
                    <?php } ?>
					</div>
              <h5 style="padding-top: 20px;">3. Price and Variation&nbsp;&nbsp;<a href="<?php echo $step_url; ?>?step=variation"><i class="fa fa-edit"></i> Edit</a></h5>

                <?php if( $variation['variable_product'] ) { ?>
<div id="variation_list_box" style="display:<?php echo ($variation['variable_product'] == 1 ? 'block' : 'none'); ?>;">
   <div class="variation_table" >
       <div class="col col-md-12" style="background-color:rgba(64, 169, 182, 0.64); color:#FFF">
            <div class="col-md-2">Image</div>
            <div class="col-md-2">Variation</div>
            <div class="col-md-2" align="center">SKU<br />Part#</div>
            <div class="col-md-2" align="center">Qty</div>
            <div class="col-md-2" align="center">Price<br />MSRP</div>
            <div class="col-md-2" align="center">UPC</div>
        </div>
    </div>
    <div class="row" style="border-bottom:none">
        <div class="col-md-12 var_error">
        </div>
    </div>
  <div id="variant_data" >
<?php  
	$row_count =1;
	foreach( $var_data as $key => $val ) { ?>
	<div class="row">
    <?php 
	  if ( $val['sku'] == '' ) {
		   $val['sku'] = $variation['sku']."-".$row_count;
	  }
	  $images = explode("|", $variation['image']);
	?>
            <div class="col-md-2">
                <img width="100" src="/images/product/temp_img/<?php echo $images[0]; ?>" title="product image"  />
            </div>
            <div class="col-md-2" style="color:#000">
				<?php echo str_replace("|","<br>", $val['product_variant_name1']); ?>
                <input type="hidden" name="variant_id[]" value="<?php echo $val['product_variant_id']; ?>"  />
            </div>
            <div class="col-md-2" align="center" >
            <input  name="var_sku[]" placeholder="SKU" value="<?php echo $val['sku']; ?>" readonly />
            <input  name="var_mpn[]" placeholder="Part number" value="<?php echo $val['part_number']; ?>" <?php echo ($variation['variable_mpn'] == 0 ? 'readonly' : ''); ?> style="display:<?php echo ($variation['variable_mpn'] == 0 ? 'none' : 'block'); ?>" />
            </div>
            <div class="col-md-2" >
            	<input  placeholder="quantity" name="var_qty[]" value="<?php echo $val['quantity']; ?>" style="width:80px;float:right;"  />
            </div>
            <div class="col-md-2">
            <input  name="var_price[]" placeholder="Price" value="<?php echo $val['price']; ?>" <?php echo ($variation['variable_price'] == 0 ? 'readonly' : ''); ?> style="display:<?php echo ($variation['variable_price'] == 0 ? 'none' : 'block'); ?>" />
            <input  name="var_msrp[]" placeholder="Max. Retail Price" value="<?php echo $val['msrp']; ?>" <?php echo ($variation['variable_msrp'] == 0 ? 'readonly' : ''); ?> style="display:<?php echo ($variation['variable_msrp'] == 0 ? 'none' : 'block'); ?>" />
            </div>
            <div class="col-md-2">
            <input  name="var_upc[]" placeholder="UPC Code" value="<?php echo $val['upc']; ?>" style="width:80px;float:right;display:<?php echo ($variation['variable_upc'] == 0 ? 'none' : 'block'); ?>"  <?php echo ($variation['variable_upc'] == 0 ? 'readonly' : ''); ?>  />
            </div>
    </div> <!-- row -->
<?php $row_count++; } ?>
   </div> <!-- table -->
</div>
   
				<?php } else { ?>
				<h6 style="margin-top:10px;">Retail price</h6>
					<?php echo number_format($variation['msrp'],2); ?>
				<h6 style="margin-top:10px;">OpenSky price</h6>
					<?php echo number_format($variation['price'],2); ?>
				<h6 style="margin-top:10px;">Inventory</h6>
					<?php echo $variation['quantity']; ?>
				<h6 style="margin-top:10px;">SKU</h6>
					<?php echo $variation['sku']; ?>
				<h6 style="margin-top:10px;">UPC</h6>
					<?php echo ($variation['upc'] != '') ? $variation['upc'] : 'N/A'; ?>
				<h6 style="margin-top:10px;">MPN</h6>
					<?php echo ($variation['part_number'] != '') ? $variation['part_number'] : 'N/A'; ?>

                <?php } ?>
			  <br />
              <br />
              <h5>4. Shipping&nbsp;&nbsp;<a href="<?php echo $step_url; ?>?step=shipping"><i class="fa fa-edit"></i> Edit</a></h5>
              <?php if( $shipping['rates'] ) { ?>
                    <table border="1" cellpadding="0" cellspacing="0" width="70%" style="margin-top:10px;">
                    <tr>
                    <td>Location</td>
                    <td>Price</td>
                    <td>Next item price</td>
                    </tr>
                    <tr>
                    <?php foreach ( $shipping['rates'] as $key => $val ) { ?>
                    	<td>
							<?php if( $key == 'CUS' ) echo 'Contintental United States'; ?>
							<?php if( $key == 'PUR' ) echo 'Puerto Rico'; ?>
							<?php if( $key == 'AHW' ) echo 'Alaska & Hawaii'; ?>
                        </td>
                        <td><?php echo $val['ship_price'];?></td>
                        <td><?php echo ($val['next_item_price'] == '0.000') ? 'N/A' : $val['next_item_price']; ?></td>
                    <?php } ?>
                    </tr>
                    </table>
              <?php } ?>
              <h6 style="margin-top:10px;">Estimated Ship Time, in Business Days</h6>
              <?php echo $shipping['info_fields']['ship_days']; ?>
              <h6 style="margin-top:10px;">Shipping Price Details</h6>
              <?php echo ($shipping['info_fields']['ship_price_info'] != '') ? $shipping['info_fields']['ship_price_info'] : 'N/A'; ?>
              <h6 style="margin-top:10px;">Return Policy</h6>
              <?php echo $shipping['info_fields']['return_policy']; ?>
              <h6 style="margin-top:10px;">Weight (lbs.)</h6>
              <?php echo $shipping['info_fields']['weight']; ?>
              <h6 style="margin-top:10px;">Length (In.)</h6>
              <?php echo ($shipping['info_fields']['ship_length'] != '0.0000') ? $shipping['info_fields']['ship_length'] : 'N/A'; ?>
              <h6 style="margin-top:10px;">Width (In.)</h6>
              <?php echo ($shipping['info_fields']['ship_width'] != '0.0000') ? $shipping['info_fields']['ship_width'] : 'N/A'; ?>
              <h6 style="margin-top:10px;">Height (In.)</h6>
              <?php echo ($shipping['info_fields']['ship_height'] != '0.0000') ? $shipping['info_fields']['ship_height'] : 'N/A'; ?>
        
    </div>
	
    </div>
    
   <div class="row" >
      	<div class="col-md-2"><input type="submit" name="submit" class="button1"  value="Publish" ></div>
        <div class="col-md-4 col-md-push-4">
        <button type="submit" name="submit" class="button1" value="save_later" style="float:right;">Save and continue later</button>
        </div>
   </div>
  </form>
                
</div>
<?php $this->load->view('site/templates/footer');?>
