<?php

class S2Member_Tools_Autoloader {
    /**
     * Registers autoloader function to spl_autoload
     *
     * @since   0.1
     * @access  public
     * @static
     * @return  void
     */
    public static function register(){
        spl_autoload_register( 'S2Member_Tools_Autoloader::load' );
    }

    /**
     * Unregisters autoloader function with spl_autoload
     *
     * @ince    0.1
     * @access  public
     * @static
     * @return  void
     */
    public static function unregister(){
        spl_autoload_unregister( 'S2Member_Tools_Autoloader::load' );
    }

    /**
     * Autloading function
     *
     * @since   0.1
     * @param   string  $classname
     * @access  public
     * @static
     * @return  void
     */
    public static function load( $classname ){
        $file =  dirname( __FILE__ ) . DIRECTORY_SEPARATOR . ucfirst( $classname ) . '.php';
        if( file_exists( $file ) ) require_once $file;
    }
}
