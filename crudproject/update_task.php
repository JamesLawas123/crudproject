<?php
require_once 'conn.php';

try {
    // Check if all required fields are present
    if (!isset($_POST['task_id']) || !isset($_POST['taskname']) || !isset($_POST['description']) || 
        !isset($_POST['startdate']) || !isset($_POST['duedate'])) {
        throw new Exception('All fields are required');
    }

    // Prepare the update statement
    $sql = "UPDATE status SET 
            taskname = :taskname,
            description = :description,
            startdate = :startdate,
            duedate = :duedate
            WHERE task_id = :task_id AND status_id = 0";

    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':task_id', $_POST['task_id']);
    $stmt->bindParam(':taskname', $_POST['taskname']);
    $stmt->bindParam(':description', $_POST['description']);
    $stmt->bindParam(':startdate', $_POST['startdate']);
    $stmt->bindParam(':duedate', $_POST['duedate']);

    // Execute the update
    $stmt->execute();

    // Redirect back to the main page
    header("Location: page.php");
    exit();

} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
