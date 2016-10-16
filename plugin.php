<?php
/**
 * Plugin Name: Genesis Simple Footer Widgets
 * Plugin URI:  https://github.com/joedooley/genesis-simple-footer-widgets
 * Description: A simple way to change how many footer widgets your site uses. Easily go
 * from four widgets to three or three to six from a dropdown in Genesis Theme Settings.
 * Author:      Joe Dooley
 * Author URI:  http://www.developingdesigns.com/
 * Version:     1.1
 * Text Domain: genesis-simple-footer-widgets
 * Domain Path: languages
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
 * @copyright   2015 Joe Dooley, Developing Designs
 */

namespace JD_Genesis_Simple_Footer_Widgets;

/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'genesis_setup', __NAMESPACE__ . '\\launch', 20 );
/**
 * Launch this plugin once Genesis fires up
 *
 * @since 1.0.2
 *
 * @return null
 */
function launch() {
	$path = plugin_dir_path( __FILE__ );
	require_once $path . 'class-plugin.php';

	$defaults = array(
		'views'         => array(
			'metabox'   => $path . 'lib/views/settings-box.php',
		),
		'default_number_of_widgets' => 3,
	);

	$config = apply_filters( 'gsfw_configuration_parameters', $defaults );

	new Genesis_Simple_Footer_Widgets( $config, $path, $defaults );
}
