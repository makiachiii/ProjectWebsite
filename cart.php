<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>Shopping Cart - Eli's Sweet Creations</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
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
            transition: 0.6s;
        }

        header.sticky .logo,
        header.sticky ul li a {
            color: #fff;
        }
        header.sticky{
    background-color: #dfa7a7;
}

        .cart-container {
            margin: 120px auto;
            width: 90%;
            max-width: 600px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            margin-top: 250px;
        }

        .cart-container h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .cart-container ul {
            list-style: none;
            padding: 0;
        }

        .cart-container ul li {
            font-size: 1.2rem;
            color: #555;
            margin: 10px 0;
        }

        .cart-total {
            margin-top: 20px;
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
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
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #b29090;
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
            <li><a href="tracking.php">Track Delivery</a></li>
        </ul>
    </header>

    <div class="cart-container">
        <h1>Shopping Cart</h1>
        <ul class="cart-items"></ul>
        <p class="cart-total"><strong>Total:</strong> ₱<span id="cart-total">0</span></p>
        <button onclick="checkout()">Checkout</button>
        <button onclick="location.href= 'products.php'">Add Order</button>
    </div>

    <script>
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        const cartItemsElement = document.querySelector('.cart-items');
        const cartTotalElement = document.getElementById('cart-total');
    
        function renderCart() {
            cartItemsElement.innerHTML = '';
            if (cart.length === 0) {
                cartItemsElement.innerHTML = '<li>Your cart is empty.</li>';
            } else {
                cart.forEach((item, index) => {
                    const li = document.createElement('li');
                    li.style.display = "flex";
                    li.style.alignItems = "center";
                    li.style.marginBottom = "10px";
    
                    li.innerHTML = `
                        <img src="${item.imageUrl || 'number cake.jpg' || '2 tier.jpg'}" alt="${item.product}" style="width: 50px; height: 50px; margin-right: 10px; border-radius: 5px;">
                        <div style="flex-grow: 1;">
                            <strong>${item.product}</strong><br>
                            Price: ₱${item.price} <br>
                            Quantity: 
                            <input 
                                type="number" 
                                value="${item.quantity}" 
                                min="1" 
                                style="width: 50px; text-align: center;" 
                                onchange="updateQuantity(${index}, this.value)"
                            />
                        </div>
                        <span style="margin-left: 10px;">= ₱${(item.price * item.quantity).toFixed(2)}</span>
                        <button style="margin-left: 10px;" onclick="removeItem(${index})">Remove</button>
                    `;
                    cartItemsElement.appendChild(li);
                });
            }
            const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
            cartTotalElement.textContent = total.toFixed(2);
        }
    
        function updateQuantity(index, newQuantity) {
            if (newQuantity < 1) {
                alert("Quantity must be at least 1.");
                renderCart();
                return;
            }
            cart[index].quantity = parseInt(newQuantity, 10);
            localStorage.setItem("cart", JSON.stringify(cart));
            renderCart();
        }
    
        function removeItem(index) {
            cart.splice(index, 1); 
            localStorage.setItem("cart", JSON.stringify(cart));
            renderCart();
        }
    
        function checkout() {
        if (cart.length === 0) {
            alert("Your cart is empty!");
        } else {
            localStorage.setItem("cart", JSON.stringify(cart)); 
            window.location.href = "checkout.php"; 
        }
}
        renderCart();

        console.log(cart);
    </script>

<script>
    window.addEventListener("scroll", function() {
        var header = document.querySelector("header");
        header.classList.toggle("sticky", window.scrollY > 0);
    });
</script>
</body>
</html>