<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/achatainga
 * @since      1.0.0
 *
 * @package    Wpgraphql_Elementor
 * @subpackage Wpgraphql_Elementor/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wpgraphql_Elementor
 * @subpackage Wpgraphql_Elementor/includes
 * @author     Alejandro Chataing <a.chataing.a@gmail.com>
 */
class Wpgraphql_Elementor_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wpgraphql-elementor',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
