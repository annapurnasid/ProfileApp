<?php

/**
     * Function for error log files
     *
     * @access public
     * @param  string $message
     * @return void
     */
    function errorFile($message)
    {
        $name = 'log/log' . date('m_d_y') . '.txt';
       if(! file_exists($name))
       {  
           $errorFile = fopen($name, 'w'); 
       }
       else
           
       {
           $errorFile = fopen($name, 'a+');
       }
              
       fwrite($errorFile, $message . "\n");
       fclose($errorFile);

       header('Location:errorPage.php');
    }

?>