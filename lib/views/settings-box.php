<p>
	<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[footer_widgets]"><?php _e( 'Footer Widgets:', 'genesis' ); ?></label>
	<select name="<?php echo GENESIS_SETTINGS_FIELD; ?>[footer_widgets]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[footer_widgets]">
		<?php for( $i = 0; $i <= 6; $i++ ) : ?>
			<option value="<?php echo $i; ?>"<?php selected( $i, $number_of_widgets ); ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>
</p>
<em>Select how many footer widgets you want. <a href="/wp-admin/widgets.php" title="Go to Widgets" target="blank">Go to Widgets.</a></em>
