<?php
include '../db.php';

$result = $conn->query("SELECT * FROM trainings");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Training List</h1>
    <a href="create_training.php" class="btn btn-primary mb-3">Add New Training</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Training ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Duration (Hrs)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['Training_ID']; ?></td>
                    <td><?php echo $row['Title']; ?></td>
                    <td><?php echo $row['Description']; ?></td>
                    <td><?php echo $row['Start Date']; ?></td>
                    <td><?php echo $row['End Date']; ?></td>
                    <td><?php echo $row['Duration(Hrs)']; ?></td>
                    <td>
                        <a href="edit_training.php?id=<?php echo $row['Training_ID']; ?>" class="btn btn-success btn-sm">Edit</a>
                        <a href="delete_training.php?id=<?php echo $row['Training_ID']; ?>" class="btn btn-primary btn-sm">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
