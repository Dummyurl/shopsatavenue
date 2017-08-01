<!DOCTYPE html>
<html lang="en-US">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Shops at Avenue</title>
<link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap.css">
<link href="<?php echo base_url();?>font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url();?>css/style.css">


<base href="<?php echo base_url(); ?>" />

	<?php if($this->config->item('google_verification')){ echo stripslashes($this->config->item('google_verification')); }
	if ($heading == ''){?>    
		<title><?php echo $title;?></title>
	<?php }else {?>
		<title><?php echo $heading;?></title>
	<?php }?>
	
<meta name="Title" content="<?php if($meta_title=='') { echo $this->config->item('meta_title'); } else { echo $meta_title; } ?>" >
<meta name="keywords" content="<?php if($meta_keyword=='') { echo $this->config->item('meta_keyword'); } else { echo $meta_keyword; } ?>" >
<meta name="description" content="<?php if($meta_description==''){ echo $this->config->item('meta_description');} else { echo htmlentities($meta_description);}?>" >
	
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().'images/logo/'.$this->config->item('fevicon_image'); ?>">


<?php 
if($this->config->item('publish')!='Production'){	
	$chkPrv=$this->product_model->checkLogin('A');
	if($chkPrv==''){
		
		echo '<title>Coming Soon</title>';
		echo '<div style="background-color:#131521; width:100%;"><div style="margin: 0 auto; width:1300px;"><img src="images/under_maintainence.jpg" alt="under maintainence"></div></div>';
	
		die;
	}
}

?>

<!--header-->

