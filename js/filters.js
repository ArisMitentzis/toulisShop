
	// fortwnetai sto index kai sto page2
	
	// ananewnei tis vitrines me vash to filtro pou patithike
$('#filtersDiv').on('click', function(e){
	
	e.preventDefault();
	
	// metavlites pou kratoun ta marginStrings pou xrhsimopoiountai sth dhmiourgia kenwn vitrinwn
	// sto index einai koino kai gia last kai gia pop
	// sto page2 poikilloun 
	var marginString;
	var marginString_left;
	var marginString_right;
	

	//mazeuei oles tis vitrines
	var $vitrines = $(this).parent().parent().find('.vitrinaDiv'); 
	
	// var gia na krathsei to string ths ajax call sto async_pagination.php
	var urlString;
	var urlSuffixString='';
	
	// krataei ton kvdiko tou tupou pou klikaristhke
	var typeValue = $(e.target).attr('data-typeCode');
		
	urlSuffixString = 'page' + '=' + 0;
		
	// an den epilexthike to "Ola"
	if (typeValue != -1){
			
		urlSuffixString += '&' + 'type' + '=' + typeValue;
	}
		
	
	
	urlString = "async_pagination.php?" + urlSuffixString;
	
	marginString_left = "mr-2";
	marginString_right = "ml-2 mr-n5";
	
	// ypologismos ths maxPage gia ton neo typo pou epilexthike kai enhmerwsh sto pagination
	//var maxPage;
	
	function updateMaxPage (data){
		
		var maxPage = data;
			
		$('.pagination').attr('data-maxPage',maxPage);
	}
	
	// kalei to async_getMaxPage.php
	ajaxCallerWithSuccessFunction ("GET",rootFolderOfAsyncPhp + 'async_getMaxPage.php?type=' + typeValue,updateMaxPage);
	
	// vale sto pagination ws endeiksh selidas to 1
	var $vitrinaPage = $(this).parent().parent().find('.vitrinaPage'); 
	$vitrinaPage.val('1');
	
	// enhmerwse to attribute toy ekswterikou div ths listas typwn pou krata to typecode tou active typoy 
	$('#filter_div').attr('data-type',typeValue);
	
	// enhmerwse kai ton xrwmatismo active-inactive typwn sth lista typwn me vash thn epilogh toy xrhsth
	$('a[data-typeCode]').css('background-color','#e9d28c');
	$(e.target).css('background-color','#f0ad4e');
	
	
	// kane update tis vitrines
	function updateVitrines (data){
		
		//metatrepse to JSON (morfh array me objects-products) se js array me js objects
		// sthn php einai array me indexes (proionta) poy periexei se kathe thesh 1 assoc array me tis info twn proiontwn
		var myAr = JSON.parse(data);
			
			// diatrexetai o pinakas twn proiontwn
			for(i=0; i<myAr.length; i++){
				
				// an sto sygkekrimeno index den yparxei proion,kane hide thn arxikh vitrina kai dhmiourghse kenh vitrina  
				// kai dwse to katallhlo marginString me vash th thesh
				if (myAr[i] === 'empty'){
					
					$($vitrines[i]).hide();
					
					if (i==0 || i==2){
						
						marginString=marginString_left;
					}
					else{
						
						marginString=marginString_right;
					}
					
					$($vitrines[i]).parent().append("<div class='col " + marginString + "' data-role='filler'></div>");
				}
				// alliws, an sto sygkekrimeno index yparxei proion, enhmerwse tis plhrofories tou proiontos autou 
				// toy iindex
				else {
						
					$($vitrines[i]).show();
					$($vitrines[i]).parent().find("[data-role='filler']").remove();
					
					$($vitrines[i]).find('#prodCode_' + i).val(myAr[i].prodcode);
					$($vitrines[i]).find('#prodName_' + i).val(myAr[i].prodname);
					$($vitrines[i]).find('#prodNameP_' + i).text(myAr[i].prodname);
					$($vitrines[i]).find('#prodDescreption_' + i).text(myAr[i].proddescription);
					$($vitrines[i]).find('#prodPic_' + i).attr('src','images\\products\\' + myAr[i].prodpic);
					$($vitrines[i]).find('#prodValue_' + i).val(myAr[i].prodvalue);
					$($vitrines[i]).find('#quantity_' + i).val(myAr[i].quantity);
					$($vitrines[i]).find('#quantity_' + i).attr('max',myAr[i].prodstock);
					$($vitrines[i]).find('#prodStock_' + i).val(myAr[i].prodstock);
				}
			}
	}
	
	// kalei to async_pagination.php
	ajaxCallerWithSuccessFunction ("GET",rootFolderOfAsyncPhp + urlString,updateVitrines);
	
	// xtisimo toy neou url ths selidas kai ananewsh
	
	var newUrl = 'page2.php';
	var newUrlSuffix = '?' + urlSuffixString;
	
	history.pushState({id: 'SOME ID'}, '',newUrl + newUrlSuffix);
});
	