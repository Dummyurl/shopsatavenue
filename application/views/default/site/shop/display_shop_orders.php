<?php 
$this->load->view('site/templates/commonheader');
$this->load->view('site/templates/shop_header');
$this->load->model('user_model');
//echo $orderDetails[0]->TotalAmt
$total_earnings = 0.0; 

?>
<link href="css/default/jquery-ui.css" rel="stylesheet" type="text/css"/>

<?php if(isset($active_theme) &&  $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>Shop-page.css" rel="stylesheet">
<?php } ?>
<style>
.table-header th {
    text-align: center;
    height: 39px;
    vertical-align: middle;
}
.active { background-color: rgba(0, 0, 0, 0.15) !important; }
#result_box { clear:both; border:1px solid #A0A0A4; margin-left:10px; margin-right:10px; }
.order-row { width:100%; margin:0; border-bottom:0.5px solid #A0A0A4; }
.order-row div { display:inline-block; padding: 10px 0 10px 10px; }
.head-row { font-weight:bold; }
.order-row:last-child { border-bottom:none; }
.order-row div:nth-child(1) { width:120px;  }
.order-row div:nth-child(2) { width:100px; }
.order-row div:nth-child(3) { width:100px; }
.order-row div:nth-child(4) { width:100px; }
.order-row div:nth-child(5) { width:250px; }
.order-row div:nth-child(6) { width:100px; text-align:right; }

.return-row { width:100%; margin:0; border-bottom:0.5px solid #A0A0A4; }
.return-row div { display:inline-block; padding: 10px 0 10px 10px; }
.return-row:last-child { border-bottom:none; }
</style>

<div class="clear"></div>

<div id="shop_page_seller">
<section class="container">

  <div class="main">    			
     
		<ul class="bread_crumbs">
        	<li><a href="<?php echo base_url(); ?>" class="a_links">Home</a></li>
            <span>&rsaquo;</span>
           <li><a href="shop/sell" class="a_links">Your shop</a></li>
		   <span>&rsaquo;</span>
		   <li>Shop orders</li>
         </ul>

        <div class="section community_right">
                <div class="heading_account">Delivered Orders</div>
                <div class="account_info">
                    <h1 style="text-align:center !important;"><?php echo $orderDetails[0]->orders; ?></h1>
                </div>             
        </div>
            
        <div class="section community_right">
                <div class="heading_account">Total Earnings $</div>
                <div class="account_info">
                    <h1 style="text-align:center !important;">
                        <?php  echo number_format($total_earnings,2); ?> 
                    </h1>
                    
                </div>             
         </div>
            
         <div class="section community_right">
                <div class="heading_account">Withdrawal Earnings $</div>
                <div class="account_info">
                    <h1 style="text-align:center !important;">
                        <?php echo number_format($currencyValue*$paidDetails[0]->totalPaid,2);?>
                    </h1>
                </div>             
         </div>
            
         <div class="section community_right">
                <div class="heading_account">Balance Earnings $</div>
                <div class="account_info">
                    <h1 style="text-align:center !important;">
                        <?php 
                            $balance_amt= $total_earnings - $currencyValue*$paidDetails[0]->totalPaid; 									
                        ?>
                        <?php echo number_format($balance_amt,2);?>
                    </h1>
                    <h2 style="text-align:center !important;margin-top: -11px;"><?php echo shopsy_lg('lg_to_ear-withdar_earning','(Total Earnings - Withdrawal Earnings)');?>
                    
                    
                    </h2>
          		</div>             
         </div>
		<div class="purchase_review container community_right" >     					
	
			<div class="all-purchase-search">
        		<div class="top_list" style="width: 90%;margin: 0px 0px 10px 10px;">
                    <ul style="width:auto;" class="listtypename">
                       <li class="<?php echo $tab_name == '' ? 'active' : '';?>" >
                            <a title="" href="shops/<?php echo $shop->seourl; ?>/shop-orders"  >
                                <div class="name-inner">New Orders</div>
                            </a>
                       </li>
                       <li class="<?php echo $tab_name == 'Shipped' ? 'active' : '';?>" >
                            <a title="" href="shops/<?php echo $shop->seourl; ?>/shop-orders?tab_name=Shipped"  >
                                <div class="name-inner">Shipped</div>
                            </a>
                       </li>
                       <li class="<?php echo $tab_name == 'Cancelled' ? 'active' : '';?>" >
                            <a title="" href="shops/<?php echo $shop->seourl; ?>/shop-orders?tab_name=Cancelled" class="" >
                                <div class="name-inner">Cancelled</div>
                            </a>
                       </li>
                       <li class="<?php echo $tab_name == 'returns' ? 'active' : '';?>" >
                            <a title="" href="shops/<?php echo $shop->seourl; ?>/shop-orders?tab_name=returns" >
                                <div class="name-inner">Returns</div>
                            </a>
                       </li>
                    </ul>
      			</div>
            </div>

            <div id="result_box">
            <?php if( $tab_name == 'returns' ) { ?>
                <div class="return-row row head-row" >
                    <div>RMA #</div>
                	<div>Order #</div>
                    <div>Product</div>
                    <div>Quantity</div>
                    <div>Status</div>
                    <div>RTN created</div>
                </div>
                <?php foreach( $returns as $key => $row ) : ?>
                        <div class="return-row row" >
                        	 <div><?php echo $row['rma_id']; ?></div>
                             <div><?php echo $row['order_number']; ?></div>
                             <div></div>
                             <div><?php echo $row['quantity']; ?></div>
                             <div><?php echo $row['return_status']; ?></div>
                             <div><?php echo date('m/d/Y', strtotime($row['date_created'])); ?></div>
                        </div>
                <?php endforeach; ?>
            <?php } else { ?>
                <div class="order-row row head-row" >
                    <div>Order Status</div>
                	<div>Order #</div>
                    <div>Approved Date</div>
                    <div>Ship Due Date</div>
                    <div>Ship To</div>
                    <div>Order Total</div>
                </div>
                <?php foreach( $orders as $key => $row ) : ?>
                        <div class="order-row row" >
                        	 <div><?php echo $row['order_status_name']; ?></div>
                             <div><?php echo $row['store_order_id']; ?></div>
                             <div><?php echo date('m/d/Y', strtotime($row['date_added'])); ?></div>
                             <div><?php echo date('m/d/Y' , strtotime('+2 day', strtotime($row['date_added']) )); ?></div>
                             <div><?php echo $row['shipping_firstname']; ?></div>
                             <div><?php echo number_format($row['total'],2); ?></div>
                        </div>
                <?php endforeach; ?>
            <?php } ?>
            </div>
            
		</div>                 
	
   </div> <!-- main -->
        
</section>

</div>
 
<script>
$(document).ready(function(){
	$(".changeShipstatusShopCustom").change(function(){
		var dealCodeNumber=$(this).attr('data-val-id');
		var shipping_status=$(this).val();
		var con = confirm('Whether you want to continue this action?');
		if (con) {
			$("#dealCodeNumber").val(dealCodeNumber);
			$("#shipping_status").val(shipping_status);
			if(shipping_status == 'Shipped'){
				$("#edd").show();
				$("#sid").show();
			}else{
				$("#edd").hide();
				$("#sid").hide();
			}	
			$('#show_orderPopup')[0].click();	
		} else {
				return false;
		}
		$('html, body').animate({
	        scrollTop: 0
	    });
	});	
});
</script>
<script type="text/javascript">
//jQuery.noConflict();				
function search_Orders(){
	var shop = $("#sellerurl").val();
	var from = $("#orderfrom").val();
	var to = $("#orderto").val();
	var id = $("#transaction").val();
	//var order = $("#orderType").val();
	if(id !=''){
		window.location.href= "shops/"+shop+"/shop-orders?id="+id+"";
	}else{
		if((from == '' && to != '') || (from != '' && to == '')){
			alert(lg_Selec_both_fromand_todate);
			return false;
		}
		window.location.href= "shops/"+shop+"/shop-orders?from="+from+"&to="+to+"&id="+id+"";
				
	}
		//window.location.href= "shops/"+shop+"/shop-orders?from="+from+"&to="+to+"&id="+id+"&order="+order+"";
}
</script> 

<style type="text/css">
.section {
    height: 128px;
    width: 24%;
}
.section:first-child {
	margin-left:0px;
}
.heading_account{
	text-align: center;
}
</style>

<?php $this->load->view('site/templates/footer'); ?>