<?php
$pageTitle = "Contact Us — Velyora";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<main>

    <!-- =========================================================
         HERO SECTION
    ========================================================= -->
    <section class="contact-hero">
        <div class="container">
            <div class="contact-hero-content">
                <div>
                    <span class="contact-eyebrow">GET IN TOUCH</span>
                    <h1>We’re Here to <span>Help.</span></h1>
                    <p>
                        Have a question about an order, product or delivery?
                        Our team is ready to help you with anything you need.
                    </p>
                </div>

                <nav class="contact-breadcrumb">
                    <a href="index.php">Home</a>
                    <i class="bi bi-chevron-right"></i>
                    <span>Contact</span>
                </nav>
            </div>
        </div>
    </section>

    <!-- =========================================================
         MAIN SECTION 1: CONTACT HUB (INFO & FORM)
    ========================================================= -->
    <section class="contact-section">
        <div class="container">

            <div class="contact-grid">

                <!-- Left: Blue Info Card -->
                <aside class="contact-information">

                    <div class="contact-info-top">
                        <span class="contact-card-eyebrow">CONTACT VELYORA</span>

                        <h2>Let’s Start a Conversation.</h2>

                        <p>
                            Whether you need help with an order or simply
                            want to know more about our products, we're here
                            for you.
                        </p>
                    </div>

                    <div class="contact-info-list">

                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <div>
                                <span>Visit Us</span>
                                <strong>123 Fashion Street</strong>
                                <small>New York, NY 10001</small>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <i class="bi bi-telephone"></i>
                            </span>
                            <div>
                                <span>Call Us</span>
                                <strong>+1 (555) 123-4567</strong>
                                <small>Mon–Fri, 9am–6pm</small>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <div>
                                <span>Email Us</span>
                                <strong>hello@velyora.com</strong>
                                <small>We usually reply within 24 hours</small>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <i class="bi bi-clock"></i>
                            </span>
                            <div>
                                <span>Working Hours</span>
                                <strong>Monday–Friday</strong>
                                <small>9:00 AM – 6:00 PM</small>
                            </div>
                        </div>

                    </div>

                    <div class="contact-social">
                        <span>FOLLOW VELYORA</span>

                        <div>
                            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                            <a href="#" aria-label="Pinterest"><i class="bi bi-pinterest"></i></a>
                        </div>
                    </div>

                </aside>

                <!-- Right: Form Card -->
                <div class="contact-form-card">

                    <div class="contact-form-heading">
                        <span>WE'D LOVE TO HEAR FROM YOU</span>
                        <h2>Send Us a Message</h2>
                        <p>
                            Fill out the form below and our support team
                            will get back to you as soon as possible.
                        </p>
                    </div>

                    <form class="contact-form">

                        <div class="contact-form-row">
                            <div class="contact-field">
                                <label for="contact-name">Your Name</label>
                                <div class="contact-input">
                                    <i class="bi bi-person"></i>
                                    <input type="text" id="contact-name" name="name" placeholder="Enter your name" required>
                                </div>
                            </div>
                            <div class="contact-field">
                                <label for="contact-email">Email Address</label>
                                <div class="contact-input">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" id="contact-email" name="email" placeholder="you@example.com" required>
                                </div>
                            </div>
                        </div>

                        <div class="contact-form-row">
                            <div class="contact-field">
                                <label for="contact-phone">Phone Number</label>
                                <div class="contact-input">
                                    <i class="bi bi-telephone"></i>
                                    <input type="tel" id="contact-phone" name="phone" placeholder="+92 300 1234567">
                                </div>
                            </div>
                            <div class="contact-field">
                                <label for="contact-subject">Subject</label>
                                <div class="contact-input">
                                    <i class="bi bi-chat-left-text"></i>
                                    <input type="text" id="contact-subject" name="subject" placeholder="How can we help?">
                                </div>
                            </div>
                        </div>

                        <div class="contact-field">
                            <label for="contact-message">Your Message</label>
                            <div class="contact-input contact-textarea">
                                <i class="bi bi-pencil"></i>
                                <textarea id="contact-message" name="message" rows="7" placeholder="Tell us how we can help..." required></textarea>
                            </div>
                        </div>

                        <div class="contact-form-footer">
                            <div class="contact-form-note">
                                <i class="bi bi-shield-check"></i>
                                <span>Your information is safe with us.</span>
                            </div>
                            <button type="submit" class="contact-submit">
                                Send Message
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </section>

    <!-- =========================================================
         MAIN SECTION 2: MAP & TRUST FEATURES (MERGED)
    ========================================================= -->
    <section class="contact-location" style="padding-top: 0;">
        <div class="container">

            <div class="contact-location-card">

                <!-- Left: Trust Features (Replaces redundant address text) -->
                <div class="contact-location-content">

                    <span class="contact-eyebrow">WHY VELYORA</span>

                    <h2>Support You Can Count On.</h2>

                    <p>
                        From your first question to your final delivery,
                        we're committed to making your experience simple and secure.
                    </p>

                    <!-- Reusing location-details CSS to beautifully format the 3 features -->
                    <div class="contact-location-details" style="margin-top: 20px;">

                        <div>
                            <i class="bi bi-lightning-charge"></i>
                            <span>
                                <strong style="display:block; color:var(--color-heading); font-size:13px; margin-bottom:2px;">Quick Response</strong>
                                Our team aims to respond within one business day.
                            </span>
                        </div>

                        <div>
                            <i class="bi bi-headset"></i>
                            <span>
                                <strong style="display:block; color:var(--color-heading); font-size:13px; margin-bottom:2px;">Personal Support</strong>
                                Get helpful answers from a real team member.
                            </span>
                        </div>

                        <div>
                            <i class="bi bi-shield-check"></i>
                            <span>
                                <strong style="display:block; color:var(--color-heading); font-size:13px; margin-bottom:2px;">Secure & Private</strong>
                                Your contact information is handled securely.
                            </span>
                        </div>

                    </div>

                    <a href="#" class="contact-directions">
                        Get Directions to our Store
                        <i class="bi bi-arrow-up-right"></i>
                    </a>

                </div>

                <!-- Right: The Map -->
                <div class="contact-map">
                    <div class="contact-map-placeholder">
                        <i class="bi bi-geo-alt-fill"></i>

                        <strong>Velyora Flagship</strong>

                        <span>
                            123 Fashion Street, New York
                        </span>

                        <a href="#">
                            Open in Maps
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>