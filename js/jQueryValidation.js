
$(document).ready(function(){
    
    var textRegExp = /^[a-zA-Z]+$/;
    var numberRegExp = /^[0-9]+$/;
    var error = false;
    
    $('#registrationForm').on('submit', function() {
        
        // To check required fields
        $('.required').each(function(){
            var errField = '#'.concat($(this).attr('id'), 'Err'); 
            
            if ('' === $(this).val() || '0' === $(this).val())
            {
                $(errField).text('Field required');
                error = true;
            }
            else
            {
                $(errField).text('');
            }
            
        });
        
        return (error) ? false : true;
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
                error = true;
            }
            
            // To check length in case of phone and zip
            $(this).on('focusout', function(){
                switch ($(this).attr('id'))
                {
                    case 'inputPhone':
                        if(10 !== $(this).val().length)
                        {
                            $(errField).text('No of digits should be 10');
                            error = true;

                        }
                        else
                        {
                            $(errField).text('');
                        }
                    break;
                    
                    case 'inputResZip':
                    case 'inputOfcZip':
                        if(6 !== $(this).val().length)
                        {
                            $(errField).text('Zip should be of length 6');
                            error = true;

                        }
                        else
                        {
                            $(errField).text('');
                        }
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
                    if(8 !== $(this).val().length)
                        {
                            $(errField).text('Password should be minimun 8 characters');
                            error = true;

                        }
                        else
                        {
                            $(errField).text('');
                        }
                break;

                case 'inputConfirm':
                    if($('#inputPassword').val() !== $(this).val())
                        {
                            $(errField).text('Password do not match');
                            error = true;

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

   