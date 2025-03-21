<?php
include '../db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM trainings WHERE Training_ID = $id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $duration = $_POST['duration'];

    $sql = "UPDATE trainings SET Title='$title', Description='$description', `Start Date`='$start_date', `End Date`='$end_date', `Duration(Hrs)`='$duration' WHERE Training_ID=$id";

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
    <title>Edit Training</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Edit Training</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['Title']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $row['Description']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $row['Start Date']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $row['End Date']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duration (Hrs)</label>
            <input type="number" class="form-control" id="duration" name="duration" value="<?php echo $row['Duration(Hrs)']; ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="training_index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
