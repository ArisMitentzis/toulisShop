
$('#fillSimpleUser').on('click', function(e){
	document.getElementById("userEmail").value="user@mail.com";
	document.getElementById("userPassword").value = "puser1234";
});

$('#fillAdmin').on('click', function(e){
		document.getElementById("userEmail").value="admin@mail.com";
		document.getElementById("userPassword").value = "padmin1234";
});
