<?php

$this->load->view('site/templates/header');

?>
<style>
	.card
	{
		margin-top: 50px;
	}


/*** 
=============================================
    Contact Form area style
=============================================
***/
.contact-form-area {
    padding-bottom: 80px;
}
.contact-form-area .sec-title{
    padding-bottom: 40px;  
}
.contact-form-area .contact-form form input[type="text"],
.contact-form-area .contact-form form input[type="email"],
.contact-form-area .contact-form form textarea{
    background: #ffffff;
    border: 1px solid #f4f4f4;
    color: #999999;
    display: block;
    font-size: 16px;
    height: 55px;
    margin-bottom: 25px;
    padding: 0 20px;
    width: 100%;
    transition: all 500ms ease;
}
.contact-form-area .contact-form form textarea{
    height: 120px;
    margin-bottom: 31px;
    padding: 10px 20px;
}
.contact-form-area .contact-form form input[type="text"]:focus{
    border-color: #45c4e9;        
}
.contact-form-area .contact-form form input[type="email"]:focus{
    border-color: #45c4e9;        
}
.contact-form-area .contact-form form textarea:focus{
    border-color: #45c4e9;    
}
.contact-form-area .contact-form form button{
    width: 100%;
    padding: 13px 0 12px;
}

.contact-author-info ul{
    background: #f9f9f9;
    border: 1px solid #ececec;
    display: block;
    padding: 30px 20px;
}
.contact-author-info ul li {
    background: #ffffff;
    margin-bottom: 20px;
    padding-left: 20px;
    padding-top: 17px;
    padding-bottom: 20px;
}
.contact-author-info ul li .title {
    padding-bottom: 15px;
}
.contact-author-info ul li .title h3 {
    color: #222222;
    font-size: 18px;
    text-transform: uppercase;
    font-weight: 500;
}
.contact-author-info ul li:last-child{
    margin-bottom: 0;
}
.contact-author-info ul li .img-holder {
    width: 70px;
}
.contact-author-info ul li .img-holder,
.contact-author-info ul li .text-holder{
    display: table-cell;
    vertical-align: middle;
}
.contact-author-info ul li .text-holder {
    padding-left: 20px;
}
.contact-author-info ul li .text-holder h5 {
    color: #45c4e9;
    font-size: 16px;
    font-weight: 400;
    margin: 0 0 10px;
}
.contact-author-info ul li .text-holder p {
    margin: 0;
    line-height: 22px;
}
.contact-author-info ul li .text-holder p span:before {
    color: #45c4e9;
    font-size: 13px;
    display: inline-block;
    line-height: 13px;
    padding-right: 10px;
}

</style>

		
<?php $this->load->view('site/templates/user_menu'); ?>


<div class="container contact-form-area">
        <div class="row">
            <div class="col-lg-8 col-md-7">
                <div class="contact-form">
                    <div class="sec-title pdb-50">
                        <h3>Send Your Mesage Us</h3>
                        <span class="border"></span>
                    </div>
                    
                    <form id="contact-form" name="contact_form" class="default-form" action="" method="post" novalidate="novalidate">

                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="form_name" name="form_name" value="" placeholder="Your Name*" required="" aria-required="true">
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="form_email" id="form_email" value="" placeholder="Your Mail*" required="" aria-required="true">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="form_phone" name="form_phone" value="" placeholder="Phone">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="form_subject" id="form_subject" value="" placeholder="Subject">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea name="form_message" id="form_message" placeholder="Your Message.." required="" aria-required="true"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <div id="notificationUpdate">
								
								</div>

                                <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                <button onclick="saveContact()" class="thm-btn bgclr-1" type="button" data-loading-text="Please wait...">Send Message</button>
                            </div>
                        </div>
                    </form>  
                </div>
            </div>
            <div class="col-lg-4 col-md-5">
                <div class="contact-author-info">
                    <div class="sec-title pdb-50">
                        <h3>Reach US</h3>
                        <span class="border"></span>
                    </div>
                    <ul>
                        <li>
                            <div class="title">
                                <h3>Support Department</h3>
                            </div>
                          
                            <div class="text-holder">
                                <h5>Hendry Aravind</h5>
                                <p><span class="flaticon-telephone"></span>84578-25-658</p>
                                <p><span class="flaticon-back"></span>hendryaravind@gmail.com</p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <h3>Sales Department:</h3>
                            </div>
                            
                            <div class="text-holder">
                                <h5>Jack Daniel</h5>
                                <p><span class="flaticon-telephone"></span>98765-43-210</p>
                                <p><span class="flaticon-back"></span>jackdaniel@gmail.com</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                
                
            </div>
        </div>
    </div>

                    <div style="clear: both; height: 50px"></div>

<!-- Section_start -->



<?php 

$this->load->view('site/templates/footer');

?>

<script>
 function saveContact()
  {
   


var form_name = $("#form_name").val();
var form_email = $("#form_email").val();
var form_phone = $("#form_phone").val();
var form_subject = $("#form_subject").val();
var form_message = $("#form_message").val();



          jQuery.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "save_contact_support",
          dataType: 'json',
          data: {form_name: form_name, form_email: form_email,form_phone: form_phone,form_subject: form_subject,form_message: form_message},
          success: function(res) {
          if (res)
          {
          // Show Entered Value



      $("#notificationUpdate").html('<div class="col-xs-12 alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Your query submitted we will call you back soon.<span class="loadinpoint"></span></div><div style="clear:both"></div>');


        

        

       



          }
          }
          });

   

   // save_user_email_setting

   
  }
</script>