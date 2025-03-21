<?php
include '../db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: employee_index.php");
    exit();
}

$name = $email = $position = $department = '';
$errors = [];

// Fetch current record
$sql = "SELECT * FROM employees0 WHERE Employee_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$stmt->close();

if (!$employee) {
    header("Location: employee_index.php");
    exit();
}

$name = $employee['Name'];
$email = $employee['Email'];
$position = $employee['Position'];
$department = $employee['Department'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST['name']))) {
        $errors[] = "Name is required.";
    } else {
        $name = htmlspecialchars(trim($_POST['name']));
    }

    // Validate email
    if (empty(trim($_POST['email']))) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } else {
        $email = htmlspecialchars(trim($_POST['email']));
    }

    // Validate position
    if (empty(trim($_POST['position']))) {
        $errors[] = "Position is required.";
    } else {
        $position = htmlspecialchars(trim($_POST['position']));
    }

    // Validate department
    if (empty(trim($_POST['department']))) {
        $errors[] = "Department is required.";
    } else {
        $department = htmlspecialchars(trim($_POST['department']));
    }

    // Update record if no errors
    if (empty($errors)) {
        $sql = "UPDATE employees0 SET Name = ?, Email = ?, Position = ?, Department = ? WHERE Employee_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $position, $department, $id);

        if ($stmt->execute()) {
            header("Location: employee_index.php");
            exit();
        } else {
            $errors[] = "Error updating employee: " . $conn->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Employee</h2>
    <?php
    if (!empty($errors)) {
        echo "<div class='alert alert-danger'>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?id=" . $id); ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($position); ?>">
        </div>
        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <input type="text" class="form-control" id="department" name="department" value="<?php echo htmlspecialchars($department); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="employee_index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
