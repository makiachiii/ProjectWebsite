<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>Checkout - Eli's Sweet Creations</title>
    <style>
        body {
            background: url("p1.png") no-repeat center center;
            background-size: cover;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .checkout-container {
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

        .checkout-container h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .form-section {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-section label {
            font-size: 1rem;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }

        .form-section input, 
        .form-section textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-section textarea {
            resize: vertical;
        }

        .checkout-total, .shipping-fee, .final-total {
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .payment-methods {
            text-align: left;
            margin-bottom: 20px;
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

    <div class="checkout-container">
        <h1>Checkout</h1>

        <!-- Customer Information Form -->
        <div class="form-section">
            <label for="name">Full Name</label>
            <input type="text" id="name" placeholder="Enter your full name" required>

            <label for="contact">Contact Number</label>
            <input type="text" id="contact" placeholder="Enter your contact number" required>

            <label for="email">Email Address</label>
            <input type="email" id="email" placeholder="Enter your email address" required>

            <label for="address">Shipping Address</label>
            <textarea id="address" rows="4" placeholder="Enter your complete address" required></textarea>
        </div>

        <!-- Cart Items and Total -->
        <ul class="cart-items"></ul>
        <p class="checkout-total"><strong>Cart Total:</strong> ₱<span id="cart-total">0</span></p>
        <p class="shipping-fee"><strong>Shipping Fee:</strong> ₱<span id="shipping-fee">50</span></p>
        <p class="final-total"><strong>Final Total:</strong> ₱<span id="final-total">0</span></p>

        <!-- Payment Methods -->
        <div class="payment-methods">
            <h3>Mode of Payment</h3>
            <label><input type="radio" name="payment" value="Credit Card" required> Credit Card</label>
            <label><input type="radio" name="payment" value="Cash on Delivery" required> Cash on Delivery</label>
            <label><input type="radio" name="payment" value="Gcash" required> Gcash</label>
        </div>

        <button onclick="completeCheckout()">Complete Checkout</button>
    </div>

    <script>
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const cartItemsElement = document.querySelector(".cart-items");
        const cartTotalElement = document.getElementById("cart-total");
        const shippingFeeElement = document.getElementById("shipping-fee");
        const finalTotalElement = document.getElementById("final-total");

        const SHIPPING_FEE = 50; // Set a fixed shipping fee

        // Render cart items and totals
        function renderCheckout() {
            cartItemsElement.innerHTML = '';
            cart.forEach((item) => {
                const li = document.createElement("li");
                li.innerHTML = `
                    <strong>${item.product}</strong> - ₱${item.price} x ${item.quantity} = ₱${(item.price * item.quantity).toFixed(2)}
                `;
                cartItemsElement.appendChild(li);
            });

            const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
            cartTotalElement.textContent = total.toFixed(2);
            shippingFeeElement.textContent = SHIPPING_FEE.toFixed(2);
            finalTotalElement.textContent = (total + SHIPPING_FEE).toFixed(2);
        }

        // Handle checkout
        function completeCheckout() {
            const name = document.getElementById("name").value;
            const contact = document.getElementById("contact").value;
            const email = document.getElementById("email").value;
            const address = document.getElementById("address").value;
            const paymentMethod = document.querySelector('input[name="payment"]:checked');

            if (!name || !contact || !email || !address) {
                alert("Please fill out all the required fields.");
                return;
            }

            if (!paymentMethod) {
                alert("Please select a payment method.");
                return;
            }

            const customerInfo = {
                name,
                contact,
                email,
                address,
                paymentMethod: paymentMethod.value
            };

            alert(`Thank you, ${customerInfo.name}! Your order has been placed.\nPayment Method: ${customerInfo.paymentMethod}\nTotal: ₱${finalTotalElement.textContent}`);
            localStorage.removeItem("cart"); // Clear cart
            window.location.href = "HomePage.html"; // Redirect to homepage
        }

        renderCheckout();

        window.addEventListener("scroll", function() {
            var header = document.querySelector("header");
            header.classList.toggle("sticky", window.scrollY > 0);
        });

    </script>
</body>
</html>
