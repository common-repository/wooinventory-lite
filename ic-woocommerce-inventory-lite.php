<?php 
/**
Plugin Name: WooInventory Lite
Description: With WooInventory a WooCommerce Stock Manager you can easily handle various stock related settings from single page.
Version: 2.0
Author: Infosoft Consultants
Author URI: http://plugins.infosofttech.com
Plugin URI: https://wordpress.org/plugins/wooinventory-lite/

Tested Wordpress Version: 6.1.x
WC requires at least: 3.5.x
WC tested up to: 7.4.x
Requires at least: 5.7
Requires PHP: 5.6

Text Domain: icmanageinv
Domain Path: /languages/

*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'IC_WooCommerce_Inventory_Lite' ) ) { 
	class IC_WooCommerce_Inventory_Lite{
		function __construct() {
			add_filter( 'plugin_action_links_wp-job-pro/ic-job-manager.php', array( $this, 'plugin_action_links' ), 9, 2 );
			add_action( 'init', array( $this, 'load_plugin_textdomain' ));
			add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ));
		}
		
		function plugins_loaded(){
			include_once("include/ic-woocommerce-inventory-lite-init.php");
			$obj_init = new IC_WooCommerce_Inventory_Lite_Init();
		}
		
		function plugin_action_links($plugin_links, $file = ''){
			$plugin_links[] = '<a target="_blank" href="'.admin_url('admin.php?page=inventory-menu').'">' . esc_html__( 'Dashboard', 'icmanageinv' ) . '</a>';
			return $plugin_links;
		}
		
		function load_plugin_textdomain(){
			load_plugin_textdomain( 'icmanageinv', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
		}		
	}
	$obj = new  IC_WooCommerce_Inventory_Lite();
}
?>