

$(document).ready(function() {
    $('#ordersTable').DataTable( {
        "pagingType": "full_numbers"
		//,"order": [[ 3, "desc" ]]
		,"bLengthChange": false 
    } );
} );

$(document).ready(function() {
    $('#productTable').DataTable( {
        //"pagingType": "full_numbers"
		//,"order": [[ 3, "desc" ]]
		//,"bLengthChange": false 
    } );
} );

$(document).ready(function() {
    $('#usTable').DataTable( {
        //"pagingType": "full_numbers"
		//,"order": [[ 3, "desc" ]]
		//,"bLengthChange": false 
    } );
} );

$(document).ready(function() {
    $('#myOrdersTable').DataTable( {
        "pagingType": "full_numbers"
		//,"order": [[ 3, "desc" ]]
		,"bLengthChange": false 
    } );
} );

$(document).ready(function() {
    $('#ordTable').DataTable( {
        "pagingType": "full_numbers"
		//,"order": [[ 3, "desc" ]]
		,"bLengthChange": false,
		"searching": false,
		 "dom": '<"top"i>rt<"bottom"flp><"clear">'
    } );
} );

