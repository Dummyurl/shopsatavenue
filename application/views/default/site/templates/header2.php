</head>
<body>
 		<?php if($this->session->flashdata('sErrMSG') != '') { ?>
                <div class="errorContainer logoutdiv alert alert-success text-center" id="<?php echo $this->session->flashdata('sErrMSGType'); ?>">
                  <p><span><?php echo $this->session->flashdata('sErrMSG');  ?> </span></p>
                </div>
   		 <?php } ?>
	<!-- Header -->
	<header class="navbar navbar-default navbar-fixed-top">
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
					<div class="col-md-3 col-sm-2">
                            	<div class="input-groupform-group has-feedback" >
								<input name="item" class="form-control search-input"  placeholder="Search Products" type="search"  >
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                <!--<span class="input-group-addon" ><i class="glyphicon glyphicon-search"></i></span>-->
                                </div>
					</div> 
					<div class="col-md-2 col-sm-2" ><button type="submit" class="btn btn-primary search-button"  >Search</button></div>
					</form><!-- Search form -->
					<div class="col-md-3 col-sm-12">

							<?php if($this->session->userdata['shopsy_session_user_name'] == '') { ?>
							<div class="book-table">
							<a href="register">Sign Up</a>
                            <a href="login">Sign In</a>
							<a href="site/shop/plans" ><i class="fa fa-shopping-cart" style="padding-right:10px;"></i>Open Store</a>
							</div> <!-- Book a table -->
            				<?php } else { ?>
                            	<?php $this->load->view('site/templates/menu_after_login'); ?>

        					<?php } ?>

                    </div>
				</div>
			</div><!-- container -->
		</div><!-- Logo and search area -->
        
		<!-- main menu -->
	<div class="container" style="padding:0" >
        <nav class="navbar navbar-default nav-category" role="navigation" style="border-color:#FFF;" >
           <div class="container-fluid" >
               <div class="navbar-header">
                   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#category-menu">
                       <span class="sr-only">Toggle navigation</span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                    </button>
               </div>
				<div class="collapse navbar-collapse" id="category-menu">
                        
						<?php $MainCat_qry = $this->product_model->get_main_category(); ?>
					    <ul class="nav navbar-nav">
                        
						<?php foreach( $MainCat_qry->result() as $main_cat ) {   ?>
					    	<li><a href="<?php echo base_url()."search/cat/".$main_cat->seourl;?>"><?php echo $main_cat->cat_name; ?></a></li>
         					<?php if( $main_cat->id == 17 ) { ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color:#777 !important;">More</a>
                                    <ul class="dropdown-menu header-sub-menu">
                            <?php } /*else if ( $main_cat->id > 17 ) { ?>
						            <li><a href="<?php echo base_url()."search/cat/".$main_cat->seourl;?>"><i class="fa fa-angle-double-right"></i><?php echo $main_cat->cat_name; ?></a></li>
							<?php }*/ ?>

						<?php	}  //endforeach ?>
                                    </ul>
                                </li>
                            <li><a href="#">SALE</a></li>
                            <li><a href="#">FEATURED</a></li>

					    </ul><!-- navbar-nav -->
					</div>
           </div>
		</nav>
    </div>

	</header>
    <!-- Header End -->
	<div class="container-fluid">
	<!-- service section-->
	<section class="service">
		<div class="container">
			<div class="row">
				<img src="images/banner/topbanner1.jpg" class="img-responsive">
			</div>
		</div> <!-- container -->
	</section><!-- service section end -->
    </div>

