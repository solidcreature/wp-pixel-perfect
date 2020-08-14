<?php

function wppp_set_defaults($field) {
	global $post;
    $post_id = $post->ID;
	
	$field_name = $field['_name'];
	$option_value = get_option($field_name);
	
	if ( get_field($field_name, $post_id) == '' )  $field['value'] = $option_value;
	
	return $field;
}

function wppp_set_default_src($field) {
	global $post;
    $post_id = $post->ID;
	
	$field_name = $field['_name'];
	$option_value = get_option($field_name);
	
	if ( get_field($field_name, $post_id) == '' ) {
		$field['instructions'] = 'If empty <a href="' . $option_value . '" target="_blank">image</a> from plugin settings will be used';
	}
	
	return $field;
}


add_filter('acf/prepare_field/name=wppp_src', 'wppp_set_default_src');
add_filter('acf/prepare_field/name=wppp_top', 'wppp_set_defaults');
add_filter('acf/prepare_field/name=wppp_left', 'wppp_set_defaults');
add_filter('acf/prepare_field/name=wppp_right', 'wppp_set_defaults');
add_filter('acf/prepare_field/name=wppp_zindex', 'wppp_set_defaults');