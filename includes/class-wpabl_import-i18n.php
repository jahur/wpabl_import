<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://timmermarketing.com
 * @since      1.0.0
 *
 * @package    Wpabl_import
 * @subpackage Wpabl_import/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wpabl_import
 * @subpackage Wpabl_import/includes
 * @author     Jahur Ahmed <jahur@timmermarketing.com>
 */
class Wpabl_import_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wpabl_import',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . 'includes/languages/'
		);

	}



}
