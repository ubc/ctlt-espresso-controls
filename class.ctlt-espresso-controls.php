<?php
/**
 * CTLT Espresso Controls.
 *
 * @package   CTLT_Espresso_Controls
 * @author    Julien <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */

/**
 * Plugin class.
 *
 * TODO: Rename this class to a proper name for your plugin.
 *
 * @package Espresso_CTLT_Controls
 * @author  Julien <email@example.com>
 */
class CTLT_Espresso_Controls {
	
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'ctlt-espresso-controls';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		add_action( 'admin_init', array( $this, 'init_ctlt_espresso_controls' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		// TODO: Define activation functionality here
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		// TODO: Define deactivation functionality here
	}

	public function init_ctlt_espresso_controls() {
		require_once( 'lib/class.ctlt-espresso-metaboxes.php' );
		/** meta box ordering **/
		// the order of the require_once statements are what the order of the meta boxes as they appear in the events admin
		require_once( 'lib/class.ctlt-espresso-handouts.php' );
		require_once( 'lib/class.ctlt-espresso-room-setup.php' );
		require_once( 'lib/class.ctlt-espresso-additional-information.php' );
		require_once( 'lib/class.ctlt-espresso-costs.php' );
	}

	public function espresso_properties() {
		if( !defined( 'EVENT_ESPRESSO_VERSION' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice' ) );
			deactivate_plugins( ESPRESSO_CTLT_CONTROLS_BASENAME );
		}



	}

	public function admin_notice() {
		?>
		<div class="updated">
			<p>Please enable <strong>Event Espresso</strong></p>
		</div>
		<?php
	}
}