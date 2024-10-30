<?php
session_start();
include("../inc/inc_koneksi.php"); // Include database connection file

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password

    // Prepare SQL query to insert new user
    $query = "INSERT INTO users (email, password) VALUES (?, ?)";
    if ($stmt = $koneksi->prepare($query)) {
        $stmt->bind_param("ss", $email, $password);
        if ($stmt->execute()) {
            $message = "<p>Registration successful! <a href='login.php'>Click here to login</a></p>";
        } else {
            $message = "<p>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        $message = "<p>Error: " . $koneksi->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="loginregist.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo_akma_512x266.png" alt="AKMA Ambulance">
        </div>
        <div class="custom-navbar">
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="hero">
            <img src="akma bg.jpg" alt="Building">
        </div>
        <div class="rt">   
            <h1>Register</h1>
            <?php
            if ($message) {
                echo $message;
            }
            ?>
            <form id="registerForm" method="POST" action="register.php">
                <input type="email" name="email" id="email" placeholder="Email" required><br>
                <input type="password" name="password" id="password" placeholder="Password" required><br>
                <button type="submit">Register</button>
            </form>
            <a href="index.php"><button>Back to Home</button></a>
        </div>
    </main>
</body>
</html>
