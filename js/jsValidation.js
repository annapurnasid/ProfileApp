// Reset form
function resetForm() {
    document.getElementById("regForm").reset();
    errorList = document.getElementsByClassName('error'); 
}

function validateForm() {
    var textRegExp = /^[a-zA-Z]+$/;
    var phoneRegExp = /^[0-9]+$/;
    var error = false;
    
    required = document.getElementsByClassName('required');

    for (i = 0; i < required.length; i++) 
    {
        id = required[i].getAttribute('id');
        inputVal = document.getElementById(id).value;
    
        errorFieldId = id.concat('Err');
        inputError = document.getElementById(errorFieldId);
        inputError.innerHTML = '';
        
        if ('' === inputVal || '0' === inputVal)
        {
            inputError.innerHTML = 'Field required';
            error = true;
        }
        else {
            // Check email
            switch (id) {
                case 'inputEmail':

                    atpos = inputVal.indexOf('@');
                    dotpos = inputVal.lastIndexOf('.');

                    // Check validity of entered mail
                    if (1 > atpos  || ( 2 > (dotpos - atpos))) {
                        inputError.innerHTML = 'Enter valid email';
                        error = true;
                    }
                    break;

                case 'inputPassword':
                    if (8 > inputVal.length) {
                        inputError.innerHTML = 'Password should be minimun 8 characters';
                        error = true;
                    }

                    break;

                case 'inputConfirm':
                    if (document.getElementById('inputPassword').value !== inputVal) {
                        inputError.innerHTML = 'Password do not match';
                        error = true;
                    }

                    break;
            }
        }
        
    }
    
    alphabet = document.getElementsByClassName('alphabet');

    for (i = 0; i < alphabet.length; i++) 
    {
        id = alphabet[i].getAttribute('id');
        inputVal = document.getElementById(id).value;
    
        errorFieldId = id.concat('Err');
        inputError = document.getElementById(errorFieldId);
        
        if ('' !== inputVal && !textRegExp.test(inputVal))
        {
            inputError.innerHTML = 'Only alphabets allowed';
            error = true;
        }
    }
    
    number = document.getElementsByClassName('number');

    for (i = 0; i < number.length; i++) {
        id = number[i].getAttribute('id');
        inputVal = document.getElementById(id).value;
    
        errorFieldId = id.concat('Err');
        inputError = document.getElementById(errorFieldId);
        
        
        if ('' !== inputVal) {
            
            inputError.innerHTML = '';
            if (!phoneRegExp.test(inputVal)) {
                inputError.innerHTML = 'Only numbers allowed';
                error = true;
            }
            else {
                switch (id) {
                    case 'inputPhone':
                        if (10 !== inputVal.length) {
                            inputError.innerHTML = 'Phone should be 10 digits';
                            error = true;
                        }
                        break;
                        
                    case 'inputResZip':
                    case 'ofcZip':
                        if (6 !== inputVal.length) {
                            inputError.innerHTML = 'Zip should be of length 6';
                            error = true;
                        }
                        break;
                }
            }
        }
    }
    
      
    // Validate comunication
    var check = false;
    
    for (var i = 0; i < 4; i++)
    {
        check = document.getElementById('inputComm' + i).checked;
        
        if (check)
        {
            break;
        }
    }
    
    var commErr = document.getElementById('commErr');
    commErr.innerHTML = '';
    
    if (!check) {
        commErr.innerHTML = 'Specify your Communication medium';
        error = true;
    }    
    
    // Check if any field has error
    return (error) ? false : true;
}
