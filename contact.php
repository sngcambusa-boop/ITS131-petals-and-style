<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Petals & Style Flowershop</title>
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
                        <li class="nav__item"><a href="features.php" class="nav__link">Features</a></li>
                        <li class="nav__item"><a href="contact.php" class="nav__link active">Contact</a></li>
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
        <section class="page-banner">
            <div class="container">
                <h1 class="page-banner__title">Contact Us</h1>
                <p class="page-banner__breadcrumb"><a href="index.php">Home</a> / Contact</p>
            </div>
        </section>

        <section class="section contact-section">
            <div class="container">
                <div class="contact-grid">
                    <!-- Contact Info -->
                    <div class="contact-info">
                        <h2>Get In Touch</h2>
                        <p class="contact-info__intro">Have questions about the system? Need a demo? We'd love to hear from you. Reach out through any of the channels below.</p>
                        <div class="contact-info__items">
                            <div class="contact-info__item">
                                <div class="contact-info__icon"><i class="fa-solid fa-location-dot"></i></div>
                                <div>
                                    <h4>Our Location</h4>
                                    <p>National Highway, Baraca<br>Subic, Zambales 2209</p>
                                </div>
                            </div>
                            <div class="contact-info__item">
                                <div class="contact-info__icon"><i class="fa-solid fa-phone"></i></div>
                                <div>
                                    <h4>Phone</h4>
                                    <p>+63 0962 2081 167</p>
                                </div>
                            </div>
                            <div class="contact-info__item">
                                <div class="contact-info__icon"><i class="fa-solid fa-envelope"></i></div>
                                <div>
                                    <h4>Email</h4>
                                    <p>info@petalsandstyle.ph<br>support@petalsandstyle.ph</p>
                                </div>
                            </div>
                            <div class="contact-info__item">
                                <div class="contact-info__icon"><i class="fa-solid fa-clock"></i></div>
                                <div>
                                    <h4>Business Hours</h4>
                                    <p>Monday - Friday<br>8:00 AM - 6:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contact Form -->
                    <div class="contact-form-wrapper">
                        <h2>Send a Message</h2>
                        <form class="contact-form" id="contactForm">
                            <div class="form-group">
                                <label for="contactName">Full Name <span class="required">*</span></label>
                                <input type="text" id="contactName" name="contactName" placeholder="Enter your full name" required>
                            </div>
                            <div class="form-group">
                                <label for="contactEmail">Email Address <span class="required">*</span></label>
                                <input type="email" id="contactEmail" name="contactEmail" placeholder="Enter your email address" required>
                            </div>
                            <div class="form-group">
                                <label for="contactSubject">Subject</label>
                                <input type="text" id="contactSubject" name="contactSubject" placeholder="What is this about?">
                            </div>
                            <div class="form-group">
                                <label for="contactMessage">Message <span class="required">*</span></label>
                                <textarea id="contactMessage" name="contactMessage" rows="5" placeholder="Write your message here..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn--primary btn--full">Send Message <i class="fa-solid fa-paper-plane"></i></button>
                        </form>
                        <div class="form-success" id="formSuccess" style="display:none;">
                            <i class="fa-solid fa-circle-check"></i>
                            <p>Thank you! Your message has been sent successfully. We'll get back to you soon.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map Placeholder -->
        <section class="section map-section">
            <div class="container">
                <div class="map-placeholder">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <p>Map Location — 123 Blossom Street, Florist District, Metro Manila</p>
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