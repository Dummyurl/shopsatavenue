<!DOCTYPE html>
<html lang="en-US">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Shops at Avenue</title>
<link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap.css">
<link href="<?php echo base_url();?>font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url();?>css/style.css">
<!--<link rel="stylesheet" href="<?php //echo base_url();?>css/flaticon.css">
<link rel="stylesheet" href="<?php //echo base_url();?>css/swiper.css">
<link rel="stylesheet" href="<?php //echo base_url();?>css/responsive.css">-->


<base href="<?php echo base_url(); ?>" />

	<?php if($this->config->item('google_verification')){ echo stripslashes($this->config->item('google_verification')); }
	if ($heading == ''){?>    
		<title><?php echo $title;?></title>
	<?php }else {?>
		<title><?php echo $heading;?></title>
	<?php }?>
	
<meta name="Title" content="<?php if($meta_title=='') { echo $this->config->item('meta_title'); } else { echo $meta_title; } ?>" >
<meta name="keywords" content="<?php if($meta_keyword=='') { echo $this->config->item('meta_keyword'); } else { echo $meta_keyword; } ?>" >
<meta name="description" content="<?php if($meta_description==''){ echo $this->config->item('meta_description');} else { echo htmlentities($meta_description);}?>" >
	
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().'images/logo/'.$this->config->item('fevicon_image'); ?>">


<?php 
if($this->config->item('publish')!='Production'){	
	$chkPrv=$this->product_model->checkLogin('A');
	if($chkPrv==''){
		
		echo '<title>Coming Soon</title>';
		echo '<div style="background-color:#131521; width:100%;"><div style="margin: 0 auto; width:1300px;"><img src="images/under_maintainence.jpg" alt="under maintainence"></div></div>';
	
		die;
	}
}

?>
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

.merchant-menu ul > li a { color: #fff; }
.dropdown-item { display:block; padding:10px; }

.navbar-nav li.dropdown > a::before { right:auto !important; left:90%; }
</style>
</head>
 		<?php
				if($this->session->flashdata('sErrMSG') != '') { ?>
                <div class="errorContainer" id="<?php echo $this->session->flashdata('sErrMSGType'); ?>">
                  <script>setTimeout("hideErrDiv('<?php echo $this->session->flashdata('sErrMSGType'); ?>')", 5000);</script>
                  <p><span> <?php echo $this->session->flashdata('sErrMSG');  ?> </span></p>
                </div>
   		 <?php } ?>
<body>

	<!-- Header -->
 		<?php if($this->session->flashdata('sErrMSG') != '') { ?>
                <div class="errorContainer logoutdiv alert alert-success text-center" id="<?php echo $this->session->flashdata('sErrMSGType'); ?>">
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
					<div class="col-md-5 col-sm-5">
						<div class="search-box">
							<form class="search-form">
                            	<div style="width:40%;display:inline-block;">
								<input id="search-terms" name="item"  placeholder="Search Products" type="search" style="width:90%;" >
                                </div>
                                <div style="width:40%;display:inline-block;">
                                <input name="active_search" placeholder="active search" type="search" style="width:90%;" >
                                </div>
								<button type="submit">Search
									<!--<i class="fa fa-search"></i>-->
								</button>
							</form><!-- Search form -->

						</div><!-- Search area -->
					</div> 
					<div class="col-md-3 col-sm-3">

							<?php if($this->session->userdata['shopsy_session_user_name'] == '') { ?>
							<div class="book-table">
							<a href="register">Sign Up</a>
                            <a href="login">Sign In</a>
							<a href="site/shop/plans" ><i class="fa fa-shopping-cart" style="padding-right:10px;"></i>Open Store</a>
							</div> <!-- Book a table -->
            				<?php } else { ?>
							<?php if ( $this->session->userdata['userType'] == 'Seller' ) { ?>
                                    <div class="cart">
                                        <a href="merchant-home"><i class="fa fa-university"></i></a>
                                    </div>
                            <?php } ?>
                            <div class="cart">
								<a href="javascript:;">
									<i class="fa fa-user"></i>
								</a>
								<div class="cart-content">
									<div class="cart-item">
										<div class="cart-des">
											<a href="public-profile">My Profile</a>
										</div><!-- cart des -->
									</div><!-- cart item --> <!-- cart item -->

									<div class="cart-item">
										<div class="cart-des">
											<a href="purchase-review">Orders</a>
										</div><!-- cart des -->
									</div><!-- cart item -->
                                    
									<div class="cart-item">
										<div class="cart-des">
											<a href="site/user/mylikes">My Likes</a>
										</div><!-- cart des -->
									</div><!-- cart item -->

									<div class="cart-item">
										<div class="cart-des">
											<a href="user-email-settings">Emails</a>
										</div><!-- cart des -->
									</div><!-- cart item -->

									<div class="cart-item">
										<div class="cart-des">
											<a href="manage-notification">Notifications</a>
										</div><!-- cart des -->
									</div><!-- cart item -->

									<div class="cart-item">
										<div class="cart-des">
											<a href="my-offers">My Discount Offers</a>
										</div><!-- cart des -->
									</div><!-- cart item -->

									<div class="cart-item">
										<div class="cart-des">
											<a href="contact-support">Contact Support</a>
										</div><!-- cart des -->
									</div><!-- cart item -->

									<div class="cart-item">
										<div class="cart-des">
											<a href="/logout">Logout</a>
										</div><!-- cart des -->
									</div><!-- cart item --><!-- cart-bottom -->
								</div> <!-- cart content -->
							</div>

							<div class="cart">
								<a href="placeOrder"><i class="fa fa-shopping-basket"></i>
                    			<?php if( $this->session->userdata('cart_quantity') != 0 ) : ?>
									<?php echo '<span>' . $this->session->userdata('cart_quantity') .'</span>'; ?>
								</a>
                    			<?php endif; ?>
							</div>

        					<?php } ?>

                    </div>
				</div>
			</div><!-- container -->
		</div><!-- Logo and search area -->
        
		<!-- main menu -->
		<div class="main-menu main-nav style-1">
			<div class="container">
				<div class="row">
					<div class="navbar-header">
					    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					       <span class="sr-only">Toggle navigation</span>
					       <span class="icon-bar"></span>
					       <span class="icon-bar"></span>
					       <span class="icon-bar"></span>
					    </button>
					    <a class="navbar-brand logo hidden-lg" href="<?php echo base_url();?>">
					    	<img src="images/logo/<?php echo $this->config->item('logo_image'); ?>" alt="">
					    </a>
					   <div class="search-box hidden-lg">
							<form class="form-search">
								<input id="search-terms" name="item" placeholder="Search Products" type="text">
								<button type="submit">
									<i class="fa fa-search"></i>
								</button>
							</form><!-- Search form -->
						</div><!-- Search area -->
                        <div class="book-table hidden-lg">
							<a href="/register">Sign Up</a>
                            <a href="/login">Sign In</a>
						</div>
					</div><!-- navbar header -->
				</div>
			</div><!-- container -->
		</div><!-- main menu -->
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

	<div class="container" >
        <nav class="navbar navbar-default navbar-inverse" role="navigation">
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
                        <li class="active" >
                          <a href="merchant-home"><i class="fa fa-university"></i> Dashboard</a>
                        </li>
                        
                        <li class="dropdown" >
                          <a  class="nav-link dropdown-toggle" href="javascript:void(0);" id="marketingMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-lightbulb-o"></i> MARKETING <!--<i class="fa fa-caret-down"></i>--></a>
                           <div class="dropdown-menu" aria-labelledby="marketingMenu" >
                            <a class="dropdown-item" href="shop/promotions">Promotions</a>
                            <a class="dropdown-item" href="site/shop/sales_setting">Max Discount</a>
                           </div>  
                        </li>

                        <li  class="dropdown">
                          <a class="nav-link dropdown-toggle"  href="#" id="channelMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-suitcase"></i> Distribution <!--<i class="fa fa-caret-down"></i>--></a>
                           <div class="dropdown-menu"  aria-labelledby="channelMenu" >
                             <a class="dropdown-item" href="#">Marketplace</a>
                          </div>  
                        </li>
                        
                        <li class="dropdown">
                              <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="orderMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-automobile"></i> Orders</a>
                             <div class="dropdown-menu"  aria-labelledby="orderMenu" >
                                <a class="dropdown-item" href="shops/shop-orders">All</a>
                                <a class="dropdown-item" href="merchant-shipstation">Ship Station Integration</a>
                             </div>  
                        </li>
                        <li class="dropdown"><a class="nav-link dropdown-toggle" href="#" id="productMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-thumbs-up"></i> Products</a>
                        
                             <div class="dropdown-menu"  aria-labelledby="productMenu" >
                                <a class="dropdown-item" href="shop/managelistings">View All</a>
                                <a class="dropdown-item" href="import-items">Import Products</a>
                                <a class="dropdown-item" href="#">View Import History</a>
                                <a class="dropdown-item" target="_blank" href="site/shop/product_setup">Add Product</a>
                          	</div>  
                        </li>
                        <li class="dropdown">
                        	<a class="nav-link dropdown-toggle" href="#" id="accountMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Account</a>
                             <div class="dropdown-menu"  aria-labelledby="accountMenu" >
                                <a class="dropdown-item" href="shops/merchant/bizinfo">Details</a>
                                <a class="dropdown-item" href="#">Users</a>
                                <a class="dropdown-item" href="#">Billing</a>
                                <a class="dropdown-item" href="#">Plan</a>
                                <a class="dropdown-item" href="#">Payments</a>
                                <a class="dropdown-item" href="#">Penalties</a>
                                <a class="dropdown-item" href="#">Contact Us</a>
                                <a class="dropdown-item" href="#">Help</a>
                         	</div>  
                       </li>

                   </ul>
              </div><!-- /.navbar-collapse -->
           </div><!-- /.container-fluid -->
        </nav>
    </div>

	<div class="container" style="padding:0" >
        		<nav class="navbar navbar-toggleable-md navbar-light"  >
					 <div class="collapse navbar-collapse" id="navbarNavDropdown">
    					<ul class="navbar-nav" >
                        <li class="nav-item active" >
                          <a href="merchant-home"><i class="fa fa-university"></i> Dashboard</a>
                        </li>
                        <li class="nav-item dropdown" >
                          <a  class="nav-link dropdown-toggle" href="javascript:void(0);" id="marketingMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-lightbulb-o"></i> MARKETING <!--<i class="fa fa-caret-down"></i>--></a>
                           <div class="dropdown-menu" aria-labelledby="marketingMenu" >
                            <a class="dropdown-item" href="shop/promotions">Promotions</a>
                            <a class="dropdown-item" href="site/shop/sales_setting">Max Discount</a>
                           </div>  
                        </li>
                        <li  class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle"  href="#" id="channelMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-suitcase"></i> Distribution <!--<i class="fa fa-caret-down"></i>--></a>
                           <div class="dropdown-menu"  aria-labelledby="channelMenu" >
                             <a class="dropdown-item" href="#">Marketplace</a>
                          </div>  
                        </li>
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="orderMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-automobile"></i> Orders</a>
                             <div class="dropdown-menu"  aria-labelledby="orderMenu" >
                                <a class="dropdown-item" href="shops/shop-orders">All</a>
                                <a class="dropdown-item" href="merchant-shipstation">Ship Station Integration</a>
                             </div>  
                        </li>
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="productMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-thumbs-up"></i> Products</a>
                        
                             <div class="dropdown-menu"  aria-labelledby="productMenu" >
                                <a class="dropdown-item" href="shop/managelistings">View All</a>
                                <a class="dropdown-item" href="import-items">Import Products</a>
                                <a class="dropdown-item" href="#">View Import History</a>
                                <a class="dropdown-item" target="_blank" href="site/shop/product_setup">Add Product</a>
                          	</div>  
                        </li>
                        <li class="nav-item  dropdown">
                        	<a class="nav-link dropdown-toggle" href="#" id="accountMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Account</a>
                             <div class="dropdown-menu"  aria-labelledby="accountMenu" >
                                <a class="dropdown-item" href="shops/merchant/bizinfo">Details</a>
                                <a class="dropdown-item" href="#">Users</a>
                                <a class="dropdown-item" href="#">Billing</a>
                                <a class="dropdown-item" href="#">Plan</a>
                                <a class="dropdown-item" href="#">Payments</a>
                                <a class="dropdown-item" href="#">Penalties</a>
                                <a class="dropdown-item" href="#">Contact Us</a>
                                <a class="dropdown-item" href="#">Help</a>
                         	</div>  
                       </li>
  					</ul>
                   </div>
				</nav>

				<div class="title" style="">
                	<a href="#" data-ga-click-category="" data-ga-click-action="Carousel" data-ga-click-label=""><?php echo $this->session->userdata['shop_name']; ?></a>
                </div>
    </div>

<link href='3rdparty/morris/morris.css' rel='stylesheet' type='text/css'>

<?php $this->load->model('user_model'); ?>

<style>
.box.box-solid { border-top: 0;}
.bg-teal-gradient {
    background: #39cccc !important;
    background: -webkit-gradient(linear, left bottom, left top, color-stop(0, #39cccc), color-stop(1, #7adddd)) !important;
    background: -ms-linear-gradient(bottom, #39cccc, #7adddd) !important;
    background: -moz-linear-gradient(center bottom, #39cccc 0, #7adddd 100%) !important;
    background: -o-linear-gradient(#7adddd, #39cccc) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#7adddd', endColorstr='#39cccc', GradientType=0) !important;
    color: #fff;
}

.box {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border-top: 3px solid #d2d6de;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
.box.box-solid[class*="bg"] > .box-header {
    color: #fff;
}
.box-header {
    color: #444;
    display: block;
    padding: 10px;
    position: relative;
}
.box-title1{
    color: #000;
    font-weight: 700;
	padding-left:10px;
	display:inline-block;
}

</style>
   <div class="container" style="margin-top:60px;">
    <div class="row">
        <div class="col-md-3">&nbsp;</div>
        <div class="col-md-6">
            <div class="tab-head ">
                <nav class="nav-sidebar" >
                    <ul class="nav tabs ">
                        <li class="active"><a href="#tab1" data-toggle="tab" style="color:#2a9ff5;">Yesterday</a></li>
                        <li class=""><a href="#tab2" data-toggle="tab"  style="color:#2a9ff5;">Current Pay Period</a></li> 
                        <li class=""><a href="#tab3" data-toggle="tab"  style="color:#2a9ff5;">Previous Pay Period</a></li>  
                    </ul>
                </nav>
                <div class="tab-content tab-content-t ">
                    <div class="tab-pane active text-style" id="tab1">
                        <div>
                            <div class="col-md-4">
                                <div class="">
                                        <p style="text-align:center;"><strong>$<?php echo number_format($shop->total_sales_amount,2);?></strong><br>
                                        Total Sales</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="">
                                    <p style="text-align:center;"><strong><?php echo (int)$shop->total_views; ?></strong><br>Detail Views</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="">
                                        <p style="text-align:center;"><strong><?php echo (int)$shop->total_likes; ?></strong><br>Loves</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="tab-pane  text-style" id="tab2">
                        <div class="con-w3l">
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                        <p style="text-align:center;"><strong>$<?php echo number_format($sales_current->current_period_amount,2);?></strong><br>Total Sales</p>
                                </div>
                            </div>
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                    <p style="text-align:center;"><strong><?php echo (int)$sales_current->current_period_views; ?></strong><br>Detail Views</p>
                                </div>
                            </div>
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                    <p style="text-align:center;"><strong><?php echo (int)$sales_current->current_period_likes; ?></strong><br>Loves</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                        
                    <div class="tab-pane  text-style" id="tab3">
                        <div class="con-w3l">
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                        <p style="text-align:center;"><strong>$<?php echo number_format($sales_previous->previous_period_amount,2);?></strong><br>Total Sales</p>
                                </div>
                            </div>
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                    <p style="text-align:center;"><strong><?php echo (int)$sales_previous->previous_period_views; ?></strong><br>Detail Views</p>
                                </div>
                            </div>
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                    <p style="text-align:center;"><strong><?php echo (int)$sales_previous->previous_period_likes; ?></strong><br>Loves</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>
        <div class="col-md-3">&nbsp;</div>
    </div>

      <div class="row">
        <section class="col-md-12 connectedSortable">

          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th fa-2x"></i>
              <h3 class="box-title1">Sales Graph</h3>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div>
          </div>
          <!-- /.box -->


        </section>
        <!-- right col -->
      </div>
      
      <div class="row">
      	<section class="col-md-6 col-xs-12">
            <div class="box-header">
            	<h3>Top Seller</h3>
            </div>
            <table class="table table-responsive" style="margin-top:10px;">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Sales</th>
                    <th>Views</th>
                    <th>Likes</th>
                </tr>
                </thead>
                <tbody>
						<?php  
								for( $i=0; $i < count($top_sales); $i++ )   {
                                	$imgArr=explode(',' , $top_sales[$i]['image']);
                        ?>
                          <tr>
                                <td>
                                	<img class="" width="50" height="50" alt="." src="images/product/<?php echo $top_sales[$i]['product_id'];?>/<?php echo $imgArr[0] == '' ? 'images/noimage.jpg' : $imgArr[0]; ?>" >
                                </td>
                                <td><?php echo $top_sales[$i]['product_name']; ?></td>
                                <td><?php echo $top_sales[$i]['total_sales']; ?></td>
                                <td><?php echo $top_sales[$i]['total_views']; ?></td>
                                <td><?php echo $top_sales[$i]['total_likes']; ?></td>
                          </tr>
						<?php } ?>
                       
                </tbody>
            </table>
        
        </section>
      </div>

    </div>


<?php $this->load->view('site/templates/footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script type="text/javascript" src="3rdparty/morris/morris.min.js"></script>

<script type="text/javascript">
  var line = new Morris.Line({
    element: 'line-chart',
    resize: true,
    data: [
      {y: '2011 Q1', item1: 2666},
      {y: '2011 Q2', item1: 2778},
      {y: '2011 Q3', item1: 4912},
      {y: '2011 Q4', item1: 3767},
      {y: '2012 Q1', item1: 6810},
      {y: '2012 Q2', item1: 5670},
      {y: '2012 Q3', item1: 4820},
      {y: '2012 Q4', item1: 15073},
      {y: '2013 Q1', item1: 10687},
      {y: '2013 Q2', item1: 8432}
    ],
    xkey: 'y',
    ykeys: ['item1'],
    labels: ['Item 1'],
    lineColors: ['#efefef'],
    lineWidth: 2,
    hideHover: 'auto',
    gridTextColor: "#fff",
    gridStrokeWidth: 0.4,
    pointSize: 4,
    pointStrokeColors: ["#efefef"],
    gridLineColor: "#efefef",
    gridTextFamily: "Open Sans",
    gridTextSize: 10
  });

</script>