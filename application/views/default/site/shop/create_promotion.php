<?php  $this->load->view('site/templates/merchant_header'); ?>
<style>
	.promotions-table {
		width: 85%;
		display: inline-block;
		border: 1px solid #dbdbdb;
		padding:10px;
		margin-left:15px;
		margin-top:15px;
		color:#4B4A4A;
	}
	.promotions-table .heading {  font-weight:700;}

label{
    width: 100%!important;
}
input[type='text'], input[type='number']{
    width: 100%!important;
    border-radius: 0;
    border: 0.5px solid #4c4a4e;
    color: #4c4a4e;
    height:44px;
    padding: 5px;

}
input[type='text']:focus{
    color: #999;
    border: .0625rem solid #67ccf3
}
.saa-textarea { border: 0.0625rem solid #4c4a4e; border-radius: 0px; }
.saa-select
{
      /*display: block;*/
    border: 1px solid #4c4a4e;
    color: #4c4a4e;
    background-color: #fff;
    box-shadow: none;
    transition: none;
    font-size: 18px;
    font-weight: 600;
    height:44px!important;
    padding: 5px;
    -webkit-appearance: none;
    appearance: none;
    border: 1px solid #28262a;
    background: #fff url('../images/select_down.svg') no-repeat right 10px top 50%;
    background-size: 3%;
    font-weight: 400;
    background-color: #fff;
    -moz-appearance : none!important;
    min-width:80px!important;
}  
</style>


<?php $pr = $promotions['promotions']; ?>

<div class="container" >

	<div class="row" >

		<div class="col-md-12"><h4>Promotions</h4></div>

        <div class="col-md-12" style="margin-top:10px;"><b><?php echo ($promo_type == 'product' ? 'Product ' : 'Store wide ' ); ?> Promotion</b></div>

        <div class="promotions-table">
			<?php if ( $promotion['promotion_type'] == 'product' ) { ?>
			  <div class="row" style="margin: 20px 0 0 10px;">
              		<div class="col-lg-1" >
                         <img class="upload-img1" src="/images/product/cropthumb/<?php echo $image;?>"  />
                    </div>
                    <div class="col-lg-5"><h1><?php echo $promotion['product_name']; ?></h1></div>
              </div>
              <?php } ?>
              
              <div class="col-md-12" >

                <form class="form-horizontal" method="post" action="" name="product_promotion" >
                <input type="hidden" name="promotion_id" value="<?php echo $promotion['promotion_id']; ?>"  />
                       <?php if(  $this->session->userdata('draft_product_message') != '' ) { ?>
                           <div style="background-color:#F00; color:#FFF;" align="center"><b>
                                <?php 
                                    echo $this->session->userdata('draft_product_message');
                                    $this->session->unset_userdata('draft_product_message');
                                 ?></b>
                           </div>
                       <?php } ?>
                      <div class="form-group">
                            <div class="col-md-2" >
                            	<label for="discount">Discount</label>
                                 <select class="saa-select"  name="discount" >
                                       <option value="0">0%</option>
                                 <?php for($i=1; $i <= 16; $i++) { ?>
                                       <option value="<?php echo ($i * 5); ?>" <?php echo $promotion['discount_percent'] == ($i * 5) ? 'selected' : ''; ?> ><?php echo ($i * 5); ?>%</option>
                                 <?php } ?>
                                 </select>
                            </div>
                      </div>
                      <div class="form-group">
                          <div class="col-md-8">
                            <input  name="free_shipping" placeholder="" value="1" type="checkbox" style="margin-top:0px" <?php echo $promotion['free_shipping'] == '1' ? 'checked' : ''; ?> >
                            Offer free shipping during this sale.
                          </div>
                      </div>
                      <div class="form-group">
                      <div class="col-lg-2"><label for="promotion_date">Start</label></div>
                      </div>
                      <div class="row">
                        <div class="col-lg-3" >
                            <div class="input-group date" >
                                <input type="text" name="promotion_date" id="promotion_date" class="form-control datepicker" value="<?php echo ($promotion['start_date'] != '') ? date('m-d-Y', strtotime($promotion['start_date']) ) : ''; ?>" />
                                <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                      </div>
                      <div class="form-group" style="margin-top:20px;">
                            <div class="col-md-6">
                                <?php $duration = $promotion['duration']; ?>
                                <label for="duration">Length</label>
                                <select class="saa-select" name="duration" >
                                    <option value="12H" <?php echo $duration == '12H' ? 'selected' : ''; ?> >12 Hours</option>
                                    <option value="24H" <?php echo $duration == '24H' ? 'selected' : ''; ?> >24 Hours</option>
                                    <option value="48H" <?php echo $duration == '48H' ? 'selected' : ''; ?> >48 Hours</option>
                                    <option value="7D" <?php echo $duration == '7D' ? 'selected' : ''; ?> >7 Days</option>
                                    <option value="2W" <?php echo $duration == '2W' ? 'selected' : ''; ?> >2 Weeks</option>
                                    <option value="1M" <?php echo $duration == '1M' ? 'selected' : ''; ?> >1 Month</option>
                                    <option value="1Y" <?php echo $duration == '1Y' ? 'selected' : ''; ?> >1 Year</option>
                                </select>
                            </div>
                      </div>
                      
                      <div class="form-group">
                           <div class="col-md-8">
                            <input  name="allow_credit" placeholder="" value="1" type="checkbox" style="margin-top:0px" <?php echo $promotion['allow_credit'] == '1' ? 'checked' : ''; ?> >                 Allow shoppers to use Credits during this sale.
                            </div>
                      </div>
        
                      <div style="width:20%">
                        <button type="submit" name="submit" class="button1"  value="Save_Promotion" >Save Promotion</button>
                      </div>                   
                </form>
          </div> <!-- form container -->
        </div>
        
    </div> 	 	
</div>

<?php $this->load->view('site/templates/footer'); ?>
<script type="text/javascript" src="js/timepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(function () {
	$('#promotion_date').datepicker({});
});
</script>





