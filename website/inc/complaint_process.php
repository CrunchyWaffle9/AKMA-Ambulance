<?php
include('../includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $ambulance_id = $_POST['ambulance_id'];
    $complaint = $_POST['complaint'];

    $sql = "INSERT INTO complaints (user_id, ambulance_id, complaint) VALUES ('$user_id', '$ambulance_id', '$complaint')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Complaint recorded successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Record Complaint</title>
</head>
<body>
    <form method="POST" action="complaint_process.php">
        <label>User ID:</label>
        <input type="text" name="user_id" required><br>
        <label>Ambulance ID:</label>
        <input type="text" name="ambulance_id" required><br>
        <label>Complaint:</label>
        <textarea name="complaint" required></textarea><br>
        <input type="submit" value="Record Complaint">
    </form>
</body>
</html>
