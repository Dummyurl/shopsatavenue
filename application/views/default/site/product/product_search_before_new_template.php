<?php $this->load->view('site/templates/header'); $segmentArr=$this->uri->segment_array();   ?>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/default/site/themes-smoothness-jquery-ui.css" >
<script type="text/javascript" src="js/currency/jquery.formatCurrency-1.4.0.js"></script>
<link rel="stylesheet" type="text/css" href="a_data/jquery-ui.css">  
<script type="text/javascript" src="js/front/freewall.js"></script>
<?php if(isset($active_theme) &&  $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>Search-page.css" rel="stylesheet">
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>header.css" rel="stylesheet">
<link href="./theme/themecss_<?php echo $active_theme->row()->id;?>footer.css" rel="stylesheet">
<?php } ?>
<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,700,400italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/default/site/base.css" />
<link rel="stylesheet" href="css/default/site/style-menu.css" />

<style>
.color-filter li{ 
	display:inline-block;
	width:25px;
	height:25px;
	border-radius:4px;
} 

.color-filter li a {
  display: block;
  font-weight: bold;
  margin: 0 8px;
  padding: 5px;
  border-radius: 4px;
  width: 25px;
  height: 25px;
}  

.list-inline-item span img {
	width: inherit;
  	height: inherit;
 } 
</style>
<style>
.loading-bar {
	border: 1px solid #DDDDDD;
    border-radius: 5px;
    box-shadow: 0 -45px 30px -40px rgba(0, 0, 0, 0.05) inset;
    clear: both;
    cursor: pointer;
    display: block;
    float: none;
    font-family: "museo-sans",sans-serif;
    font-size: 2em;
    font-weight: bold;
    margin: 20px 0px 20px 0;
    padding: 10px 0px;
    position: relative;
    text-align: center;
    width: 100%;
}
.loading-bar:hover {
	box-shadow: inset 0px 45px 30px -40px rgba(0, 0, 0, 0.05);
}
.standardized_filters {
    float: left;
    width: 30%;
}
.product-search-page {
    float: left;
    width: 70%;
}
.product-search-page .product_listing li {
    height: 220px;
    margin: 0 0 24px 25px;
    width: 208px;
}
/*.filter-cat-menu li { padding:10px; }*/
.checkbox label:after, 
.radio label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr,
.radio .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon,
.radio .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.radio .cr .cr-icon {
    margin-left: 0.04em;
}

.checkbox label input[type="checkbox"],
.radio label input[type="radio"] {
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon,
.radio label input[type="radio"] + .cr > .cr-icon {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
.radio label input[type="radio"]:checked + .cr > .cr-icon {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr,
.radio label input[type="radio"]:disabled + .cr {
    opacity: .5;
}
</style>    

<?php $c_url=current_url();  
	
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
<div id="product_search_div">
<section class="container">
  		<div id="content">
        	<div class="purchase_review product-search-main">

            	<div class="content-wrap-inner1">
					<div id="secondary">
                         <div style="float:left;"><?php echo count( $product_list); ?> Product(s) found!</div>
                    </div>
                    <div id="primary">
                         <div id="sort_header" style="float:right;">
                             <div class="sort-options no-views btn-secondary">
                                <label>Sort by:</label>
                                <ul id="menu">
                                    <li><a href="javascript:void(0);" id="order">
                                            <?php 
                                            if($this->input->get('order') == 'date_desc'){
                                                 echo 'Most Recent'; $recentAct='active';
                                            }  else if($this->input->get('order') == 'most_relevant') { 
                                                 echo 'Relevancy'; $relevanttAct='active';
                                            } else if($this->input->get('order') == 'price_desc'){
                                                 echo 'Highest Price'; $priceHigh='active';
                                            } else if($this->input->get('order') == 'price_asc'){
                                                 echo 'Lowest Price'; $priceLow='active';
                                            }
                                            ?>
                                            <img src="images/down_arrow.png"></a>
                                        <ul class="sub-menu">
                                        <span class="cursor"></span>
                                        <li><a href="<?php  echo $c_url.'?'.$s_key.$s_gift.$min_price.$max_price.$location.$shipto.'&order=date_desc';?>" id="Relevancy" class="<?php echo $recentAct;?>">Most Recent</a></li>
                                        
                                        <li><a href="<?php  echo $c_url.'?'.$s_key.$s_gift.$min_price.$max_price.$location.$shipto.'&order=most_relevant';?>" id="Alphabetical" class="<?php echo $relevanttAct;?>">Relevancy</a></li>
                                         <li><a href="<?php  echo $c_url.'?'.$s_key.$s_gift.$min_price.$max_price.$location.$shipto.'&order=price_desc';?>" id="Highest" class="<?php echo $priceHigh;?>">Highest Price</a></li>
                                        <li><a href="<?php  echo $c_url.'?'.$s_key.$s_gift.$min_price.$max_price.$location.$shipto.'&order=price_asc';?>" id="Lowest" class="<?php echo $priceLow;?>">Lowest Price</a></li>
                                        </ul>
                                    </li>
                                 </ul>
                                    
                              </div>
                         </div>
                     </div>
            	</div>

            	<div class="content-wrap-inner1">
                    
                        <div id="secondary" class="standardized_filters">
                        	<div id="search-filters" class="secondary-liner">
                            <ul class="filter-cat-menu">
                            <?php foreach( $main_cat_qry->result() as $category ) { ?>
                            		<li>
                                        <div class="checkbox">
                                          <label>
                                            <input type="checkbox" name="cat_id" value="<?php echo $category->id; ?>" >
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <?php echo $category->cat_name; ?>
                                          </label>
                                        </div>
                                    </li>
                            <?php } ?>
                            </ul>
                            </div>
                        </div>
               
                    	<div id="primary">
							<div id="freewall" class="free-wall" style="margin-bottom: 51px;"> 
                            <div id="tiles">
                        
            <?php 
				if(!empty($product_list)) { 
					$i=0;
					foreach( $product_list as $proddetails ) {
                  	$imgSplit = explode(",",$proddetails['image']); 
					$shopDet = $this->product_model->get_business_name($proddetails['user_id']);
			?>
            	 <div class="brick">     
                    <div class="brick-hover">
                                <div class="product_hide">                                    
                                    <div class="product_fav">                             
										<?php if($loginCheck !=''){ ?>
										<?php if($proddetails['user_id']==$loginCheck){ ?>
										<a href="javascript:void(0);" onclick="return ownProductFav();">
                                            <input type="submit" value="" class="hoverfav_icon" />
                                        </a>
										<?php
										}else{
                                        $favArr = $this->product_model->getUserFavoriteProductDetails(stripslashes($proddetails['id']));
                                        #print_r($favArr); die;
                                        if(empty($favArr)){ ?>
                                        <a href="javascript:void(0);" onclick="return changeProductToFavourite('<?php echo stripslashes($proddetails['id']); ?>','Fresh',this);">
                                            <input type="submit" value="" class="hoverfav_icon" />
                                        </a>
                                        <?php  } else { ?>                        
                                        <a href="javascript:void(0);" onclick="return changeProductToFavourite('<?php echo stripslashes($proddetails['id']); ?>','Old',this);">
                                            <input type="submit" value="" class="hoverfav_icon1" />
                                        </a>
                                        <?php }}} else { ?>
                                        <a href="login" >
                                            <input type="submit" value="" class="hoverfav_icon" />
                                        </a>
                                        <?php  } ?> 
                                    </div>  
                                     
                                    <div class="hoverdrop_icon">
                                    	<a href="javascript:hoverView('<?php echo $i; ?>');">  </a>
                                        	<div class="hover_lists" id="hoverlist<?php echo $i; ?>">
                                               	<h2><?php if($this->lang->line('user_your_lists') != '') { echo stripslashes($this->lang->line('user_your_lists')); } else echo "Your Lists"; ?></h2>
                                                <div class="lists_check">
                                                	<?php foreach($userLists as $Lists){ 
													$haveListIn = $this->user_model->check_list_products(stripslashes($proddetails['id']),$Lists['id'])->num_rows();
													#echo $haveListIn;
													if($haveListIn>0){$chk='checked="checked"';}else{ $chk='';}
													?>
                                                    <input type="checkbox" class="check_box" onclick="return addproducttoList('<?php echo $Lists['id']; ?>','<?php echo stripslashes($proddetails['id']); ?>');" <?php echo $chk; ?> />
                                                    <label><?php echo $Lists['name']; ?></label>
                                                    <?php } ?>
                                                     <?php if(!empty($userRegistry)){ 
														$haveRegisryIn = $this->user_model->check_registry_products($proddetails['id'],$userRegistry->user_id)->num_rows();
														if($haveRegisryIn>0){$chk='checked="checked"';}else{ $chk='';}
													?>
													<input type="checkbox" class="check_box" onclick="return manageRegisrtyProduct('<?php echo $userRegistry->user_id; ?>','<?php echo $proddetails['id']; ?>');" <?php echo $chk; ?> />
													<label><span class="registry_icon"></span><?php if($this->lang->line('prod_wedding') != '') { echo stripslashes($this->lang->line('prod_wedding')); } else echo "Wedding Registry"; ?></label>
													<?php }  ?>
                                                 </div>                                                    
                                                    <div class="new_list">
                                                    <form method="post" action="site/user/add_list">
                                                        <input type="hidden" value="1" name="ddl" />
                                                        <input type="hidden" value="<?php echo $proddetails['id']; ?>" name="productId" />
                                                        <input type="text" placeholder="<?php if($this->lang->line('user_new_list') != '') { echo stripslashes($this->lang->line('user_new_list')); } else echo "New list"; ?>" class="list_scroll" name="list" id="creat_list_<?php echo $i; ?>" />
                                                        <input type="submit" value="<?php if($this->lang->line('user_add') != '') { echo stripslashes($this->lang->line('user_add')); } else echo "Add"; ?>" class="primary-button" onclick="return validate_create_list('<?php echo $i; ?>');" />
                                                    </form>
                                                </div>
                                        	</div>
                                    	
                                   	</div>  
                               </div>
                      
                        <a href="products/<?php echo $proddetails['seourl'];?>">
                            <img  src="<?php if(!empty($imgSplit[0])){ ?>images/product/<?php echo $proddetails['id'];?>/thumb/<?php echo stripslashes($imgSplit[0]); } else { echo "images/dummyProductImage.jpg";  }?>" 
                              alt="<?php echo stripslashes($proddetails['product_name']);?>" title="<?php echo stripslashes($proddetails['product_name']);?>" width="100%" />
                        </a>
           			</div>

                    <div class="info">
						<h3><?php echo $proddetails['product_name']?></h3>
						<span class="cat-name"><a href="shop-section/<?php echo $shopDet->row()->shop_seourl; ?>"><?php echo $shopDet->row()->shop_name?></a></span>
						
						<span class="cat-name cat-price">
							<?php if($proddetails['price'] != 0.00) {?>
                             <span class="currency_value" ><?php echo $currencySymbol; echo number_format($currencyValue*$proddetails['price'],2)?></span>
                            <span class="currency_code"><?php echo $currencyType;?></span>
                            <?php } else { ?> 
                            <span class="currency_value"><?php echo $currencySymbol; echo number_format($currencyValue*$proddetails['base_price'],2); echo '+';?></span>
                            <span class="currency_code"><?php echo $currencyType;?></span>
                            <?php }?>
                    	</span>
						
					</div>
                    
                </div> 
				<?php  $i++;	
					   } //end foreach
				?>
		<?php }  else { ?>
				<h2>No Products Found In Your Search</h2> 
		<?php } ?>
						
			<?php echo $paginationDisplay;?>

     						</div>
						
							</div>
						<div id="load_ajax_img" style="text-align: center;"></div>
                        </div>
						
						
                 </div>
			</div>
         </div>

<!--        </div> -->
</section>
</div>


<script>
$(document).ready(function(e) {
});
$(document).ready(function(e) {
});
</script>

<script type="text/javascript">
/*var loading = true;
$(window).scroll(function(){
	if(loading==true){
		if(($(document).scrollTop()+$(window).height())>($(document).height()-200)){
			//wall.fitWidth();
			$url = $(document).find('.landing-btn-more').attr('href');
			console.log($url);
			if($url){
				loading = false;
				$(document).find('#load_ajax_img').append('<img id="theImg" src="<?php //echo base_url(); ?>images/loader64.gif" />');
				$.ajax({
					type : 'get',
					url : $url,
					dataType : 'html',
					success : function(html){
						
						$html = $($.trim(html));
						//console.log($html);
						$(document).find('.landing-btn-more').remove();
						$(document).find('#tiles').append($html.find('#tiles').html());
						$(document).find('#tiles').after($html.find('.landing-btn-more'));
						wall.fitWidth();
						setTimeout(function(){wall.fitWidth();},100);
						
					},
					error : function(a,b,c){
						console.log(c);
					},
					complete : function(){
						$("#load_ajax_img img:last-child").remove();
						loading = true;
						
					}
				});
			}
		}
	}
});*/

</script>

<?php $this->load->view('site/templates/footer'); ?>