
	// fortwnetai sto add_product και στο edit_product
	
	// 
$('#fileBrowseButton').on('click', function(e){
	
	$('#fileInput').click();
});
	
$('#fileInput').on('change', function(e){
	
	var  fileString = /[^\\]*$/.exec(this.value)[0];
	
	if (fileString == ''){
		
		$('#fileP')[0].innerHTML = 'None'; 
		fileString='none.jpg';
	}
	else{
		
		$('#fileP')[0].innerHTML = '\\' + fileString;
	}
	
	//$('#board').text(this.value); 
	
	$('#prodPic').attr('src','images\\products\\' + fileString);
	$('#prodPic').attr('title',fileString);
	
	$('#filePInput').val(fileString);
});

$('#clearPic').on('click', function(e){
	
	var fileString='none.jpg';
	
	$('#prodPic').attr('src','images\\products\\' + fileString);
	$('#prodPic').attr('title',fileString);
	$('#fileP')[0].innerHTML = 'None'; 
	$('#filePInput').val(fileString);
});