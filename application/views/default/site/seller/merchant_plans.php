<?php $this->load->view('site/templates/merchant_header'); ?>
<style>
  
</style>
   
<div class="container" >
     <div class="row">
           <div class="col-md-12">
            <h4>Your Current Plan Details</h4>
           </div>
     </div>
     <div class="row" style="margin-top:20px;">
           <div class="col-md-6 col-xs-12">
               <div class="col-md-6 col-xs-6">Your Plan:</div>
               <div class="col-md-6 col-xs-6"><?php echo $current_plan->plan_name; ?></div>
           </div>
     </div>
     <div class="row">
           <div class="col-md-6 col-xs-12">
               <div class="col-md-6  col-xs-6">Plan Start Date:</div>
               <div class="col-md-6 col-xs-6"><?php echo date('m-d-Y H:i:s',strtotime($current_plan->plan_start_date)); ?></div>
           </div>
     </div>
     <div class="row">
           <div class="col-md-6 col-xs-12">
               <div class="col-md-6 col-xs-6">Plan End Date:</div>
               <div class="col-md-6 col-xs-6"><?php echo date('m-d-Y H:i:s',strtotime($current_plan->plan_end_date)); ?></div>
           </div>
     </div>

     <div class="row" style="margin-top:40px;">
           <div class="col-md-12">
            <h4>Your Past Plans</h4>
           </div>
     </div>
     
</div>

   

<script type="text/javascript">

</script>
	
<?php $this->load->view('site/templates/footer');?>