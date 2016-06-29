/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validateForm() {
    var textCheck = /^[a-zA-Z]+$/;
    var phoneCheck = /^[0-9]+$/;
    var error = false;
    
    // Validate title
    var title = document.getElementById('inputTitle').value;
    var titleErr = document.getElementById('titleErr');
    
    if ('' === title)
    {
        titleErr.innerHTML = 'Field required';
        error = true;
    }
    else if (!textCheck.test(title))
    {
        titleErr.innerHTML = 'Only characters allowed';
        error = true;
    }
    else
    {
        titleErr.innerHTML = '';
    }
    
    // Validate FirstName
    var fName = document.getElementById('inputFirstName').value;
    var firstNameErr = document.getElementById('firstNameErr');
    
    if ('' === fName)
    {
        firstNameErr.innerHTML = 'Field required';
        error = true;
    }
    else if (!textCheck.test(fName))
    {
        firstNameErr.innerHTML = 'Only characters allowed';
        error = true;
    }
    else
    {
        firstNameErr.innerHTML = '';
    }
     
    // Validate Middle Name
    var mName = document.getElementById('inputMiddleName').value;
    var middleNameErr = document.getElementById('middleNameErr');
    
    if ('' !== mName && !textCheck.test(mName))
    {
        middleNameErr.innerHTML = 'Only characters allowed';
        error = true;
    }
    else
    {
        middleNameErr.innerHTML = '';
    }

     
    // Validate Last Name
    var lName = document.getElementById('inputLastName').value;
    var lastNameErr = document.getElementById('lastNameErr');
    
    if ('' === lName)
    {
        lastNameErr.innerHTML = 'Field required';
        error = true;
    }
    else if (!textCheck.test(lName))
    {
        lastNameErr.innerHTML = 'Only characters allowed';
        error = true;
    }
    else
    {
        lastNameErr.innerHTML = '';
    }
     
     // Validate email
    var email = document.getElementById('inputEmail').value;
    var emailErr = document.getElementById('emailErr');
    
    // Check if empty
    if ('' === email)
    {
        emailErr.innerHTML = 'Field required';
        error = true;
    }
    else
    {
        atpos = email.indexOf('@');
        dotpos = email.lastIndexOf('.');

        // Check validity of entered mail
        if (atpos < 1 || ( dotpos - atpos < 2 )) 
        {
           emailErr.innerHTML = 'Enter valid email';
           error = true;
        }
        else
        {
          emailErr.innerHTML = '';  
        }
    }
    
    // Validate password
    var password = document.getElementById('inputPassword').value;
    var passwordErr = document.getElementById('passwordErr');
    
    if ('' === password)
    {
        passwordErr.innerHTML = 'Field required';
        error = true;
    }
    else if (8 > password.length) 
    {
       passwordErr.innerHTML = 'Password should be minimum 8 characters';
       error = true;
    }
    else
    {
      passwordErr.innerHTML = '';  
    }
    
    // Validate confirm
    var confirm = document.getElementById('inputConfirm').value;
    var confirmErr = document.getElementById('confirmErr');
    
    if ('' === confirm)
    {
        confirmErr.innerHTML = 'Field required';
        error = true;
    }
    else if (confirm !== password) 
    {
       confirmErr.innerHTML = 'Password do not match';
       error = true;
    }
    else
    {
      confirmErr.innerHTML = '';
    }
    
     
    // Validate phone number
    var phone = document.getElementById('inputPhone').value;
    var phoneErr = document.getElementById('phoneErr');
    
    if ('' === phone)
    {
        phoneErr.innerHTML = 'Field required';
        error = true;
    }
    else if (10 !== phone.length || !phoneCheck.test(phone)) 
    {
       phoneErr.innerHTML = 'Enter valid phone number';
       error = true;
    }
    else
    {
      phoneErr.innerHTML = '';  
    }
     
    // Validate DOB
    var dob = document.getElementById('inputDob').value;
    var dobErr = document.getElementById('dobErr');
    
    if ('' === dob)
    {
        dobErr.innerHTML = 'Field required';
        error = true;
    }
    else
    {
      dobErr.innerHTML = '';  
    }
    
    // Validate Residence street
    var resStreet = document.getElementById('inputResStreet').value;
    var resStreetErr = document.getElementById('resStreetErr');
    
    if ('' === resStreet)
    {
        resStreetErr.innerHTML = 'Field required';
        error = true;
    }
    else
    {
        resStreetErr.innerHTML = '';
    }
    
    // Validate Residence city
    var resCity = document.getElementById('inputResCity').value;
    var resCityErr = document.getElementById('resCityErr');
    
    if ('' === resStreet)
    {
        resCityErr.innerHTML = 'Field required';
        error = true;
    }
    else
    {
        resCityErr.innerHTML = '';
    }
    
    // Validate Residence Zip
    var resZip = document.getElementById('inputResZip').value;
    var resZipErr = document.getElementById('resZipErr');
    
    if ('' === resZip)
    {
        resZipErr.innerHTML = 'Field required';
        error = true;
    }
    else if (6 !== resZip.length || !phoneCheck.test(resZip)) 
    {
       resZipErr.innerHTML = 'Enter valid phone number';
       error = true;
    }
    else
    {
      resZipErr.innerHTML = '';  
    }

    // Validate Residence state
    var resState = document.getElementById('inputResState').value;
    var resStateErr = document.getElementById('resStateErr');
    
    if ('0' === resState)
    {
        resStateErr.innerHTML = 'Select a state';
        error = true;
    }
    else
    {
        resStateErr.innerHTML = '';
    }
    
    // Validate Marital status
    var marStatus = document.getElementById('inputMarStatus').value;
    var marStatusErr = document.getElementById('marStatusErr');
    
    if ('0' === marStatus)
    {
        marStatusErr.innerHTML = 'Specify your marital status';
        error = true;
    }
    else
    {
        marStatusErr.innerHTML = '';
    }
    
    // Validate employment status and employer
    var employer = document.getElementById('inputEmployer').value;
    var employerErr = document.getElementById('employErr');
    var employed = document.getElementById('employed');
    
    if (employed.checked)
    {
        if('' === employer.trim())
        {
            employerErr.innerHTML = 'Specify your Employer';
            error = true;
        }
    }
    else
    {
        employerErr.innerHTML = '';
    }
    
    // Validate comunication
    var check = false;
    for (var i = 0; i < 4; i++)
    {
        check = document.getElementById('inputComm' + i).checked;
        if(check)
        {
            break;
        }
    }
    
    var commErr = document.getElementById('commErr');
    
    if (!check)
    {
        commErr.innerHTML = 'Specify your Communication medium';
        error = true;
    }
    else
    {
        commErr.innerHTML = '';
    }     
    
    // Check if any field has error
     if(error)
     {
         return false;
     }
}
