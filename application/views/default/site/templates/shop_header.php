<?php if($this->session->flashdata('sErrMSG') != '') { ?>


<div class="errorContainer" id="<?php echo $this->session->flashdata('sErrMSGType'); ?>"> 
  <script>setTimeout("hideErrDiv('<?php echo $this->session->flashdata('sErrMSGType'); ?>')", 5000);</script>
 
  <p><span> <?php echo $this->session->flashdata('sErrMSG');  ?> </span></p>
</div>

<?php  } ?>

<?php  $showShopHead = 0; $shopEditArr = array('admin-edit-product','admin-preview','admin-copy-product'); $shopAddArr = array('admin-listitem','admin-preview'); $bodyArr2 = array('sell','listitem','name','billing'); ?>
<body>

<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- css -->
<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,700,400italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/default/site/base.css" />
<link rel="stylesheet" href="css/default/site/style-menu.css" />
   
<!-- js -->
<!--<script src="js/jquery-1.9.1.min.js"></script>-->
<script src="js/modernizr.custom.js"></script>
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

<?php 
if($CurrUserImg != ''){
	$user_pic='users/thumb/'.$CurrUserImg; 													
}else{ 
	$user_pic='default_avat.png';
} 												
?>
<style>
#you1{
	background: url(<?php echo base_url()."images/".$user_pic; ?>) no-repeat scroll ;
	background-position:center;
	border-radius: 50%;
	box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);
	float: left;
	height: 31px !important;
	margin-top: 0;
	vertical-align: middle;
	width: 31px;
	background-size: cover;
}
.add_shop{
	margin-top: 61px;
}


</style>
<header>
  <div class="main-4">
    <div class="header_top">
	<div class="container top">
	<div class="row">
	
		<div class="col-md-12 signin sign-mobile"> 					
						<span class="shop-cart"> 
							<a href="cart"><i class="fa fa-shopping-cart icon-shopping"></i> <?php if($this->lang->line('comm_cart') != '') { echo stripslashes($this->lang->line('comm_cart')); } else echo 'Cart'; ?> 
							<span id="CartCount1" class="CartCount1"> <?php if($MiniCartViewSet>0) { ?><?php echo $MiniCartViewSet; ?><?php }else{ echo '0'; } ?></span>
						</a>
						</span>
				</div>
				
				
      <div class="col-md-2 col-xs-2" id="logo">
						<a href="<?php echo base_url();?>">
							<img src="images/logo/<?php echo $this->config->item('logo_image'); ?>"  alt="<?php echo $this->config->item('email_title'); ?>" title="<?php echo $this->config->item('email_title'); ?>">
						</a>
				     </div>
      
	  <div class="col-md-3 search-bl col-xs-6 ">				
						<form name="search" action="search/all" method="get">
                            <div class="input-group add-on">
							<input type="text" class="form-control search" name="item" placeholder="Search for items and shops" value="<?php if($this->input->get('item') != ''){ echo htmlspecialchars($this->input->get('item'));}?>" id="search_items" autocomplete="off" >
							<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
							<?php if($this->input->get('gift_cards') == 'on'){ ?>
							<input type="hidden" name="gift_cards" value="<?php echo $gift;?>" /> <?php  }?>
							 <?php if($minVal != ''){ ?> 
							<input type="hidden" name="min_price" value="<?php echo $minVal;?>" /> <?php  }?>
								 <?php if($maxVal != ''){ ?>
							<input type="hidden" name="max_price" value="<?php echo $maxVal;?>" /> <?php  }?>
							<?php if($locVal != ''){ ?>
							<input type="hidden" name="location" value="<?php echo $locVal;?>" /> <?php  }?>
							<?php if($shipVal != ''){ ?>
							<input type="hidden" name="shipto" value="<?php echo $shipVal;?>" /> <?php  }?>	
							<!--<input type="submit" value="Search" class="search-bt">-->
						</form>
						<div id="sugglist"></div>
				  </div>
					
				 <!--<div class="btn-group col-md-1 act-browse-bt col-xs-6">
					<button type="button" class="btn btn-default dropdown-toggle browse " data-toggle="dropdown" aria-expanded="false"> Browse
						<span class="caret"></span> 
					</button>
							<ul class="dropdown-menu" role="menu">
									
								<?php
									$p=0;
							foreach ($mainCategories->result() as $row){
								if ($row->cat_name != ''){ 
									if($p<=14){
									
									
									//$commentData = $this->category_model->get_all_counts($row->id,''); 
									//if($commentData[0]['disp']>0){
							?>
							<li><a href="category-list/<?php echo $row->id;?>-<?php echo $row->seourl;?>"><?php echo $row->cat_name;?></a></li>
							<?php 
									//}
								}else{ ?>
								<li><a href="<?php echo base_url().'category'; ?>"><?php if($this->lang->line('com_more') != '') { echo stripslashes($this->lang->line('com_more')); } else echo 'More'; ?> </a></li>
								
								<?php 
								break; }								
									$p++;
								} 
							}
							?> 
						</ul>	
				 </div>-->
		
		
		
					
					<div class="col-md-2 pull-right signin cart-top">  
						<!--<i class="fa fa-bell"></i>-->
						 <span class="shop-cart"> 
						     <a href="cart"><i class="fa fa-shopping-cart icon-shopping"></i> </a>
						     <a class="cart-txt" href="cart">Cart
							<span id="CartCount1" class="CartCount1"> <?php if($MiniCartViewSet>0) { ?><?php echo $MiniCartViewSet; ?><?php }else{ echo '0'; } ?></span>
							 </a> 
							</span>
						
					 </div>
					 
					 <div class="col-md-5 col-xs-5 top-login">
				  
						<ul class="header_menu">
										
							<li>
								<a href="<?php echo base_url();?>" id="home" title="Home">
									<span class="icon-text">Home</span>
								</a>
							</li>
							
							<li>
								<a id="favorites" href="people/<?php echo $this->session->userdata['shopsy_session_user_name'];?>/favorites" title="Favorites">
									<span class="icon-text">Favorites</span>
								</a>
							</li>
							
							<li>
								<a href="shop/sell" id="shop" title="<?php echo $this->session->userdata['shop_name']; ?>">
									 <?php if($curruserGroup=='Seller'){ ?>
									<span class="icon-text"><?php echo $this->session->userdata['shop_name']; ?></span>
									<?php } else{?>
									<span class="icon-text">Sell</span>
									<?php }?>
								</a>
								
							</li>
							<li>
								<a class="dropdown-toggle browse "  data-toggle="dropdown" id="you1" title="You">
									<span class="icon-text">You
									
									<?php if($notificationCount>0){ ?>
									<span class="notification-count" id="notificationCount"><?php echo $notificationCount; ?></span> 
									<?php }  ?>
									</span>
								</a>
							<i></i>
							
								<ul class="dropdown-menu browse-nav-inner showlist2" role="you">
											<span class="menuarrow"></span>
											`
									
									 <li class="first">
										<div class="drop_right_main">
											<div class="user_img">
												<?php 
												if($CurrUserImg != ''){
													$user_pic='users/thumb/'.$CurrUserImg; 
												}else{ 
													$user_pic='default_avat.png';
												} 
											
											?>
											<img src="images/<?php echo $user_pic;?>" />
											</div>
											<div class="drop_right"><strong><?php echo $this->session->userdata['shopsy_session_user_name'];?></strong><span><a href="view-profile/<?php echo $this->session->userdata['shopsy_session_user_name']; ?>" class="view-btn1">View Profile</a></span></div>							
										</div>
									</li>
									<li><a style="padding: 0 20px;" href="activity">
									<small><?php if($this->lang->line('activity_count') != '') { echo stripslashes($this->lang->line('activity_count')); } else echo 'Activity'; ?></small>
									<?php if($userActivityCount>0) {?>
									<span class="activity-count"><?php echo $userActivityCount; ?></span> 
									<?php } ?>
									</a>
									</li>
									
									<?php if($notificationCount>0) {?>
									<li>
										<a style="padding: 0 20px;" href="<?php echo $this->session->userdata['shopsy_session_user_name'];?>/notifications">
										<small><?php if($this->lang->line('notify_notifications') != '') { echo stripslashes($this->lang->line('notify_notifications')); } else echo 'Notifications'; ?></small>
										<span class="notification-list-count"><?php echo $notificationCount; ?></span> 
										</a>
									</li>
									<?php } ?>
									
									
									<li><a href="purchase-review"><?php if($this->lang->line('user_purchases') != '') { echo stripslashes($this->lang->line('user_purchases')); } else echo 'Purchases'; ?></a></li>
									<li><a href="reviews"><?php if($this->lang->line('lg_reviews') != '') { echo stripslashes($this->lang->line('lg_reviews')); } else echo 'Reviews'; ?></a></li>
									<li><a href="disputes"><?php if($this->lang->line('lg_disputes') != '') { echo stripslashes($this->lang->line('lg_disputes')); } else echo 'Disputes'; ?></a></li>
									<li><a href="manage-community"><?php if($this->lang->line('comm_community') != '') { echo stripslashes($this->lang->line('comm_community')); } else echo 'Manage Community'; ?></a></li>
									<li><a href="public-profile"><?php if($this->lang->line('user_pub_profile') != '') { echo stripslashes($this->lang->line('user_pub_profile')); } else echo 'Public Profile'; ?></a></li>
									<li><a href="settings/my-account/<?php echo $this->session->userdata['shopsy_session_user_name'];?>"><?php if($this->lang->line('landing_account_ettings') != '') { echo stripslashes($this->lang->line('landing_account_ettings')); } else echo 'Account Settings'; ?></a></li>
									<li class="last"><a href="logout"><?php if($this->lang->line('sign_out') != '') { echo stripslashes($this->lang->line('sign_out')); } else echo 'Sign Out'; ?></a></li> 																		
								</ul>							
							</li>									   
						</ul>
				  
				    </div>
			</div>
		</div>
    </div>

  </div>
</header>
 <?php if($showShopHead == 0){ ?>
<div class="add_shop">
  <div class="main">
	
	<!--<div id="flip">Menu</div>-->
	<div id="nav-trigger">
            <span>Menu</span>
    </div>
	<nav id="nav-main">
    <ul id="panel" class="add_steps" style="background:none; box-shadow:none;">
      
      
      
      <li <?php if ($this->uri->segment(3) == 'banner' || $this->uri->segment(2)== 'name'){ ?> class="side_active" <?php } ?> >
      	<a title="Choose Your Shop Name"  href="<?php echo ($selectSellershop_details[0]['seourl'] !='') ? 'appearance/' . $selectSellershop_details[0]['seourl'].'/banner' : 'shop/name' ?>" ><div class="name-inner" >Shop Info<span class="complete-indicator"></span></div></a>
      </li>
      
      <!--class="<?php //if($this->uri->segment(2)=='name'){ echo 'shop_active_tab';} ?> " >-->
      
        
        
      <li class="<?php echo ($this->uri->segment(3) == 'bizinfo') ? 'side_active' : '';?>" >
		<?php if($selectSellershop_details[0]['seller_businessname'] != '') { ?>
			<a href="shops/<?php echo $selectSellershop_details[0]['seller_businessname'];?>/bizinfo">
				<div class="name-inner">Biz. Info<span class="complete-indicator"></span></div>
			</a>
		<?php } ?>	
	 </li>
	 
      <li <?php if ($this->uri->segment(3) == 'product_setup' && $this->uri->segment(2) == 'shop'){ ?> class="side_active" <?php } ?>>
        <?php if($selectSellershop_details[0]['seller_businessname'] != '') { ?>
        	<a title="What are you going to sell? Add and edit listings here." href="site/shop/product_setup" class="<?php if($this->uri->segment(2)=='listitem'){ echo 'shop_active_tab';} ?> "> 
			<div class="name-inner">Add Items</div></a>
        <?php } else { ?>
        	<a class="shop_active" ><div class="name-inner">Add Items</div></a>
         <?php } ?>
      </li>

		 <li <?php if ($this->uri->segment(2) == 'managelistings' && $this->uri->segment(1) == 'shop'){ ?> class="side_active" <?php } ?> >
          <?php if(count($shopProduc)!= 0) { ?>
        	<a title="Manage your listings here." href="shop/managelistings" class="<?php if($this->uri->segment(2)=='managelistings' || $this->uri->segment(1)=='edit-product'){ echo 'shop_active_tab';} ?>"> 
				<div class="name-inner">Manage items</div>
			</a>
        <?php } else { ?>
        	<a class="shop_active"  >
				<div class="name-inner">Manage items</div>
			</a>
         <?php } ?>
        </li>
		 <li <?php if ( ( $this->uri->segment(2) == 'promotions' || $this->uri->segment(2) == 'create_promotion') && $this->uri->segment(1) == 'shop'){ ?> class="side_active" <?php } ?> >
        	<a title="promotions" href="shop/promotions" class="<?php if($this->uri->segment(3)=='promotions' ){ echo 'shop_active_tab';} ?>"> 
				<div class="name-inner">Promotions</div>
			</a>
        </li>
        
                
        <?php //if( $loginCheck != 1 ){ ?>
      	
        <?php if($curruserGroup == 'Seller'){ ?>
		
		<li <?php if ($this->uri->segment(3) == 'shop-orders'){ ?> class="side_active" <?php } ?>>
        	<a href="shops/<?php echo $selectSellershop_details[0]['seourl']; ?>/shop-orders"><div class="name-inner">Orders<!--<b class="caret" style="position: static;"></b>--></div>
            </a>
		
		<!--<ul class="add_shop_drop_down">
			<?php //$shop_id = $loginCheck;?>
			<?php //$this->load->model('order_model'); ?>
			
			<?php //$processedorder = $this->order_model->view_shop_order_details('Paid',$shop_id,'Processed'); ?>
			   <li><a title="" href="shops/<?php //echo $selectSellershop_details[0]['seourl']; ?>/shop-orders?order=Processed" class="" ><div class="name-inner">Processed (<?php //echo $processedorder->num_rows();?>)</div></a></li>
			<?php //$shippedorder = $this->order_model->view_shop_order_details('Paid',$shop_id,'Shipped'); ?>   
            <li><a title="" href="shops/<?php //echo $selectSellershop_details[0]['seourl']; ?>/shop-orders?order=Shipped" class="" ><div class="name-inner">Shipped (<?php //echo $shippedorder->num_rows();?>)</div></a></li>
			<?php //$deliveredorder = $this->order_model->view_shop_order_details('Paid',$shop_id,'Delivered'); ?>
			   <li><a title="" href="shops/<?php //echo $selectSellershop_details[0]['seourl']; ?>/shop-orders?order=Delivered" class="" ><div class="name-inner">Delivered (<?php //echo $deliveredorder->num_rows();?>)</div></a></li>
			<?php //$cancelledorder = $this->order_model->view_shop_order_details('Paid',$shop_id,'Cancelled'); ?>
			   <li><a title="" href="shops/<?php //echo $selectSellershop_details[0]['seourl']; ?>/shop-orders?order=Cancelled" class="" ><div class="name-inner">Cancelled (<?php //echo $cancelledorder->num_rows();?>)</div></a></li>
			<?php //$returnorder = $this->order_model->view_shop_order_details('Paid',$shop_id,'dispute'); ?>  
			   <li><a title="" href="shops/<?php //echo $selectSellershop_details[0]['seourl']; ?>/shop-orders?order=dispute" class="" ><div class="name-inner">Return / Replace (<?php //echo $returnorder->num_rows();?>)</div></a></li>
		</ul>-->
		
		</li>
		
		<li><a  href="javascript:void(0)"><div class="name-inner">More<b class="caret" style="position: static;"></b></div></a>
		
			<ul class="add_shop_drop_down">
					<li><a href="promote-shop">Your Main Image</a></li>
					
					<li><a href="shop/reviews">Reviews</a></li>
					
					<li><a href="shops/<?php echo $selectSeller_details[0]['seourl']; ?>/shop-transaction">Transaction</a></li>
					
					<li><a href="shops/<?php echo $selectSeller_details[0]['seourl']; ?>/commision-tracking">Earnings List</a></li>
					
					<li><a href="shops/<?php echo $selectSeller_details[0]['seourl']; ?>/withdraw-req">Withdrawal Request</a></li>
					
					<li><a href="import-items">Import Listings</a></li>
						
			</ul>

		
		</li>
		<?php }?>
     
    <?php //} ?>
      
    </ul>
  </nav>
        <nav id="nav-mobile"></nav>
  </div>
</div>
<?php } ?>
<script>
function hideErrDiv(arg) {
    document.getElementById(arg).style.display = 'none';
}
</script> 
<script src="js/site/main.js" type="text/javascript"></script>
<div style='display:none'>
  <div id='inline' style='background:#F5F5F1; border-radius:5px'> 
  <div style="padding: 20px 30px; border-radius:5px 5px 0 0" class="global-header"><h2 style="color: #555555;"><?php if($this->lang->line('comm_welcome') != '') { echo stripslashes($this->lang->line('comm_welcome')); } else echo 'Welcome to our Global Community of Sellers!'; ?></h2></div>
   <div style="background:#fff; border-radius:0 0 5px 5px" class="global-section glob-sugession">
   <p><?php if($this->lang->line('comm_shopsybuyers') != '') { echo stripslashes($this->lang->line('comm_shopsybuyers')); } else echo 'Reach shopsy Buyers, I already sell full time'; ?></p>
   <p><?php if($this->lang->line('comm_quitmyday') != '') { echo stripslashes($this->lang->line('comm_quitmyday')); } else echo 'Quit my day job to sell full time'; ?></p>
    <p><?php if($this->lang->line('comm_sparetime') != '') { echo stripslashes($this->lang->line('comm_sparetime')); } else echo 'Sell in my spare time'; ?></p>
     <p><?php if($this->lang->line('comm_other') != '') { echo stripslashes($this->lang->line('comm_other')); } else echo 'other'; ?></p><input type="text" placeholder="<?php if($this->lang->line('comm_other') != '') { echo stripslashes($this->lang->line('comm_other')); } else echo 'other'; ?>"></div>
    
    
  </div>
</div>


<?php

	#echo $this->session->userdata['shopsy_session_user_confirm'];die;
	if($this->session->userdata['shopsy_session_user_confirm'] == 'No') { 
	  			  $this->load->view('site/templates/mail_confirmation');
    }

?>


<style>

#{
	position:absolute;
	border:1px solid #333;
	background:#333333;
	padding:2px 5px;
	color:#FFFFFF;
	display:none;
    
    top:40px;
	border-radius: 3px;
	width:200px;
	float:left;
	padding: 3px 6px;
	
	font-size: 13px;
	z-index:9999;
    font-weight: normal;
}

</style>
