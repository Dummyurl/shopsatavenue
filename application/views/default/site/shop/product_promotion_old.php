<?php 
$this->load->view('site/templates/productheader');
$this->load->view('site/templates/shop_header'); 
$shopEditArr = array('admin-edit-product','admin-preview'); $shopAddArr = array('admin-listitem','admin-preview');
$showShopHeadList = 0;
if(in_array($this->uri->segment(1),$shopEditArr)){
	$showShopHeadList = 1;
}elseif(in_array($this->uri->segment(2),$shopAddArr)){ 
   $showShopHeadList = 1;
} 
?>


<?php if(isset($active_theme) &&  $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>Shop-page.css" rel="stylesheet">
<?php } ?>
<script type="text/javascript" src="js/site/timepicker/bootstrap-datepicker.js"></script>

<div class="list_inner_fields" id="shop_page_seller">   


	<div class="sh_content">
       <div style="margin: 0 0 0 20px">
		<h3>Create Promotion</h3>	
       </div>
    


    <div class="col-lg-12" >
<?php //echo "GV:" . print_r( $product_info, 1); exit(0); ?>   
        <form class="form-horizontal" method="post" action="" name="product_promotion" >
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  />
            <div class="col-lg-12 sh_border" >
               <?php if(  $this->session->userdata('draft_product_message') != '' ) { ?>
                   <div style="background-color:#F00; color:#FFF;" align="center"><b>
                        <?php 
							echo $this->session->userdata('draft_product_message');
							$this->session->unset_userdata('draft_product_message');
						 ?></b>
                   </div>
               <?php } ?>
			  <div class="row" style="margin-top:20px;">
              		<div class="col-lg-1" >
                         <img class="upload-img1" src="/images/product/cropthumb/<?php echo $image;?>"  />
                    </div>
                    <div class="col-lg-5"><h1><?php echo $product_name; ?></h1></div>
              </div>
			  <div class="row">
              		<div class="col-lg-2" >
                         <label for="discount">Discount</label>
                         <select name="discount" >
                               <option value="0">0%</option>
                         <?php for($i=1; $i <= 16; $i++) { ?>
                               <option value="<?php echo ($i * 5); ?>" <?php echo $discount == ($i * 5) ? 'selected' : ''; ?> ><?php echo ($i * 5); ?>%</option>
                         <?php } ?>
                         </select>
                    </div>
              </div>
              <div class="row">
                   <div class="col-lg-8">
                    <label  for="free_shipping" style="text-transform:none;" >Offer free shipping during this sale.
                    <input  name="free_shipping" placeholder="" value="1" type="checkbox" style="margin-top:0px" <?php echo $free_shipping == '1' ? 'checked' : ''; ?> >
                    </label>
                    </div>
              </div>
           	  <div class="row"><div class="col-lg-2"><label for="promotion_date">Start</label></div></div>
              <div class="row">
                <div class="col-lg-3" >
                    <div class="input-group date" >
                        <input type="text" name="promotion_date" id="promotion_date" class="form-control datepicker" value="<?php echo $promotion_date; ?>" />
                        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
              </div>
              <div class="row" style="margin-top:20px;">
              		<div class="col-lg-3">
                    	<label for="duration">Length</label>
                        <select name="duration" >
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
              <div class="row">
                   <div class="col-lg-8">
                    <label  for="allow_credit" style="text-transform:none;" >Allow shoppers to use Credits during this sale.
                    <input  name="allow_credit" placeholder="" value="1" type="checkbox" style="margin-top:0px" <?php echo $allow_credit == '1' ? 'checked' : ''; ?> >
                    </label>
                    </div>
              </div>

              <div class="form-group" style="padding:10px 0px 0px 0">
                <button type="submit" name="submit" class="btn btn-info"  value="Save_Promotion" >Save Promotion</button>
              </div>                   
           </div> <!-- sh border -->
        </form>
        
    </div>
        <script type="text/javascript">
            $(function () {
                    $('#promotion_date').datepicker({
    });
            });
        </script>
<?php $this->load->view('site/templates/footer');?>
