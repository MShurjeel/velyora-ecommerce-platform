<!-- =========================================================
     FOOTER
========================================================= -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-main">
            <div>
                <a href="{{ route('home') }}" class="footer-logo">
                    <img src="{{ asset('assets/images/logo/logo-dark-bg.png') }}" alt="Velyora">
                </a>
                <p>Everything you love, carefully brought together in one place.</p>
            </div>
            
            <div>
                <h4>Shop</h4>
                <a href="{{ route('products.index') }}">All Products</a>
                <a href="{{ route('products.index', ['sort' => 'newest']) }}">New Arrivals</a>
                <a href="{{ route('products.index', ['sort' => 'featured']) }}">Best Sellers</a>
                <a href="{{ route('products.index', ['filter' => 'sale']) }}">Deals & Offers</a>
            </div>
            
            <div>
                <h4>Support</h4>
                <a href="{{ route('contact') }}">Contact Us</a>
                <a href="{{ route('contact') }}">Shipping & Delivery</a>
                <a href="{{ route('contact') }}">Returns & Exchanges</a>
                <a href="{{ route('contact') }}">Help Center & FAQs</a>
            </div>
            
            <div>
                <h4>Follow Us</h4>
                <div class="footer-socials">
                    <a href="https://facebook.com" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="https://tiktok.com" target="_blank" rel="noopener" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Velyora. All rights reserved.</p>
            <div>
                <a href="{{ route('contact') }}">Privacy Policy</a>
                <a href="{{ route('contact') }}">Terms & Conditions</a>
            </div>
        </div>
    </div>
</footer>
