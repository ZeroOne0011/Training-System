<?php include '../db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Employees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Employee List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM employees0";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Employee_ID'] . "</td>";
                    echo "<td>" . $row['Name'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Position'] . "</td>";
                    echo "<td>" . $row['Department'] . "</td>";
                    echo "<td>
                        <a href='edit_employee.php?id=" . $row['Employee_ID'] . "' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='delete_employee.php?id=" . $row['Employee_ID'] . "' class='btn btn-danger btn-sm'>Delete</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No employees found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php $conn->close(); ?>
</body>
</html>
