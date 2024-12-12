<?php
session_start();

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php'); // Redirect to login page
    exit();
}

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELI'S SHOP</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        .user-menu {
            position: relative;
            display: inline-block;
        }

        .username {
            cursor: pointer;
            display: inline-block;
            padding: 10px;
        }

        .logout-btn {
            display: none;
            opacity: 0;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            margin-top: 5px;
            padding: 8px;
            background-color: #dfa7a7;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 40px;
            text-align: center;
            transition: opacity 1s ease-out; /* Added smooth fade-out transition */
        }

        .logout-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <header>
        <a href="#Home" class="logo" aria-label="Go to Home">@ELI'S SWEET CREATIONS</a>
        <nav>
            <ul>
                <li><a href="#Home">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="form.php">Rate Us</a></li>
                <li class="user-menu">
                    <span class="username">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                    <button class="logout-btn" onclick="location.href='index.php?logout'">Log out</button>
                </li>
            </ul>
        </nav>  
    </header>

    <section id="Home" class="grid">
        <div class="content">
            <div class="content-left">
                <div class="info">
                    <h2>Order Your Best <br>Food Anytime</h2>
                    <p>Our delicious cakes are waiting for you. <br> We're always near you with sweet treats!</p>
                </div>
                <button onclick="location.href='#Menu'">Explore Food</button>
            </div>
            <div class="content-right">
                <img src="cakesf1.jpg" alt="Delicious cakes on display">
            </div>
        </div>
    </section>

    <section id="Menu" class="category">
        <div class="carousel">
            <div class="carousel-track">
                <div class="carousel-item">
                    <img src="kik1.jpg" alt="Cake 1">
                    <h3>Chocolate Cake</h3>
                    <button onclick="location.href='products.php'">Buy Now</button>
                </div>
                <div class="carousel-item">
                    <img src="kik9.png" alt="Cake 2">
                    <h3>Choco Strawberry Cake</h3>
                    <button onclick="location.href='products.php'">Buy Now</button>
                </div>
                <div class="carousel-item">
                    <img src="kik10.png" alt="Cake 3">
                    <h3>Fruitcake</h3>
                    <button onclick="location.href='products.php'">Buy Now</button>
                </div>
            </div>
        </div>
    </section>

    <section id="Menu2" class="category2">
        <div class="carousel2">
            <div class="carousel-track">
                <div class="carousel-item2">
                    <img src="2 tier.jpg" alt="Cake 1">
                    <h3>Chocolate Cake</h3>
                    <button onclick="location.href='products.php'">Buy Now</button>
                </div>
                <div class="carousel-item2">
                    <img src="3 tier.jpg" alt="Cake 2">
                    <h3>Choco Strawberry Cake</h3>
                    <button onclick="location.href='products.php'">Buy Now</button>
                </div>
                <div class="carousel-item2">
                    <img src="bento.jpg" alt="Cake 3">
                    <h3>Fruitcake</h3>
                    <button onclick="location.href='products.php'">Buy Now</button>
                </div>
            </div>
        </div>
    </section>

    <section id="footer">
        <h2>"Delighting Taste Buds, Delivering Smiles."</h2>
    </section>

    <script>
        const usernameElement = document.querySelector('.username');
        const logoutButton = document.querySelector('.logout-btn');

        usernameElement.addEventListener('mouseenter', function() {
            logoutButton.style.display = 'inline-block';
            logoutButton.style.opacity = 1; // Ensure it's fully visible when hovered
        });

        usernameElement.addEventListener('mouseleave', function() {
            setTimeout(function() {
                logoutButton.style.opacity = 0; // Fade out the button after 5 seconds
                setTimeout(function() {
                    logoutButton.style.display = 'none'; // Hide the button completely after fade
                }, 1000); // Wait for the opacity transition to finish (1 second)
            }, 2000); // Delay the fade out for 5 seconds
        });

        window.addEventListener("scroll", function() {
            var header = document.querySelector("header");
            header.classList.toggle("sticky", window.scrollY > 0);
        });
    </script>
</body>
</html>
