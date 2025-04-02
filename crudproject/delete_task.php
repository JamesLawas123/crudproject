<?php
header('Content-Type: application/json');

// Include database connection
require_once 'conn.php';

try {
    if (!isset($_POST['task_id'])) {
        throw new Exception('Task ID is required');
    }

    $taskId = (int)$_POST['task_id'];

    // Using soft delete by updating status_id to 1 instead of actually deleting the record
    $sql = "UPDATE status SET status_id = 1 WHERE task_id = :task_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to delete task');
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
