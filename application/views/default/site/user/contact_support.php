<?php $this->load->view('site/templates/header'); ?>
<?php $this->load->view('site/templates/user_menu'); ?>

<style>
select{height:3.7rem;padding:.5rem;border:1px solid #414042;margin:0 0 1rem;font-size:1.5rem;font-family:inherit;line-height:normal;color:#414042;background-color:#fefefe;border-radius:0;-webkit-appearance:none;-moz-appearance:none;background-image:url("images/select_down.svg");background-size:9px 6px;background-position:right -1rem center;background-origin:content-box;background-repeat:no-repeat;padding-right:1.5rem}
label { float:left; }
</style>

<div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7">
                <div class="contact-form">
                    <h3 class="text-left">Contact Support</h3>
                    <form id="contact-form" name="contact_form" class="default-form" action="" method="post" novalidate="novalidate">
                        
                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                	<label for="query_type">Query Related to</label>
                                	<select name="query_type"  >
                                        <option value="general" >General query</option>
                                        <option value="order" >Order Related</option>
                                        <option value="shipment" >Shipment Related</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                	<label for="user_message">Enter your query <small>( max. 1000 characters )</small></label>
                                	<textarea name="user_message" id="user_message" placeholder="Query..." required="" aria-required="true" class="form-control"></textarea>
                                </div>
                                <div id="notificationUpdate"></div>
                                <div class="form-group">
                                    <button name="btn-save" onclick="saveContact()" class="btn btn-large btn-block btn-primary" type="button" data-loading-text="Please wait...">Send Message</button>
                                </div>
                            </div>
                            
                        </div>
                    </form>  
                </div>
            </div>
            <div class="col-lg-4 col-md-5">
                <div class="contact-author-info">
                    <!--<div class="sec-title pdb-50">
                        <h1>Reach US</h1>
                        <span class="border"></span>
                    </div>-->
                    <ul>
                        <li>
                            <div class="title">
                                <h3>Email us</h3>
                            </div>
                          
                            <div class="text-holder">
                                <!--<h5>Hendry Aravind</h5>
                                <p><span class="flaticon-telephone"></span>84578-25-658</p>-->
                                <p><span class="flaticon-back"></span>cs@shopsatavenue.com</p>
                            </div>
                        </li>
                        <!--<li>
                            <div class="title">
                                <h3>Sales Department:</h3>
                            </div>
                            
                            <div class="text-holder">
                                <h5>Jack Daniel</h5>
                                <p><span class="flaticon-telephone"></span>98765-43-210</p>
                                <p><span class="flaticon-back"></span>jackdaniel@gmail.com</p>
                            </div>
                        </li>-->
                    </ul>
                </div>
                
                
                
            </div>
        </div>
    </div>

<div style="clear: both; height: 50px"></div>

<!-- Section_start -->



<?php $this->load->view('site/templates/footer'); ?>

<script>
 function saveContact()
  {
		$('button[name=btn-save]').prop('disabled', true);
		$.ajax({
			  type: "POST",
			  url: "<?php echo base_url(); ?>" + "save_contact_support",
			  data: $('select, textarea'),
			  dataType: 'json',
			  success: function(res) {
				  if( res.hasOwnProperty('status') && res.status == 'success' )
				  {
						// Show Entered Value
					  $("#notificationUpdate").html('<div class="col-xs-12 alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Your query submitted we will contact you soon.</div>');
				} else {
						$('button[name=btn-save]').prop('disabled', false);
					  $("#notificationUpdate").html('<div class="col-xs-12 alert alert-warning"><button type="button" class="close" data-dismiss="alert">x</button><strong>Error! </strong>There is a problem in server. Please try later!.</div>');
				}
			}
		});
   
  }
</script>