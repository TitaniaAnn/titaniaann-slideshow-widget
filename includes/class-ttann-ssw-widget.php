<?php
/**
 * Creates the widget
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
class TTANN_SSW_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	function __construct() {
		parent::__construct(
			'trm_slideshow_widget', // Base ID
			__( 'Trillium Slideshow', 'text_domain' ), // Name
			array( 'description' => __( 'A slideshow widget with transitions for the trillium theme', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $wpdb;
		//$ttann-slideshow-db-name = $wpdb->prefix . 'ttann-slideshow-widget-slideshow'
		$ttann-image-db-name = $wpdb->prefix . 'ttann-slideshow-widget-image'

		$image_list = $wpdb->get_results( "SELECT id, slideshowid, imageid, size, caption FROM $ttann-image-db-name WHERE slideshowid = $instance['slideshow']" );
		?>
		<script type="text/javascript">
			JQuery("#ttann-slideshow-<?php echo $instance['slideshow']; ?>").cycle({
				fx: 		<?php echo $instance['effects']; ?>,
				speed:		<?php echo $instance['speed']; ?>,
				timeout:	<?php echo $instance['timeout']; ?>,
				random:		<?php echo $instance['random']; ?>,
			<?php
			if ( $instance['loader'] ) {
				?>
				loader:     true, 
				<?php
			} else {
				?>
				loader:     "wait",
				<?php
			}
			?> 
			});
		</script>
		<?php
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', '#slideshow' ). $args['after_title'];
		}
		?>
		<div id="ttann-slideshow-<?php echo $instance['slideshow']; ?>">
		<?php
		if ( $instance['caption'] ) {
			?>
			<div class="cycle-overlay"></div>
			<?php
		}
		if ( ! empty( $image_list ) ) {
			foreach ( $image_list as $image ) {
				$caption = $image->caption;
				$alt = get_post_meta($image->imageid, '_wp_attachment_image_alt', true);
				$url = wp_get_attachment_image_src($image->imageid, $image->size)[0];
				?>
				<img src="<?php echo $url; ?>" alt="<?php echo $alt; ?>" data-cycle-title="<?php echo $caption; ?>" style="display: none" />
				<?php
			}
		}
		?>
		</div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		global $wpdb;
		$ttann-slideshow-db-name = $wpdb->prefix . 'ttann-slideshow-widget-slideshow'

		$effects_list = array('fade', 'fadeout', 'flip', 'scrollHorz', 'scrollVert');
		$slideshow_list = $wpdb->get_results( "SELECT id, name FROM '$ttann-slideshow-db-name'" );

		$title = esc_attr( isset( $instance['title'] ) ? $instance['title'] : '' );
		$slideshow = esc_attr( isset( $instance['slideshow'] ) ? $instance['slideshow'] : '' );
		$speed = esc_attr( isset( $instance['speed'] ) ? $instance['speed'] : '500' );
		$timeout = esc_attr( isset( $instance['timeout'] ) ? $instance['timeout'] : '4000' );
		$loader = isset( $instance['loader'] ) ? (bool) $instance['loader'] : true;
		$random = isset( $instance['random'] ) ? (bool) $instance['random'] : true;
		$caption = isset( $instance['caption'] ) ? (bool) $instance['caption'] : false;
		$effects = isset( $instance['effects'] ) ? $instance['effects'] : '';
		$effects_array = explode( ",", str_replace( '\'', '', $effects) );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<? echo esc_attr( $title ); ?>" />
		</p>		
		<div>
			<p>Slideshow</p>
			<?php
			if ( ! empty( $slideshow_list ) ) {
				?>
				<select name="slideshow">
				<?php
					foreach ( $slideshow_list as $slist) {
						?>
						<option value="<?php echo $slist->id; ?>"><?php echo $slist->name; ?></option>
						<?php
					}
				?>
				</select>
				<?php
			} else {
				echo "link to settings page";
			}
			?>

			<script type="text/javascript">
				function isNumber(evt) {
				    evt = (evt) ? evt : window.event;
				    var charCode = (evt.which) ? evt.which : evt.keyCode;
				    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				        return false;
				    }
				    return true;
				}
			</script>
			<p>Options</p>
			<ul style="-moz-column-count: 2; -moz-column-gap: 5px; -webkit-column-count: 2; -webkit-column-gap: 5px; column-count: 2; column-gap: 5px;">
			<li>
			<label for="<?php echo $this->get_field_id( 'speed' ); ?>"><?php _e( 'Speed:' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'speed' ); ?>" name="<?php echo $this->get_field_name( 'speed' ); ?>" onkeypress="return isNumber(event)" value="<?php echo esc_attr( $speed ); ?>" />
			</li>
			<li>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'loader' ); ?>" name="<?php echo $this->get_field_name( 'loader' ); ?>"  <?php checked( $loader ); ?> />
				<label for="<?php echo $this->get_field_id( 'loader' ); ?>"><?php _e( 'Use the loader to show first available image' ); ?></label>
			</li>
			<li>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'caption' ); ?>" name="<?php echo $this->get_field_name( 'caption' ); ?>"  <?php checked( $caption ); ?> />
				<label for="<?php echo $this->get_field_id( 'caption' ); ?>"><?php _e( 'Show image captions' ); ?></label>
			</li>
			<li>
			<label for="<?php echo $this->get_field_id( 'timeout' ); ?>"><?php _e( 'Timeout:' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'timeout' ); ?>" name="<?php echo $this->get_field_name( 'timeout' ); ?>" onkeypress="return isNumber(event)" value="<?php echo esc_attr( $timeout ); ?>" />
			</li>
			<li>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>"  <?php checked( $random); ?> />
				<label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e( 'Random Image Order:' ); ?></label>
			</li>
			</ul>
			<p>Effects</p>
			<ul style="-moz-column-count: 2; -moz-column-gap: 5px; -webkit-column-count: 2; -webkit-column-gap: 5px; column-count: 2; column-gap: 5px;">
			<?php
			foreach ( $effects_list as $effect ) {
				?>
				<li>
					<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( $effect ); ?>" name="<?php echo $this->get_field_name( $effect ); ?>"  <?php checked( isset( $effects_array ) ? in_array( $effect, $effects_array ) : false ); ?> />
					<label for="<?php echo $this->get_field_id( $effect ); ?>"><?php _e( $effect ); ?></label>
				</li>
				<?php
			}
			?>
			</ul>
			<ul>

			</ul>
		</div>
		<?php

	}


}