<?php
	// Setup our default assets to load.
	//Assets::add_js( 'bootstrap.min.js' );
			
	//~ $inline  = '$(".dropdown-toggle").dropdown();';
	//~ $inline .= '$(".tooltips").tooltip();';
	//~ $inline .= '$(".login-btn").click(function(e){ e.preventDefault(); $("#modal-login").modal(); });';
//~ 
	//~ Assets::add_js( $inline, 'inline' );

	Template::block('header', 'parts/head');

	Template::block('topbar', 'parts/topbar');
?>
