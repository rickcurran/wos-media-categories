<div class="wrap">
<h2>WOS Media Categories</h2>
<p>WOS Media Categories enables the selection of Categories when editing media in the Media Library.</p>
<p>If you wish to restrict available categories to only children of a particular Parent category then enter the ID of the parent category in the field below.</p>
<form method="post" action="options.php">
<?php
	settings_fields('wos-media-categories-group');
	$options = get_option('wos_media_categories_options');
	echo '<table class="form-table">';
	echo '<tr valign="top">';
	echo '<th scope="row">Parent Category ID: ';
	echo '<input type="text" name="wos_media_categories_options[wos_parent_id]" value="'.$options['wos_parent_id'].'" />';
	echo '</th>';
	echo '</tr>';		
	echo '</table>';
?>
<p><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
</form>
</div>