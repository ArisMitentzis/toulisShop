
 
$('form').on('submit', function (e) {    
	  
	  var isZero = parseInt($('#totalValue').attr('data-totalValue')) === 0;
	  var hasAgreed = $('#agree').prop('checked');
	  
	  if (hasAgreed && !isZero){
		  
		  $('#agree_msg').hide();
		  $('#totalValue_msg').hide();
	  }
	  else{
		  
		  $('#agree_msg').hide();
		  $('#totalValue_msg').hide();
		  
		  if (!hasAgreed){
			  
			  $('#agree_msg').show();
		  } 
		  
		  if(isZero){
			  
			  $('#totalValue_msg').show();
		  }
		  
		  e.preventDefault();
	  }
});
	


agree_msg
totalValue_msg