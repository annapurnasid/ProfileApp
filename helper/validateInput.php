<?php

/*
  @Author : Mfsi_Annapurnaa
  @purpose : Form Validation
 */

class validateInput
{
    
    
    public $inputData;
    public $fileData;
    public $update;
    public $errorList = ['title' => '', 'firstName' => '', 'middleName' => '',
        'lastName' => '', 'email' => '', 'phone' => '', 'gender' => '',
        'dob' => '', 'resStreet' => '', 'resCity' => '', 'resZip' => '',
        'resState' => '', 'marStatus' => '', 'empStatus' => '',
        'employer' => '', 'comm' => '', 'confirm' => '', 'password'=> '',
        'note' => '', 'image' => '', 'dob' => ''];

    /**
     * Constructor function
     *
     * @access public
     * @param  array  $input
     * @param  int    $up 
     * @return void
     */
    function __construct($input, $up)
    {
        $this->inputData = $input['postData'];
        $this->fileData = $input['fileData'];
        $this->update = $up;
    }

    /**
     * Function to check required fields
     *
     * @access public
     * @param  array $requiredField  
     * @return array $this->errorList
     */
    function required($requiredField)
    {
        
        foreach ($this->inputData as $key => $value)
        {
            // Check if $key is present in array $required 
            if (in_array($key, $requiredField) && empty($this->inputData[$key]))
            {
                $this->errorList[$key] = 'Field is required';
            }
   
            // Validation if field is not empty
            if (!empty($this->inputData[$key]))
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
                    case 'empStatus':
                        $this->errorList = $this->employement($value, $key);
                        break;
                    case 'password':
                        $this->errorList = $this->password($value, $key);
                        break;

                    default:
                        break;
                }
            }
        }

        // Validation for image
        if ( ! $this->fileData['image']['error'])
        {
            $name = $this->fileData['image']['name']; //file name uploaded
            $imageSize = $this->fileData['image']['size'];
            $imageTmp = $this->fileData['image']['tmp_name'];
            $imageExt = $this->fileData['image']['type'];
            
            $this->errorList = $this->image($name, $imageSize, $imageTmp, $imageExt);
        }
        else if ( ! $this->update)
        {
            $this->errorList['image'] = 'Select an image';
        }

        return $this->errorList;
    }

    /**
     * Function to validate text fields
     *
     * @access public
     * @param  string $value
     * @param  string $key
     * @return array $this->errorList
     */
    function alphabets($value, $key)
    {
        // Check if title only contains letters and whitespace
        if (!preg_match('/^[a-zA-Z ]*$/', $value))
        {
            $this->errorList[$key] = 'Only letters allowed';
        }
        return $this->errorList;
    }

    /**
     * Function to validate email
     *
     * @access public
     * @param  string $value
     * @param  string $key
     * @return array $this->errorList
     */
    function email($value, $key)
    {

        $queryObj = new queryOperation();
        
        // Check email format
        if (!filter_var($value, FILTER_VALIDATE_EMAIL))
        {
            $this->errorList[$key] = 'Invalid email format';
        }

        // Check unique email
        $condition = ['column' => 'Employee.email', 'operator' => '=', 'val' => '\'' . $value . '\''];
        $result = $queryObj->select('Employee', 'email', $condition);
        if (mysqli_num_rows($result) > 0 && !$this->update) 
        {
            $this->errorList[$key] = 'Email taken';
        }
          
        return $this->errorList;
    }

    /**
     * Function to validate numeric field
     *
     * @access public
     * @param  string $value
     * @param  string $key
     * @return array $this->errorList
     */
    function number($value, $key)
    {
        // Validate phone number
        if ('phone' === $key)
        {
            if (!preg_match('/^\d{10}$/', $value))
            {
                $this->errorList[$key] = 'Invalid phone number';
            }
        }
        
        // Validate zip
        else
        {
            if (!preg_match('/^\d{6}$/', $value))
            {
                $this->errorList[$key] = 'Invalid zip';
            }
        }
        
        return $this->errorList;
    }

   /**
     * Function to validate image
     *
     * @access public
     * @param  string $name
     * @param  int    $imageSize
     *  @param string $imageTmp
     *  @param string $imageExt
     * @return array $this->errorList
     */
    function image($name, $imageSize, $imageTmp, $imageExt)
    {
        // Image file type validation
        $exploded = explode('.', $this->fileData['image']['name']);
        $imageExt = strtolower(end($exploded));
        $extensions = array('jpeg', 'jpg', 'png');

        // Validate image type
        if (!in_array($imageExt, $extensions))
        {
            $this->errorList['image'] = 'Extension not allowed, please choose a JPEG or PNG file';
        }

        // Image size validation
        $maxSize = 2097152;

        if ($imageSize > $maxSize)
        {
            $this->errorList['image'] = 'File size must be excately 2 MB';
        }
        
        // Move image to desired folder
        if (isset($name) && !empty($name) && (0 === count($this->errorList)))
        {
            move_uploaded_file($imageTmp, IMAGEPATH . $name);
        }
        

        return $this->errorList;
    }
    
     /**
     * Function to validate employement andemployer field
     *
     * @access public
     * @param  string $value
     * @param  string $key
     * @return array $this->errorList
     */
    function employement($value, $key)
    {
        if ('self-employed' === $value)
        {
            $_POST['employer'] = 'Self';
            $employer = $_POST['employer'];
        }
        if ('employed' === $value && '' === $_POST['employer'])
        {
            echo'++++';exit();
            $this->errorList['employer'] = 'Specify Your employer';
        }
        return $this->errorList;
    }
    
   /**
     * Function to validate input password
     *
     * @access public
     * @param  string $value
     * @param  string $key
     * @return array $this->errorList
     */
    function password($value, $key)
    {
        
        // Validate password length
        if ( 8 > strlen($value))
        {
            $this->errorList[$key] = 'Minimum 8 characters required';
        }
        
        // Validate password confirmation
        else if($this->inputData['confirm'] !== $value)
        {
            $this->errorList['confirm'] = 'Passwords do not match';
        }
        
        return $this->errorList;
    }

}
?>

