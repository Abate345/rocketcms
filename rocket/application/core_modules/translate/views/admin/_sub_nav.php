<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(3) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/translate') ?>"><?php echo lang('tr_translate'); ?></a>
	</li>
	<? if(0){ ?>
		<li <?php echo $this->uri->segment(3) == 'export' ? 'class="active"' : '' ?>>
			<a href="<?php echo site_url(SITE_AREA .'/translate/export') ?>"><?php echo lang('tr_export_short'); ?></a>
		</li>
	<? } ?>	
</ul>
