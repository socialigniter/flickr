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
		$this->response(array('data'=>2), 200);
	}
		
	function create_image_get()
	{
		$this->load->library('curl');
		
		$recent_images = $this->curl->simple_get('http://junk:8890/data/flickr.photos.getRecent.json');
		$recent_images = json_decode($recent_images);

		foreach ($recent_images->photos->photo as $photo)
		{	
			$check_photo = $this->social_igniter->get_content($photo->canonical);
		
			if (!$check_photo)
			{
				$image_name	= flickr_make_image_name($photo->title, $photo->id);
	
				preg_match("/\.([^\.]+)$/", $photo->url_t, $extension_matches);    
	
				$image_filename = $image_name.'.'.$extension_matches[1];
			
				$image_content = array(
					'flickr_id'	=> $photo->id,
					'small'		=> 'small_'.$image_filename,
					'medium'	=> 'medium_'.$image_filename,
					'large'		=> 'large_'.$image_filename,
					'original'	=> 'original_'.$image_filename
				);
				
		    	$content_data = array(
		    		'site_id'			=> config_item('site_id'),
					'parent_id'			=> $this->input->post('parent_id'),
					'category_id'		=> $this->input->post('category_id'),
					'module'			=> 'flickr',
					'type'				=> 'photo',  // activity stream type
					'source'			=> 'import',
					'order'				=> 0,
		    		'user_id'			=> config_item('flickr_import_owner_id'),
					'title'				=> $photo->title,
					'title_url'			=> form_title_url($photo->title, NULL),
					'content'			=> json_encode($image_content),
					'details'			=> '',
					'canonical'			=> 'http://flickr.com/photos/'.$photo->owner.'/'.$photo->id,
					'access'			=> 'E',  // E-everyone P-private
					'comments_allow'	=> 'Y',
					'geo_lat'			=> $photo->latitude,
					'geo_long'			=> $photo->longitude,
					'viewed'			=> 'N',
					'approval'			=> 'Y', // already approved
					'status'			=> 'P'  // published
		    	);
		    	
				$activity_data = array(			
					'title'			=> $photo->title,
					'content' 		=> $photo->description->_content,
					'thumb' 		=> base_url().config_item('flickr_images_folder').$photo->id."/small_".$image_filename
				);
	
				$add_photo = $this->social_igniter->add_content($content_data, $activity_data);
							
	    		// Snatch Flickr Image
	    		$this->load->model('image_model');
	    		make_folder(config_item('flickr_images_folder').$add_photo['content']->content_id.'/');
	    		
	    		// Small
				$this->image_model->get_external_image($photo->url_t, config_item('flickr_images_folder').$add_photo['content']->content_id.'/small_'.$image_filename);				    	
						
				// Medium
				$this->image_model->get_external_image($photo->url_s, config_item('flickr_images_folder').$add_photo['content']->content_id.'/medium_'.$image_filename);				    	
				
				// Large
				$this->image_model->get_external_image($photo->url_z, config_item('flickr_images_folder').$add_photo['content']->content_id.'/large_'.$image_filename);				    				
		
			}
		
		}
	
	}

/*						
			echo '<p>';
			echo '<b>Date Taken: </b>'.$photo->datetaken.'<br>';
			echo '<b>Title:</b> '.$photo->title.'<br>';
			echo '<b>Description:</b>'.$photo->description->_content.'<br>';
			echo '<b>Lat, Long:</b> '.$photo->latitude.', '.$photo->longitude.'<br>';				
			echo '<b>Source:</b> http://flickr.com/photos/'.$photo->owner.'/'.$photo->id.'<br>';
			echo '<b>Tiny: </b>'.$photo->url_t.'<br>';
			echo '<b>Small: </b>'.$photo->url_s.'<br>';
			echo '<b>Bigger: </b>'.$photo->url_z.'<br>';
			echo '<b>Original: </b>'.$photo->url_o.'</p>';
			echo '<hr>';
*/

	function download_get()
	{
	    	$content_data = array(
	    		'site_id'			=> config_item('site_id'),
				'parent_id'			=> $this->input->post('parent_id'),
				'category_id'		=> $this->input->post('category_id'),
				'module'			=> 'flickr',
				'type'				=> 'photo',  // activity stream type
				'source'			=> 'import',
				'order'				=> 0,
	    		'user_id'			=> config_item('flickr_import_owner_id'),
				'title'				=> $title,
				'title_url'			=> form_title_url($title, NULL),
				'content'			=> $content,
				'details'			=> '',
				'access'			=> 'E',  // E-everyone P-private
				'comments_allow'	=> 'Y',
				'geo_lat'			=> $lat,
				'geo_long'			=> $lng,
				'viewed'			=> 'N',
				'approval'			=> 'Y', // already approved
				'status'			=> 'P'  // published
	    	);

			// Insert, also creates activity entry
			$result = $this->social_igniter->add_content($content_data);
		
		$this->social_tools->process_tags(array('tag2','tag3'), $result['content']->content_id);
	
	
		$this->response(array('since'=>$_GET['since']), 200);
	}


}