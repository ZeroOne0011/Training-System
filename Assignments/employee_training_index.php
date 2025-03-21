<?php
include '../db.php';

// Get the current date
$current_date = date('Y-m-d H:i:s');

// Update statuses for all training assignments
$update_query = "SELECT `Employee_ID`, `Training_ID`, `Start date`, `End date` FROM `employee_trainings`";
$update_result = $conn->query($update_query);

if ($update_result->num_rows > 0) {
    while ($row = $update_result->fetch_assoc()) {
        $employee_id = $row['Employee_ID'];
        $training_id = $row['Training_ID'];
        $start_date = $row['Start date'];
        $end_date = $row['End date'];

        // Determine the current status
        if ($current_date < $start_date) {
            $status = "Assigned";
        } elseif ($current_date >= $start_date && $current_date <= $end_date) {
            $days_left = ceil((strtotime($end_date) - strtotime($current_date)) / (60 * 60 * 24));
            $status = "In Progress ($days_left days left)";
        } else {
            $status = "Completed";
        }

        // Update the status in the database
        $status_update_query = "UPDATE `employee_trainings` SET `Status` = ? WHERE `Employee_ID` = ? AND `Training_ID` = ?";
        $status_stmt = $conn->prepare($status_update_query);
        $status_stmt->bind_param("sii", $status, $employee_id, $training_id);
        $status_stmt->execute();
    }
}

// Fetch all records from employee_trainings table
$query = "SELECT et.*, e.Name AS EmployeeName, t.Title AS TrainingTitle 
          FROM `employee_trainings` et
          JOIN `employees0` e ON et.Employee_ID = e.Employee_ID
          JOIN `trainings` t ON et.Training_ID = t.Training_ID";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Employee Trainings</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Employee Trainings</h2>
    <br>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Employee Name</th>
            <th>Training Title</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row["EmployeeName"] ?></td>
                <td><?= $row["TrainingTitle"] ?></td>
                <td><?= $row["Start date"] ?></td>
                <td><?= $row["End date"] ?></td>
                <td><?= $row["Status"] ?></td>
                <td>
                    <a href="read_employee_training.php?id=<?= $row['Employee_ID'] ?>" class="btn btn-info btn-sm">View</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
