<?php

class S2Member_Tools_Installation {

    /**
     * Check some thinks on plugin activation
     *
     * @since   0.1
     * @access  public
     * @static
     * @return  void
     */
	public static function on_activate() {

        // check WordPress version
        if ( ! version_compare( $GLOBALS[ 'wp_version' ], '3.0', '>=' ) ) {
            deactivate_plugins( S2Member_Tools::$plugin_filename );
            die(
                wp_sprintf(
                    '<strong>%s:</strong> ' .
                    __( 'This plugin requires WordPress 3.0 or newer to work', S2Member_Tools::get_textdomain() )
                    , S2Member_Tools::get_plugin_data( 'Name' )
                )
            );
        }


        // check php version
        if ( version_compare( PHP_VERSION, '5.2.0', '<' ) ) {
            deactivate_plugins( S2Member_Tools::$plugin_filename );
            die(
                wp_sprintf(
                    '<strong>%1s:</strong> ' .
                    __( 'This plugin requires PHP 5.2 or newer to work. Your current PHP version is %1s, please update.', S2Member_Tools::get_textdomain() )
                    , S2Member_Tools::get_plugin_data( 'Name' ), PHP_VERSION
                )
            );
        }

        // test if s2member is installed
        $plugins = get_plugins();
        $deactivate = true;
        foreach( $plugins as $path => $plugin ){
            if( strtolower( $plugin[ 'Name' ] ) === 's2member framework' ){
                if( is_plugin_active( $path ) ){
                    $deactivate = false;
                }
                break;
            }
        }

        if( $deactivate ){
            deactivate_plugins( S2Member_Tools::$plugin_filename );
            die(
                __( 'The plugin <strong>s2Member Framework</strong> is not activated, but is necessary for the use of this plugin.', S2Member_Tools::get_textdomain() )
            );
        }

	}

	public static function on_uninstall() {

	}
}