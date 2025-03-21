<?php
include '../db.php';

$id = $_GET["id"] ?? null;
if ($id) {
    $query = "SELECT et.*, e.Name AS EmployeeName, t.Title AS TrainingTitle, t.Description AS TrainingDescription 
              FROM `employee_trainings` et
              JOIN `employees0` e ON et.Employee_ID = e.Employee_ID
              JOIN `trainings` t ON et.Training_ID = t.Training_ID
              WHERE et.Employee_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Employee Training</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Employee Training Details</h2>
    <?php if ($record): ?>
        <p><strong>Employee Name:</strong> <?= $record["EmployeeName"] ?></p>
        <p><strong>Training Title:</strong> <?= $record["TrainingTitle"] ?></p>
        <p><strong>Training Description:</strong> <?= $record["TrainingDescription"] ?></p>
        <p><strong>Start Date:</strong> <?= $record["Start date"] ?></p>
        <p><strong>End Date:</strong> <?= $record["End date"] ?></p>
        <p><strong>Status:</strong> <?= $record["Status"] ?></p>
    <?php else: ?>
        <p>Record not found.</p>
    <?php endif; ?>
</div>
</body>
</html>
