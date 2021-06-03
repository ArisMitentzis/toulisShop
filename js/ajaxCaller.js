
	// fortwnetai se oses selides kanoun ajax call
	
	var rootFolderOfAsyncPhp = "/toulisShop/asyncPhp/";
	
	//var rootFolderOfAsyncPhp = "";
	
	function ajaxCaller (callType,urlString){
		
		$.ajax({
			
			type:callType,
			url: urlString,
			error: function(){
				$('#board').text('error');
			},
			complete: function(){
				//$('#board').text('complete'); 
			}
		});
	}
	
	function ajaxCallerWithDataArgumentString (callType,urlString,dataArgumentString){
		
		$.ajax({
			
			type:callType,
			url: urlString,
			data: dataArgumentString,
			error: function(){
				$('#board').text('error');
			},
			complete: function(){
				//$('#board').text('complete'); 
			}
		});
	}
	
	function ajaxCallerWithSuccessFunction (callType,urlString,successFunction){
		
		$.ajax({
			
			type:callType,
			url: urlString,
			success: function(data){
				successFunction(data); 
			},
			error: function(){
				$('#board').text('error');
			},
			complete: function(){
				//$('#board').text('complete'); 
			}
		});
	}
	
	function ajaxCallerWithDataArgumentString_SuccessFunction (callType,urlString,dataArgumentString,successFunction) {
		
		$.ajax({
			
			type:callType,
			url: urlString,
			data: dataArgumentString,
			success: function(data){
				successFunction(data); 
			},
			error: function(){
				//$('#board').text('error');
			},
			complete: function(){
				//$('#board').text('complete'); 
			}
		});
	}
	
	
	
	


	