<?php echo theme_view('parts/_header'); ?>

<div class="container narrow-body"> <!-- Start of Main Container -->

<?php

	echo Template::message();
	echo isset($content) ? $content : Template::r_yield();
?>

<?php echo theme_view('parts/_footer'); ?>