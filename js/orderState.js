/*
$(document).ready(function() {
    
	$('.orderNow').hide();
} );
*/	
$('.stateSelect').on('change', function (e) { 

	function stockAlert (data){
	
		$('#board').text(data); 
		
		if (data.trim() == 'false'){
			
			//alert('false');
			
			$('#board').text(data); 
			$currentSelect.val(oldStateValue);
			$currentSelect.closest('tr').find('.orderNow').show();
			$currentSelect.closest('tr').find('.orderNow').parent().removeClass('btn-info');
			$currentSelect.closest('tr').find('.orderNow').parent().addClass('btn-danger');
			
		}
		else{
			//alert('true');
			$('#board').text(data); 
			$currentSelect.attr('data-initValue',newStateValue);
			$currentSelect.closest('tr').find('.orderNow').hide();
			$currentSelect.closest('tr').find('.orderNow').parent().addClass('btn-info');
			$currentSelect.closest('tr').find('.orderNow').parent().removeClass('btn-danger');
		}
	}

	var $currentSelect = $(this);
	
	var oldStateValue = $currentSelect.attr('data-initValue');
	var newStateValue = $currentSelect.val();
	var currentOrderCode = $currentSelect.closest('tr').find('.orderCodeTd').text();
	
	ajaxCallerWithSuccessFunction ("GET",rootFolderOfAsyncPhp + 'async_changeOrderState.php?orderCode=' + currentOrderCode + '&oldState=' 
															+ oldStateValue + '&newState=' + newStateValue,stockAlert);
});





