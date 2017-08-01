<?php 
$this->load->view('site/templates/merchant_header');

?>
<link rel="stylesheet" href="css/default/front/checkout.css">
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

   
<div class="container" >
	<form  id="form-products" name="form-products" method="post" action="" novalidate="novalidate">
        <div class="row">
           <div class="col-md-12">
            <h2 class="checkout-sub-header">Total Products (<?php echo $total_products; ?>)</h2>
            <div>
            Stock up! Listing 10 or more items gives buyers more opportunities to find your shop.
            <span style="display:inline-block; width:auto;margin-left: 20px;"><a href="site/shop/product_setup" title="Add Product"><i class="fa fa-plus-circle"></i>&nbsp;<strong>Add New Product</strong></a></span>
            <span style="float:right; margin-right:10px;margin-bottom:10px;" >
                <input type="hidden" name="page_no" value="<?php echo $page_no;?>"  />
                <a href="javascript:;" class="btn-link" onClick="$('input[name=page_no]').val('1');$('#form-products').submit();" >First</a>
                <a href="javascript:;" class="btn-link" onClick="$('input[name=page_no]').val('<?php echo ($page_no + 1);?>');$('#form-products').submit();" >Next</a>
                <a href="javascript:;" class="btn-link" onClick="$('input[name=page_no]').val('<?php echo ($page_no - 1);?>');$('#form-products').submit();" >Prev</a>
                <a href="javascript:;" class="btn-link" onClick="$('input[name=page_no]').val('<?php echo ($total_pages-1);?>');$('#form-products').submit();" >Last</a>
            </span>
            <span style="float:right; margin-right:10px;">
                <select name="filter_status" onchange="filter_product();" >
                      <option value="">Select Product status</option>
                      <option value="Draft" <?php echo ($filter_status == 'Draft' ? 'selected' : '');?> >Draft</option>
                      <option value="Publish" <?php echo ($filter_status == 'Publish' ? 'selected' : '');?> >Published</option>
                      <option value="Rejected" <?php echo ($filter_status == 'Rejected' ? 'selected' : '');?> >Rejected</option>
                      <option value="Deleted" <?php echo ($filter_status == 'Deleted' ? 'selected' : '');?> >Deleted</option>
                </select>
            </span>
            </div>
           </div>
           <div class="col-md-12">
            <table class="table table-bordered table-striped" style="margin-top:0px;">
            <thead>
            <tr>
                <th class="span1"><div class="billing-shipping-address" style="padding:0; margin:0; text-align:center;"><input  type="checkbox" style="text-align:center;"></div></th>
                <th class="span2">Image</th>
                <th class="span3">Title</th>
                <th class="span4">In-Stock</th>
                <th class="span5">Price</th>
                <th class="span6">Category</th>
                <th class="span7">Status</th>
                <th class="span7">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php  
                    for( $i=0; $i < count($products); $i++ )   {
                        $imgArr=explode(',' , $products[$i]['image']);
            ?>
                <tr>
                    <td style="text-align:center;">
                        <input id="use-shipping" type="checkbox" value="<?php echo $products[$i]['id']; ?>" name="chkProducts[]" class="osky-chkbox">
                    </td>
                    <td>
                        <img class="" width="50" height="50" alt="." src="images/product/<?php echo $products[$i]['id']; ?>/list-image/<?php echo $imgArr[0]; ?>">
                    </td>
                    <td><a title="" href="<?php echo base_url().'products/'.$products[$i]['seourl']; ?>"><?php echo $products[$i]['product_name']; ?></a></td>
                    <td><?php echo $products[$i]['quantity']; ?></td>
                    <td><?php echo number_format($products[$i]['price'],2);  echo '+';  ?></td>
                    <td><?php echo $products[$i]['cat_name']; ?></td>
                    <td><?php echo $products[$i]['status']; ?></td>
                    <td>
                        <?php if ( $filter_status == 'Draft' ) : ?>
                        <a href="add-product/<?php echo $products[$i]['id'];?>" ><i class="fa fa-edit fa-2x"></i></a>
                        <?php endif; ?>
                        <?php if ( $filter_status == 'Publish' ) : ?>
                        <a href="edit-product/<?php echo $products[$i]['seourl'];?>" ><i class="fa fa-edit fa-2x"></i></a>
                        <?php endif; ?>
                        &nbsp;
                        <a href="javascript:void(0);" ><i class="fa fa-trash fa-2x"></i></a>
                        <!--<a href="javascript:void(0);" style="background-color:#0e73bc; color:#fff; padding:5px 7px 5px 7px; border-radius:6px;">DELETE</a>-->
                    </td>
               </tr>
            <?php } ?>
           
            </tbody>
        </table>

           </div>
           </div>
	</form>
</div>

   

<script type="text/javascript">
function filter_product() {
	$('input[name=page_no]').val('0');
	$('#form-products').submit();
}

</script>
	
<?php $this->load->view('site/templates/footer');?>