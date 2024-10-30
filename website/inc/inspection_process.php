<?php
include('../includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $complaint_id = $_POST['complaint_id'];
    $spv_id = $_SESSION['user_id'];
    $inspection_details = $_POST['inspection_details'];
    $repair_category = $_POST['repair_category'];

    $sql = "INSERT INTO inspections (complaint_id, spv_id, inspection_details, repair_category) VALUES ('$complaint_id', '$spv_id', '$inspection_details', '$repair_category')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Inspection recorded successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Record Inspection</title>
</head>
<body>
    <form method="POST" action="inspection_process.php">
        <label>Complaint ID:</label>
        <input type="text" name="complaint_id" required><br>
        <label>Inspection Details:</label>
        <textarea name="inspection_details" required></textarea><br>
        <label>Repair Category:</label>
        <input type="text" name="repair_category" required><br>
        <input type="submit" value="Record Inspection">
    </form>
</body>
</html>
