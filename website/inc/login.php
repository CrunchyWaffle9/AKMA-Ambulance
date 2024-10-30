<?php
include('includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            switch($row['role']) {
                case 'customer':
                    header('Location: dashboard/customer.php');
                    break;
                case 'admin':
                    header('Location: dashboard/admin.php');
                    break;
                case 'ppc':
                    header('Location: dashboard/ppc.php');
                    break;
                case 'spv':
                    header('Location: dashboard/spv.php');
                    break;
            }
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found with that email";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="login.php">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
