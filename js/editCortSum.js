
	// fortwnetai sto page3
	
	// ginetai update h endeiksh pou afora to kalathi sto header
	function updateCartHeader(data) {
		
		$('#cartHlineSmall').text(data); 
	}
	
	// ginetai update h endeiksh tou sunolikou posou agoras poy emfanizetai akrivws katw apo ton pinaka tou kalathioy
	function updateCortArrayTotalValue(data) {
		
		$('#totalValue').text("Κόστος Παραγγελίας: " + data + " €");
		$('#totalValue').attr('data-totalValue',data.trim());
	}
	
	// otan o xrhsths pataei kapoio apo ta koumpia "delete" 
	// ston pinaka pou apeikonizei ta periexomena tou kalathiou
	// tote sbhnetai sto session kalathi to sygkekrimeno proion
	// kai enhmerwnetai o pinakas poy apeikonizei to kalathi
	// Epishs, enhmerwnetai h endeiksh tou kalathiou sto header kai to synoliko xrhmatiko poso 
	// poy emfanizetai katw apo ton pinaka toy kalathiou
$('.delProduct').on('click', function(e){
	
	e.preventDefault();
	
	var $aElement = $(e.target).parent();
	// tsimpa to product id poy einai gia svhsimo
	var productId = $aElement.attr('data-productId');
	// to row tou pinaka pou einai na svhstei
	var $rowToDelete = $aElement.parent().parent();
	
	// kalei to async_editCortSum.php pou tha svhsei apo to session kalathi to sygkekrimeno product
	ajaxCaller ("GET","async_editCortSum.php?" + "del=" + productId);
	
	// ginetai delete h epilegmenh row
	$rowToDelete.remove();
	
	// ginetai update h endeiksh pou afora to kalathi sto header
	ajaxCallerWithSuccessFunction ("POST","async_cortHline.php",updateCartHeader);
	
	// ginetai update h endeiksh tou sunolikou posou agoras poy emfanizetai akrivws katw apo ton pinaka tou kalathioy
	ajaxCallerWithSuccessFunction ("POST","async_cortArrayTotalValue.php",updateCortArrayTotalValue);
});

// otan allazei h posothta enos proiontos tou kalathiou
// tote elegxetai an yparxei apoklish apo thn arxikh posothta
// kai an nai tote energopoieitai to koumpi -> to opoio ananewnei mono to sygkekrimeno row
$('.quantityInput').on('change', function(e){
	
	var $quantityElement = $(this);
	
	var $editIcon = $quantityElement.parent().parent().find('.editProduct').children();
	
	// an h twrinh axia einai diaforetikh apo ayth pou einai kataxwrhmenh sto session kalathi gia auto to proion
	if ($quantityElement.attr('data-initQuantity') !== $quantityElement.val()){
	
		// kane to koumpi tou edit energo
			$editIcon.css({
			
				"color":"blue",
				"cursor":"pointer"
			});
		}
		// alliws kane to anenergo 
		else{
	
			$editIcon.css({
			
			"color":"grey",
			"cursor":"default"
			});
		}
});

// otan o xrhsths pataei kapoio apo ta koumpia "edit" 
// ston pinaka pou apeikonizei ta periexomena tou kalathiou
// tote ananewnetai sto session kalathi h posothta tou sygkekrimenou proiontos
// kai enhmerwnetai o pinakas poy apeikonizei to kalathi
// Epishs, enhmerwnetai h endeiksh tou kalathiou sto header kai to synoliko xrhmatiko poso 
// poy emfanizetai katw apo ton pinaka toy kalathiou
$('.editProduct').on('click', function(e){
	
	e.preventDefault();
	
	// to eikonidio tou edit
	var $editIcon = $(this).children();
	
	//o current kwdikos proiontos
	var productCode = $(this).val();
	
	// to current quantity element
	var $quantityElement = $(this).closest('tr').find('.quantityInput');
	
	// h nea posothta gia to current proion
	var newQuantity = $quantityElement.val();
	
	// enhmerwse kai thn initial posothta (xrhsh gia toggling tou edit button apo active se inactive)
	$quantityElement.attr('data-initquantity',newQuantity);
	
	// to string me tis POST metablhtes pou tha xrhsimopoihthoun sto ajax call
	var argumentString = 'edt=' + productCode + '&newQuantity=' + newQuantity;
	
	// kalei to async_editCortSum.php pou tha ananewsei sto session kalathi thn posothta tou sygkekrimenou product
	ajaxCallerWithDataArgumentString ("POST","async_editCortSum.php",argumentString);
	
	// ginetai update h endeiksh pou afora to kalathi sto header
	ajaxCallerWithSuccessFunction ("POST","async_cortHline.php",updateCartHeader);
	
	// ginetai update h endeiksh tou sunolikou posou agoras poy emfanizetai akrivws katw apo ton pinaka tou kalathioy
	ajaxCallerWithSuccessFunction ("POST","async_cortArrayTotalValue.php",updateCortArrayTotalValue);
	
	//kane to koumpi edit inactive
	$editIcon.css({
			
			"color":"grey",
			"cursor":"default"
			});
});