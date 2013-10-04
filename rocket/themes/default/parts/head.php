<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php e($this->settings_lib->item('site.title')); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

	<script src="<?php echo Template::theme_url('js/modernizr-2.5.3.js') ?>"></script>
	<?php echo Assets::css(); ?>
	<link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" />
	
	<link rel="stylesheet" href="/assets/css/jquery.image-gallery.min.css">
	<!-- CSS to style the file input field as button and adjust the jQuery UI progress bars -->
	<link rel="stylesheet" href="/assets/css/jquery.fileupload-ui.css">
	<!-- CSS adjustments for browsers with JavaScript disabled -->
	<noscript><link rel="stylesheet" href="/assets/css/jquery.fileupload-ui-noscript.css"></noscript>
	
	<link rel="stylesheet" href="/assets/css/optima/base.css">
    <!-- iPhone and Mobile favicon's and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-114x114.png">
  </head>
<body>
<!--[if lt IE 7]>
		<p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or
		<a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p>
<![endif]-->
