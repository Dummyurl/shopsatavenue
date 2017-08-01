<?php 
$this->load->view('site/templates/commonheader');
$this->load->view('site/templates/shop_header'); 
?>
<script type="text/javascript" src="3rdparty/bootstrap-3.3.6/bootstrap-validator/validator.min.js"></script>
<script type="text/javascript" src="3rdparty/color-picker/colors.js"></script>
<script type="text/javascript" src="3rdparty/color-picker/jqColorPicker.min.js"></script>
<script type="text/javascript" src="3rdparty/color-picker/jqColorPickerSetup.js" ></script>
<script type="text/javascript" src="3rdparty/sweet-alert/sweet-alert.js"></script>
<link rel="stylesheet" href="3rdparty/sweet-alert/sweet-alert.css">

<script type="text/javascript">
	
	jQuery( document ).ready(function() {
		
			$('select[name=var_type]').change( function() {
				if ( this.value == 'color_swatch' ) {
					$('#var_name').val('Color');
				}
				if ( this.value == 'size_list' ) {
					$('#var_name').val('Size');
				}
				$( 'select[name=var_type]' ).closest('.row').find('div span').remove();
			});

			$('input[name=need_upc]').change( function() {
				if( this.checked ) {
					$('input[name=var_upc\\[\\]]').attr('readonly', false); 
					$('input[name=var_upc\\[\\]]').show(); 
				} else {
					$('input[name=var_upc\\[\\]]').attr('readonly', true); 
					$('input[name=var_upc\\[\\]]').hide(); 
				}
			});
			$('input[name=need_price]').change( function() {
				if( this.checked ) {
					$('input[name=var_price\\[\\]]').attr('readonly', false); 
					$('input[name=var_price\\[\\]]').show(); 
					$('input[name=var_price\\[\\]]').val( $('input[name=product_price]').val() );
				} else {
					$('input[name=var_price\\[\\]]').attr('readonly', true); 
					$('input[name=var_price\\[\\]]').hide(); 
				}
			});
			$('input[name=need_msrp]').change( function() {
				if( this.checked ) {
					$('input[name=var_msrp\\[\\]]').attr('readonly', false); 
					$('input[name=var_msrp\\[\\]]').show(); 
				} else {
					$('input[name=var_msrp\\[\\]]').attr('readonly', true); 
					$('input[name=var_msrp\\[\\]]').hide(); 
				}
			});
			$('input[name=need_mpn]').change( function() {
				if( this.checked ) {
					$('input[name=var_mpn\\[\\]]').attr('readonly', false); 
					$('input[name=var_mpn\\[\\]]').show(); 
				} else {
					$('input[name=var_mpn\\[\\]]').attr('readonly', true); 
					$('input[name=var_mpn\\[\\]]').hide(); 
				}
			});
		
	});

	function showVariation() {
		
		if ( $('#variation_flag').prop( 'checked' ) ) {
			$('#variation_box').show();
			$('button[name=UpdateVariation]').closest('.form-group').show()
		} else {
			$('#variation_box').hide();
			$('button[name=UpdateVariation]').closest('.form-group').hide()
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
			if (  $('#var_row > .row:nth-child('+ i + ') div:nth-child(2)').text().toUpperCase() == $('#var_name').val().toUpperCase() ){
				msg += '<p>Variation name is already used!. please change!</p>';
				isValid = false;
			}
		}
		
		if( ! isValid ) {
			$('#var_error').html( msg );
			return false;
		}
		
		var var_text = '<div class="row"><div class="col-lg-2"></div><div class="col-lg-2"></div><div class="col-lg-6 color_val"></div><div class="col-lg-2" style="float:right"><a href="javascript:;" onclick="removeVariation(this);"><i class="fa fa-minus"></i>&nbsp;Remove</a></div></div>';

		var var_type = '';
		var var_id = 0;
		if( $('select[name=var_type]').val() == 'color_swatch' ) {
			var_type = 'Color';
			var_id = 1;
		}
		if( $('select[name=var_type]').val() == 'size_list' ) {
			var_type = 'Size';
			var_id = 2;
		}
		if( $('select[name=var_type]').val() == 'custom_list' ) {
			var_type = 'Custom';
			var_id = 3;
		}
		

		$('#var_row').append( var_text );
		var row_count = $('#var_row > .row').length;
		var variation_type_html, variation_name_html, var_name;
		variation_type_html = var_type + '<input type="hidden" name="var_option_id_' + row_count.toString() + '"  value="" >';
		variation_type_html += '<input type="hidden" name="' +  'var_' + row_count.toString() + '" value="' + var_id + '" readonly >';
		var_name = $('#var_name').val();
		 
		variation_name_html = '<span id="opt_name">' + var_name + '</span>' + '<input type="hidden" name="' +  'var_' + row_count.toString() + '_name' ;
		variation_name_html += '" value="' + var_name + '" >';
		
		$('#var_row > .row:last-child div:nth-child(1)').html( variation_type_html );
		$('#var_row > .row:last-child div:nth-child(2)').html( variation_name_html );

		if( var_id == 1 ) {
		
			var var_color_html = '<div id="color_line" style="width: 140px;"><div class="color" style="width: 18px; height: 18px; background-color: rgb(85, 107, 47); margin-top: 3px; float: left;"><input type="hidden" value="" name="color_code[]" ></div>';
			var_color_html += '<input style="height: 18px; border: medium none; font-size: 12px; padding: 1px; clear: both; margin-top: -4px; width: 100px;" name="' + var_name + '[]" type="text" placeholder="color"><a href="javascript:;" onclick="removeColorVariation(this);" title="Remove color"><i class="fa fa-times"></i></a><a href="javascript:;" onclick="addVariationValue(this);" title="Add color"><span style="float: left; margin-left: 150px; margin-top: -18px;" class="fa fa-plus-circle"></span></a></div>';

			$('#var_row > .row:last-child div:nth-child(3)').html( var_color_html );
		} 

		if( var_id == 2 ) {
			var var_size_html = '<div id="size_line" style="width: 140px;"><input style="font-size: 12px;width:100px;padding:0 0;" name="';
			var_size_html += var_name + '[]" type="text" placeholder="size"><a href="javascript:;" onclick="removeVariationValue(this);" title="Remove size"><i class="fa fa-times"></i></a><a href="javascript:;" onclick="addVariationValue(this, \'size\');" title="Add size"><span style="float: left;margin-left: 120px; margin-top: -18px;" class="fa fa-plus-circle"></span></span></a></div>';
			$('#var_row > .row:last-child div:nth-child(3)').html( var_size_html );
		} 
		if( var_id == 3 ) {
			var var_line_html = '<div id="var_line" style="width: 140px;"><input style="font-size: 12px;width:100px;padding: 0 0;" name="';
			var_line_html += var_name + '[]" type="text" placeholder="Option Value"><a href="javascript:;" onclick="removeVariationValue(this);" title="Remove Value"><i class="fa fa-times"></i></a><a href="javascript:;" onclick="addVariationValue(this, \'other\');" title="Add Value"><span style="float: left;margin-left: 120px; margin-top: -18px;" class="fa fa-plus-circle"></span></span></a></div>';

			$('#var_row > .row:last-child div:nth-child(3)').html( var_line_html );
		}
		
		$('input[name=total_options]').val( row_count );
		
		//clear values
		$('#var_name').val('');
		$('select[name=var_type]').val('');

	}
	function addVariationValue( obj ) {
		var var_name = $( obj ).closest( '.row' ).find(' div:nth-child(2) #opt_name ').text() ;
		var var_id = $( obj ).closest( '.row' ).find(' div:nth-child(1) ').find( 'input:last-child' ).val() ;

		var var_value_html = '';

		if( var_id == 1 ) {
			var_value_html = '<div id="color_line" style="width: 140px;"><div class="color" style="width: 18px; height: 18px; background-color: rgb(85, 107, 47); margin-top: 3px; float: left;"><input type="hidden" value="" name="color_code[]" ></div>';
			var_value_html += '<input style="height: 18px; border: medium none; font-size: 12px; padding: 1px; clear: both; margin-top: -4px; width: 100px;" name="' + var_name + '[]" type="text" placeholder="color"><a href="javascript:;" onclick="removeColorVariation(this);" title="Remove color"><i class="fa fa-times"></i></a><a href="javascript:;" onclick="addVariationValue(this);" title="Add color"><span style="float: left; margin-left: 150px; margin-top: -18px;" class="fa fa-plus-circle"></span></a></div>';
		} 

		if( var_id == 2 ) {
			var_value_html = '<div id="size_line" style="width: 140px;"><input style="font-size: 12px;width:100px;padding:0 0;" name="';
			var_value_html += var_name + '[]" type="text" placeholder="size"><a href="javascript:;" onclick="removeVariationValue(this);" title="Remove size"><i class="fa fa-times"></i></a><a href="javascript:;" onclick="addVariationValue(this, \'size\');" title="Add size"><span style="float: left;margin-left: 120px; margin-top: -18px;" class="fa fa-plus-circle"></span></span></a></div>';
		} 
		if( var_id == 3 ) {
			var_value_html = '<div id="var_line" style="width: 140px;"><input style="font-size: 12px;width:100px;padding:0 0;" name="';
			var_value_html += var_name + '[]" type="text" placeholder="Option Value"><a href="javascript:;" onclick="removeVariationValue(this);" title="Remove Value"><i class="fa fa-times"></i></a><a href="javascript:;" onclick="addVariationValue(this, \'other\');" title="Add Value"><span style="float: left;margin-left: 120px; margin-top: -18px;" class="fa fa-plus-circle"></span></span></a></div>';

		}
		
		$( obj ).closest( '.color_val' ).append( var_value_html );
	}
	
	function removeColorVariation( obj ) {

		var colorObj = $( obj ).closest( '.color_val' );
		if( $( colorObj ).find( ' > #color_line').length >  1 ) {
			$( obj ).closest('#color_line').remove();
		}
		
	}
	
	function removeVariationValue( obj ) {
	
		var colorObj = $( obj ).closest( '.color_val' );
		if( $( colorObj ).find( ' > #var_line').length >  1 ) {
			$( obj ).closest('#size_line').remove();
		}
		
	}
	
	function removeVariation( obj ) {

		swal({
		  title: "Are you sure?",
		  text: "This product option will be deleted!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it!",
		  cancelButtonText: "cancel!",
		  closeOnConfirm: true,
		  closeOnCancel: true
		},
		function(isConfirm) {
		  if (isConfirm) {
			$( obj ).closest('.row').remove();
			swal("", "Product option deleted", "error");
		  } else {
		  }
		});		
	}
	
	function updateVariation() {
		if (  $('#var_row > .row').length == 0 ) {
			$('#var_error').html( '<p>Variations are not found!</p>'  );
			return false;
		}
		
		var no_of_variations = $('#var_row > .row').length;
		var row_count = 1;
		for( row_count=1; row_count <= no_of_variations; row_count++ ) {
			var var_name = $('#var_row > .row:nth-child(' + row_count + ') div:nth-child(2) #opt_name').text();
			for( var i=0; i < $('#var_row > .row:nth-child(' + row_count + ') div:nth-child(3) input[name=' + var_name +'\\[\\]]').length; i++ ) {
				var row_obj = $('#var_row > .row:nth-child(' + row_count + ') div:nth-child(3) input[name=' + var_name +'\\[\\]]')[i];
				if( $( row_obj ).val() == '' ) {
					$('#var_error').html( '<p>Enter valid value!</p>'  );
					$( row_obj ).focus();
					return false;
				}
			}
		}
		//$('#frm_product_variation').submit();
		return true;
	}
	function validate() {
		if ( $("#variation_flag").attr('checked') ) {
			for( i=1; i <= $('#variant_data .row').length; i++ ) {
				if( parseInt( $('#variant_data .row:nth-child(' + i +') div:nth-child(4) input').val() ) == 0 ) {
					alert('Enter valid quantity!');
					$('#variant_data .row:nth-child(' + i +') div:nth-child(4) input').focus();
					return false;
				}
			}
		}
		return true;
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
/*#variation_box {
	color:#000;
	font-size:small;
	font-weight:bold;
}*/
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
.var_error {
	font-size:12px;
	font-weight:bold;
	color:#FF5F00;
	text-transform:none;
}
.variation_table {
	border:1px rgba(64, 169, 182, 0.64) solid;border-bottom-style: none; height:auto; min-height:120px;
	color:#000;
	/*text-transform:capitalize;*/
	font-size:small;
	font-weight:bold;
}
#variation_list_box  .row {
	border-bottom: 1px solid rgba(64, 169, 182, 0.64);
	width: 99.9%;
	margin-left: -5px;
	color:#000;
}
.var_col { width:100px; margin-top:5px; }
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
        <form  method="post" action="" name="frm_product_variation" id="frm_product_variation" onsubmit="return validate();"  >
        	<input type="hidden" name="current_step" value="variation"  />
        	<input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  >
            <input type="hidden" name="total_options" value="<?php echo count($variation['product_options']); ?>"  />
            <div class="col-lg-12 sh_border" >
               <div><h4>PRODUCT PRICE and VARIATION</h4></div>

               <div class="form-group" >
                  <div class="row" >
                   <div class="col-lg-4">
                   <label for="product_msrp">Retail Price ( MSRP )</label>
                   <input  class="form-control" type="text" maxlength="20"  name="product_msrp" id="product_msrp" value="<?php echo number_format($product->msrp,2); ?>"  />
                   </div>
                   <div class="col-lg-4" >
                   <label for="product_price">Price on Shops@Avenue</label>
                   <input  class="form-control" type="text" maxlength="20"  name="product_price" id="product_price" value="<?php echo number_format($product->price,2); ?>"  >
                   <div style="color:#900"><?php if( isset( $error['product_price'] ) ) echo $error['product_price'];  ?></div>
                   </div>
                   <div class="col-lg-4">
               			<label for="stock_qty">Inventory</label>
            			<input  class="form-control" type="number" maxlength="20" name="stock_qty" id="stock_qty"  value="<?php echo $product->quantity; ?>"   >
               		</div>
                    <div style="color:#900"><?php if( isset( $error['stock_qty'] ) ) echo $error['stock_qty'];  ?></div>
				   </div> <!-- row -->
                   <div class="row">
                        <div class="col-lg-4">
                            <label for="product_sku">SKU</label>
                            <input  class="form-control" type="text" maxlength="20"  name="product_sku" id="product_sku" readonly="readonly"  value="<?php echo $variation['sku']; ?>" />
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
                <input type="checkbox" name="variation_flag" id="variation_flag"  value="1"  onchange="showVariation();" <?php echo ($product->variable_product == 1 ? 'checked' : ''); ?> ></p>
              </div>
    		  <div id="variation_box" class="variation_table" style="display:<?php echo ($product->variable_product == 1 ? 'block' : 'none'); ?>;">
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
                        <div class="col-lg-5"><a href="javascript:;" onclick="addVariation();" style="font-size:16px;"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;Add Option</a></div>
                    </div>
                    <div class="row">
                    	<div id="var_error" class="col-lg-12 var_error" >
                        </div>
                    </div>
                   <div style="border:0px rgba(64, 169, 182, 0.64) solid;border-bottom-style: none; height:auto; min-height:25px;">
                       <div class="col col-lg-12" style="background-color:rgba(64, 169, 182, 0.64); color:#FFF">
                            <div class="col-lg-2">Option Type</div>
                            <div class="col-lg-2">Option Name</div>
                            <div class="col-lg-3">Values</div>
                            <!--<div class="col-lg-1">Need SKU</div>-->
                            <div class="col-lg-1">Need UPC</div>
                            <div class="col-lg-1">Need Price</div>
                            <div class="col-lg-1">Need MSRP</div>
                            <div class="col-lg-1">Need Part#</div>
                        </div>
                        <div class="col col-lg-12" style="background-color:rgba(64, 169, 182, 0.64); color:#FFF;"  align="center">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-3"></div>
                            <!--<div class="col-lg-1"><input type="checkbox" name="need_sku" value="1" checked ></div>-->
                            <div class="col-lg-1"><input type="checkbox" name="need_upc" <?php echo ($product->variable_upc == 1 ? 'checked' : ''); ?>></div>
                            <div class="col-lg-1"><input type="checkbox" name="need_price" <?php echo ($product->variable_price == 1 ? 'checked' : ''); ?> ></div>
                            <div class="col-lg-1"><input type="checkbox" name="need_msrp" <?php echo ($product->variable_msrp == 1 ? 'checked' : ''); ?> ></div>
                            <div class="col-lg-1"><input type="checkbox" name="need_mpn" <?php echo ($product->variable_mpn == 1 ? 'checked' : ''); ?> ></div>
                        </div>
                       <div id="var_row">
<?php if ( $product->variable_product && count($options) ) { 

		 $var_types = array( 
		           1 => 'Color swatch',
				   2 => 'Color',
				   3 => 'Size',
				   4 => 'Custom'
		 		);
		 //$options = $variation['product_options'];
         for( $i=0; $i < count($options) ; $i++ ) { 
		 	$option_type_id = $options[$i]['option_type_id']; 
//echo "GV:" 
			?>
			<div class="row">
            	<div class="col-lg-2"><?php echo $var_types[ $option_type_id ]; ?>
                <input type="hidden" name="var_option_id_<?php echo ($i+1); ?>"  value="<?php echo $options[$i]['product_option_id']; ?>"  >
                <input type="hidden" name="var_<?php echo ($i+1); ?>"  value="<?php echo $option_type_id; ?>" readonly >
                </div>
                <div class="col-lg-2"><span id="opt_name"><?php echo $options[$i]['product_option_name']; ?></span>
                <input type="hidden" name="var_<?php echo ($i+1); ?>_name" value="<?php echo $options[$i]['product_option_name']; ?>" >
                </div>
                <div class="col-lg-6 color_val">
                	<?php if( $option_type_id == 1 ) { 
						  //$option_values = $options[$i]['values'];
						  $ID = $options[$i]['product_option_id'];
                          for($j=0; $j < count($values[$product_option_id]); $j++ ) { ?>
					<div id="color_line" style="width: 140px;">
					<div class="color" style="width: 18px; height: 18px; background-color: <?php echo $values[$ID][$j]['color_code'];?>; margin-top: 3px; float: left;"><input type="hidden" value="<?php echo $values[$ID][$j]['color_code'];?>" name="color_code[]" >
                    </div>
					<input style="height: 18px; border: medium none; font-size: 12px; padding: 1px; clear: both; margin-top: -4px; width: 100px;" name="<?php echo $options[$i]['product_option_name']; ?>[]" value="<?php echo $values[$ID][$j]['option_value'];?>" type="text" placeholder="color">
                    <a href="javascript:;" onclick="removeColorVariation(this);" title="Remove color"><i class="fa fa-times"></i></a>
                    <a href="javascript:;" onclick="addVariationValue(this);" title="Add color"><span style="float: left; margin-left: 150px; margin-top: -18px;" class="fa fa-plus-circle"></span></a>
					</div>
                    <?php } //end for ?>
                    <?php } //end if ?>
                	<?php if( $option_type_id == 2 ) { 
						  //$option_values = $options[$i]['values'];
						  $ID = $options[$i]['product_option_id'];
                          for($j=0; $j < count($values[$ID]); $j++ ) { ?>
					<div id="size_line" style="width: 140px;">
                    <input style="font-size: 12px;width:100px;padding:0 0;" name="<?php echo $options[$i]['product_option_name']; ?>[]" type="text" value="<?php echo $values[$ID][$j]['option_value'];?>" placeholder="size">
                    <a href="javascript:;" onclick="removeVariationValue(this);" title="Remove size"><i class="fa fa-times"></i></a>
                    <a href="javascript:;" onclick="addVariationValue(this, 'size');" title="Add size">
                    <span style="float: left;margin-left: 120px; margin-top: -18px;" class="fa fa-plus-circle"></span>
                    </a>
                    </div>
                    <?php } //end for ?>
                    <?php } ?>
                	<?php if( $option_type_id == 3 ) { 
						  //$option_values = $options[$i]['values'];
						   $ID = $options[$i]['product_option_id'];
                          for($j=0; $j < count($values[$ID]); $j++ ) { ?>
					<div id="var_line" style="width: 140px;">
                    <input style="font-size: 12px;width:100px;padding: 0 0;" name="<?php echo $options[$i]['product_option_name']; ?>[]" type="text" value="<?php echo $values[$ID][$j]['option_value'];?>" placeholder="Option Value">
                    <a href="javascript:;" onclick="removeVariationValue(this);" title="Remove Value">
                    <i class="fa fa-times"></i></a>
                    <a href="javascript:;" onclick="addVariationValue(this, 'other');" title="Add Value">
                    <span style="float: left;margin-left: 120px; margin-top: -18px;" class="fa fa-plus-circle"></span>
                    </a>
                    </div>

                    <?php } //end for ?>
                    <?php } ?>
                </div>
                <div class="col-lg-2" style="float:right">
                	<a href="javascript:;" onclick="removeVariation(this);"><i class="fa fa-minus"></i>&nbsp;Remove</a>
                </div>
            </div>			 
<?php  	} // end for  ?>

<?php } //end if ?>
                       </div>
                   </div>

              </div>
              <div class="form-group" style="display:<?php echo ($product->variable_product == 1 ? 'block' : 'none'); ?>;padding: 10px 0px;">
                  <button type="submit" name="UpdateVariation" value="UpdateVariation"  class="btn btn-info" onclick="return updateVariation(this);" >Update Variation</button><span style="color:red">Updating variation will Delete All variant values (Price, UPC etc.)</span>
              </div>
              
<div id="variation_list_box" style="display:<?php echo ($product->variable_product == 1 ? 'block' : 'none'); ?>;">
   <div class="variation_table" >
       <div class="col col-lg-12" style="background-color:rgba(64, 169, 182, 0.64); color:#FFF">
            <div class="col-lg-2">Image</div>
            <div class="col-lg-2">Variation</div>
            <div class="col-lg-2" align="center">SKU<br />Part#</div>
            <div class="col-lg-2" align="center">Qty</div>
            <div class="col-lg-2" align="center">Price<br />MSRP</div>
            <div class="col-lg-2" align="center">UPC</div>
       </div>
        <div class="row" style="border-bottom:none">
            <div class="col-lg-12 var_error">
            </div>
        </div>
  <div id="variant_data" >
<?php  
	$row_count =1;
	foreach( $variations as $key => $variant ) { ?>
	<div class="row" style="margin: 0px;padding-top: 10px;">
    <?php 
	  if ( $$variant['sku'] == '' ) {
		   $$variant['sku'] = $variant['sku']."-".$row_count;
	  }
	  $images = explode(",", $product->image);
	?>
            <div class="col-lg-2">
                <img width="100" src="/images/product/<?php echo $product->id; ?>/thumb/<?php echo $images[0]; ?>" title="product image"  />
            </div>
            <div class="col-lg-2" style="color:#000">
				<?php echo $variant['option1']; ?>
                <?php if( $variant['option2'] != '' ) : ?>
                      <br /><?php echo $variant['option2']; ?>
                <?php endif; ?>
                <?php if( $variant['option3'] != '' ) : ?>
                      <br /><?php echo $variant['option3']; ?>
                <?php endif; ?>
                <input type="hidden" name="variant_id[]" value="<?php echo $variant['product_variant_id']; ?>"  />
            </div>
            <div class="col-lg-2" align="center" >
            <input  name="var_sku[]" placeholder="SKU" value="<?php echo $val['sku']; ?>" readonly />
            <input  name="var_mpn[]" placeholder="Part number" value="<?php echo $val['part_number']; ?>" <?php echo ($variation['variable_mpn'] == 0 ? 'readonly' : ''); ?> style="display:<?php echo ($variation['variable_mpn'] == 0 ? 'none' : 'block'); ?>" />
            </div>
            <div class="col-lg-2" >
            	<input  placeholder="quantity" name="var_qty[]" value="<?php echo $variant['quantity']; ?>" style="width:80px;float:right;"  />
            </div>
            <div class="col-lg-2">
            <input  name="var_price[]" placeholder="Price" value="<?php echo $variant['price']; ?>" <?php echo ($product->variable_price == 0 ? 'readonly' : ''); ?>  >
            <input  name="var_msrp[]" placeholder="Max. Retail Price" value="<?php echo $variant['msrp']; ?>" <?php echo ($product->variable_msrp == 0 ? 'readonly' : ''); ?> >
            </div>
            <div class="col-lg-2">
            <input  name="var_upc[]" placeholder="UPC Code" value="<?php echo $variant['upc']; ?>" style="width:80px;float:right;display:<?php echo ($product->variable_upc == 0 ? 'none' : 'block'); ?>"  <?php echo ($product->variable_upc == 0 ? 'readonly' : ''); ?>  />
            </div>
    </div> <!-- row -->
<?php $row_count++; } ?>
   </div> <!-- table -->
</div>
              
              <div class="form-group" style="padding:10px 0px 0px 0">
                <input type="submit" name="btn-media" class="btn btn-info"  value="Previous Step"  />
                <input type="submit" name="btn-shipping" class="btn btn-info"  value="Next Step"  />
                <button type="submit" name="submit" class="btn btn-info" value="save_later" style="float:right;">Save and continue later</button>
              </div>                   
           </div> <!-- sh border -->
        </form>
        
    </div>
    </div>

<?php $this->load->view('site/templates/footer');?>
