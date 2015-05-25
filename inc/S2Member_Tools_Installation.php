<?php
/**
 * Created by PhpStorm.
 * User: staude
 * Date: 13.05.15
 * Time: 12:05
 */

class S2Member_Tools_Installation {

	public static function on_activate() {
        global $wpdb;

        // check wp version
        if ( ! version_compare( $GLOBALS[ 'wp_version' ], '3.0', '>=' ) ) {
            deactivate_plugins( S2Member_Tools::$plugin_filename );
            die(
                wp_sprintf(
                    '<strong>%s:</strong> ' .
                    __( 'Ddieses Plugin benötigt Wordpress 3.0+ um zu funktionieren', S2Member_Tools::get_textdomain() )
                    , S2Member_Tools::get_plugin_data( 'Name' )
                )
            );
        }


        // check php version
        if ( version_compare( PHP_VERSION, '5.2.0', '<' ) ) {
            deactivate_plugins( S2Member_Tools::$plugin_filename ); // Deactivate ourself
            die(
                wp_sprintf(
                    '<strong>%1s:</strong> ' .
                    __( 'Dieses Plugin benötigt PHP 5.2+ um ordnungsgemäß zu funktionieren. Ihre aktuelle PHP Version ist %1s, bitte fragen beten Sie ihren Hoster eine aktuellere, nicht so fehleranfällige PHP Version zu installieren.', S2Member_Tools::get_textdomain() )
                    , S2Member_Tools::get_plugin_data( 'Name' ), PHP_VERSION
                )
            );
        }

        // test if woocommerce is installed
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
            deactivate_plugins( S2Member_Tools::$plugin_filename ); // Deactivate ourself
            die(
                __( 'Das Plugin <strong>s2Member Framework</strong> ist nicht aktiv; ist aber notwendig für die Nutzung dieses Plugins.', S2Member_Tools::get_textdomain() )
            );
        }

	}

	public static function on_uninstall() {

	}
}