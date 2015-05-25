<?php
/**
 * Plugin Name:     s2Member Tools
 * Plugin URI:      http://staude.net/wordpress/s2member-tools
 * Description:     Add some features to s2member plugin
 * Author:          Frank Staude
 * Version:         0.1
 * Licence:         GPLv3
 * Author URI:      http://staude.net
 * Text Domain:     s2member-tools
 * Domain Path:     /languages
 * Last Change:     12.05.2015 13:20
 */

class S2Member_Tools {
    /**
     * Plugin version
     *
     * @var     string
     * @since   0.1
     * @access  public
     */
    static public $version = "0.1";

    /**
     * Singleton object holder
     *
     * @var     mixed
     * @since   0.1
     * @access  private
     */
    static private $instance = NULL;

    /**
     * @var     mixed
     * @since   0.1
     * @access  public
     */
    static public $plugin_name = NULL;

    /**
     * @var     mixed
     * @since   0.1
     * @access  public
     */
    static public $textdomain = NULL;

    /**
     * @var     mixed
     * @since   0.1
     * @access  public
     */
    static public $plugin_base_name = NULL;

    /**
     * @var     mixed
     * @since   0.1
     * @access  public
     */
    static public $plugin_url = NULL;

    /**
     * @var     string
     * @since   0.1
     * @access  public
     */
    static public $plugin_filename = __FILE__;

    /**
     * @var     string
     * @since   0.1
     * @access  public
     */
    static public $plugin_version = '';

	/**
	 * Options from S2Member plugin for caching
	 *
	 * @var     string
	 * @since   0.1
	 * @access  public
	 */
	static public $s2m_options = '';

    /**
     * Plugin constructor.
     *
     * @since   0.1
     * @access  public
     * @uses    plugin_basename
     */
    public function __construct ()
    {
        // set the textdomain variable for Auto Updater
        self::$textdomain = self::get_textdomain();

        // The Plugins Name
        self::$plugin_name = $this->get_plugin_header('Name');

        // The Plugins Basename
        self::$plugin_base_name = plugin_basename(__FILE__);

        // The Plugins Version
        self::$plugin_version = $this->get_plugin_header('Version');

	    self::$s2m_options = get_option( 'ws_plugin__s2member_options' );

        // Load the textdomain
        $this->load_plugin_textdomain();

        add_filter( 'manage_pages_columns',         array( 'S2Member_Tools_Pages', 'add_page_list_columns_head' ) );
	    add_action( 'manage_pages_custom_column',   array( 'S2Member_Tools_Pages', 'add_page_list_columns_data' ), 10, 2 );
	    add_filter( 'manage_posts_columns',         array( 'S2Member_Tools_Posts', 'add_post_list_columns_head' ) );
	    add_action( 'manage_posts_custom_column',   array( 'S2Member_Tools_Posts', 'add_post_list_columns_data' ), 10, 2 );

    }

    /**
     * Creates an Instance of this Class
     *
     * @since   0.1
     * @access  public
     * @return  S2Member_Tools
     */
    public static function get_instance() {

        if ( NULL === self::$instance )
            self::$instance = new self;

        return self::$instance;
    }
    /**
     * Load the localization
     *
     * @since	0.1
     * @access	public
     * @uses	load_plugin_textdomain, plugin_basename
     * @filters s2member_tools_translationpath path to translations files
     * @return	void
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain( self::get_textdomain(), FALSE,false, apply_filters ( 's2member_tools_translationpath', dirname( plugin_basename( __FILE__ )) .  self::get_textdomain_path() ) );
    }

    /**
     * Get a value of the plugin header
     *
     * @since   0.1
     * @access	protected
     * @param	string $value
     * @uses	get_plugin_data, ABSPATH
     * @return	string The plugin header value
     */
    protected function get_plugin_header( $value = 'TextDomain' ) {

        if ( ! function_exists( 'get_plugin_data' ) ) {
            require_once( ABSPATH . '/wp-admin/includes/plugin.php');
        }

        $plugin_data = get_plugin_data( __FILE__ );
        $plugin_value = $plugin_data[ $value ];

        return $plugin_value;
    }

	/**
	 * get the textdomain
	 *
	 * @since   0.1
	 * @static
	 * @access	public
	 * @return	string textdomain
	 */
	public static function get_textdomain() {
		if( is_null( self::$textdomain ) )
			self::$textdomain = self::get_plugin_data( 'TextDomain' );

		return self::$textdomain;
	}

	/**
	 * get the textdomain
	 *
	 * @access	public
	 * @return	string Domain Path
	 */
	public static function get_textdomain_path() {
		return self::get_plugin_data( 'DomainPath' );
	}

	/**
	 * get the s2m options
	 *
	 * @since   0.1
	 * @access  @public
	 * @return  mixed
	 */
	public static function get_s2m_options() {
		return self::$s2m_options;
	}

	/**
	 * return plugin comment data
	 *
	 * @since   0.1
	 * @uses    get_plugin_data
	 * @access  public
	 * @param   $value string, default = 'Version'
	 *		Name, PluginURI, Version, Description, Author, AuthorURI, TextDomain, DomainPath, Network, Title
	 * @return  string
	 */
	private static function get_plugin_data( $value = 'Version' ) {

		if ( ! function_exists( 'get_plugin_data' ) )
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

		$plugin_data  = get_plugin_data ( __FILE__ );
		$plugin_value = $plugin_data[ $value ];

		return $plugin_value;
	}
}

if ( class_exists( 'S2Member_Tools' ) ) {

    add_action( 'plugins_loaded', array( 'S2Member_Tools', 'get_instance' ) );

    require_once 'inc/S2Member_Tools_Autoloader.php';
    S2Member_Tools_Autoloader::register();

    register_activation_hook( __FILE__, array( 'S2Member_Tools_Installation', 'on_activate' ) );
    register_uninstall_hook(  __FILE__,	array( 'S2Member_Tools_Installation', 'on_uninstall' ) );
}
