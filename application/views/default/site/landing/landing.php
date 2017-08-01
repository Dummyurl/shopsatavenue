<?php $this->load->view('site/templates/commonheader'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>css/product-detail.css" type="text/css" >

<script type="text/javascript" >
	var baseURL = '<?php echo base_url(); ?>';
	var loadingProduct = false;
// $(document).ready(function(e) {
// });

</script>
<style>
#close{
    display:block;
    float:right;
    width:30px;
    height:29px;
	position: relative;
	top: 11.5%;
	left: -7.6%;
	z-index: 3000;
	color:#fff;
}

#product-modal .modal-dialog {
width:80% !important; margin:0 auto;overflow-y: scroll; overflow-x:hidden;   max-height:85%; margin-top: 72px; margin-bottom:50px;
border-radius:0px;
}

</style>
<?php $this->load->view('site/templates/header2'); ?>

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
	<section class="pricing" >
    
			<div class="row">
				<div class="pricing-wrapper">
				<?php 
                    if(!empty($product_list)) { 
                        $i=0;
                        foreach( $product_list as $proddetails ) {
                        $imgSplit = explode(",",$proddetails['image']); 
                        $shopDet = $this->product_model->get_business_name($proddetails['user_id']);
                        if( ! empty($imgSplit[0]) ) { 
                            $image = 'images/product/' . $proddetails['id'] . '/mb/thumb/' . stripslashes($imgSplit[0]); 
                        } else { 
                            $image = "images/noimage.jpg";  
                        }
                ?>
					<div class="col-md-3 col-sm-6" >
						<div class="pricing-table" >
							<div class="pricing-img">
                                <a href="products/<?php echo $proddetails['seourl'];?>" class="image" ><img src="<?php echo $image; ?>" alt="" /></a>
							</div>
							<h5 style="margin-top:10px;"><?php echo $proddetails['product_name']?></h5>
							<p style="margin-top:10px;"><?php echo ($proddetails['price'] != 0.00) ? '$' . number_format($proddetails['price'],2) : '$' . number_format($proddetails['base_price'],2) . '+';?></p>
							<button type="submit" style="margin-top:12px;" class="button" onclick="show_product('<?php echo $proddetails['seourl'];?>', this);">
                            <i class="fa fa-shopping-cart" style="padding-right:10px;"></i>Add to Cart
                            </button>

                            <a href="javascript:;" onclick="<?php echo $loginCheck != '' ? 'addFavoriteItem(this)' : "$('#login-popup').modal('show')"; ?>" class="inline-heart_home is-unloved" data-id="<?php echo base64_encode($proddetails['id']);?>" >
                            <span class="inline-heart-hover">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                            </span>
                        	</a>

						</div><!-- pricing-table -->
					</div>


				<?php $i++; if($i%4==0){ echo "<div style='clear:both'></div>"; } } //endforeach; ?>
                <?php } ?>
				</div><!-- pricing-wrapper -->
			</div>

               <div class="dish-btn" style="margin-bottom:20px;" >
                    <form name="form-load-products" id="form-load-products" action="" method="post" >
                       <input type="hidden" name="page_no" value="<?php echo ($page_no+1);?>"  >
                       <input type="hidden" name="total_pages" value="<?php echo $total_pages;?>" >
                       <button type="submit" name="btn-submit" value="submit" class="button" >Shop More Products</button>
                    </form>
               </div>
            

	</section>

<div class="modal fade product_large_modal" id="product-modal" tabindex="-1" role="dialog" aria-labelledby="ProductModalLabel"  >
  <a id="close" href="javascript:;" data-dismiss="modal" aria-hidden="true" ><i class="fa fa-window-close fa-2x"></i></a>
  <div class="modal-dialog modal-lg" role="document">
  
    <div class="modal-content">
      <div class="modal-body">
        
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="login-popup" tabindex="-1" role="dialog" aria-labelledby="loginPopupLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 300px;" >
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="loginPopupLabel">Log in</h4>
			</div> <!-- /.modal-header -->

			<div class="modal-body">
				<form role="form">
					<div class="form-group  has-feedback">
							<input type="text" class="form-control" name="emailAddr" id="emailAddr" placeholder="Email address">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div> <!-- /.form-group -->

					<div class="form-group  has-feedback">
							<input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div> <!-- /.form-group -->

					<div class="checkbox">
						<label>
							<input type="checkbox" name="stay_signed_in" value="1" > Stay Signed In
						</label>
					</div> <!-- /.checkbox -->
				</form>

			</div> <!-- /.modal-body -->

			<div class="modal-footer">
				<button class="btn btn-small btn-primary" name="btn-login" onclick="ajaxLogin();">Login</button>

				<div class="progress">
					<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="100" style="width: 0%;">
						<span class="sr-only">progress</span>
					</div>
				</div>
			</div> <!-- /.modal-footer -->

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>
<!-- container -->
            

<script type="text/javascript">

function addFavoriteItem( obj ) {
	//alert( $(obj).closest('div').data('seller-id') );
	if ( $(obj).hasClass( 'is-unloved' ) ) {
		$.ajax({
			type: 'POST',
			url: baseURL+'site/user/addMyLikes',
			data: { 'data_id' : $(obj).data("id") },
			dataType: 'json',
			success: function(response){
				if( response.status == 'success' ) {
					$( obj ).removeClass('is-unloved');
					$( obj ).addClass('is-loved');
				}
				alert( response.message );
			}
		});
	} else {
		$.ajax({
			type: 'POST',
			url: baseURL+'site/user/removeMyLikes',
			data: { 'data_id' : $(obj).data("id") },
			dataType: 'json',
			success: function(response){
				if( response.status == 'success' ) {
					$( obj ).removeClass('is-loved');
					$( obj ).addClass('is-unloved');
				}
				alert( response.message );
			}
		});
	}
	
}
function ajax_add_cart_new() {

	$('.error-msg').remove();
//alert('GV:ok');	
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
				} else if(arr[0] == 'Error'){
					if($.isNumeric(arr[1])==true){
						$('#ADDCartErr').html('<font color="red">Maximum Purchase Quantity: '+mqty+'. Already in your cart: '+arr[1]+'.</font>');
					}else{
						$('#ADDCartErr').html('<font color="red">'+arr[1]+'.</font>');
					}					
						$('#ADDCartErr').show().delay('2000').fadeOut();
				}else{
					//alert(arr[1]);
					$('#cartCount').html(arr[1]);
					//$('#product_add_cart').trigger('click');
				}
		
			}
		});
		return false;
		
}

</script>
	

<?php $this->load->view('site/templates/footer');?>

                        
<script type="text/javascript" src="js/zoom/jquery.imagezoom.min.js"></script>
<script type="text/javascript" src="js/zoom/modernizr.custom.17475.js"></script>
<script type="text/javascript" src="js/zoom/jquery.elastislide.pop.js"></script>

<script>

$( document ).on( 'click', ".price_info span i",  function () {
	$('#price_details').slideToggle();
	if ( $('.price_info span i').hasClass('fa-angle-double-down') ) {
			$('.price_info span i').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
		} else {
			$('.price_info span i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
		}
	} );   


$('#product-modal').on('shown.bs.modal', function() {
});

$('#login-popup').on('shown.bs.modal', function (e) {

	var inputs = $('form input');
	var title = $('.modal-title');
	var progressBar = $('.progress-bar');
	var button = $('.modal-footer button');

	$('#login-popup .has-error').removeClass('has-error');
	inputs.removeAttr("disabled");

	title.text("Log in");

	progressBar.css({ "width" : "0%" });

	button.removeClass("btn-success")
			.addClass("btn-primary")
			.text("Login")
			.removeAttr("data-dismiss");
			
});

function ajaxLogin() {
	var isValid = true;
	$('#login-popup .has-error').removeClass('has-error');

	if( $('input[name=emailAddr]').val().trim() == '' ) {
		$('input[name=emailAddr]').closest('div').addClass('has-error');
		isValid = false;
	}
	if( $('input[name=password]').val().trim() == '' ) {
		$('input[name=password]').closest('div').addClass('has-error');
		isValid = false;
	}
	if ( ! isValid ) return false;
		
	var button = $('button[name=btn-login]');
	var inputs = $('form input');
	var progress = $('.progress');
	var progressBar = $('.progress-bar');

	inputs.attr("disabled", "disabled");

	button.hide();

	progress.show();

	progressBar.animate({width : "100%"}, 100);
	//progress.delay(1000)
			//.fadeOut(600);

	$.ajax({
		type: 'POST',
		url: 'site/user/ajaxUserLogin', 
		data: $('#login-popup input'),
		dataType: 'json',
		success: function(result) {
			if( result.status == 'success' ) {
				$('a.inline-heart_home').attr('onclick', 'addFavoriteItem(this)');
				if ( result.hasOwnProperty('menu') ) {
					$('.book-table:first-child').closest('div').html( result.menu );
				}
				$('#login-popup').modal('hide');

			} else {
				alert( result.message );
			}
		}
	});
	
}

function show_product( product_url, obj ) {

	$.ajax({
		url: 'products/ajax/' + product_url, 
		success: function(result){
			$(".product_large_modal .modal-body").html( result );

				$('.product_large_modal').modal();

				var a = $('#product_img_slider_carusel').elastislide({
					        start: 0,
					        maxItems: 3,
					        onClick: function(c, d, e) {

					            c.siblings().removeClass("active");
					            c.addClass("active");
					           
					            var f = $('#product_img_slider').data('imagezoom');
					            f.changeImage(c.find('img').attr('src'), c.find('img').data('largeimg'));
					             e.preventDefault();

					             return false; 

					        },
					        onReady: function() {


					            $('#product_img_slider').ImageZoom();
					            $('#product_img_slider_carusel li:eq(0)').click();
					            $('#product_img_slider_carusel li:eq(0)').addClass('active')
					        }

				});


				$(".tab-link").on( 'click', function (event) {
						$('.tab-link').removeClass('current');
						$(this).addClass('current');
						var id = $(this).attr("data-tab");
						$(".tab-content").removeClass("current");

						$("#"+id+"").addClass("current");
						event.preventDefault();
					    	
				});


		}
	});
}

$(window).scroll(function() {   
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
		if( ! loadingProduct ) { 
			$('.pricing-wrapper').append( '<div class="col-md-12 text-center" style="padding-bottom:20px;" ><i class="fa fa-spin fa-spinner fa-3x"></i></div>' );
			$.ajax({
				type: 'POST',
				url: 'site/product/ajax_load_more',
				data: $('#form-load-products').serialize(),
				dataType: 'json',
				success: function ( res )
				{
					if (res.status === 'success')
					{
						var i =0;
						var html = '';
						var products = res.product_list;
						for(var i=0; i < res.product_list.length; i++ ) {
                        	var imgString = products[i].image;
							var images = imgString.split(',');
                        	if( images[0] != '' ) { 
                            	image = 'images/product/' + products[i].id + '/mb/thumb/' + images[0]; 
                        	} else { 
                            	image = "images/noimage.jpg";  
                        	}
							var price = parseFloat(products[i].price);
							if ( price != 0.00 ) {
								 price = '$' + price.toFixed(2);
							} else {
								 price = '$' + ( products[i].base_price ).toFixed(2) + ' +';
							}

							html += '<div class="col-md-3 col-sm-6" ><div class="pricing-table" >';
							html +=	'<div class="pricing-img">';
							html +=	'<a href="products/' + products[i].seourl +'" class="image" ><img src="' + image +'" alt="" /></a>';
							html +=	'</div>';
							html +=	'<h5 style="margin-top:10px;">' + products[i].product_name + '</h5>';
							html +=	'<p style="margin-top:10px;">' + price + '</p>';
							html +=	'<button type="submit" style="margin-top:12px;" class="button" onclick="show_product(\''+ products[i].seourl +'\', this);">';
							html +=	'<i class="fa fa-shopping-cart" style="padding-right:10px;"></i>Add to Cart</button>';
							html += '<a href="javascript:;" onclick="addFavoriteItem(this);" class="inline-heart_home is-unloved" data-id="' + products[i].id + '" >';
							html += '<span class="inline-heart-hover"><i class="fa fa-heart-o" aria-hidden="true"></i></span></a>';
							html += '</div></div>';
						}
						$('.fa-spinner').remove();
						$('.pricing-wrapper').append( html );
						var page_no = parseInt( res.page_no ) + 1;
						$('#form-load-products input[name=page_no]').val( page_no );
						$('#form-load-products input[name=total_pages]').val( res.total_pages );
						loadingProduct = true;
					}
				},
				error: function (error)
				{
					console.log(error.statusText);
					//alert("Exception thrown : " + error.statusText );
				}
			});

		}
   }

});

</script>


