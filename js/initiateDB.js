
$('#initDBbutton').on('click', function(e){
	
	function notifyFeedback(data) {
		
		//$('#initializedText').style.visibility = "visible"; 
		//$('#initializedText').hide;
		document.getElementById('initDBbutton').disabled=true;
		document.getElementById("initializedText").innerHTML = "Αρχικοποιήθηκε";
		//alert("Hello! I am an alert box!");
	}
	ajaxCallerWithSuccessFunction ("POST",rootFolderOfAsyncPhp + "async_initiateDB.php",notifyFeedback);
});


	