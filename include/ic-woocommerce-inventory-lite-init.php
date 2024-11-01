<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'IC_WooCommerce_Inventory_Lite_Init' ) ) { 
	class IC_WooCommerce_Inventory_Lite_Init{
		function __construct() {
			add_action( 'admin_menu',  array(&$this,'admin_menu') );
			add_action( 'admin_enqueue_scripts',  array(&$this,'admin_enqueue_scripts' ));
			add_action( 'wp_ajax_ic_mange_inv_lite',  array(&$this,'ic_mange_inv_lite') );	
		}
		function admin_menu(){
			
			$option = array();
			$option["role"] = "manage_options";
			$option["menu"] = "inventory-menu";
			add_menu_page('WooInventory', 'WooInventory', $option["role"], $option["menu"],  array(&$this,'add_page'), 'dashicons-store','63.15' );
			add_submenu_page($option["menu"], 'Dashboard', 		  'Dashboard', 		  $option["role"], 	$option["menu"] , array(&$this,'add_page'));
			add_submenu_page($option["menu"], 'Inventory', 		  'Inventory', 		 $option["role"], 	"ic-woo-manage-inventory" , array(&$this,'add_page'));
			add_submenu_page($option["menu"], 'Other Plug-ins', 'Other Plug-ins', 		 $option["role"], 	"ic-woo-manage-addons" , array(&$this,'add_page'));
		}
		function admin_enqueue_scripts(){
			wp_enqueue_script( 'ic-mange-inv-script', plugins_url( '../js/script.js', __FILE__ ), array('jquery') );
			wp_enqueue_script( 'ic-mange-inv-update-script', plugins_url( '../js/ic-mange-inv.js', __FILE__ ), array('jquery') );
			wp_localize_script( 'ic-mange-inv-script', 'ic_taxt_report_ajax_object', array( 'ic_taxt_report_ajax_url' => admin_url( 'admin-ajax.php' )) );
			
			wp_enqueue_style('ic-mange-inv-css', plugins_url( '../css/ic-mange-inv.css', __FILE__ ));
			wp_enqueue_style('fontawesome_styles', plugins_url( '../css/lib/font-awesome.min.css', __FILE__) );
				
		}
		function ic_mange_inv_lite(){
			//echo json_encode($_REQUEST);
			//die;
			$sub_action=$this->get_request("sub_action");
			if ($sub_action =="ic_update_stock"){
				include_once("ic-woo-manage-inventory.php");
				$obj = new IC_Woo_Manage_Inventory();
				$obj->update_stock();
			}
			if ($sub_action =="ic_stock_manage"){
				include_once("ic-woo-manage-inventory.php");
				$obj = new IC_Woo_Manage_Inventory();
				$obj->ajax();
			}
			//echo json_encode($_REQUEST);
			die;
		}
		function add_page(){
			?>
            	<div class="ic_inventory_lite">
                <div class="container-liquid">
            <?php
			if(isset($_REQUEST["page"])){
				$page = $_REQUEST["page"];
				if ($page=="ic-woo-manage-inventory"){
					include("ic-woo-manage-inventory.php");
					$obj = new IC_Woo_Manage_Inventory();
					$obj->page_init();
				}
				if ($page=="inventory-menu"){
					include("ic-woo-manage-dashboard.php");
					$obj = new ic_Woo_Manage_Dashboard();
					$obj->page_init();
				}
				if ($page=="ic-woo-manage-addons"){
					include("ic-woo-manage-addon.php");
					$obj = new ic_Woo_Manage_addons();
					$obj->page_init();
				}
			?>
            	</div>
                </div>
            <?php
			}
		}
		public function get_request($name,$default = NULL,$set = false){
			if(isset($_REQUEST[$name])){
				$newRequest = $_REQUEST[$name];
				
				if(is_array($newRequest)){
					$newRequest = implode(",", $newRequest);
				}else{
					$newRequest = trim($newRequest);
				}
				
				if($set) $_REQUEST[$name] = $newRequest;
				
				return $newRequest;
			}else{
				if($set) 	$_REQUEST[$name] = $default;
				return $default;
			}
		}
	}
}
?>