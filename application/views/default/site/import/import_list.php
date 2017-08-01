<?php $this->load->view('site/templates/merchant_header'); ?>
<div class="clear"></div>
<section class="container">
	<div class="main">
		<div class="shop_details">         
			<div class="payment_div"></div>	
				<div class="list_div" style="border-radius:5px 5px 0 0; margin:5px 0 0">
					<div class="payment_check">
						<div class="import-list">
							<ul>
                            	<li class="col-md-3">
                                	<a href="csv-upload"><img src="images/sales_channels/csvimport.png" alt="CSV Import" title="Import"  /></a>
                                    <label>Import products from CSV File</label>
                                </li>
								<li class="col-md-3">
									<a href="shopify-import">										
											<img src="images/sales_channels/shopify.png" alt="Shopify" title="Shopify" />
									</a>
                                    <label>Shopify store product import</label>
								</li>
							</ul>
						</div>
					</div>	   
				</div> 
			</form>
		</div>
	</div>
</section>
<?php 
$this->load->view('site/templates/footer',$this->data);
?>