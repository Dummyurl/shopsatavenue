<?php

$this->load->view('site/templates/header');

?>
<style>
    .footerseperator
    {
        width: 100%;
        height: 60px;
        clear: both;
    }

    #order_popup { width:80%; background-color:#FFF; /*border:5px solid gray;*/ border-radius:10px; height:auto;  }
.head1 { font-size:16px; font-weight:600; color:#000; text-align:center; padding-top:20px; padding-bottom:10px; }
.close-popup { float: right; padding-right: 15px; margin-top: -10px; cursor:pointer; }

.product_row { width:100% !important; border-bottom:1px solid #A0A0A4; padding-top:5px; padding-bottom:5px; }
.product_row div { display:inline-block; width:100%;  float:left;  }
.product_row > div:first-child {width:60px; text-align:center } 
.product_row > div:nth-child(2) {width:80px; } 
.product_row > div:nth-child(3) {width:500px; padding-left:5px; } 
.product_row > div:nth-child(4) {width:100px; } 
.product_row > div:nth-child(5) {width:100px; } 
.product_row > div:nth-child(6) {width:100px; } 
.product_row > div:nth-child(7) {width:100px; }
.total_row { width:950px; color:#000; font-weight:600; text-align:right;  margin:auto; }
.total_row span { width:120px; text-align:right; float:right; padding-right:30px; }
.product_row:last-child { border-bottom:none; }

.product_table { width:950px; margin:auto !important; }
.pname { color:#4D4A4A; }
.price { text-align: right; padding-right: 20px; }
.rtn-message { font-size:16px; color:#F00; text-align:center; padding-bottom:30px; }

#shipment_info { width:300px; background-color:#FFF; /*border:5px solid gray;*/ border-radius:10px; height:auto; color:#000; 
padding-top:10px; padding-bottom:10px; }
.selected { background-color:#FFDF00; }

ul.nav.tabs { display:inline-block; }
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
.tabs li{
    display:inline-block;
}
ul.nav.tabs {
    text-align: center;
    margin-bottom: 1em;
}
.tabs li a {
    font-size: 1em;
    color: #8A8A8A;
    padding: 16px 17px !important;
    display: inline-block;
}

.tabs  li.active {
    border-bottom: 2px solid #000
}
.nav > li > a:hover, .nav > li > a:focus {
    background: none;
}

.tab-content-t {
    padding: 1em !important;
}


.sec-title
{
    margin-bottom: 30px;
}
</style>

		
<?php $this->load->view('site/templates/user_menu'); ?>
<?php
// echo "<pre>";
// print_r($page_items);
// echo "</pre>";
?>

<div class="container contact-form-area">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="contact-form">
                    <div class="sec-title pdb-50">
                        <h3>My Offers And Discounts</h3>
                        <span class="border"></span>
                    </div>

                     <div class="tab-content tab-content-t " style="background-color:#efefef;">
                <div class="tab-pane active text-style" id="result_content"  >
                        <div class="con-w3l">
                            <section id="responsive">
                   <table class="table table-bordered table-striped">

                    <thead>
      <tr>
        <th>#</th>
        <th>Product Image</th>
        <th>Product Title</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Discount</th>
        <th>Shipping Amount</th>
          <th>Total</th>
      </tr>
    </thead>
    <tbody>


    <?php
    foreach ($page_items as $key => $value) {
    	# code...
    	?>
    	<tr>
    	<td>
    	<?php 
    	echo $key+1;
    	?>
    	</td>
    	<td>
    	<?php 
    	 $imgSplit = explode(",",$value['image']); 
                        
                        if( ! empty($imgSplit[0]) ) { 
                            $image = 'images/product/' . $value['pid'] . '/mb/thumb/' . stripslashes($imgSplit[0]); 
                        } else { 
                            $image = "images/noimage.jpg";  
                        }
                        ?>
                        <img src='<?php echo  $image;?>' style="width:100px"/>
    	</td>
    	<td>
    	<?php 
    	echo $value['name'];
    	?>
    	</td>
    	<td>
    	<?php 
    	echo "$ ".number_format($value['price'],2);
    	?>
    	</td>
    	<td>
    	<?php 
    	echo $value['quantity'];
    	?>
    	</td>
    	<td>
    	<?php 
    	echo "$ ".number_format($value['disc_amount'],2);
    	
    	?>
    	</td>
    	<td>
    	<?php 
    	echo "$ ".number_format($value['shipping_paid'],2);
    	
    	?>
    	</td>
    	<td>
    	<?php 
    	echo "$ ".number_format($value['total'],2);
    	
    	?>
    	</td>
    	</tr>
    	<?php
    }

    ?>
     </tbody>

                    	
                    </table>  
                    </section>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

     <div class="footerseperator"></div>

<!-- Section_start -->



<?php 

$this->load->view('site/templates/footer');

?>

<script>
 function saveContact()
  {
   


var form_name = $("#form_name").val();
var form_email = $("#form_email").val();
var form_phone = $("#form_phone").val();
var form_subject = $("#form_subject").val();
var form_message = $("#form_message").val();



          jQuery.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "save_contact_support",
          dataType: 'json',
          data: {form_name: form_name, form_email: form_email,form_phone: form_phone,form_subject: form_subject,form_message: form_message},
          success: function(res) {
          if (res)
          {
          // Show Entered Value



      $("#notificationUpdate").html('<div class="col-xs-12 alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Your query submitted we will call you back soon.<span class="loadinpoint"></span></div><div style="clear:both"></div>');


        

        

       



          }
          }
          });

   

   // save_user_email_setting

   
  }
</script>