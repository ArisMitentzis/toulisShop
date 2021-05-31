
	// fortwnetai sto list_delete_product
	
	
	// otan o xrhsths pataei kapoio apo ta koumpia "delete" 
	// ston pinaka pou apeikonizei ta proionta
	// tote sbhnetai ston DB pinaka PRODUCTS to sygkekrimeno proion
	// kai enhmerwnetai o pinakas poy apeikonizei ta proionta
	
$('.delProduct').on('click', function(e){
	
	e.preventDefault();
	
	// tsimpa to row poy einai gia svhsimo
	var $rowΤοDelete = $(this).parent().parent().parent();
	// tsimpa to product id poy einai gia svhsimo
	var currentProdcode = $rowΤοDelete.find('.prodCode').text();
	
	// kalei to async_list_delete_product.php pou tha svhsei ston DB pinaka PRODUCTS to sygkekrimeno proion
	ajaxCaller ("GET","async_list_delete_product.php?" + "del=" + currentProdcode);
	
	// ginetai delete h epilegmenh row ston pinaka me ta proionta
	$rowΤοDelete.remove();
	
	//$('#board').text($rowΤοDelete.html());
	
	//$('#productTable').DataTable().ajax.reload();
	//$('#productTable').DataTable().clear().draw();
	
	$('#productTable').destroy();
	$('#productTable').DataTable();
	
	//$('#productTable').DataTable().clear();
	//$('#productTable').DataTable().draw();
	//$rowΤοDelete.remove().draw( false );
	
	//$('#productTable').draw(true);
	
	//$('#productTable')
    //.rows()
    //.invalidate()
    //.draw();
});



