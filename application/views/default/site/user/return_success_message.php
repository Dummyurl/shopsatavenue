<div class="rtn-message" >
     <p>Your return request is successfull. Your return request number is RMA#<?php echo $rma_id; ?></p>
     <p>Product should reach us to the following address on or before <?php echo date( 'm/d/Y', strtotime( "+14 day" ) ); ?>.</p>
     <p></p>
     <p style="color:#000;"><strong>Shipping Address:</strong><br>
     	<?php echo $ship_address['legal_name']. '<br>' . $ship_address['ship_address1']; ?>
        <?php if ( $ship_address['ship_address2'] != '' ) {
			  echo  '<br>' . $ship_address['ship_address2'];
			 } ?>
		<?php echo  '<br>' . $ship_address['ship_city']. ', ' . $ship_address['ship_state']. ', ' . $ship_address['ship_zip']; ?>
     </p>
     <p style="font-size:smaller">After shipping the product, please update the carrier and tracking number in returns page</p>
     
</div>