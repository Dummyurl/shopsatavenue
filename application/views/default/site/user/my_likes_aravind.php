<?php $this->load->view('site/templates/header'); ?>
<style>
	.footerseperator
	{
		width: 100%;
		height: 60px;
		clear: both;
	}

	#order_popup { width:80%; background-color:#FFF; /*border:5px solid gray;*/ border-radius:10px; height:auto;  }
.head1 { font-size:16px; font-weight:600; color:#000; text-align:center; padding-top:20px; padding-bottom:10px; }
.close-popup { float: right; padding-right: 15px; margin-top: -10px; cursor:pointer; }

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

.product_table { width:950px; margin:auto !important; }
.pname { color:#4D4A4A; }
.price { text-align: right; padding-right: 20px; }
.rtn-message { font-size:16px; color:#F00; text-align:center; padding-bottom:30px; }

#shipment_info { width:300px; background-color:#FFF; /*border:5px solid gray;*/ border-radius:10px; height:auto; color:#000; 
padding-top:10px; padding-bottom:10px; }
.selected { background-color:#FFDF00; }

ul.nav.tabs { display:inline-block; }
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
.tabs li{
	display:inline-block;
}
ul.nav.tabs {
    text-align: center;
	margin-bottom: 1em;
}
.tabs li a {
    font-size: 1em;
    color: #8A8A8A;
    padding: 16px 17px !important;
    display: inline-block;
}

.tabs  li.active {
	border-bottom: 2px solid #000
}
.nav > li > a:hover, .nav > li > a:focus {
    background: none;
}

.tab-content-t {
    padding: 1em !important;
}


.sec-title
{
	margin-bottom: 30px;
}

</style>

<link rel="stylesheet" href="<?php echo base_url();?>css/product-detail.css" type="text/css" >



<?php $this->load->view('site/templates/user_menu'); ?>

<?php 
	$this->load->model('user_model');
	$this->load->model('product_model');

	$c_url=current_url();  
	
	if($this->input->get('item') != ''){
	$s_key='item='.$this->input->get('item');;
	} else { $s_key ='';}
	
   if($this->input->get('order') != ''){
	   $order='&order='.$this->input->get('order');
	   $orderVal=$this->input->get('order');
   } else {
	   $order=''; $orderVal='';
   }
 ?>
	<div class="container">
	  <div class="row">
            <div class="col-lg-12 col-md-12">
                
                    <div class="sec-title pdb-50">
                        <h3>My Likes</h3>
                        <span class="border"></span>
                    </div>

                    <div class="tab-content tab-content-t " style="background-color:#efefef;">
				<div class="tab-pane active text-style" id="result_content"  >
						<div class="con-w3l">
                           	<section id="responsive">
  <table class="table table-bordered table-striped">

                    <thead>
      <tr>
        <th>#</th>
        <th>Product Image</th>
        <th>Product Title</th>
        <th>Price</th>
        <th>Action</th>
      
      </tr>
    </thead>
    <tbody>


				<?php 
                    if(!empty($product_list)) { 
                        $i=0;
                        foreach( $product_list as $proddetails ) {
                        $imgSplit = explode(",",$proddetails['image']); 
                     
                        if( ! empty($imgSplit[0]) ) { 
                            $image = 'images/product/' . $proddetails['id'] . '/mb/thumb/' . stripslashes($imgSplit[0]); 
                        } else { 
                            $image = "images/noimage.jpg";  
                        }
                ?>


				


					<tr>
				    	<td>
				    	<?php 
				    	echo $key+1;
				    	?>
				    	</td>
				    	<td>
				    	<?php 
				    	 $imgSplit = explode(",",$proddetails['image']); 
				                        
				                        if( ! empty($imgSplit[0]) ) { 
				                            $image = 'images/product/' . $proddetails['id'] . '/mb/thumb/' . stripslashes($imgSplit[0]); 
				                        } else { 
				                            $image = "images/noimage.jpg";  
				                        }
				                        ?>
				                        <img src='<?php echo  $image;?>' style="width:100px"/>
				    	</td>
				    	<td>
				    	<?php 
				    	echo $proddetails['product_name'];
				    	?>
				    	</td>
				    	<td>
				    	<?php 
				    	echo "$ ".number_format($proddetails['price'],2);
				    	?>
				    	</td>
				    
				    <td class="tabelcls">
				    	<input type="button" value="Unlike" onclick="addFavourite('<?php echo $proddetails['id'];?>')">
				    	</td>
				    
				    	</tr>

				<?php $i++; } //endforeach; ?>
                <?php } ?>

                </tbody>
                </table>

                </section>
                </div>
                </div>
                </div>

				</div><!-- pricing-wrapper -->
			</div>

               
<div class="footerseperator"></div>
	

<!-- popup prdduct modal -->
  
	</div>
    <!-- container -->
            
	



<?php $this->load->view('site/templates/footer');?>


<script>

$( document ).on( 'click', ".price_info span i",  function () {
		$('#price_details').slideToggle();
		if ( $('.price_info span i').hasClass('fa-angle-double-down') ) {
			$('.price_info span i').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
		} else {
			$('.price_info span i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
		}
	} );   


//$( "#close-product-detail-modal" ).click(function() {
//$('#close-product-detail-modal').on('click', function() {
  //$('#product_modal').modal('hide');
//});

function show_product( product_url, obj ) {

	//$('#product_modal').modal('show');

	/*$('#spinner').show();*/
	$.ajax({
		url: 'products/ajax/' + product_url, 
		success: function(result){
			$("#product_modal .modal-content #product-popup").html( result );
			//$('#spinner').hide();
			alert( result );
			$('#product_modal').modal('show');
		}
	});
}

</script>

<script type="text/javascript">

function addFavoriteItem( obj ) {
	//alert( $(obj).closest('div').data('seller-id') );
	$( obj ).removeClass('is-unloved');
}
function ajax_add_cart_new() {

	$('.error-msg').remove();
	
	if( $('input[type=radio][name=var_color_1]').length > 0 && $('input[type=radio][name=var_color_1]:checked').length == 0 ) {
		$('#color_wrapper').append('<div class="error-msg">Select Color</div>');
		return false;
	}
	var data = $('select[name=quantity], #product_id, #seller_id, #price ').add('input[type=radio][name=var_color_1]:checked' );

		$.ajax({
			type: 'POST',
			url: baseURL+'site/cart/userAddToCart',
			data: $( data ).serialize() + "&mqty=" + $('#quantity_list').data('mqty') + "&shop_name=<?php echo $selectedSeller_details[0]['seller_businessname'];?>" ,
			success: function(response){
				var arr = response.split('|');
				if(arr[0] =='login'){
					window.location.href= baseURL+"login";	
				}else if(arr[0] == 'Error'){
					if($.isNumeric(arr[1])==true){
						$('#ADDCartErr').html('<font color="red">Maximum Purchase Quantity: '+mqty+'. Already in your cart: '+arr[1]+'.</font>');
					}else{
						$('#ADDCartErr').html('<font color="red">'+arr[1]+'.</font>');
					}					
						$('#ADDCartErr').show().delay('2000').fadeOut();
				}else{
					//alert(arr[1]);
					$('#CartCount').html(arr[1]);
					$('.CartCount1').html(arr[1]);
					$('#product_add_cart').trigger('click');
				}
		
			}
		});
		return false;
		
}

  function addFavourite(id)
  {



  	
      $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "site/user/removemyLikes",
          dataType: 'json',
          data: {id :id },
          success: function(res) {
          if (res)
          {

        		window.location.reload();

        

       



          }
          }
          });
  }
</script>