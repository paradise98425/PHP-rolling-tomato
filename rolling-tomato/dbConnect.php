<?php  
    /******************************************************************** */
        // this is a class which requires the configuration file 
        // for the database connection.

        ///////////////////// DID YOU RUN THE SQL SCRIPTS? //////////////////
        // Before running the project, remember to run the  sql scripts first.
    /******************************************************************** */

    class dbConnect {   

        private $conn;

        // constructor
        function __construct() {  
            // use your own username instead of root and password insead of "" after root to run the project.
            $this->conn = mysqli_connect('localhost', 'root', '', 'rolling_tomato');  

            // testing the connection  
            if(!$this->conn)
            {  
                // die is inbuilt PHP function that is used to print message
                // and exit from the current PHP script. 
                die ("Cannot connect to the database");  
            }   
            return $this->conn; 
        } 
        
        // this function returns the connection to the mysql database
        public function getConnection() {
            return $this->conn;
        }
    }  
?>  