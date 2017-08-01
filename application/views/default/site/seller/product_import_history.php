<?php 
$this->load->view('site/templates/commonheader'); 
$this->load->view('site/templates/merchant_header');

?>
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
   
<div class="container" >
     <div class="row">
           <div class="col-md-12">
            <h4>Product Import History</h4>
           </div>
     </div>
     <?php if( count($imports) == 0 ) { ?>
     <div class="row" style="margin-top:20px;">
           <div class="col-md-6 col-xs-12">
               <div>You have not imported a file yet. Once you do, you will see your imports here.</div>
           </div>
     </div>
     <?php } else { ?>
           <div class="col-md-12">
            <table class="table table-bordered table-striped" style="margin-top:0px;">
            <thead>
            <tr>
                <th >S.No</th>
                <th >File Name</th>
                <th >User ID</th>
                <th >Import Time</th>
                <th>Date</th>
                <!--<th>Action</th>-->
            </tr>
            </thead>
            <tbody>
            <?php  
                    for( $i=0; $i < count($imports); $i++ )   {
            ?>
                <tr>
                    <td style="text-align:center;">
                        <?php echo ($i+1); ?>
                    </td>
                    <td><?php echo $imports[$i]['file_name']; ?></td>
                    <td><?php echo $imports[$i]['user_name']; ?></td>
                    <td><?php echo date('m-d-Y H:i:s', $imports[$i]['import_time']); ?></td>
                    <td><?php echo date('m-d-Y', strtotime($imports[$i]['date_added']) ); ?></td>
               </tr>

            <?php } ?>
            	
            </tbody>
        </table>
        </div>

     <?php } ?>
</div>

   

<script type="text/javascript">

</script>
	
<?php $this->load->view('site/templates/footer');?>