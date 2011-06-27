<?php
class Flickr extends Site_Controller
{
    function __construct()
    {
        parent::__construct();       

		$this->load->config('flickr');
	}
	
	function index()
	{
		$this->data['page_title'] = 'Flickr';
		$this->render();	
	}

	function view() 
	{		
		// Basic Content Redirect	
		if ($this->uri->segment(2) == 'view')
		{
			$photo = $this->social_igniter->get_content($this->uri->segment(3));
		
			$photo_data = json_decode($photo->content);
			
			$this->data['photo'] = base_url().config_item('flickr_images_folder').$photo_data->flickr_id.'/'.$photo_data->large;
			$this->data['title'] = $photo->title;
		}

		$this->data['sub_title'] = $photo->title;		

		$this->render();
	}

	
}
