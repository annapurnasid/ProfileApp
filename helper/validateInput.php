<?php

class validateInput
{
    /*
      @Author : Mfsi_Annapurnaa
      @purpose : Form Validation
     */

    public $inputData;
    public $fileData;
    public $update;
    public $errorList = ['title' => '', 'firstName' => '', 'middleName' => '',
        'lastName' => '', 'email' => '', 'phone' => '', 'gender' => '',
        'dob' => '', 'resStreet' => '', 'resCity' => '', 'resZip' => '',
        'resState' => '', 'marStatus' => '', 'empStatus' => '',
        'employer' => '', 'comm' => '',
        'note' => '', 'image' => '', 'dob' => ''];

    function __construct($input, $up)
    {
        $this->inputData = $input['postData'];
        $this->fileData = $input['fileData'];
        $this->update = $up;
    }

    function required($requiredField)
    {
        foreach ($this->inputData as $key => $value)
        {
            if (in_array($key, $requiredField) && empty($this->inputData[$key]))
            {
                $this->errorList[$key] = 'Field is required';
            }
   
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

                    default:
                        break;
                }
            }
        }

        if ( ! $this->fileData['image']['error'])
        {
            $name = $this->fileData['image']['name']; //file name uploaded
            $imageSize = $this->fileData['image']['size'];
            $imageTmp = $this->fileData['image']['tmp_name'];
            $imageExt = $this->fileData['image']['type'];
            
            $this->errorList = $this->image($name, $imageSize, $imageTmp, $imageExt);
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
        if ('phone' === $key)
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
                $this->errorList[$key] = 'Invalid zip';
            }
        }
        
        return $this->errorList;
    }

    function image($name, $imageSize, $imageTmp, $imageExt)
    {
        // Image file type validation
        $exploded = explode('.', $this->fileData['image']['name']);
        $imageExt = strtolower(end($exploded));
        $extensions = array('jpeg', 'jpg', 'png');

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
        else if ( ! $this->update)
        {
            $this->errorList['image'] = 'Select an image';
        }

        return $this->errorList;
    }
    
    function employement($value, $key)
    {
        if ('self-employed' === $value)
        {
            $this->inputData['employer'] = 'Self';
            $employer = $this->inputData['employer'];
        }
        else if ('employed' === $value && empty($this->inputData['employer']))
        {
            $this->errorList['employer'] = 'Specify Your employer';
        }
        return $this->errorList;
    }

}
?>

