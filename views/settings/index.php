<form name="settings" method="post" action="<?= base_url() ?>settings/update" enctype="multipart/form-data">	
<div class="content_wrap_inner">

	<div class="content_inner_top_right">
		<h3>Module</h3>
		<p><?= form_dropdown('enabled', config_item('enable_disable'), $settings['flickr']['enabled']) ?></p>
	</div>
	
	<h3>Permissions</h3>

	<p>Create
	<?= form_dropdown('create_permission', config_item('users_levels'), $settings['flickr']['create_permission']) ?>
	</p>

	<p>Publish
	<?= form_dropdown('publish_permission', config_item('users_levels'), $settings['flickr']['publish_permission']) ?>	
	</p>

	<p>Manage All
	<?= form_dropdown('manage_permission', config_item('users_levels'), $settings['flickr']['manage_permission']) ?>	
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

	<input type="hidden" name="module" value="module-template">

	<p><input type="submit" name="save" value="Save" /></p>

</div>
</form>
