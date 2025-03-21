<?php include '../db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Employee Records</h2>
    <a href="add_employee.php" class="btn btn-success mb-3">Add New Employee</a>
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
                    echo "<td>" . htmlspecialchars($row['Employee_ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Position']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Department']) . "</td>";
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
