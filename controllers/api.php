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
	
	function get_comments()
	{
	
	
	}
		

	function get_favorites()
	{
	
	
	}


}