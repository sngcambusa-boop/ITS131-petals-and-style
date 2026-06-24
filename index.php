<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petals & Style Flowershop - Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header & Navigation -->
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
                        <li class="nav__item"><a href="index.php" class="nav__link active">Home</a></li>
                        <li class="nav__item"><a href="about.php" class="nav__link">About</a></li>
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

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="hero__overlay"></div>
        <div class="container">
            <div class="hero__content">
                <span class="hero__badge">Web-Based Management System</span>
                <h1 class="hero__title">Streamline Your <span class="text-accent">Flowershop</span> Operations</h1>
                <p class="hero__subtitle">
                    Automate inventory tracking, organize customer orders, and generate real-time sales &amp; spoilage reports — all in one secure, elegant platform.
                </p>
                <div class="hero__cta">
                    <a href="register.php" class="btn btn--primary">Get Started <i class="fa-solid fa-arrow-right"></i></a>
                    <a href="features.php" class="btn btn--outline">Explore Features</a>
                </div>
                <div class="hero__stats">
                    <div class="hero__stat"><span class="hero__stat-number">100%</span><span class="hero__stat-label">Secure</span></div>
                    <div class="hero__stat"><span class="hero__stat-number">24/7</span><span class="hero__stat-label">Access</span></div>
                    <div class="hero__stat"><span class="hero__stat-number">Real-Time</span><span class="hero__stat-label">Reports</span></div>
                </div>
            </div>
        </div>
        <div class="hero__wave">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path d="M0,60 C360,120 720,0 1440,60 L1440,120 L0,120 Z" fill="#fefaf6"/></svg>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro section" id="intro">
        <div class="container">
            <div class="section__header">
                <span class="section__label">Welcome to</span>
                <h2 class="section__title">Petals & Style Management System</h2>
                <p class="section__description">
                    A comprehensive web-based solution designed specifically for retail flower shops. Replace cumbersome manual logs with a streamlined digital platform that handles everything from inventory to customer orders.
                </p>
            </div>
            <div class="intro__cards">
                <div class="intro__card">
                    <div class="intro__card-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                    <h3>Inventory Tracking</h3>
                    <p>Monitor stock levels, track flower freshness, and receive spoilage alerts automatically.</p>
                </div>
                <div class="intro__card">
                    <div class="intro__card-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                    <h3>Order Management</h3>
                    <p>Organize customer orders, manage deliveries, and track order statuses in real time.</p>
                </div>
                <div class="intro__card">
                    <div class="intro__card-icon"><i class="fa-solid fa-chart-line"></i></div>
                    <h3>Sales & Spoilage Reports</h3>
                    <p>Generate insightful reports that help you optimize pricing, reduce waste, and boost profitability.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="cta-banner section">
        <div class="container">
            <div class="cta-banner__inner">
                <div class="cta-banner__text">
                    <h3>Ready to transform your flowershop?</h3>
                    <p>Join dozens of florists who have already digitized their operations.</p>
                </div>
                <a href="register.php" class="btn btn--light">Create Free Account</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
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