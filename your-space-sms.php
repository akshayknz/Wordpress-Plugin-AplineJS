<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://akshaykn.vercel.app/
 * @since             1.0.0
 * @package           Your_Space_Sms
 *
 * @wordpress-plugin
 * Plugin Name:       SMS 
 * Plugin URI:        https://https://madaboutdigital.co.in/
 * Description:       This is a plugin that helps to Login with otp,signup with otp, Attach SMSs to woocommerce hooks (onpurchase, onpayment, onfailiure etc), Attach SMSs to forms' submission
 * Version:           1.0.0
 * Author:            Akshay
 * Author URI:        https://akshaykn.vercel.app/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       your-space-sms
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
define( 'YOUR_SPACE_SMS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-your-space-sms-activator.php
 */
function activate_your_space_sms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-your-space-sms-activator.php';
	Your_Space_Sms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-your-space-sms-deactivator.php
 */
function deactivate_your_space_sms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-your-space-sms-deactivator.php';
	Your_Space_Sms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_your_space_sms' );
register_deactivation_hook( __FILE__, 'deactivate_your_space_sms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-your-space-sms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_your_space_sms() {

	$plugin = new Your_Space_Sms();
	$plugin->run();

}
run_your_space_sms();
