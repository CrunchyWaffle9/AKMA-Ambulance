<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <div class="center">
            <h1>Login</h1>
            <?php
                session_start();
                include("../inc/inc_koneksi.php"); // Include database connection file

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    // Prepare SQL query to check for user in database
                    $query = "SELECT * FROM complaints WHERE email = ?";
                    if ($stmt = $koneksi->prepare($query)) {
                        $stmt->bind_param("s", $email); // Only one parameter for email
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            // User found, set session variables
                            $_SESSION['email'] = $email;
                            header("Location: halaman.php");
                            exit;
                        } else {
                            echo "<p>Invalid email or password. Please try again.</p>";
                        }
                        $stmt->close();
                    } else {
                        echo "Error preparing statement: " . $koneksi->error;
                    }
                }
            ?>
            <form id="loginForm" method="POST" action="login.php">
                <input type="email" name="email" id="email" placeholder="Email" required><br>
                <input type="password" name="password" id="password" placeholder="Password" required><br>
                <button type="submit">Login</button>
            </form>
            <a href="index.html"><button>Back to Home</button></a>
        </div>
    </main>
</body>
</html>
