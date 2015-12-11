<?php
/**
 * 
 * 
 */



/**
 * Add Plugins scripts and styles
 */
 function ttann_ssw_scripts() {
 	wp_enqueue_script(
 		'jquery-cycle2-core',
 		plugins_url( 'js/jquery.cycle2.core.min.js', __FILE__ ),
 		array( 'jquery' )
	);
	wp_enqueue_script(
 		'jquery-cycle2-caption',
 		plugins_url( 'js/jquery.cycle2.caption.min.js', __FILE__ ),
 		array( 'jquery',  'jquery-cycle2-core')
	);
	wp_enqueue_script(
 		'jquery-cycle2-loader',
 		plugins_url( 'js/jquery.cycle2.loader.min.js', __FILE__ ),
 		array( 'jquery',  'jquery-cycle2-core')
	);
	wp_enqueue_script(
 		'jquery-cycle2-flip',
 		plugins_url( 'js/jquery.cycle2.flip.min.js', __FILE__ ),
 		array( 'jquery',  'jquery-cycle2-core')
	);
	wp_enqueue_script(
 		'jquery-cycle2-tmpl',
 		plugins_url( 'js/jquery.cycle2.tmpl.min.js', __FILE__ ),
 		array( 'jquery',  'jquery-cycle2-core')
	);
	wp_enqueue_script(
 		'jquery-cycle2-scrollVert',
 		plugins_url( 'js/jquery.cycle2.scrollVert.min.js', __FILE__ ),
 		array( 'jquery',  'jquery-cycle2-core')
	);

 }

 add_action( 'wp_enqueue_scripts', 'ttann_ssw_scripts' );