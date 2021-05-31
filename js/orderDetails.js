
$(document).ready(function() {
    
	$('tr').each(function(){
	
		var currentQuantityValue = parseInt($(this).find('.tdQuantity').text());
		var $currentTdStock = $(this).find('.tdStock');
		var currentStockValue = parseInt($currentTdStock.text());
		
		if (currentQuantityValue > currentStockValue){
			
			$currentTdStock.css('background-color','red');
		}
	});
});





