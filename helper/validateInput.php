<?php
class validateInput{
    /*
      @Author : Mfsi_Annapurnaa
      @purpose : Form Validation
*/
     public $inputData;
     public $errorList = ['title' => '', 'firstName' => '', 'middleName' => '',
        'lastName' => '', 'email' => '', 'phone' => '', 'gender' => '',
         'dob' => '', 'resStreet' => '', 'resCity' => '', 'resZip' => '',
         'resState' => '', 'marStatus' => '', 'empStatus' => '',
         'employer' => '', 'comm' => '',
        'note' => '', 'image' => '', 'dob' => ''];
     
     function __construct($input)
     {
         $this->inputData = $input;
     }

     function required($requiredField)
     {
        foreach ($this->inputData as $key => $value)
        {
            if (in_array($key, $requiredField) && empty($this->inputData[$key]))
            {
                $this->errorList[$key] = 'Field is required';
                //$errorList[$key] = ucfirst(strtolower($key . ' is required'));
            }
            else if (!empty($this->inputData[$key]))
            {
                switch ($key)
                {
                    case 'title':
                    case 'firstName':
                    case 'middleName':
                    case 'lastName':
                        $this->errorList = $this->alphabets($value, $key);
                        break;
                    case 'email':
                        $this->errorList = $this->email($value, $key);
                        break;
                    case 'phone':
                    case 'resZip':
                        $this->errorList = $this->number($value, $key);
                        break;
                        

                    default:
                        break;
                }
            }
        }
        return $this->errorList;
    }
    function alphabets($value, $key)
    {
        // Check if title only contains letters and whitespace
        if (!preg_match('/^[a-zA-Z ]*$/', $value))
        {
            $this->errorList[$key] = 'Only letters allowed';
        }
        return $this->errorList;
    }

    function email($value, $key)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL))
        {
            $this->errorList[$key] = 'Invalid email format';
        }
        return $this->errorList;
    }
    
    function number($value, $key)
    {
        if('phone' === $key)
        {
            if (!preg_match('/^\d{10}$/', $value))
            {
                $this->errorList[$key] = 'Invalid phone number';
            }
        }
        else
        {
            if (!preg_match('/^\d{6}$/', $value))
            {
                $this->errorList[$key] ='Invalid zip';
            }
        }
                return $this->errorList;

    }

}
?>

