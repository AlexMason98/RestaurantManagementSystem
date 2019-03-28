<?php
class Database {
    // This sets up the database connection with our credentials
	private $host = "localhost";
	private $user = "root";
	private $password = "teamproject5";
	private $database = "customer";
	private $conn;

    // Constructs the file by calling the connectDB method to initialise connection
    function __construct() {
        $this->conn = $this->connectDB();
	}	
	
    // Connect DB method to connect to the database, ready to run queries
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
    // Runs base queries using the database connection
    function runBaseQuery($query) {
        $result = $this->conn->query($query);	
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        return $resultset;
    }
    
    
    // Runs queries in the database using the database connection
    function runQuery($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->get_result();
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        
        if(!empty($resultset)) {
            return $resultset;
        }
    }
    
    // Bind paramters received from the query to other bits of data
    function bindQueryParams($sql, $param_type, $param_value_array) {
        $param_value_reference[] = & $param_type;
        for($i=0; $i<count($param_value_array); $i++) {
            $param_value_reference[] = & $param_value_array[$i];
        }
        call_user_func_array(array(
            $sql,
            'bind_param'
        ), $param_value_reference);
    }
    
    // Function to insert data into the database
    function insert($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }
    
    // Function to update data into the database
    function update($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }
}
?>