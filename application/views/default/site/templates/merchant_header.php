<?php 
$this->load->view('site/templates/commonheader');
$this->load->model('user_model');
$home = false;
$marketing = false;
$orders = false;
$products = false;
$account = false;

if( $this->uri->segment(1,'') === 'merchant-home' ) {
	$home = true;
}else
if ( $this->uri->segment(3,'') === 'sales_setting' ) {  
	$marketing = true; 
}elseif ( $this->uri->segment(2,'') === 'promotions' ) {  
	$marketing = true; 
}else
if ( $this->uri->segment(2,'') === 'shop-orders' ) {  
	$orders = true; 
}elseif( $this->uri->segment(1,'') === 'merchant-shipstation' ) {
	$orders = true; 
}else
if( $this->uri->segment(2, '') === 'managelistings'  ) {
	$products = true;
}elseif ( in_array( $this->uri->segment(1, ''), array(  'product-setup', 'import-items', 'product-import-history' ) ) ) {
	$products = true;
}else
if( $this->uri->segment(3, '') === 'bizinfo' ) {
	$account = true;
}elseif( in_array( $this->uri->segment(1, ''), array('merchant-billing','merchant-plan','merchant-payments','merchant-penaltys','merchant-support','merchant-help') ) ){
	$account = true;
}
 
?>
<!--<link href='css/merchant-menu.css' rel='stylesheet' type='text/css'>-->
<link href='http://fonts.googleapis.com/css?family=Raleway:400,600,900' rel='stylesheet' type='text/css'>
<style>
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

 .navbar-inverse .navbar-nav > li  > a { color:#fff; }

</style>
</head>
 		<?php
				//if($this->session->flashdata('sErrMSG') != '') { ?>
                <!--<div class="errorContainer" id="<?php //echo $this->session->flashdata('sErrMSGType'); ?>">
                  <script>setTimeout("hideErrDiv('<?php //echo $this->session->flashdata('sErrMSGType'); ?>')", 5000);</script>
                  <p><span> <?php //echo $this->session->flashdata('sErrMSG');  ?> </span></p>
                </div>-->
   		 <?php //} ?>
<body>

	<!-- Header -->
 		<?php if($this->session->flashdata('sErrMSG') != '') { ?>
                <div class="errorContainer logoutdiv alert alert-success text-center" id="<?php echo $this->session->flashdata('sErrMSGType'); ?>">
                  <script>setTimeout("hideErrDiv('<?php echo $this->session->flashdata('sErrMSGType'); ?>')", 5000);</script>
                  <p><span><?php echo $this->session->flashdata('sErrMSG');  ?> </span></p>
                </div>
   		 <?php } ?>

	<!-- Header -->
	<header class="header">
		<!-- Header top -->
		<div class="logo-search-area">
			<div class="container">
				<div class="row">
                	<div class="col-md-4 col-sm-4">
						<div class="logo">
							<a href="<?php echo base_url(); ?>"><img src="images/logo/<?php echo $this->config->item('logo_image'); ?>" alt=""></a>
						</div><!-- logo -->
					</div>
					<form name="search-form" action="search/all" method="get" >
					<div class="col-md-3 col-sm-3">
                            	<div class="input-group" >
								<input name="item" class="form-control search-input"  placeholder="Search Products" type="search"  >
                                <span class="input-group-addon" ><i class="glyphicon glyphicon-search"></i></span>
                                </div>
					</div> 
					<div class="col-md-2 col-sm-2" ><button type="submit" class="btn btn-primary search-button" >Search</button></div>
					</form><!-- Search form -->
					<div class="col-md-3 col-sm-3">

							<?php if($this->session->userdata['shopsy_session_user_name'] == '') { ?>
							<div class="book-table">
							<a href="register">Sign Up</a>
                            <a href="login">Sign In</a>
							<a href="site/shop/plans" ><i class="fa fa-shopping-cart" style="padding-right:10px;"></i>Open Store</a>
							</div> <!-- Book a table -->
            				<?php } else { ?>
                            <?php $this->load->view('site/templates/menu_after_login'); ?>
							<?php //if ( $this->session->userdata['userType'] == 'Seller' ) { ?>
                                    <!--<div class="cart">
                                        <a href="merchant-home"><i class="fa fa-university"></i></a>
                                    </div>-->
                            <?php //} ?>
                            <!--<div class="cart">
								<a href="javascript:;">
									<i class="fa fa-user"></i>
								</a>
								<div class="cart-content">
									<div class="cart-item">
										<div class="cart-des">
											<a href="public-profile">My Profile</a>
										</div>
									</div>

									<div class="cart-item">
										<div class="cart-des">
											<a href="purchase-review">Orders</a>
										</div>
									</div>
                                    
									<div class="cart-item">
										<div class="cart-des">
											<a href="site/user/mylikes">My Likes</a>
										</div>
									</div>

									<div class="cart-item">
										<div class="cart-des">
											<a href="user-email-settings">Emails</a>
										</div>
									</div>

									<div class="cart-item">
										<div class="cart-des">
											<a href="manage-notification">Notifications</a>
										</div>
									</div>

									<div class="cart-item">
										<div class="cart-des">
											<a href="my-offers">My Discount Offers</a>
										</div>
									</div>

									<div class="cart-item">
										<div class="cart-des">
											<a href="contact-support">Contact Support</a>
										</div>
									</div>

									<div class="cart-item">
										<div class="cart-des">
											<a href="logout">Logout</a>
										</div>
									</div>
								</div>
							</div>

							<div class="cart">
								<a href="placeOrder"><i class="fa fa-shopping-basket"></i>
                    			<?php //if( $this->session->userdata('cart_quantity') != 0 ) : ?>
									<?php //echo '<span>' . $this->session->userdata('cart_quantity') .'</span>'; ?>
								</a>
                    			<?php //endif; ?>
							</div>-->

        					<?php } ?>

                    </div>
				</div>
			</div><!-- container -->
		</div><!-- Logo and search area -->
        
	</header>
    <!-- Header End -->

	<!-- service section-->
	<section class="service">
		<div class="container">
			<div class="row">
				<img src="images/banner/topbanner1.jpg" class="img-responsive">
			</div>
		</div> <!-- container -->
	</section><!-- service section end -->


	<div class="container" style="padding:0" >
        <nav class="navbar navbar-default navbar-inverse navbar-merchant" role="navigation">
           <div class="container-fluid" id="navfluid">
               <div class="navbar-header">
                   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigationbar">
                       <span class="sr-only">Toggle navigation</span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                    </button>
               </div>
               <div class="collapse navbar-collapse" id="navigationbar">
                   <ul class="nav navbar-nav">
                        <li class="<?php echo $home ? 'active' : '';?>" style="color:#fff;" >
                          <a href="merchant-home"><i class="fa fa-university"></i> Dashboard</a>
                        </li>
                        
                        <li class="dropdown <?php echo $marketing ? 'active' : '';?>" >
                          <a  class="nav-link dropdown-toggle" href="javascript:void(0);" id="marketingMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-lightbulb-o"></i> MARKETING <i class="fa fa-caret-down"></i></a>
                           <div class="dropdown-menu" aria-labelledby="marketingMenu" >
                            <a class="dropdown-item" href="shop/promotions">Promotions</a>
                            <a class="dropdown-item" href="site/shop/sales_setting">Max Discount</a>
                           </div>  
                        </li>

                        <!--<li  class="dropdown">
                          <a class="nav-link dropdown-toggle"  href="#" id="channelMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-suitcase"></i> Distribution <i class="fa fa-caret-down"></i></a>
                           <div class="dropdown-menu"  aria-labelledby="channelMenu" >
                             <a class="dropdown-item" href="#">Marketplace</a>
                          </div>  
                        </li>-->
                        
                        <li class="dropdown <?php echo $orders ? 'active' : '';?>">
                              <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="orderMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-automobile"></i> Orders <i class="fa fa-caret-down"></i></a>
                             <div class="dropdown-menu"  aria-labelledby="orderMenu" >
                                <a class="dropdown-item" href="shops/shop-orders">All Orders</a>
                                <a class="dropdown-item" href="merchant-shipstation">Ship Station Integration</a>
                             </div>  
                        </li>
                        <li class="dropdown <?php echo $products ? 'active' : '';?>"><a class="nav-link dropdown-toggle" href="#" id="productMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-thumbs-up"></i> Products <i class="fa fa-caret-down"></i></a>
                        
                             <div class="dropdown-menu"  aria-labelledby="productMenu" >
                                <a class="dropdown-item" href="shop/managelistings">View All</a>
                                <a class="dropdown-item" href="product-setup">Product Setup</a>
                                <a class="dropdown-item" href="import-items">Import Products</a>
                                <a class="dropdown-item" href="product-import-history">View Import History</a>
                          	</div>  
                        </li>
                        <li class="dropdown <?php echo $account ? 'active' : '';?>">
                        	<a class="nav-link dropdown-toggle" href="#" id="accountMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Account <i class="fa fa-caret-down"></i></a>
                             <div class="dropdown-menu"  aria-labelledby="accountMenu" >
                                <a class="dropdown-item" href="shops/merchant/bizinfo">Details</a>
                                <a class="dropdown-item" href="merchant-billing">Billing</a>
                                <a class="dropdown-item" href="merchant-plan">Plan</a>
                                <a class="dropdown-item" href="merchant-payments">Payments</a>
                                <!--<a class="dropdown-item" href="#">Users</a>-->
                                <a class="dropdown-item" href="merchant-penalty">Penalties</a>
                                <a class="dropdown-item" href="merchant-support">Contact Us</a>
                                <a target="_blank" class="dropdown-item" href="pages/merchant_help">Help</a>
                         	</div>  
                       </li>

                   </ul>
              </div><!-- /.navbar-collapse -->
           </div><!-- /.container-fluid -->
        </nav>

				<!--<div class="title" style="">
                	<a href="#" data-ga-click-category="" data-ga-click-action="Carousel" data-ga-click-label=""><?php //echo $this->session->userdata['shop_name']; ?></a>
                </div>-->
    </div>

<!-- GV -->
		  
	


