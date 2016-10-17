<?php
/**
 * Genesis Simple Footer Widgets
 *
 * @package     JD_Genesis_Simple_Footer_Widgets
 * @since       1.0.2
 * @author      Joe Dooley <hello@developingdesigns.com>
 * @link        https://github.com/joedooley/genesis-simple-footer-widgets
 * @license     GNU General Public License 2.0+
 * @copyright   2015 Joe Dooley, Developing Designs
 */

namespace JD_Genesis_Simple_Footer_Widgets;

use JD_Genesis_Simple_Footer_Widgets\Admin\Metabox;

// Oh no you don't. Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheatin&#8217; uh?' );
}

class Genesis_Simple_Footer_Widgets {

	/**
	 * Number of footer widgets
	 *
	 * @var int
	 */
	protected $number_of_footer_widgets = 3;

	/**
	 * The plugin's version
	 *
	 * @var string
	 */
	const VERSION = '1.1';

	/**
	 * The plugin's minimum WordPress requirement
	 *
	 * @var string
	 */
	const MIN_WP_VERSION = '3.5';

	/**
	 * Configuration parameters
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * Plugin's dir path
	 *
	 * @var string
	 */
	protected $plugin_dir = '';

	/**
	 * Plugin's URL path
	 *
	 * @var string
	 */
	protected $plugin_url = '';

	/**
	 * Instance of Metabox
	 *
	 * @var
	 */
	protected $metabox;

	/*************************
	 * Getters
	 ************************/

	public function version() {
		return self::VERSION;
	}

	public function min_wp_version() {
		return self::MIN_WP_VERSION;
	}

	/****************************
	 * Instantiate & Initialize
	 ***************************/

	/**
	 * Instantiate the plugin
	 *
	 * @since 1.0.2
	 *
	 * @param array  $config     Configuration parameters
	 * @param string $plugin_dir Plugin directory
	 * @param array  $defaults   Default configuration parameters
	 */
	public function __construct( array $config, $plugin_dir, array $defaults ) {
		$this->init_properties( $config, $plugin_dir, $defaults );
		$this->init_hooks();
	}

	/**
	 * Initialize the plugin's properties
	 *
	 * @since 1.0.2
	 *
	 * @param array     $config         Configuration parameters
	 * @param string    $plugin_dir     Plugin dir
	 * @param array     $defaults       Default configuration parameters
	 */
	protected function init_properties( array $config, $plugin_dir, array $defaults ) {
		$this->config = wp_parse_args( $config, $defaults );
		$this->plugin_dir = $plugin_dir;

		$this->plugin_url = plugin_dir_url( __FILE__ );
		if ( is_ssl() ) {
			$this->plugin_url = str_replace( 'http://', 'https://', $this->plugin_url );
		}

		$this->number_of_footer_widgets = (int) genesis_get_option( 'footer_widgets' );
		$this->number_of_footer_widgets = $this->number_of_footer_widgets > -1 ? $this->number_of_footer_widgets : 3;
	}

	/**
	 * Initialize hooks
	 *
	 * @since 1.0.2
	 */
	protected function init_hooks() {

		add_action( 'after_setup_theme',                array( $this, 'add_theme_support' ), 9 );

		if ( $this->number_of_footer_widgets > 0 ) {
			add_filter( 'genesis_attr_footer-widgets',  array( $this, 'footer_widgets_attr' ) );
		}

		add_action( 'wp_enqueue_scripts',               array( $this, 'enqueue' ) );
		add_filter( 'genesis_theme_settings_defaults',  array( $this, 'set_defaults' ) );
		add_action( 'genesis_settings_sanitizer_init',  array( $this, 'sanitize' ) );
		add_action( 'admin_init',                       array( $this, 'init_admin' ) );
	}

	/*****************************
	 * Public Methods & Callbacks
	 ****************************/

	/**
	 * Initialize the Metabox in the admin area
	 *
	 * @since 1.0.2
	 */
	public function init_admin() {
		include $this->plugin_dir . 'lib/admin/class-metabox.php';

		$this->metabox = new Metabox( $this->config );
	}

	/**
	 * Add theme support for the footer widgets
	 *
	 * Note: We hook into after_setup_theme before Genesis calls genesis_register_footer_widget_areas()
	 * to ensure we are overriding the Child theme's setting for footer widgets
	 *
	 * @since 1.0.2
	 */
	public function add_theme_support() {
		add_theme_support( 'genesis-footer-widgets', $this->number_of_footer_widgets );
	}

	/**
	 * Register the styles
	 *
	 * @since 1.0.2
	 */
	public function enqueue() {
		wp_enqueue_style(
			'gsfw-stylesheet',
			$this->plugin_url . 'css/style.min.css',
			false,
			self::VERSION
		);
	}

	/**
	 * Register Defaults
	 *
	 * @author Bill Erickson
	 * @link http://www.billerickson.net/genesis-theme-options/
	 *
	 * @param array     $defaults
	 * @return array    modified defaults
	 */
	public function set_defaults( $defaults ) {
		$defaults['footer_widgets'] = '3';

		return $defaults;
	}

	/**
	 * Add css class attributes
	 *
	 * @since 1.0.2
	 *
	 * @param array     $attributes
	 * @return array
	 */
	public function footer_widgets_attr( $attributes ) {
		$attributes['class'] .= ' gsfw-footer-widgets-' . genesis_get_option( 'footer_widgets' );

		return $attributes;
	}

	/**
	 * Sanitization
	 *
	 * Register our new option values with the no_html sanitization type defined within Genesis.
	 *
	 * @author Bill Erickson
	 * @link http://www.billerickson.net/genesis-theme-options/
	 *
	 */
	public function sanitize() {
		genesis_add_option_filter(
			'no_html',
			GENESIS_SETTINGS_FIELD,
			[
				'footer_widgets',
			]
		);
	}
}
