<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Flickr : Install
* Author: 		Brennan Novak
* 		  		contact@social-igniter.com
*         		@brennannovak
*          
* Created: 		Brennan Novak
*
* Project:		http://social-igniter.com/
* Source: 		http://github.com/socialigniter/flickr
*
* Description: 	Install values for Flickr App for Social Igniter 
*/
/* Settings */
$config['flickr_settings']['enabled'] 				= 'TRUE';
$config['flickr_settings']['date_style'] 			= 'SIMPLE';
$config['flickr_settings']['consumer_key']			= '';
$config['flickr_settings']['consumer_key_secret']	= '';
$config['flickr_settings']['social_login']			= 'TRUE';
$config['flickr_settings']['social_connection']		= 'TRUE';
$config['flickr_settings']['social_photos']			= 'TRUE';
$config['flickr_settings']['create_permission']		= '3';
$config['flickr_settings']['publish_permission']	= '2';
$config['flickr_settings']['manage_permission']		= '2';
$config['flickr_settings']['comments_per_page']		= '5';
$config['flickr_settings']['comments_allow']		= 'no';
$config['flickr_settings']['images_sizes_original']	= 'yes';

/* Site */
$config['flickr_site'] = array(
array(
	'url' 		=> 'flickr.com', 
	'module' 	=> 'flickr', 
	'type' 		=> 'remote', 
	'title' 	=> 'Flickr', 
	'favicon' 	=> 'flickr_24.png'
));

/* Folders */
$config['flickr_folders'] 							= array('flickr');