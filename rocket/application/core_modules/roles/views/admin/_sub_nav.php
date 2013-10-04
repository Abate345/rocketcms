<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(3) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/roles') ?>"><?php echo lang('role_roles'); ?></a>
	</li>

	<li <?php echo $this->uri->segment(3) == 'create' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/roles/create') ?>" id="create_new"><?php echo lang('role_new_role'); ?></a>
	</li>
</ul>

