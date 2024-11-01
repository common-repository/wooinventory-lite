<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'ic_Woo_Manage_Dashboard' ) ) { 
	class ic_Woo_Manage_Dashboard{
		function __construct() {
		}
		function page_init(){
			//echo "Dashbaord Content Here ";
			//echo $this->get_total_variation_product();
?>
			<h2 class="hide_for_print"><?php _e('WooInventory Dashboard');?></h2>
			<div class="ic_postbox">
				<h3>
					<span class="title">Summary</span>
				</h3>
				<div class="row ic_summary">
					<div class="col-xs-3">
						<div class="ic_block ic_block-orange">
							<i class="fa fa-cube"></i>
							<h4>Low Stock Product</h4>
							<span class="ic_value"><?php echo $this->get_low_stock_product_count(); ?></span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="ic_block ic_block-pink">
							<i class="fa fa-cube"></i>
							<h4>Out Of Stock Product</h4>
							<span class="ic_value"><?php echo $this->get_out_of_stock_product_count(); ?></span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="ic_block ic_block-purple">
							<i class="fa fa-cube"></i>
							<h4>Most Stock Product</h4>
							<span class="ic_value"><?php echo $this->get_most_stock_product_count(); ?></span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="ic_block ic_block-yellow">
							<i class="fa fa-cube"></i>
							<h4>Zero Stock Product</h4>
							<span class="ic_value"><?php echo  $this->get_zero_stock_product_count(); ?></span>
						</div>
					</div>
					
				</div>
                <div class="row ic_summary">
                	<div class="col-xs-3">
						<div class="ic_block ic_block-yellow">
							<i class="fa fa-cube"></i>
							<h4>Total Products</h4>
							<span class="ic_value"><?php echo $this->get_total_product(); ?></span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="ic_block ic_block-orange">
							<i class="fa fa-cube"></i>
							<h4>Total Simple Products</h4>
							<span class="ic_value"><?php echo $this->get_total_simple_product(); ?></span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="ic_block ic_block-pink">
							<i class="fa fa-cube"></i>
							<h4>Total Variable Products</h4>
							<span class="ic_value"><?php echo $this->get_total_variable_product(); ?></span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="ic_block ic_block-purple">
							<i class="fa fa-cube"></i>
							<h4>Total Variation Products</h4>
							<span class="ic_value"><?php echo $this->get_total_variation_product(); ?></span>
						</div>
					</div>
				</div>
            </div>
<?php
		}
		function get_total_simple_product(){
			global $wpdb;	
			$query  = "";
		
			$query .=" SELECT  count(*) as count  ";
			
			$query .=" FROM {$wpdb->prefix}posts as post  ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_relationships as relationships ON relationships.object_id=post.ID ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_taxonomy as term_taxonomy ON term_taxonomy.term_taxonomy_id=relationships.term_taxonomy_id ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}terms as terms ON terms.term_id=term_taxonomy.term_id ";
			
			
			$query .=" WHERE 1=1 ";
			$query .=" AND post.post_type='product'";
			$query .=" AND post.post_status='publish'";
			$query .=" AND terms.name='simple'";
			
			$row = $wpdb->get_var( $query);
			return $row;
			
		}
		function get_total_variable_product(){
			global $wpdb;	
			$query  = "";
		
			$query .=" SELECT  count(*) as count  ";
			
			$query .=" FROM {$wpdb->prefix}posts as post  ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_relationships as relationships ON relationships.object_id=post.ID ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_taxonomy as term_taxonomy ON term_taxonomy.term_taxonomy_id=relationships.term_taxonomy_id ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}terms as terms ON terms.term_id=term_taxonomy.term_id ";
			
			
			$query .=" WHERE 1=1 ";
			$query .=" AND post.post_type='product'";
			$query .=" AND post.post_status='publish'";
			$query .=" AND terms.name='variable'";
			
			$row = $wpdb->get_var( $query);
			return $row;
		}
		function get_total_variation_product(){
		   global $wpdb;	
			$query  = "";
			
		
			$query .=" SELECT  count(*) as count  ";
			
			$query .=" FROM {$wpdb->prefix}posts as post  ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}posts as post_parent ON post_parent.ID=post.post_parent ";
			
			$query .=" WHERE 1=1 ";
			$query .=" AND post.post_type='product_variation'";
			$query .=" AND post.post_status='publish'";
			$row = $wpdb->get_var( $query);
			
			return $row;
			
		}
		function get_total_product(){
			global $wpdb;	
			$query  = "";
		
			$query .=" SELECT  count(*) as count  ";
			
			$query .=" FROM {$wpdb->prefix}posts as post  ";
			
			//$query .=" LEFT JOIN {$wpdb->prefix}term_relationships as relationships ON relationships.object_id=post.ID ";
			
			//$query .=" LEFT JOIN {$wpdb->prefix}term_taxonomy as term_taxonomy ON term_taxonomy.term_taxonomy_id=relationships.term_taxonomy_id ";
			
			//$query .=" LEFT JOIN {$wpdb->prefix}terms as terms ON terms.term_id=term_taxonomy.term_id ";
			
			
			$query .=" WHERE 1=1 ";
			$query .=" AND post.post_type='product'";
			$query .=" AND post.post_status='publish'";
			//$query .=" AND terms.name='simple'";
			
			$row = $wpdb->get_var( $query);
			return $row;
			
		}
		function get_low_stock_product_count(){
			global $wpdb;
			// display an 'Out of Stock' label on archive pages
			$stock          = absint( max( get_option( 'woocommerce_notify_low_stock_amount' ), 1 ) );
			$nostock        = absint( max( get_option( 'woocommerce_notify_no_stock_amount' ), 0 ) );
			
			$query = 	"SELECT  COUNT( DISTINCT posts.ID) as product_count
			FROM {$wpdb->posts} as posts
				INNER JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id
				INNER JOIN {$wpdb->postmeta} AS postmeta2 ON posts.ID = postmeta2.post_id
				WHERE 1=1
				AND posts.post_type IN ( 'product', 'product_variation' )
				AND posts.post_status = 'publish'
				AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
				AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) <= '{$stock}'
				AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) > '{$nostock}' ";
				
			 $results = $wpdb->get_var( $query);
			//$this->print_array($results);	
			//echo $results[0]->product_count;
			 
			return  $results;
		
		}
		function get_out_of_stock_product_count(){
			global $wpdb;
			$stock          = absint( max( get_option( 'woocommerce_notify_low_stock_amount' ), 1 ) );
			$nostock        = absint( max( get_option( 'woocommerce_notify_no_stock_amount' ), 0 ) );
			$query = 	"SELECT  COUNT( DISTINCT posts.ID) as product_count
			FROM {$wpdb->posts} as posts
				INNER JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id
				INNER JOIN {$wpdb->postmeta} AS postmeta2 ON posts.ID = postmeta2.post_id
				WHERE 1=1
				AND posts.post_type IN ( 'product', 'product_variation' )
				AND posts.post_status = 'publish'
				AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
				AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) <= '{$nostock}' ";
				
			$results = $wpdb->get_var( $query);
		//	$this->print_array($results);	
			
			return $results;
		}
		function get_most_stock_product_count(){
			global $wpdb;
			// display an 'Out of Stock' label on archive pages
			$stock          = absint( max( get_option( 'woocommerce_notify_low_stock_amount' ), 1 ) );
			$nostock        = absint( max( get_option( 'woocommerce_notify_no_stock_amount' ), 0 ) );
			
			$query = 	"SELECT  COUNT( DISTINCT posts.ID) as product_count
			FROM {$wpdb->posts} as posts
				INNER JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id
				INNER JOIN {$wpdb->postmeta} AS postmeta2 ON posts.ID = postmeta2.post_id
				WHERE 1=1
				AND posts.post_type IN ( 'product', 'product_variation' )
				AND posts.post_status = 'publish'
				AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
				AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) > '{$stock}'
			";
				
			 $results = $wpdb->get_var( $query);
			//$this->print_array($results);	
			//echo $results[0]->product_count;
			 
			return  $results;
		
		}
		function get_zero_stock_product_count(){
			global $wpdb;
			$stock          = absint( max( get_option( 'woocommerce_notify_low_stock_amount' ), 1 ) );
			$nostock        = absint( max( get_option( 'woocommerce_notify_no_stock_amount' ), 0 ) );
			$query = 	"SELECT  COUNT( DISTINCT posts.ID) as product_count
			FROM {$wpdb->posts} as posts
				INNER JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id
				INNER JOIN {$wpdb->postmeta} AS postmeta2 ON posts.ID = postmeta2.post_id
				WHERE 1=1
				AND posts.post_type IN ( 'product', 'product_variation' )
				AND posts.post_status = 'publish'
				AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
				AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) = '0' ";
				
			$results = $wpdb->get_var( $query);
		//	$this->print_array($results);	
			
			return $results;
		}
	}
}