<?php $this->load->view('site/templates/header'); ?>
<style>
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
</style>
<?php $this->load->view('site/templates/user_menu'); ?>

<?php 
	$this->load->model('user_model');
	$this->load->model('product_model');
 ?>
	<div class="container">
	  <div class="row">
            <div class="col-lg-12 col-md-12">
                
                    <div class="sec-title pdb-50">
                        <h1>My Likes</h1>
                        <span class="border"></span>
                    </div>
                    
              <div id="error-msg"></div>
              
              <table class="table table-striped table-bordered" style="margin-top: 20px" >
            
               <thead>
                  <tr>
                    <th>#</th>
                    <th>Product Image</th>
                    <th>Product Title</th>
                    <th>Price</th>
                    <th>Action</th>
                  
                  </tr>
                </thead>
                <tbody>
				<?php 
                    if(!empty($product_list)) { 
                        $i=0;
                        foreach( $product_list as $proddetails ) {
                        $imgSplit = explode(",",$proddetails['image']); 
                     
                        if( ! empty($imgSplit[0]) ) { 
                            $image = 'images/product/' . $proddetails['id'] . '/mb/thumb/' . stripslashes($imgSplit[0]); 
                        } else { 
                            $image = "images/noimage.jpg";  
                        }
                ?>

					<tr>
				    	<td><?php 	echo $i+1;	?></td>
				    	<td>
				    	<?php 
				    	 $imgSplit = explode(",",$proddetails['image']); 
				                        
				                        if( ! empty($imgSplit[0]) ) { 
				                            $image = 'images/product/' . $proddetails['id'] . '/mb/thumb/' . stripslashes($imgSplit[0]); 
				                        } else { 
				                            $image = "images/noimage.jpg";  
				                        }
				                        ?>
				                        <img src='<?php echo  $image;?>' style="width:100px"/>
				    	</td>
				    	<td>
				    	<?php 
				    	echo $proddetails['product_name'];
				    	?>
				    	</td>
				    	<td>
				    	<?php 
				    	echo "$ ".number_format($proddetails['price'],2);
				    	?>
				    	</td>
				    
				    <td><button type="button" class="btn btn-small btn-block btn-primary" onclick="removeFavourite('<?php echo $proddetails['id'];?>', this)">Unlike</button></td>
				    
				    	</tr>

				<?php $i++; } //endforeach; ?>
                <?php } ?>

                </tbody>
                </table>

				</div><!-- pricing-wrapper -->
			</div>

               
  
	</div>
    <!-- container -->
            
	
<script type="text/javascript" >

function removeFavourite(id, obj )
{
	  $('#error-msg').html('');
	  $.ajax({
		  type: "POST",
		  url: "<?php echo base_url(); ?>" + "site/user/removeMyLikes",
		  data: {id :id },
		  dataType: 'json',
		  success: function(res) {
			  
			  if( res.hasOwnProperty('status') && res.status == 'success' ) {
				  $('#error-msg').html('<p class="alert-success text-center">Product unliked!</p>' );
				  $( obj ).closest('tr').remove();
			  }
			  
			  if( res.hasOwnProperty('status') && res.status == 'error' ) {
				  $('#error-msg').html('<p class="alert-success">Product unliked failed!</p>' );
			  }
		  }
	 });
}
</script>


<?php $this->load->view('site/templates/footer');?>
