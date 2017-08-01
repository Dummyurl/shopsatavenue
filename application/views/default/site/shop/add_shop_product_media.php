<?php $this->load->view('site/templates/merchant_header');?>
<style>
.has-error { color:#F00; }
.nav-sidebar ul li { display:inline-block; }
.steps { margin:auto; padding-top:20px; padding-bottom:20px; width:80%; }
.step-bubble {  font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px; }
.field-wrapper { margin-left:15px; margin-top:15px; }
.active  { background-color: skyblue;padding: 8px;border-radius: 4px; }

border-radius: 5px;
label{
    width: 100%!important;
}
input[type='text'], input[type='number']{
    width: 100%!important;
    border-radius: 0;
    border: 0.5px solid #4c4a4e;
    color: #4c4a4e;
    height:44px;
    padding: 5px;

}
input[type='text']:focus{
    color: #999;
    border: .0625rem solid #67ccf3
}
.saa-textarea { border: 0.0625rem solid #4c4a4e; border-radius: 0px; }
.saa-select
{
      /*display: block;*/
    border: 1px solid #4c4a4e;
    color: #4c4a4e;
    background-color: #fff;
    box-shadow: none;
    transition: none;
    font-size: 18px;
    font-weight: 600;
    height:44px!important;
    padding: 5px;
    -webkit-appearance: none;
    appearance: none;
    border: 1px solid #28262a;
    background: #fff url('../images/select_down.svg') no-repeat right 10px top 50%;
    background-size: 3%;
    font-weight: 400;
    background-color: #fff;
    -moz-appearance : none!important;
    min-width:80px!important;
}  
.photo_list { margin-top:20px; }
.photo_list li { display:inline-block; padding:20px; border:0.5px solid gray; margin-left:10%; }

</style>

</head>

<body>

<div class="container" >
		<div class="steps">
            <nav class="nav-sidebar" >
                <ul class="nav tabs" role="navigation" >
                    <li class=""><span class="step-bubble">Step: 1.</span>Product Info</a></li>
                    <li class="active"><span class="step-bubble">Step: 2.</span>Product Media</li>
                    <li class=""><span class="step-bubble" >Step: 3.</span>Price and Variation</li> 
                    <li class=""><span class="step-bubble">Step: 4.</span>Product Shipping</li> 
                    <li class=""><span class="step-bubble">Step: 5.</span>Finalize</li> 
                </ul>
            </nav>
		</div>
                
	<div class="row">
        <div class="col-md-12" style="padding-bottom: 10px;">
            <h3 id="prod_label"><?php echo isset($product_title) ? $product_title :'Add a new Product'; ?> (Draft)</h3>	
        </div>
    	<div class="col-md-8 col-xs-11" >
    	<form  method="post" action="" name="frm_product_media" id="frm_product_media" enctype="multipart/form-data">
        	<input type="hidden" name="current_step" value="media"  />
        	<input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  >
    
            <div class="col-md-12">
				<h4>Product Images and Video</h4>
                <p>Add upto 5 photos and 1 video for your product.<br>
The first photo will be used as the default thumbnail for this product.</p>

            <div class="col-md-12">
                <ul class="photo_list" style="list-style:none; ">
                    <li>
                        
                        <div id="photo_container">
                            <input type="file" class="image-upload" id="image_upload" name="image_upload" style="display:none;position:absolute; top:-100px;"> 
                            <!--<img class="upload-img1" src="" id="loadedImg" width="90px" height="71px" style="display:none"> </img>-->
                            <div class="photo_add">
                                <a href="javascript:;" onClick="return open_image_browse();"><i class="fa fa-photo fa-5x"></i><br />
                                <span>ADD PHOTOS</span></a>
                            </div>
                        </div>
                        </a>
                    </li>
                    <li>
                        <div id="videoDiv" >
                            <!--<div class="photo_contain">
                                <span class="image-wrap" onclick="delete_image('image_upload','loadedImg')">X</span>
                            </div>-->
                            <img class="upload-img1" src="" id="loadedImg" width="90px" height="71px" style="display:none"> </img>
                            <div class="photo_add">
                            	<a href="javascript:void(0);"  onClick="$('#videoPopup').modal('show');">
                                <i class="fa fa-video-camera fa-5x"></i><br />
                                <span>ADD VIDEO</span>
                                </a>
                            </div>
                        </div>
                    </li>
                 </ul>
            </div>

            <div id="image_container" class="col-md-12"  style="margin-top:20px;padding:0;">
				<?php
                  if( $images != '' ) {
                      $imagesArr = explode( ",", $images );
                      foreach( $imagesArr as $key => $val ) {
                ?>
                    <div class="col-md-2">
                        <img class="img-responsive" src="images/product/temp_img/<?php echo $val;?>" id="loadedImg" />
                        <div align="center"><a href="javascript:;" onClick="remove_image('<?php echo $val;?>');">Remove</a></div>
                    </div>
                <?php      
                    }
                  }
                ?>
            </div>

                <p style="font-size:11px; margin-top:12px;">Minimum dimension: 225px x 225px<br>
                Maximum File size: 2MB<br>
                File type: jpeg<br>
                Best size: 544px x 544px<br>
                For zoomable images, at least 1248px x 1248px</p>

                <div class="container">
                	<div class="col-md-2">
               			<button type="submit" name="submit" value="Previous Step"  class="button1"  >Prev Step</button>
                	</div>
                    <div class="col-md-3">
                       	<button type="submit" name="submit" value="Next Step"  class="button1" >Next Step</button>
                    </div>
                    
                    <div class="col-md-3"><p style="clear:both;">
                    <button type="button"  class="button1" onClick="location='merchant-home'" >Save and Continue Later</button></p>
                    </div>
                </div>
                
            </div>
		</form>
		</div>
        
	</div>
                        
  <!-- Modal -->
  <div class="modal fade" id="videoPopup" role="dialog">
    <div class="modal-dialog modal-md">
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
          <div class="col-md-5">
          <button type="button" class="button1" onClick="saveProductVideo();">Save</button>
          </div>
          <div class="col-md-5">
          <button type="button" class="button1" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
        
</div>

<?php $this->load->view('site/templates/footer');?>
<script type="text/javascript">

	function open_image_browse() {
		$('#image_upload').trigger('click');
	}

$(document).ready(function(){
	
	$("#image_upload").change(function(e) { 
			e.preventDefault();	
			
		if ( $('#image_container > div').length >= 5 ) {
			alert( 'Maximum images uploaded!' );
			$("#image_upload").val('');
			return false;
		}
		
		//$("#loadedImg").css("display", "block");	
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
					  var html = '<div class="col-md-2">';
                      html +=  '<img class="img-responsive" src="' + arr[1] + '"  />';
                      html +=  '<div align="center"><a href="javascript:;" onClick="remove_image(\'' + arr[1] + '\');">Remove</a></div>';
                      html += '</div>';
					  $(html).appendTo('#image_container');
					  //$('#image_container > div:last-child').find('img.upload-img1').attr('src', baseURL + arr[1]);
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
					  $('#image_container').append('<div style="display:inline-block"><img class="upload-img1" src=""  width="110px" ></img><div align="center"><a href="javascript:;" onclick="remove_image(\''+ images[i] +'\');">Remove</a></div></div>');
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
