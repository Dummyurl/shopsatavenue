<?php
$this->load->view('site/templates/merchant_header');
?>
<link rel="stylesheet" href="3rdparty/sweet-alert/sweet-alert.css">
<style>
  	.error_msg { color:#F00; text-align:center; }
	.btn-link, .btn-link:active, .btn-link:focus, .btn-link:hover  { 
		cursor: pointer;
		border-color: #28a4c9;
		background-image: linear-gradient(to bottom,#5bc0de 0,#2aabd2 100%);
		color:#FFF;
		padding: 5px;
		border-radius: 5px;
		text-decoration:none !important;
	}
table{max-width:100%;border-collapse:collapse;border-spacing:0}
.table{width:100%;margin-bottom:24px}
.table th,.table td{padding:8px 8px 8px 16px;line-height:20px;text-align:left;border-top:1px solid #999}
.table th{font-weight:700;vertical-align:bottom}.table td{vertical-align:top}
.table thead:first-child tr th,.table thead:first-child tr td{border-top:0}
.table tbody+tbody{border-top:2px solid #999}
tr.expired{color:#999;text-decoration:line-through}
.table-gaps th,.table-gaps td{border:0;border-left:5px solid #fff;border-bottom:5px solid #fff}
.table-gaps th:first-child,.table-gaps td:first-child{border-left:0}.table-striped tr th,.table-striped tr td{background:#ededed}.table-striped tr:nth-child(even) th,.table-striped tr:nth-child(even) td{background:#ddd}.table-striped thead:first-child tr th,.table-striped thead:first-child tr td{background:#b4e2f3;color:#666}.table-striped-simple tr:nth-child(even) th,.table-striped-simple tr:nth-child(even) td{background:#ededed}.table-nohead tr:first-child td{border-top:0}.table-thick td{padding:1em}.table-grid-tight{font-size:11px;border-collapse:separate;border-spacing:1px;margin-bottom:10px}.table-grid-tight th,.table-grid-tight td{padding:8px;border:1px solid rgba(204,204,204,0.3);background:#ededed;line-height:14px}.table-half{max-width:50%}.table-list td{border:0;padding:8px 0}.table-list td:first-child{font-weight:700}.table-small th,.table-small td{padding:8px 4px;font-size:12px}@media screen and (max-width:620px){.table-scrollable{overflow-x:scroll}.table-scrollable table{min-width:495px;margin-bottom:0}}
.tab-head {
    margin: 1em 0 0;
}
select{height:3.7rem;padding:.5rem;border:1px solid #414042;margin:0 0 1rem;font-size:1.5rem;font-family:inherit;line-height:normal;color:#414042;background-color:#fefefe;border-radius:0;-webkit-appearance:none;-moz-appearance:none;background-image:url("images/select_down.svg");background-size:9px 6px;background-position:right -1rem center;background-origin:content-box;background-repeat:no-repeat;padding-right:1.5rem}
  
</style>
<script type="text/javascript" src="3rdparty/sweet-alert/sweet-alert.js"></script>

<div class="container" style="margin-top:60px;">

                    <div class="row">
                       <div class="col-md-12">
                        <h2 >Shopify product selection 
                        <span style="float:right"><button name="btn-import" class="btn btn-primary" >Import Product</button></span>
                        <span style="float:right; margin-right:10px;margin-top: 14px;font-size: 16px;">
                        <form name="form-import" id="form-import" action="site/product/shopify_product_selection" method="post" >
                        	<input type="hidden" name="page_no" value="<?php echo $page_no;?>"  />
                        <a href="javascript:;" class="btn-link" onClick="$('input[name=page_no]').val('1');$('#form-import').submit();" >First</a>
                        <a href="javascript:;" class="btn-link" onClick="$('input[name=page_no]').val('<?php echo ($page_no + 1);?>');$('#form-import').submit();" >Next</a>
                        <a href="javascript:;" class="btn-link" onClick="$('input[name=page_no]').val('<?php echo ($page_no - 1);?>');$('#form-import').submit();" >Prev</a>
                        <a href="javascript:;" class="btn-link" onClick="$('input[name=page_no]').val('<?php echo $total_pages;?>');$('#form-import').submit();" >Last</a>
                        </form>
                        </span>
                        <!--<span style="float:right"><a href="javascript:;"><i class="fa fa-arrow-right fa-3x"></i></a></span>-->
                        </h2>
                       <div class="error_msg"></div>
                       <div class="col-md-12">
                        <table class="table table-bordered table-striped" style="margin-top:10px;">
                        <thead>
                        <tr>
                            <th class="span1">
                            	<div class="billing-shipping-address" style="padding:0; margin:0; text-align:center;"><input id="use-shipping"  type="checkbox" style="text-align:center;"></div></th>
                            <th class="span2">Image</th>
                            <th class="span3">Title</th>
                            <!--<th class="span4">In-Stock</th>
                            <th class="span5">Price</th>
                            <th class="span6">Listed</th>
                            <th class="span7">Status</th>
                            <th class="span7">Action</th>-->
                        </tr>
                        </thead>
                        <tbody>
						<?php  
								$products = $result->products;
								for( $i=0; $i < count($products); $i++ )   {
                                	$imgArr=explode(',' , $products[$i]->image);
                        ?>
                          <tr>
                                <td style="text-align:center;">
                                	<input id="use-shipping" class="chkProd" type="checkbox" value="<?php echo $products[$i]->id; ?>" name="selProducts[]" <?php echo in_array($products[$i]->id, $product_exist) ? 'disabled' : ''; ?> >
                                </td>
                                <td>
                                	<img class="" width="50" height="50" alt="." src="<?php echo $imgArr[0] == '' ? 'images/noimage.jpg' : $imgArr[0]; ?>" >
                                </td>
                                <td><?php echo $products[$i]->title; ?></a></td>
                          </tr>
						<?php } ?>
                       
                        </tbody>
                    </table>
        
                       </div>
                       </div>
                	</div>

</div>    
<a data-toggle="modal" href="#load_import" data-keyboard="false" data-backdrop="static" aria-hidden="true" id="loadingPop"></a>
<div class="modal fade" id="load_import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-wrapper" id="popWrapper">
				<div class="text-center" id="popUpLoad">
					<img src="images/ajax-loader/ajax-loader-pop.gif" class="icon" width="50" />
					<h4>Importing Product, Please Wait...</h4>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
#loadingPop {
    display:none;
}
</style>

<?php $this->load->view('site/templates/footer');?>

<script type="text/javascript">
$(function() {
	$("button[name=btn-import]").click(function(){
		$('.error_msg').html('');
		if( $('input[name^=selProducts]:checked').length == 0 ) {
			$('.error_msg').html('Please select product to import!');
			return false;
		}
		swal({
		  title: "Do you want to continue to download product?",
		  text: "",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "osky-btn",
		  confirmButtonText: "Yes",
		  cancelButtonClass: "osky-btn",
		  cancelButtonText: "cancel!",
		  closeOnConfirm: true,
		  closeOnCancel: true
		},
		function(isConfirm) {
		  if (isConfirm) {

		$("#loadingPop").trigger('click');
		$("button[name=btn-import]").attr('disabled', true);

		$.ajax({
			url: baseURL + 'site/product/import_shopify_products', 
			method: 'post',
			dataType: 'json',
			data: $('input[name^=selProducts]:checked'),
			success: function(data){
				//var res = data.split('|');
				//alert( JSON.stringify( data ) );
				$('#load_import').modal('hide');
				if( data.status == 'success' ) {
					//first disable checkbox and then uncheck
					$('input[name^=selProducts]:checked').prop('disabled', true);
					$('input[name^=selProducts]:checked').prop('checked', false);
					$('.error_msg').html( data.message );
					$("button[name=btn-import]").attr('disabled', false);
				} else {
					$("button[name=btn-import]").attr('disabled', false);
					$('.error_msg').html( data.message );
				}
			}
		});

		  } else {
			return false;
		  }
		});		
		
	
	});
});

</script>
	
