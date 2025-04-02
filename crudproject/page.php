<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        h1 {
            color: #333;
            margin: 0;
        }
        .add-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .add-btn:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .delete-btn, .update-btn {
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }
        .delete-btn {
            background-color: #ff4444;
            color: white;
        }
        .update-btn {
            background-color: #2196F3;
            color: white;
        }
        .delete-btn:hover {
            background-color: #cc0000;
        }
        .update-btn:hover {
            background-color: #0b7dda;
        }
    </style>
    <script>
        function openModal() {
            document.getElementById("addTaskModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("addTaskModal").style.display = "none";
        }

        function deleteTask(taskId) {
            if (confirm("Are you sure you want to delete this task?")) {
                fetch('delete_task.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'task_id=' + taskId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Error deleting task: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting task');
                });
            }
        }

        function openUpdateModal(taskId, taskname, description, startdate, duedate) {
            document.getElementById("updateTaskModal").style.display = "block";
            document.getElementById("update_task_id").value = taskId;
            document.getElementById("update_taskname").value = taskname;
            document.getElementById("update_description").value = description;
            document.getElementById("update_startdate").value = startdate;
            document.getElementById("update_duedate").value = duedate;
        }

        function closeUpdateModal() {
            document.getElementById("updateTaskModal").style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("addTaskModal")) {
                closeModal();
            }
            if (event.target == document.getElementById("updateTaskModal")) {
                closeUpdateModal();
            }
        }
    </script>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Task Management</h1>
            <button class="add-btn" onclick="openModal()">
                <span>Add Task</span>
            </button>
        </div>

        <div id="addTaskModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Add New Task</h2>
                <form action="add_task.php" method="POST">
                    <div class="form-group">
                        <label for="taskname">Task Name:</label>
                        <input type="text" id="taskname" name="taskname" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="startdate">Start Date:</label>
                        <input type="datetime-local" id="startdate" name="startdate" required>
                    </div>
                    <div class="form-group">
                        <label for="duedate">Due Date:</label>
                        <input type="datetime-local" id="duedate" name="duedate" required>
                    </div>
                    <button type="submit" class="submit-btn">Add Task</button>
                </form>
            </div>
        </div>

        <div id="updateTaskModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeUpdateModal()">&times;</span>
                <h2>Update Task</h2>
                <form action="update_task.php" method="POST">
                    <input type="hidden" id="update_task_id" name="task_id">
                    <div class="form-group">
                        <label for="update_taskname">Task Name:</label>
                        <input type="text" id="update_taskname" name="taskname" required>
                    </div>
                    <div class="form-group">
                        <label for="update_description">Description:</label>
                        <textarea id="update_description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="update_startdate">Start Date</label>
                        <input type="datetime-local" id="update_startdate" name="startdate" required>
                    </div>
                    <div class="form-group">
                        <label for="update_duedate">Due Date</label>
                        <input type="datetime-local" id="update_duedate" name="duedate" required>
                    </div>
                    <button type="submit" class="submit-btn">Update Task</button>
                </form>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include database connection
                require_once 'conn.php';
                
                try {
                    // Fetch only non-deleted tasks (status_id = 0)
                    $stmt = $conn->query("SELECT * FROM status WHERE status_id = 0 ORDER BY task_id DESC");
                    
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['taskname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . date('Y-m-d H:i:s', strtotime($row['startdate'])) . "</td>";
                        echo "<td>" . date('Y-m-d H:i:s', strtotime($row['duedate'])) . "</td>";
                        echo "<td>";
                        
                        // Format dates for the update modal - only pass the date part
                        $startDateFormatted = date('Y-m-d', strtotime($row['startdate']));
                        $dueDateFormatted = date('Y-m-d', strtotime($row['duedate']));
                        
                        echo "<button class='update-btn' onclick='openUpdateModal(" . 
                            $row['task_id'] . ", " . 
                            json_encode($row['taskname']) . ", " . 
                            json_encode($row['description']) . ", " . 
                            json_encode($startDateFormatted) . ", " . 
                            json_encode($dueDateFormatted) . 
                            ")'>Update</button>";
                        echo "<button class='delete-btn' onclick='deleteTask(" . $row['task_id'] . ")'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
