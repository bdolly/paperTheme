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
	var logging = false;

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
		Initialize Modules
	========================================================================== */
	jsModule.init();


}($));//end anonymous wrapper function