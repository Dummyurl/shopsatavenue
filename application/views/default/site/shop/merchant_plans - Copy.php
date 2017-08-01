<?php $this->load->view('site/templates/commonheader');
//$this->load->view('site/templates/shop_header'); 
	
	$this->load->view('site/templates/css_files',$this->data);
	$this->load->view('site/templates/script_files',$this->data);

?>
<style>
.center {
    margin: auto;
    width: 100%;
    padding: 10px;
}
.center img { display:block; margin:auto; }
.page-head { text-align: center; line-height: 150%; letter-spacing: 3px; }
.head { text-align: center; line-height: 150%; letter-spacing: 3px; background-color:#CBEAEA; }

.register { margin:auto; width:150px; height:50px; border:1px solid #3FF; text-decoration:none; font-weight:800; padding-top:10px; border-radius:5px; }
/*.register div { margin-top:10px; }*/

thead th, td { font-size: 1.125rem; color: #4c4c4c; width:200px; text-align:center; }
tr { height:40px; }
td:nth-child(1) { text-align:left; }
tr:nth-child(1) { height:40px; }
tr:nth-child(2) { height:60px; }
tr:nth-child(6), tr:nth-child(7), tr:nth-child(9),tr:nth-child(11) { height:80px; }
tr:nth-child(13), tr:nth-child(16),tr:nth-child(17),tr:nth-child(19) { height:80px; }

</style>

<div class="content">
     <div class="center">
     		<a href="<?php echo base_url();?>">
            <img src="images/logo/<?php echo $logo;?>" alt="Shops@Avenue logo" title="Shops@Avenue"  >
            </a>
     </div>
     <div class="center">
           <h1 class="page-head">SELECT YOUR PLAN</h1>
     </div>

     <table width="90%" style="margin-left:50px" >
         <thead>
                  <th>&nbsp;</th>
                  <th>STARTER</th>
                  <th>PRO</th>
                  <th>ELITE</th>
                  <th>ENTERPRISE</th>
         </thead>
         <tbody>
         	<tr>
            	<td>Pricing</td>
                <td>Free - 1 Year
                </td>
                <td><sup style="top:-1.5em">$</sup><span style="font-size:xx-large; font-weight:700;">32</span><sup  style="top:-1.5em">.99</sup> <span style="font-size:smaller">/month</span>
                </td>
                <td><sup style="top:-1.5em">$</sup><span style="font-size:xx-large; font-weight:700;">199</span><sup  style="top:-1.5em">.99</sup> <span style="font-size:smaller">/month</span></td>
                <td><sup style="top:-1.5em">$</sup><span style="font-size:xx-large; font-weight:700;">2500</span><sup  style="top:-1.5em">.99</sup> <span style="font-size:smaller">/month</span></td>
            </tr>
            <tr>
            	<td></td>
                <td><a href="site/shop/plans/1"><div class="register"><div>Register</div></div></a></td>
                <td><a href="site/shop/plans/2"><div class="register"><div>Register</div></div></a></td>
                <td><a href="site/shop/plans/3"><div class="register"><div>Register</div></div></a></td>
                <td><a href="site/shop/plans/4"><div class="register"><div>Register</div></div></a></td>
            </tr>
         	<tr>
            	<td>Transaction Fee</td>
                <td>15%</td>
                <td>15%</td>
                <td>15%</td>
                <td>15%</td>
            </tr>
         	<tr>
            	<td>Credit Card Processing Fee</td>
                <td>3%</td>
                <td>3%</td>
                <td>3%</td>
                <td>3%</td>
            </tr>
            <tr class="head"><td colspan="5" style="text-align:center" >FEATURES</td></tr>
         	<tr>
            	<td>Get Preferred Email Placement for Your Products</td>
                <td>-</td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
            </tr>
         	<tr>
            	<td>Stay on Shoppers' Minds with Notifications</td>
                <td>-</td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
            </tr>
         	<tr>
            	<td>Get Help When You Need It</td>
                <td>Basic Assistance</td>
                <td>Priority Assistance</td>
                <td>Dedicated Account Manager</td>
                <td>Agency-Level Assistance</td>
            </tr>
         	<tr>
            	<td>Access Shopper & Marketing Analytics</td>
                <td>Basic Reporting</td>
                <td>Advanced Reporting</td>
                <td>In-Depth Analysis</td>
                <td>In-Depth Analysis</td>
            </tr>
         	<tr>
            	<td>Priority in Search</td>
                <td>-</td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
            </tr>
         	<tr>
            	<td>Shops@Avenue Home Page Placement</td>
                <td>-</td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
            </tr>
         	<tr>
            	<td>Featured in Sitewide Promos</td>
                <td>Limited Access</td>
                <td>Full Access</td>
                <td>Full Access</td>
                <td>Full Access</td>
            </tr>
         	<tr>
            	<td>Fully Hosted Shops@Avenue Store</td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
            </tr>
         	<tr>
            	<td>Easy Product Upload & Editing</td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
            </tr>
         	<tr>
            	<td>Product Listings</td>
                <td>Up to 100 Products</td>
                <td>Unlimited</td>
                <td>Unlimited</td>
                <td>Unlimited</td>
            </tr>
         	<tr>
            	<td>Top-Rate Fraud Analysis</td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
            </tr>
         	<tr>
            	<td>Easy Third-Party Fulfillment Integration</td>
                <td>-</td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
            </tr>
         	<tr>
            	<td>Time-Saving Bulk Product Editing & Order Processing</td>
                <td>-</td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
                <td><i class="fa fa-check-circle fa-2x"></i></td>
            </tr>
         	<tr>
            	<td>Targeted Ads on Facebook, Pinterest & Google</td>
                <td>-</td>
                <td>Eligible</td>
                <td>Eligible & Managed for You</td>
                <td>Eligible & Managed for You</td>
            </tr>
         	<tr>
            	<td>Sell on 200 Other Ad Channels</td>
                <td>-</td>
                <td>Eligible</td>
                <td>Eligible & Managed for You</td>
                <td>Eligible & Managed for You</td>
            </tr>
         </tbody>
     </table>
</div>

<?php $this->load->view('site/templates/footer'); ?>
