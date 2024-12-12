<?php
session_start(); // Start the session

// Database connection settings
$host = 'localhost';
$dbname = 'eli_sweet';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($username) || empty($password)) {
        $error = 'Both username and password are required.';
    } else {
        // Query to check if user exists
        $stmt = $conn->prepare('SELECT password FROM users WHERE username = ?');
        
        if ($stmt === false) {
            // Error handling: Output error if the statement couldn't be prepared
            die('Error preparing statement: ' . $conn->error);
        }

        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header('Location: HomePage.php');
                exit();
            } else {
                $error = 'Invalid username or password.';
            }
        } else {
            $error = 'Invalid username or password.';
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - ELI'S SWEET CREATIONS</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="main">
        <h1>ELI'S SWEET CREATIONS</h1>
        <h3>Enter your login credentials</h3>

        <?php if (!empty($error)): ?>
            <p style="color: red;"> <?php echo htmlspecialchars($error); ?> </p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your Username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <div class="wrap">
                <button type="submit">Login</button>
            </div>
        </form>

        <p>Not registered?
            <a href="signup.php" style="text-decoration: none;">Create an account</a>
        </p>
    </div>

    <?php
    // Logout functionality
    if (isset($_GET['logout'])) {
        session_destroy(); // Destroy the session
        header('Location: login.php'); // Redirect to login page
        exit();
    }
    ?>
</body>
</html>
