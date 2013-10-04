<?php
class error extends Front_Controller{
	public function __construct(){
		parent::__construct();
	}

	public function e404(){
		Template::redirect( site_url('404.html') );
	}
}
?>