<?php  
//die;
$this->load->view('site/templates/commonheader'); 
$this->load->view('site/templates/shop_header');

?>
<style>
   .promo_nav {
	   width:100%;
	   font-size:14px;
   }
   .promo_nav li { 
       display:inline; 
	   margin: 10px;
	}
	.promotions-table {
		width: 75%;
		display: inline-block;
		border: 1px solid #dbdbdb;
		color:#4B4A4A;
	}
	.promotions-table .heading {  font-weight:700;}
	.free-shipping, .initial-price, .credits-allowed, .percent { line-height:120%; }
.row::after {
		content: " ";
		display: table;
}
.row .row::after {
    clear: both;
}	
.action {
	text-transform:uppercase;
	font-stretch:extra-condensed;
	font-size:10px;
	font-weight:700;
	padding-top: 20px;
}

</style>
<?php if(isset($active_theme) &&  $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>Shop-page.css" rel="stylesheet">
<?php } ?>
<?php $pr = $promotions['promotions']; ?>
<div id="shop_page_seller" >
	<section class="container" >
        <div class="main">
            <ul class="bread_crumbs">
                <li><a href="<?php echo base_url(); ?>" class="a_links">Home</a></li>
                <span>&rsaquo;</span>
               <li><a href="shop/sell" class="a_links">Your shop</a></li>
               <span>&rsaquo;</span>
                <li>Promotions</li>
            </ul>
        </div>
		<div>
        	<h1>Promotions</h1>
        </div>
        <div class="promo_nav" >
           <ul>
             <li style="margin-left:0px;">
        	<a href="/shop/promotions/current">Current Promotions (<?php echo $promotions['count']['current_promotions'];?>)</a></li>
        	<li><a href="/shop/promotions/past">Past Promotions (<?php echo $promotions['count']['past_promotions'];?>)</a></li>
            <li></li>
            <li></li>
            <li><a class="btn btn-info" href="shop/create_promotion">Add Promotion</a></li>
            </ul>
        </div>
        <div><b><?php echo $promo_list; ?> Promotions</b></div>

        <div class="promotions-table">
           	<div class="row heading" >
                <div class="col-md-4" style="padding: 0px 0 0 25px;">Name</div>
                <div class="col-md-2">Price</div>
                <div class="col-md-2">Length</div>
                <div class="col-md-2">Start</div>
                <div class="col-md-2">Action</div>
    		</div>
            <?php foreach( $promotions['promotions'] as $key => $pr ) { 
				   $price = "$". number_format($pr['price'],2);
				   $new_price = "$" . number_format( $pr['price'] - ($pr['price'] /100 * $pr['discount_percent']) , 2);
				   $free_shipping = $pr['free_shipping'] ? 'free shipping' : '';
				   $allow_credit = $pr['allow_credit'] ? 'Use credits' : 'No credits';
				   switch ( $pr['duration'] ){
                       case "12H" :
					   		$duration = "12 Hours";
							break;
                       case "24H" :
                       		$duration = "24 Hours";
							break;
                       case "48H" :
					   		$duration = "48 Hours";
							break;
                       case "7D" :
					   		$duration = "7 Days";
							break;
                       case "2W" :
					   		$duration = "2 Weeks";
							break;
                       case "1M" :
					   		$duration = "1 Month";
							break;
                       case "1Y" :
					   		$duration = "1 Year";
							break;
						default:
                   }
			?>
           	<div class="row" >
                <div class="col-md-4" style="padding: 0px 0 0 25px;"><b><?php echo ($pr['promotion_type'] == 'product' ) ? $pr['product_name'] : 'Store Promotion'; ?></b></div>
                <?php if($pr['promotion_type'] == 'product' ) { ?>
                <div class="col-md-2">
                    <div class="flash-price"><b>Offer <?php echo  $new_price; ; ?></b></div>
                    <div class="initial-price">Current <?php echo $price; ?></div>
                    <div class="percent"><?php echo $pr['discount_percent']; ?> % off</div>
                    <div class="free-shipping"><?php echo $free_shipping; ?></div>
                    <div class="credits-allowed"><?php echo $allow_credit; ?></div>
                </div>
                <?php } else { ?>
                <div class="col-md-2" style="margin-top:10px;">
                    <div><?php echo $pr['discount_percent']; ?> % off</div>
                    <div><?php echo $free_shipping; ?></div>
                    <div><?php echo $allow_credit; ?></div>
                </div>
                <?php } ?>
                <div class="col-md-2"><?php echo $duration; ?></div>
                <div class="col-md-2"><?php echo date('m-d-Y',strtotime($pr['start_date']));?></div>
                <div class="col-md-2 action">
                	<a href="javascript:;">Share</a> |
                <?php if($pr['promotion_type'] == 'product' ) { ?>
                    <a href="/shop/create_promotion/edit/<?php echo $pr['seourl'];?>" >EDIT</a> |
                    <a href="/shop/create_promotion/cancel/<?php echo $pr['seourl'];?>" >cancel</a> 
                <?php } else { ?>
                    <a href="/shop/create_promotion" >EDIT</a> |
                    <a href="/shop/create_promotion" >cancel</a> 
                <?php } ?>
                </div>
    		</div>
            <?php } ?>
        </div>
    </section> 	 	
</div>


<?php 
$this->load->view('site/templates/footer');
?>





