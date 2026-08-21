<?php
$pageTitle = "Sign In — Velyora";
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
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <h1>Login</h1>
            <nav class="breadcrumb">
                <a href="index.php">Home</a>
                <span>/</span>
                <span>Login</span>
            </nav>
        </div>
    </div>
</section>
<main>
<section class="login-page">
    <div class="container">
        <div class="login-wrapper">
            <div class="login-intro">
                <span class="login-eyebrow">WELCOME TO VELYORA</span>
                <h1>Everything you love, <span>starts here.</span></h1>
                <p>Sign in to manage your orders, track deliveries, save your favorite products and enjoy a smoother shopping experience.</p>
                <div class="login-benefits">
                    <div class="login-benefit">
                        <span class="login-benefit-icon">
                            <i class="bi bi-box-seam"></i>
                        </span>
                        <div>
                            <strong>Track Your Orders</strong>
                            <span>Stay updated from purchase to delivery.</span>
                        </div>
                    </div>
                    <div class="login-benefit">
                        <span class="login-benefit-icon">
                            <i class="bi bi-heart"></i>
                        </span>
                        <div>
                            <strong>Save Your Favorites</strong>
                            <span>Keep products you love in one place.</span>
                        </div>
                    </div>
                    <div class="login-benefit">
                        <span class="login-benefit-icon">
                            <i class="bi bi-shield-check"></i>
                        </span>
                        <div>
                            <strong>Secure Shopping</strong>
                            <span>Your account information stays protected.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="login-card">
                <div class="login-card-header">
                    <div class="login-card-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <div>
                        <span>ACCOUNT</span>
                        <h2>Welcome Back</h2>
                    </div>
                </div>
                <p class="login-card-description">Sign in to continue to your Velyora account.</p>
                <form class="login-form" action="#" method="post">
                    <div class="login-field">
                        <label for="login-email">Email Address</label>
                        <div class="login-input">
                            <i class="bi bi-envelope"></i>
                            <input type="email" id="login-email" name="email" placeholder="Enter your email address" autocomplete="email" required>
                        </div>
                    </div>
                    <div class="login-field">
                        <div class="login-label-row">
                            <label for="login-password">Password</label>
                            <a href="#">Forgot Password?</a>
                        </div>
                        <div class="login-input">
                            <i class="bi bi-lock"></i>
                            <input type="password" id="login-password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                            <button type="button" class="login-password-toggle" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <label class="login-remember">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <button type="submit" class="login-submit">
                        Sign In
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </form>
                <div class="login-divider">
                    <span>OR CONTINUE WITH</span>
                </div>
                <div class="login-socials">
                    <button type="button">
                        <i class="bi bi-google"></i>
                        Google
                    </button>
                    <button type="button">
                        <i class="bi bi-apple"></i>
                        Apple
                    </button>
                </div>
                <div class="login-register">
                    <span>Don't have an account?</span>
                    <a href="#">Create an Account</a>
                </div>
                <div class="login-security">
                    <i class="bi bi-shield-lock"></i>
                    <span>Your information is protected with secure encryption.</span>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
<?php include 'includes/footer.php'; ?>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
    const toggle=document.querySelector('.login-password-toggle');
    const password=document.querySelector('#login-password');
    if(toggle&&password){
        toggle.addEventListener('click',function(){
            const isPassword=password.type==='password';
            password.type=isPassword?'text':'password';
            toggle.setAttribute('aria-label',isPassword?'Hide password':'Show password');
            toggle.innerHTML=isPassword?'<i class="bi bi-eye-slash"></i>':'<i class="bi bi-eye"></i>';
        });
    }
});
</script>
</body>
</html>