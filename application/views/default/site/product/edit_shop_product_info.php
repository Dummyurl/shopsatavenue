<?php 
$this->load->view('site/templates/commonheader');

?>
<link rel="stylesheet" href="css/default/front/checkout.css">
<link rel="stylesheet" href="css/default/front/etalage.css">
<!--<script type="text/javascript" src="3rdparty/bootstrap-3.3.6/bootstrap-validator/validator.min.js"></script>-->
<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="3rdparty/sweet-alert/sweet-alert.js"></script>
<link rel="stylesheet" href="3rdparty/sweet-alert/sweet-alert.css">
<script type="text/javascript">
tinyMCE.init({
		// General options
		mode : "specific_textareas",
		editor_selector : "mceEditor",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
		width: "715",
        height: "275",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
   		theme_advanced_toolbar_location : "top",
 		theme_advanced_toolbar_align : "left",
 		theme_advanced_statusbar_location : "bottom",
 		theme_advanced_resizing : true,
		file_browser_callback : "ajaxfilemanager",
		relative_urls : false,
		convert_urls: false,
		// Example content CSS (should be your site CSS)
		content_css : "css/default/example.css",
		 
		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "js/template_list.js",
		external_link_list_url : "js/link_list.js",
		external_image_list_url : "js/image_list.js",
		media_external_list_url : "js/media_list.js",
		 
		// Replace values for the template plugin
		template_replace_values : {
		username : "Some User",
		staffid : "991234"
		}
		});
		
		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = '<?php echo base_url();?>js/tinymce/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php';
			switch (type) {
				case "image":
					break;
				case "media":
					break;
				case "flash": 
					break;
				case "file":
					break;
				default:
					return false;
			}
            tinyMCE.activeEditor.windowManager.open({
                url: '<?php echo base_url();?>js/tinymce/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php',
                width: 782,
                height: 440,
                inline : "yes",
                close_previous : "no"
            },{
                window : win,
                input : field_name
            });
            
            return false;			
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}
</script>
<script type="text/javascript">

jQuery(document).ready(function() {
	$('#main_cat_id').on('change', main_cat_change );
});

function main_cat_change() {
		swal({
		  title: "Are you sure?",
		  text: "All your sub category selections will be cleared!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it!",
		  cancelButtonClass: "btn btn-default",
		  cancelButtonText: "cancel!",
		  closeOnConfirm: true,
		  closeOnCancel: true
		},
		function(isConfirm) {
		  if (isConfirm) {
			$('#category_list').html('');
			$('input[name=old_main_cat_id]').val( $('#main_cat_id').val() );
			swal("", "Sub categories selection is cleared!", "success");
		  } else {
			$('#main_cat_id').val( $('input[name=old_main_cat_id]').val() ); 
		  }
		});		
	
}

function populate_categories( cat_id = '' ) {
   if( $('#main_cat_id').val() == '' ) {
	   //$('#main_cat_id').focus();
	    alert( 'Select Main category!' );
		return false;
   }

   if( cat_id == '' ) { cat_id = $('#main_cat_id').val() };

	var fd = new FormData();
	fd.append('cat_id', cat_id);
	
	$('#main_cat_id').attr('disabled', true);
		$.ajax({
			url: 'site/product/get_category_list' , 
			type: 'post',
			data: fd,
			dataType: 'json',
        	contentType: false,
        	processData: false,
			success: function(result){
				$('#main_cat_id').attr('disabled', false);
				$('#cat_link').html( result.cat_crumb );
				
				if( result.cat_options.length > 0 ) {
					$('#sub_cat_id')
						.find('option')
						.remove()
						.end()
						.append(result.cat_options);
				} else {
					$('#sub_cat_id')
						.find('option')
						.remove()
						.end()
						.append('<option value="">Select sub category</option>');
				}
				$('#category_modal').modal('show');
			},
			error: function() {
				$('#main_cat_id').attr('disabled', false);
			}
		});
	
}
function addCategory() {
	$('#sub_cat_id').find('option').remove().end().append('<option value="">Select sub category</option>');
	$('#category_list').append( '<div><input name="sub_cats[]" id="use-shipping" value="'+ $('input[name=scat_id]').val() +'" checked="" type="checkbox">' + $('#cat_link').html() + '</div>' );
	$('#cat_link').html('');
	$('#category_modal').modal('hide');
}
</script>
<style>
.has-error { color:#F00; }
</style>
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
                            <li  class="active"><a href="#tab1" data-toggle="tab"><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 1:</span>Product Info</a></li>
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 2:</span>Product Media</li>
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 3:</span>Price and Variation</li> 
                            <li><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 4:</span>Product Shipping</li> 
                            <li class=""><span style=" font-size:12px; font-style:italic; background-color:#0e73bc; color:#fff; padding:3px 10px 3px 10px; border-radius:100px; margin-right:10px;">Step: 5:</span>Finalize</li> 
                        </ul>
                    </nav>
					<div class="tab-content tab-content-t">
					<div class="tab-pane active text-style" id="tab1">
						<div class="con-w3l">
                           <div class="product-grid-item-wrapper">
<div class="cart-wrapper row">
           <div class="checkout-forms-wrapper ">
                <div class="row osky-form cart-form">
                  <div class="table-row">
<div class="table-header">
	<div id="payment-form" class="payment-form-wrapper">
    	<form class="osky-form" method="post" action="" name="frm_product_info" id="frm_product_info" novalidate="novalidate"  >
    	<input type="hidden" name="current_step" value="info"  >
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  >
		<div id="add-credit-card">
    	<div class="credit-card checkout-section">
  			<div class="inner">
            	<div class="col-md-12">
                   	<div class="col-md-12">
					<h2 class="checkout-sub-header">Product Info</h2>
                    <div aria-required="true" class="required  <?php if( isset( $error['product_title'] ) ) echo 'has-error';  ?>" >
                      	<label aria-required="true" for="product_title">Product Name <span style="font-size:10px">( Enter 140 Characters )</span></label>
                        <span class="field-wrap ">
            			<input autofocus type="text" maxlength="150" name="product_title" id="product_title"  placeholder="Product Title" required  value="<?php echo $product_info->product_name; ?>" >
                        </span>
                   	</div>
               
                    <div aria-required="true" class="state required ">
                    	<label aria-required="true" for="main_cat_id" >Main Category</label>
                        <span class="field-wrap">
                            <select  name="main_cat_id" id="main_cat_id" class="osky-select" data-required="1">
                            <option value="">Select a category</option>
							<?php foreach($mainCategories->result() as $MaincatValues) {?>
                                  <option value="<?php echo $MaincatValues->id;?>" <?php echo ($product_info->category_id == $MaincatValues->id) ? 'selected' : ''; ?> ><?php echo $MaincatValues->cat_name;?></option>
                            <?php }?>

                            </select>
                            <input type="hidden" name="old_main_cat_id" value="<?php echo $MaincatValues->id;?>"  />
                        </span>
                    </div>
                    <div aria-required="true" class="state">
                        <span class="field-wrap" id="category_list">
                             <?php foreach( $sub_cats as $key => $cat_row ) { ?>
                                  <div>
                                  <input type="checkbox" name="sub_cats[]" value="<?php echo $cat_row['id'];?>" checked /><b><?php echo $cat_row['cat_name']; ?></b>
                                  </div>
                             <?php }  
							       if( count($sub_cats) == 0 ) {
							 ?>
                             	<label>No sub categories...</label>
                             <?php } ?>
                        </span>
                    	<input type="hidden" name="category_id" id="category_id" value="" >
                    </div>
                    
                    <div aria-required="true" class="zip">
                    	<label>&nbsp;</label>
   				  		<button type="button" class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button" style="background-color:#0e73bc; border:none;"  onclick="populate_categories();" >Select Sub Category</button>
                   </div>
   
                   <div aria-required="true" class="zip required " >
                      <label aria-required="true" for="product_sort">Product Sort ( Optional - Positive Number )</label>
                        <span class="field-wrap ">
                        <input  class="form-control" type="text" maxlength="10" name="product_sort" id="product_sort" value="<?php echo $product_info->product_sort; ?>" style="width:20%;" >
                        </span>
                   </div>
                   <div aria-required="true" class="city required " >
                      	<label aria-required="true" for="description">Description</label>
						<textarea  name="description"  id="desc" data-title="Please enter the description" required ><?php echo $product_info->description; ?></textarea>
                   </div>
   
                   <div aria-required="true" class="city required ">
                      <div class="billing-address checkout-section">
                       	<div class="billing-shipping-address" style="padding-left:0px; margin-left:0px;">
                        	<input id="use-shipping" name="sold_excl"  type="checkbox" style="margin-top:7px;" <?php echo (isset($product_info->sold_excl) && $product_info->sold_excl == '1') ? 'checked' : ''; ?> value="1" >
                        	<label for="use-shipping">Sold exclusively on ShopsAtAvenue. (optional) </label>
							<input id="use-shipping" type="checkbox" style="margin-top:7px;" name="custom_prod" value="1" <?php echo (isset($custom_prod) && $custom_prod == '1') ? 'checked' : ''; ?> >
                        	<label for="use-shipping">This product is made-to-order or customizable. (optional)</label>
                        </div>
                      </div>
                  </div>
    
				  <div aria-required="true" class="city required ">
                  		<label aria-required="true" for="transaction_billing_postal_code">Keywords</label>
                    	<span class="field-wrap">
		  				<input class="form-control" type="text"  name="product_keyword" id="product_keyword" value="<?php echo $product_keyword; ?>"  required  >
                        </span>
                    	<p style="font-size:12px; font-style:italic;">(10 keyword maximum and each separated by comma) Keyword automatically filled up when page loading if it is empty</p>
                </div>
                
                <div class="container">
                     <div class="col-md-7">
                     	<p style="clear:both;">
                        	<button type="submit" name="btn-media" class="osky-btn osky-btn-default osky-btn-inline-block coupon-form-button" value="Next Step"  style="background-color:#598F27; border:none; cursor:pointer;">Next Step</button>
                        </p>
                     </div>
                    
                    <div class="col-md-3">
                    	<p style="clear:both;">
                        	<button type="submit" name="submit" value="Save and continue later" class="osky-btn osky-btn-default osky-btn-inline-block" style="background-color:#333; border:none; cursor:pointer;">Save and Continue Later
                            </button>
                        </p>
                    </div>
                
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
    

  <div class="modal fade" id="category_modal" role="dialog">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content" style="border-radius: 6px 6px 6px 6px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Category selection</h4>
      </div>
           <div class="modal-body">
              <div style="margin-left:20px;">
                  <div class="row">
                    <select  name="sub_cat_id" id="sub_cat_id" onChange="$('input[name=scat_id]').val( this.value ); populate_categories( this.value );"  >
                        <option value="">Select a category</option>
                    </select>
                  </div>
                  <div class="row">
                  	<div  id="cat_link"></div>
                    <input type="hidden" name="scat_id" value="" />
                  </div>
                  <div class="row">
                      <button type="button" class="btn btn-info" onClick="addCategory(); return false;">Add Category</button>
                  </div>
			</div>
           </div>
      </div>
    </div>
  </div>

<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.ui.totop.js"></script>

<?php $this->load->view('site/templates/footer');?>
