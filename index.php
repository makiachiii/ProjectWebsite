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
</head>
<body>
    <header>
        <a href="#Home" class="logo" aria-label="Go to Home">@ELI'S SWEET CREATIONS</a>
        <nav>
            <ul>
            <li><button onclick="location.href='login.php'">Log In</button></li>
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
                </div>
                <div class="carousel-item">
                    <img src="kik9.png" alt="Cake 2">
                    <h3>Choco Strawberry Cake</h3>
                </div>
                <div class="carousel-item">
                    <img src="kik10.png" alt="Cake 3">
                    <h3>Fruitcake</h3>
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
                </div>
                <div class="carousel-item2">
                    <img src="3 tier.jpg" alt="Cake 2">
                    <h3>Choco Strawberry Cake</h3>
                </div>
                <div class="carousel-item2">
                    <img src="bento.jpg" alt="Cake 3">
                    <h3>Fruitcake</h3>
                </div>
            </div>
        </div>
    </section>

    <section id="footer">
        <h2>"Delighting Taste Buds, Delivering Smiles."</h2>
    </section>

    

    

    <script>
    // Sticky header on scroll
    window.addEventListener("scroll", function () {
        const header = document.querySelector("header");
        header.classList.toggle("sticky", window.scrollY > 0);

        // Add shadow effect for sticky header
        if (window.scrollY > 0) {
            header.style.boxShadow = "0 4px 6px rgba(0, 0, 0, 0.1)";
        } else {
            header.style.boxShadow = "none";
        }
    });

    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll("nav a[href^='#']");
    navLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const targetId = this.getAttribute("href").substring(1);
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                window.scrollTo({
                    top: targetSection.offsetTop - document.querySelector("header").offsetHeight,
                    behavior: "smooth"
                });
            }
        });
    });

    
</script>

</body>

</html>
