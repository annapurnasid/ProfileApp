
$(document).ready(function(){
    
    var textRegExp = /^[a-zA-Z]+$/;
    var numberRegExp = /^[0-9]+$/;
    var error = false;
    
    $('#registrationForm').on('submit', function() {
        
        // To check required fields
        $('.required').each(function(){
            var errField = '#'.concat($(this).attr('id'), 'Err'); 
            
            if ('' === $(this).val())
            {
                $(errField).text('Field required');
                error = true;
            }
            else
            {
                $(errField).text('');
            }
            
        });
        
        if (error){
            return false;
        }
        return true;
    });
        
        // To validate alphabets only field
        $('.alphabets').on('keyup focusout',function(){
            var errField = '#'.concat($(this).attr('id'), 'Err');
            if ('' !== $.trim($(this).val()) && !textRegExp.test($(this).val()))
            {
                $(errField).text('Only characters allowed');
                error = true;
            }

        });
        
        // To validate number only field
        $('.number').on('keyup focusout',function(){
            var errField = '#'.concat($(this).attr('id'), 'Err');
            if ('' !== $.trim($(this).val()) && !numberRegExp.test($(this).val()))
            {
                $(errField).text('Only numbers allowed');
                console.log($(errField).val());
                error = true;
            }
            
            // To check lenght in case ofphone and zip
            $(this).on('focusout', function(){
                switch ($(this).attr('id'))
                {
                    case 'inputPhone':
                        $(errField).text((10 !== $(this).val().length) ? 'No of digits should be 10' : '');
                    break;
                    
                    case 'inputResZip':
                    case 'inputOfcZip':
                        $(errField).text((6 !== $(this).val().length) ? 'Zip should be of length 6' : '');
                    break;
                }
            });
            
        });
        
        // Validate email
        $('#inputEmail').on('focusout', function(){
            atpos = $(this).val().indexOf('@');
            dotpos = $(this).val().lastIndexOf('.');

            // Check validity of entered mail
            if (atpos < 1 || ( dotpos - atpos < 2 )) 
            {
               $('#inputEmailErr').text('Enter valid email');
               error = true;
            }
            else
            {
              $('#inputEmailErr').text(''); 
            }
        });
        
        // Validate password
        $('.password').on('focusout', function(){
            var errField = '#'.concat($(this).attr('id'), 'Err');
            switch ($(this).attr('id'))
            {
                case 'inputPassword':
                    $(errField).text((8 !== $(this).val().length) ? 'Password should be minimun 8 characters' : '');
                break;

                case 'inputConfirm':
                    if ($('#inputPassword').val() !== $(this).val())
                    {
                        $(errField).text('Password do not match');
                    }
                    else
                    {
                        $(errField).text('');
                    }
                    
                break;
            }
            });
            
        });
        
        // Reset form
        $('#formReset').on('click', function(){
            $('.error').text('');
        });

    
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
 

    