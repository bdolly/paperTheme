/******************************************************************
Site Name:
Author: TPD Desgin House

Javascript: Custom Javascript

This is setup for your to write custom js using the revelaing module pattern 
http://weblogs.asp.net/dwahlin/techniques-strategies-and-patterns-for-structuring-javascript-code-revealing-module-pattern

******************************************************************/
/* =======================================================================
	Global Variables
========================================================================== */
var globalVar;



// anonymous wrapper function depends on JQuery being loaded first
(function($){
	/* =======================================================================
	Private Variables
	========================================================================== */
	var logging = true,
		// get "type-* " class and push to array,
		postType_class = ($('.site-main article').length && $('.site-main article').attr('class').match(/(type-)\w+/g) ) ? $('.site-main article').attr('class').match(/(type-)\w+/g)[0].split('-') : {};

	// helpful logging functions
	var paperTheme_log = function(message){ if(logging === true){console.log('paperTheme LOG: '+ message);} },
	 	paperTheme_json_log = function(message, jsnObj){
	 	 					if(logging === true){
	 	 						console.log('paperTheme JSON LOG: '+ message+': '+JSON.stringify(jsnObj,undefined,2 ) );
	 	 					}
	 	 				};


	/* =======================================================================
		MODULE FUNCTIONALITY DESCRIPTION HERE
	========================================================================== */
	// set custom jsModule declaration
	var jsModule = (function($){
		// private jsModule() variables
		var privateVar;

		function jsModule_function(){
			try{
				// **************************
				// code to execute goes here
				// **************************
			}catch(ex){console.log('jsModule_function(): ' + ex); }
		}// end jsModule_function()

		// return jsModule initilaztion method (jsModule.init)
		// to anonymous wrapper function scope
		return{ 
			init: function(){
				jsModule_function();
			}
		};

	 })($);//end jsModule module





	 /* =======================================================================
	AJAX - Category Navigation loading
	========================================================================== */
	var wpAJAX = (function($){
		// private jsModule() variables
		

		function request(requestType ,postData, onSuccess, onError ){
			try{
				var request_type = requestType.toUpperCase();

				$.ajaxSetup({cache:false});
					// AJAX POST request breakdown
					// url:
					//  -- send AJAX POST request to admin-ajax.php set as global var by localize-script in functions.php
					// data:{ action: 
					// 		  -- make sure "action" is set to the same add_action as in "add_action( 'wp_ajax_nopriv_ACTION-GOES-HERE', 'ACTION-GOES-HERE' );	"
					
					$.ajax({
						type:request_type ,
						url: LocalAJAX.url,
						data:postData,
					})
					.done(function(data){
		        		if(typeof onSuccess === "function"){ onSuccess(data);}

		        		if(typeof data === "object"){ 
		        			paperTheme_json_log("Success JSON Data: ", data );
		        		}else{
		        			paperTheme_log("Success Data: "+ data );
		        		}	
						
					})
					.fail(function(jqXHR, textStatus, errorThrown) {
                	    paperTheme_log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                	    if(typeof onError === "function"){ onError(jqXHR, textStatus, errorThrown);}
                	});
			}catch(ex){console.log("wpAjax.request("+request_type+"):"+ ex);}
		}//post()
			
	
		return{  request: request };

	 })($);//end wpAJAX module



	 

	/* =======================================================================
		Initialize Modules
	========================================================================== */
	jsModule.init();

	// example admin-ajax request
	wpAJAX.request('GET',{
	 		action: 'lazyLoad_request', 
	 		post_type:'post', 
	 		page_no: 1,
	 		posts_per: 3,
	 		cat_name: 'uncategorized',
	 		tag_name: 'tag',
	 		search_term: 'search term here'
	 	}, 
	 	function(){
	 	// success callback
	 	paperTheme_log('ajax call successful');
	 });

	


}($));//end anonymous wrapper function