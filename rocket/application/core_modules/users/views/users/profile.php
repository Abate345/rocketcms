<?
	echo "
		<script>
			var base_url = '". base_url() ."';
			var project_id = '". $project->project_id ."';
		</script>
	";
?>
<div class='sheet profile'>
	<header class='project_title'>
		<h3>Account</h3>
	</header>
	
	<div class="sheet_body">
		<section id="profile">
			<?php if (auth_errors() || validation_errors()) : ?>
			<div class="row-fluid">
				<div class="span8 offset2">
					<div class="alert alert-error fade in">
						<?php echo auth_errors() . validation_errors(); ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
			
			<?php if ($success) : ?>
			<div class="row-fluid">
				<div class="span8 offset2">
					<div class="alert alert-success fade in">
						<?=$success?>
					</div>
				</div>
			</div>
			<?php endif; ?>
			
			

			<?php if (isset($user) && $user->role_name == 'Banned') : ?>
			<div class="row-fluid">
				<div class="span8 offset2">
					<div data-dismiss="alert" class="alert alert-error fade in">
					  <a data-dismiss="alert" class="close">&times;</a>
						<?php echo lang('us_banned_admin_note'); ?>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<div class="row-fluid">
				<div class="span12">

			<?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
				
				<p class="clearfix">
					<em>(<abbr>*</abbr>) All fields are required</em>
				</p>
				<div class="control-group">
					<label>Full Name:<abbr>*</abbr></label>
					<div class="controls">
						<input id="full_name" type="text" name="full_name" maxlength="255" value="<?php echo set_value('full_name', isset($user) ? $user->full_name : ''); ?>"  />
					</div>	
				</div>
				
				<div class="control-group">
					<label>Username:<abbr>*</abbr></label>
					<div class="controls">
						<input class="span6" type="text" id="username" name="username" value="<?php echo set_value('username', isset($user) ? $user->username : '') ?>" />
					</div>
				</div>
				

				<div class="control-group">
					<label>Email:<abbr>*</abbr></label>
					<div class="controls">
						<input class="span6" type="text" id="email" name="email" value="<?php echo set_value('email', isset($user) ? $user->email : '') ?>" />
					</div>
				</div>


				<div class="control-group">
					<label>Password:</label>
					<div class="controls">
						<input class="span6" type="password" id="password" name="password" value="" />
					</div>
				</div>

				<div class="control-group">
					<label>Password (repeat):</label>
					<div class="controls">
						<input class="span6" type="password" id="pass_confirm" name="pass_confirm" value="" />
					</div>
				</div>

				<?php if (isset($languages) && is_array($languages) && count($languages)) : ?>
					<?php if(count($languages) == 1): ?>
						<input type="hidden" id="language" name="language" value="<?php echo $languages[0]; ?>">
					<?php else: ?>
						<div class="control-group <?php echo form_error('language') ? 'error' : '' ?>">
							<label class="control-label required" for="language"><?php echo lang('bf_language') ?></label>
							<div class="controls">
								<select name="language" id="language" class="chzn-select">
								<?php foreach ($languages as $language) : ?>
									<option value="<?php e($language) ?>" <?php echo set_select('language', $language, isset($user->language) && $user->language == $language ? TRUE : FALSE) ?>>
										<?php e(ucfirst($language)) ?>
									</option>

								<?php endforeach; ?>
								</select>
								<?php if (form_error('language')) echo '<span class="help-inline">'. form_error('language') .'</span>'; ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<div class="control-group">
					<label>Timezone:<abbr>*</abbr></label>
					<div class="controls">
						<?php echo timezone_menu(set_value('timezone', isset($user) ? $user->timezone : $current_user->timezone)); ?>
						<?php if (form_error('timezone')) echo '<span class="help-inline">'. form_error('timezone') .'</span>'; ?>
					</div>
				</div>

				<?php
					// Allow modules to render custom fields
					Events::trigger('render_user_form', $user );
				?>

				<!-- Start of Form Actions -->
				<div class="form-actions">
					<input type="submit" name="submit" class="btn btn-primary" value="<?php echo lang('bf_action_save') .' '. lang('bf_user') ?> " />
					<a class="pill pill-style2" href="/project"><span class="pill-inner">Cancel</span></a>
				</div>
				<!-- End of Form Actions -->

			<?php echo form_close(); ?>

				</div>
			</div>
		</section>
	</div>
	<div id="shade"></div>
</div>
