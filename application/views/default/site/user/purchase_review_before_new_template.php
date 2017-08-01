<?php 
$this->load->view('site/templates/header');

$this->load->model('product_model');
$this->load->model('user_model');

?>
<script src="<?php echo base_url(); ?>3rdparty/jquery/js/jquery.popupoverlay.js"></script>

<!--<link rel="stylesheet" href="css/default/site/shopsy_style.css" type="text/css" media="all" />-->
<link rel="shortcut icon" type="image/x-icon" href="images/logo/<?php echo $this->data["fevicon"] ?>">

<!-- <script src="'.base_url().'js/html5shiv.js"></script> -->

<style>
select { margin:0px !important; }

#order_popup { width:1020px; background-color:#FFF; /*border:5px solid gray;*/ border-radius:10px; height:auto;  }
#return_popup { width:1020px; background-color:#FFF; /*border:5px solid gray;*/ border-radius:10px; height:auto;  }
.rtn-content { width:90%; margin:auto; padding-bottom:10px; padding-top:10px; }
.action { float: left;cursor:pointer; }
.close-popup { float: right; padding-right: 15px; margin-top: -10px; cursor:pointer; }
.thumb-image { border:0.5px solid #A0A0A4; }

#order_popup .row { margin:0; }
.head1 { font-size:16px; font-weight:600; color:#000; text-align:center; padding-top:20px; padding-bottom:10px; }
.address_box { min-height:100px; border:1px solid #808080 ; width:250px; }
.border1 { border:1px solid  #A0A0A4; }
.box_head { text-align:center; padding: 10px 20px 10px 10px; font-weight:600; color:#000; }
.product_table { width:950px; margin:auto !important; }

.rtn_row { width:100% !important; border-bottom:1px solid #A0A0A4; padding-top:5px; padding-bottom:5px; margin:0; }
.rtn_row div { display:inline-block; width:100%;  float:left;  }
.rtn_row > div:first-child {width:60px; text-align:center } 
.rtn_row > div:nth-child(2) {width:80px; } 
.rtn_row > div:nth-child(3) {width:300px; padding-left:5px; } 
.rtn_row > div:nth-child(4) {width:50px; } 
.rtn_row > div:nth-child(5) {width:100px; text-align:right; } 
.rtn_row > div:nth-child(6) {width:100px; } 
.rtn_row > div:nth-child(7) {width:100px; }

.product_row { width:100% !important; border-bottom:1px solid #A0A0A4; padding-top:5px; padding-bottom:5px; }
.product_row div { display:inline-block; width:100%;  float:left;  }
.product_row > div:first-child {width:60px; text-align:center } 
.product_row > div:nth-child(2) {width:80px; } 
.product_row > div:nth-child(3) {width:500px; padding-left:5px; } 
.product_row > div:nth-child(4) {width:100px; } 
.product_row > div:nth-child(5) {width:100px; } 
.product_row > div:nth-child(6) {width:100px; } 
.product_row > div:nth-child(7) {width:100px; }

.total_row { width:950px; color:#000; font-weight:600; text-align:right;  margin:auto; }
.total_row span { width:120px; text-align:right; float:right; padding-right:30px; }
.product_row:last-child { border-bottom:none; }

.shipped_row { width:100% !important; border-bottom:1px solid #A0A0A4; padding-top:5px; padding-bottom:5px; margin:0; }
.shipped_row div { display:inline-block; width:100%;  float:left;  }
.shipped_row > div:first-child {width:60px; text-align:center } 
.shipped_row > div:nth-child(2) {width:80px; } 
.shipped_row > div:nth-child(3) {width:250px; margin-left:20px; } 
.shipped_row > div:nth-child(4) {width:60px; text-align:center; }  /*qty*/
.shipped_row > div:nth-child(5) {width:80px; text-align:center; }  /* ship date */
.shipped_row > div:nth-child(6) {width:80px; text-align:center; }  /* Deliv. date */
.shipped_row > div:nth-child(7) {width:100px; text-align:center; }  /* carrier */
.shipped_row > div:nth-child(8) {width:150px; }  /* tracking number */
.shipped_row > div:nth-child(9) {width:80px; }  /* Action */

.return_row { width:100% !important; border-bottom:1px solid #A0A0A4; padding-top:5px; padding-bottom:5px; margin:0; }
.return_row div { display:inline-block; width:100%;  float:left;  }
.return_row > div:first-child {width:60px; text-align:center } 
.return_row > div:nth-child(2) {width:80px; } 
.return_row > div:nth-child(3) {width:250px; margin-left:20px; } 
.return_row > div:nth-child(4) {width:60px; text-align:center; }  
.return_row > div:nth-child(5) {width:80px; text-align:center; }  
.return_row > div:nth-child(6) {width:80px; text-align:center; min-width:50px; }  
.return_row > div:nth-child(7) {width:100px; text-align:center; min-width:50px; } 
.return_row > div:nth-child(8) {width:100px; }  /* status */
.return_row > div:nth-child(9) {width:80px; }  /* Action */

.head_row { font-weight:600; color:#000; text-align:center; }

.pname { color:#4D4A4A; }
.price { text-align: right; padding-right: 20px; }
.rtn-message { font-size:16px; color:#F00; text-align:center; padding-bottom:30px; }

#shipment_info { width:300px; background-color:#FFF; /*border:5px solid gray;*/ border-radius:10px; height:auto; color:#000; 
padding-top:10px; padding-bottom:10px; }
.selected { background-color:#FFDF00; }

</style>

<style>
#cboxContent{background:none !important;}

</style>

<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,700,400italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/default/site/base.css" />
<link rel="stylesheet" href="css/default/site/style-menu.css" />
<script>
    $(document).ready(function(){
        $("#nav-mobile").html($("#nav-main").html());
        $("#nav-trigger span").click(function(){
            if ($("nav#nav-mobile ul").hasClass("expanded")) {
                $("nav#nav-mobile ul.expanded").removeClass("expanded").slideUp(250);
                $(this).removeClass("open");
            } else {
                $("nav#nav-mobile ul").addClass("expanded").slideDown(250);
                $(this).addClass("open");
            }
        });
    });
</script>
<?php if(isset($active_theme) && $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>User-Profile-page.css" rel="stylesheet">
<?php }?>

<div class="add_steps shop-menu-list">

			<div class="main">
				<div id="nav-trigger">
					<span>Menu</span>
				</div>
				<nav id="nav-main">
                    <ul id="panel" class="add_steps" style="background:none; box-shadow:none;">
                        <li>
                            <a href="purchase-review">Orders</a>
                        </li>
                        <li>
                             <a href="settings/my-account/<?=$this->session->userdata['shopsy_session_user_name']?>">Settings</a>
                        </li>
                        <li>
                             <a href="public-profile">Public Profile</a>
                        </li>
                    </ul>
  				</nav>
                
        		<nav id="nav-mobile"></nav>
			</div>
			
</div>

<div id="profile_div">
	<section class="browse-head">
	<div class="container">
        <ul class="bread_crumbs">
                    <li><a href="<?php echo base_url(); ?>" class="a_links">Home</a></li>
                    <span>&rsaquo;</span>
                   <li><a href="view-profile/<?php echo $this->session->userdata['shopsy_session_user_name'];?>" class="a_links"><?php echo $this->session->userdata['shopsy_session_user_name'];?></a></li>
                   <span>&rsaquo;</span>
                   <li>Purchases & Reviews</li>
        </ul>

        <div class="">
            <div id="header_menu" class="content-wrap-inner clear ">
                <div class="col col4">
                    <h1>Orders</h1>
                </div>
            </div>
        </div>
   </div>    
<!-- purchases and Review -->        
<!--</header>-->
	</section>

<section class="container">
<!-- header_end -->
<!-- section_start -->
<div class="purchase_review container community_right">    	
    <div class="main">    
            <div class="all-purchase-search">
                    <div style="display:inline-block; float:left;">
                        <ul class="secondary-tabs clear">
                            <li class="first"><a class="active" href="purchase-review" >New Orders</a></li>
                            <li><a href="javascript:;" onclick="show_shipped();">Shipped</a></li>
                            <li><a href="javascript:;" onclick="show_completed();">Completed</a></li>
                            <li><a href="javascript:;" onclick="show_returns();">Returns</a></li>
                        </ul>
                    </div>
                    <div class="purchase-search">
                        <div class="review-search-bar">
                        <form method="get" action="purchase-review">
                        	<input type="text" placeholder="Order Number" name="query" id="query" value="<?php echo $this->input->get('query'); ?>" >
                        </form>
                        </div>
                    </div>
             </div>
           <div id="result_content" >
           <?php if( count( $orders ) > 0 ) { ?>
			   <table width="100%">
               		<tr>
                    <th>S. No</th>
                    <th>Order #</th>
                    <th>Order Date</th>
                    <th>Ship To</th>
                    <th>Order Total</th>
                    <th>Order Status</th>
                    <th>Action</th>
                    </tr>
			<?php $i=1;
				  foreach ( $orders as $key => $order ) : ?>
            		<tr>
                    	<td><?php echo $i; ?></td>
                    	<td><?php echo $order['order_id']; ?></td>
                    	<td><?php echo date('m-d-Y', strtotime($order['date_added']) ); ?></td>
                    	<td><?php echo $order['shipping_firstname']; ?></td>
                    	<td><?php echo number_format( $order['total'], 2); ?></td>
                        <td><?php echo ($order['order_status_id'] == 0 ? 'Unpaid' : $order['order_status_name']); ?></td>
                        <td class="action"><a href="javascript:;" onclick="show_order('<?php echo $order['order_id']; ?>')"><i class="fa fa-eye fa-lg"></i></a></td>
                    </tr>
            <?php $i++; endforeach; ?>
               </table>
           <?php } else { ?>
       				<h3><b>No Purchases? No Problem!</b></h3>
           <?php } ?>
           </div>
     
	</div> 
</div>
</section>

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
	$('ul.secondary-tabs li a').removeClass('active');
	$('ul.secondary-tabs li:eq(1) a').addClass('active');
	$('#result_content').html('<div style="padding:100px;width:100px; margin:auto;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');

	$.ajax({
		url: '<?php echo base_url();?>' + 'site/order/getShippedOrder', 
		method: 'post',
		//data: ,
		dataType: 'json',
		success: function(result) {
			//alert( JSON.stringify( result ) );
			var html = '';
			var i=0;
			$('#result_content').html('');
			html = '<div class="shipped_row row head_row">';
			html += '<div>S.No</div>';
			html += '<div>Image</div>';
			html += '<div>Product</div>';
			html += '<div>Quantity</div>';
			html += '<div>Ship Date</div>';
			html += '<div>Delivery Date</div>';
			html += '<div>Carrier</div>';
			html += '<div>Tracking #</div>';
			html += '<div>Action</div>';
			html += '</div>';
			$('#result_content').append( html );
			for( i=0; i < result.shipments.length; i++ ) {
				var images;
				var ship_date = result.shipments[i].ship_date.split('-');
				var order_id  = result.shipments[i].store_order_id.split('-');
				if ( result.shipments[i].image != null ) images = result.shipments[i].image.split(',');
				var image = '';
				if ( images.length > 0 ) {
					image = 'images/product/' + result.shipments[i].product_id + '/thumb/' + images[0];
				}
				html = '<div class="shipped_row row">';
				html += '<div>' + ( i + 1 ) + '</div>';
				html += '<div class="thumb-image"><image src="' + image  +  '" alt="image" title="product" /></div>';
				html += '<div>'
				html += '<div class="" >' + result.shipments[i].name +  '</div>' ;
				html += '<div>' + result.shipments[i].shop_name +  '</div>' ;
				html += '</div>';
				html += '<div>' + result.shipments[i].quantity +  '</div>';
				html += '<div>' + ship_date[1] + '/' + ship_date[2] + '/' + ship_date[0] +  '</div>';
				html += '<div>' + result.shipments[i].carrier +  '</div>';
				html += '<div>' + result.shipments[i].tracking_no +  '</div>';
				html += '<div class="action"><a href="javascript:;" onclick="show_order(\'' + order_id + '\')"><i class="fa fa-eye fa-lg"></i></a>';
				html += '</div>';
				$('#result_content').append( html );
			}

		}
	});

}

function show_completed() {
	$('ul.secondary-tabs li a').removeClass('active');
	$('ul.secondary-tabs li:eq(2) a').addClass('active');
	$('#result_content').html('<div style="padding:100px;width:100px; margin:auto;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');

	$.ajax({
		url: '<?php echo base_url();?>' + 'site/order/getCompletedOrder', 
		method: 'post',
		//data: ,
		dataType: 'json',
		success: function(result) {
			//alert( JSON.stringify( result ) );
			var html = '';
			var i=0;
			$('#result_content').html('');
			$('#return_popup .rtn-content').show();
			$('#return_popup .fa-spin').remove();
			
			html = '<div class="shipped_row row head_row">';
			html += '<div>S.No</div>';
			html += '<div>Image</div>';
			html += '<div>Product</div>';
			html += '<div>Quantity</div>';
			html += '<div>Ship Date</div>';
			html += '<div>Delivery Date</div>';
			html += '<div>Carrier</div>';
			html += '<div>Tracking #</div>';
			html += '<div>Action</div>';
			html += '</div>';
			$('#result_content').append( html );
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
				html = '<div class="shipped_row row">';
				html += '<div>' + ( i + 1 ) + '</div>';
				html += '<div class="thumb-image"><image src="' + image  +  '" alt="image" title="product" /></div>';
				html += '<div>'
				html += '<div class="" >' + result.shipments[i].name +  '</div>' ;
				html += '<div>' + result.shipments[i].shop_name +  '</div>' ;
				html += '</div>';
				html += '<div>' + result.shipments[i].quantity +  '</div>';
				html += '<div>' + ship_date[1] + '/' + ship_date[2] + '/' + ship_date[0] +  '</div>';
				html += '<div>' + delivery_date[1] + '/' + delivery_date[2] + '/' + delivery_date[0] +  '</div>';
				html += '<div>' + result.shipments[i].carrier +  '</div>';
				html += '<div>' + result.shipments[i].tracking_no +  '</div>';

				html += '<div class="action">';
				html += '<div style="padding-left:25px;"><a href="javascript:;" onclick="show_order(\'' + order_id[0] + '\')"><i class="fa fa-eye fa-lg"></i></a></div>';
				if( parseInt(result.shipments[i].days) < 15 ) {
					html += '<div><a href="javascript:;" onclick="show_return_form('+ result.shipments[i].order_product_id +', this )"><button type="button" name="btn-return" class="btn btn-info">Return</button></div>';
				}
				
				html += '</div>';
				
				html += '</div>';
				$('#result_content').append( html );
			}

		}
	});

}

function show_returns() {
	$('ul.secondary-tabs li a').removeClass('active');
	$('ul.secondary-tabs li:eq(3) a').addClass('active');
	$('#result_content').html('<div style="padding:100px;width:100px; margin:auto;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');

	$.ajax({
		url: '<?php echo base_url();?>' + 'site/order/getOrderReturns', 
		method: 'post',
		//data: ,
		dataType: 'json',
		success: function(result) {
			var html = '';
			var i=0;
			$('#result_content').html('');
			
			html = '<div class="return_row row head_row">';
			html += '<div>S.No</div>';
			html += '<div>Image</div>';
			html += '<div>Product</div>';
			html += '<div>Quantity</div>';
			html += '<div>Return Date</div>';
			html += '<div>Carrier</div>';
			html += '<div>Tracking #</div>';
			html += '<div>Status</div>';
			html += '<div>Action</div>';
			html += '</div>';
			$('#result_content').append( html );
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

				html = '<div class="return_row row">';
				html += '<div>' + ( i + 1 ) + '<input type="hidden" name="rma_id[]" value="' + result.returns[i].rma_id + '" ></div>';
				html += '<div class="thumb-image"><image src="' + image  +  '" alt="image" title="product" /></div>';
				html += '<div>'
				html += '<div class="" >' + result.returns[i].name +  '</div>' ;
				//html += '<div>' + result.shipments[i].shop_name +  '</div>' ;
				html += '</div>';
				html += '<div>' + result.returns[i].quantity +  '</div>';
				html += '<div>' + result.returns[i].rtn_date +  '</div>';
				html += '<div>' + carrier +  '</div>';
				html += '<div>' + tracking_no +  '</div>';
				html += '<div>' + result.returns[i].return_status_name +  '</div>';

				html += '<div class="action">';
				html += '<div style="padding-left:25px;"><a href="javascript:;" onclick="show_order(\'' + result.returns[i].order_id + '\')"><i class="fa fa-eye fa-lg"></i></a></div>';
				if ( result.returns[i].return_tracking_no == '' && result.returns[i].return_carrier == '' ) {
					html += '<button class="btn btn-info" name="btn-add-track" onclick="addShipment( this );" style="padding-left:10px;">Add Carrier</button>';
				}
				html += '</div>';
				
				html += '</div>';
				$('#result_content').append( html );
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