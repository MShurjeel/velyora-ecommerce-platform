/**
 * Velyora Main Frontend JavaScript
 * Handles global navigation, header dropdowns (Account & Cart), mobile menu, and shared UI behaviors.
 */

document.addEventListener('DOMContentLoaded', function () {
    const accountDropdown = document.querySelector('.account-dropdown');
    const accountToggle = document.querySelector('.account-dropdown-toggle');

    const cartDropdown = document.querySelector('.cart-dropdown');
    const cartToggle = document.querySelector('.cart-dropdown-toggle');

    // Close all open header dropdowns
    function closeAllDropdowns() {
        if (accountDropdown) {
            accountDropdown.classList.remove('active');
            if (accountToggle) accountToggle.setAttribute('aria-expanded', 'false');
        }
        if (cartDropdown) {
            cartDropdown.classList.remove('active');
            if (cartToggle) cartToggle.setAttribute('aria-expanded', 'false');
        }
    }

    // Toggle Account Dropdown (closes Cart if open)
    if (accountToggle && accountDropdown) {
        accountToggle.addEventListener('click', function (e) {
            e.preventDefault();
            const willOpen = !accountDropdown.classList.contains('active');
            closeAllDropdowns();
            if (willOpen) {
                accountDropdown.classList.add('active');
                accountToggle.setAttribute('aria-expanded', 'true');
            }
        });
    }

    // Toggle Cart Dropdown (closes Account if open)
    if (cartToggle && cartDropdown) {
        cartToggle.addEventListener('click', function (e) {
            e.preventDefault();
            const willOpen = !cartDropdown.classList.contains('active');
            closeAllDropdowns();
            if (willOpen) {
                cartDropdown.classList.add('active');
                cartToggle.setAttribute('aria-expanded', 'true');
            }
        });
    }

    // Mobile Hamburger Menu Toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-button');
    const categoryNavbar = document.querySelector('.category-navbar');
    if (mobileMenuBtn && categoryNavbar) {
        mobileMenuBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            categoryNavbar.classList.toggle('mobile-open');
            const isOpen = categoryNavbar.classList.contains('mobile-open');
            mobileMenuBtn.innerHTML = isOpen ? '<i class="bi bi-x-lg"></i>' : '<i class="bi bi-list"></i>';
        });
    }

    // Mobile Catalog Filter Toggle
    const filterBtn = document.querySelector('.mobile-filter-button');
    const sidebar = document.querySelector('.catalog-sidebar');
    if (filterBtn && sidebar) {
        filterBtn.addEventListener('click', function () {
            sidebar.classList.toggle('mobile-visible');
            const isVisible = sidebar.classList.contains('mobile-visible');
            filterBtn.innerHTML = isVisible 
                ? '<i class="bi bi-x-lg"></i> Close' 
                : '<i class="bi bi-sliders"></i> Filters';
        });
    }

    // Click outside handler: close dropdowns when clicking outside
    document.addEventListener('click', function (e) {
        const clickedInsideAccount = accountDropdown && accountDropdown.contains(e.target);
        const clickedInsideCart = cartDropdown && cartDropdown.contains(e.target);

        if (!clickedInsideAccount && !clickedInsideCart) {
            closeAllDropdowns();
        }

        // Close mobile menu when clicking outside
        if (categoryNavbar && !categoryNavbar.contains(e.target) && !mobileMenuBtn?.contains(e.target)) {
            categoryNavbar.classList.remove('mobile-open');
            if (mobileMenuBtn) mobileMenuBtn.innerHTML = '<i class="bi bi-list"></i>';
        }
    });

    // Close dropdowns on Escape key press
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
            if (categoryNavbar) {
                categoryNavbar.classList.remove('mobile-open');
                if (mobileMenuBtn) mobileMenuBtn.innerHTML = '<i class="bi bi-list"></i>';
            }
        }
    });
});
