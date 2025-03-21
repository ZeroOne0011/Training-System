<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Calculate duration in hours (difference in days * 24)
    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);
    $duration = round(($end_timestamp - $start_timestamp) / 3600); // Converting seconds to hours

    if ($duration <= 0) {
        die("Error: End Date must be after Start Date.");
    }

    $sql = "INSERT INTO trainings (Title, Description, `Start Date`, `End Date`, `Duration(Hrs)`) VALUES ('$title', '$description', '$start_date', '$end_date', '$duration')";

    if ($conn->query($sql) === TRUE) {
        header("Location: training_index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Training</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function calculateDuration() {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);

            if (startDate && endDate && endDate > startDate) {
                const durationInHours = Math.round((endDate - startDate) / (1000 * 60 * 60)); // Milliseconds to hours
                document.getElementById('duration').value = durationInHours;
            } else {
                document.getElementById('duration').value = ''; // Clear if invalid
            }
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Add New Training</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="datetime-local" class="form-control" id="start_date" name="start_date" required onchange="calculateDuration()">
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="datetime-local" class="form-control" id="end_date" name="end_date" required onchange="calculateDuration()">
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duration (Hrs)</label>
            <input type="number" class="form-control" id="duration" name="duration" readonly>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="training_index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
