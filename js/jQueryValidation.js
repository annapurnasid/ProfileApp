
$(document).ready(function(){
    
    var textRegExp = /^[a-zA-Z]+$/;
    var numberRegExp = /^[0-9]+$/;
    var error = false;
    
    $('#register').click(function() {
        
        var title = $('#inputTitle').val();
        var firstName = $('#inputFirstName').val();
        var middleName = $('#inputMiddleName').val();
        var lastName = $('#inputLastName').val();
        var email = $('#inputEmail').val();
        var password = $('#inputPassword').val();
        var confirm = $('#inputConfirm').val();
        var phone = $('#inputPhone').val();
        var dob = $('#inputDob').val();
        var resStreet = $('#inputResStreet').val();
        var resCity = $('#inputResCity').val();
        var resZip = $('#inputResZip').val();
        var resState = $('#inputResState').val();
        var marStatus = $('#inputMarStatus').val();
        
        titleVal(title);
        firstNameVal(firstName);
        middleNameVal(middleName);
        lastNameVal(lastName);
        emailVal(email);
        passwordVal(password);
        confirmVal(confirm, password);
        phoneVal(phone);
        dobVal(dob);
        resStreetVal(resStreet);
        resCityVal(resCity);
        resZipVal(resZip);
        resStateVal(resState);
        marStatusVal(marStatus);
        
        if(error){
            return false;
        }
        return true;
    });
    
    function titleVal(title)
    {
        if ('' === title)
        {
            $('#titleErr').text('Field required');
            error = true;
        }
        else if(!textRegExp.test(title))
        {
            $('#titleErr').text('Only characters allowed');
            error = true;
        }
        else
        {
            $('#titleErr').text('');
        }
    }
    
    function firstNameVal(firstName)
    {
        if ('' === firstName)
        {
            $('#firstNameErr').text('Field required');
            error = true;
        }
        else
        {
            $('#firstNameErr').text('');
        }
    }
    
    function middleNameVal(middleName)
    {
        if ('' !== middleName.trim() && !textRegExp.test(middleName))
        {
            $('#middleNameErr').text('Only characters allowed');
            error = true;
        }
        else
        {
            $('#middleNameErr').text('');
        }
    }
    
    function lastNameVal(lastName)
    {
        if ('' === lastName)
        {
            $('#lastNameErr').text('Field required');
            error = true;
        }
        else
        {
            $('#lastNameErr').text('');
        }
    }
    
    function emailVal(email)
    {
        // Check if empty
        if ('' === email)
        {
            $('#emailErr').text('Field required');
            error = true;
        }
        else
        {
            atpos = email.indexOf('@');
            dotpos = email.lastIndexOf('.');

            // Check validity of entered mail
            if (atpos < 1 || ( dotpos - atpos < 2 )) 
            {
               $('#emailErr').text('Enter valid email');
               error = true;
            }
            else
            {
              $('#emailErr').text(''); 
            }
        }
    }
    
    // Validate password
    function passwordVal(password)
    {
        if ('' === password)
        {
            $('#passwordErr').text('Field required');
            error = true;
        }
        else if (8 > password.length) 
        {
           $('#passwordErr').text('Password should be minimum 8 characters');
           error = true;
        }
        else
        {
          $('#passwordErr').text(''); 
        }
    }
    
    function confirmVal(confirm,password)
    {
        // Validate confirm
        if ('' === confirm)
        {
            $('#confirmErr').text('Field required');
            error = true;
        }
        else if (confirm !== password) 
        {
           $('#confirmErr').text('Password do not match');
           error = true;
        }
        else
        {
          $('#confirmErr').text('');
        }
    }
    
    function phoneVal(phone)
    {
        // Validate phone number
        if ('' === phone)
        {
            $('#phoneErr').text('Field required');
            error = true;
        }
        else if (10 !== phone.length || !numberRegExp.test(phone)) 
        {
            $('#phoneErr').text('Enter valid phone number');
            error = true;
        }
        else
        {
            $('#phoneErr').text('');  
        }
    }
    
    function dobVal(dob)
    {
        if ('' === dob)
        {
            $('#dobErr').text('Field required');
            error = true;
        }
        else
        {
            $('#dobErr').text(''); 
        }
    }
    
    function resStreetVal(resStreet)
    {
        // Validate Residence street
        if ('' === resStreet)
        {
            $('#resStreetErr').text('Field required');
            error = true;
        }
        else
        {
            $('#resStreetErr').text('');
        }
    }
    
    // Validate Residence City
    function resCityVal(resCity)
    {
        // Validate Residence city
        if ('' === resCity)
        {
            $('#resCityErr').text('Field required');
            error = true;
        }
        else
        {
            $('#resCityErr').text('');
        }
    }
    
    // Validate Residence Zip
    function resZipVal(resZip)
    {

        if ('' === resZip)
        {
            $('#resZipErr').text('Field required');
            error = true;
        }
        else if (6 !== resZip.length || !numberRegExp.test(resZip)) 
        {
            $('#resZipErr').text('Enter valid Zip');
           error = true;
        }
        else
        {
            $('#resZipErr').text('');
        }
    }
    
    // Validate Residence state
    function resStateVal(resState)
    {

        if ('0' === resState)
        {
            $('#resStateErr').text('Select a state');
            error = true;
        }
        else
        {
            $('#resStateErr').text('');
        }
    }
    
    // Validate Marital status
    function marStatusVal(marStatus)
    {

        if ('0' === marStatus)
        {
            $('#marStatusErr').text('Specify your marital status');
            error = true;
        }
        else
        {
            $('#marStatusErr').text('');
        }
    }
 
});
    