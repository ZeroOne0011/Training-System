<?php
include '../db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "DELETE FROM employees0 WHERE Employee_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: employee_index.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
} else {
    header("Location: employee_index.php");
    exit();
}

$conn->close();
?>
