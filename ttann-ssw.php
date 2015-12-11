<?php
/**
 * Plugin Name: Slideshow Widget
 * Plugin URI:	http://titaniaann.github.io/titaniaann-slideshow-widget/
 * Description: A custom slideshow widget plugin with the ability create image collections.
 * Version:		1.0.0
 * Author:		Cynthia Brown
 * Author URI:	http://cynthiabrown.me
 * License:		GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * 
 * @link 		http://cynthiabrown.me
 * @since 		1.0.0
 * @package 	titaniaann-slideshow-widget
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die('-1');
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_ttann_slideshow_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ttann-ssw-activator.php';
	TTANN_SSW_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_ttann_slideshow_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ttann-ssw-deactivator.php';
	TTANN_SSW_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ttann_slideshow_widget' );
register_deactivation_hook( __FILE__, 'deactivate_ttann_slideshow_widget' );