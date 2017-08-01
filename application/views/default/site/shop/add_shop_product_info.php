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
    font-size: 14px;
    font-weight: 400;
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
</style>
</head>

<body>

<div class="container" >
		<div class="steps">
            <nav class="nav-sidebar" >
                <ul class="nav tabs" role="navigation" >
                    <li class="active"><span class="step-bubble">Step: 1.</span>Product Info</a></li>
                    <li class=""><span class="step-bubble">Step: 2.</span>Product Media</li>
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
    
        <form  method="post" action="" name="frm_product_info" id="frm_product_info" onSubmit="return validate();"  >
            <input type="hidden" name="current_step" value="info"  >
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  >
            <div>
               <h4>PRODUCT INFO <?php echo (int) $product_id == 0 ? '<span style="float:right; color:red;">Save this page to move next page</span>' : ''; ?></h4>
               <div class="field-wrapper" >
               <div class="form-group <?php if( isset( $error['product_title'] ) ) echo 'has-error';  ?>">
                <label for="product_title" >Product name <span style="font-size:10px">( Enter 155 Characters )</span></label>
                <input autofocus class="form-control" type="text" maxlength="155" name="product_title" id="product_title"  placeholder="Product Title" onKeyUp="jQuery('#prod_label').text( this.value + ' ( Draft )' );"  onblur="jQuery('#prod_label').text( this.value + ' ( Draft )' );"  value="<?php echo $product_title; ?>" >
                <div style="color:#900"><?php if( isset( $error['product_title'] ) ) echo $error['product_title'];  ?></div>
                </div>
                
                <div class="form-group <?php if( isset( $error['main_cat_id'] ) ) echo 'has-error';  ?>">
                    <!--<label  id="category_fields" for="" class="control-label">Categories / Sub categories</label>-->
                    <div style="width:60%;display:inline-block;">
                    <label for="main_cat_id">Main Category:</label>
                         <select class="saa-select"  name="main_cat_id" id="main_cat_id" onChange="main_cat_change();" style="width:90%"   >
                            <option value="">Select a category</option>
                            <?php foreach($mainCategories->result() as $MaincatValues) {?>
                                  <option value="<?php echo $MaincatValues->id;?>" <?php echo ($main_cat_id == $MaincatValues->id) ? 'selected' : ''; ?> ><?php echo $MaincatValues->cat_name;?></option>
                            <?php }?>
                        </select>
                        <input type="hidden" name="old_main_cat_id" value="<?php echo $MaincatValues->id;?>"  />
                    </div>
                    <div style="width:30%; display:inline-block;">
                        <button type="button" class="button1"  onclick="populate_categories();">Select Sub Category</button>
                    </div>
                </div>

                <div class="form-group" >
                    <div id="category_list">
                         <?php foreach( $sub_cats as $key => $cat_row ) { ?>
                              <div><input type="checkbox" name="sub_cats[]" value="<?php echo $cat_row['id'];?>" checked /><b><?php echo $cat_row['cat_name']; ?></b></div>
                         <?php } ?>
                    </div>
                    <input type="hidden" name="category_id" id="category_id" value="" />
                    <div style="color:#900"><?php if( isset( $error['main_cat_id'] ) ) echo $error['main_cat_id'];  ?></div>
                </div>
               
               <div class="form-group <?php if( isset( $error['product_sort'] ) ) echo 'has-error';  ?>">
                   <label for="product_sort">Product sort <span style="font-size:10px">( optional - positive number )</span></label>
                   <input  class="form-control" type="text" maxlength="10" name="product_sort" id="product_sort" value="<?php echo $product_sort; ?>"  >
                   <div style="color:#900"><?php if( isset( $error['product_sort'] ) ) echo $error['product_sort'];  ?></div>
               </div>

               <div class="form-group <?php if( isset( $error['description'] ) ) echo 'has-error';  ?>" >  
                   <label id="Description" for="description" >Description</label>
                   <textarea  class="saa-textarea mceEditor" rows="5" cols="100" name="description"  id="desc" data-title="Please enter the description" ><?php echo $description; ?></textarea>
                   <div style="color:#900"><?php if( isset( $error['description'] ) ) echo $error['description'];  ?></div>
    
               </div>

              <div class="form-group">           
                <input type="checkbox" name="sold_excl" id="sold_excl" value="1" <?php echo (isset($sold_excl) && $sold_excl == '1') ? 'checked' : ''; ?> >Sold exclusively on ShopsAtAvenue <span style="font-size:10px">( optional )</span>
                
              </div>
              <div class="form-group" > 
                <input type="checkbox" name="custom_prod" id="custom_prod" value="1" <?php echo (isset($custom_prod) && $custom_prod == '1') ? 'checked' : ''; ?>  >This product is made-to-order or customizable. <span style="font-size:10px">( optional )</span>
              </div>

              <div class="form-group <?php if( isset( $error['product_keyword'] ) ) echo 'has-error';  ?>"> 
              <label for="product_keyword">Keywords <span style="font-size:10px">( 10 keyword maximum and each separated by comma )</span></label>
              <input class="form-control" type="text"  name="product_keyword" id="product_keyword" value="<?php echo $product_keyword; ?>"  >
              <div style="color:#900"><?php if( isset( $error['product_keyword'] ) ) echo $error['product_keyword'];  ?></div>
              </div>
              
              <!--<div class="form-group"> 
              <label for="product_shopify">Shopify Product URL <span style="font-size:10px">( optional )</span></label>
              <input class="form-control" type="text" maxlength="300"  name="product_shopify" id="product_shopify"  value="<?php //echo $product_shopify; ?>"   />
              </div>-->
              
              <div class="form-group" >
                <div class="col-md-4 col-xs-12">
                	<button type="button" name="btn-next-step" class="button1" <?php echo $product_id == '' ? 'disabled' : ''; ?> onClick="location='<?php echo 'add-product/'.$product_id.'?step=media';?>'" >Next Step</button>
                </div>
                <div class="col-md-5 col-xs-12 col-md-push-3">
                 	<button type="button" name="btn-save-later" class="button1" onClick="return continue_later();"  style="float:right;">Save and continue later</button>
                </div>
              </div>
              
           </div><!-- field wrapper -->
           </div>
        </form>
    
    </div>
    </div>
       
                            
     
</div>


  <div class="modal fade" id="category_modal" role="dialog">
    <div class="modal-dialog modal-md" >
      <div class="modal-content" style="border-radius: 6px 6px 6px 6px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sub Category selection</h4>
      </div>
           <div class="modal-body">
              <div style="margin-left:20px;">
                  <div class="row">
                    <div class="col-md-6" >
                    <select class="saa-select"  name="sub_cat_id" id="sub_cat_id" onChange="$('input[name=scat_id]').val( this.value ); populate_categories( this.value );"  >
                        <option value="">Select a sub category</option>
                    </select>
                    </div>
                  </div>
                  <div class="row" style="margin-top:20px; margin-bottom:20px;">
                    <div class="col-md-12">
                  	<div  id="cat_link"></div>
                    <input type="hidden" name="scat_id" value="" />
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-5">
                      <button type="button" class="button1" onClick="addCategory(); return false;">Add Category</button>
                      </div>
                  </div>
			</div>
           </div>
      </div>
    </div>
  </div>

<!--<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.ui.totop.js"></script>-->

<?php $this->load->view('site/templates/footer');?>
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
		content_css : "",
		 
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
			/*var fileBrowserWindow = new Array();
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
			
			return false;*/
		}
</script>
<script type="text/javascript">

jQuery(document).ready(function() {
	//$('#main_cat_id').on('change', main_cat_change );
	$('#category_list').html('');
	$('input[name=old_main_cat_id]').val( $('#main_cat_id').val() );

});

function main_cat_change() {
	if( $('#product_keyword').val().trim() == '' ) {
		$('#product_keyword').val( $('#main_cat_id option:selected').text() );
	}
		/*swal({
		  title: "Are you sure?",
		  text: "All your sub category selections will be cleared!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it!",
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
		});	*/
	
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
	$('#category_list').append( '<div><input name="sub_cats[]" value="'+ $('input[name=scat_id]').val() +'" checked="" type="checkbox">' + $('#cat_link').html() + '</div>' );
	$('#cat_link').html('');
	$('#category_modal').modal('hide');
}

function validate() {
	if( $('#product_title').val().trim() == '' ) {
		$('#product_title').closest('.form-group').addClass('has-error');
		$('<div class="error-msg">Invalid Product name!</div>').appendTo( $('#product_title').closest('.form-group') );
		window.scrollTo(0, 0);
		return false;
	}
	
	return true;
}

function continue_later() {

	if( ! validate() ) return false;
	$('button[name=btn-save-later]').prop('disabled', true );
	$('<i class="fa fa-spin fa-spinner fa-3x"></i>').insertAfter( $('button[name=btn-save-later]') );
	$('button[name=btn-save-later]').hide();
	//var fd = new FormData( $('#frm_product_info') );

		$.ajax({
			url: 'site/shop/saveDraftProductInfo' , 
			type: 'post',
			data: $('#frm_product_info').serialize(),
			dataType: 'json',
			success: function(result){
				if( result.status == 'error' ) {
					alert( result.message );
					$('button[name=btn-save-later]').show();
					$('button[name=btn-save-later]').prop('disabled', false );
					$('.fa-spinner').remove();
					return;
				}
				if ( result.status == 'success' ) {
					location = result.next_url;
				}
			},
			error: function( error ) {
				console.log(error);
				alert("Exception thrown : " + error.statusText);
				//$('#main_cat_id').attr('disabled', false);
			}
		});
	
}
</script>
