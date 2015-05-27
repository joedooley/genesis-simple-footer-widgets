<?php namespace JD_Genesis_Simple_Footer_Widgets\Admin;

/**
 * Genesis Simple Footer Widgets
 *
 * @package     JD_Genesis_Simple_Footer_Widgets
 * @since       1.0.2
 * @author      Joe Dooley
 * @link        http://www.developingdesigns.com/author/joe-dooley/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 Joe Dooley
 */

class Metabox {

	protected $config = array();

	/****************************
	 * Instantiate & Initialize
	 ***************************/

	/**
	 * Instantiate the plugin
	 *
	 * @since 1.0.2
	 *
	 * @param array     $config         Configuration parameters
	 * @return self
	 */
	public function __construct( array $config ) {
		$this->config = $config;
		$this->init_hooks();
	}

	/**
	 * Initialize the plugin's properties
	 *
	 * @since 1.0.2
	 *
	 * @return null
	 */
	protected function init_hooks() {
		add_action( 'genesis_theme_settings_metaboxes', array( $this, 'register_settings_box' ) );
	}

	/*****************************
	 * Public Methods & Callbacks
	 ****************************/

	/**
	 * Register additional metaboxes to Genesis > Theme Settings
	 * @author Bill Erickson
	 * @link http://www.billerickson.net/genesis-theme-options/
	 *
	 * @param string    $pagehook      $_genesis_theme_settings_pagehook
	 * @return null
	 */
	public function register_settings_box( $pagehook ) {
		add_meta_box(
			'jd-gsfw-settings',
			'Footer Widgets',
			array( $this, 'render_metabox' ),
			$pagehook,
			'main',
			'high'
		);
	}

	/**
	 * Render the Metabox
	 *
	 * @since 1.0.2
	 *
	 * @author Bill Erickson
	 * @link http://www.billerickson.net/genesis-theme-options/
	 * @return null
	 */
	public function render_metabox() {
		$number_of_widgets = genesis_get_option( 'footer_widgets' );
		$number_of_widgets = is_numeric( $number_of_widgets ) ? intval( $number_of_widgets ) : 0;

		if ( is_readable( $this->config['views']['metabox'] ) ) {
			include( $this->config['views']['metabox'] );
		}
	}
}