<?php 
$this->load->view('site/templates/merchant_header');

$this->load->model('product_model');
$this->load->model('user_model');

?>
<script type="text/javascript">
    var base_url =  '<?php echo base_url();?>';
</script>
<script src="<?php echo base_url(); ?>3rdparty/jquery/js/jquery.popupoverlay.js"></script>
<style>
table{max-width:100%;border-collapse:collapse;border-spacing:0}
.table{width:100%;margin-bottom:24px}
.table th,.table td{padding:8px 8px 8px 16px;line-height:20px;text-align:left;border-top:1px solid #999}
.table th{font-weight:700;vertical-align:bottom}.table td{vertical-align:top}
.table thead:first-child tr th,.table thead:first-child tr td{border-top:0}
.table tbody+tbody{border-top:2px solid #999}
tr.expired{color:#999;text-decoration:line-through}
.table-gaps th,.table-gaps td{border:0;border-left:5px solid #fff;border-bottom:5px solid #fff}
.table-gaps th:first-child,.table-gaps td:first-child{border-left:0}.table-striped tr th,.table-striped tr td{background:#ededed}.table-striped tr:nth-child(even) th,.table-striped tr:nth-child(even) td{background:#ddd}.table-striped thead:first-child tr th,.table-striped thead:first-child tr td{background:#b4e2f3;color:#666}.table-striped-simple tr:nth-child(even) th,.table-striped-simple tr:nth-child(even) td{background:#ededed}.table-nohead tr:first-child td{border-top:0}.table-thick td{padding:1em}.table-grid-tight{font-size:11px;border-collapse:separate;border-spacing:1px;margin-bottom:10px}.table-grid-tight th,.table-grid-tight td{padding:8px;border:1px solid rgba(204,204,204,0.3);background:#ededed;line-height:14px}.table-half{max-width:50%}.table-list td{border:0;padding:8px 0}.table-list td:first-child{font-weight:700}.table-small th,.table-small td{padding:8px 4px;font-size:12px}@media screen and (max-width:620px){.table-scrollable{overflow-x:scroll}.table-scrollable table{min-width:495px;margin-bottom:0}}
.tab-head {
    margin: 1em 0 0;
}
</style>
<div class="container"  >

<!-- product feeds -->
<h3>Orders</h3>


<!--content-->
<div class="content-top ">
	<div class="container ">
    	<div class="tab-head ">
			<nav class="nav-sidebar">
				<ul class="nav tabs ">
					  <!--<li class="active" style="padding-left:30px; text-align:left; padding-right:30px;">
                      	<a href="#tab11" data-toggle="tab"><h4>Purchases & Reviews</h4></a>
                      </li>-->
					  <li class="<?php echo $tab_name == '' ? 'active' : ''; ?>" style="padding-left:30px; padding-right:30px;">
                      	<a href="shops/shop-orders" onclick="location=base_url + 'shops/shop-orders';" ><h4>New Orders</h4></a>
                      </li> 
                      <li class="<?php echo $tab_name == 'Cancelled' ? 'active' : ''; ?>" style="padding-left:30px; padding-right:30px;">
                      	<a href="javascript:void(0);" onclick="show_completed();" data-toggle="tab"><h4>Cancelled</h4></a>
                        </li> 
					  <li class="<?php echo $tab_name == 'shipped' ? 'active' : ''; ?>" style="padding-left:30px; padding-right:30px;">
                      	<a href="javascript:void(0);" onclick="show_shipped();"  data-toggle="tab"><h4>Shipped</h4></a></li>  
					  <li class="<?php echo $tab_name == 'delivered' ? 'active' : ''; ?>" style="padding-left:30px; padding-right:30px;">
                      	<a href="javascript:void(0);" onclick="show_delivered();"  data-toggle="tab"><h4>Delivered</h4></a></li>  
                      <li class="<?php echo $tab_name == 'returns' ? 'active' : ''; ?>" style="padding-left:30px; padding-right:30px;">
                      	<a href="javascript:void(0);" onclick="show_returns();" data-toggle="tab"><h4>Returns</h4></a>
                      </li> 
                      <li class="<?php echo $tab_name == 'returns' ? 'active' : ''; ?>" style="padding-left:30px; padding-right:30px;">
                      	<a href="javascript:void(0);" onclick="show_refunds();" data-toggle="tab"><h4>Refunds</h4></a>
                      </li> 

				</ul>
			</nav>
            
            <div class="tab-content tab-content-t " style="background-color:#efefef;">
				<div class="tab-pane active text-style" id="result_content"  >
						<div class="con-w3l">
                           	<section id="responsive">
            					<table class="table table-bordered table-striped" style="margin-top:0px;">
                					<thead>
                						<tr>
                                            <th class="span1">S.No</th>
                                            <th class="span2">Order #</th>
                                            <th class="span3">Order Date</th>
                                            <th  class="span4">Ship To</th>
                                            <th class="span5">Order Total</th>
                                            <th  class="span6">Order Status</th>
                                            <th class="span7">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php $i=1;
                                          foreach ( $orders as $key => $order ) : ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $order['store_order_id']; ?></td>
                                                <td><?php echo date('m-d-Y', strtotime($order['date_added']) ); ?></td>
                                                <td><?php echo $order['shipping_firstname']; ?></td>
                                                <td><?php echo number_format( $order['total'], 2); ?></td>
                                                <td><?php echo ($order['order_status_id'] == 0 ? 'Unpaid' : $order['order_status_name']); ?></td>
                                                <td class="action"><a href="javascript:;" onclick="show_order('<?php echo $order['order_id']; ?>')">
                                                <i class="fa fa-eye fa-lg"></i></a>
                                                </td>
                                            </tr>
                                    <?php $i++; endforeach; ?>
									</tbody>
								</table>
							</section>
                       		<div class="clearfix"></div>
						</div>
				</div>
           
            </div>
				
		</div>
	</div> 
</div>

</div>
<div id="order_popup" style="display:none">
  <div class="head1">Order Details<span class="close-popup"><i class="fa fa-times"></i></span></div>
  <!--<div class="container">
  		<div class="address_box">
        	<div>Billing Address</div>
            <div>Name</div>
            <div>Address</div>
            <div>zip</div>
        </div>
  </div>-->
	<div class="row" >
        <div class="col-md-3 border1" style="min-height:186px;margin-left:30px;">
             <div class="box_head">Customer Information</div>
             <div id="bill_address"></div>
        </div>
        <div class="col-md-4 border1" style="min-height:186px;margin-left:13px;" >
        	 <div class="box_head">Shipping Address</div>
             <div id="ship_address"></div>
        </div>
        <div id="order_info" class="col-md-4 border1" style="min-height:186px; float:right; margin-right:30px;">
        </div>
    </div>
	<div class="row"  style="margin:20px;">
        <div class="col-md-12 text-center"><h4>Product Details</h4></div>
    </div>

	<div class="product_table row border1">
       <div class="product_row row" style="height:40px;">
            <div >S.No</div>
            <div>IMAGE</div>
            <div class="text-center">Name</div>
            <!--<div>SKU</div>
            <div>UPC</div>-->
            <div>Quantity</div>
            <div>Price</div>
            <div style="text-align: right;padding-right: 20px;" >Total</div>
       </div>

    </div> <!-- product table -->
  
  <!--<button class="order_popup_close">Close</button>-->
</div>

</div>

<div id="return_popup" style="display:none">
  <div class="head1">Product Return<span class="close-popup return_popup_close"><i class="fa fa-times"></i></span></div>
  <div class="container">
  </div>
  <div class="rtn-content">
  		<label>Reason for return</label>
        <textarea class="form-control" name="rtn_reason"></textarea>
  </div>
  <div class="rtn-content" style="padding-bottom:30px;" >
  	<p style="color:red;text-align:center;padding-top:10px;">Please confirm the above product and quanity to RETURN. <span id="rtn-last-date"></span></p>
    <div style="margin:auto; width:200px;">
    	<button type="button" class="btn btn-info" name="btn-rtn-confirm" onclick="save_return();" >Confirm Product Return</button>
    </div>
  </div>
</div>	

<div id="shipment_info"  style="display:none;" >
  <div style="width:80%;margin:auto;">
      <div style="font-stretch:extra-expanded;text-align:center; font-weight:600;">Add Shipment Information</div>
      <fieldset>
      <input type="hidden" name="rtn_rma_id" value=""  >
      <div>
         <label for="carrier">Carrier</label>
         <select class="form-control" name="carrier" >
         		<option value="">Select Carrier</option>
              <?php foreach( $carriers as $key => $val ) : ?>

         		<option value="<?php echo $val->carrier_code;?>" ><?php echo $val->carrier_name; ?></option>
              <?php endforeach; ?>
         </select>
      </div>
      <div>
         <label for="tracking_no">Tracking Number</label>
         <input class="form-control" type="text" name="tracking_no" >
      </div>
      <div style="padding:10px" align="center">
            <button type="button" class="btn btn-sm btn-info" onClick="save_shipment_info();">Save</button>
            <button type="button" class="btn btn-sm btn-info" onClick="close_shipment_box();" >Close</button>
      </div>
      </fieldset>
  </div>
</div>

<script type="text/javascript">

function show_shipped() {
    location = '<?php echo base_url();?>' + 'shops/shop-orders?tab_name=shipped';
	return;
	//$('ul.secondary-tabs li a').removeClass('active');
	//$('ul.secondary-tabs li:eq(1) a').addClass('active');
	$('ul.nav.tabs li').removeClass('active');
	$('ul.nav.tabs li:nth-child(2)').addClass('active');

	$('#result_content').find('table').html('')
	$('<div style="padding:100px;width:100px; margin:auto;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>').insertBefore( $('#result_content').find('table') );

	$.ajax({
		url: '<?php echo base_url();?>' + 'shops/shop-orders?tab_name=shipped', 
		method: 'post',
		//data: ,
		dataType: 'json',
		success: function(result) {
			//alert( JSON.stringify( result ) );
			var html = '';
			var i=0;
			//$('#result_content').find(.html('');
			html = '<thead><tr>';
			html += '<td>S.No</td>';
			html += '<td>Image</td>';
			html += '<td>Product</td>';
			html += '<td>Quantity</td>';
			html += '<td>Ship Date</td>';
			html += '<td>Delivery Date</td>';
			html += '<td>Carrier</td>';
			html += '<td>Tracking #</td>';
			html += '<td>Action</td>';
			html += '</tr></thead>';
			$('#result_content').find('table').html( html );
			for( i=0; i < result.shipments.length; i++ ) {
				var images;
				var ship_date = result.shipments[i].ship_date.split('-');
				var order_id  = result.shipments[i].store_order_id.split('-');
				if ( result.shipments[i].image != null ) images = result.shipments[i].image.split(',');
				var image = '';
				if ( images.length > 0 ) {
					image = 'images/product/' + result.shipments[i].product_id + '/thumb/' + images[0];
				}
				html = '<tbody><tr>';
				html += '<td>' + ( i + 1 ) + '</td>';
				html += '<td><image src="' + image  +  '" alt="image" title="product" /></td>';
				html += '<td>'
				html += '<div class="" >' + result.shipments[i].name +  '</div>' ;
				html += '<div>' + result.shipments[i].shop_name +  '</div>' ;
				html += '</td>';
				html += '<td>' + result.shipments[i].quantity +  '</td>';
				html += '<td>' + ship_date[1] + '/' + ship_date[2] + '/' + ship_date[0] +  '</td>';
				html += '<td>' + result.shipments[i].carrier +  '</td>';
				html += '<td>' + result.shipments[i].tracking_no +  '</td>';
				html += '<td><a href="javascript:;" onclick="show_order(\'' + order_id + '\')"><i class="fa fa-eye fa-lg"></i></a>';
				html += '</td>';
				html += '</tr></tbody>';
				$('#result_content').find('table').append( html );
			}
			
			if( result.shipments.length == 0 ) {
				$('#result_content').find('table').append( '<tbody><tr><td colspan=7>No Data</td></tr></tbody>' );
			}
			$('.fa-spinner').closest('div').remove();
		}
	});

}

function show_completed() {
    location = '<?php echo base_url();?>' + 'shops/shop-orders?tab_name=Cancelled';
	return;

	$('ul.nav.tabs li').removeClass('active');
	$('ul.nav.tabs li:nth-child(3)').addClass('active');
	$('<div style="padding:100px;width:100px; margin:auto;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>').insertBefore( $('#result_content').find('table') );

	$.ajax({
		url: '<?php echo base_url();?>' + 'site/order/getCompletedOrder', 
		method: 'post',
		//data: ,
		dataType: 'json',
		success: function(result) {
			//alert( JSON.stringify( result ) );
			var html = '';
			var i=0;
			$('#result_content').find('table').html( '' );
			$('#return_popup .rtn-content').show();
			$('#return_popup .fa-spin').remove();
			
			html = '<thead><tr>';
			html += '<td>S.No</td>';
			html += '<td>Image</td>';
			html += '<td>Product</td>';
			html += '<td>Quantity</td>';
			html += '<td>Ship Date</td>';
			html += '<td>Delivery Date</td>';
			html += '<td>Carrier</td>';
			html += '<td>Tracking #</td>';
			html += '<td>Action</td>';
			html += '</tr></thead>';
			$('#result_content').find('table').html( html );
			for( i=0; i < result.shipments.length; i++ ) {
				var images;
				var ship_date = result.shipments[i].ship_date.split('-');
				var delivery_date = result.shipments[i].delivered_date.split('-');

				var order_id  = result.shipments[i].store_order_id.split('-');
				if ( result.shipments[i].image != null ) images = result.shipments[i].image.split(',');
				var image = '';
				if ( images.length > 0 ) {
					image = 'images/product/' + result.shipments[i].product_id + '/thumb/' + images[0];
				}
				html = '<tbody><tr>';
				html += '<td>' + ( i + 1 ) + '</td>';
				html += '<td class="thumb-image"><image src="' + image  +  '" alt="image" title="product" /></td>';
				html += '<td>'
				html += '<div>' + result.shipments[i].name +  '</td>' ;
				html += '<div>' + result.shipments[i].shop_name +  '</td>' ;
				html += '</td>';
				html += '<td>' + result.shipments[i].quantity +  '</td>';
				html += '<td>' + ship_date[1] + '/' + ship_date[2] + '/' + ship_date[0] +  '</td>';
				html += '<td>' + delivery_date[1] + '/' + delivery_date[2] + '/' + delivery_date[0] +  '</td>';
				html += '<td>' + result.shipments[i].carrier +  '</td>';
				html += '<td>' + result.shipments[i].tracking_no +  '</td>';

				html += '<td>';
				html += '<div style="padding-left:25px;"><a href="javascript:;" onclick="show_order(\'' + order_id[0] + '\')"><i class="fa fa-eye fa-lg"></i></a></div>';
				if( parseInt(result.shipments[i].days) < 15 ) {
					html += '<div><a href="javascript:;" onclick="show_return_form('+ result.shipments[i].order_product_id +', this )"><button type="button" name="btn-return" class="btn btn-info">Return</button></div>';
				}
				
				html += '</td>';
				
				html += '</tr></tbody>';
				$('#result_content').find('table').append( html );
			}
			if( result.shipments.length == 0 ) {
				$('#result_content').find('table').append( '<tbody><tr><td colspan=7>No Data</td></tr></tbody>' );
			}
			$('.fa-spinner').closest('div').remove();

		}
	});

}

function show_returns() {

    location = '<?php echo base_url();?>' + 'shops/shop-orders?tab_name=returns';
	return;

	$('ul.nav.tabs li').removeClass('active');
	$('ul.nav.tabs li:nth-child(4)').addClass('active');
	$('<div style="padding:100px;width:100px; margin:auto;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>').insertBefore( $('#result_content').find('table') );

	$.ajax({
		url: '<?php echo base_url();?>' + 'site/order/getOrderReturns', 
		method: 'post',
		//data: ,
		dataType: 'json',
		success: function(result) {
			var html = '';
			var i=0;
			$('#result_content').find('table').html( '' );
			
			html = '<thead><tr>';
			html += '<td>S.No</td>';
			html += '<td>Image</td>';
			html += '<td>Product</td>';
			html += '<td>Quantity</td>';
			html += '<td>Return Date</td>';
			html += '<td>Carrier</td>';
			html += '<td>Tracking #</td>';
			html += '<td>Status</td>';
			html += '<td>Action</td>';
			html += '</tr></thead>';
			$('#result_content').find('table').html( html );
			for( i=0; i < result.returns.length; i++ ) {
				var images;
				//var rtn_date = result.returns[i].rtn_date.split('-');
				var carrier = result.returns[i].return_carrier;
				carrier = carrier == '' ? '&nbsp;' : carrier;
				var tracking_no = result.returns[i].return_tracking_no;
				tracking_no = tracking_no == '' ? '&nbsp;' : tracking_no ;
				
				if ( result.returns[i].image != null ) images = result.returns[i].image.split(',');
				var image = '';
				if ( images.length > 0 ) {
					image = 'images/product/' + result.returns[i].product_id + '/thumb/' + images[0];
				}

				html = '<tbody><tr>';
				html += '<td>' + ( i + 1 ) + '<input type="hidden" name="rma_id[]" value="' + result.returns[i].rma_id + '" ></td>';
				html += '<td class="thumb-image"><image src="' + image  +  '" alt="image" title="product" /></td>';
				html += '<td>'
				html += '<div class="" >' + result.returns[i].name +  '</div>' ;
				//html += '<div>' + result.shipments[i].shop_name +  '</div>' ;
				html += '</td>';
				html += '<td>' + result.returns[i].quantity +  '</td>';
				html += '<td>' + result.returns[i].rtn_date +  '</td>';
				html += '<td>' + carrier +  '</td>';
				html += '<td>' + tracking_no +  '</td>';
				html += '<td>' + result.returns[i].return_status_name +  '</td>';

				html += '<td>';
				html += '<div style="padding-left:25px;"><a href="javascript:;" onclick="show_order(\'' + result.returns[i].order_id + '\')"><i class="fa fa-eye fa-lg"></i></a></div>';
				if ( result.returns[i].return_tracking_no == '' && result.returns[i].return_carrier == '' ) {
					html += '<button class="btn btn-info" name="btn-add-track" onclick="addShipment( this );" style="padding-left:10px;">Add Carrier</button>';
				}
				html += '</td>';
				
				html += '</tr></tbody>';
				$('#result_content').find('table').append( html );
				if( result.returns.length == 0 ) {
					$('#result_content').find('table').append( '<tbody><tr><td colspan=7>No Data</td></tr></tbody>' );
				}
				$('.fa-spinner').closest('div').remove();
	
				}
		}
	});

}

function show_order( order_id ) {

	$.ajax({
		url: '<?php echo base_url();?>' + 'site/order/getOrder', 
		method: 'post',
		data: { 'order_id' : order_id },
		dataType: 'json',
		success: function(result) {
			//alert( JSON.stringify( result ) );
			var html = '';
			var i=0;
			for( i=0;i < $('.product_row').length-1; i++ ) {
				$('.product_row:last-child').remove();
			}
			$('#bill_address').html('');
			$('#ship_address').html('');
			$('#order_info').html('');
			$('.total_row').remove();
             html += '<div class="col-md-5 text-right" >Order #:</div><div class="col-md-6" >' + result.order.order_id + '</div>';
             html += '<div class="col-md-5 text-right">Order Date:</div><div class="col-md-6">' + result.order.date_added + '</div>';
             html += '<div class="col-md-5 text-right">Email:</div><div class="col-md-6">' + result.order.email + '</div>';
             html += '<div class="col-md-5 text-right">Phone:</div><div class="col-md-6">' + result.order.telephone + '</div>';
			$('#order_info').append( html );
			html = '';
			html += '<div>' + result.order.payment_firstname + '</div>';
			html += '<div>' + result.order.payment_address_1 + '</div>';
			if ( result.order.payment_address_2 != null || result.order.payment_address_2.length > 0 ) {
				html += '<div>' + result.order.payment_address_2 + '</div>';
			}
			html += '<div>' + result.order.payment_city + ', ' + result.order.payment_zone + '</div>' ;
			html += '<div>' + result.order.payment_postcode  + '</div>' ;
			$('#bill_address').append(html);
			html = '';
			html += '<div>' + result.order.shipping_firstname + '</div>';
			html += '<div>' + result.order.shipping_address_1 + '</div>';
			if ( result.order.shipping_address_2 != null || result.order.shipping_address_2.length > 0 ) {
				html += '<div>' + result.order.shipping_address_2 + '</div>';
			}
			html += '<div>' + result.order.shipping_city + ', ' + result.order.shipping_zone + '</div>' ;
			html += '<div>' + result.order.shipping_postcode  + '</div>' ;
			$('#ship_address').append(html);
			var subtotal = 0.0;
			var disc_total = 0.0;
			var ship_total = 0.0;
			for( var i=0; i < result.products.length; i++ ) {
				var images;
				var line_total;
				line_total = parseFloat(result.products[i].quantity) * parseFloat(result.products[i].price);
				subtotal += line_total;
				disc_total += parseFloat( result.products[i].disc_amount );
				ship_total += parseFloat( result.products[i].shipping_paid );
				if ( result.products[i].image != null ) images = result.products[i].image.split(',');
				var image = '';
				if ( images.length > 0 ) {
					image = 'images/product/' + result.products[i].product_id + '/thumb/' + images[0];
				}
				html = '<div class="product_row row">';
				html += '<div>' + ( i + 1 ) + '</div>';
				html += '<div class="thumb-image"><image src="' + image  +  '" alt="image" title="product" /></div>';
				html += '<div>'
				html += '<div class="pname" >' + result.products[i].name +  '</div>' ;
				html += '<div>' + result.products[i].shop_name +  '</div>' ;
				html += '</div>';
				html += '<div>' + result.products[i].quantity +  '</div>';
				html += '<div>' + parseFloat(result.products[i].price).toFixed(2) +  '</div>';
				html += '<div class="price" >' + line_total.toFixed(2) +  '</div>';
				html += '</div>';
				$('.product_table').append( html );
			}
			
			html = '';
			html += '<div class="total_row">Sub total: <span>' + subtotal.toFixed(2) + '</span><div>';
			html += '<div class="total_row">Discount: <span>' + disc_total.toFixed(2) + '</span><div>';
			html += '<div class="total_row">Shipping Total: <span>' + ship_total.toFixed(2) + '</span><div>';
			html += '<div class="total_row">Total Paid: <span>' + parseFloat(result.order.total).toFixed(2) + '</span><div>';

			$(html).insertAfter('.product_table');
       
			$('#order_popup').popup('show');
		}
	});
}

$('.close-popup').on('click', function() {
	$('#order_popup').popup('hide');
});

function addShipment( obj ) {
	$('.return_row.selected').removeClass('selected');
	
	$(obj).closest('.return_row').addClass('selected');
	$('input[name=rtn_rma_id]').val( $(obj).closest('.return_row').find('input[name^=rma_id]').val() );
	$('#shipment_info').popup('show');
}

function close_shipment_box() {

	$('select[name=carrier]').val('');
	$('input[name=tracking_no], input[name=rtn_rma_id]').val('');
	$('#shipment_info').popup('hide');
}

function save_shipment_info( ) {
	
	$('.error-msg').remove();
	$('.has-error').removeClass('has-error');
	var isValid = true;
	
	if( $('select[name=carrier]').val() == '' ) {
		$('select[name=carrier]').closest('div').addClass('has-error');
		$('select[name=carrier]').closest('div').append('<div class="error-msg">Select carrier</div>');
		isValid = false;
	}
	if( $('input[name=tracking_no]').val() == '' ) {
		$('input[name=tracking_no]').closest('div').addClass('has-error');
		$('input[name=tracking_no]').closest('div').append('<div class="error-msg">Invalid tracking number</div>');
		isValid = false;
	}
	
	if( ! isValid ) return false;

	$.ajax({
		url: '<?php echo base_url();?>' + 'site/order/addReturnCarrier', 
		method: 'post',
		data: $('input[name=tracking_no], select[name=carrier], input[name=rtn_rma_id]'),
		dataType: 'json',
		success: function(result) {
			if( result.status == 'success' ) {
				$('.return_row.selected').find('div:nth-child(6)').text( $('select[name=carrier]').val() );
				$('.return_row.selected').find('div:nth-child(7)').text( $('input[name=tracking_no]').val() );
			}

			var html = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + result.message + '</div>';
			$( html ).insertBefore('.return_row:last-child').delay(5000).fadeOut();
			$('.return_row.selected').removeClass('selected');
			$('#shipment_info').popup('hide');
		}
	});
	
}

$(document).ready(function() {

	$('#order_popup, #return_popup, #shipment_info').popup({
	  opacity: 0.3,
	  blur: false,
	  escape: false,
	  transition: 'all 0.3s'
	});      // Initialize the plugin

});


function show_return_form( id, obj ) {
	//$(obj).find( $('button[name=btn-return]') ).hide();
	$(obj).hide();
	$('<span sytle="padding:100px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></span>').insertAfter( $(obj) );

	$.ajax({
		url: '<?php echo base_url();?>' + 'site/order/getReturnDetails', 
		method: 'post',
		data:  { 'req_id' : id },
		dataType: 'json',
		success: function(result) {
			//alert( JSON.stringify( result ) );
			//$(obj).hide();
			if ( result.status == 'error' ) {
				alert( result.message );
				return;
			}
			$('#return_popup .container').html( '' );
			$('button[name=btn-rtn-confirm]').show();
			$('textarea[name=rtn_reason]').val('');
			
			$('#rtn-last-date').html( '<br>Prodcut should reach us within 14 days. <br>Last date of return the product is ' + result.rtn_last_date + '<br>' );
			var html = '';
       		html = '<div class="rtn_row row head_row" style="height:40px;"><div >S.No</div><div>IMAGE</div><div class="text-center">Name</div>';
			html += '<div>Quantity</div><div style="text-align:right;" >Amount Paid</div>';
			html += '</div>';
			$('#return_popup .container').append( html );

			var i = 0;
			if ( result.rtn_product.image != null ) images = result.rtn_product.image.split(',');
			var image = '';
			if ( images.length > 0 ) {
				image = 'images/product/' + result.rtn_product.product_id + '/thumb/' + images[0];
			}
			html = '<div class="rtn_row row">';
			html += '<div>' + ( i + 1 ) + '</div>';
			html += '<div class="thumb-image"><image src="' + image  +  '" alt="image" title="product" /></div>';
			html += '<div>'
			html += '<div class="pname" >' + result.rtn_product.name +  '</div>' ;
			html += '<div>' + result.rtn_product.shop_name +  '</div>' ;
			html += '</div>';
			html += '<div class="text-center"><input type="text" class="form-control" name="rtn_qty" value="' + result.rtn_product.quantity +  '" >';
			html += '<input type="hidden" name="order_qty" value="' + result.rtn_product.quantity + '" >';
			html += '<input type="hidden" name="order_product_id" value="' + result.rtn_product.order_product_id + '" >';
			html += '</div>';
			html += '<div>' + parseFloat(result.rtn_product.total).toFixed(2) +  '</div>';
			//html += '<div class="price" >' + line_total.toFixed(2) +  '</div>';
			html += '</div>';
			$('#return_popup .container').append( html );

			$(obj).closest('div').find( $('.fa-spinner') ).remove();
			$('#return_popup').popup('show');
		}
	});

}

function save_return() {
	$('.error_msg').remove();
	var rtn_qty = parseInt( $('input[name=rtn_qty]').val().trim() );
	if ( isNaN( rtn_qty ) || rtn_qty <= 0 || rtn_qty > parseInt( $('input[name=order_qty]').val() ) ) {
		$('<div class="error_msg">Invalid quantity!</div>').insertAfter( $('#return_popup .container .rtn_row:last-child') );
		return false;
	}
	
	$('button[name=btn-rtn-confirm]').hide();
	$('<span sytle="padding:100px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></span>').insertAfter( $('button[name=btn-rtn-confirm]') );
	$.ajax({
		url: '<?php echo base_url();?>' + 'site/order/saveProductReturn', 
		method: 'post',
		data: $('input[name=rtn_qty], textarea[name=rtn_reason], input[name=order_product_id]'),
		dataType: 'json',
		success: function(result) {
			if ( result.status == 'error' ) {
				alert( result.message );
				return;
			}
			$('#return_popup .container').html('');
			$('#return_popup .container').html( result.message );
			$('#return_popup .rtn-content').hide();
		}
	});
	
}

</script>

<?php 
     $this->load->view('site/templates/footer');
?>