<?php 

$this->load->view('site/templates/productheader');
$this->load->view('site/templates/shop_header'); 

?>

<style>
#When_is{margin:0px !important;}
</style>
<style>
#progressDiv { margin-left: 20px; }

#progressDiv > div {
	 margin-top:10px;
}
#progressDiv > div a {
    font: bold 12px sans-serif;
    text-align: center;
    color: #999;
    line-height: 18px;
}

#progressDiv > div span {
color: #FFF;
vertical-align: middle;
display: inline-block;
border-radius: 9px;
line-height: 18px;
background: #999 none repeat scroll 0% 0%;
margin-right: 10px;
width: 17px;
text-align: center;
}
#progressDiv > div.current span {
	background-color:#000;
}
#progressDiv > div.current a {
	color:#000;
}
.thumb-box {
	display:inline-block;
	border: 1px solid;
}

</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#image_upload").change(function(e) { 
			e.preventDefault();	
			
		if ( $('#image_container > div').length >= 5 ) {
			alert( 'Maximum images uploaded!' );
			$("#image_upload").val('');
			return false;
		}
		
		$("#loadedImg").css("display", "block");	
        var formData = new FormData(  );

		formData.append( 'image_upload',  $( "input[type=\'file\']" )[0].files[0] );
		formData.append( 'image_upload_file', $('#image_upload').val() );
		formData.append( 'product_id', $("input[name='product_id']").val() );
		formData.append( 'current_step', $("input[name='current_step']" ).val() );
		
        $.ajax({
			beforeSend: function()
 		      {
      	        document.getElementById("loadedImg").src='images/loader64.gif';
  			  },
            //url: 'site/product/ajax_load_images',
            url: location,
            type: 'POST',
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
            success: function(data) {
				$("#loadedImg").css("display", "none"); 
		      	var arr = data.split('|');
			  	if(arr[0] == 'Success'){
				  if( $('#image_container > div').length <= 5 ) {
					  $('#image_container').append('<div style="display:inline-block"><img class="upload-img1" src="" id="loadedImg" width="110px" ></img><div align="center"><a href="javascript:;" onclick="remove_image(\''+ arr[1] +'\');">Remove</a></div></div>');
					  $('#image_container > div:last-child').find('img.upload-img1').attr('src', baseURL + arr[1]);
					  $("#image_upload").val('');
				  }
				}else{
					alert( arr[1] );
				}
			},
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
        return false;	
	});
});

function remove_image( image_name ) {
        var formData = new FormData(  );

		formData.append( 'image_name',  image_name );
		formData.append( 'action',  'remove_image' );
		formData.append( 'product_id', $('input[name=product_id]').val() );
		formData.append( 'current_step', $('input[name=current_step]' ).val() );

        $.ajax({
			beforeSend: function()
 		      {
      	        //document.getElementById("loadedImg").src='images/loader64.gif';
  			  },
            url: location,
            type: 'POST',
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
            success: function(data) {
		      	var arr = data.split('~');
			  	if(arr[0] == 'Success'){
					var images = arr[1].split('|');
					$('#image_container').html('');
					for(var i=0; i < images.length-1; i++ ) {
					  $('#image_container').append('<div class="thumb-box"><img class="upload-img1" src="" id="loadedImg" width="110px" ></img><div align="center"><a href="javascript:;" onclick="remove_image(\''+ images[i] +'\');">Remove</a></div></div>');
					  $('#image_container > div:last-child').find('img.upload-img1').attr('src', baseURL + 'images/product/temp_img/' + images[i] );
					}
				} else {
					alert( arr[1] );
				}
			},
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });

}
function saveProductVideo() {
		
		if ( $('#video_url').val() == '' ) {
			alert('Please enter Video URL!');
			return false;
		}
		
        var formData = new FormData(  );

		formData.append( 'video_url',  $('#video_url').val() );
		formData.append( 'product_id', $("input[name='product_id']").val() );
		formData.append( 'current_step', $("input[name='current_step']" ).val() );
        $.ajax({
			beforeSend: function()
 		      {
      	        //document.getElementById("loadedImg").src='images/loader64.gif';
  			  },
            //url: 'site/product/ajax_load_images',
            url: location,
            type: 'POST',
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
            success: function(data) {
		      	var arr = data.split('|');
			  	if(arr[0] == 'Success'){
					$('#video_url').val('');
					$('#myModal').modal('hide');
				}else{
					alert( arr[1] );
				}
			},
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
	
}
</script>
<?php if(isset($active_theme) &&  $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>Shop-page.css" rel="stylesheet">
<?php } ?>

<div class="list_inner_fields" id="shop_page_seller">   


	<div class="sh_content">
       <div style="margin: 0 0 0 20px">
    	<p><a href="#"><i class="fa fa-arrow-circle-o-right"></i>&nbsp;Back to listing</a></p>
		<h3><?php echo $product_name; ?></h3>
       </div>
    
    <div id="progressDiv" class="col-lg-2 sh_border">
       <p style="color:#000"><b>Product Setup Steps:</b></p>
       <div><a href="<?php echo $step_url; ?>?step=info"><span>1</span>Product Info</a></div>
       <div class="current"><a href="<?php echo $step_url; ?>?step=media"><span>2</span>Product Media</a></div>
       <div><a href="<?php echo $step_url; ?>?step=variation"><span>3</span>Price and Variation</a></div>
       <div><a href="<?php echo $step_url; ?>?step=shipping"><span>4</span>Product Shipping</a></div>
       <div><a href="<?php echo $step_url; ?>?step=final"><span>5</span>Finalize</a></div>
    </div>

    <div class="col-lg-8" >
    
        <form class="form-horizontal" method="post" action="" name="frm_product_media" id="frm_product_media" enctype="multipart/form-data">
        	<input type="hidden" name="current_step" value="media"  />
        	<input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  >
            <div class="col-lg-12 sh_border" >
               <div><h4>PRODUCT IMAGES and VIDEO</h4></div>
            <p style="line-height:normal; padding-bottom:20px">Add upto 5 photos and 1 video for your product.<br />
            The first photo will be used as the default thumbnail for this product.</p>
            <div class="list_inner_right">
                <ul class="photo_list">
                    <li>
                        <div>
                            <div class="photo_contain">
                                <span class="image-wrap" onclick="delete_image('image_upload','loadedImg')">X</span>
                                <input type="file" class="image-upload" id="image_upload" name="image_upload"> 
                            </div>
                            <img class="upload-img1" src="" id="loadedImg" width="90px" height="71px" style="display:none"> </img>
                            <div class="photo_add">
                                <i class="fa fa-photo fa-5x"></i><br />
                                <span>ADD PHOTOS</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div id="videoDiv" data-toggle="modal" data-target="#myModal" >
                            <div class="photo_contain">
                                <!--<span class="image-wrap" onclick="delete_image('image_upload','loadedImg')">X</span>-->
                            </div>
                            <img class="upload-img1" src="" id="loadedImg" width="90px" height="71px" style="display:none"> </img>
                            <div class="photo_add">
                                <i class="fa fa-video-camera fa-5x"></i><br />
                                <span>ADD VIDEO</span>
                            </div>
                        </div>
                    </li>
                 </ul>
            </div>

                    <div id="image_container" class="col-lg-12"  style="margin-top:20px;padding:0;">

					<?php
                      if( $product->image != '' ) {
                          $imagesArr = explode( ",", $product->image );
                          foreach( $imagesArr as $key => $val ) {
                    ?>
                        <div class="thumb-box">
                            <img class="upload-img1" src="/images/product/<?php echo $product->id;?>/thumb/<?php echo $val;?>" id="loadedImg" width="110px"  > </img>
                            <div align="center"><a href="javascript:;" onclick="remove_image('<?php echo $val;?>');">Remove</a></div>
                        </div>

					<?php      
                        }
                      }
                    ?>
					</div>
                   <p style="clear:both; line-height:normal; padding-top:10px;">Minimum dimension: 225px x 225px<br />
                   Maximum File size: 2MB<br />
                   File type: jpeg<br />
                   Best size: 544px x 544px<br />
                   For zoomable images, at least 1248px x 1248px<br />
                   </p>

              <div class="form-group" style="padding:10px 0px 0px 0">
                <input type="submit" name="btn-info" class="btn btn-info"  value="Previous Step"  />
                <input type="submit" name="btn-variation" class="btn btn-info"  value="Next Step"  />
                <button class="btn btn-info" style="float:right;">Save and continue later</button>
              </div>                   
           </div> <!-- sh border -->
        </form>

    </div>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Product Video</h4>
        </div>
        <div class="modal-body">
          <label>Enter Video URL</label>
          <input  type="text" name="video_url" id="video_url" style="width:400px;"   />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" onclick="saveProductVideo();">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>


<?php $this->load->view('site/templates/footer');?>
