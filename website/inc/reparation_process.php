<?php
include('../includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inspection_id = $_POST['inspection_id'];
    $ppc_id = $_SESSION['user_id'];
    $spare_part_check = $_POST['spare_part_check'];
    $estimated_time = $_POST['estimated_time'];

    $sql = "INSERT INTO reparations (inspection_id, ppc_id, spare_part_check, estimated_time) VALUES ('$inspection_id', '$ppc_id', '$spare_part_check', '$estimated_time')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Reparation recorded successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Record Reparation</title>
</head>
<body>
    <form method="POST" action="reparation_process.php">
        <label>Inspection ID:</label>
        <input type="text" name="inspection_id" required><br>
        <label>Spare Part Check:</label>
        <textarea name="spare_part_check" required></textarea><br>
        <label>Estimated Time (hours):</label>
        <input type="text" name="estimated_time" required><br>
        <input type="submit" value="Record Reparation">
    </form>
</body>
</html>
