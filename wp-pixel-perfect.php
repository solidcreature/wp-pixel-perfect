<?php
/*
Plugin Name: WP Pixel Perfect
Plugin URI: http://github.com/solidcreature/pixel-perfect
Description: Helps achieve pixel-perfect layout on the front-end. Based on Pixlayout js-script by Artem Karabut, http://pixlayout.polycreative.ru
Version: 0.1
Author: Nikolay Mironov
Author URI: wpfolio.ru
Text Domain: wp-pixel-perfect
Domain Path: /languages
*/


define( 'PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );

//Plugin Options page
include PLUGIN_DIR . '/inc/plugin-options.php';

//Integration with ACF plugin
include PLUGIN_DIR . '/inc/acf-groups.php';
include PLUGIN_DIR . '/inc/acf-related.php';


//Regestering JS, that shows Overlay on front-end
function pixlayout_scripts() {
	wp_enqueue_script('wp-pixlayout', PLUGIN_URL . 'inc/pixlayout/pixlayout.js', array('jquery'));
	wp_enqueue_style('wp-pixlayout-css', PLUGIN_URL . 'inc/pixlayout/pixlayout.css', array());
}

add_action( 'wp_enqueue_scripts', 'pixlayout_scripts' );


//Show panel +overlay on front-end
function pp_show_panel(){

	//Check hide or show panel
	$show_panel = true;
	$acf_overwrite = false;
	if ( get_option('wppp_hide_for_visitors') ) $show_panel = false;
	if ( is_user_logged_in() ) $show_panel = true;
	if ( get_option('wppp_disable_script') ) $show_panel = false;
	
	
	//Not a best construction, but it allows to disable script on the site except certain pages with respect to wppp_hide_for_visitors setting
	if ( function_exists('acf_add_local_field_group') ) {
		if ( get_field('wppp_acf_overwrite') ) {
			$acf_overwrite = true;
			$show_panel = true;
			if ( get_option('wppp_hide_for_visitors') ) $show_panel = false;
			if ( is_user_logged_in() ) $show_panel = true;		
		}
	}
	
	
	if ($show_panel) {

		if ( $acf_overwrite ) {
			$src = get_field('wppp_src');
			$opacity = get_field('wppp_opacity');
			$top = get_field('wppp_top');
			$left = get_field('wppp_left');
			$right = get_field('wppp_right');
			$center = get_field('wppp_center'); if ($center == 1) { $center = 'true'; } else { $center = 'false'; }
			$clip = get_field('wppp_clip'); if ($clip == 1) { $clip = 'true'; } else { $clip = 'false'; }
			$fixed = get_field('wppp_fixed'); if ($fixed == 1) { $fixed = 'true'; } else { $fixed = 'false'; }
			$show = get_field('wppp_show'); if ($show == 1) { $show = 'true'; } else { $show = 'false'; }
			$tag = get_field('wppp_tag');		
		} else {
			$src = get_option('wppp_src');
			$opacity = get_option('wppp_opacity');
			$top = get_option('wppp_top');
			$left = get_option('wppp_left');
			$right = get_option('wppp_right');
			$center = get_option('wppp_center'); if ($center == 1) { $center = 'true'; } else { $center = 'false'; }
			$clip = get_option('wppp_clip'); if ($clip == 1) { $clip = 'true'; } else { $clip = 'false'; }
			$fixed = get_option('wppp_fixed'); if ($fixed == 1) { $fixed = 'true'; } else { $fixed = 'false'; }
			$show = get_option('wppp_show'); if ($show == 1) { $show = 'true'; } else { $show = 'false'; }
			$tag = get_option('wppp_tag');
		}	

		echo "
		<script>
		jQuery(function(){
		jQuery.pixlayout({
			src: '$src',
			opacity: '$opacity',
			top: $top,
			left: $left,
			center: $center,
			clip: $clip,
			fixed: $fixed,
			show: $show
		}, '$tag');
		});</script>";
	}	
}

add_action( 'get_footer', 'pp_show_panel' );




