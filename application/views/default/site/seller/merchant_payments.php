<?php 
$this->load->view('site/templates/commonheader'); 
$this->load->view('site/templates/merchant_header');

?>
<style>
  
</style>
   
<div class="container" >
	<div class="col-md-12 col-xs-12 centered">
        <div class="row">
         <h4>Payments</h4>
         <br />
            <p><strong>ACH Payments</strong>: Shopsatavenue.com pays you 2 times a month via ACH Payments. Deposits are usually processed on the 15th and last day of each month, and take at least 2 to 3 business days to reach your bank account. These figures appear as positive numbers, unless your returns exceed your sales within a given 2-week period.</p>

			<p><a target="_blank" href="pages/payments">Learn more about payments</a>.</p>

        </div>
    </div>


                <div class="col-md-12 col-xs-12 centered">
                    <ul id="summary-tabs" class="tabs " role="tablist">
                            <li class="tabs-title" role="presentation">
                                <a href="#previous-period" role="tab" aria-controls="2017-07-10" aria-selected="false" id="previous-period-label">
                                    <div class="payment-label payment-date">6/16 - 6/30</div>
                                    <div class="payment-label payment-total currency"><span class="symbol">$</span><span class="dollars">48</span><span class="period">.</span><span class="cents">99</span></div>
                                    <div class="payment-label payment-status">Paid</div>
                                </a>
                            </li>
                                                    
                            <li class="tabs-title payment-period small-4 columns" role="presentation">
                                <a href="#2017-07-25" role="tab" aria-controls="2017-07-25" aria-selected="false" id="2017-07-25-label">
                                    <div class="payment-label payment-date">7/1 - 7/15</div>
                                    <div class="payment-label payment-total currency"><span class="symbol">$</span><span class="dollars">62</span><span class="period">.</span><span class="cents">39</span></div>
                                    <div class="payment-label payment-status">To Be Paid</div>
                                </a>
                            </li>
                                                    
                            <li class="tabs-title payment-period small-4 columns is-active" role="presentation">
                                <a href="#2017-08-10" role="tab" aria-controls="2017-08-10" aria-selected="true" id="2017-08-10-label">
                                    <div class="payment-label payment-date">7/16 - 7/31</div>
                                    <div class="payment-label payment-total currency"><span class="symbol">$</span><span class="dollars">-2</span><span class="period">.</span><span class="cents">41</span></div>
                                    <div class="payment-label payment-status">In Progress</div>
                                </a>
                            </li>
                    </ul>
                    <div class="tabs-content" data-tabs-content="summary-tabs">

             		</div>

                </div>
     
</div>

   

<script type="text/javascript">

</script>
	
<?php $this->load->view('site/templates/footer');?>