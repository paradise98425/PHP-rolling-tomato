<?php

/**************************************** */
//Debbuging mode code 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*************************************** */

require_once "dbConnect.php";

// class begins here 
class dbFunction {

    private $conn;
    
    // Constructor 
    function __construct() {
        $dbc = new dbConnect();
        $this->conn = $dbc->getConnection();
    }

    // function to fetch the required speed
    public function FetchSpeed($id) {
        // fetching the required speed
        $speedId = 500;
        $result = mysqli_query($this->conn, 
                            "SELECT * FROM `speeds` WHERE id = '".$id."'"
                        ) 
                        or die(mysqli_error());
        
        return $result;         // returning the result
    }

    // function to register play details in the databse
    public function SucessRegister($session_id, $time) { 
        // inserting the data into databse table called sucesses, if failed
        // it prints the error message mysql gives and then terminated 
        // the running PHP script
        if($time > 1){
            $qr = mysqli_query($this->conn, "INSERT INTO sucesses(session_id, time) 
                            values('".$session_id."','".$time."')") 
                            or die(mysqli_error());  
            return $qr; 
        }     
    } 
}

?>