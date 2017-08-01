<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
if($this->config->item('publish')!= 'Production'){	
	$chkPrv=$this->product_model->checkLogin('A');
	if($chkPrv==''){
		
		echo '<title>Coming Soon</title>';
		echo '<div style="background-color:#131521; width:100%;"><div style="margin: 0 auto; width:1300px;"><img src="images/under_maintainence.jpg" alt="under maintainence"></div></div>';
		die;
	}
}

?>



<base href="<?php echo base_url(); ?>" />

	<?php if($this->config->item('google_verification')){ echo stripslashes($this->config->item('google_verification')); }
	if ($heading == ''){?>    
		<title><?php echo $title;?></title>
	<?php }else {?>
		<title><?php echo $heading;?></title>
	<?php }?>
	
<meta name="Title" content="<?php if($meta_title=='') { echo $this->config->item('meta_title'); } else { echo $meta_title; } ?>" />
<meta name="keywords" content="<?php if($meta_keyword=='') { echo $this->config->item('meta_keyword'); } else { echo $meta_keyword; } ?>" />
<meta name="description" content="<?php if($meta_description==''){ echo $this->config->item('meta_description');}else{ echo $meta_description;}?>" />
	
<?php  if($this->uri->segment(1)=='products'){
  if($meta_product_img !=''){?>
<meta property="og:title" content="<?php if($meta_title=='') { echo $this->config->item('meta_title'); } else { echo $meta_title; } ?>"/>
<meta property="og:type" content="IMAGE"/>
<meta property="og:url" content="<?php echo base_url().$meta_product_url;?>"/>
<meta property="og:image" content="<?php echo base_url().'images/product/thumb/'.$meta_product_img?>" />
<meta property="og:site_name" content="shopsy-v2"/>
<!--<meta property="fb:admins" content="USER_ID"/>-->
<meta property="og:description"  content="<?php if($meta_description==''){ echo $this->config->item('meta_description');}else{ echo $meta_description;}?>"/>

<?php }}?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().'images/logo/'.$this->config->item('fevicon_image'); ?>">    

<script type="text/javascript">
		var baseURL = '<?php echo base_url();?>';
		var BaseURL = '<?php echo base_url();?>';
		var currencySymbol = '<?php echo $currencySymbol;?>';
		var siteTitle = '<?php echo $siteTitle;?>';
		var can_show_signin_overlay = false;
		var currUrls = '<?php echo addslashes($this->uri->segment(4)); ?>';
</script>

<link href="3rdparty/bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link href="css/default/front/font-awesome.css" rel="stylesheet">
<script type="text/javascript" src="js/site/jquery.1.11.min.js"></script>
<script src="3rdparty/bootstrap-3.3.6/js/bootstrap.min.js" ></script>

<link href="css/default/front/main.css" rel="stylesheet">
<link href="css/default/front/home.css" rel="stylesheet">
<!--<link href="css/default/front/deal.css" rel="stylesheet">
<link href="css/default/front/browse.css" rel="stylesheet">
<link href="css/default/front/art.css" rel="stylesheet">
<link href="css/default/front/seller.css" rel="stylesheet">
<link href="css/default/front/custom.css" rel="stylesheet">-->
<link href="css/default/site/responsive-dev.css" rel="stylesheet"> 
<link rel="stylesheet" type="text/css" media="all" href="css/default/site/shopsy_style.css"/>
<link rel="stylesheet" type="text/css" media="all" href="css/default/site/shopsy_style_1.css"/>
<link rel="stylesheet" type="text/css" media="all" href="css/default/site/account_master.css"/>
<link rel="stylesheet" type="text/css" media="all" href="css/default/site/popup.css"/>
<link rel="stylesheet" type="text/css" media="all" href="css/default/site/help.css"/>
<link rel="stylesheet" type="text/css" media="all" href="css/default/front/auction.css"/>

<link href="css/default/front/edit-css.css" rel="stylesheet">
<link href="css/default/site/shop-add.css" rel="stylesheet">
<link href="css/default/front/menu-horizontal.css" rel="stylesheet">
<link href="css/default/front/zo-cas-style.css" rel="stylesheet">
<link href="css/default/front/style-responsive.css" rel="stylesheet">
<link href="css/default/front/responsive-style-sheet.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.elastislide.js"></script>
<script type="text/javascript" src="js/jcarousellite_1.0.1.pack.js"></script>

<?php 
	
	//$this->load->view('site/templates/css_files',$this->data);
	//$this->load->view('site/templates/script_files',$this->data);
?>
<!--[if lt IE 9]>
<script src="js/html5shiv/dist/html5shiv.js"></script>
<![endif]-->
<?php if($this->config->item('google_verification_code')){ echo stripslashes($this->config->item('google_verification_code'));} ?>

<!--header-->
<!--Theme settings-->
<?php 
$path='./theme/themecss_'.$themeLayout[0]['id'].'.css';
?>

<!--<script src="js/assets/jquery-v11.js"></script>
<script src="js/assets/bootstrap.min.js"></script>-->
