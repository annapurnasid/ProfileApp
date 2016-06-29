
$(document).ready(function(){
    
    var textCheck = /^[a-zA-Z]+$/;
    //var phoneCheck = /^[0-9]+$/;
    var error = false;
    
    $('#register').click(function() {
        
        var title = $('#inputTitle').val();
        var firstName = $('#inputFirstName').val();
        var middleName = $('#inputMiddleName').val();
        var lastName = $('#inputLastName').val();
        
        
        titleVal(title);
        firstNameVal(firstName);
        middleNameVal(middleName);
        lastNameVal(lastName);
        
        if(error){
            return false;
        }
        return true;
    });
    
    function titleVal(title)
    {
        if ('' === title)
        {
            $('#titleErr').text('Required field');
            error = true;
        }
        else if(!textCheck.test(title))
        {
            $('#titleErr').text('Only characters allowed');
            error = true;
        }
        else
        {
            console.log('+++');
            $('#titleErr').text('');
        }
    }
    
    function firstNameVal(firstName)
    {
        if ('' === firstName)
        {
            $('#firstNameErr').text('Required field');
            error = true;
        }
        else
        {
            $('#titleErr').text('');
        }
    }
    
    function middleNameVal(middleName)
    {
        if ('' !== middleName && !textCheck.test(middleName))
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
            $('#lastNameErr').text('Required field');
            error = true;
        }
        else
        {
            $('#titleErr').text('');
        }
    }
});
