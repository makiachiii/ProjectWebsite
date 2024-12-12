<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Delivery Tracking</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            background: url("p1.png") no-repeat center center;
            background-size: cover;
            background-attachment: absolute; 
            min-height: 100vh;
        }

        #map {
            width: 100%; 
            margin-top: 110px;
            height: 70vh;
            border: 2px solid #ccc;
            border-radius: 8px;
            margin-right: 20px;
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
            z-index: 1000;
        }

        header .logo {
            font-weight: 700;
            color: #323030;
            text-decoration: none;
            font-size: 2em;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.6s;
            text-shadow: -4px 5px 8px #dfa7a7;
        }

        header ul {
            display: flex;
            justify-content: center;
            align-items: center;
            text-shadow: -4px 5px 8px #dfa7a7;
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

        #status {
            width: 30%;
            margin-top: 350px;
            padding: 30px;
            background: #ffcccb; /* Pinkish hue */
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .status-title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            color: #333;
        }
        header.sticky{
    background-color: #dfa7a7;
}

        .status-item {
            display: flex;
            align-items: center;
            margin-top: 20px;
            font-size: 18px;
            font-weight: 600;
            position: relative;
            padding-left: 30px;
            color: #333;
            transition: 0.3s;
            cursor: pointer;
        }

        .status-item:hover {
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            padding-left: 25px;
            transition: 0.3s ease-in-out;
        }

        .status-item::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: gray;
            transition: 0.3s;
        }

        .status-item.completed::before {
            background: green;
        }

        .status-item.active::before {
            background: blue;
        }

        .status-item.inactive::before {
            background: lightgray;
        }

        /* Adding icons for visual appeal */
        .status-item i {
            margin-right: 15px;
            font-size: 22px;
        }

        .status-item.active i {
            color: #007bff;
        }

        .status-item.completed i {
            color: green;
        }

        .status-item.inactive i {
            color: lightgray;
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

    <div id="map"></div>

    <div id="status">
        <h2 class="status-title">Order Status</h2>
        <div id="orderPlaced" class="status-item active">
            <i class="fas fa-box"></i> Order Placed
        </div>
        <div id="orderPacked" class="status-item inactive">
            <i class="fas fa-cogs"></i> Order Packed
        </div>
        <div id="orderOnItsWay" class="status-item inactive">
            <i class="fas fa-truck"></i> Order On Its Way
        </div>
        <div id="orderDelivered" class="status-item inactive">
            <i class="fas fa-check-circle"></i> Order Delivered
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- FontAwesome for Icons -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([14.4541, 120.9870], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: 'Â© OpenStreetMap'
        }).addTo(map);

        const destinationLocation = [14.4453, 120.9860];
        const destinationMarker = L.marker(destinationLocation).addTo(map);
        destinationMarker.bindPopup('<b>Destination</b><br>This is the delivery destination.').openPopup();

        const deliveryPersonMarker = L.marker([14.4641, 120.9885]).addTo(map);
        deliveryPersonMarker.bindPopup('<b>Delivery Person</b><br>Currently at this location.').openPopup();

        let orderStatus = 0;

        async function fetchDeliveryData() {
            return {
                deliveryPerson: { lat: 14.4641 + (Math.random() - 0.5) * 0.01, lng: 120.9885 + (Math.random() - 0.5) * 0.01 },
                destination: { lat: 14.4453, lng: 120.9860 }
            };
        }

        async function updateLocations() {
            const data = await fetchDeliveryData();
            if (data.deliveryPerson) {
                deliveryPersonMarker.setLatLng([data.deliveryPerson.lat, data.deliveryPerson.lng]);
                deliveryPersonMarker.getPopup().setContent('<b>Delivery Person</b><br>Currently at this location.').openOn(map);
            }

            if (orderStatus < 3) {
                orderStatus++;
                updateOrderStatus();
            }
        }

        function updateOrderStatus() {
            document.querySelectorAll('.status-item').forEach(item => {
                item.classList.remove('active', 'completed', 'inactive');
            });

            switch (orderStatus) {
                case 0:
                    document.getElementById('orderPlaced').classList.add('active');
                    break;
                case 1:
                    document.getElementById('orderPlaced').classList.add('completed');
                    document.getElementById('orderPacked').classList.add('active');
                    break;
                case 2:
                    document.getElementById('orderPacked').classList.add('completed');
                    document.getElementById('orderOnItsWay').classList.add('active');
                    break;
                case 3:
                    document.getElementById('orderOnItsWay').classList.add('completed');
                    document.getElementById('orderDelivered').classList.add('active');
                    break;
            }
        }

        setInterval(updateLocations, 2000);
    </script>
</body>
</html>