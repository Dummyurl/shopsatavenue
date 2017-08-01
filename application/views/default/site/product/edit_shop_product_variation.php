<?php 
$this->load->view('site/templates/commonheader');
?>
<link rel="stylesheet" href="css/default/front/checkout.css">
<link rel="stylesheet" href="css/default/front/etalage.css">

<!--<script type="text/javascript" src="3rdparty/bootstrap-3.3.6/bootstrap-validator/validator.min.js"></script>-->
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
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 1:</span>Product Info</li>
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 2:</span>Product Media</li>
                            <li class="active"><a href="#tab3" data-toggle="tab"><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 3:</span>Price and Variation</a></li> 
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 4:</span>Product Shipping</li> 
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 5:</span>Finalize</li> 
                        </ul>
                    </nav>
					<div class="tab-content tab-content-t">

                        <div class="tab-pane active text-style" id="tab3">
                            <div class="con-w3l">
                                <div class="product-grid-item-wrapper">
                        			<div class="cart-wrapper row">
                                   	<div class="checkout-forms-wrapper ">
                                      <div class="row osky-form cart-form">
                                          <div class="table-row">
                        					<div class="table-header">
                            				<div id="payment-form" class="payment-form-wrapper">
                                            <form class="osky-form"   method="post" action="" name="frm_product_variation" id="frm_product_variation" onSubmit="return validate();"  >
                                            <input type="hidden" name="current_step" value="variation"  />
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  >
                                            <input type="hidden" name="total_options" value="<?php echo count($variation['product_options']); ?>"  />

                                            <div id="add-credit-card">
                                            <div class="credit-card checkout-section">
                                            <div class="inner">
                                                <div class="col-md-12">
                                                <div class="col-md-12">
												<h2 class="checkout-sub-header">Product Price and Variation</h2>
                                       
                                               <div aria-required="true" class="zip required ">
                                                     <label aria-required="true" for="product_msrp">Retail Price ( MSRP )</label>
                                                     <span class="field-wrap ">
                   									 <input type="text" maxlength="20"  name="product_msrp" id="product_msrp" value="<?php echo number_format($product->msrp,2); ?>"  />
                                                     </span>
                                               </div>
                                               <div aria-required="true" class="zip required ">
                                                  <label aria-required="true" for="transaction_billing_postal_code">Price On Shops@Avenue</label>
                                                    <span class="field-wrap ">
                   									<input type="text" maxlength="20"  name="product_price" id="product_price" value="<?php echo number_format($product->price,2); ?>"  >
                                                    </span>
                                               </div>
                                               <div aria-required="true" class="zip required ">
                                                  <label aria-required="true" for="transaction_billing_postal_code">Inventory</label>
                                                    <span class="field-wrap ">
            										<input type="number" maxlength="20" name="stock_qty" id="stock_qty"  value="<?php echo $product->quantity; ?>"   >
                                                    </span>
                                               </div>
                           
                                                <div aria-required="true" class="zip required ">
                                                  <label aria-required="true" for="product_sku">SKU</label>
                                                    <span class="field-wrap ">
													<input type="text" maxlength="20"  name="product_sku" id="product_sku" readonly="readonly"  value="<?php echo $variation['sku']; ?>" />
                                                    </span>
                                                </div>
                                                <div aria-required="true" class="zip required ">
                                                  	<label aria-required="true" for="product_upc">UPC (Optional)</label>
                                                    <span class="field-wrap ">
													<input type="text" maxlength="14"  name="product_upc" id="product_upc"  value="<?php echo $variation['upc']; ?>"   />
                                                    </span>
                                                </div>
                                                <div aria-required="true" class="zip required ">
                                                  	<label aria-required="true" for="transaction_billing_postal_code">Manufact. Part Number (Optional)</label>
                                                    <span class="field-wrap ">
													<input type="text" maxlength="14"  name="product_mpn" id="product_mpn" value="<?php echo $variation['part_number']; ?>" />
                                                    </span>
                                               </div>
                                                <div aria-required="true" class="city required ">
                                                   <div class="billing-address checkout-section">
                                                    <div class="billing-shipping-address" style="padding-left:0px; margin-left:0px;">
                                                    <!--<input id="use-shipping"  type="checkbox" style="margin-top:7px;">-->
                									<input type="checkbox" name="variation_flag" id="variation_flag"  value="1"  onchange="showVariation();" <?php echo ($product->variable_product == 1 ? 'checked' : ''); ?> style="margin-top:7px;" >
                                                    <label for="variation_flag" style="color:#F00;">This product has variations (Size, Color, etc.) ( optional ) </label>
                                                    </div>
                                                   </div>
                                                </div>
                           
                           						<table class="table table-bordered table-striped" style="margin-top:0px;">
                                        		<thead>
                                            	<div aria-required="true" class="state required " style="width:30%;">
                                				<span class="field-wrap ">
                                                <select class="osky-select" name="var_type" >
                                                    <option value="" >Select type</option>
                                                    <option value="color_swatch">Color swatch</option>
                                                    <option value="size_list">Size</option>
                                                    <option value="custom_list">Custom dropdown</option>
                                                </select>
                                				</span>
												</div>
                           
                                              <div aria-required="true" class="zip required " style="width:30%;">
                                                <span class="field-wrap ">
                            						<input type="text" name="var_name" id="var_name" value=""  />
                                                </span>
											  </div>
                                               <div aria-required="true" class="zip required " style="width:30%; margin-left:6px;">
                                               		<p style="clear:both;">
                                                    <button id="apply-coupon-btn" class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button" onClick="addVariation();" style="background-color:#0e73bc; border:none;"><i class="fa fa-plus"></i>Add Option</button>
                                                    </p>
                                               </div>
                           
                           
                                        <tr >
                                            <th class="span2" style="font-size:15px;">Option Type</th>
                                            <th class="span2"  style="font-size:15px;">Option Name</th>
                                            <th class="span3"  style="font-size:15px;">Values</th>
                                            <th class="span4"  style="font-size:15px;">Need UPC </th>
                                            <th class="span5" style="font-size:15px;">Need Price</th>
                                            <th class="span6"  style="font-size:15px;">Need MSRP</th>
                                            <th class="span7"  style="font-size:15px;">Need Part #</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="billing-shipping-address">
                                            <td style="text-align:center;"></td>
                                            <td></td>
                                            <td></td>
                                            <td><input type="checkbox" name="need_upc" <?php echo ($product->variable_upc == 1 ? 'checked' : ''); ?>></td>
                                            <td><input type="checkbox" name="need_price" <?php echo ($product->variable_price == 1 ? 'checked' : ''); ?> ></td>
                                            <td><input type="checkbox" name="need_msrp" <?php echo ($product->variable_msrp == 1 ? 'checked' : ''); ?> ></td>
                                            <td><input type="checkbox" name="need_mpn" <?php echo ($product->variable_mpn == 1 ? 'checked' : ''); ?> ></td>
                                            <td>
                                            	<!--<a href="#" style="background-color:#0e73bc; color:#fff; padding:10px 15px 10px 15px; border-radius:6px;">REMOVE</a>-->
                                            </td>
                                          
                                       </tr>
                                       
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
										?>
                                       <tr id="var_row">
                                            <td>
												<?php echo $var_types[ $option_type_id ]; ?>
                                                <input type="hidden" name="var_option_id_<?php echo ($i+1); ?>"  value="<?php echo $options[$i]['product_option_id']; ?>"  >
                                                <input type="hidden" name="var_<?php echo ($i+1); ?>"  value="<?php echo $option_type_id; ?>" readonly >                                            </td>
                                            <td>
												<span id="opt_name"><?php echo $options[$i]['product_option_name']; ?></span>
                								<input type="hidden" name="var_<?php echo ($i+1); ?>_name" value="<?php echo $options[$i]['product_option_name']; ?>" >                                            </td>
                                            <td class="color_val" colspan="4">
													<?php if( $option_type_id == 1 ) { 
                                                          //$option_values = $options[$i]['values'];
                                                          $ID = $options[$i]['product_option_id'];
                                                          for($j=0; $j < count($values[$product_option_id]); $j++ ) { ?>
                                                    <div id="color_line" style="width: 140px;">
                                                    <div class="color" style="width: 18px; height: 18px; background-color: <?php echo $values[$ID][$j]['color_code'];?>; margin-top: 3px; float: left;"><input type="hidden" value="<?php echo $values[$ID][$j]['color_code'];?>" name="color_code[]" >
                                                    </div>
                                                    <input style="height: 18px; border: medium none; font-size: 12px; padding: 1px; clear: both; margin-top: -4px; width: 100px;" name="<?php echo $options[$i]['product_option_name']; ?>[]" value="<?php echo $values[$ID][$j]['option_value'];?>" type="text" placeholder="color">
                                                    <a href="javascript:;" onClick="removeColorVariation(this);" title="Remove color"><i class="fa fa-times"></i></a>
                                                    <a href="javascript:;" onClick="addVariationValue(this);" title="Add color"><span style="float: left; margin-left: 150px; margin-top: -18px;" class="fa fa-plus-circle"></span></a>
                                                    </div>
                                                    <?php } //end for ?>
                                                    <?php } //end if ?>
                                                    
													<?php if( $option_type_id == 2 ) { 
                                                          //$option_values = $options[$i]['values'];
                                                          $ID = $options[$i]['product_option_id'];
                                                          for($j=0; $j < count($values[$ID]); $j++ ) { ?>
                                                    <div id="size_line" style="width: 140px;">
                                                    <input style="font-size: 12px;width:100px;padding:0 0;" name="<?php echo $options[$i]['product_option_name']; ?>[]" type="text" value="<?php echo $values[$ID][$j]['option_value'];?>" placeholder="size">
                                                    <a href="javascript:;" onClick="removeVariationValue(this);" title="Remove size"><i class="fa fa-times"></i></a>
                                                    <a href="javascript:;" onClick="addVariationValue(this, 'size');" title="Add size">
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
                                                    <a href="javascript:;" onClick="removeVariationValue(this);" title="Remove Value">
                                                    <i class="fa fa-times"></i></a>
                                                    <a href="javascript:;" onClick="addVariationValue(this, 'other');" title="Add Value">
                                                    <span style="float: left;margin-left: 120px; margin-top: -18px;" class="fa fa-plus-circle"></span>
                                                    </a>
                                                    </div>
                                
                                                    <?php } //end for ?>
                                                    <?php } ?>

                                            </td>
                                            <td>
                                            	<a href="javascript:;" title="Remove" ><i class="fa fa-minus fa-2x"></i></a>
                                            </td>
                                        
                                       </tr>
										<?php  	} // end for  ?>
                                        <?php } //end if ?>
                                        
                                        
                                        </tbody>
                                    </table>
                                    
                                    <div aria-required="true" class="zip required " style="width:50%;">
                           				<p style="clear:both;">
                           					<button  type="submit" name="UpdateVariation" value="UpdateVariation"  onclick="return updateVariation(this);" class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button" style="background-color:#0e73bc; border:none;">Update Variation</button>&nbsp;&nbsp;<span>Updating variation will Delete All variant values (Price, UPC etc.)</span></p>
                           			</div>
                           
                           
                            <table class="table table-bordered table-striped" style="margin-top:0px;">
                                <thead>
                           			<tr>
									<th class="span2" style="font-size:15px;">Image</th>
                                    <th class="span2"  style="font-size:15px;">Variation</th>
                                    <th class="span3"  style="font-size:15px;">SKU<br>Part#</th>
                                    <th class="span4"  style="font-size:15px;">Qty </th>
                                    <th class="span5" style="font-size:15px;">Price<br>MSRP</th>
                                    <th class="span6"  style="font-size:15px;">UPC</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                    <tr id="variant_data" >
                                      <td style="text-align:center;">
                							<img width="100" src="images/product/<?php echo $product->id; ?>/thumb/<?php echo $images[0]; ?>" title="product image"  />
                                      </td>
                                        <td>
											<?php echo $variant['option1']; ?>
                                            <?php if( $variant['option2'] != '' ) : ?>
                                                  <br /><?php echo $variant['option2']; ?>
                                            <?php endif; ?>
                                            <?php if( $variant['option3'] != '' ) : ?>
                                                  <br /><?php echo $variant['option3']; ?>
                                            <?php endif; ?>
                                            <input type="hidden" name="variant_id[]" value="<?php echo $variant['product_variant_id']; ?>"  />
                                        </td>
                                        <td>
                                            <input  name="var_sku[]" placeholder="SKU" value="<?php echo $val['sku']; ?>" readonly />
                                            <input  name="var_mpn[]" placeholder="Part number" value="<?php echo $val['part_number']; ?>" <?php echo ($variation['variable_mpn'] == 0 ? 'readonly' : ''); ?> style="display:<?php echo ($variation['variable_mpn'] == 0 ? 'none' : 'block'); ?>" />
                                        </td>
                                        <td>
            								<input  placeholder="quantity" name="var_qty[]" value="<?php echo $variant['quantity']; ?>" style="width:80px;float:right;"  />
                                        </td>
                                        <td>
                                            <input  name="var_price[]" placeholder="Price" value="<?php echo $variant['price']; ?>" <?php echo ($product->variable_price == 0 ? 'readonly' : ''); ?>  >
                                            <input  name="var_msrp[]" placeholder="Max. Retail Price" value="<?php echo $variant['msrp']; ?>" <?php echo ($product->variable_msrp == 0 ? 'readonly' : ''); ?> >
                                        </td>
                                        <td>
            								<input  name="var_upc[]" placeholder="UPC Code" value="<?php echo $variant['upc']; ?>" style="width:80px;float:right;display:<?php echo ($product->variable_upc == 0 ? 'none' : 'block'); ?>"  <?php echo ($product->variable_upc == 0 ? 'readonly' : ''); ?>  />
                                        </td>
                                   </tr>
									<?php $row_count++; } ?>

                                </tbody>
                           </table>
                            
                            
                        <div class="container">
                        
                        <div class="col-md-2">
                        	<p style="clear:both;">
                            	<button type="submit" name="btn-media" value="Previous Step"  class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button" style="background-color:#0e73bc; border:none;">Prev Step</button>
                            </p>
                        </div>
                        <div class="col-md-7">
                        	<p style="clear:both;">
                            	<button type="submit" name="btn-shipping"value="Next Step"  class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button" style="background-color:#598F27; border:none;">Next Step</button>
                            </p>
                        </div>
                            
                        <div class="col-md-3">
                        	<p style="clear:both;">
                            	<button type="submit" name="submit" value="save_later"  class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button"  style="background-color:#333; border:none;">Save and Continue Later</button>
                            </p>
                       </div>
                        
                     </div>
                        
                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        </div>
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

<?php $this->load->view('site/templates/footer');?>
