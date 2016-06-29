
$(document).ready(function(){
    
    var textRegExp = /^[a-zA-Z]+$/;
    var phoneRegExp = /^[0-9]+$/;
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
        
        if(error){
            console.log('die');
            return false;
        }
        console.log('bye');
        return true;
    });
    
    function titleVal(title)
    {
        console.log('HIII');
        if ('' === title)
        {
            console.log('++++');
            $('#titleErr').text('Field required');
            error = true;
        }
        else if(!textRegExp.test(title))
        {
            console.log('====');
            $('#titleErr').text('Only characters allowed');
            error = true;
        }
        else
        {
            console.log('++++=====');
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
        if ('' !== middleName && !textRegExp.test(middleName))
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
        else if (10 !== phone.length || !phoneRegExp.test(phone)) 
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
    
 
});

