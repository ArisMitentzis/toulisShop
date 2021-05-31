
	// fortwnetai mono sto index

	// otan sto index emafanizetai to idio proion sto pop row kai sto last row,sygxronizei stis endexomenes 
	// allages to quantity tous
	
	// to event afora allagh sta input posothtas twn proiontwn
$('.quantityInput').on('change', function(e){
	
	// tsimpaei to div pou ylopoiei th vitrina proiontos sthn opoia allaxthike h posothta
	var $changedVitrinaDiv = $(this).closest('.vitrinaDiv');
	
	// tsimpaei to eidos ths vitrinas pou egine h allagh (last_page h pop_page)
	var changedRow = $changedVitrinaDiv.attr('data-vitrina');
	
	// tsimpaei ton kwdiko proiontos ths vitrinas sthn opoia egine h allagh quantity
	var changedProdCode = $changedVitrinaDiv.find('.productCodeInput').val();
	
	// tsimpaei th nea posothta ths vitrinas sthn opoia egine h allagh quantity
	var changedProdQuantity = $changedVitrinaDiv.find('.quantityInput').val();
	
	// to eidos tou row me vitrines (pop_page h last_page) sto opoio prepei na psaksei gia pithanh uparksh tou idioy proiontos
	// tou opoiou to quantity prepei na sygxronistei
	var rowForSearch;
	
	if (changedRow == 'pop_page'){
		rowForSearch = 'last_page';
	}
	else{
		rowForSearch = 'pop_page';
	}
	
	// jQ selection me tis vitrines stis opoies tha psaksei gia pithanh uparksh tou idioy proiontos
	// tou opoiou to quantity prepei na sygxronistei
	var $vitrinesForSearch = $('.vitrinaDiv[data-vitrina=' + rowForSearch + ']');
	
	$vitrinesForSearch.each(function(){
		
		// checkpoint - just testing
		//$('#board').append($(this).find('.productCodeInput').val());
		//$('#board').append('-');
		
		// An vreis ton kwdiko tou proiontos tou opoiou h posothta allaxthike enhmervse to quantity wste na sugxronistoun
		if($(this).find('.productCodeInput').val() == changedProdCode){
			
			$(this).find('.quantityInput').val(changedProdQuantity);
		}
	});
});
	