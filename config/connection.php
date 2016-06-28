<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Db connection operations
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include constants
include('config/constants.php');

class connection
{

    static $conn;

    /**
     * Function for creating database connection
     *
     * @access public
     * @param  void
     * @return object
     */
    function makeConnection()
    {
        if (!self::$conn)
        {
            // Making connection
            self::$conn = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBNAME);

            // Checking connection
            if (mysqli_connect_error(self::$conn))
            {
                die('Failed to connect to database' . mysqli_connect_error());
            }
        }

        return self::$conn;
    }

    /**
     * Function for checking database connection
     *
     * @access public
     * @param  obj 	$conn
     * @param query $testSelect
     * @return query result $row
     */
    function executeConnection($conn, $query)
    {
        $result = mysqli_query($conn, $query);

        if (!$result)
        {
            echo 'Operation failed' . mysql_error();
        }
        else
        {
            return $result;
        }
    }

    /**
     * Function for checking database connection
     *
     * @access public
     * @param  void
     * @return void
     */
    function closeConnection()
    {
        mysqli_close();
    }
}

?>