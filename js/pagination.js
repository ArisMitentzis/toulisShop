
// fortwnetai sto index kai sto page2

// ananewnei thn katallhlh seira me vitrines (kanei update tis info twn vitrinwn tou row) 
$('.pagination').on('click', function(e){
	
	e.preventDefault();
	
	// xrhsimeuei mono sto index. Ekei exw 2 triades apo proionta kai thelw ta id tous na lhgoun se 0-5
	// opote h deuterh triada tha einai 0+3=3,1+3=4,2+3=5
	var plusInIdIndexes =0;
	
	// metavlites pou kratoun ta marginStrings pou xrhsimopoiountai sth dhmiourgia kenwn vitrinwn
	// sto index einai koino kai gia last kai gia pop
	// sto page2 poikilloun 
	var marginString;
	var marginString_left;
	var marginString_right;
	
	//krataei th zhtoymenh energeia (next h previous)
	var action = $(e.target).text();
	
	// krataei to max index gia th sugkekrimenh row me proionta (ksekina apo 0)
	var maxPage = $(this).attr('data-maxPage');
	
	//twrinh page (ksekinwntas apo 1)
	var $page = $(e.target).parent().parent().find('.vitrinaPage');
	// twrino index ths row proiontwn (ksekinwntas apo 0)
	var pageNumber = $page.val() -1;
	
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
	
	// phgainei sto div tou pagination
	var $vitrinaWithChangedPage = $(this).parent();
	// tsimpa to eidos tou row (pop_page h last_page gia to index,type gia to page2) pou afora to pagination
	var changedRow = $vitrinaWithChangedPage.attr('data-pagination');
	
	
	
	//mazeuei oles tis vitrines
	var $vitrines = $vitrinaWithChangedPage.parent().find('.vitrinaDiv'); 
	var $vitrinesForChange=$vitrines;
	// an prokeitai gia to index epilegei tis vitrines tou swstou row (pop_page h last_page)
	// to page2 exei ena pagination mono - opote den to afora auto to vhma
	if (changedRow !== 'type'){
		$vitrinesForChange = $vitrines.filter('[data-vitrina=' + changedRow + ']');
		
		
	}
	
	// xtisimo tou url gia thnn ajax call
	var urlString;
	var urlSuffixString='';
	
	// an prokeitai gia thn katw seira (popular products) tou index
	// ta product id tha einai apo 3 ews 5
	if (changedRow === 'pop_page'){
		
		plusInIdIndexes =3;
	}
	
	// xtisimo tou urlSuffixString, dhladh ths katalhkshs (periexei tis GET parametrous pou tha 
	// kollhthoun sto url tou ajax call)
	
	// an prokeitai gia th page2 - emfanish proiontwn ana typo 
	// to changedRow exei thn timh 'type'
	if (changedRow === 'type'){
		
		var typeValue = $('#filter_div').attr('data-type');
		
		// parametros "page" pernietai aneksarthtos an exei epilegei sygkekrimenos typos h "ola"
		// kai ws value exei to neo index poy exei zhththei
		urlSuffixString = 'page' + '=' + pageNumber;
		
		// an den exei epilegei to "Ola" sth lista typwn
		// tote to typeValue exei ton kwdiko epilegmenou typoy 
		// an exei epilegei to ola tote den tha perastei parametros GET me key "type"
		if (typeValue != -1){
			
			urlSuffixString += '&' + changedRow + '=' + typeValue;
		}
	}
	
	// an prokeitai gia to index - emfanish proiontwn last h pop
	// to changedRow tha exei value -> last_page h pop_page
	// to pageNumber krataei to neo index
	else{
		urlSuffixString = changedRow + "=" + pageNumber;
		
	}
	
	urlString = "async_pagination.php?" + urlSuffixString;
	
	
	// dinontai ta katallhla values sta margins analoga me to an afora index h page2
	if (changedRow === 'pop_page' || changedRow === 'last_page'){
		marginString = "mr-4";
	}
	else{
		marginString_left = "mr-2";
		marginString_right = "ml-2 mr-n5";
	}
	
	// ananewse ta products sth sxetikes vitrines
	function updateProducts (data){
		
		$page.val(pageNumber +1);
			
		//metatrepse to JSON (morfh array me objects-products) se js array me js objects
		// sthn php einai array me indexes (proionta) poy periexei se kathe thesh 1 assoc array me tis info twn proiontwn	
		var myAr = JSON.parse(data);
			
		var idIndex;
		
		// diatrexetai o pinakas twn proiontwn	
		for(i=0; i<myAr.length; i++){	
			
			// edw prostithetai timh 3 mono an afora to index kai to row twn pop products
			idIndex = i + plusInIdIndexes;
				
			// an sto sygkekrimeno index den yparxei proion,kane hide thn arxikh vitrina kai dhmiourghse kenh vitrina  
			// kai dwse to katallhlo marginString me vash th thesh	
			if (myAr[i] === 'empty'){
					
				$($vitrinesForChange[i]).hide();
					
				if (i==0 || i==2){
						
					marginString=marginString_left;
				}
				else{
						
					marginString=marginString_right;
				}
					
				$($vitrinesForChange[i]).parent().append("<div class='col " + marginString + "' data-role='filler'></div>");
					
			}
			// alliws, an sto sygkekrimeno index yparxei proion, enhmerwse tis plhrofories tou proiontos autou 
			// toy iindex
			else {
					
				if (pageNumber === (maxPage-1)){
						
						$($vitrinesForChange[i]).show();
						
						$($vitrinesForChange[i]).parent().find("[data-role='filler']").remove();
				}
					
				$($vitrinesForChange[i]).find('#prodCode_' + idIndex).val(myAr[i].prodcode);
				$($vitrinesForChange[i]).find('#prodName_' + idIndex).val(myAr[i].prodname);
				$($vitrinesForChange[i]).find('#prodNameP_' + idIndex).text(myAr[i].prodname);
				$($vitrinesForChange[i]).find('#prodDescreption_' + idIndex).text(myAr[i].proddescription);
				$($vitrinesForChange[i]).find('#prodPic_' + idIndex).attr('src','images\\products\\' + myAr[i].prodpic);
				$($vitrinesForChange[i]).find('#prodValue_' + idIndex).val(myAr[i].prodvalue);
				$($vitrinesForChange[i]).find('#quantity_' + idIndex).val(myAr[i].quantity);
				$($vitrinesForChange[i]).find('#quantity_' + idIndex).attr('max',myAr[i].prodstock);
				$($vitrinesForChange[i]).find('#prodStock_' + idIndex).val(myAr[i].prodstock);
			}
		}
	}
	
	// kalei to async_pagination.php
	ajaxCallerWithSuccessFunction ("GET",urlString,updateProducts);
	
	
	// xtisimo toy neou url ths selidas kai ananewsh
	
	// krataei to form element
	var $cortForm = $vitrinaWithChangedPage.parent();
	//krataei ta div twn pagination
	var $allRows = $cortForm.find("div[data-pagination]");
	var newUrl;
	var newUrlSuffix;
	
	// an prokeitai gia to index
	if (changedRow !== 'type'){
		
		var lastPageValue;
		var popPageValue;
		var currentVitrinaTypeString;
		var currentNotChangedPageNumber;
	
		$allRows.each(function(){
			
			currentVitrinaTypeString= $(this).attr('data-pagination');
		
			if (currentVitrinaTypeString === changedRow){
			
				if (currentVitrinaTypeString === 'last_page'){
				
					lastPageValue = pageNumber;
				}
				else{
				
					popPageValue = pageNumber;
				}
			
				//$('#board').text($(this).attr('data-pagination'));
				//break;
			}
		
			else {
				
				currentNotChangedPageNumber = ($(this).find('.vitrinaPage').val())-1;
			
				if (currentVitrinaTypeString === 'last_page'){
				
					lastPageValue = currentNotChangedPageNumber;
				}
				else{
				
					popPageValue = currentNotChangedPageNumber;
				}
			
				//$('#board').text($(this).attr('data-pagination'));
				//break;
			}
		
			//$('#board').text("?last_page=" + lastPageValue + "&pop_page=" + popPageValue);
			newUrlSuffix = "?last_page=" + lastPageValue + "&pop_page=" + popPageValue;
			
			newUrl = "index.php";
		});
	}
	// an prokeitai gia to page2
	else{
		
		newUrl = "page2.php";
		newUrlSuffix = "?" + urlSuffixString;
	}
	
	// ananewnei to url xwris refresh
	history.pushState({id: 'SOME ID'}, '',newUrl + newUrlSuffix);
	//$('#board').text($($allRows[1]).html()); 
	
	

	//new
	
});
	