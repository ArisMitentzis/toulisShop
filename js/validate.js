function valdtRegistrationForm() {

    var mail = document.getElementById('email').value;
    var pass = document.getElementById('password').value;
    var confirmPass = document.getElementById('confirmPassword').value;

    if (! valdtEmail(mail)) {
		
        window.alert ("Το e-mail που δώσατε δεν βρισκεται σε κατάλληλη μορφή! ");
        return false;
    }

    if (pass.length  < 8) {
        
		window.alert("Ο κωδικός πρέπει να αποτελείται απο το λιγότερο 8 χαρακτήρες!");
        return false;
		
    } else if (pass != confirmPass) {
        
		window.alert("Λανθασμένη επιβεβαίωση κωδικού!");
        return false;
    }
}

function valdtEmail(mail){
	
    var reg= /\S+@\S+\.\S+/;
    return reg.test(mail) ;
}