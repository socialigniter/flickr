<?php

function flickr_make_image_name($title, $id)
{
	if ($title != '')
	{
		return url_username($title, 'dash', TRUE);
	}
	else
	{
		return $id;
	}
}