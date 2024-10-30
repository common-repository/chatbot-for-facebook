<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://personic.ai
 * @since             1.0.0
 * @package           Facebook_Chatbot
 *
 * @wordpress-plugin
 * Plugin Name:       Chatbot for Facebook
 * Plugin URI:        http://personic.ai
 * Description:       Publish posts automatically from your blog to a Chatbot for Facebook
 * Version:           1.0.0
 * Author:            personic
 * Author URI:        https://profiles.wordpress.org/personic
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       facebook-chatbot
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-facebook-chatbot-activator.php
 */
function activate_facebook_chatbot() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-facebook-chatbot-activator.php';
	Facebook_Chatbot_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-facebook-chatbot-deactivator.php
 */
function deactivate_facebook_chatbot() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-facebook-chatbot-deactivator.php';
	Facebook_Chatbot_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_facebook_chatbot' );
register_deactivation_hook( __FILE__, 'deactivate_facebook_chatbot' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-facebook-chatbot.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_facebook_chatbot() {

	$plugin = new Facebook_Chatbot();
	$plugin->run();

}
run_facebook_chatbot();
