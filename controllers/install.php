<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends Oauth_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('install');
	}

	function index_get()
	{
        if ($media = TRUE)
        {
            $message = array('status' => 'success', 'message' => 'The Media App was installed');
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Oops could not install the Media App');
        }
        
        $this->response($message, 200);
	}	
	
	function update_get()
	{
	
	}
	
	function uninstall_get()
	{
	
	}
}