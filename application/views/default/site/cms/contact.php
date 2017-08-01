  <section class="container">
    	<div class="main" style="padding:30px 30px">
		
            <div class="contact-page">
            	<div class="col50">

            <div class="shop_title_abt"><?php echo $pageDetails->row()->page_title; ?></div>

            <div class="inner-container-cms" style="clear:both;">  <?php 

            	if ($pageDetails->num_rows()>0){

            		echo $pageDetails->row()->description;

            	}

            	?>				
				
			<?php #if($this->uri->segment(2) == 'contact-us' && $this->session->userdata['shopsy_session_user_name'] != ''){?>
			<script src="js/jquery.validate.js"></script>    
			<script>$(document).ready(function(){$("#feedBackform").validate(); });</script>

		</div>

		</div>
		
         </div>

        </div>

    </section>


