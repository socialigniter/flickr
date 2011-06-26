<?php
class Connections extends MY_Controller
{
	protected $module_site;

    function __construct()
    {
        parent::__construct();
		   
		if (config_item('flickr_enabled') != 'TRUE') redirect(base_url());
	
		
		// Get Site for Flickr
		$this->module_site = $this->social_igniter->get_site_view_row('module', 'flickr');
	}

	function index()
	{	
		// User Is Logged In
		if ($this->social_auth->logged_in()) redirect('connections/flickr/add');
	
		
	}
	
	function signup()
	{
		echo 'echo at signup steps';

	}

	function add()
	{
		// User Is Logged In
		if (!$this->social_auth->logged_in()) redirect('connections/flickr');


}