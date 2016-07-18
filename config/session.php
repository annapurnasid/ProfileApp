<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Session Opertaions
 */

class session
{
    /**
     * Function to start session
     *
     * @access public
     * @param  void
     * @return void
     */
    function start()
    {
        session_start();
    }

    /**
     * Function to initialize session fields
     *
     * @access public
     * @param  string $key
     * @param  string $value
     * @return void
     */
    function init($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Function to check if session exists
     *
     * @access public
     * @param  void
     * @return boolean
     */
    function checkSession()
    {
        if (isset($_SESSION['id']) && !empty($_SESSION['id']))
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Function to signout
     *
     * @access public
     * @param  void
     * @return void
     */
    function signOut()
    {
        session_unset();
        session_destroy();
    }
}
