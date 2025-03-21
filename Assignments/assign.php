<?php
// Define admin credentials
$admin_name = "admin";
$admin_password = "password123";

// Initialize variables for authentication
$auth_success = false;

// Check if admin credentials are submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    $input_admin_name = $_POST['admin_name'];
    $input_admin_password = $_POST['admin_password'];

    // Verify admin credentials
    if ($input_admin_name === $admin_name && $input_admin_password === $admin_password) {
        $auth_success = true;
    } else {
        echo "<div class='alert alert-danger text-center'>Invalid admin credentials. Please try again.</div>";
    }
}

// Proceed only if authenticated
if ($auth_success || (isset($_POST['assign']) && isset($_POST['employee_id'], $_POST['training_id']))) {
    // Database connection configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "training_system";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['assign'])) {
        // Handle form submission to assign employee to training
        $employee_id = $_POST['employee_id'];
        $training_id = $_POST['training_id'];

        // Check if the employee is already assigned to another training
        $check_sql = "SELECT * FROM employee_trainings WHERE Employee_ID = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $employee_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Employee is already assigned to a training
            echo "<div class='alert alert-warning'>This employee is already assigned to a training. Please select a different employee.</div>";
            $check_stmt->close();
        } else {
            // Fetch start and end dates for the selected training
            $dates_sql = "SELECT `Start Date`, `End Date` FROM trainings WHERE Training_ID = ?";
            $dates_stmt = $conn->prepare($dates_sql);
            $dates_stmt->bind_param("i", $training_id);
            $dates_stmt->execute();
            $dates_result = $dates_stmt->get_result();
            $training_dates = $dates_result->fetch_assoc();

            $start_date = $training_dates['Start Date'];
            $end_date = $training_dates['End Date'];

            // Determine the status based on the current date
            $current_date = date('Y-m-d H:i:s');
            if ($current_date < $start_date) {
                $status = "Assigned";
            } elseif ($current_date >= $start_date && $current_date <= $end_date) {
                $days_left = (strtotime($end_date) - strtotime($current_date)) / (60 * 60 * 24);
                $days_left = ceil($days_left);
                $status = "In Progress (" . $days_left . " days left)";
            } elseif (!$training_dates || !$start_date || !$end_date) {
                die("<div class='alert alert-danger'>Invalid training selected. Please try again.</div>");
            } else {
                $status = "Completed";
            }

            $sql = "INSERT INTO employee_trainings (Employee_ID, Training_ID, `Start date`, `End date`, Status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisss", $employee_id, $training_id, $start_date, $end_date, $status);

            if ($stmt->execute()) {
                // Redirect to employee_training_index.php after a successful assignment
                header("Location: ../employee_training_index.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }

            $stmt->close();
            $dates_stmt->close();
        }
    }

    // Fetch employees
    $employees_result = $conn->query("SELECT Employee_ID, Name FROM employees0");

    // Fetch trainings
    $trainings_result = $conn->query("SELECT Training_ID, Title FROM trainings");

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Employees to Trainings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!$auth_success): ?>
            <h1 class="text-center">Admin Login</h1>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="admin_name" class="form-label">Admin Name:</label>
                    <input type="text" class="form-control" id="admin_name" name="admin_name" required>
                </div>
                <div class="mb-3">
                    <label for="admin_password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                </div>
                <button type="submit" name="admin_login" class="btn btn-primary w-100">Login</button>
            </form>
        <?php else: ?>
            <h1 class="text-center">Assign Employees to Trainings</h1>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="employee_id" class="form-label">Select Employee:</label>
                    <select class="form-select" name="employee_id" id="employee_id" required>
                        <?php while ($employee = $employees_result->fetch_assoc()): ?>
                            <option value="<?php echo $employee['Employee_ID']; ?>">
                                <?php echo $employee['Name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="training_id" class="form-label">Select Training:</label>
                    <select class="form-select" name="training_id" id="training_id" required>
                        <?php while ($training = $trainings_result->fetch_assoc()): ?>
                            <option value="<?php echo $training['Training_ID']; ?>">
                                <?php echo $training['Title']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" name="assign" class="btn btn-primary w-100">Assign</button>
            </form>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
