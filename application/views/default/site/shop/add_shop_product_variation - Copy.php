<?php 
$this->load->view('site/templates/commonheader');
$this->load->view('site/templates/shop_header'); 
$shopEditArr = array('admin-edit-product','admin-preview'); $shopAddArr = array('admin-listitem','admin-preview');
$showShopHeadList = 0;
if(in_array($this->uri->segment(1),$shopEditArr)){
	$showShopHeadList = 1;
}elseif(in_array($this->uri->segment(2),$shopAddArr)){ 
   $showShopHeadList = 1;
} 
?>
<script type="text/javascript" src="3rdparty/bootstrap-3.3.6/bootstrap-validator/validator.min.js"></script>
<script type="text/javascript" src="3rdparty/color-picker/colors.js"></script>
<script type="text/javascript" src="3rdparty/color-picker/jqColorPicker.min.js"></script>
<script type="text/javascript" src="3rdparty/color-picker/jqColorPickerSetup.js" ></script>

<script type="text/javascript">
	
	jQuery( document ).ready(function() {
            /*var canvas = $("#myCanvas").get(0);
            var ctx = canvas.getContext("2d");

            var image = new Image();
            image.src = "images/product/1446788563-1311330438524.jpg";
            $(image).load(function() {
                ctx.drawImage(image, 0, 0);
            });

            $(canvas).click(function(e) {
                var canvasOffset = $(canvas).offset();
                var canvasX = Math.floor(e.pageX-canvasOffset.left);
                var canvasY = Math.floor(e.pageY-canvasOffset.top);

                var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                var pixels = imageData.data;
                var pixelRedIndex = ((canvasY - 1) * (imageData.width * 4)) + ((canvasX - 1) * 4);
                var pixelcolor = "rgba("+pixels[pixelRedIndex]+", "+pixels[pixelRedIndex+1]+", "+pixels[pixelRedIndex+2]+", "+pixels[pixelRedIndex+3]+")";
                //$("body").css("backgroundColor", pixelcolor);
            });*/
		
			$('select[name=var_type]').change( function() {
				if ( this.value == 'color_swatch' ) {
					$('#var_name').val('Color');
				}
				if ( this.value == 'size_list' ) {
					$('#var_name').val('Size');
				}
				$( 'select[name=var_type]' ).closest('.row').find('div span').remove();
			});
		
	});

	function showVariation() {
		
		if ( $('#variation_flag').prop( 'checked' ) ) {
			$('#variation_box').show();
		} else {
			$('#variation_box').hide();
		}
	}
	function addVariation() {
		$( 'select[name=var_type]' ).closest('.row').find('div span').remove();
		var isValid = true;
		var msg = '';
		$('#var_error').html( '' );
		
		if ( $('select[name=var_type]').val() == '' ) {
			//$('select[name=var_type]').closest('div').append( '<span style="color:red">select variation type</span>' );
			msg += '<p>select variation type</p>';
			isValid = false;
		} 
		if( $('#var_name').val() == '' ) {
			//$('#var_name').closest('div').append( '<span style="color:red">enter variation name</span>' )
			msg += '<p>enter variation name</p>';
			isValid = false;
		}

		for( var i=1; i <= $('#var_row > .row').length; i++ ) {
			if (  $('#var_row > .row:nth-child('+ i + ') div:nth-child(2)').text() == $('#var_name').val() ){
				msg += '<p>Variation name is already used!. please change!</p>';
				isValid = false;
			}
		}
		
		if( ! isValid ) {
			$('#var_error').html( msg );
			return false;
		}
		
		var var_text = '<div class="row"><div class="col-lg-2"></div><div class="col-lg-2"></div><div class="col-lg-6 color_val"></div><div class="col-lg-2" style="float:right"><a href="javascript:;"><i class="fa fa-minus"></i>&nbsp;Remove</a></div></div>';

		var var_color = '<div id="var_color" style="width: 140px;"><div id="color_val" class="color" style="width: 18px; height: 18px; background-color: rgb(85, 107, 47); margin-top: 3px; float: left;"></div><input style="height: 18px; border: medium none; font-size: 12px; padding: 1px; clear: both; margin-top: -4px; width: 100px;" name="var_value" id="var_value" type="text" placeholder="color"><a href="javascript:;" onclick="removeColorVariation(this);"><i class="fa fa-times"></i></a></div><a href="javascript:;" onclick="addColorVariation(this);"><span style="float: left; margin-left: 150px; margin-top: -18px;" class="fa fa-plus-circle"></span></a>';
		var var_type = '';
		if( $('select[name=var_type]').val() == 'color_swatch' ) var_type = 'Color Swatch';
		if( $('select[name=var_type]').val() == 'size_list' ) var_type = 'Size';
		if( $('select[name=var_type]').val() == 'custom_list' ) var_type = 'Custom dropdown';
		

		$('#var_row').append( var_text );
		$('#var_row > .row:last-child div:nth-child(1)').text( var_type );
		$('#var_row > .row:last-child div:nth-child(2)').text( $('#var_name').val() );
		//$('#var_row > .row:last-child div:nth-child(3)').html( '<div id="var_color" class="color" style="width: 18px; height: 18px; background-color: rgb(85, 107, 47); margin-top: 3px;"></div><input style="height: 18px; border: medium none; font-size: 12px; padding: 1px; margin-top: -10px; margin-left: 20px;" name="var_value" type="text"><img style="float: right;" src="/images/list-icons/plus.png">' );
		if( $('select[name=var_type]').val() == 'color_swatch' ) {
			$('#var_row > .row:last-child div:nth-child(3)').html( var_color );
		} 
		
		$('#var_name').val('');
		$('select[name=var_type]').val('');

	}
	function addColorVariation( obj ) {
		var var_color = '<div id="var_color" style="width: 140px;"><div id="color_val" class="color" style="width: 18px; height: 18px; background-color: rgb(85, 107, 47); margin-top: 3px; float: left;"></div><input style="height: 18px; border: medium none; font-size: 12px; padding: 1px; clear: both; margin-top: -4px; width: 100px;" name="var_value" id="var_value" type="text" placeholder="color"><a href="javascript:;" onclick="removeColorVariation(this);"><i class="fa fa-times"></i></a></div>';

		$( obj ).closest( '.color_val' ).append( var_color );
	}
	function removeColorVariation( obj ) {
		var colorObj = $( obj ).closest( '.col-lg-5' );
		if( $( colorObj ).find( ' > #var_color' ).length >  1) {
			$( obj ).closest('#var_color' ).remove();
		}
	}
	function updateVariation() {
		if (  $('#var_row > .row').length == 0 ) {
			$('#var_error').html( '<p>Variations are not found!</p>'  );
			return false;
		}
			var i = 1, j=1;
		if( $('#var_row > .row:nth-child(' + i + ') div:nth-child(' + j + ') ').text() == "Color Swatch" ) {
			for( i=1; i <= $('#var_row  #var_color > :input').length; i++ ) {
				alert( $('#var_row  #var_color:nth-child(' + i + ') > :input').val() );
			}
		}
		//} else {
		//	$('#var_error').html( '<p>Variations values are not found!</p>'  );
		//	return false;
		//}
		return false;
	}
</script>

<style>
#When_is{margin:0px !important;}
</style>

<style>
#progressDiv { margin-left: 20px; }

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
#variation_box {
	color:#000;
	text-transform:capitalize;
	font-size:small;
	font-weight:bold;
}
#variation_box  .row {
	margin-left:5px;
}
#var_row  {
	margin-left: 5px;
	width:100%;
}
#var_row .row {
	border-bottom: 1px solid rgba(64, 169, 182, 0.64);
	width: 99.9%;
	margin-left: -5px;
}
#var_error {
	font-size:12px;
	font-weight:bold;
	color:#FF5F00;
	text-transform:none;
}
</style>


<?php if(isset($active_theme) &&  $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>Shop-page.css" rel="stylesheet">
<?php } ?>


<div class="list_inner_fields" id="shop_page_seller">   


	<div class="sh_content">
       <div style="margin: 0 0 0 20px">
    	<p><a href="#"><i class="fa fa-arrow-circle-o-right"></i>&nbsp;Back to listing</a></p>
		<h3><?php echo $variation['product_name']; ?> (Draft)</h3>	
       </div>
    <div id="progressDiv" class="col-lg-2 sh_border">
       <p style="color:#000"><b>Product Setup Steps:</b></p>
       <div><a href="<?php echo $step_url; ?>?step=info"><span>1</span>Product Info</a></div>
       <div><a href="<?php echo $step_url; ?>?step=media"><span>2</span>Product Media</a></div>
       <div class="current"><a href="<?php echo $step_url; ?>?step=variation"><span>3</span>Price and Variation</a></div>
       <div><a href="<?php echo $step_url; ?>?step=shipping"><span>4</span>Product Shipping</a></div>
       <div><a href="<?php echo $step_url; ?>?step=final"><span>5</span>Finalize</a></div>
    </div>
    
    <div class="col-lg-8" >
    
        <!--<form class="form-horizontal" method="post" action="" name="frm_product_variation" data-toggle="validator" role="form" >-->
        <form  method="post" action="" name="frm_product_variation" data-toggle="validator" role="form" >
        	<input type="hidden" name="current_step" value="variation"  />
        	<input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  >
            <div class="col-lg-12 sh_border" >
               <div><h4>PRODUCT PRICE and VARIATION</h4></div>

               <div class="form-group" >
                  <div class="row" >
                   <div class="col-lg-4">
                   <label for="product_msrp">Retail Price ( MSRP )</label>
                   <input  class="form-control" type="text" maxlength="20"  name="product_msrp" id="product_msrp" value="<?php echo $variation['msrp']; ?>"  />
                   </div>
                   <div class="col-lg-4" >
                   <label for="product_price">Price on ShopsAtAvenue</label>
                   <input  class="form-control" type="text" maxlength="20"  name="product_price" id="product_price" value="<?php echo $variation['price']; ?>"  >
                   <div style="color:#900"><?php if( isset( $error['product_price'] ) ) echo $error['product_price'];  ?></div>
                   </div>
                   <div class="col-lg-4">
               			<label for="stock_qty">Inventory</label>
            			<input  class="form-control" type="number" maxlength="20" name="stock_qty" id="stock_qty"  value="<?php echo $variation['quantity']; ?>" required   >
               		</div>
                    <div style="color:#900"><?php if( isset( $error['stock_qty'] ) ) echo $error['stock_qty'];  ?></div>
				   </div> <!-- row -->
                   <div class="row">
                        <div class="col-lg-4">
                            <label for="product_sku">SKU</label>
                            <input  class="form-control" type="text" maxlength="20"  name="product_sku" id="product_sku" readonly="readonly" required  value="<?php echo $variation['sku']; ?>" />
                        </div>
                        <div class="col-lg-4">
                            <label for="product_upc">UPC <span style="font-size:10px">( optional )</span></label>
                            <input  class="form-control" type="text" maxlength="14"  name="product_upc" id="product_upc"  value="<?php echo $variation['upc']; ?>"   />
                        </div>
                        <div class="col-lg-4">
                            <label for="product_mpn">Manufact. Part Number <span style="font-size:10px">( optional )</span></label>
                        </div>
                       <div class="col-lg-4">
                            <input  class="form-control" type="text" maxlength="14"  name="product_mpn" id="product_mpn" value="<?php echo $variation['part_number']; ?>"   />
                        </div>
                   </div> <!-- row -->
               </div>

              <div class="form-group">           
                <h5></h5>
                <p style="color:#F00; font-size:16px;">This product has variations (Size, Color, etc.) <span style="font-size:10px">( optional )</span>
                <input type="checkbox" name="variation_flag" id="variation_flag" value="1" onchange="showVariation();"  ></p>
              </div>
                  <!--<canvas id="myCanvas" width="100" height="100">
        Your user agent does not support the HTML5 Canvas element.
    </canvas>-->
    		  <div id="variation_box" style="display:none;">
                    <div class="row">
                        <div class="col-lg-3">
                            <select name="var_type" >
                                <option value="" >Select type</option>
                                <option value="color_swatch">Color swatch</option>
                                <option value="size_list">Size</option>
                                <option value="custom_list">Custom dropdown</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <input type="text" name="var_name" id="var_name" value=""  />
                        </div>
                        <div class="col-lg-5"><a href="javascript:;" onclick="addVariation();" style="font-size:16px;"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;Add Variation</a></div>
                    </div>
                    <div class="row">
                    	<div id="var_error" class="col-lg-12">
                        </div>
                    </div>
                   <div style="border:1px rgba(64, 169, 182, 0.64) solid;border-bottom-style: none; height:auto; min-height:25px;">
                       <div class="col col-lg-12" style="background-color:rgba(64, 169, 182, 0.64); color:#FFF">
                            <div class="col-lg-2">Variation Type</div>
                            <div class="col-lg-2">variation name</div>
                            <div class="col-lg-3">Values</div>
                            <div class="col-lg-1">Need SKU</div>
                            <div class="col-lg-1">Need UPC</div>
                            <div class="col-lg-1">Need Price</div>
                            <div class="col-lg-1">Need MSRP</div>
                            <div class="col-lg-1">Need Part#</div>
                        </div>
                    <div class="col col-lg-12" style="background-color:rgba(64, 169, 182, 0.64); color:#FFF;"  align="center">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-2"></div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-1"><input type="checkbox" name="need_sku" ></div>
                        <div class="col-lg-1"><input type="checkbox" name="need_upc" ></div>
                        <div class="col-lg-1"><input type="checkbox" name="need_price" ></div>
                        <div class="col-lg-1"><input type="checkbox" name="need_msrp" ></div>
                        <div class="col-lg-1"><input type="checkbox" name="need_mpn" ></div>
                    </div>
                       <div id="var_row">
                       </div>
                   </div>
                  <div class="form-group">
                      <button  class="btn btn-primary" onclick="return updateVariation();">Update Variation</button>
                  </div>

              </div>
              
              
              <div class="form-group" style="padding:10px 0px 0px 0">
                <input type="submit" name="submit" class="btn-primary"  value="Previous Step"  />
                <input type="submit" name="submit" class="btn-primary"  value="Next Step"  />
                <button class="btn-primary" style="float:right;">Save and continue later</button>
              </div>                   
           </div> <!-- sh border -->
        </form>
        
    </div>

<?php $this->load->view('site/templates/footer');?>
