<?php $this->load->view('site/templates/header'); ?>
<style>
#main-content h2{
 margin-bottom:20px;
}
#main-content h3{
 margin-bottom:10px;
 font-size:18px;
}
#main-content #signinbt{
 width:400px;
 margin-bottom:40px;
}
#main-content p{
 margin-bottom:20px;
}

.checkbox p{
 margin-left:20px;
}
.col-centered{
    float: none;
    margin: 0 auto;
}

</style>

<?php $this->load->view('site/templates/user_menu'); ?>

<section id="">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-centered">
					<div id="main-content">
<h2>Email Settings</h2>
<p>We love communicating with you, but we want to fit your schedle!</p>

<p>Your email subscription for info@swiftglobal.net can be managed with the options below. To control how often you hear from us, please check the
appropriate boxes and click "Save" to update your preferences.</p>
<?php 
$subscribe = 0;
$promo_button = $page_items[0]['promotional'];
$newsale_discount = $page_items[0]['newsale_discounts'];

$emailmeless = $page_items[0]['emailmeless'];

$keepcoming = $page_items[0]['keepcoming'];



?>
<div class="row">
                        <div class="col-xs-8">
                          <div class="checkbox icheck">
                            <label>
                              <input type="checkbox" id="newsale_discount" <?php if($newsale_discount=='1'){ echo "checked='checked'";}?>> New Sale & Discount Alerts
                            </label>
                            <p>I would like to receive notifications about new sales and discounts on products i love</p>
                          </div>
                        </div>
                      </div>
                      
<div class="row">
                        <div class="col-xs-8">
                          <div class="checkbox icheck">
                            <label>
                              <input type="checkbox" id="promo_emails" <?php if($promo_button=='1'){ echo "checked='checked'";}?>> Promotional Emails
                            </label>
                            <p>I would like to receive updates on exclusive sales, new arrivals, trending products and more.</p>
                          </div>
                        </div>
                      </div>
                      
                       <p>

                       <div id="firstMessage">
                       
<div class="clear"></div>
</div>



                            <div id="signinbt">
                            <button class="btn btn-large btn-block btn-primary" type="submit" onclick="buttonSavepromo()">Save My Preferences</button>
                            </div>
                        </p>
                        
                        <h3>Email Me Less Frequently</h3>
                        <p>If you'd prefer for us to email you only once a week so you can still keep in touch from time to time, please click the button below.</p>
                        
                       <p>
                       <div id="secondMessage">
                       
<div class="clear"></div>
</div>
                            <div id="signinbt">
                            <?php //if($emailmeless==1){ ?> 
                            <button class="btn btn-large btn-block btn-primary" id='emailless' title='emaillesson' type="submit"  onclick="buttonSaveEmailLess()">One Email per Week, Thanks!</button>
                            <?php //} else {  ?>
                              <!--<button class="btn btn-large btn-block btn-error"  id='emailless' title='emaillessoff' type="submit"  onclick="buttonSaveEmailLess()">One Email per Week, Thanks!</button>-->
                              <?php //}  ?>
                            </div>
                       </p>
                            
                                <h3>Unsubscribe All (Have a store? Update your email settings above.)</h3>
                        <p>If you wish to unsubscribe from all emails from click the button below.</p>
                        
                       <p>

                       

                       <div id="fourthMessage">
                       
<div class="clear"></div>
</div>
                            <div id="signinbt">
                            <button class="btn btn-large btn-block btn-primary" type="submit" onclick="UnsubscribeAll()">Unsubscribe All</button>
                            </div></p>
                            
                            
                                <h3>Keep Them Coming</h3>
                        <p>On second thought, I'd like to continue receiving communications from shopsatavenue.com</p>
                        
                       <p>
                       <div id="thirdMessage">
                       <div class="clear"></div>
					   </div>
                            <div>
                             <?php if($keepcoming==1){ ?> 
                            <button class="btn btn-large btn-block btn-primary" id='keepcoming' title='keepcomingon' type="submit"  onclick="buttonSavekeepcoming()">Keep 'em Coming!</button>
                            <?php } else { ?>
                              <button class="btn btn-large btn-block btn-error"  id='keepcoming' title='keepcomingpoff' type="submit"  onclick="buttonSavekeepcoming()">Keep 'em Coming!</button>
                              <?php  }   ?>
                            </div>
                            </p>
</div>
</div></div></div></div>
<?php $this->load->view('site/templates/footer'); ?>

<script>
  function buttonSavepromo()
  {
   var promo_emails = 0;
   var newsale_discount = 0;
   if($("#promo_emails").is(":checked")){
    promo_emails = 1;
   }

   if($("#newsale_discount").is(":checked")){
    newsale_discount = 1;
  }


          jQuery.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "site/user_settings/save_user_email_setting",
          dataType: 'json',
          data: {newsale_discount: newsale_discount, promo_emails: promo_emails,forwhich:"first"},
          success: function(res) {
          if (res)
          {
          // Show Entered Value

         $("#firstMessage").html('<div class="col-xs-6 alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Mail Settings Saved Successfully.</div>');





          }
          }
          });

   

   // save_user_email_setting

   
  }

  function buttonSaveEmailLess()
  {
   

var presentStage = $("#emailless").attr("title");

if(presentStage=='emaillesson')
{
  var sendless = 0;
}
else
{
  var sendless = 1;
}

          jQuery.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "site/user_settings/save_user_email_setting",
          dataType: 'json',
          data: {sendless:sendless,forwhich:'second'},
          success: function(res) {
          if (res)
          {
          // Show Entered Value
          if(sendless==1){
            $("#emailless").removeClass("btn-error");
                $("#emailless").addClass("btn-primary");
                

                $('#emailless').attr('title', 'emaillesson');


         $("#secondMessage").html('<div class="col-xs-6 alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Email Me Less Frequently Enabled.</div>');
       }
       else
       {
        $("#emailless").addClass("btn-error");
                $("#emailless").removeClass("btn-primary");
             $('#emailless').attr('title', 'emaillessoff');
             $("#secondMessage").html('<div class="col-xs-6 alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Email Me Less Frequently Disabled.</div>');
       }





          }
          }
          });

   

   // save_user_email_setting

   
  }

    function buttonSavekeepcoming()
  {

    var presentStage = $("#keepcoming").attr("title");

    if(presentStage=='keepcomingon')
    {
      var keepcoming = 0;
    }
    else
    {
      var keepcoming = 1;
    }
   

          jQuery.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "site/user_settings/save_user_email_setting",
          dataType: 'json',
          data: {keepcoming: keepcoming,forwhich:'third'},
          success: function(res) {
          if (res)
          {
          // Show Entered Value



          if(keepcoming==1){
            $("#keepcoming").removeClass("btn-error");
                $("#keepcoming").addClass("btn-primary");
                

                $('#keepcoming').attr('title', 'keepcomingon');


         $("#thirdMessage").html('<div class="col-xs-6 alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Keep \'em Coming! Enabled.</div>');
       }
       else
       {
        $("#keepcoming").addClass("btn-error");
                $("#keepcoming").removeClass("btn-primary");
             $('#keepcoming').attr('title', 'keepcomingoff');
             $("#thirdMessage").html('<div class="col-xs-6 alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Keep \'em Coming! Disabled.</div>');
       }





          }
          }
          });

   

   // save_user_email_setting

   
  }
 function UnsubscribeAll()
  {
   

          jQuery.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "site/user_settings/save_user_email_setting",
          dataType: 'json',
          data: {newsale_discount: "0", promo_emails: "0",forwhich:"first"},
          success: function(res) {
          if (res)
          {
          // Show Entered Value

         $("#fourthMessage").html('<div class="col-xs-6 alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Unsubscribed All mails. Once done page automatically reload. Please wait a moment.<span class="loadinpoint"></span></div>');

        

         setTimeout(loadAppendpoint, 500);

 // use setTimeout() to execute
 setTimeout(showpanel, 3000);



          }
          }
          });

   

   // save_user_email_setting

   
  }

  function loadAppendpoint(){
     $(".loadinpoint").append(".");
       setTimeout(loadAppendpoint, 500);
  }
function showpanel() {     
  
  window.location.reload();
 }



  


  
</script>
