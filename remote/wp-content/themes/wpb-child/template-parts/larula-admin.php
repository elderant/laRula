<div class="wrap main-div admin-page larula-admin">
	<h1 class="title admin-page"><?php _e('La Rula Options', 'larula');?></h1>
	<form method="post" action="options.php">
		<?php settings_fields('larula_options'); ?>
		<?php do_settings_sections('larula'); ?>
		<input class="button-primary" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
</div>