<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('connection.php');

class queryOperation
{

    public $conn;
    public $connObj;
    public $result;

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
     * @param  int
     * @return void
     */
    function getEmployeeDetail($id = '')
    {
        if (!empty($id))
        {	
            $sqlQuery = "SELECT Employee.empId, Employee.title, Employee.firstName, Employee.middleName, 
                Employee.lastName, Employee.email, Employee.phone, Employee.gender, Employee.dateOfBirth, 
                Residence.street AS resStreet, Residence.city AS resCity , Residence.zip AS resZip, 
                Residence.state AS resState, Office.street AS ofcStreet, Office.city AS ofcCity , Office.zip 
                AS ofcZip, Office.state AS ofcState, Employee.maritalStatus AS marStatus, Employee.empStatus, 
                Employee.image, Employee.employer, Employee.commId, Employee.note
                FROM Employee 
                JOIN Address AS Residence ON Employee.empId = Residence.empId 
                AND Residence.addressType = 'residence'
                JOIN Address AS Office ON Employee.empId = Office.empId 
                AND Office.addressType = 'office'
                HAVING EmpID = $id";
        }
        else{
            $sqlQuery = "SELECT Employee.empId AS EmpID, CONCAT(Employee.title, ' ', Employee.firstName, 
                ' ', Employee.middleName, ' ', Employee.lastName) AS Name, Employee.email AS EmailID, 
                Employee.phone AS Phone, Employee.gender AS Gender, Employee.dateOfBirth AS Dob, 
                CONCAT(Residence.street, '<br />' , Residence.city , '<br />', Residence.zip,'<br />', 
                Residence.state ) AS Res,
                CONCAT(Office.street, '<br />', Office.city , '<br />',  Office.zip, '<br />', Office.state) AS Ofc,
                Employee.maritalStatus AS marStatus, Employee.empStatus AS EmploymentStatus, 
                Employee.employer AS Employer, Employee.commId AS Communication, Employee.image AS Image, 
                Employee.note AS Note
                FROM Employee 
                JOIN Address AS Residence ON Employee.empId = Residence.empId 
                AND Residence.addressType = 'residence'
                JOIN Address AS Office ON Employee.empId = Office.empId 
                AND Office.addressType = 'office'";
        }

        // If connection made, return query result
        return $this->connObj->executeConnection($this->conn, $sqlQuery);
    }

    /**
     * Function for getting communication detail of employee
     *
     * @access public
     * @param  table  $table
     * @param  column $field
     * @param  array  $condition
     * @return void
     */
    function select($table, $field, $condition = '')
    {
        $selectQuery = "SELECT $field FROM $table";

        if (0 < count($condition))
        {
            $selectQuery .= ' WHERE ';
            
            $c = count($condition) - 1;

            foreach ($condition as $key => $val)
            {
                if (is_array($val))
                {
                    // Multi Asoociative
                    foreach ($val as $col => $value)
                    {
                        $selectQuery .= $val[$col] . ' ';
                    }

                    if (0 !== $c)
                    {
                        $selectQuery .= ' AND ';
                    }

                    $c--;
                }
                else
                {
                    $selectQuery .= $condition[$key] . ' ';
                }
            }
        }

    return $this->connObj->executeConnection($this->conn, $selectQuery);
    }
    
    /**
     * Function for deleting employee details
     *
     * @access public
     * @param  table   $table
     * @param  array   $data
     * @param  array   $condition
     * @return boolean $update
     */
    function delete($table, $condition){
        $deleteQuery = "DELETE FROM $table WHERE $condition[column]  $condition[operator]  $condition[val]";
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
     * @param  table   $table
     * @param  array   $data
     * @param  array   $condition
     * @return boolean $update
     */
    function insertUpdate($table, $data, $condition = '', $isUpdate = FALSE)
    {
        $count = 0;
        $fields = '';
        echo '====';
        foreach ($data as $key => $val)
        {
            if ($count++ != 0)
            {
                $fields .= ', ';
            }

            $col = mysqli_real_escape_string($this->conn, $key);
            $value = mysqli_real_escape_string($this->conn, $val);
            $fields .= "$col = '$val'";
        }

        if (!$isUpdate)
        {
            $empInsert = "INSERT INTO $table SET $fields";
            $result = $this->connObj->executeConnection($this->conn, $empInsert);
            if (!$result)
            {
                echo 'Insertion Failed';
            }
            else
            {
                echo 'inserted';
            }

            // Id of the last inserted record
            $employeeId = mysqli_insert_id($this->conn);
            return $employeeId;
        }
        else
        {
            $empUpdate = "UPDATE $table
                SET $fields
                WHERE $condition[column]  $condition[operator]  $condition[val]";
            $result = $this->connObj->executeConnection($this->conn, $empUpdate);
            if (!$result)
            {
                echo 'Update Failed';
            }
            else
            {
                echo 'Updated';
            }
        }
    }

}
?>