<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * Flickr API : Module : Social-Igniter
 *
 */
class Api extends Oauth_Controller
{
	protected $module_site;

    function __construct()
    {
        parent::__construct(); 
        
        $this->load->config('flickr');
        $this->load->helper('flickr');  
  		$this->load->helper('file');            
 
		// Get Site for Flickr
		$this->module_site = $this->social_igniter->get_site_view_row('module', 'flickr');    
    }

	function new_get()
	{
		if ($new_content = $this->social_igniter->get_content_new_count('flickr'))
		{
         	$message = array('status' => 'success', 'message' => 'New Flickr photos', 'data' => $new_content);	
		}
		else
		{
         	$message = array('status' => 'error', 'message' => 'No new Flickr photos', 'data' => $new_content);			
		}
		
        $this->response($message, 200);		
	}
	
	function download_get()
	{
		$count = $this->download_flickr_photos();
		
        // Needs logic if photos are not archived successfully
        $message = array('status' => 'success', 'message' => 'Flickr photos successfully archived', 'data' => $count);
		
		// API Response		
		$this->response($message, 200);
	}

	private function download_flickr_photos($num=10)
	{
		$this->load->library('curl');

		$recent_images	= $this->curl->simple_get('http://localhost/sampledata.json');
		$recent_images	= json_decode($recent_images);
		$archive_count	= 0;

		// NEEDS logic for checking if new images exist...
		// NEEDS logic for pagination archiving...

		foreach ($recent_images->photos->photo as $photo)
		{	
			$canonical 		= 'http://flickr.com/photos/'.$photo->owner.'/'.$photo->id;
			$photo_exists 	= $this->social_igniter->check_content_duplicate('canonical', $canonical);
		
			if ($photo_exists)
			{
				$this->process_photo($canonical, $photo);
				$archive_count++;				
			}
		}
		
		return $archive_count;
	}

	private function process_photo($canonical, $photo)
	{
		// Image Filename
		$image_name	= flickr_make_image_name($photo->title, $photo->id);
		preg_match("/\.([^\.]+)$/", $photo->url_t, $extension_matches);	
		$image_filename = $image_name.'.'.$extension_matches[1];
	
		$image_content = array(
			'flickr_id'			=> $photo->id,
			'date_taken'		=> $photo->datetaken,
			'description'		=> $photo->description->_content,
			'small'				=> 'small_'.$image_filename,
			'medium'			=> 'medium_'.$image_filename,
			'large'				=> 'large_'.$image_filename,
			'original'			=> 'original_'.$image_filename
		);
		
    	$content_data = array(
    		'site_id'			=> $this->module_site->site_id,
			'parent_id'			=> $this->input->post('parent_id'),
			'category_id'		=> $this->input->post('category_id'),
			'module'			=> 'flickr',
			'type'				=> 'photo',  // ActivityStream type
			'source'			=> 'import',
			'order'				=> 0,
    		'user_id'			=> config_item('flickr_import_owner_id'),
			'title'				=> $photo->title,
			'title_url'			=> form_title_url($photo->title, NULL),
			'content'			=> json_encode($image_content),
			'details'			=> '',
			'canonical'			=> $canonical,
			'access'			=> 'E',  // E-everyone P-private
			'comments_allow'	=> 'Y',
			'geo_lat'			=> $photo->latitude,
			'geo_long'			=> $photo->longitude,
			'viewed'			=> 'N',
			'approval'			=> 'Y', // Already Approved
			'status'			=> 'P'  // Published
    	);
    	
		$activity_data = array(			
			'title'			=> $photo->title,
			'content' 		=> $photo->description->_content,
			'thumb' 		=> base_url().config_item('flickr_images_folder').$photo->id."/small_".$image_filename,
			'description'	=> $photo->description->_content
		);

		$add_photo = $this->social_igniter->add_content($content_data, $activity_data);
					
		// Snatch Flickr Image
		$this->load->model('image_model');
		make_folder(config_item('flickr_images_folder').$photo->id.'/');
		
		// Small
		if (isset($photo->url_t))
		{
			$this->image_model->get_external_image($photo->url_t, config_item('flickr_images_folder').$photo->id.'/small_'.$image_filename);				    	
		}

		// Medium
		if (isset($photo->url_s))
		{
			$this->image_model->get_external_image($photo->url_s, config_item('flickr_images_folder').$photo->id.'/medium_'.$image_filename);				    	
		}
		
		// Large
		if (isset($photo->url_z))
		{
			$this->image_model->get_external_image($photo->url_z, config_item('flickr_images_folder').$photo->id.'/large_'.$image_filename);			
		}

		// Original
		if (isset($photo->url_o) AND config_item('flickr_images_sizes_original') == 'yes')
		{ 
			$this->image_model->get_external_image($photo->url_o, config_item('flickr_images_folder').$photo->id.'/large_'.$image_filename);
		}
	}
}