<?php  
//die;
$this->load->view('site/templates/merchant_header');
$pr = $promotions['promotions'];

?>
<style>
.table-striped thead:first-child tr th, .table-striped thead:first-child tr td {
    background: #b4e2f3;
    color: #666;
}
main-style5.css:2
.table thead:first-child tr th, .table thead:first-child tr td {
    border-top: 0;
}
main-style5.css:2
.table-striped thead:first-child tr th, .table-striped thead:first-child tr td {
    background: #b4e2f3;
    color: #666;
}
main-style5.css:2
.table thead:first-child tr th, .table thead:first-child tr td {
    border-top: 0;
}
main-style5.css:2
.table-striped tr th, .table-striped tr td {
    background: #ededed;
}
main-style5.css:2
.table-striped tr th, .table-striped tr td {
    background: #ededed;
}
main-style5.css:2
.table th {
    font-weight: 700;
    vertical-align: bottom;
}
main-style5.css:2
.table th, .table td {
    padding: 8px 8px 8px 16px;
    line-height: 20px;
    text-align: left;
    border-top: 1px solid #999;
}
main-style5.css:2
.table th {
    font-weight: 700;
    vertical-align: bottom;
}
main-style5.css:2
.table th, .table td {
    padding: 8px 8px 8px 16px;
    line-height: 20px;
    text-align: left;
    border-top: 1px solid #999;
}
main-style5.css:1
table thead th, table thead td, table tfoot th, table tfoot td {
    padding: .25rem;
    font-weight: bold;
    text-align: left;
}
main-style5.css:1
table thead th, table thead td, table tfoot th, table tfoot td {
    padding: .25rem;
    font-weight: bold;
    text-align: left;
}
</style>
<div class="container" style="margin-top:60px;">

   <div class="table-row">
		<form  method="post" action="#" novalidate="novalidate">
                <div class="row" style="margin-left:0px;">
                    <div class="col-md-3">
                        <h6><a href="shop/promotions/current">Current Promotions (<?php echo $promotions['count']['current_promotions'];?>)</a></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><a href="shop/promotions/past">Past Promotions (<?php echo $promotions['count']['past_promotions'];?>)</a></h6>
                    </div>
                    <div class="col-md-4">
                        <a href="shop/create_promotion" style="background-color:#0e73bc; color:#fff; padding:10px 15px 10px 15px; border-radius:6px;">Add Promotions</a>
                    </div>
                </div>
                           
   				<div class="col-md-12" style="margin-top:20px;">
					<h2 class="">Promotions</h2>
                    <table class="table table-bordered table-striped" style="margin-top:0px;">
                                    <thead>
                                    <tr>
                                        <th class="span1">Name</th>
                                        <th class="span2">Price</th>
                                        <th class="span3">Length</th>
                                        <th class="span4">Start</th>
                                        <th class="span5">End</th>
                                        <th class="span6">Action</th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php foreach( $promotions['promotions'] as $key => $pr ) { 
                                           $price = "$". number_format($pr['price'],2);
                                           $new_price = "$" . number_format( $pr['price'] - ($pr['price'] /100 * $pr['discount_percent']) , 2);
                                           $free_shipping = $pr['free_shipping'] ? 'free shipping' : '';
                                           $allow_credit = $pr['allow_credit'] ? 'Use credits' : 'No credits';
                                           switch ( $pr['duration'] ){
                                               case "12H" :
                                                    $duration = "12 Hours";
													$strDuration = "+ 12 Hours";
                                                    break;
                                               case "24H" :
													$strDuration = "+ 24 Hours";
                                                    $duration = "24 Hours";
                                                    break;
                                               case "48H" :
													$strDuration = "+ 48 Hours";
                                                    $duration = "48 Hours";
                                                    break;
                                               case "7D" :
													$strDuration = "+ 7 Days";
                                                    $duration = "7 Days";
                                                    break;
                                               case "2W" :
													$strDuration = "+ 2 Weeks";
                                                    $duration = "2 Weeks";
                                                    break;
                                               case "1M" :
													$strDuration = "+ 1 Month";
                                                    $duration = "1 Month";
                                                    break;
                                               case "1Y" :
													$strDuration = "+ 1 Year";
                                                    $duration = "1 Year";
                                                    break;
                                                default:
                                           }
                                    ?>

                                    <tr>
                                        <td style="text-align:center;">
										<?php echo ($pr['promotion_type'] == 'product' ) ? $pr['product_name'] : 'Store Promotion'; ?></b>
                                        </td>
                                        <td>
											<?php if($pr['promotion_type'] == 'product' ) { ?>
                                                <div class="flash-price"><b>Offer <?php echo  $new_price; ; ?></b></div>
                                                <div class="initial-price">Current <?php echo $price; ?></div>
                                                <div class="percent"><?php echo $pr['discount_percent']; ?> % off</div>
                                                <div class="free-shipping"><?php echo $free_shipping; ?></div>
                                                <div class="credits-allowed"><?php echo $allow_credit; ?></div>
                                            <?php } else { ?>
                                                <div><?php echo $pr['discount_percent']; ?> % off</div>
                                                <div><?php echo $free_shipping; ?></div>
                                                <div><?php echo $allow_credit; ?></div>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $duration; ?></td>
                                        <td><?php echo date('m-d-Y',strtotime($pr['start_date']));?></td>
                                        <td><?php echo date( 'm-d-Y', strtotime( $pr['start_date'] . $strDuration ) );?></td>
                                        <td>
                                        <?php if($pr['promotion_type'] == 'product' ) { ?>
                                            <a href="site/shop/create_promotion/edit/<?php echo $pr['seourl'];?>" >EDIT</a> |
                                            <a href="site/shop/create_promotion/cancel/<?php echo $pr['seourl'];?>" >cancel</a> 
                                        <?php } else { ?>
                                            <a href="site/shop/create_promotion/edit" >EDIT</a> |
                                            <a href="site/shop/create_promotion/cancel" >cancel</a> 
                                        <?php } ?>
                                        </td>
                                    </tr>
									<?php } ?>

                                    </tbody>
                                </table>
				</div>
		</form>
	</div>
                  
</div>

<?php 
$this->load->view('site/templates/footer');
?>





