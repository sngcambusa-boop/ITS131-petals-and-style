<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - Petals & Style Flowershop</title>
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
                        <li class="nav__item"><a href="about.php" class="nav__link">About</a></li>
                        <li class="nav__item"><a href="features.php" class="nav__link active">Features</a></li>
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
        <section class="page-banner page-banner--features">
            <div class="container">
                <h1 class="page-banner__title">System Features</h1>
                <p class="page-banner__breadcrumb"><a href="index.php">Home</a> / Features</p>
            </div>
        </section>

        <!-- Major Features -->
        <section class="section features-detail">
            <div class="container">
                <div class="section__header">
                    <span class="section__label">What We Offer</span>
                    <h2 class="section__title">Powerful Features for Your Flowershop</h2>
                    <p class="section__description">Every tool you need to manage inventory, orders, and reporting — all in one place.</p>
                </div>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-card__icon"><i class="fa-solid fa-warehouse"></i></div>
                        <h3>Inventory Management</h3>
                        <p>Track all flower stock in real time. Receive automated alerts when stock runs low or when flowers approach spoilage dates. Categorize by type, supplier, and freshness level.</p>
                        <ul class="feature-card__tags">
                            <li>Stock Tracking</li>
                            <li>Spoilage Alerts</li>
                            <li>Supplier Management</li>
                        </ul>
                    </div>
                    <div class="feature-card">
                        <div class="feature-card__icon"><i class="fa-solid fa-cart-shopping"></i></div>
                        <h3>Order Management</h3>
                        <p>Create, update, and track customer orders seamlessly. Manage delivery schedules, assign order statuses, and maintain complete order histories for every client.</p>
                        <ul class="feature-card__tags">
                            <li>Order Creation</li>
                            <li>Status Tracking</li>
                            <li>Delivery Scheduling</li>
                        </ul>
                    </div>
                    <div class="feature-card">
                        <div class="feature-card__icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                        <h3>Sales Reporting</h3>
                        <p>Generate comprehensive sales reports with beautiful visualizations. Analyze daily, weekly, and monthly revenue trends to identify peak seasons and optimize pricing.</p>
                        <ul class="feature-card__tags">
                            <li>Revenue Analytics</li>
                            <li>Trend Charts</li>
                            <li>Export to PDF</li>
                        </ul>
                    </div>
                    <div class="feature-card">
                        <div class="feature-card__icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <h3>Spoilage Tracking</h3>
                        <p>Monitor flower freshness and automatically log spoilage events. Generate spoilage reports to identify patterns and reduce waste, saving your business money.</p>
                        <ul class="feature-card__tags">
                            <li>Freshness Monitoring</li>
                            <li>Waste Analytics</li>
                            <li>Cost Reduction</li>
                        </ul>
                    </div>
                    <div class="feature-card">
                        <div class="feature-card__icon"><i class="fa-solid fa-users"></i></div>
                        <h3>Customer Management</h3>
                        <p>Maintain a secure database of customer profiles, purchase histories, and preferences. Build better relationships through personalized service.</p>
                        <ul class="feature-card__tags">
                            <li>Customer Profiles</li>
                            <li>Purchase History</li>
                            <li>Preferences</li>
                        </ul>
                    </div>
                    <div class="feature-card">
                        <div class="feature-card__icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <h3>Secure Access Control</h3>
                        <p>Role-based authentication ensures only authorized personnel access sensitive data. Every action is logged for accountability and audit trails.</p>
                        <ul class="feature-card__tags">
                            <li>Role-Based Access</li>
                            <li>Activity Logs</li>
                            <li>Encrypted Data</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- System Mockup Preview -->
        <section class="section preview-section">
            <div class="container">
                <div class="section__header">
                    <span class="section__label">Sneak Peek</span>
                    <h2 class="section__title">System Interface Preview</h2>
                </div>
                <div class="preview-grid">
                    <div class="preview-card">
                        <div class="preview-card__img"><i class="fa-solid fa-gauge-high"></i></div>
                        <span>Dashboard</span>
                    </div>
                    <div class="preview-card">
                        <div class="preview-card__img"><i class="fa-solid fa-table-list"></i></div>
                        <span>Records</span>
                    </div>
                    <div class="preview-card">
                        <div class="preview-card__img"><i class="fa-solid fa-chart-pie"></i></div>
                        <span>Reports</span>
                    </div>
                    <div class="preview-card">
                        <div class="preview-card__img"><i class="fa-solid fa-user-gear"></i></div>
                        <span>Profile</span>
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