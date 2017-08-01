<?php 
$this->load->view('site/templates/commonheader');
?>
<style>
.thumb-box {
	display:inline-block;
	border: 1px solid;
}
.photo_list li { list-style:none; display:inline-block; cursor:pointer; }
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
</head>

<body class="microsite site-kgsinfotech content-page">
                
<header id="header" class="header-sites header-logo-only">
        <div class="row header-top">
        	<div class="small-12 columns site-header-logo">
            <a class="header-logo-link" href="<?php echo base_url(); ?>"><img  src="images/logo/<?php echo $this->config->item('logo_image'); ?>"></a>
            </div>
        </div>            
</header>
<div class="off-canvas-wrapper" style="padding:0px 3rem 0px 3rem; margin-top:50px;">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper="">
    <div class="off-canvas-content" data-off-canvas-content="">
    <div class="main-container outer-wrap">
    <div class="row collapse">
        <div class="small-12 columns">
        <div class="container-fluid">
    
    <div class="layout-columns">
        <div class="cms-content">
			<div class="content-top">
				<div class="container">
				<div class="tab-head ">
                    <nav class="nav-sidebar">
                        <ul class="nav tabs" style="text-align:left; border:0px !important; ">
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 1:</span>Product Info</li>
                            <li class="active"><a href="#tab2" data-toggle="tab"><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 2:</span>Product Media</a></li>
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 3:</span>Price and Variation</li> 
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 4:</span>Product Shipping</li> 
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 5:</span>Finalize</li> 
                        </ul>
                    </nav>

                    <div class="tab-pane text-style" id="tab2">
						<div class="con-w3l">
                           <div class="product-grid-item-wrapper">
<div class="cart-wrapper row">
           <div class="checkout-forms-wrapper ">
                <div class="row osky-form cart-form">
                  <div class="table-row">
<div class="table-header">
	<div id="payment-form" class="payment-form-wrapper">
    	<form class="osky-form" method="post" action="" name="frm_product_media" id="frm_product_media" enctype="multipart/form-data">
        	<input type="hidden" name="current_step" value="media"  />
        	<input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  >
		<div id="add-credit-card">
    	<div class="credit-card checkout-section">
  			<div class="inner">
            		<div class="col-md-12">
                    <div class="col-md-12">
				<h2 class="checkout-sub-header">Product Images and Video</h2>
                <p>Add upto 5 photos and 1 video for your product.<br>
The first photo will be used as the default thumbnail for this product.</p>
            <div class="list_inner_right col-md-12">
                <ul class="photo_list" style="list-style:none;">
                    <li>
                        <div>
                            <div class="photo_contain">
                                <!--<span class="image-wrap" onclick="delete_image('image_upload','loadedImg')">X</span>-->
                                <input type="file" class="image-upload" id="image_upload" name="image_upload" style="display:none;"> 
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
                            <img class="upload-img1" src="images/product/<?php echo $product->id;?>/thumb/<?php echo $val;?>" id="loadedImg" width="110px"  > </img>
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
                	<div class="col-md-1">
                		<p style="clear:both;">
                			<button type="submit" name="btn-info" value="Previous Step"  class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button"  style="background-color:#0e73bc; border:none;">Prev Step</button>
                		</p>
                	</div>
                    <div class="col-md-7">
                    	<p style="clear:both;">
                        	<button type="submit" name="btn-variation" value="Next Step"  class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button" style="background-color:#598F27; border:none;">Next Step</button>
                        </p>
                    </div>
                    
                    <div class="col-md-3"><p style="clear:both;"><button id="apply-coupon-btn" class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button" data-action="apply" style="background-color:#333; border:none;">Save and Continue Later</button></p></div>
                
                </div>
                
               </div>
			</div>
 		</div>
	</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
                            
     
<div class="clearfix"></div>
</div>
                    </div>
                    
                     
              </div>
		</div>
	</div> 
</div>
     		</div>
		</div>
  	</div>
</div>
                        
<div class="end-of-page-container"></div>
    </div>
    </div>
    </div>
    </div>
        
</div>


<?php $this->load->view('site/templates/footer');?>
