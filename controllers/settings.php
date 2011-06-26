<?php
class Settings extends Dashboard_Controller 
{
    function __construct() 
    {
        parent::__construct();

		if ($this->data['logged_user_level_id'] > 1) redirect('home');	
        
        $this->load->config('flickr');
        
		$this->data['page_title']	= 'Flickr';
    }
 
 	function index()
	{ 	
		$this->data['sub_title'] = 'Settings';
		$this->render('dashboard_wide');
	}
	
	function widgets()
	{
		$this->data['sub_title'] = 'Widgets';		
		
		$this->render('dashboard_wide');
	}		

}