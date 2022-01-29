<?php
/**
 * Plugin Name:       WPABL Import
 * Plugin URI:        https://timmermarketing.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Jahur Ahmed
 * Author URI:        https://timmermarketing.com
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpabl_import
 * Domain Path:       includes/languages
 * GitHub Plugin URI: jahur/wpabl_import
 */

// If this file is called directly, abort. test this
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WPABL_IMPORT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpabl_import-activator.php
 */
function activate_wpabl_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpabl_import-activator.php';
	Wpabl_import_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpabl_import-deactivator.php
 */
function deactivate_wpabl_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpabl_import-deactivator.php';
	Wpabl_import_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpabl_import' );
register_deactivation_hook( __FILE__, 'deactivate_wpabl_import' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpabl_import.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpabl_import() {

	$plugin = new Wpabl_import();
	$plugin->run();

}
run_wpabl_import();
