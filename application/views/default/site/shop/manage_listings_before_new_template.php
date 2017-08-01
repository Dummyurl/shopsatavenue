<?php 
$this->load->view('site/templates/commonheader');
$this->load->view('site/templates/shop_header'); 
$shopEditArr = array('admin-edit-product','admin-preview'); $shopAddArr = array('admin-listitem','admin-preview');
$showShopHeadList = 0; if(in_array($this->uri->segment(1),$shopEditArr)){
		  		$showShopHeadList = 1;
		   }elseif(in_array($this->uri->segment(2),$shopAddArr)){ 
	           $showShopHeadList = 1;
        }
?>
<?php if(isset($active_theme) &&  $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>Shop-page.css" rel="stylesheet">
<?php } ?>
<style>
#shop_page_seller{
	background:#FFF; 
	border-bottom: 1px solid #DDDDDD; 
	border-top: 1px solid #DDDDDD;  
	padding: 20px 0;
}
</style>
 <style>
.not-active {
 pointer-events: none;
 cursor: default;
}
</style>

<div id="shop_page_seller" > 
<div class="main">
<div id="tabs">

    <div id="tabs-2">    
            <div class="manage-listing-heading">
                <h1>Total Products<span>(<?php echo count($products); ?>)</span></h1>
                <p>Stock up! Listing 10 or more items gives buyers more opportunities to find your shop.</p>
            </div>
             <form class="tab_form_list" action="site/product/DeleteShopProducts" method="post">
				<div class="manage-table">
                 <table class="tab_form_list_table">
                    <thead>
                      <tr class="look">
                            <td colspan="7">
                            <span class="shuffle">
                            <input class="find-all" onchange="select_multiple(this);" type="checkbox" value="on" name="find_all[]">
                            <button class="secondary-button-delete" value="Delete" name="action" type="submit" onClick="return confirmDeletePrd();">Delete</button>
                            </span>
                            </td>
                        </tr>   
                        <tr class="table-header">
                            <th class="list-display"></th>
                            <th class="list-heading">Title<span class="sort-arrow"></span></th>        
                            <th class="list-wid"><span>In Stock</span></th>        
                            <th class="price-wid"><span>Price</span></th>        
                            <th class="date-wid">Listed<span class="sort-arrow"></span></th>
                            <th class="date-wid">Status<span class="sort-arrow"></span></th>
                            <th class="listgap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php  for( $i=0; $i < count($products); $i++ )   {
							$imgArr=explode(',' , $products[$i]['image']);
					?>
                        <tr id="listing-<?php echo $products[$i]->id; ?>" class="row-1 odd">
                            <td><input class="chkProd" type="checkbox" value="<?php echo $products[$i]['id']; ?>" name="deleteProducts[]"></td>
                            <td>
                                <div class="">
                                    <a class="list-image12" title="<?php echo $row->product_name; ?>" href="<?php echo base_url().'products/'.$products[$i]['seourl']; ?>">
                                        <img class="" width="50" height="50" alt="." src="images/product/<?php echo $products[$i]['id']; ?>/list-image/<?php echo $imgArr[0]; ?>">
                                    </a>
                                    <span class="center-text">
                                        <div>
                                            <a title="" href="<?php echo base_url().'products/'.$products[$i]['seourl']; ?>"><?php echo $products[$i]['product_name']; ?></a>
                                        </div>
                                    </span>
                                </div>
                            </td>        
                            <td class=""><?php echo $products[$i]['quantity']; ?></td>        
                            <td class="">
                                <span class="dolar-symbol">$</span>
                                <span class="dolar-value"><?php echo number_format($products[$i]['price'],2);  echo '+';  ?></span>
                                <!--<span class="dolar-code"><?php //echo $currencyType;?></span>-->
                            </td>
                            <td class=""><?php echo substr($products[$i]['created'],0,10); ?></td>
                             <td class=""><?php echo $products[$i]['status']; ?></td>
                            <td class="">
                                
										<a title="Edit listing" href="edit-product/<?php echo $products[$i]['seourl']; ?>" style="margin-right: 15%;"><image src="images/site/edit_icon.png" /></a>
									   <!--<a title="<?php //echo shopsy_lg('lg_copy_listing','Copy listing'); ?>" href="copy-product/<?php //echo $shopDetail[$i]->seourl; ?>"><image src="images/site/copy-icon.png" /></a>-->
									 
										<a class="<?php if($products[$i]['status'] != "Publish"){echo "not-active";} ?>" title="Make it Feature" href="site/cart/makeFeatrue/<?php echo $products[$i]['seourl']; ?>" style="margin-right: 15%;"><image src="images/site/activity.png" /></a>
                            </td>
                        </tr>
					<?php } ?>
                    </tbody>
                    <tfoot>       
                        <tr class="look styleback">
                            <td colspan="7">
                                <span class="shuffle">
                                  <input class="find-all" onchange="select_multiple(this);" type="checkbox" value="on" name="find_all[]">
                                    <button class="secondary-button-delete" value="Delete" name="action" onClick="return confirmDeletePrd();" type="submit">Delete</button>
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                 </table>  
				</div>
                 <span id="CPDel"></span>   
   
             </form>

   
   
    </div>

</div>
</div>
</div>
<a href="#feature_list" id="btn_popup" data-toggle="modal"></a>
<div id='feature_list' class="modal fade in language-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				 <div style='background:#fff;'>  
					<div class="conversation" style="width: 340px; margin-left: 191px; margin-top: 171px;">
						<div class="conversation_container">
							<h2 class="conversation_headline" style="margin: 8px;color: #9E612F;">  <?php echo shopsy_lg('lg_Valid_Till',' Valid Till '); ?>
							<label id="exp" name="exp"></label> <?php echo shopsy_lg('lg_Date',' Date'); ?>
							<?php echo shopsy_lg('lg_Are_You_Sure_Unfeature',' Are You Sure To Unfeature This Product');?>  </h2>
							<form action="site/cart/proceed2unfeature"  method="post">
								
								<input type="hidden" id="product_seourl" name="product_seourl" value="">							
							
								<div class="modal-footer footer_tab_footer">
										<div class="btn-group">
												<input type="submit" class="btn btn-default submit_btn" id="submit_pay" value="<?php echo shopsy_lg('lg_yes','YES'); ?>">
												<input type="submit" class="btn btn-default submit_btn" data-dismiss="modal" id="report-cancel" value="<?php echo shopsy_lg('lg_cancel','Cancel'); ?>">
										</div>
								</div>	
							</form>
						</div>
					</div>
				</div>			
			</div>
		</div>
	</div>	
<script>
function makepopup(seourl,expdate)
{
	$('#product_seourl').val(seourl);
	document.getElementById('exp').innerHTML=expdate;
	
	//document.getElementById('product_seourl').value=seourl;
	$('#btn_popup').trigger('click');
}
function select_multiple(evt){
	var val= $(evt).val();
	if(val == "on")
	{
		$('.chkProd').prop('checked', true);
		$('.find-all').prop('checked', true);
		$(evt).val("off")
	} else if(val == "off"){
		$('.chkProd').prop('checked', false);
		$('.find-all').prop('checked', false);
		$(evt).val("on")
	}
	
}
$('.chkProd').change(function(){
	if($('.chkProd:checked').length == $('.chkProd').length  ){
		$('.find-all').prop('checked', true);
		$('.find-all').val("off")
	}else{
		$('.find-all').prop('checked', false);
		$('.find-all').val("on")
	}/* $('.abc:checked').length == $('.abc').length */
});
/* function pay_feature()
{
	var pid=$('#product_seourl').val();
	var pack_id=$('#pack_id').val();
	if(pack_id != ""){
		$.ajax({
			type:'post',
				url	: baseURL+'site/checkout/pay_feature',
				dataType: 'json',			
				data:{'p_seo':pid,'pack_id':pack_id},
				success: function(response){
					
					alert(response);
				}
			
		});
	}else{
	}
	
} */
</script>
<?php $this->load->view('site/templates/footer');?>