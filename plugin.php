<?php
/**
 * Plugin Name:  Genesis Simple Footer Widgets
 * Plugin URI:   https://github.com/joedooley/genesis-simple-footer-widgets
 * Description:  A simple way to change how many footer widgets your site uses. Easily go
 *               from four widgets to three or three to six from a dropdown in Genesis Theme Settings.
 * Author:       Joe Dooley
 * Author URI:   http://www.developingdesigns.com/
 * Version:      1.2
 * Text Domain:  genesis-simple-footer-widgets
 * Domain Path:  languages
 * Requires PHP: 5.4
 *
 * Genesis Simple Footer Widgets is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Genesis Simple Footer Widgets is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Genesis Title Toggle. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    JD_Genesis_Simple_Footer_Widgets
 * @author     Joe Dooley <hello@developingdesigns.com>
 * @license    GPL-2.0+
 * @copyright  2015 Joe Dooley, Developing Designs
 */

namespace JD_Genesis_Simple_Footer_Widgets;

/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}



add_action( 'init', __NAMESPACE__ . '\load_textdomain' );
/**
 * Loads plugins translated strings. Were loading load_plugin_textdomain()
 * on 'init' hook.
 *
 * @since 1.2
 */
function load_textdomain() {
	load_plugin_textdomain( 'genesis-simple-footer-widgets', false, basename( dirname( __DIR__ ) ) . '/languages/' );
}


add_action( 'admin_notices', __NAMESPACE__ . '\genesis_check' );
/**
 * Display admin notice if Genesis isn't installed or 'PHP version < 5.4'.
 *
 * @since 1.2
 */
function genesis_check() {
	if ( 'genesis' !== basename( TEMPLATEPATH ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die( __( 'Sorry, Genesis Simple Footer Widgets needs the Genesis theme to be activated in order to function properly. Please install Genesis and activate the theme.', 'genesis-simple-footer-widgets' ) );
	}
}



add_action( 'admin_notices', __NAMESPACE__ . '\min_php_check' );
/**
 * Do not activate plugin if PHP < 5.4
 *
 * @param $version int PHP version
 * @since 1.2
 */
function min_php_check( $version ) {
	$min_php_version = 5.4;

	if ( version_compare( $min_php_version, $version, '<' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die( sprintf( __( 'Sorry, Genesis Simple Footer Widgets requires PHP version %1$d or greater to function properly. You have PHP version %2$d. Please contact your hosting provider for assistance.', 'genesis-simple-footer-widgets' ) ) );
	}
}



add_action( 'genesis_setup', __NAMESPACE__ . '\launch', 20 );
/**
 * Launch this plugin once Genesis fires up
 *
 * @since 1.0.2
 */
function launch() {

	$path = plugin_dir_path( __FILE__ );
	require_once $path . 'class-plugin.php';

	$defaults = [
		'views'         => [
			'metabox'   => $path . 'lib/views/settings-box.php',
		],
		'default_number_of_widgets' => 3,
	];

	$config = apply_filters( 'gsfw_configuration_parameters', $defaults );

	new Genesis_Simple_Footer_Widgets( $config, $path, $defaults );
}
