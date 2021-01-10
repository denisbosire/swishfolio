<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://thepixeltribe.com
 * @since             1.0.0
 * @package           Pro_Portfolio
 *
 * @wordpress-plugin
 * Plugin Name:       SwishFolio
 * Plugin URI:        https://portfolio.thepixeltribe.com
 * Description:       This plugin adds galleries, portfolio CPT & custom homepage for all our portfolio themes
 * Version:           1.0.0
 * Author:            Fortisthemes
 * Author URI:        https://thepixeltribe.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       swishfolio
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRO_PORTFOLIO', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pro-portfolio-activator.php
 */
function activate_pro_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pro-portfolio-activator.php';
	Pro_Portfolio_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pro-portfolio-deactivator.php
 */
function deactivate_pro_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pro-portfolio-deactivator.php';
	Pro_Portfolio_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pro_portfolio' );
register_deactivation_hook( __FILE__, 'deactivate_pro_portfolio' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pro-portfolio.php';

if ( file_exists( plugin_dir_path( __FILE__ ) . 'includes/libraries/cmb2/init.php' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/libraries/cmb2/init.php';
} elseif ( file_exists( plugin_dir_path( __FILE__ ) . 'includes/libraries/CMB2/init.php' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/libraries/CMB2/init.php';
}

require plugin_dir_path( __FILE__ ) . 'templates/portfolio-templates.php';

require plugin_dir_path( __FILE__ ) . 'templates/page-templates.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pro_portfolio() {

	$plugin = new Pro_Portfolio();
	$plugin->run();

}
run_pro_portfolio();
