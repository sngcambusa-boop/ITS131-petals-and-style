<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Petals & Style Flowershop</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header" id="header">
        <div class="container">
            <div class="header__inner">
                <a href="index.php" class="logo">
                    <i class="fa-solid fa-flower-daffodil logo__icon"></i>
                    <div class="logo__text">
                        <span class="logo__name">Petals & Style</span>
                        <span class="logo__tagline">Flowershop</span>
                    </div>
                </a>
                <nav class="nav" id="nav">
                    <ul class="nav__list">
                        <li class="nav__item"><a href="index.php" class="nav__link">Home</a></li>
                        <li class="nav__item"><a href="about.php" class="nav__link active">About</a></li>
                        <li class="nav__item"><a href="features.php" class="nav__link">Features</a></li>
                        <li class="nav__item"><a href="contact.php" class="nav__link">Contact</a></li>
                        <li class="nav__item nav__item--cta"><a href="login.php" class="nav__link nav__link--btn">Login</a></li>
                    </ul>
                </nav>
                <button class="hamburger" id="hamburger" aria-label="Menu">
                    <span class="hamburger__line"></span>
                    <span class="hamburger__line"></span>
                    <span class="hamburger__line"></span>
                </button>
            </div>
        </div>
    </header>

    <main>
        <!-- Page Banner -->
        <section class="page-banner">
            <div class="container">
                <h1 class="page-banner__title">About Our System</h1>
                <p class="page-banner__breadcrumb"><a href="index.php">Home</a> / About</p>
            </div>
        </section>

        <!-- Background Section -->
        <section class="section about-section">
            <div class="container">
                <div class="about-grid">
                    <div class="about-grid__image">
                        <div class="about-image-placeholder">
                            <i class="fa-solid fa-shop"></i>
                            <span>Petals & Style Flowershop</span>
                        </div>
                    </div>
                    <div class="about-grid__content">
                        <span class="section__label">Background</span>
                        <h2 class="section__title">The Story Behind Petals & Style</h2>
                        <p>
                            Petals & Style Flowershop was established with a passion for bringing beauty and elegance to every occasion through stunning floral arrangements. Over the years, the shop has grown from a small local florist to a bustling retail operation serving hundreds of customers monthly.
                        </p>
                        <p>
                            As the business expanded, manual logs and paper-based tracking became increasingly inefficient. Inventory spoilage went unnoticed, order tracking was cumbersome, and generating sales reports required hours of manual computation. The need for a digital transformation became undeniable.
                        </p>
                        <p>
                            The <strong>Web-Based Management System</strong> was conceptualized to address these pain points — replacing outdated manual processes with a secure, automated, and real-time digital platform.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission & Vision -->
        <section class="section mv-section">
            <div class="container">
                <div class="mv-grid">
                    <div class="mv-card mv-card--mission">
                        <div class="mv-card__icon"><i class="fa-solid fa-bullseye"></i></div>
                        <h3>Our Mission</h3>
                        <p>To provide flower shops with an intuitive, secure, and efficient management system that automates daily operations, minimizes waste, and empowers business owners to make data-driven decisions.</p>
                    </div>
                    <div class="mv-card mv-card--vision">
                        <div class="mv-card__icon"><i class="fa-solid fa-eye"></i></div>
                        <h3>Our Vision</h3>
                        <p>To become the leading digital management solution for retail florists nationwide — bridging the gap between traditional floral artistry and modern business technology.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Project Objectives -->
        <section class="section objectives-section">
            <div class="container">
                <div class="section__header">
                    <span class="section__label">Purpose</span>
                    <h2 class="section__title">Project Objectives</h2>
                    <p class="section__description">The primary goals that drive the development of this management system.</p>
                </div>
                <div class="objectives-list">
                    <div class="objective-item">
                        <span class="objective-item__number">01</span>
                        <div class="objective-item__content">
                            <h4>Automate Inventory Management</h4>
                            <p>Replace manual stock logs with real-time inventory tracking, including automated spoilage alerts based on flower freshness windows.</p>
                        </div>
                    </div>
                    <div class="objective-item">
                        <span class="objective-item__number">02</span>
                        <div class="objective-item__content">
                            <h4>Streamline Order Processing</h4>
                            <p>Organize all customer orders digitally — from placement to delivery — with status tracking and automated notifications.</p>
                        </div>
                    </div>
                    <div class="objective-item">
                        <span class="objective-item__number">03</span>
                        <div class="objective-item__content">
                            <h4>Generate Actionable Reports</h4>
                            <p>Produce real-time sales summaries, spoilage analyses, and profitability reports that enable smarter business decisions.</p>
                        </div>
                    </div>
                    <div class="objective-item">
                        <span class="objective-item__number">04</span>
                        <div class="objective-item__content">
                            <h4>Ensure Data Security</h4>
                            <p>Implement robust database connectivity with secure authentication, role-based access, and encrypted data storage.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer__grid">
                <div class="footer__brand">
                    <a href="index.php" class="logo logo--footer">
                        <i class="fa-solid fa-flower-daffodil logo__icon"></i>
                        <div class="logo__text">
                            <span class="logo__name">Petals & Style</span>
                            <span class="logo__tagline">Flowershop</span>
                        </div>
                    </a>
                    <p>Empowering flower shops with smart management solutions since 2026.</p>
                </div>
                <div class="footer__links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="features.php">Features</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer__links">
                    <h4>System</h4>
                    <ul>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="reports.php">Reports</a></li>
                    </ul>
                </div>
                <div class="footer__social">
                    <h4>Follow Us</h4>
                    <div class="social-icons">
                        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&pp=ygUebmV2ZXIgZ29ubmEgZ2l2ZSB5b3UgdXAgbHlyaWNz" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&pp=ygUebmV2ZXIgZ29ubmEgZ2l2ZSB5b3UgdXAgbHlyaWNz" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer__bottom">
                <p>&copy; 2026 Petals & Style Flowershop Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>