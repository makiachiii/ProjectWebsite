<?php

session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}


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

// Fetch products from the database
$sql = "SELECT * FROM products"; // Assuming your products table is named 'products'
$result = $conn->query($sql);

// Check if there are any products
if ($result->num_rows > 0) {
    // Fetch product data and display them
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Product Details - Eli's Sweet Creations</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(210,183,183,0.6138830532212884) 0%);
            min-height: 200vh;
            background: url("p1.png") no-repeat center center;
            background-size: cover;
            background-attachment: absolute;
            min-height: 100vh;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.6s;
            padding: 40px 100px;
            z-index: 1000000;
        }

        header .sticky {
            padding: 5px 100px;
            background: #fff;
        }

        header .logo {
            font-weight: 700;
            color: #323030;
            text-decoration: none;
            font-size: 2em;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: -4px 5px 8px #dfa7a7;
        }

        header ul {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        header ul li {
            list-style: none;
        }

        header ul li a {
            margin: 0 15px;
            text-decoration: none;
            color: #000;
            letter-spacing: 2px;
            font-weight: 500;
        }

        #products {
            margin: 200px auto;
            width: 100%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .container {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: -1px 6px 50px 0px #dfa7a7;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
        }

        .cake img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .details {
            padding: 20px;
        }

        .details h2 {
            font-size: 1.5em;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .details p {
            font-size: 1rem;
            margin: 5px 0;
            color: #555;
        }

        .price {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ff6f61;
            margin-top: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: none;
            background-color: #dbb7b7;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #dbb7b7;
        }
    </style>
</head>
<body>
    <header>
        <a href="https://www.facebook.com/Elisweetcreations/" class="logo">@ELI'S SWEET CREATIONS</a>
        <ul>
            <li><a href="HomePage.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
        </ul>
    </header>

    <section id="products">
        <?php foreach ($products as $product): ?>
            <div class="container">
                <div class="cake">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="details">
                    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p>Description: <?php echo htmlspecialchars($product['description']); ?></p>
                    <p>Size: <?php echo htmlspecialchars($product['size']); ?></p>
                    <p class="price">₱<?php echo number_format($product['price'], 2); ?></p>
                    <button onclick="addToCart('<?php echo htmlspecialchars($product['name']); ?>', <?php echo $product['price']; ?>, '<?php echo htmlspecialchars($product['image_url']); ?>')">Add to Cart</button>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <script>
        function addToCart(product, price, imageUrl) {
            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const existingItem = cart.find(item => item.product === product);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({ product, price, imageUrl, quantity: 1 });
            }
            localStorage.setItem("cart", JSON.stringify(cart));
            alert(`${product} has been added to the cart.`);
            window.location.href = "cart.php"; // Redirect to cart page
        }
    </script>

    <script>
        window.addEventListener("scroll", function() {
            var header = document.querySelector("header");
            header.classList.toggle("sticky", window.scrollY > 0);
        });
    </script>
</body>
</html>
