<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(3) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/users') ?>"><?php echo lang('bf_users'); ?></a>
	</li>
	<li <?php echo $this->uri->segment(3) == 'create' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/users/create') ?>" id="create_new"><?php echo lang('bf_new') .' '. lang('bf_user'); ?></a>
	</li>
</ul>
