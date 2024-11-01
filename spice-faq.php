<?php
/*
 * Plugin Name: Spice Faq
 * Description: This is Spice Faq plugin. .
 * Version: 1.0
 * Author: priyanshu.mittal,a.ankit,abhipathak,spicethemes
 * Author URI: http://spicethemes.com
 * License: GPLv2 or later
 * Text Domain: spice-faq
 * Domain Path: /languages
 *
*/

class Spice_FAQ {
	
	/**
     * Plugin version.
     *
     * @since   1.0
     * @access  private
     * @var     string      $version    Plugin version
     */
    private $version;

    /**
     * The directory path to the plugin file's includes folder.
     *
     * @since   1.0
     * @access  private
     * @var     string      $dir        The directory path to the includes folder
     */
    private $inc;

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.6.0
     */
    public function __construct() {
		define( 'SPICE__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		define( 'SPICE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        $this->version = '1.0';
        $this->inc = trailingslashit( plugin_dir_path( __FILE__ ) . '/include' );
        $this->load_required_fiels();
      }
	
	private function load_required_fiels(){
		require_once($this->inc . 'admin-faq.php');
		require_once($this->inc . 'show-faq.php');
		
	}
	

}


add_action( 'plugins_loaded', 'spice_faq_run' );

function spice_faq_run() {
    load_plugin_textdomain( 'spice_faq' );
    new Spice_FAQ();
}
?>