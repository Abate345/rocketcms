<nav id="nav-topbar">
	<div class="logo">
		<a href="<?=site_url('project')?>" class="brand">
			<img src='<?=site_url('assets/images/logo.png')?>' />
		</a>
	</div>

	<div class="global_links">
		<?=render_menu()?>
	</div>

	<div class="current_user">
		
		<ul>
			<li><?=@$current_user->user_img?> <a href="/account">Account</a></li>
			<? if(0){ ?><li><a href="<?=site_url('plans')?>">Upgrades</a></li><? } ?>

			<li><a href="<?=site_url('logout')?>"><?=lang('bf_action_logout')?></a></li>
		</ul>
	</div>
	<div class="clear"></div>
</nav>