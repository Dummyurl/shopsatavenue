<?php 
	$this->load->view('site/templates/commonheader'); 
	$this->load->view('site/templates/merchant_header'); 
?>
<link rel="stylesheet" href="css/default/front/etalage.css">

</head>

<body class="microsite site-kgsinfotech content-page">

                
<header id="header" class="header-sites header-logo-only">
        <div class="row header-top">
        	<div class="small-12 columns site-header-logo"><a class="header-logo-link" href="<?php echo base_url(); ?>"><img  src="images/logo/<?php echo $this->config->item('logo_image'); ?>"></a></div>
        </div>            
</header>

<div class="off-canvas-wrapper">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper="">
    <div class="off-canvas-content" data-off-canvas-content="">
    <div class="main-container outer-wrap">
    <div class="row collapse">
        <div class="small-12 columns">
            <div class="container-fluid">
    
                <div class="layout-columns">
                    <div class="cms-content">
     

<!--content-->
<div class="content-top ">
	<div class="container ">
    
		<div class="tab-head ">
				<nav class="nav-sidebar">
					<ul class="nav tabs "  style="text-align:left; border:0px !important; ">
					  <!--<li class=""><a href="#tab1" data-toggle="tab">Manage Boosts</a></li>-->
					  <li class="active"><a href="#tab2" data-toggle="tab">Max Discount</a></li> 
					</ul>
				</nav>
				<div class="tab-content tab-content-t ">
					<div class="tab-pane  text-style" id="tab1">
						<div class="con-w3l">
								<div class="product-grid-item-wrapper"><h4>Manage Boosts</h4></div>
						</div>
                     	<div class="clearfix"></div>
					</div>
                    <div class="tab-pane active text-style" id="tab2">
						<div class="con-w3l">
							<div class="product-grid-item-wrapper">
                                <h4>Set Your Maximum Allowed Discount</h4>
                                <p style="margin-top:20px;">Periodically, Shopsatavenue.com runs promotional events with Discounts, Credits and Coupon Codes. Shoppers can use these limited-time incentives to save on eligible products, driving more than 50% of all sales on the marketplace.</p>
                                <p>Opt in to these programs by setting your maximum allowed discount (the most you'd reduce any of your prices during these events). Higher maximums make your product eligible for inclusion in more promotions, increasing their visibility and attracting more customers.</p>
                                <p>
                                How it works: If you set your max discount to 60%, you'll be eligible for inclusion in 20%, 45% or 60% Discount Events but not 70% events, or events with higher percentages.
                                </p>
                                <p><strong>Note:</strong> Discounts, Coupons and Credits can't be combined with each other, so you can set a high maximum with confidence. And you can change your setting at any time.</p>

                            	<!--<div class="state">
                                <label aria-required="true" for="cart_shippingAddress_state" class="required">Maximum Allowed Discount</label>
                                    <span class="field-wrap">
                                    <select id="cart_shippingAddress_state" name="cart[shippingAddress][state]" class="osky-select osky-state" data-required="1">
                                        <option value="20">20%</option>
                                        <option value="25">25%</option>
                                        <option value="30">30%</option>
                                        <option value="35">35%</option>
                                       <option value="40">40%</option>
                                        <option value="45">45%</option>
                                       <option value="50">50%</option>
                                        <option value="55">55%</option>
                                       <option value="60">60%</option>
                                        <option value="65">65%</option>
                                    </select>
                                   </span>
                            	</div>-->

                            	<div class="sellable-quantity osky-input-group">
                                <label aria-required="true" for="cart_shippingAddress_state" class="required">Maximum Allowed Discount</label>
                                    <span class="field-wrap">
                                    <select id="cart_shippingAddress_state" name="cart[shippingAddress][state]" class="osky-form" data-required="1">
                                        <option value="20">20%</option>
                                        <option value="25">25%</option>
                                        <option value="30">30%</option>
                                        <option value="35">35%</option>
                                       <option value="40">40%</option>
                                        <option value="45">45%</option>
                                       <option value="50">50%</option>
                                        <option value="55">55%</option>
                                       <option value="60">60%</option>
                                        <option value="65">65%</option>
                                    </select>
                                   </span>
                            	</div>
                                
        					<button id="apply-coupon-btn" class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button" data-action="apply">
                            Save Settings</button>
        						
							</div>
						</div>
					</div>
             </div>
		</div>
        
	</div> 
</div>
 
<?php //$this->load->view('site/templates/footer'); ?>
