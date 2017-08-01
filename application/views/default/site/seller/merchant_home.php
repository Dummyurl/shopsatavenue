<?php  
//die;
$this->load->view('site/templates/commonheader'); 
$this->load->view('site/templates/merchant_header');

?>
<link href='3rdparty/morris/morris.css' rel='stylesheet' type='text/css'>

<style>
.box.box-solid { border-top: 0;}
.bg-teal-gradient {
    background: #39cccc !important;
    background: -webkit-gradient(linear, left bottom, left top, color-stop(0, #39cccc), color-stop(1, #7adddd)) !important;
    background: -ms-linear-gradient(bottom, #39cccc, #7adddd) !important;
    background: -moz-linear-gradient(center bottom, #39cccc 0, #7adddd 100%) !important;
    background: -o-linear-gradient(#7adddd, #39cccc) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#7adddd', endColorstr='#39cccc', GradientType=0) !important;
    color: #fff;
}

.box {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border-top: 3px solid #d2d6de;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
.box.box-solid[class*="bg"] > .box-header {
    color: #fff;
}
.box-header {
    color: #444;
    display: block;
    padding: 10px;
    position: relative;
}
.box-title1{
    color: #000;
    font-weight: 700;
	padding-left:10px;
	display:inline-block;
}

</style>
   <div class="container" >
    <div class="row">
        <div class="col-md-3">&nbsp;</div>
        <div class="col-md-6">
            <div class="tab-head ">
                <nav class="nav-sidebar" >
                    <ul class="nav tabs ">
                        <li class="active"><a href="#tab1" data-toggle="tab" style="color:#2a9ff5;">Yesterday</a></li>
                        <li class=""><a href="#tab2" data-toggle="tab"  style="color:#2a9ff5;">Current Pay Period</a></li> 
                        <li class=""><a href="#tab3" data-toggle="tab"  style="color:#2a9ff5;">Previous Pay Period</a></li>  
                    </ul>
                </nav>
                <div class="tab-content tab-content-t ">
                    <div class="tab-pane active text-style" id="tab1">
                        <div>
                            <div class="col-md-4">
                                <div class="">
                                        <p style="text-align:center;"><strong>$<?php echo number_format($shop->total_sales_amount,2);?></strong><br>
                                        Total Sales</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="">
                                    <p style="text-align:center;"><strong><?php echo (int)$shop->total_views; ?></strong><br>Detail Views</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="">
                                        <p style="text-align:center;"><strong><?php echo (int)$shop->total_likes; ?></strong><br>Loves</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="tab-pane  text-style" id="tab2">
                        <div class="con-w3l">
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                        <p style="text-align:center;"><strong>$<?php echo number_format($sales_current->current_period_amount,2);?></strong><br>Total Sales</p>
                                </div>
                            </div>
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                    <p style="text-align:center;"><strong><?php echo (int)$sales_current->current_period_views; ?></strong><br>Detail Views</p>
                                </div>
                            </div>
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                    <p style="text-align:center;"><strong><?php echo (int)$sales_current->current_period_likes; ?></strong><br>Loves</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                        
                    <div class="tab-pane  text-style" id="tab3">
                        <div class="con-w3l">
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                        <p style="text-align:center;"><strong>$<?php echo number_format($sales_previous->previous_period_amount,2);?></strong><br>Total Sales</p>
                                </div>
                            </div>
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                    <p style="text-align:center;"><strong><?php echo (int)$sales_previous->previous_period_views; ?></strong><br>Detail Views</p>
                                </div>
                            </div>
                            <div class="col-md-4 m-wthree">
                                <div class="product-grid-item-wrapper">
                                    <p style="text-align:center;"><strong><?php echo (int)$sales_previous->previous_period_likes; ?></strong><br>Loves</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>
        <div class="col-md-3">&nbsp;</div>
    </div>

      <div class="row">
        <section class="col-md-12 connectedSortable">

          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th fa-2x"></i>
              <h3 class="box-title1">Sales Graph</h3>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div>
          </div>
          <!-- /.box -->


        </section>
        <!-- right col -->
      </div>
      
      <div class="row">
      	<section class="col-md-6 col-xs-12">
            <div class="box-header">
            	<h3>Top Seller</h3>
            </div>
            <table class="table table-responsive" style="margin-top:10px;">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Sales</th>
                    <th>Views</th>
                    <th>Likes</th>
                </tr>
                </thead>
                <tbody>
						<?php  
								for( $i=0; $i < count($top_sales); $i++ )   {
                                	$imgArr=explode(',' , $top_sales[$i]['image']);
                        ?>
                          <tr>
                                <td>
                                	<img class="" width="50" height="50" alt="." src="images/product/<?php echo $top_sales[$i]['product_id'];?>/<?php echo $imgArr[0] == '' ? 'images/noimage.jpg' : $imgArr[0]; ?>" >
                                </td>
                                <td><?php echo $top_sales[$i]['product_name']; ?></td>
                                <td><?php echo $top_sales[$i]['total_sales']; ?></td>
                                <td><?php echo $top_sales[$i]['total_views']; ?></td>
                                <td><?php echo $top_sales[$i]['total_likes']; ?></td>
                          </tr>
						<?php } ?>
                       
                </tbody>
            </table>
        
        </section>
      </div>

    </div>


<?php $this->load->view('site/templates/footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script type="text/javascript" src="3rdparty/morris/morris.min.js"></script>

<script type="text/javascript">
  var line = new Morris.Line({
    element: 'line-chart',
    resize: true,
    data: [
      {y: '2011 Q1', item1: 2666},
      {y: '2011 Q2', item1: 2778},
      {y: '2011 Q3', item1: 4912},
      {y: '2011 Q4', item1: 3767},
      {y: '2012 Q1', item1: 6810},
      {y: '2012 Q2', item1: 5670},
      {y: '2012 Q3', item1: 4820},
      {y: '2012 Q4', item1: 15073},
      {y: '2013 Q1', item1: 10687},
      {y: '2013 Q2', item1: 8432}
    ],
    xkey: 'y',
    ykeys: ['item1'],
    labels: ['Item 1'],
    lineColors: ['#efefef'],
    lineWidth: 2,
    hideHover: 'auto',
    gridTextColor: "#fff",
    gridStrokeWidth: 0.4,
    pointSize: 4,
    pointStrokeColors: ["#efefef"],
    gridLineColor: "#efefef",
    gridTextFamily: "Open Sans",
    gridTextSize: 10
  });

</script>