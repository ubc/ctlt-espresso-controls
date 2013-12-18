<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * @package   CTLT Espresso Controls
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 *
 * @wordpress-plugin
 * Plugin Name: CTLT Espresso Controls
 * Plugin URI:  
 * Description: Create more control panels into the event editor
 * Version:     3.1.5
 * Author:      Julien Law and Nathan Sidles, CTLT
 * Author URI:  ctlt.ubc.ca
 * Text Domain: 
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die(-1);
}

define( 'CTLT_ESPRESSO_CONTROLS_DEBUG', false );

define( 'CTLT_ESPRESSO_CONTROLS_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'CTLT_ESPRESSO_CONTROLS_BASENAME', plugin_basename( __FILE__ ) );
define( 'CTLT_ESPRESSO_CONTROLS_DIR_URL', plugins_url( '', CTLT_ESPRESSO_CONTROLS_BASENAME ) );
define( 'CTLT_ESPRESSO_CONTROLS_ASSETS_URL', CTLT_ESPRESSO_CONTROLS_DIR_URL . '/assets/' );
define( 'CTLT_ESPRESSO_CONTROLS_CSS_URL', CTLT_ESPRESSO_CONTROLS_DIR_URL . '/css/' );
define( 'CTLT_ESPRESSO_CONTROLS_JS_URL', CTLT_ESPRESSO_CONTROLS_DIR_URL . '/js/' );

define( 'CTLT_ESPRESSO_EVENTS_META', $wpdb->prefix . 'events_meta' );

// TODO: replace `class-plugin-name.php` with the name of the actual plugin's class file
require_once( CTLT_ESPRESSO_CONTROLS_DIR_PATH . 'class.ctlt-espresso-controls.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
// TODO: replace Plugin_Name with the name of the plugin defined in `class-plugin-name.php`
register_activation_hook( __FILE__, array( 'CTLT_Espresso_Controls', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'CTLT_Espresso_Controls', 'deactivate' ) );

// TODO: replace Plugin_Name with the name of the plugin defined in `class-plugin-name.php`
CTLT_Espresso_Controls::get_instance();
