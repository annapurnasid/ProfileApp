<?php

//including the file containing the constants
include('config/constants.php');

class DB
{

    /**
     * Codes for creating database connection
     *
     * @access public 
     * @param 
     * @return 
     */
    function dbConnection()
    {
        // Initialize the connection parameters
        $host = DBHOST;
        $uName = DBUSER;
        $password = DBPASSWORD;
        $database = DBNAME;

        // Making connection
        $conn = mysqli_connect($host, $uName, $password, $database);

        // Checking connection
        if (mysqli_connect_error($conn))
        {
            die('Failed to connect to database' . mysqli_connect_error());
        }
    }

    /**
     * Codes for handling error for database queries
     *
     * @access public
     * @param $conn, $query
     * @return void
     */
    function queryResult($conn, $query)
    {
        $result = mysqli_query($conn, $query);
        if (!$result)
        {
            echo 'Query Execution failed' . mysql_error();
        }
    }

    /**
     * Codes for updating employee details
     *
     * @access public
     * @param int   $employeeIdUpdate
     * @param array $updateData
     * @return array
     */
    function update($employeeIdUpdate, $updateData)
    {
        // Query for employee details
        $empUpdate = "UPDATE Employee
            SET title = '$title', firstName = '$firstName', middleName = '$middleName', 
            lastName = '$lastName', dateOfBirth = '$dob', gender = '$gender', phone = '$phone', 
            email = '$email', maritalStatus = '$marStatus', empStatus = '$empStatus', 
            commId = '$communication', employer = '$employer', image = '$name', note = '$note'
            WHERE empId = $employeeIdUpdate";

        // Query for Office address details
        $empOfcUpdate = "UPDATE Address
            SET street = '$ofcStreet', city = '$ofcCity', zip = '$ofcZip', state = '$ofcState'
            WHERE empId = '$employeeIdUpdate' 
            AND addressType = 'office'";

        // Query for Residential address details
        $empResUpdate = "UPDATE Address
            SET street = '$resStreet', city = '$resCity', zip = '$resZip', state = '$resState'
            WHERE empId = '$employeeIdUpdate' 
            AND addressType = 'residence' ";
        return array($empUpdate, $empOfcUpdate, $empResUpdate);
    }

    /**
     * Codes for inserting employee details
     *
     * @access public insert()
     * @param $conn
     * @return
     */
    function insert($conn)
    {
        // Insert personal details
        $employeeInsert = "INSERT INTO Employee(title, firstName, middleName, lastName, 
            dateOfBirth, gender, phone, email, maritalStatus, empStatus, commId, image, note, employer)
            VALUES ('$title', '$firstName', '$middleName', '$lastName', '$dob', '$gender', $phone, 
            '$email', '$marStatus', '$empStatus', '$communication','$name',
            '$note', '$employer')";

        // Id of the last inserted record
        $employeeId = mysqli_insert_id($conn);

        // Query to insert employee details
        $address = "INSERT INTO Address(addressType, street, city, zip, state, empId) 
            values('office', '$ofcStreet', '$ofcCity', '$ofcZip', '$ofcState', '$employeeId'), 
            ('residence', '$resStreet', '$resCity', '$resZip', '$resState', '$employeeId')";
    }

    /**
     * Codes for inserting employee details
     *
     * @access public select()
     * @param $empId
     * @return
     */
    function select($empId)
    {
        $selectQuery = "SELECT Employee.empId, Employee.title, Employee.firstName, Employee.middleName, 
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
            HAVING EmpID = $empId";
    }

}

?>