<?php
class Connections extends MY_Controller
{
	protected $module_site;

    function __construct()
    {
        parent::__construct();
		   
		if (config_item('flickr_enabled') != 'TRUE') redirect(base_url());
	
		$config = array(
			'flickr_consumer_key' => config_item('flickr_consumer_key'),
			'flickr_consumer_secret' => config_item('flickr_consumer_key_secret')
		);
	
		$this->load->library('flickr_library', $config);
		
		// Get Site for Flickr
		$this->module_site = $this->social_igniter->get_site_view_row('module', 'flickr');
	}

	function index()
	{	
		// User Is Logged In
		if ($this->social_auth->logged_in()) redirect('connections/flickr/add');
	
		
	}
	
	function test()
	{
		if ($connection = $this->social_auth->check_connection_user($this->oauth_user_id, 'flickr', 'primary'))
		{
			$this->tweet->set_tokens(array('oauth_token' => $connection->auth_one, 'oauth_token_secret' => $connection->auth_two));

			$twitter_post = $this->tweet->call('post', 'statuses/update', array('status' => $this->input->post('content')));		

			$message = array('status' => 'success', 'message' => 'Posted to Twitter successfully', 'data' => $twitter_post);
		}
		else
		{
			$message = array('status' => 'error', 'message' => 'No Twitter account for that user');			
		}


		$tokens 			= $this->flickr_library->get_tokens();	

		$check_connection	= $this->social_auth->check_connection_auth('flickr', $tokens['oauth_token'], $tokens['oauth_token_secret']);

		$flickr_user		= $this->flickr_library->call('get', 'flickr.test.login');

		print_r($flickr_user);
	}

	function add()
	{
		// User Is Logged In
		if (!$this->social_auth->logged_in()) redirect('connections/flickr');

		// Do Flickr Auth
		if (!$this->flickr_library->logged_in())
		{
			// Redirect after auth
			$this->flickr_library->set_callback(base_url().'flickr/connections/add');

			// Send to login
			$this->flickr_library->login();
		}
		else
		{
			// Get Tokens, Check Connection, Add
			$tokens 			= $this->flickr_library->get_tokens();	
			$check_connection	= $this->social_auth->check_connection_auth('flickr', $tokens['oauth_token'], $tokens['oauth_token_secret']);
			$flickr_user		= $this->flickr_library->call('get', 'flickr.test.login');

			if (connection_has_auth($check_connection))
			{			
				$this->session->set_flashdata('message', "You've already connected this Flickr account");
				redirect('settings/connections', 'refresh');
			}
			else
			{
				// Add Connection	
	       		$connection_data = array(
	       			'site_id'				=> $this->module_site->site_id,
	       			'user_id'				=> $this->session->userdata('user_id'),
	       			'module'				=> 'flickr',
	       			'type'					=> 'primary',
	       			'connection_user_id'	=> $flickr_user->user->id,
	       			'connection_username'	=> $flickr_user->user->username->_content,
	       			'auth_one'				=> $tokens['oauth_token'],
	       			'auth_two'				=> $tokens['oauth_token_secret']
	       		);

	       		// Update / Add Connection	       		
	       		if ($check_connection)
	       		{
	       			$connection = $this->social_auth->update_connection($check_connection->connection_id, $connection_data);
	       		}
	       		else
	       		{
					$connection = $this->social_auth->add_connection($connection_data);
				}

				// Connection Status				
				if ($connection)
				{
					$this->social_auth->set_userdata_connections($this->session->userdata('user_id'));
				
					$this->session->set_flashdata('message', "Flickr account connected");
				 	redirect('settings/connections', 'refresh');
				}
				else
				{
				 	$this->session->set_flashdata('message', "That Flickr account is connected to another user");
				 	redirect('settings/connections', 'refresh');
				}
			}		
		}
	}
}