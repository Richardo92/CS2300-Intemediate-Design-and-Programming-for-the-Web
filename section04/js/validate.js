/* 1. Form Validation using JavaScript (and some jQuery) */

/* The overall function called to validate the form has been written for you: */
function validateForm(form) {
	var reason = "";
	reason += validateName(form.name);
	reason += validateAge(form.age);
    reason += validateEthnicity(form.ethnicity);
	reason += validateZip(form.zip);
	reason += validateEmail(form.email);
	
	if (reason != "") {
		event.preventDefault();
    	alert("Some fields need correction:\n" + reason);
    	return false;
	}
    return true;
}

/* The function to validate the age field has been written for you as an example: */
function validateAge(field) {
	var error = "";
	var legalChars = /^\d+$/;

	if (field.value.length == 0) {
		field.className = 'missing';
		error = "The required age field must be filled in.\n";
	}
	else if (!legalChars.test(field.value)) {
		field.className = 'invalid';
		error = "The age can only contain numbers.\n"
	}
	else {
		field.className = '';
	}
	return error;
}

/* This function should make sure that the user has inputted a valid zipcode.
Like the age validation function, it should check against an empty input, inputs
that include anything other than numbers. In addition, it should check that the 
zip entered is exactly of length 5. 

Additional challenge: Make your zipcode more flexible by allowing for an optional
additional dash and 4 more digits.
*/
function validateZip(field) {
    var error = "";

    // Change the regex to allow just 5 numbers. Hint: look at validateAge.
    var legalChars = / /;

    // Change the conditional to test against an empty input.
    if (true) {
        field.className = 'missing';
        error = "The required zip code field must be filled in.\n";
    }

    // Change the conditional to test if the input does not match legalChars.
    // Hint: look at validateAge.
    else if (true) {
        field.className = 'invalid';
        error = "The zip code can only contain 5 numbers.\n"
    }
    else {
        field.className = '';
    }
    return error;
}

/* This function should validate the name field. First, we must check against an empty
entry. Next, if the user has entered something, allow names as long as they contain
only word characters (a character from a-z, A-Z, 0-9, and '_' (underscore). */
function validateName(field) {
	var error = "";

    // Change the regex to represent any illegal characters (non-word character).
	var illegalChars = / /;

    // Change the conditional to test against an empty input.
	if (true) {
		field.className = 'missing';
		error = "The required name field must be filled in.\n";
	}

    // Change the conditional to test against an input that contains illegalChars.
	else if (true) {
		field.className = 'invalid';
		error = "The name contains illegal characters.\n"
	}
	else {
		field.className = '';
	}
	return error;
}

/* This function should make sure that at least one checkbox is checked in the
ethnicity question. Checkboxes are harder to check using vanilla JavaScript, so 
we will use jQuery here instead. 

Hint: https://api.jquery.com/checked-selector/ may be helpful
*/
function validateEthnicity(field) {
    var error = "";

    // Change the conditional to get the checked attribute of the checkboxes by
    // selecting the class, and check if its length is 0. Don't forget '$' keyword.
    if (true) {
        error = "The required ethnicity must have at least one option checked.\n";
    }
    return error;
}

/* This function should check the email field for a valid email address if the user
inputted anything. If the field is left blank, we assume the user did not want to
provide their email address and ignore. */
function validateEmail(field) {
	var error = "";

    // Change the regex to match a valid email address.
    // A valid email address must contain at least a '@' sign and a dot '.'
    // Also, the '@' must not be the first character of the address and the '.' must at least be one character after the '@' sign.
	// Hint: if needed, search the Internet for JavaScript regex email validation
	var emailFilter = / /;
            		
	// Change the conditional to check that the input is not empty AND it follows the
    // correct email format.
	if (true) {
		field.className = 'invalid';
		error = "The email entered is invalid.\n"
	}
	else {
		field.className = '';
	}
	return error;
}