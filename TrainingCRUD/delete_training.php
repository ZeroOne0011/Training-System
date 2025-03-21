<?php
include '../db.php';

$id = $_GET['id'];
$sql = "DELETE FROM trainings WHERE Training_ID = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: training_index.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
