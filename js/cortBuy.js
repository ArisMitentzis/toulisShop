
	// fortwnetai sto index kai sto page2
	
	// otan o xrhsths pataei kapoio apo ta koumpia "prosthiki sto kalathi"
	// tote enhmervnontai sto session kalathi oi posothtes tvn proiontwn pou exoyn allaxthei
	// me ena klik se opoiodhpote koumpi kalathiou ths selidas enhmerwnontai oles oi allages 
	// sta proionta pou emfanizontai
	// Epishs, enhmerwnetai h endeiksh tou kalathiou sto header

	// to event afora klik se koumpia kalathiou
	
	//var rootOfAsyncPhp = "/toulisShop/asyncPhp/"
	
$('.buyButton').on('click', function(e){
	
	e.preventDefault();
	
	var typeCode = $('#cortForm').attr('data-userType');
	
	if (typeCode == 0){
		location.replace("sign_in.php");
	}
	
	// tsimpaei ta stoixeia ths formas - profanws osa exoyn name attribute - (periexei tis vitrines me ta proionta)
	var ser = $('#cortForm').serialize();
	
	// kalei to async_cort.php pou tha enhmerwsei to session-kalathi
	ajaxCallerWithDataArgumentString ("POST",rootFolderOfAsyncPhp + "async_cort.php",ser);
	
	// lambanei to neo keimeno (apo thn ajax call sto async_cortHline) pou prepei na fanei sthn endeiksh tou kalathiou 
	// sto header kai ananewnei to keimeno
	function updateCartHeader(data) {
		
		$('#cartHlineSmall').text(data); 
	}
	
	// kalei to async_cortHline.php pou tha enhmerwsei to keimeno ths endeikshs tou kalathiou 
	// sto header 
	ajaxCallerWithSuccessFunction ("POST",rootFolderOfAsyncPhp + "async_cortHline.php",updateCartHeader);
});


	