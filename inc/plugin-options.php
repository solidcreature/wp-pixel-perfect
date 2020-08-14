<?php
//Regestering plugins options page
function pp_register_options_page() {
  add_options_page('WP Pixel Perfect', 'WP Pixel Perfect', 'manage_options', 'pp_options_page', 'pp_options_page');
}
add_action('admin_menu', 'pp_register_options_page');


//Creating form on pptions page
function pp_options_page() {
	echo '<div>';
	echo '<h1>WP Pixel Perfect</h1>';
	echo '<form action="options.php" method="post">';
	
	settings_fields('pp_settings_group'); 
	do_settings_sections('pp_options_page'); 
	submit_button();
	
	echo '</form>';
	echo '</div>';
} 


//Regestering set of seetings for a script
function pp_options_fields(){
	register_setting( 'pp_settings_group', 'wppp_src', '' );
	register_setting( 'pp_settings_group', 'wppp_opacity', '' );
	register_setting( 'pp_settings_group', 'wppp_step', '' );
	register_setting( 'pp_settings_group', 'wppp_top', '' );
	register_setting( 'pp_settings_group', 'wppp_left', '' );
	register_setting( 'pp_settings_group', 'wppp_right', '' );
	register_setting( 'pp_settings_group', 'wppp_zindex', '' );
	register_setting( 'pp_settings_group', 'wppp_clip', '' );
	register_setting( 'pp_settings_group', 'wppp_center', '' );
	register_setting( 'pp_settings_group', 'wppp_fixed', '' );
	register_setting( 'pp_settings_group', 'wppp_show', '' );
	register_setting( 'pp_settings_group', 'wppp_tag', '' );
	
	register_setting( 'pp_settings_group', 'wppp_acf_support', '' );
	register_setting( 'pp_settings_group', 'wppp_hide_for_visitors', '' );
	register_setting( 'pp_settings_group', 'wppp_disable_script', '' );
	
	$defaults = array(
		'src' => '',
		'opacity' => '0.7',
		'step' => 1,
		'top' => 0,
		'left' => 0,
		'right' => 0,
		'zindex' => 99,
		'clip' => 0,
		'center' => 1,
		'fixed' =>0,
		'show' =>1,
		'tag' => 'body'
	);
	
	add_settings_section('pp_section_main', __('Overlay settings','wp-pixel-perfect'), '', 'pp_options_page');
	

	add_settings_field('wppp_src', __('Overlay image','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main', ['wppp_src',$defaults['src'],110]);
	add_settings_field('wppp_opacity', __('Overlay opacity','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main',['wppp_opacity',$defaults['opacity'],5]);
	add_settings_field('wppp_step', __('Step moving overlay in px','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main',['wppp_step',$defaults['step'],5]);
	add_settings_field('wppp_top', __('Offset top in px','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main',['wppp_top',$defaults['top'],5]);
	add_settings_field('wppp_left', __('Offset left in px','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main',['wppp_left',$defaults['left'],5]);
	add_settings_field('wppp_right', __('Offset right in px','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main',['wppp_right',$defaults['right'],5]);
	add_settings_field('wppp_zindex', __('Z-index of overlay','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main',['wppp_zindex',$defaults['zindex'],5]);
	add_settings_field('wppp_clip', __('Keep Panel on screen','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main',['wppp_clip',$defaults['clip'],1]);
	add_settings_field('wppp_center', __('Image centered','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main',['wppp_center',$defaults['center'],1]);
	add_settings_field('wppp_fixed', __('Overlay position: fixed','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main',['wppp_fixed',$defaults['fixed'],1]);
	add_settings_field('wppp_show', __('Show overlay on page load','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main',['wppp_show',$defaults['show'],1]);
	add_settings_field('wppp_tag', __('Place to add','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_main',['wppp_tag',$defaults['tag'],5]);
	
	add_settings_section('pp_section_advanced', __('Advanced settings','wp-pixel-perfect'), '', 'pp_options_page');
	add_settings_field('wppp_acf_support', __('Enable ACF support','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_advanced',['wppp_acf_support',1,1]);
	add_settings_field('wppp_hide_for_visitors', __('Hide from visitors','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_advanced',['wppp_hide_for_visitors',1,1]);
	add_settings_field('wppp_disable_script', __('Show only with ACF','wp-pixel-perfect'), 'wppp_default_cb', 'pp_options_page', 'pp_section_advanced',['wppp_disable_script',0,1]);
}

add_action('admin_init', 'pp_options_fields');

//Functions that renders inpurts for each setting
//Yes, it isn't perfect and checlboxes with dropdowns will be better, but there is an ACF options with better interface
function wppp_default_cb($args) {
	//$args[0] - option name
	//$args[1] - default value
	//$args[2] - input width
	
	$options = get_option($args[0]);
	//If option is unset, will use defaukt value
	if ( $options == '' ) $options = $args[1]; 
	
	//Rendering input with option value
	echo "<input id='$args[0]' name='$args[0]' size='$args[2]' type='text' value='{$options}' />";
} 






