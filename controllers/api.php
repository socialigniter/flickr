<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * Flickr API : Module : Social-Igniter
 *
 */
class Api extends Oauth_Controller
{
	// EXAMPLE - hacked from Facebook to 
	function social_post_authd_post()
	{
		$message = array('status' => 'error', 'message' => 'Test api end point');
	
	    $this->response($message, 200);
	}
	
	function new_get()
	{
	
		$this->response(array('data'=>2), 200);
	}
		

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