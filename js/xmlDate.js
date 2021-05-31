
$(document).ready(function() {
    
	/*
	$("#toDt").datepicker(
	{
		dateFormat : "dd-mm-yyyy" //any valid format that you want to have
	});
	*/
	//$( "#toDt" ).datepicker( "option", dateFormat, "dd-mm-yyyy" );
	
	//$("#toDt").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true });
} );

function assignDate(date,dateInputId) {
	
	var day = ("0" + date.getDate()).slice(-2);
	
	// oi mhnes sth js ksekinoun apo 0->january ---  gia auto kai to +1
	var month = ("0" + (date.getMonth() + 1)).slice(-2);

	var today = date.getFullYear() + "-" + month + "-" + day ;

	$(dateInputId).val(today);
}

function setLastXdays(lastXdays) {
	
	var now = new Date();
	assignDate(now,'#toDt');
	
	
	var aWeekAgo = new Date();
	var aWeekAgoDate = now.getDate() - lastXdays;
	aWeekAgo.setDate(aWeekAgoDate);
	assignDate(aWeekAgo,'#frDt');
}

$('#lastWeek').on('click', function (e) {  

	setLastXdays(7);
});

$('#lastMonth').on('click', function (e) {  

	setLastXdays(30);
});

$('.dtPick').on('click', function (e) {  

	$('#custom').prop('checked', true);
});

/*
$('#lastWeek').on('click', function (e) {  

	//alert('aek');
	
	// twrinh hmeromhnia
	var now = new Date();
	
	//xtizei string 0+hmera(1 ws 31) kai me to slice krataei mono ta 2 teleutaia pshfia
	var day = ("0" + now.getDate()).slice(-2);
	
	// oi mhnes sth js ksekinoun apo 0->january ---  gia auto kai to +1
	var month = ("0" + (now.getMonth() + 1)).slice(-2);

	var today = now.getFullYear() + "-" + month + "-" + day ;

	$('#toDt').val(today);
	
	//$('#board').text($('#toDt').val()); 
 
	var ourDate = new Date();
 
	//Change it so that it is 7 days in the past.
	var pastDate = ourDate.getDate() - 7;
	ourDate.setDate(pastDate);
	
	$('#board').text(ourDate); 
});
*/

