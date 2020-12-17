<?php

/**
 * @author ajith_rn
 * @copyright 2019
 */

if (!defined('ABSPATH')) die();

/* -------------------------------------------------------------------------- */
/*                      enqueue custom scripts and styles                      */
/* -------------------------------------------------------------------------- */

function dc_enqueue_parent() { 
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css',false, false ); 
	wp_enqueue_style( 'dc-custom-style', get_stylesheet_directory_uri() . '/assets/css/custom.css', false, false);
}

function dc_enqueue_scripts() {
	wp_enqueue_script( 'dc-custom-script', get_stylesheet_directory_uri() . '/assets/scripts/script.js', array( 'jquery' ), false, true );
}

add_action( 'wp_enqueue_scripts', 'dc_enqueue_parent' );
add_action( 'wp_enqueue_scripts', 'dc_enqueue_scripts' );

/* -------------------------------------------------------------------------- */
/*           include divi lazy load for slider and silder bg images           */
/* -------------------------------------------------------------------------- */

require_once dirname(__FILE__) . '/includes/divi_layzyload.php';


/* -------------------------------------------------------------------------- */
/*                             custom panel edits                             */
/* -------------------------------------------------------------------------- */

if ( ! function_exists( 'et_load_core_options' ) ) {
    
    function et_load_core_options() {
        $options = require_once( get_stylesheet_directory() . esc_attr( "/panel_options.php" ) );
    }
    add_action( 'init', 'et_load_core_options', 999 );
    
}

/* -------------------------------------------------------------------------- */
/*                          custom social media icons                          */
/* -------------------------------------------------------------------------- */
if ( ! function_exists( 'et_get_safe_localization' ) ) {
    
    function et_get_safe_localization( $string ) {
    	return wp_kses( $string, et_get_allowed_localization_html_elements() );
    }    
}

/* -------------------------------------------------------------------------- */
/*                           enable shortcode module                          */
/* -------------------------------------------------------------------------- */
function showmodule_shortcode($moduleid) {
	extract(shortcode_atts(array('id' =>'*'),$moduleid)); 
	return do_shortcode('[et_pb_section global_module="'.$id.'"][/et_pb_section]');
}
add_shortcode('showmodule', 'showmodule_shortcode');

/* -------------------------------------------------------------------------- */
/*                             remove unwanted css                            */
/* -------------------------------------------------------------------------- */
add_action( 'wp_print_styles',     'adv_deregister_styles', 100 );
function adv_deregister_styles()    { 
	if( !is_user_logged_in() ) {
		wp_deregister_style( 'dashicons' ); 
	}
}
?>