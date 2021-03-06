<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/achatainga
 * @since             1.0.0
 * @package           Wpgraphql_Elementor
 *
 * @wordpress-plugin
 * Plugin Name:       WPGraphQL Elementor
 * Plugin URI:        https://github.com/achatainga/wpgraphql-elementor
 * Description:       Expose Elementor css to wpgraphql.
 * Version:           1.0.0
 * Author:            Alejandro Chataing
 * Author URI:        https://github.com/achatainga
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpgraphql-elementor
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
define( 'WPGRAPHQL_ELEMENTOR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpgraphql-elementor-activator.php
 */
function activate_wpgraphql_elementor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpgraphql-elementor-activator.php';
	Wpgraphql_Elementor_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpgraphql-elementor-deactivator.php
 */
function deactivate_wpgraphql_elementor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpgraphql-elementor-deactivator.php';
	Wpgraphql_Elementor_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpgraphql_elementor' );
register_deactivation_hook( __FILE__, 'deactivate_wpgraphql_elementor' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpgraphql-elementor.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpgraphql_elementor() {

	$plugin = new Wpgraphql_Elementor();
	$plugin->run();

}
run_wpgraphql_elementor();

require_once plugin_dir_path( __FILE__ ) . 'includes/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'beautiful_elementor_timeline_widget_register_required_plugins' );
function beautiful_elementor_timeline_widget_register_required_plugins() {
	$plugins = array(
		array(
			'name'        	=> 'Elementor',
			'slug'			=> 'elementor',
			'required'		=> true
		),

	);
	$config = array(
		'id'           => 'beautiful_elementor_timeline_widget',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'beautiful-elementor-timeline-widget-required-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

add_action( 'graphql_register_types', function() {
	global $wp_scripts;
	global $wp_styles;

	register_graphql_field( 'Page', 'scripts', [
		'type' => [ 'list_of' => 'String' ],
		'description' => __( 'Page Scripts', 'wp-graphql' ),
		'resolve' => function( $post ) {
			global $wp_scripts;
			$enqueued_scripts = array();
			foreach( $wp_scripts->queue as $handle ) {
				$enqueued_scripts[] = $wp_scripts->registered[$handle]->src;
			}
			return $enqueued_scripts;
		}
	] );

	register_graphql_field( 'Page', 'styles', [
		'type' => [ 'list_of' => 'String' ],
		'description' => __( 'Page Styles', 'wp-graphql' ),
		'resolve' => function( $post ) {
			global $wp_styles;
			$enqueued_styles = array();
			foreach( $wp_styles->queue as $handle ) {
				$enqueued_styles[] = $wp_styles->registered[$handle]->src;
			}
			return $enqueued_styles;
		}
	] );
} );