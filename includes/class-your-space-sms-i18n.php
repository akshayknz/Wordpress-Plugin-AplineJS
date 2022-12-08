<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://akshaykn.vercel.app/
 * @since      1.0.0
 *
 * @package    Your_Space_Sms
 * @subpackage Your_Space_Sms/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Your_Space_Sms
 * @subpackage Your_Space_Sms/includes
 * @author     Akshay <akshayakn6@gmail.com>
 */
class Your_Space_Sms_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'your-space-sms',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
