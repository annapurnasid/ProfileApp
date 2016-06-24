<?php

class session
{
    function start()
    {
        session_start();
    }
    
    function init($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    function checkSession()
    {
        if(isset($_SESSION['id']) && !empty($_SESSION['id']))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    function signOut()
    {
        session_unset();
         session_destroy();
    }
}
?>
