<?php
/*
  @Author : Mfsi_Annapurnaa
  @purpose : Query Operations
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config/connection.php');
require_once ('config/session.php');

class queryOperation
{
    public $conn;
    public $connObj;
    public $result;

    /**
     * Constructor function
     *
     * @access public
     * @param  void
     * @return void
     */
    function __construct()
    {
        // Creating the Connection class obj to make connection
        $this->connObj = new connection();
        $this->conn = $this->connObj->makeConnection();
    }

    /**
     * Function for getting all details of employee
     *
     * @access public
     * @param  int $id
     * @return array
     */
    function getEmployeeDetail($id = '')
    {
        $joinQuery = "FROM Employee 
            JOIN Address AS Residence ON Employee.empId = Residence.empId 
            AND Residence.addressType = 'residence'
            JOIN Address AS Office ON Employee.empId = Office.empId 
            AND Office.addressType = 'office'";
        
        // To fetch the details for update, after log in
        if (!empty($id))
        {
            $sqlQuery = "SELECT Employee.empId, Employee.title, Employee.firstName, Employee.middleName, 
                Employee.lastName, Employee.email, Employee.phone, Employee.gender, Employee.dateOfBirth, 
                Residence.street AS resStreet, Residence.city AS resCity , Residence.zip AS resZip, 
                Residence.state AS resState, Office.street AS ofcStreet, Office.city AS ofcCity , Office.zip 
                AS ofcZip, Office.state AS ofcState, Employee.maritalStatus AS marStatus, Employee.empStatus, 
                Employee.image, Employee.employer, Employee.commId, Employee.note, Employee.password, 
                Employee.note " . $joinQuery;
        }
        // To fetch the details to display
        else
        {
            $sqlQuery = "SELECT Employee.empId AS EmpID,
                CONCAT(Employee.title, ' ', Employee.firstName, 
                ' ', Employee.middleName, ' ', Employee.lastName) AS Name,
                Employee.email AS EmailID, 
                Employee.phone AS Phone, Employee.gender AS Gender, Employee.dateOfBirth AS Dob, 
                CONCAT(Residence.street, '<br />' , Residence.city , '<br />',
                Residence.zip,'<br />', Residence.state ) AS Res,
                CONCAT(Office.street, '<br />', Office.city , '<br />',  Office.zip, '<br />',
                Office.state) AS Ofc,
                Employee.maritalStatus AS marStatus, Employee.empStatus AS EmploymentStatus, 
                Employee.employer AS Employer, Employee.commId AS Communication,
                Employee.image AS Image, 
                Employee.note AS Note " . $joinQuery;
        }

        // If connection made, return query result
        return $this->connObj->executeConnection($this->conn, $sqlQuery);
    }

    /**
     * Function for getting communication detail of employee
     *
     * @access public
     * @param string $table
     * @param string $field
     * @param array  $condition
     * @return array
     */
    function select($table, $field, $condition = '')
    {
        $selectQuery = "SELECT $field FROM $table";

        // If $condition has some value 
        if (0 < count($condition))
        {
            // Add WHERE to concate condition with query
            $selectQuery .= ' WHERE ';

            // To keep track of last but one condition in $condition array
            $indexCount = count($condition) - 1;

            foreach ($condition as $key => $val)
            {
                
                // Check if $condition is array i.e it has multiple values
                if (is_array($val))
                {
                    // Multi associative array
                    foreach ($val as $col => $value)
                    {
                        $selectQuery .= $val[$col] . ' ';
                    }

                    // If last but 1 index not reached, add AND
                    if (0 !== $indexCount)
                    {
                        $selectQuery .= ' AND ';
                    }

                    $indexCount--;
                }
                else
                {
                    $selectQuery .= $condition[$key] . ' ';
                }
            }
        }

        // If fieldsare for display in userHome page, return $row 
        if ('email, empId, password, title, firstName, lastName, middleName' === $field)
        {
            $result = $this->connObj->executeConnection($this->conn, $selectQuery);
            $row = mysqli_fetch_assoc($result);
            return $row;
        }

        return $this->connObj->executeConnection($this->conn, $selectQuery);
    }

    /**
     * Function for deleting employee details
     *
     * @access public
     * @param string $table
     * @param array $condition
     * @return void
     */
    function delete($table, $condition)
    {
        $deleteQuery = 'DELETE FROM ' . $table . ' WHERE ' . $condition[column] . ' ' .
                $condition[operator] . ' ' . $condition[val];
        $result = $this->connObj->executeConnection($this->conn, $deleteQuery);

        if (!$result)
        {
            echo 'Deletetion Failed';
        }
    }

    /**
     * Function for inserting employee details
     *
     * @access public
     * @param string  $table
     * @param array   $data
     * @param array   $condition
     * @param boolean $isUpdate
     * @return void
     */
    function insertUpdate($table, $data, $condition = '', $isUpdate = FALSE)
    {
        $count = 0;
        $fields = '';
        foreach ($data as $key => $val)
        {
            if (0 !== $count++)
            {
                $fields .= ', ';
            }

            $col = mysqli_real_escape_string($this->conn, $key);
            $value = mysqli_real_escape_string($this->conn, $val);
            $fields .= "$col = '$val'";
        }

        // Insert values into db
        if (!$isUpdate)
        {
            $empQuery = "INSERT INTO $table SET $fields";
            session_start();
            $_SESSION['insert'] = 1;
        }
        else
        {
            // Update values in db
            $empQuery = "UPDATE $table
                SET $fields
                WHERE $condition[column]  $condition[operator]  $condition[val]";
        }

        $result = $this->connObj->executeConnection($this->conn, $empQuery);

        if (!$result)
        {
            echo ($isUpdate) ? 'Update Failed!' : 'Insertion Failed!';
        }

        // Use session variable
        if (!$isUpdate)
        {
            // Id of the last inserted record
            $employeeId = mysqli_insert_id($this->conn);
            return $employeeId;
        }

        return TRUE;
    }
}

?>