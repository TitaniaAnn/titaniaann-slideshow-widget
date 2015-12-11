<?php
/**
 * Fired during plugin activation
 *
 * @link       	http://cynthiabrown.me
 * @since 		1.0.0
 *
 * @package    titaniaann-slideshow-widget
 * @subpackage titaniaann-slideshow-widget/includes
 */
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    titaniaann-slideshow-widget
 * @subpackage titaniaann-slideshow-widget/includes
 * @author     Cynthia Brown <cynthia@cynthiabrown.me>
 */
class TTANN_SSW_Activator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		ttann_create_database();
	}

	/**
	 * Adds the database table if does not exist.
	 *
	 */
	private function ttann_create_database() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		/**
		 * Slideshow table
		 * id 
		 * name
		 * settings
		 */
		$ttann-slideshow-db-name = $wpdb->prefix . 'ttann-slideshow-widget-slideshow';

		if ( $wpdb->get_var( "show tables like '$ttann-slideshow-db-name'" ) != $ttann-slideshow-db-name ) {
			$sql = "CREATE TABLE $ttann-slideshow-db-name (
						'id' mediumint(9) NOT NULL AUTO_INCREMENT,
						'name' tinytext NOT NULL,
						UNIQUE KEY 'id' (id)
					) $charset_collate;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}

		/**
		 * Image table
		 * id
		 * slideshowid
		 * imageid
		 * size
		 * alttext
		 */
		$ttann-image-db-name = $wpdb->prefix . 'ttann-slideshow-widget-images';

		if ( $wpdb->get_var( "show tables like '$ttann-image-db-name'" ) != $ttann-image-db-name ) {
			$sql = "CREATE TABLE $ttann-image-db-name (
						'id' mediumint(9) NOT NULL AUTO_INCREMENT,
						'slideshowid' mediumint(9) NOT NULL,
						'imageid' mediumint(9) NOT NULL,
						'size' tinytext,
						'caption' text,
						UNIQUE KEY 'id' (id)
					) $charset_collate;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}
}