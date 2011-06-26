<?php
class Flickr extends Site_Controller
{
    function __construct()
    {
        parent::__construct();       

		$this->load->config('config');
	}
	
	function index()
	{
		$this->data['page_title'] = 'Flickr';
		$this->render();	
	}

	function view() 
	{		
		// Basic Content Redirect	
		$this->render();
	}
	
}
