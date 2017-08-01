<footer>
		<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="footer-widget-wrapper">
							<div class="col-md-3 col-sm-6">
								<div class="footer-widget">
									<h2 class="footer-widget-title">Turn Your Passion Into Biz.</h2>
									 <ul class="unstyled">
                        				<li><a href="site/shop/plans">Open a Shop</a></li>
                        			 </ul>
								 </div><!-- footer-widget -->
							</div>
							<div class="col-md-3 col-sm-6">
								<div class="footer-widget">
									<h2 class="footer-widget-title">Get to Know Us</h2>
									<ul class="unstyled">
                        				 <li><a href="pages/about-us">About Us</a></li>
                       					 <li><a href="pages/contact-us">Contact</a></li>
                       					 <li><a href="#">Press</a></li>
                       				</ul>
								</div><!-- footer-widget -->
							</div>
							<div class="col-md-2 col-sm-6">
								<div class="footer-widget">
									<h2 class="footer-widget-title">Policy</h2>
                                     <ul class="unstyled">
                        				<li><a href="pages/privacy-policy">Privacy Policy</a></li>
                        				<li><a href="pages/shipping-policy">Shipping Policy</a></li>
                        				<li><a href="pages/return-policy">Return Policy</a></li>
                        				<li><a href="#">Terms of Use</a></li>
                    				 </ul>
								</div><!-- footer-widget -->
							</div>
							<div class="col-md-2 col-sm-6">
								<div class="footer-widget">
									<h2 class="footer-widget-title">Account</h2>
									<ul class="unstyled">
                     					<li><a href="signup">SIGN UP</a></li>
                     					<li><a href="#">Account Overview</a></li>
                        				<li><a href="#">My Orders</a></li>
                        				<li><a href="#">My Favorites</a></li>
                        				<li><a href="#">Shipping & Billing</a></li>
                    				</ul>
								</div><!-- footer-widget -->
							</div>
                            
                            <div class="col-md-2 col-sm-6">
								<div class="footer-widget">
									<h2 class="footer-widget-title">Follow Us</h2>
									<div class="social-profiles">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                            <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                            <li><a href="#"><i class="fa fa-vimeo-square"></i></a></li>
                                        </ul>
									</div>
                                    <div><a href="#">BLOG</a></div>
								</div><!-- footer-widget -->
							</div>
						</div><!-- footer-widget-wrapper -->
					</div>
				</div><!-- container -->
		</div><!-- footer-top -->
		<!--Scroll top-->
		<div class="scroll-top">
			<i class="fa fa-angle-up"></i>
		</div>
		<div class="footer-bottom">
        	<div class="container">
			<div class="row">
			<p style="text-align:center;">Copyright © 2017 Shopsatavenue.com</p>
            </div>
            </div>
		</div><!-- footer-bottom -->
</footer><!-- Footer End-->

	<script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-2.1.3.min.js"></script>


<!--<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>-->
<script type="text/javascript" src="js/zoom/jquery.imagezoom.min.js"></script>
<script type="text/javascript" src="js/zoom/modernizr.custom.17475.js"></script>
<script type="text/javascript" src="js/zoom/jquery.elastislide.js"></script>


<script type="text/javascript">
$(function() {
    var a = $('#product_img_slider_carusel').elastislide({
        start: 0,
        minItems: 3,
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
  
  
    
    	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})

});



</script>

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
			        alert( response.message);
				} else {
			        alert( response.message);
				}
				
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
          $('#cart-total-qty').html(arr[1]);
          location = 'placeOrder';
          //$('#product_add_cart').trigger('click');
        }
    
      }
    });
    return false;
    
}
</script>

<script type="text/javascript">
  $( document ).on( 'click', ".price-block span i",  function () {
    $('#price_details').slideToggle();
    if ( $('.price-block span i').hasClass('fa-angle-double-down') ) {
      $('.price-block span i').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
    } else {
      $('.price-block span i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
    }
  });
  
  function show_tab( tab, obj ) {
    $('.product-desc-tab li.active').removeClass('active');
    $( obj ).closest('li').addClass('active');
    $('.product-desc-tab .tab-content .tab-pane').removeClass('active');
    $( '#' + tab ).addClass('active');
  }


  function addFavourite(id)
  {
      $.ajax({
          type: "GET",
          url: "<?php echo base_url(); ?>" + "json/favorite/add-remove",
          dataType: 'json',
          data: {type: "product", mode:"",id :id },
          success: function(res) {
			  if (res)
			  {
					console.log(res);
			  }
          }
      });
  }
  
</script>	

</body>
</html>