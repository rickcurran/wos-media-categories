<?php
/*
Plugin Name: WOS Media Categories
Plugin URI: http://suburbia.org.uk/page/projects.html#wos_media_categories
Description: Enables Management of Categories for Media / Attachments.
Version: 1.0.1
Author: Rick Curran
Author URI: http://suburbia.org.uk
*/

add_action('admin_init', 'reg_tax'); // Enable the Category field for Attachments, this is then hidden via CSS, category values are entered into it via Javascript
function reg_tax() {
   register_taxonomy_for_object_type('category', 'attachment');
   add_post_type_support('attachment', 'category');
}

add_action('admin_menu', 'wos_media_categories_parent');
function wos_media_categories_parent() {  
	add_options_page('WOS Media Categories', 'WOS Media Categories', 'manage_options', 'wos-media-categories', 'wos_media_categories_parent_page');
	//call register settings function
	add_action('admin_init', 'register_wos_media_categories_parent_settings');
}
// Display WOS Media Categories editing page
function wos_media_categories_parent_page() {
	if (!current_user_can('manage_options'))  {
    	wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	include('wos-mc-options.php');
}
function register_wos_media_categories_parent_settings() {
	//register our settings
	register_setting('wos-media-categories-group', 'wos_media_categories_options');
}




// THIS NEEDS TO BE CONFIGURABLE IN WP ADMIN!!!
function getParentCat() { // Sets optional parent category
	$parent_cat = get_option('wos_media_categories_options');
	return $parent_cat['wos_parent_id'];
	//$parent_cat = '21';
	//return $parent_cat;
}


function wos_media_categories($args) {
		$pc = getParentCat();
		//echo $pc;
        $cat_test = get_post($_GET['attachment_id'])->post_category;
		//$categories = get_categories('hide_empty=0'); // Get all available Categories
		$categories = get_categories('child_of='.$pc.'&hide_empty=0'); // Get all available Categories
		$post_categories = wp_get_post_categories($_GET['attachment_id']); // Get this posts' Categories
		
		$all_cats .= '<ul id="wos-media-categories-list" style="width:500px;">'; 
		
		foreach ($categories as $category) {
			if (in_array($category->term_id, $post_categories)) {
				$chk = ' checked="checked"';
			} else {
				$chk = '';	
			}
			$option = '<li style="width:240px;float:left;"><input type="checkbox" class="wos-categories-cb" value="'.$category->category_nicename.'" id="'.$category->category_nicename.'" name="'.$category->category_nicename.'"'.$chk.'> ';
			$option .= '<label for="'.$category->category_nicename.'">'.$category->cat_name.'</label>';
			$option .= '</li>';
			$all_cats .= $option;
		}
		$all_cats .= '</ul>';
		
        // Format Category fields on page
        $categories = array('all_categories' => array (
                'label' => __('Category'),
                'input' => 'html',
                'html' => $all_cats
        ));

        return array_merge($args, $categories);
}

add_filter('attachment_fields_to_edit', 'wos_media_categories', 5);

if (is_admin()) { // Only load if in the admin area
	$jsfile = '/wos-media-categories/wos-media-categories.js';
	$cssfile = '/wos-media-categories/wos-media-categories.css';
	if (file_exists(WP_PLUGIN_DIR.$jsfile)) {
		wp_register_script('wos_mediacategories_js', WP_PLUGIN_URL.$jsfile);
		wp_enqueue_script('wos_mediacategories_js');
	}
	if (file_exists(WP_PLUGIN_DIR.$cssfile)) {
		wp_register_style('wos_mediacategories_css', WP_PLUGIN_URL.$cssfile);
		wp_enqueue_style( 'wos_mediacategories_css');
	}
}

?>