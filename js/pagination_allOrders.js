
// fortwnetai sta allOrders,list_delete_product,allUsers,myOrders

// allazei page, ananewnei ton vasiko pinaka twn selidwn,enhmerwnei to url (xwris refresh) 
$('.pagination').on('click', function(e){
	
	e.preventDefault();
	
	//krataei th zhtoymenh energeia (next h previous)
	var action = $(e.target).text();
	
	
	// krataei to max index gia to sygkekrimeno pinaka
	var maxPage = $(this).attr('data-maxPage');
	
	//alert (maxPage);
	
	//twrinh page (ksekinwntas apo 1)
	var $page = $(e.target).parent().parent().find('.vitrinaPage');
	// twrino index tou pinaka (ksekinwntas apo 0)
	var pageNumber = $page.val() -1;
	
	//alert (pageNumber);
	
	// ypologizei to neo index page (ksekinwntas apo 0)
	// an einai hdh sth selida 1 kai exei zhththei "previous" h an vrisketai sth max selida
	// kai exei zhththei "next", epistrefei.
	if (action === 'Next' && pageNumber < maxPage){
		pageNumber++;
	}
	else if(action === 'Previous' && pageNumber > 0){
		pageNumber--;
	}
	else {
		
		return;
	}
	
	//alert (pageNumber);
	
	
	// phgainei sto div tou pagination
	var $vitrinaWithChangedPage = $(this).parent();
	// tsimpa to eidos tou row (allOrders,list_delete_product,allUsers,myOrders) pou afora to pagination
	var currentPage = $vitrinaWithChangedPage.attr('data-pagination');
	
	
	var $tBody = $('#tableDiv').find('tbody');
	
	//$tBody.remove();
	
	// xtisimo tou url gia thnn ajax call
	var urlString;
	
	// xtisimo tou urlSuffixString, dhladh ths katalhkshs (periexei tis GET parametrous pou tha 
	// kollhthoun sto url tou ajax call)
	
		
	var urlSuffixString = 'page' + '=' + pageNumber;
	urlSuffixString += '&currentPage' + '=' + currentPage;
	
	// an prokeitai gia to myOrders prepei na steilw kai to userCode tou xrhsth
	if (currentPage === 'myOrders'){
		
		urlSuffixString += '&userCode' + '=' + $('#tableDiv').attr('data-usercode');
	}
	
	var urlString = "async_echoTable.php?" + urlSuffixString;
	
	// ananewse tto vasiko pinaka
	function updateTable (data){
		
		$page.val(pageNumber +1);
			
		$tBody.html(data);
	}
	
	// kalei to async_pagination.php
	ajaxCallerWithSuccessFunction ("GET",rootFolderOfAsyncPhp + urlString,updateTable);
	
	
	// ananewnei to url xwris refresh
	history.pushState({id: 'SOME ID'}, '',currentPage + ".php?" + "page=" + pageNumber);
});
	