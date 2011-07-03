<?php
class Flickr extends Site_Controller
{
    function __construct()
    {
        parent::__construct();       

		$this->load->config('flickr');
		$this->load->helper('flickr');
	}
	
	function index()
	{
		$this->data['page_title'] = 'Flickr';
		$this->render();	
	}

	function view() 
	{		
		// Basic Content Redirect	
		if ($photo = $this->social_igniter->get_content($this->uri->segment(3)))
		{		
			$photo_data = json_decode($photo->content);
			
			$this->data['photo']		= base_url().config_item('flickr_images_folder').$photo_data->flickr_id.'/'.$photo_data->large;
			$this->data['title']		= $photo->title;
			$this->data['date_taken']	= format_datetime(config_item('flickr_date_style'), $photo_data->date_taken);
			$this->data['description']	= $photo_data->description;
			$this->data['canonical']	= $photo->canonical;			
			$this->data['sub_title'] 	= $photo->title;

			if (config_item('flickr_comments_allow') == 'TRUE')
			{				
				$this->data['comments_view'] = $this->social_tools->make_comments_section($photo->content_id, 'photo', $this->data['logged_user_id'], $this->data['logged_user_level_id']);
			}
		}
		else
		{
			redirect(404);
		}		

		$this->render();
	}
}
