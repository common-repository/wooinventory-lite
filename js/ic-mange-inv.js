// JavaScript Document
var product_id = 0;
var product_name = '';
var regular_price = 0;
var sale_price = 0;
var stock = 0;
var sku   ='';
var stock_status = '';
var backorders = '';
var manage_stock = '';
var from_name ='';
jQuery(document).ready( function($) {
	//alert("dsad");
	$("#frm_simple_stock,#frm_variable_stock,#frm_variation_stock").submit(function(e) {
		  // This does the ajax request
		  //ic_taxt_report_ajax_object
		  //ic_taxt_report_ajax_url
		//	alert(ic_taxt_report_ajax_object.ic_taxt_report_ajax_url);
		//alert("dsad");
		//return false;
			$.ajax({
				url: ajaxurl,
				data:$($(this)).serialize(),
				success:function(data) {
					// This outputs the result of the ajax request
					console.log(data);
					//alert(data);
					$("._ic_data").html(data);
				},
				error: function(errorThrown){
					console.log(errorThrown);
					alert(JSON.stringify(errorThrown));
				}
			});  

		e.preventDefault();
	});
	
	//pagination
	$(document).on("click",".pagination a",function(e) {
		p = $(this).attr("data-p")
		$("._page").val(p);
		//alert($(".from_name").val());
		from_name = $(".from_name").val();
		//alert(from_name);
		//$( "#frm_simple_stock" ).trigger( "submit" );
		//$( "#".from_name ).trigger( "submit" );
		
		if (from_name=="frm_simple_stock"){
			$( "#frm_simple_stock" ).trigger( "submit" );
		}
		if (from_name=="frm_variable_stock"){
			$( "#frm_variable_stock" ).trigger( "submit" );
		}
		if (from_name=="frm_variation_stock"){
			$( "#frm_variation_stock" ).trigger( "submit" );
		}
		return false;
		
	});
	$( "#frm_simple_stock,#frm_variable_stock,#frm_variation_stock" ).trigger( "submit" );
	
	
	
	
	//alert(ic_taxt_report_ajax_object.ic_taxt_report_ajax_url);
	$(document).on("click","._update_inv",function(){
		//alert($(this).data("product_id"));
		//alert($(this).parent().parent().html());
		product_id			 = $(this).data("product_id");
		sku 					= jQuery(this).parent().parent().find("._sku").val();
		product_name 		   = jQuery(this).parent().parent().find("._product_name").val();	
		regular_price 		  = jQuery(this).parent().parent().find("._regular_price").val();	
		sale_price 		  	 = jQuery(this).parent().parent().find("._sale_price").val();
		stock 		  		  = jQuery(this).parent().parent().find("._stock").val();
		stock_status 		   = jQuery(this).parent().parent().find("._stock_status").val();
		backorders 		  	 = jQuery(this).parent().parent().find("._backorders").val();
		manage_stock 		   = jQuery(this).parent().parent().find("._manage_stock").val();		
	    
		update_stock();
		
		return false;
	});
	function update_stock(){
		$.ajax({
			url:ic_taxt_report_ajax_object.ic_taxt_report_ajax_url,
			data: {
				'action'			: 'ic_mange_inv_lite',
				'sub_action' 		: 'ic_update_stock',
				'product_id' 		: product_id,
				'sku' 			   : sku,
				'regular_price'     : regular_price,
				'sale_price' 	    : sale_price,
				'stock' 			 : stock,
				'stock_status'      : stock_status,
				'backorders' 	    : backorders,
				'manage_stock' 	  : manage_stock,
				'product_name' 	  : product_name,
			},
			success:function(response) {
				//var obj = JSON.parse(response);
			//	alert(JSON.stringify(response));
				$("._ic_message").html(response);
			},
			error: function(errorThrown){
				console.log(errorThrown);
				alert("e2");
			}
		}); 
		
		return false;
	}
});