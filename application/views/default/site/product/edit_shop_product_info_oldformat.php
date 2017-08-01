<?php 
$this->load->view('site/templates/productheader');
$this->load->view('site/templates/shop_header');
//echo print_r( $mainCategories->result(), 1); exit(0);
?>
<script type="text/javascript" src="3rdparty/bootstrap-3.3.6/bootstrap-validator/validator.min.js"></script>
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
	$('#category_list').append( '<div><input name="sub_cats[]" value="'+ $('input[name=scat_id]').val() +'" checked="" type="checkbox">' + $('#cat_link').html() + '</div>' );
	$('#cat_link').html('');
	$('#category_modal').modal('hide');
}
</script>

<style>
#When_is{margin:0px !important;}
</style>
<style>
#progressDiv { margin-left: 20px; }

#progressDiv > div {
	    /*width: 18px; height: 18px;*/
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
input[type="checkbox"] { margin:0 5px ; }
</style>

<?php if(isset($active_theme) &&  $active_theme->num_rows() !=0) {?>
<link href="./theme/themecss_<?php echo $active_theme->row()->id; ?>Shop-page.css" rel="stylesheet">
<?php } ?>


<div class="list_inner_fields" id="shop_page_seller">   

	<div class="sh_content">
       <div style="margin: 0 0 0 20px">
    	<p><a href="shop/managelistings"><i class="fa fa-arrow-circle-o-right"></i>&nbsp;&nbsp;Back to listing</a></p>
		<!--<h3 id="prod_label"><?php //echo isset($product_title) ? $product_title :'Add a new Product'; ?> (Draft)</h3>	-->
       </div>

    <div id="progressDiv" class="col-lg-2 sh_border">
       <!--<p style="color:#000"><b>Product Setup Steps:</b></p>-->
       <div class="current"><a href="<?php echo $step_url; ?>?step=info"><span>1</span>Product Info</a></div>
       <?php if ( $product_id == NULL ) { ?>
       <div><a href="javascript:;"><span>2</span>Product Media</a></div>
       <div><a href="javascript:;"><span>3</span>Price and Variation</a></div>
       <div><a href="javascript:;"><span>4</span>Product Shipping</a></div>
       <div><a href="javascript:;"><span>5</span>Finalize</a></div>
       <?php } else { ?>
       <div><a href="<?php echo $step_url; ?>?step=media"><span>2</span>Product Media</a></div>
       <div><a href="<?php echo $step_url; ?>?step=variation"><span>3</span>Price and Variation</a></div>
       <div><a href="<?php echo $step_url; ?>?step=shipping"><span>4</span>Product Shipping</a></div>
       <div><a href="<?php echo $step_url; ?>?step=final"><span>5</span>Finalize</a></div>
       <?php } ?>
    </div>
    
<!--<div id="progressDiv" class="col-lg-2 sh_border">
   <p><b>Product Setup Steps:</b></p>
   <ol>
       <li class="curProcess" >Product Info</li>
       <li>Product Media</li>
       <li>Price and Variation</li>
       <li>Product Shipping</li>
       <br />
       <li>Finalize</li>
   </ol>
</div>-->

<div class="col-lg-8" >

	<form class="form-horizontal"  method="post" action="" name="frm_product_info" id="frm_product_info" data-toggle="validator" role="form" >
    	<input type="hidden" name="current_step" value="info"  >
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"  >
		<div class="col-lg-12 sh_border" >
           <div><h4>PRODUCT INFO</h4></div>
           <div class="form-group <?php if( isset( $error['product_title'] ) ) echo 'has-error';  ?>" >
			<label for="product_title" class="control-label">Product name <span style="font-size:10px">( Enter 140 Characters )</span></label>
            <input autofocus class="form-control" type="text" maxlength="140" name="product_title" id="product_title"  placeholder="Product Title"  required  value="<?php echo $product_info->product_name; ?>" >
            <div style="color:#900"><?php if( isset( $error['product_title'] ) ) echo $error['product_title'];  ?></div>
            </div>
            
            <div class="form-group <?php if( isset( $error['main_cat_id'] ) ) echo 'has-error';  ?>">
            <div class="row">
                <div class="col-md-6" >
                <!--<label  id="category_fields" for="" class="control-label">Categories / Sub categories</label>-->
            	<label for="main_cat_id">Main Category:</label>
                     <select  name="main_cat_id" id="main_cat_id"  >
                        <option value="">Select a category</option>
                        <?php foreach($mainCategories->result() as $MaincatValues) {?>
                              <option value="<?php echo $MaincatValues->id;?>" <?php echo ($product_info->category_id == $MaincatValues->id) ? 'selected' : ''; ?> ><?php echo $MaincatValues->cat_name;?></option>
                        <?php }?>
                    </select>
					<input type="hidden" name="old_main_cat_id" value="<?php echo $MaincatValues->id;?>"  />
                </div>
            </div>
            <div class="row">
                <div class="col-md-8" >
      				<div id="category_list">
                         <?php foreach( $sub_cats as $key => $cat_row ) { ?>
                              <div><input type="checkbox" name="sub_cats[]" value="<?php echo $cat_row['id'];?>" checked /><b><?php echo $cat_row['cat_name']; ?></b></div>
                         <?php } ?>
                    </div>
                    <input type="hidden" name="category_id" id="category_id" value="" >
                    <div style="color:#900"><?php if( isset( $error['main_cat_id'] ) ) echo $error['main_cat_id'];  ?></div>
                </div>
                <div class="col-md-3" >
                    <button type="button" class="btn btn-info"  onclick="populate_categories();">Select Sub Category</button>
                </div>


            </div>
           </div>
           
           <div class="form-group <?php if( isset( $error['product_sort'] ) ) echo 'has-error';  ?>" >
		   <label for="product_sort">Product sort <span style="font-size:10px">( optional - positive number )</span></label>
           <div style="width:100px;">
           <input  class="form-control" type="text" maxlength="10" name="product_sort" id="product_sort" value="<?php echo $product_info->product_sort; ?>"  >
           </div>
           <div style="color:#900"><?php if( isset( $error['product_sort'] ) ) echo $error['product_sort'];  ?></div>
           </div>
           <div class="form-group <?php if( isset( $error['description'] ) ) echo 'has-error';  ?>" >  
           <label id="Description" for="description" class="col-sm-2 col-xs-12 control-label">Description</label>
		   <textarea onkeyup="change('desc','goo_item_desc');" style=" width:295px" class="tipTop mceEditor" name="description"  id="desc" data-title="Please enter the description" required ><?php echo $product_info->description; ?></textarea>
           <div style="color:#900"><?php if( isset( $error['description'] ) ) echo $error['description'];  ?></div>
           </div>
			<!--<p>Preview how your listing will appear in Google search results <a href="javascript:void(0)" id="preview_GSR" onclick="return Goog_SR('preview_GSR');"></a></p>-->
			<!--<div class="list_inner_fields preview_div" id="preview"></div>-->
		  <div class="form-group">           
            <h5>Sold exclusively on ShopsAtAvenue <span style="font-size:10px">( optional )</span> <input type="checkbox" name="sold_excl" id="sold_excl" value="1" <?php echo (isset($product_info->sold_excl) && $product_info->sold_excl == '1') ? 'checked' : ''; ?> ></h5>
            
		  </div>
          <div class="form-group"> 
            <h5>This product is made-to-order or customizable. <span style="font-size:10px">( optional )</span> <input type="checkbox" name="custom_prod" id="custom_prod" value="1" <?php echo (isset($custom_prod) && $custom_prod == '1') ? 'checked' : ''; ?>  ></h5>
            
		  </div>
          <div class="form-group <?php if( isset( $error['product_keyword'] ) ) echo 'has-error';  ?>"> 
          <h5 for="product_keyword">Keywords <span style="font-size:10px">( 10 keyword maximum and each separated by comma )</span>
          <span style="color:red;font-size:10px;">Keyword automatically filled up when page loading if it is empty</span></h5>
		  <input class="form-control" type="text"  name="product_keyword" id="product_keyword" value="<?php echo $product_keyword; ?>"    >
          <div style="color:#900"><?php if( isset( $error['product_keyword'] ) ) echo $error['product_keyword'];  ?></div>
          </div>
          
          <!--<div class="form-group"> 
          <label for="product_shopify">Shopify Product URL <span style="font-size:10px">( optional )</span></label>
		  <input class="form-control" type="text" maxlength="300"  name="product_shopify" id="product_shopify"  value="<?php //echo $product_shopify; ?>"   />
          </div>-->
          
          <div class="form-group" style="padding:10px 0px 0px 0">
          	<input type="submit" name="btn-media" class="btn btn-info"  value="Next step"  >
            <input type="submit" name="submit" class="btn btn-info"  value="Save and continue later" style="float:right;">
          </div>
       </div>

  </div>
       
	</form>
    
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
                    <select  name="sub_cat_id" id="sub_cat_id" onchange="$('input[name=scat_id]').val( this.value ); populate_categories( this.value );"  >
                        <option value="">Select a category</option>
                    </select>
                  </div>
                  <div class="row">
                  	<div  id="cat_link"></div>
                    <input type="hidden" name="scat_id" value="" />
                  </div>
                  <div class="row">
                      <button type="button" class="btn btn-info" onclick="addCategory(); return false;">Add Category</button>
                  </div>
			</div>
           </div>
      </div>
    </div>
  </div>
<?php $this->load->view('site/templates/footer');?>
