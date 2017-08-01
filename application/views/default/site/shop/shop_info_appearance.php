<?php 
$this->load->view('site/templates/commonheader'); 
$this->load->view('site/templates/shop_header');

?>
<script type="text/ecmascript" src="js/site/custom_validation.js" ></script>

<link href="css/cropper.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<?php if(isset($active_theme) &&  $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>Shop-page.css" rel="stylesheet">
<?php } ?>
<div class="clear"></div>
<div id="shop_page_seller">
<section class="container">
<div class="main">
		
  
  <ul class="bread_crumbs">
   	<li><a href="<?php echo base_url(); ?>" class="a_links">Home</a></li>
            <span>&rsaquo;</span>
    <li><a href="shop/sell" class="a_links"><?php  echo stripslashes(strip_tags($selectSeller_details[0]['seller_businessname'])); ?></a></li>
		   <span>&rsaquo;</span>
    <li>Info and appearance</li>
 </ul>
		
		
            <div style="margin-top:20px" class="manage-listing-heading">
                <h1>Info & Appearance</h1>
                <p>Flash out your shop with the following information</p>
            </div>            
            <form id="policies" class="shop-form-policies" action="site/shop/shop_appearance_setting" method="post" enctype="multipart/form-data" onsubmit="return image_validate()">
            
            <div class="shop-policies-section list_wrap">
            <div class="shop-form-section-inner">
            
            <div class="shop_member">
           <label class="label-text">Shop Name</label>
		   <div class="shop_member_right">
           <input type="text" class="checkout_txt" name="seller_businessname" id="seller_businessname" value="<?php  echo stripslashes(strip_tags($selectSeller_details[0]['seller_businessname'])); ?>" autocomplete="off" onCopy="return false" onDrag="return false" onDrop="return false"
 onblur="return check_shopname(this);"  onkeyup="return check_shopname(this);" style="width:425px; height:27px" />
            <div id="errMsg" style="color:#FF3333"></div>
			</div>
            </div>
             <hr>
             
             
            <div class="shop_member">
                <label class="label-text">Shop Title</label>
				<div class="shop_member_right">
                <input id="shop_title" class="headline-shop" type="text" maxlength="55" value="<?php  echo stripslashes(strip_tags($selectSeller_details[0]['shop_title'])); ?>" name="shop_title"  onKeyUp="change('shop_title','goo_item_title')" />
				</div>
            </div>                        
            <hr>
            
            <?php if($selectSeller_details[0]['seller_store_image'] != ''){ ?>
            <div class="shop_member">
                <label class="label-text">Current Banner image</label>
                <div class="shop_member_right"><img src="images/store-banner/<?php print_r($selectSeller_details[0]['seller_store_image']); ?>"/></div>
            </div>
            <hr>
            <?php }?>
            
            
			<div class="shop_member">
                <label class="label-text">Shop Banner Image</label>
				<div class="shop_member_right">
				<div class="input-change" ><div>
<input type="button" onclick="document.getElementById('inputImage').click();$('#showcropImage').show();" value="Choose File..."/><b id="no_file_selected">No File Selected</b></div></div>

                <input type="file" name="shop_banner" id="shop_banner_img" />
                <div style="padding:0px 0px 0px 141px;"><img id="loadedImgshop" src="images/loader64.gif" style="widows:25px; height:25px; display:none" /></div>
                
                <p class="inline-message" id="ErrImage">Upload a .jpg, .gif or .png that is 760px by 100px and no larger than 2MB.</p>
                <input type="hidden" id="imageResult" value="failure"/>
				</div>
            </div>
  
<div class="shop_member" id="cropImage">
      
<div class="container">
    <div class="row">
    
      <div class="col-md-9" id="showcropImage" style="display:none;">
        <!-- <h3 class="page-header">Demo:</h3> -->
        <div class="img-container">
          <img src="images/store-banner/default_avat.png" alt="Picture">
        </div>
      </div>
      <div class="col-md-3" >
        <!-- <h3 class="page-header">Preview:</h3> -->
        <div class="docs-preview clearfix" style="display:none;">
          <div class="img-preview preview-lg"></div>
          <div class="img-preview preview-md"></div>
          <div class="img-preview preview-sm"></div>
          <div class="img-preview preview-xs"></div>
        </div>

        <!-- <h3 class="page-header">Data:</h3> -->
        <div class="docs-data" style="display:none;">
          <div class="input-group">
            <label class="input-group-addon" for="dataX">X</label>
            <input class="form-control" id="dataX" name="left" type="text" placeholder="x">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group">
            <label class="input-group-addon" for="dataY">Y</label>
            <input class="form-control" id="dataY" name="top" type="text" placeholder="y">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group">
            <label class="input-group-addon" for="dataWidth">Width</label>
            <input class="form-control" id="dataWidth" name="width" type="text" placeholder="width">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group">
            <label class="input-group-addon" for="dataHeight">Height</label>
            <input class="form-control" id="dataHeight" name="height" type="text" placeholder="height">
            <span class="input-group-addon">px</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-9 docs-buttons">
        <!-- <h3 class="page-header">Toolbar:</h3> -->

      
        <div class="btn-group" style="display:none;">
          <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
       
            <input class="sr-only" id="inputImage" name="file" type="file" accept="image/*">

            <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
              <span class="icon icon-upload"></span>
            </span>
          </label>
        </div>

        <div class="btn-group btn-group-crop" id="preview" style="display:none;">
          <button class="btn btn-primary" data-method="getCroppedCanvas" type="button">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCroppedCanvas&quot;)">preview</span>
          </button>
        </div>

        <!-- Show the cropped image in modal -->
        <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
              </div>
              <div class="modal-body"></div>
            </div>
          </div>
        </div><!-- /.modal -->

      </div><!-- /.docs-buttons -->
      
    </div>
  </div>

  <!-- Alert -->
  <div class="docs-alert"><span class="warning message"></span></div>
      
  </div>
<hr>
  
            <!--<div class="shop_member">
                <label style="margin-top:0" class="label-text">Local Markets</label>
                <div class="shop_member_right">
                <input type="checkbox" <?php  //if(stripslashes($selectSeller_details[0]['local_markets'])=="Yes"){ echo 'checked="checked"';} ?>  value="true" name="local_markets">Show upcoming local markets you will attend on your shop page</div>
            </div>-->
            <div class="shop_member">
                <label style="margin-top:0" class="label-text">Hide Reviews</label>
                <div class="shop_member_right">
                <input type="checkbox" <?php  if( $selectSeller_details[0]['hide_review'] ){ echo 'checked="checked"';} ?>  value="1" name="hide_review"></div>
            </div>            

            <hr>
            
            <div class="shop_member">
                 
                <div class="shop_member">
                    <label class="label-text">Shop Announcement</label>
                    <div class="shop_member_right"><textarea id="shop_announcement" class="message121" rows="4" name="shop_announcement" style="overflow: hidden; border-color:#ccc; height: 101px;"  onKeyUp="change('shop_announcement','goo_item_desc')"><?php  echo stripslashes($selectSeller_details[0]['shop_announcement']); ?></textarea>
                    <p class="inline-message">Additional policies, FAQs, custom orders, wholesale & consignment, guarantees, etc.</p></div>
                    <div id="showpreview">
                        <p>Preview how your shop homepage will appear in Google search results: </p>
                        <div class="preview-body"><p class="showing-msg"><span id="goo_item_title"><?php  echo stripslashes($selectSeller_details[0]['shop_title']); ?></span><span id="goo_item_desc"><?php  echo stripslashes(strip_tags($selectSeller_details[0]['shop_announcement'])); ?></span>. </p></div>
                    </div>
                </div>
                <hr>
                <div class="shop_member">
                    <label class="label-text">Message to Buyers</label>
                    <div class="shop_member_right"><textarea id="msg_to_buyers" class="message121" rows="4" name="msg_to_buyers" style="overflow: hidden; height: 101px; border-color: #CCCCCC;"><?php  echo stripslashes(strip_tags($selectSeller_details[0]['msg_to_buyers'])); ?></textarea>
                    <p class="inline-message">We include this message on receipt pages and in the email buyers receive when they purchase from your shop.</p>
                    </div>
                </div>           
                <!--<div class="shop_member">
                    <label class="label-text">Message to Buyers for Digital Items</label>
                    <div class="shop_member_right"><textarea id="msg_to_buyers_for_digiitem" class="message121" rows="4" name="msg_to_buyers_for_digiitem" style="overflow: hidden; height: 101px; border-color: #CCCCCC;"><?php  //echo htmlspecialchars(stripslashes(strip_tags($selectSeller_details[0]['msg_to_buyers_for_digiitem']))); ?></textarea>
                    <p class="inline-message">If you sell digital items, we include this message on the Downloads page for digital orders. It applies to all digital listings purchased from your shop.</p>
                    </div>
                </div>
			</div>-->
		</div>
        </div>
        <div class="wid">
            <span class="button-large">
                <span>
                    <input type="submit" id= "save_changes" value="Save Changes" >
				</span>
            </span>
        </div> 
			<div style="display:none;" id="error_msg"><span style="color: red;" >Your not Suppose to add any special Characters !!!<span></div>
        <input type="hidden" id="shop-banner" name="shop-banner" value="shop-banner-img" />          
    	</form> 
		</div>
	</section> 	
</div>
<script type="text/javascript">

$(document).ready(function(){

$('#shop_banner_img').on('change',function(){
	$('#no_file_selected').text(this.value);                       
});


// $("#shop_banner_img").change(function(e) {
// 	alert("b");
//     for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
        
//         var file = e.originalEvent.srcElement.files[i];
        
//         //var img = document.createElement("img");
//         var reader = new FileReader();
//         reader.onloadend = function() {
//              	//img.src = reader.result;
//         		//$("#img").attr("src",reader.result);
//         		$("#cropImage img").attr("src",reader.result);
//         }
//         reader.readAsDataURL(file);
//         //$("#shop_banner_img").after(img);
//     }
// });

});    



//$("#showcropImage").hide();

</script>

 <script>
function check_shopname(val) {

	var shopname=$('#seller_businessname').val();  //^[a-zA-Z0-9]\s{2,20}$
		if(shopname.trim()=="" || shopname.trim()==null){
			  $("#errMsg").html(lg_enter_shopname);
			  return false;
		 } 

		$.get('site/shop/Load_ajax_shopName_check?s_name='+shopname, function(data) {
			if(data.trim() == 'exist'){ 
			 $("#errMsg").html(lg_shop_exist);
			 return false;
			 } else {
			 $("#errMsg").html('');

 			 }
		});
}
</script>

  <!--<script src="js/cropper/jquery.min.js"></script>
  <script src="js/cropper/bootstrap.min.js"></script>-->
  <script src="js/cropper/cropper.js"></script>
  <script src="js/cropper/main.js"></script>
<script>

$(".img-container > img").cropper({
	cropBoxResizable: false,
	dragCrop: false,
	  aspectRatio: 76 / 10,
	  preview: ".img-preview",
	  crop: function(e) {
	    $("#dataX").val(Math.round(e.x));
	    $("#dataY").val(Math.round(e.y));
	    $("#dataHeight").val(Math.round(e.height));
	    $("#dataWidth").val(Math.round(e.width));
	    $("#dataRotate").val(e.rotate);
	    $("#dataScaleX").val(e.scaleX);
	    $("#dataScaleY").val(e.scaleY);
	  }
});

function image_validate(){
	
// 	if($("#imageResult").val() != 'success'){
// 		alert("Uploaded Image Too Small. Please Upload Image Size More than or Equalto 760 X 100");
// 		return false;
// 	}
}
</script>
 <script>
	$('#save_changes').click(function(){
		var regx = /^[A-Za-z0-9 _.-]+$/;
		if(!(regx.test($('#seller_businessname').val())))
		{		
			$('#error_msg').css('display','block');
			return false;
		}else{
			$('#error_msg').css('display','none');
			return true;
		}
	});
 </script>
<?php 
$this->load->view('site/templates/footer');
?>