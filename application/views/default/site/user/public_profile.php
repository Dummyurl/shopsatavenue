<?php 
$this->load->view('site/templates/header');
$this->load->model('product_model');
$this->load->model('user_model');
?>

<style>
#popupContact {
  display: none!important;
}

/*** custom checkboxes ***/
input[type=checkbox] { display:none; } /* to hide the checkbox itself */
input[type=checkbox] + label:before {
  font-family: FontAwesome;
  display: inline-block;
}

input[type=checkbox] + label:before { content: "\f096"; } /* unchecked icon */
input[type=checkbox] + label:before { letter-spacing: 10px; } /* space between checkbox and label */

input[type=checkbox]:checked + label:before { content: "\f046"; } /* checked icon */
input[type=checkbox]:checked + label:before { letter-spacing: 5px; } /* allow space for check mark */
</style>
<!-- header_end -->
<!-- section_start -->

<?php $this->load->view('site/templates/user_menu'); ?>
        
<div class="container" >
	<section class="container">

    	<div class="row" style="padding-bottom:20px;">
        </div>
          
         <form action="site/user/update_public_profile" method="post" enctype="multipart/form-data" id="profile_form" name="profile_form">  

		 <div class="row">
          	 <div class="col-md-6">
             	<div class="form-group" >
             	<label >Profile Picture</label>
             <img src="<?php echo base_url();?>images/users/thumb/<?php if($PublicProfile->row()->thumbnail!=""){echo $PublicProfile->row()->thumbnail;}else{echo "profile_pic.png";}?>" />
				<input type="button" onclick="document.getElementById('user_profile_img').click()" value="Choose File ..." />
				<input type="file" id="user_profile_img" class="shipping_fiel_12" style="margin:10px 0 0 10px; color:#fff; display:none;" name="profile_pict" />
		     	<label id="ErrImage" class="img-size"></label>
                </div>
                
                <div class="form-group">
        	<label >Full Name</label>
            <span id="display_first_name"><?php echo $PublicProfile->row()->full_name." ".$PublicProfile->row()->last_name;?></span>

            	<!--<a id="button" style="cursor:pointer !important;">Change or Remove</a>-->

                </div>
                <div class="form-group">
       				<div><label>Gender</label></div>
       	        	<input name="gender" type="radio" value="Female"  id="Female" ><label for="Female">Female</label>
        	        <input name="gender" type="radio" value="Male"  id="Male"/><label for="Male">Male</label>
        	        <input name="gender" type="radio" value="" id="Unspecified"/><label for="Unspecified">Rather not say</label>
                </div>

                <div class="form-group">
         			<label for="city">City</label>
        	        <input name="city" type="text" value="<?php echo $PublicProfile->row()->city;?>"  style=" width:38%;" class="form-control" >
                </div>
                <div class="form-group">
         			<label for="country">Country</label>
                    <select class="form-control" name="country" id="country" style="cursor:pointer !important;width:50%;">
                    <option value="">Select country</option>
                        <?php foreach($data_country->result() as $countryName){ ?>
                            <option <?php if($countryName->name==$PublicProfile->row()->country) { ?> selected="selected"<?php } ?> value="<?php echo $countryName->name; ?>"><?php echo $countryName->name; ?></option>
                        <?php } ?>
                 </select>
                </div>
                <div class="form-group">
                	<div><label >Birthday</label></div>
                     <select class="form-control" name="month" id="month" style="cursor:pointer !important; width:30%; display:inline-block;">
                        <option>Select Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                     </select>

                      <select class="form-control" style="width:20%;cursor:pointer !important; display:inline-block;" name="day" id="day">
                             <option>Select day</option>
                             <?php for($i=1; $i<=31; $i++ ){?>
                              <option value="<?php echo $i;?>"><?php echo $i;?></option>
                             <?php }?>
        
                     </select>
           		 	<span style="color:red" id="date_error"></span>
               </div>


             </div>
             <div class="col-md-6">

 
                <div class="form-group">
                	<div>
           			<label>Include on Your Profile</label>
                    </div>
				   <?php if($PublicProfile->row()->include_profile != 'All') {   
                            $include_arr=explode(',',$PublicProfile->row()->include_profile);
                    ?>
                    <div>
        	        <input name="include_profile[]" type="checkbox" <?php  if(in_array('Shop',$include_arr)) echo "checked"; ?> value="Shop"   id="Shop" />
                    <label for="Shop" >Shop</label>
                    </div>

                    <div>
                   <input name="include_profile[]"  <?php  if(in_array('Favorite_items',$include_arr)) echo "checked"; ?>  type="checkbox" value="Favorite_items" id="Favorite_items"  >
                    <label for="Favorite_items"  >Favorite items</label>
                    </div>
                    <div>
                     <input name="include_profile[]" type="checkbox"  <?php  if(in_array('Favorite_shops',$include_arr)) echo "checked"; ?>  value="Favorite_shops" id="Favorite_shops"  >
                    <label for="Favorite_shops" >Favorite shops</label>
                    </div>

                    <!--<input name="include_profile[]"  <?php  //if(in_array('Teams',$include_arr)) echo "checked"; ?> type="checkbox"  value="Teams" id="Teams" >
                    <label for="Teams" >Teams</label>-->
                  <?php } else {?>
                  	<div>
       	        	<input name="include_profile[]" type="checkbox" value="Shop"   id="Shop" checked="checked" ><label for="Shop" >Shop</label>
                    </div>
                    <div>
                    <input name="include_profile[]" type="checkbox" class="chkb" value="Favorite_items" id="Favorite_items"  checked="checked" ><label for="Favorite_items"  >Favorite items</label>
                    </div>
                    <div>
                    <input name="include_profile[]" type="checkbox" class="chkb" value="Favorite_shops" id="Favorite_shops"  checked="checked" ><label for="Favorite_shops" >Favorite shops</label>
                    </div>

                    <!--<input name="include_profile[]" type="checkbox" class="chkb" value="Teams" id="Teams"  style="float:left;cursor:pointer !important;" checked="checked"/>
                    <label style=" margin:0px 0 0 3px;" >Teams</label>-->

                  <?php }?>
                </div>

             </div>
            <div class="col-md-12">
                <div class="form-group">
                <input type="submit" class="button" value="Save Changes" style=" margin-left:10px; margin-top:1px;" id="profile_submit" onclick="return date_validation();" >
                </div>
            </div>

        </div>

		</div><!-- row -->
        </form>
        
        </div>

    </section>
<div>
  

  <div id="popupContact">

    <div class="overlay-content"  id="namechange-overlay">

                <form class="namechange-overlay-form" method="post" action="site/user/change_name" onsubmit="return validateName();">

                <div class="overlay-header">

                    <h2><?php if($this->lang->line('user_change_rmv_name') != '') { echo stripslashes($this->lang->line('user_change_rmv_name')); } else echo 'Change or Remove Your Name'; ?></h2>

                    <p><?php if($this->lang->line('user_these_fields_fname') != '') { echo stripslashes($this->lang->line('user_these_fields_fname')); } else echo 'These fields are for your full name'; ?>.</p>

                </div>

                <div class="overlay-body change-name-overlay">

                    <div class="input-group input-group-stacked">

                        <label for="new-first-name"><?php if($this->lang->line('user_fname') != '') { echo stripslashes($this->lang->line('user_fname')); } else echo 'First Name'; ?></label>

                        <div class="pop-input">

                        <input value="<?php echo $PublicProfile->row()->full_name?>" name="new-first-name" id="new-first-name" maxlength="40" class="text" type="text" >

                        </div>

                       

                    </div>

            		<div class="input-group input-group-stacked">

			            <label for="new-last-name"><?php if($this->lang->line('user_lname') != '') { echo stripslashes($this->lang->line('user_lname')); } else echo 'Last Name'; ?></label>

                        <div class="pop-input">

                        <input value="<?php echo $PublicProfile->row()->last_name?>" id="new-last-name" name="new-last-name" maxlength="40" class="text" type="text">

                        </div>

                        

                    </div>

                </div>

                <span class="error" id="splErr"></span>

                <div class="overlay-footer">

                    <div class="primary-actions">

                        <div class="save-changes"><input type="submit" name="save" value="<?php if($this->lang->line('user_save_changes') != '') { echo stripslashes($this->lang->line('user_save_changes')); } else echo 'Save Changes'; ?>"></div>

                       <div class="popup-cancel"><input type="button" name="cancel" value="<?php if($this->lang->line('user_cancel') != '') { echo stripslashes($this->lang->line('user_cancel')); } else echo 'Cancel'; ?>" id="popupContactClose"></div>

                    </div>

                </div>

            </form>

            </div>    


	</div>

	<div id="backgroundPopup"></div>

  

  <script>

document.getElementById("<?php if($PublicProfile->row()->gender==""){echo "Unspecified";}else{echo $PublicProfile->row()->gender;}?>").checked=true;



<?php if($PublicProfile->row()->birthday!=""){$dob=explode('-',$PublicProfile->row()->birthday);?>

document.getElementById("month").value="<?php echo $dob[0];?>";

document.getElementById("day").value="<?php echo $dob[1];?>";

<?php }?>



<?php $include_profile=explode(',',$PublicProfile->row()->include_profile);

	for($i=0;$i<sizeof($include_profile);$i++) { ?>

 $('#<?php echo $include_profile[$i];?>').attr('checked',true);

<?php }?>

</script>

<script>

function validateName(){

	$('#splErr').hide();

	$('#splErr').html('');

	if($('#new-first-name').val().trim()==''){		

		$('#splErr').show();

		$('#splErr').html('Enter Your First Name.');

		return false;

	}

	if($('#new-last-name').val().trim()==''){		

		$('#splErr').show();

		$('#splErr').html('Enter Your Last Name.');

		return false;

	}

}

function date_validation()

{



var favorite_materials=$('#favorite_materials').val().split(',');

	$('#favorite_materialsErr').hide();

if(favorite_materials.length>13){

	$('#favorite_materialsErr').show();	

	$('#favorite_materialsErr').html('Maximum 13 materials are added');

	return false;

}



$("#date_error").html("");

var day=document.getElementById("day").value;

var month=document.getElementById("month").value;

	if(month==2)

	{

		if(day>28)

		{

			$("#date_error").html("Invalid date");

			return false;

		}

	}

	if(month==4||month==6||month==9||month==11)

	{

		if(day>30)

		{

			$("#date_error").html("Invalid date");

			return false;

		}

	}

	if((day>0&&month=="Month")||(month>0&&day=="Day"))	

	{

		$("#date_error").html("Invalid date");

			return false;

	}

}



function hide_me()

{

	//alert(element_id);

$("#alert_div").hide();	

}

</script>



<script>

//function change_name()

//{

//	var first_name=document.getElementById("new-first-name").value;

//	var last_name=document.getElementById("new-last-name").value;

	

//	$.ajax({

//			url : '<?php echo base_url();?>site/user/change_name',

			//data : {firstname : first_name,lastname : last_name},

			//type : "post",

			

//			success:function(e){

//				alert(e);

				//$("#display_first_name_header").html(response.first_name);

				//$("#display_first_name").html(response.first_name);

				//$("#new-first-name").val(response.first_name);

				//$("#new-last-name").val(response.last_name);

				//$("#alert_div").css("display", "block");

				//$("#alert_message").html(response.msg);

//			},

//			error: function(er){

				

//				alert("error");

//			}

//			});

	

	

//}

</script>


<script>
$('#user_profile_img').change(function(){
	$('#no_file_selected').text($('#user_profile_img').val());
});
</script>


<?php 

     $this->load->view('site/templates/footer');

?>