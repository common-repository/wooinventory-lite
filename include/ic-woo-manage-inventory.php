<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'IC_Woo_Manage_Inventory' ) ) { 
	class IC_Woo_Manage_Inventory{
		function __construct() {
		}
		function page_init(){
		//$this->ic_manage_simple_product();
		//$this->ic_manage_variable_product();
		//$this->ic_manage_variation_product();
		//$this->get_variation_product_query();
		//$input_type = "hidden";
		
		$input_type = "text";
		$product_type =	isset($_REQUEST["product_type"])?$_REQUEST["product_type"] : 'simple_product';
		$page =	isset($_REQUEST["page"])?$_REQUEST["page"] : '';
		$page_titles 				= array(
					'simple_product'			=> __('Simple Product',				'icwoocommerce_textdomains')
					,'variable_product'		 => __('Variable Product',					'icwoocommerce_textdomains')
					,'variation_product'		 => __('Variation Product',					'icwoocommerce_textdomains')				
				);
		?>
        <h2><?php _e('WooInventory')?></h2>
        
        <h2 class="nav-tab-wrapper woo-nav-tab-wrapper hide_for_print">
		<div class="responsive-menu"><a href="#" id="menu-icon"></a></div>
		<?php            	
		   foreach ( $page_titles as $key => $value ) {
				echo '<a href="'.admin_url( 'admin.php?page='.$page.'&product_type=' . urlencode( $key ) ).'" class="nav-tab ';
				if ( $product_type == $key ) echo 'nav-tab-active';
				echo '">' . esc_html( $value ) . '</a>';
		   }
		   
		   
		?>
        </h2>
        <?php 
		if ($product_type == "simple_product"){
		?>
        <form name="frm_simple_stock" id="frm_simple_stock" style="display:none">
            <input type="<?php echo $input_type ; ?>" name="p"  value="1" class="_page">
			<input type="<?php echo $input_type ; ?>" name="limit"  value="10">
            <input type="<?php echo $input_type ; ?>" name="sub_action"  value="ic_stock_manage">
            <input type="<?php echo $input_type ; ?>" name="call"  value="ic_simple_product">
            <input type="<?php echo $input_type ; ?>" name="action"  value="ic_mange_inv_lite">
             <input type="<?php echo $input_type ; ?>" name="from_name"  class="from_name" value="frm_simple_stock">
            <input type="submit" value="Search" class="ic_button">
            </form>
            <div class="_ic_data ic_table-responsive"></div>
        <?php	
		}
		if ($product_type == "variable_product"){
		?>
        <form name="frm_variable_stock" id="frm_variable_stock" style="display:none">
            <input type="<?php echo $input_type ; ?>" name="p"  value="1" class="_page">
			<input type="<?php echo $input_type ; ?>" name="limit"  value="10">
            <input type="<?php echo $input_type ; ?>" name="sub_action"  value="ic_stock_manage">
            <input type="<?php echo $input_type ; ?>" name="call"  value="ic_variable_product">
            <input type="<?php echo $input_type ; ?>" name="action"  value="ic_mange_inv_lite">
            <input type="<?php echo $input_type ; ?>" name="from_name"  class="from_name" value="frm_variable_stock">
            <input type="submit" value="Search" class="ic_button">
            </form>
            <div class="_ic_data ic_table-responsive"></div>
        <?php	
		}
		if ($product_type == "variation_product"){
		?>
        <form name="frm_variation_stock" id="frm_variation_stock" style="display:none">
            <input type="<?php echo $input_type ; ?>" name="p"  value="1" class="_page">
			<input type="<?php echo $input_type ; ?>" name="limit"  value="10">
            <input type="<?php echo $input_type ; ?>" name="sub_action"  value="ic_stock_manage">
            <input type="<?php echo $input_type ; ?>" name="call"  value="ic_variation_product">
            <input type="<?php echo $input_type ; ?>" name="action"  value="ic_mange_inv_lite">
            <input type="<?php echo $input_type ; ?>" name="from_name"  class="from_name" value="frm_variation_stock">
            <input type="submit" value="Search" class="ic_button">
            </form>
            <div class="_ic_data ic_table-responsive"></div>
        <?php	
		}
		?>
        
        <?php
		}
		function ic_manage_simple_product(){
			$columns =$this->get_columns("simple");
			$limit= $this->get_request("limit",10);
			
			//$row = $this->get_simple_product_query();
			
			$row = $this->get_simple_product_query("row");
			$count = $this->get_simple_product_query("count");
			
			
			?>
            <div class="_ic_message ic_success"></div>
            <table class="widefat">
            <thead>
            	<tr>
            	<?php 
					foreach($columns as $ckey=>$cvalue){
					?>
                    <td><?php echo $cvalue; ?></td>
                    <?php
					}
				?>	
            	</tr>
             </thead>
            <?php
			foreach($row as $key=>$value){
				?>
                <tr>
                <?php
				foreach($columns as $ckey=>$cvalue){
					$td_value = "";
					switch($ckey){
						case "sku":
							$td_value = $this->get_text_box("sku",$value->$ckey,"10");
							break;
						case "product_name":
							$td_value = $this->get_text_box("product_name",$value->$ckey,"30");
							break;
						case "stock":
							$td_value = $this->get_text_box("stock",$value->$ckey,'4',"right");
							break;
						case "sale_price":
							$td_value = $this->get_text_box("sale_price",$value->$ckey,'4',"right");
							break;	
						case "regular_price":
							$td_value = $this->get_text_box("regular_price",$value->$ckey,'4',"right");
							break;
						case "manage_stock":
							$td_value = $this->get_yes_no_dropdown("manage_stock",$value->$ckey);
							break;
						case "backorders":
							//$td_value = $value->$ckey;
							$td_value = $this->get_yes_no_dropdown("backorders",$value->$ckey,150);
							break;
						case "stock_status":
							//$td_value = $value->$ckey;
							$td_value = $this->get_yes_no_dropdown("stock_status",$value->$ckey);
							break;	
						case "update":
							$td_value = "<a class='_update_inv' href=\"\" data-product_id='{$value->product_id}' >Update</a>";
							break;
						case "edit":
							$edit   = admin_url("post.php")."?post=". $value->product_id."&action=edit";
							$td_value = "<a href=\"".  $edit."\" target=\"_blank\">Edit</a>";
							break;			
						default:
							$td_value = isset($value->$ckey)?$value->$ckey:'';
					}
					?>
                    <td><?php echo $td_value; ?></td>
                    <?php
						
				}
				?>
                </tr>
                <?php
			}
			?>
    		</table>
            <?php
			echo $this->get_pagination($count ,$limit);
		}
		function ic_manage_variable_product(){
			$columns =$this->get_columns("variable");
		    $limit= $this->get_request("limit",10);
			
			
			$row = $this->get_variable_product_query("row");
			$count = $this->get_variable_product_query("count");
			
			
			
			?>
            <div class="_ic_message ic_success"></div>
            <table class="widefat">
            <thead>
            	<tr>
            	<?php 
					foreach($columns as $ckey=>$cvalue){
					?>
                    <td><?php echo $cvalue; ?></td>
                    <?php
					}
				?>	
            	</tr>
                
            </thead>
            <?php
			foreach($row as $key=>$value){
				?>
                <tr>
                <?php
				foreach($columns as $ckey=>$cvalue){
					$td_value = "";
					switch($ckey){
						case "sku":
							$td_value = $this->get_text_box("sku",$value->$ckey,"10");
							break;
						case "product_name":
							$td_value = $this->get_text_box("product_name",$value->$ckey,"30");
							break;
						case "stock":
							$td_value = $this->get_text_box("stock",$value->$ckey ,'4',"right");
							break;
						case "sale_price":
							$td_value = $this->get_text_box("sale_price",$value->$ckey ,'4',"right");
							break;	
						case "regular_price":
							$td_value = $this->get_text_box("regular_price",$value->$ckey ,'4',"right");
							break;
						case "manage_stock":
							$td_value = $this->get_yes_no_dropdown("manage_stock",$value->$ckey);
							break;
						case "backorders":
							//$td_value = $value->$ckey;
							$td_value = $this->get_yes_no_dropdown("backorders",$value->$ckey,150);
							break;
						case "stock_status":
							//$td_value = $value->$ckey;
							$td_value = $this->get_yes_no_dropdown("stock_status",$value->$ckey);
							break;	
						case "update":
							$td_value = "<a class='_update_inv' href=\"\" data-product_id='{$value->product_id}' >Update</a>";
							break;
						case "edit":
							$edit   = admin_url("post.php")."?post=". $value->product_id."&action=edit";
							$td_value = "<a href=\"".  $edit."\" target=\"_blank\">Edit</a>";
							break;			
						default:
							$td_value = isset($value->$ckey)?$value->$ckey:'';
					}
					?>
                    <td><?php echo $td_value; ?></td>
                    <?php
						
				}
				?>
                </tr>
                <?php
			}
			?>
    		</table>
            <?php
			echo $this->get_pagination($count ,$limit);
			
		}
		function ic_manage_variation_product(){
			  $limit= $this->get_request("limit",10);
			$columns =$this->get_columns("variation");
			$row = $this->get_variation_product_query("row");
			 $count = $this->get_variation_product_query("count");
			
			
			
			?>
            <div class="_ic_message ic_success"></div>
            <table class="widefat">
            <thead>
            	<tr>
            	<?php 
					foreach($columns as $ckey=>$cvalue){
					?>
                    <td><?php echo $cvalue; ?></td>
                    <?php
					}
				?>	
            	</tr>
           	</thead>
            <?php
			foreach($row as $key=>$value){
				?>
                <tr>
                <?php
				foreach($columns as $ckey=>$cvalue){
					$td_value = "";
					switch($ckey){
						case "sku":
						     $new_td_value = isset($value->$ckey)?$value->$ckey:''; 
							$td_value = $this->get_text_box("sku",  $new_td_value,"8");
							break;
						case "product_name":
							$td_value = $this->get_text_box("product_name",$value->$ckey,"30");
							break;
						case "stock":
							$new_td_value = isset($value->$ckey)?$value->$ckey:'0'; 
							$td_value = $this->get_text_box("stock",$new_td_value ,'4',"right");
							break;
						case "sale_price":
							$td_value = $this->get_text_box("sale_price",$value->$ckey,'4',"right");
							break;	
						case "regular_price":
							$td_value = $this->get_text_box("regular_price",$value->$ckey,'4',"right");
							break;
						case "manage_stock":
							$new_td_value = isset($value->$ckey)?$value->$ckey:''; 
							$td_value = $this->get_yes_no_dropdown("manage_stock",$new_td_value ,60);
							break;
						case "backorders":
							//$td_value = $value->$ckey;
							$new_td_value = isset($value->$ckey)?$value->$ckey:''; 
							$td_value = $this->get_yes_no_dropdown("backorders",$new_td_value,150);
							break;
						case "stock_status":
							//$td_value = $value->$ckey;
							$new_td_value = isset($value->$ckey)?$value->$ckey:''; 
							$td_value = $this->get_yes_no_dropdown("stock_status",$new_td_value,110);
							break;	
						case "update":
							$td_value = "<a class='_update_inv' href=\"\" data-product_id='{$value->product_id}' >Update</a>";
							break;
						case "edit":
							$edit   = admin_url("post.php")."?post=". $value->parent_product_id."&action=edit";
							$td_value = "<a href=\"".  $edit."\" target=\"_blank\">Edit</a>";
							break;				
						default:
							$td_value = isset($value->$ckey)?$value->$ckey:'';
					}
					?>
                    <td><?php echo $td_value; ?></td>
                    <?php
						
				}
				?>
                </tr>
                <?php
			}
			?>
    		</table>
            <?php
			echo $this->get_pagination($count ,$limit);
		}
		function get_text_box($name="",$value="",$size= 4,$text_align="left"){
			ob_start();	
			$output = ob_get_contents();
			?>
            <input style="text-align:<?php echo $text_align ?>" type="text" size="<?php echo $size; ?>" class="_<?php echo $name; ?>"  name="<?php echo $name ?>" value="<?php echo $value; ?>" >
            <?php
			$output = ob_get_contents();
			ob_end_clean();
			return $output ;
		}
		function get_yes_no_dropdown($name='',$selected='',$size = 100){
			$dropdown_value  = array();
			
			$dropdown_value = $this->get_dropdown_value($name);
			ob_start();	
			$output = ob_get_contents();
			?>
            <select name="<?php echo $name; ?>" class="_<?php echo $name; ?>" style="width:<?php echo $size; ?>px;">
            <?php 
			foreach($dropdown_value as $key=>$value){
				if ($selected ==$key ){
				?>
                <option selected value="<?php  echo $key; ?>"><?php echo $value; ?></option>
                <?php
				}else{
				?>
               <option  value="<?php  echo $key; ?>"><?php echo $value; ?></option>
                <?php
				}
			}
			?>
            </select>
            <?php	
			$output = ob_get_contents();
			ob_end_clean();
			return $output ;
		}
		function get_simple_product_query($type = "row"){
			global $wpdb;
			$meta_key = $this->get_meta_key("simple");
			
	
			
			$p		= $this->get_request("p",1);
			$limit	= $this->get_request("limit",10);
			$start 	= ($p-1) * $limit;
			
			$query  = "";
			if ($type =="count"){
				$query .=" SELECT  count(*) as count  ";
			}else{
				$query .=" SELECT    ";
				$query .=" post.ID as product_id ";
				$query .=", post.post_title as product_name ";
			}
			$query .=" FROM {$wpdb->prefix}posts as post  ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_relationships as relationships ON relationships.object_id=post.ID ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_taxonomy as term_taxonomy ON term_taxonomy.term_taxonomy_id=relationships.term_taxonomy_id ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}terms as terms ON terms.term_id=term_taxonomy.term_id ";
			
			
			$query .=" WHERE 1=1 ";
			$query .=" AND post.post_type='product'";
			$query .=" AND post.post_status='publish'";
			$query .=" AND terms.name='simple'";
			
			if ($type =="count"){
				$row = $wpdb->get_var( $query);
			}else{
				$query .=" LIMIT $start, $limit "	;
				$row = $wpdb->get_results( $query);
			}
			
			//$this->print_data($row);
			
			
			if ($type =="row"){
				foreach($row as $key=>$value){
					$product_id =$value->product_id ;
					$all_meta = $this->get_all_post_meta($product_id,$meta_key);
					foreach($all_meta as $k=>$v){
						$row[$key]->$k =$v;
					}
				}
			}
			//$this->print_data($row);
			return $row;	
		}
		function get_variable_product_query($type = "row"){
			global $wpdb;
			$meta_key = $this->get_meta_key("variable");
			
			
			$p		= $this->get_request("p",1);
			$limit	= $this->get_request("limit",10);
			$start 	= ($p-1) * $limit;

			
			$query  = "";
			if ($type =="count"){
				$query .=" SELECT  count(*) as count  ";
			}else{
				$query .=" SELECT    ";
				$query .=" post.ID as product_id ";
				$query .=", post.post_title as product_name ";
			}
			$query .=" FROM {$wpdb->prefix}posts as post  ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_relationships as relationships ON relationships.object_id=post.ID ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_taxonomy as term_taxonomy ON term_taxonomy.term_taxonomy_id=relationships.term_taxonomy_id ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}terms as terms ON terms.term_id=term_taxonomy.term_id ";
			
			
			$query .=" WHERE 1=1 ";
			$query .=" AND post.post_type='product'";
			$query .=" AND post.post_status='publish'";
			$query .=" AND terms.name='variable'";
			
			if ($type =="count"){
				$row = $wpdb->get_var( $query);
			}else{
				$query .=" LIMIT $start, $limit "	;
				$row = $wpdb->get_results( $query);
			}
			//$this->print_data($row);
			
			//die;
			if ($type =="row"){
				foreach($row as $key=>$value){
					$product_id =$value->product_id ;
					$all_meta = $this->get_all_post_meta($product_id,$meta_key);
					foreach($all_meta as $k=>$v){
						$row[$key]->$k =$v;
					}
				}
			}
			//$this->print_data($row);
			return $row;	
		}
		function get_variation_product_query($type = "row"){
			global $wpdb;
			$meta_key = $this->get_meta_key("variation");
			
			$p		= $this->get_request("p",1);
			$limit	= $this->get_request("limit",10);
			$start 	= ($p-1) * $limit;
			
			if ($type =="count"){
				$query .=" SELECT  count(*) as count  ";
			}else{
				$query  = "";
				$query .=" SELECT    ";
				$query .=" post.ID as product_id ";
				//$query .=", post.post_title as product_name2 ";
				$query .=", post_parent.post_title as product_name ";
				$query .=", post_parent.ID as parent_product_id ";
			}
			$query .=" FROM {$wpdb->prefix}posts as post  ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}posts as post_parent ON post_parent.ID=post.post_parent ";
			
			$query .=" WHERE 1=1 ";
			$query .=" AND post.post_type='product_variation'";
			$query .=" AND post.post_status='publish'";
		
			
			if ($type =="count"){
				$row = $wpdb->get_var( $query);
			}else{
				$query .=" LIMIT $start, $limit "	;
				$row = $wpdb->get_results( $query);
			}
			
			
			if ($type =="row"){
			
				$variation_ids		= $this->get_items_id_list($row,'product_id');		
				$product_variations   = $this->get_product_variations($variation_ids);
				foreach ($row as $key => $value){
					$product_id = $row[$key]->product_id;
					$product_variation = isset($product_variations[$product_id]) ? $product_variations[$product_id] : array();			
					//$row[$key]->product_name  = $value->parent_product_title ." - ". implode(", ",$product_variation);
					$row[$key]->product_variation  = implode(", ",$product_variation);
					
				}
				
				
				
				foreach($row as $key=>$value){
					$product_id =$value->product_id ;
					$all_meta = $this->get_all_post_meta($product_id,$meta_key);
					foreach($all_meta as $k=>$v){
						$row[$key]->$k =$v;
					}
				}
			}
			return $row;	
		}
		function get_items_id_list($order_items = array(),$field_key = 'order_id', $return_default = '-1' , $return_formate = 'string'){
			$list 	= array();
			$string = $return_default;
			if(count($order_items) > 0){
				foreach ($order_items as $key => $order_item) {
					if(isset($order_item->$field_key)){
						if(!empty($order_item->$field_key))
							$list[] = $order_item->$field_key;
					}
				}
				
				$list = array_unique($list);
				
				if($return_formate == "string"){
					$string = implode(",",$list);
				}else{
					$string = $list;
				}
			}
			return $string;
		}//End Function
		function get_product_variations($order_id_string = array()){			
			global $wpdb;
			
			if(is_array($order_id_string)){
				$order_id_string = implode(",",$order_id_string);
			}
				
			$sql = "SELECT meta_key, REPLACE(REPLACE(meta_key, 'attribute_', ''),'pa_','') AS attributes, meta_value, post_id as variation_id
					FROM  {$wpdb->prefix}postmeta as postmeta WHERE 
					meta_key LIKE '%attribute_%'";
			
			if(strlen($order_id_string) > 0){
				$sql .= " AND post_id IN ({$order_id_string})";
				//$sql .= " AND post_id IN (23)";
			}
			
			$order_items 		= $wpdb->get_results($sql);
			
			$product_variation  = array(); 
			if(count($order_items)>0){
				foreach ( $order_items as $key => $order_item ) {
					$variation_label	=	ucfirst($order_item->meta_value);
					$variation_key		=	$order_item->attributes;
					$variation_id		=	$order_item->variation_id;
					$product_variation[$variation_id][$variation_key] =  $variation_label;
				}
			}
			return $product_variation;
		}
		function get_all_post_meta($post_id = 202,$meta_key = array()){
		
		
		
			global $wpdb;
			$query  ="";	
			$query .=" SELECT  *  ";
			$query .=" FROM {$wpdb->prefix}postmeta as postmeta  ";
			$query .=" WHERE 1=1 ";
			$query .=" AND postmeta.post_id= {$post_id} ";
			if (count($meta_key)>0 ){
				$str_meta_key = implode("','", $meta_key );
				$query .=" AND postmeta.meta_key IN ( '{$str_meta_key}' )";
			}
			$row = $wpdb->get_results( $query);
			$meta_row = array();
			foreach($row as $key=>$value){
				$meta_row[ltrim($value->meta_key,"_")] = $value->meta_value;
			}
			return $meta_row;
		}
		function print_data($data){
			print "<pre>";
			print_r($data);
			print "</pre>";
		}
		function get_columns($product_type="simple"){
			$columns = array();
			if ($product_type == "simple" ){
					//$columns["product_id"] 		= __("product_id","icmanageinv");
					$columns["sku"] 			   = __("SKU","icmanageinv");
					$columns["product_name"] 	  = __("Product Name","icmanageinv");
					
					
					$columns["regular_price"] 	 = __("Regular Price","icmanageinv");
					$columns["sale_price"] 		= __("Sale Price","icmanageinv");
					$columns["stock"]			 = __("Stock","icmanageinv");
					$columns["stock_status"] 	  = __("Stock Status","icmanageinv");
					$columns["backorders"] 		= __("Back Orders","icmanageinv");
					$columns["manage_stock"] 	  = __("Manage Stock","icmanageinv");
					$columns["update"] 	 		= __("Update","icmanageinv");
					$columns["edit"] 	 		  = __("Edit","icmanageinv");
			}
			if ($product_type == "variable" ){
				//	$columns["product_id"] 		= __("product_id","icmanageinv");
					$columns["sku"] 			   = __("SKU","icmanageinv");
					$columns["product_name"] 	  = __("Product Name","icmanageinv");
					
					
					$columns["regular_price"] 	 = __("Regular Price","icmanageinv");
					$columns["sale_price"] 		= __("Sale Price","icmanageinv");
					$columns["stock"]			 = __("Stock","icmanageinv");
					$columns["stock_status"] 	  = __("Stock Status","icmanageinv");
					$columns["backorders"] 		= __("Back Orders","icmanageinv");
					$columns["manage_stock"] 	  = __("Manage Stock","icmanageinv");
					$columns["update"] 	 		= __("Update","icmanageinv");
					$columns["edit"] 	 		  = __("Edit","icmanageinv");
			}
			if ($product_type == "variation" ){
				//	$columns["product_id"] 		= __("product_id","icmanageinv");
					$columns["sku"] 			   = __("SKU","icmanageinv");
					$columns["product_name"] 	  = __("Product Name","icmanageinv");
					
					$columns["product_variation"] = __("Product Variation","icmanageinv");
					
					$columns["regular_price"] 	 = __("Regular Price","icmanageinv");
					$columns["sale_price"] 		= __("Sale Price","icmanageinv");
					$columns["stock"]			 = __("Stock","icmanageinv");
					$columns["stock_status"] 	  = __("Stock Status","icmanageinv");
					$columns["backorders"] 		= __("Back Orders","icmanageinv");
					$columns["manage_stock"] 	  = __("Manage Stock","icmanageinv");
					$columns["update"] 	 		= __("Update","icmanageinv");
					$columns["edit"] 	 		  = __("Edit","icmanageinv");
					
					
			}
			return $columns;
		
		}
		function get_meta_key($product_type="simple"){
			$meta_key = array();
			if ($product_type == "simple" ){
				$meta_key = array('_sku','_stock_status','_sale_price','_sale_price','_regular_price','_stock','_stock','_manage_stock','_backorders');
				
			}
			if ($product_type == "variable"){
				$meta_key = array('_sku','_stock_status','_sale_price','_sale_price','_regular_price','_stock','_stock','_manage_stock','_backorders');
			}
			if ($product_type == "variation"){
				$meta_key = array('_sku','_stock_status','_sale_price','_sale_price','_regular_price','_stock','_stock','_manage_stock','_backorders');
			}
			return $meta_key;
		}
		function get_dropdown_value($dropdown_name=''){
			$values = array();
			if ($dropdown_name == "backorders"){
				$values["no"]		=__("Do not allow","icmanageinv");
				$values["notify"]	=__("Allow, but notify customer","icmanageinv");
				$values["yes"]	   =__("Allow","icmanageinv");	
			}
			if ($dropdown_name == "manage_stock"){
				$values["no"]		=__("No","icmanageinv");
				$values["yes"]	   =__("Yes","icmanageinv");	
			}
			if ($dropdown_name == "stock_status"){
				$values["instock"]		=__("In stock","icmanageinv");
				$values["outofstock"]	   =__("Out of stock","icmanageinv");	
			}
			return $values;
			
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
		function get_pagination($total_pages = 50,$limit = 10,$adjacents = 3,$targetpage = "admin.php?page=RegisterDetail",$request = array()){		
				
				if(count($request)>0){
					unset($request['p']);
					//$new_request = array_map(create_function('$key, $value', 'return $key."=".$value;'), array_keys($request), array_values($request));
					//$new_request = implode("&",$new_request);
					//$targetpage = $targetpage."&".$new_request;
				}
				
				
				/* Setup vars for query. */
				//$targetpage = "admin.php?page=RegisterDetail"; 	//your file name  (the name of this file)										
				/* Setup page vars for display. */
				if(isset($_REQUEST['p'])){
					$page = $_REQUEST['p'];
					$_GET['p'] = $page;
					$start = ($page - 1) * $limit; 			//first item to display on this page
				}else{
					$page = false;
					$start = 0;	
					$page = 1;
				}
				
				if ($page == 0) $page = 1;					//if no page var is given, default to 1.
				$prev = $page - 1;							//previous page is page - 1
				$next = $page + 1;							//next page is page + 1
				$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
				$lpm1 = $lastpage - 1;						//last page minus 1
				
				
				
				$label_previous = __('previous', 'icwoocommerce_textdomains');
				$label_next = __('next', 'icwoocommerce_textdomains');
				
				/* 
					Now we apply our rules and draw the pagination object. 
					We're actually saving the code to a variable in case we want to draw it more than once.
				*/
				$pagination = "";
				if($lastpage > 1)
				{	
					$pagination .= "<div class=\"pagination\">";
					//previous button
					if ($page > 1) 
						$pagination.= "<a href=\"$targetpage&p=$prev\" data-p=\"$prev\">{$label_previous}</a>\n";
					else
						$pagination.= "<span class=\"disabled\">{$label_previous}</span>\n";	
					
					//pages	
					if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
					{	
						for ($counter = 1; $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>\n";
							else
								$pagination.= "<a href=\"$targetpage&p=$counter\" data-p=\"$counter\">$counter</a>\n";					
						}
					}
					elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
					{
						//close to beginning; only hide later pages
						if($page < 1 + ($adjacents * 2))		
						{
							for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>\n";
								else
									$pagination.= "<a href=\"$targetpage&p=$counter\" data-p=\"$counter\">$counter</a>\n";					
							}
							$pagination.= "...";
							$pagination.= "<a href=\"$targetpage&p=$lpm1\" data-p=\"$lpm1\">$lpm1</a>\n";
							$pagination.= "<a href=\"$targetpage&p=$lastpage\" data-p=\"$lastpage\">$lastpage</a>\n";		
						}
						//in middle; hide some front and some back
						elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
						{
							$pagination.= "<a href=\"$targetpage&p=1\" data-p=\"1\">1</a>\n";
							$pagination.= "<a href=\"$targetpage&p=2\" data-p=\"2\">2</a>\n";
							$pagination.= "...";
							for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>\n";
								else
									$pagination.= "<a href=\"$targetpage&p=$counter\" data-p=\"$counter\">$counter</a>\n";					
							}
							$pagination.= "...";
							$pagination.= "<a href=\"$targetpage&p=$lpm1\" data-p=\"$lpm1\">$lpm1</a>\n";
							$pagination.= "<a href=\"$targetpage&p=$lastpage\" data-p=\"$lastpage\">$lastpage</a>\n";		
						}
						//close to end; only hide early pages
						else
						{
							$pagination.= "<a href=\"$targetpage&p=1\" data-p=\"1\">1</a>\n";
							$pagination.= "<a href=\"$targetpage&p=2\" data-p=\"2\">2</a>\n";
							$pagination.= "...";
							for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>\n";
								else
									$pagination.= "<a href=\"$targetpage&p=$counter\" data-p=\"$counter\">$counter</a>\n";					
							}
						}
					}
					
					//next button
					if ($page < $counter - 1) 
						$pagination.= "<a href=\"$targetpage&p=$next\" data-p=\"$next\">{$label_next}</a>\n";
					else
						$pagination.= "<span class=\"disabled\">{$label_next}</span>\n";
					$pagination.= "</div>\n";		
				}
				return $pagination;
			
		}//End Get Pagination
		function update_stock(){
			$meta_key =  array("regular_price","sale_price","stock","sku","stock_status","backorders","manage_stock");
			$product_id	=	$this->get_request("product_id",0,true);
			$product_name	=	$this->get_request("product_name",'',true);
			
			foreach ($_REQUEST as $key => $value)  {
				//$test .= "Key =" .   $key . " Value =" .$value ."<br>";	
				if (in_array($key,$meta_key)){
					//$test .= "Key =" .   $key . " Value =" .$value ."<br>";	
					 update_post_meta($product_id, "_".$key, $value); 
				}
			}
			$product_post = array(
				  'ID'           => $product_id,
				  'post_title'   => $product_name,
			 );
		    wp_update_post( $product_post );
			//echo json_encode("Record has been updated successfully.");
			echo "Record has been updated successfully.";
			die;
		}
		function ajax(){
			$call=$this->get_request("call");
			if ($call=="ic_simple_product"){
				$this->ic_manage_simple_product();
			}
			if ($call =="ic_variable_product"){
				$this->ic_manage_variable_product();
			}
			if ($call =="ic_variation_product"){
				$this->ic_manage_variation_product();
			}
			die;
		}
	}
}