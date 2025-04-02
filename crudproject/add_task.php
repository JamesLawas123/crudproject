<?php
require_once 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $taskname = $_POST['taskname'];
        $description = $_POST['description'];
        
        // Convert and validate dates
        $startdate = date('d-m-Y H:i:s', strtotime($_POST['startdate']));
        $duedate = date('d-m-Y H:i:s', strtotime($_POST['duedate']));
        
        // Validate that dates are valid
        if ($startdate === false || $duedate === false) {
            throw new Exception('Invalid date format');
        }
        
        // Prepare SQL statement
        $sql = "INSERT INTO status (taskname, description, startdate, duedate, status_id) 
                VALUES (:taskname, :description, :startdate, :duedate, 0)";
        
        $stmt = $conn->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':taskname', $taskname);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':startdate', $startdate);
        $stmt->bindParam(':duedate', $duedate);
        
        // Execute the statement
        $stmt->execute();
        
        // Redirect back to the main page
        header("Location: page.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
