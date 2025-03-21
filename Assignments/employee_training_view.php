<?php
include '../db.php';

// Fetch data from employee_trainings table with employee and training details
$sql = "
    SELECT 
        e.Name AS Employee_Name, 
        t.Title AS Training_Title, 
        et.`Start date`, 
        et.`End date`, 
        et.Status
    FROM 
        employee_trainings et
    JOIN 
        employees0 e ON et.Employee_ID = e.Employee_ID
    JOIN 
        trainings t ON et.Training_ID = t.Training_ID
";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Trainings View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Employee Trainings Details</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Training Title</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['Employee_Name']; ?></td>
                            <td><?php echo $row['Training_Title']; ?></td>
                            <td><?php echo $row['Start date']; ?></td>
                            <td><?php echo $row['End date']; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
