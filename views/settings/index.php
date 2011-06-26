<form name="settings" method="post" action="<?= base_url() ?>settings/update" enctype="multipart/form-data">	
<div class="content_wrap_inner">

	<div class="content_inner_top_right">
		<h3>Module</h3>
		<p><?= form_dropdown('enabled', config_item('enable_disable'), $settings['flickr']['enabled']) ?></p>
	</div>
	
	<h3>Application Keys</h3>

	<p>Flickr requires <a href="http://www.flickr.com/services/apps/create/apply/" target="_blank">registering your application</a></p>
				
	<p><input type="text" name="consumer_key" value="<?= $settings['flickr']['consumer_key'] ?>"> Consumer Key </p> 
	<p><input type="text" name="consumer_key_secret" value="<?= $settings['flickr']['consumer_key_secret'] ?>"> Consumer Key Secret</p>
			
</div>

<span class="item_separator"></span>

<div class="content_wrap_inner">

	<h3>Social</h3>

	<p>Sign In
	<?= form_dropdown('social_login', config_item('yes_or_no'), $settings['flickr']['social_login']) ?>
	</p>
	
	<p>Connections 
	<?= form_dropdown('social_connection', config_item('yes_or_no'), $settings['flickr']['social_connection']) ?>
	</p>	

	<p>Post
	<?= form_dropdown('social_post', config_item('yes_or_no'), $settings['flickr']['social_post']) ?>	
	</p>

</div>

<span class="item_separator"></span>

<div class="content_wrap_inner">
			
	<h3>Comments</h3>	

	<p>Allow
	<?= form_dropdown('comments_allow', config_item('yes_or_no'), $settings['flickr']['comments_allow']) ?>
	</p>

	<p>Comments Per-Page
	<?= form_dropdown('comments_per_page', config_item('amount_increments_five'), $settings['flickr']['comments_per_page']) ?>
	</p>

	<input type="hidden" name="module" value="flickr">

	<p><input type="submit" name="save" value="Save" /></p>

</div>
</form>
