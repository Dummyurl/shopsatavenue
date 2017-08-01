<?php $this->load->view('site/templates/commonheader'); ?>
<style>
.center {
    margin: auto;
    width: 100%;
    padding: 10px;
}
.register_box { margin:auto; width:300px; }

.center img { display:block; margin:auto; }
.page-head { text-align: center; line-height: 150%; letter-spacing: 3px; }
.head { text-align: center; line-height: 150%; letter-spacing: 3px; background-color:#CBEAEA; }

.register { margin:auto; width:150px; height:50px; border:1px solid #3FF; text-decoration:none; font-weight:800; padding-top:10px; border-radius:5px; }

.field_row { padding:10px; }

label { font-size:14px; color:#088278; }

</style>

<div class="container">
        <div class="row">
            <div class="col-md-12 logo" style="text-align:center !important;">
                  <a href="<?php echo base_url(); ?>"><img src="images/logo/<?php echo $this->config->item('logo_image'); ?>" alt="" style="margin-top:7px; text-align:center;"/></a>
            </div>
        </div>

     <?php if( isset($confirmation) ) { ?>
     	 <?php if( $confirmation['failed'] ) { ?>
         <div class="center" style="margin-top:20px; min-height:350px; width:90%">
              <p>Your Registraion is already confirmed!. Please contact administrator.</p>
         </div>
         <?php } else { ?>
         <div class="center" style="margin-top:20px; min-height:350px; width:90%">
               <p><span style="text-align:center; font-weight:700">Your shop registration is successfull!. </span></p>
                <p>
                   You can fill your shop information and import products until your request reviewed and approved.
                </p>
                <p>You can login using the following details:</p>
                <p  style="margin: 0cm 0cm 12pt; font-size: 9pt; font-family: Arial, sans-serif; color: rgb(76, 76, 76);">
                <table>
                   <tr>
                        <td>Login URL:</td><td><a href="<?php echo base_url().'login';?>"><?php echo base_url().'login';?></a></td>
                   </tr>
                   <tr>
                        <td>User Name:</td><td><?php echo $confirmation['email'];?></td>
                   </tr>
                   <tr>
                        <td>Password:</td><td>as you entered in Registration</td>
                   </tr>
                </table>
                </p>
               
         </div>
         <?php }  ?>

     <?php } else { ?>
     <div class="center" style="margin-top:20px; min-height:350px; width:90%">
           <p><h2 style="text-align:center;">Your shop registration is successfull!. </h2></p>
           
           <p ><h2 style="text-align:center;">Please check your email and confirm your Registration.</h2></p>
     </div>
     <?php } ?>
</div>

<?php $this->load->view('site/templates/footer'); ?>
