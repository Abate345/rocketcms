<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(3) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/sysinfo') ?>"><?php echo lang('si.system'); ?></a>
	</li>
	<li <?php echo $this->uri->segment(3) == 'modules' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/sysinfo/modules') ?>"><?php echo lang('si.modules'); ?></a>
	</li>
	<li <?php echo $this->uri->segment(3) == 'php_info' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/sysinfo/php_info') ?>"><?php echo lang('si.php'); ?></a>
	</li>
</ul>

