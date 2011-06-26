<h2 class="content_title"><img src="<?= $modules_assets ?>flickr_32.png"> Flickr</h2>
<ul class="content_navigation">
	<?= navigation_list_btn('home/flickr', 'Recent') ?>
	<?= navigation_list_btn('home/flickr/custom', 'Custom') ?>
	<?php if ($logged_user_level_id <= 2) echo navigation_list_btn('home/flickr/manage', 'Manage', $this->uri->segment(4)) ?>
</ul>