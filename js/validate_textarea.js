var charLimit;
var warnLimit;
var warnSign;

$(document).ready(function() {
    
	charLimit = parseInt($('textarea').attr('data-limit'));
	warnLimit = 0.25 * charLimit;
	warnSign = "<span class='material-icons' style='font-size:20px;color:red'>warning</span>"
});

// textareas
	// γινεται ελεγχος, ενημερωση και αποτροπή κατα την εισαγωγή χαρακτηρων στο textarea ωστε να μην
	// γίνεται υπέρβαση του ορίου των χαρακτηρων
	
	$('textarea').on('keypress', function (e) { 
	

	
	//alert('1');
	
		var typedCharsNumber = $('textarea').val().length;
	
		if (typedCharsNumber === charLimit){
			
			e.preventDefault();
			return;
		}
	});
	
	$('textarea').on('input', function (e) { 
	
	//alert('2');
	

	
		var typedCharsNumber = $('textarea').val().length;
			
		var numberOfCharsLeft = charLimit - typedCharsNumber;
		
		if (numberOfCharsLeft <= warnLimit){
			
			
		
			$('#prodDescription_count').html(warnSign + '   Απομένουν ' + numberOfCharsLeft + ' χαρακτήρες.');
			$('#prodDescription_count').show();
		}
		else{
			
			$('#prodDescription_count').hide();
		}
	});