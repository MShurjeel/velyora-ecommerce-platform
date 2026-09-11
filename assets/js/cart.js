/**
 * Velyora Dynamic Cart & Wishlist Client Engine
 */
document.addEventListener('DOMContentLoaded', function () {
    // --- Toast Notification Helper ---
    function showToast(message, type = 'success') {
        let container = document.getElementById('velyora-toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'velyora-toast-container';
            container.style.cssText = `
                position: fixed;
                bottom: 24px;
                right: 24px;
                z-index: 99999;
                display: flex;
                flex-direction: column;
                gap: 10px;
                pointer-events: none;
            `;
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = `velyora-toast ${type}`;
        const icon = type === 'success' ? 'bi-check-circle-fill' : (type === 'danger' ? 'bi-exclamation-circle-fill' : 'bi-info-circle-fill');
        const iconColor = type === 'success' ? '#22c55e' : (type === 'danger' ? '#ef4444' : '#0A1020');

        toast.style.cssText = `
            pointer-events: auto;
            min-width: 280px;
            max-width: 380px;
            background: #ffffff;
            color: #111827;
            padding: 14px 18px;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            font-family: inherit;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        `;

        toast.innerHTML = `
            <i class="bi ${icon}" style="font-size: 18px; color: ${iconColor}; flex-shrink: 0;"></i>
            <span style="flex: 1; line-height: 1.4;">${message}</span>
            <button type="button" style="background:none; border:none; color:#9ca3af; cursor:pointer; font-size:16px; padding:0; line-height:1;" aria-label="Close">
                <i class="bi bi-x"></i>
            </button>
        `;

        container.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.style.transform = 'translateY(0)';
            toast.style.opacity = '1';
        });

        const closeBtn = toast.querySelector('button');
        const dismiss = () => {
            toast.style.transform = 'translateY(10px)';
            toast.style.opacity = '0';
            setTimeout(() => {
                if (toast.parentNode) toast.parentNode.removeChild(toast);
            }, 250);
        };

        closeBtn.addEventListener('click', dismiss);
        setTimeout(dismiss, 3500);
    }

    // --- Badge Updater ---
    function updateCartBadges(count) {
        const cartBadges = document.querySelectorAll('.cart-badge-count, .cart-dropdown-toggle .cart-count');
        cartBadges.forEach(badge => {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'grid' : 'none';
        });

        const miniCounts = document.querySelectorAll('.mini-cart-count');
        miniCounts.forEach(el => {
            el.textContent = `${count} item${count === 1 ? '' : 's'}`;
        });

        const cartHeadingCount = document.querySelector('.cart-heading-count');
        if (cartHeadingCount) {
            cartHeadingCount.textContent = `${count} item${count === 1 ? '' : 's'}`;
        }
    }

    function updateWishlistBadges(count) {
        const badges = document.querySelectorAll('.wishlist-badge-count');
        badges.forEach(badge => {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'grid' : 'none';
        });

        const profileBadge = document.querySelector('.profile-wishlist-badge');
        if (profileBadge) {
            profileBadge.textContent = count;
        }

        const totalCount = document.querySelector('.wishlist-total-count');
        if (totalCount) {
            totalCount.textContent = count;
        }
    }

    // --- Helper AJAX Fetcher ---
    async function sendAjax(url, data) {
        try {
            const formData = new FormData();
            for (const key in data) {
                formData.append(key, data[key]);
            }
            const res = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return await res.json();
        } catch (err) {
            console.error('AJAX Error:', err);
            return { success: false, message: 'Network connection failed.' };
        }
    }

    // =========================================================
    // 1. ADD TO CART HANDLERS
    // =========================================================
    document.addEventListener('click', async function (e) {
        const addBtn = e.target.closest('.product-add-cart, .catalog-add-cart, .add-cart-button, .add-to-cart-btn');
        if (!addBtn) return;

        e.preventDefault();
        const productId = addBtn.getAttribute('data-product-id');
        if (!productId) return;

        // Determine quantity if on detail page
        let quantity = 1;
        const qtyInput = document.getElementById('productQuantity');
        if (qtyInput && addBtn.classList.contains('product-add-cart')) {
            quantity = parseInt(qtyInput.value, 10) || 1;
        }

        const originalHtml = addBtn.innerHTML;
        addBtn.disabled = true;
        addBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';

        const result = await sendAjax('ajax/cart.php', {
            action: 'add',
            product_id: productId,
            quantity: quantity
        });

        addBtn.disabled = false;
        if (result.success) {
            addBtn.innerHTML = '<i class="bi bi-check2"></i> Added!';
            setTimeout(() => {
                addBtn.innerHTML = originalHtml;
            }, 1800);

            updateCartBadges(result.cart_count);
            showToast(result.message, 'success');
        } else {
            if (result.requires_login) {
                showToast('Please sign in to continue.', 'warning');
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 1000);
            } else {
                addBtn.innerHTML = originalHtml;
                showToast(result.message, 'danger');
            }
        }

        if (result.success) {

            // Refresh mini-cart subtotal if present
            if (result.totals && result.totals.subtotal_formatted) {
                const subtotalEl = document.querySelector('.mini-cart-subtotal');
                if (subtotalEl) subtotalEl.textContent = result.totals.subtotal_formatted;
            }

            // Re-render mini-cart items completely
            if (result.items) {
                const wrapper = document.querySelector('.cart-items-wrapper');
                if (wrapper) {
                    if (result.items.length === 0) {
                        wrapper.innerHTML = `
                            <div class="mini-cart-empty text-center py-4" style="padding: 24px 15px; color: var(--color-text-light); text-align: center;">
                                <i class="bi bi-bag" style="font-size: 28px; color: var(--color-border); display: block; margin-bottom: 8px;"></i>
                                <span style="font-size: 13px;">Your cart is empty</span>
                            </div>
                        `;
                    } else {
                        wrapper.innerHTML = result.items.map(item => `
                            <div class="cart-item mini-cart-item" data-cart-id="${item.cart_id}">
                                <a href="product.php?id=${item.product_id}">
                                    <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                                </a>
                                <div class="cart-item-details">
                                    <h6 class="cart-item-name">
                                        <a href="product.php?id=${item.product_id}" style="text-decoration:none; color:inherit;">
                                            ${item.name}
                                        </a>
                                    </h6>
                                    <span class="cart-item-variant">${item.variant}</span>
                                    <div class="cart-item-price-row">
                                        <span class="cart-item-price">Rs. ${item.price.toLocaleString()}</span>
                                        <span class="cart-item-qty">Qty: ${item.quantity}</span>
                                    </div>
                                </div>
                                <button type="button" class="cart-item-remove mini-cart-remove" data-cart-id="${item.cart_id}" title="Remove item"><i class="bi bi-x"></i></button>
                            </div>
                        `).join('');
                    }
                }
            }
        } else {
            addBtn.innerHTML = originalHtml;
            showToast(result.message || 'Could not add to cart.', 'danger');
        }
    });

    // =========================================================
    // 2. BUY IT NOW HANDLER
    // =========================================================
    document.addEventListener('click', async function (e) {
        const buyNowBtn = e.target.closest('.product-buy-now');
        if (!buyNowBtn) return;

        e.preventDefault();
        const productId = buyNowBtn.getAttribute('data-product-id');
        if (!productId) return;

        let quantity = 1;
        const qtyInput = document.getElementById('productQuantity');
        if (qtyInput) {
            quantity = parseInt(qtyInput.value, 10) || 1;
        }

        buyNowBtn.disabled = true;
        buyNowBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing...';

        const result = await sendAjax('ajax/cart.php', {
            action: 'add',
            product_id: productId,
            quantity: quantity
        });

        if (result.success) {
            window.location.href = 'checkout.php';
        } else {
            buyNowBtn.disabled = false;
            buyNowBtn.innerHTML = '<i class="bi bi-lightning-charge-fill"></i> Buy It Now';
            showToast(result.message || 'Could not process order.', 'danger');
        }
    });

    // =========================================================
    // 3. WISHLIST TOGGLE HANDLERS (Heart buttons across all pages)
    // =========================================================
    document.addEventListener('click', async function (e) {
        const wishBtn = e.target.closest('.wishlist-button, .catalog-wishlist, .product-image-wishlist, .product-detail-wishlist');
        if (!wishBtn) return;

        e.preventDefault();
        const productId = wishBtn.getAttribute('data-product-id');
        if (!productId) return;

        const icon = wishBtn.querySelector('i');
        const result = await sendAjax('ajax/wishlist.php', {
            action: 'toggle',
            product_id: productId
        });

        if (result.success) {
            const isAdded = result.action === 'added';
            showToast(result.message, 'success');
            updateWishlistBadges(result.wishlist_count);

            // Synchronize all heart buttons for this product ID on the current page
            const relatedButtons = document.querySelectorAll(`[data-product-id="${productId}"].wishlist-button, [data-product-id="${productId}"].catalog-wishlist, [data-product-id="${productId}"].product-image-wishlist, [data-product-id="${productId}"].product-detail-wishlist`);
            relatedButtons.forEach(btn => {
                const btnIcon = btn.querySelector('i');
                if (isAdded) {
                    btn.classList.add('active');
                    if (btnIcon) {
                        btnIcon.className = 'bi bi-heart-fill text-danger';
                    }
                } else {
                    btn.classList.remove('active');
                    if (btnIcon) {
                        btnIcon.className = 'bi bi-heart';
                    }
                }
            });
        } else {
            showToast(result.message || 'Could not update wishlist.', 'danger');
        }
    });

    // =========================================================
    // 4. WISHLIST PAGE ACTIONS (Remove item & Add All to Cart)
    // =========================================================
    document.addEventListener('click', async function (e) {
        // Remove single wishlist item
        const removeWishBtn = e.target.closest('.btn-remove-wishlist');
        if (removeWishBtn) {
            e.preventDefault();
            const productId = removeWishBtn.getAttribute('data-product-id');
            const card = removeWishBtn.closest('.wishlist-card');

            const result = await sendAjax('ajax/wishlist.php', {
                action: 'remove',
                product_id: productId
            });

            if (result.success) {
                showToast(result.message, 'success');
                updateWishlistBadges(result.wishlist_count);

                if (card) {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.95)';
                    card.style.transition = 'all 0.25s ease';
                    setTimeout(() => {
                        card.remove();
                        // Check if grid is now empty
                        const grid = document.querySelector('.wishlist-grid');
                        if (grid && grid.querySelectorAll('.wishlist-card').length === 0) {
                            grid.innerHTML = `
                                <div class="empty-wishlist-state text-center py-5" style="grid-column: 1 / -1; padding: 50px 20px;">
                                    <div style="font-size: 54px; color: var(--color-border); margin-bottom: 15px;">
                                        <i class="bi bi-heart"></i>
                                    </div>
                                    <h4 style="font-weight: 700; color: var(--color-heading); margin-bottom: 10px;">Your wishlist is empty</h4>
                                    <p style="color: var(--color-text-light); max-width: 420px; margin: 0 auto 24px;">
                                        Explore our collection and add your favorite items to your wishlist for easy access anytime.
                                    </p>
                                    <a href="products.php" class="btn btn-primary" style="padding: 10px 26px; border-radius: 999px; text-decoration: none; font-weight: 600;">
                                        Explore Products
                                    </a>
                                </div>
                            `;
                            const addAllBtn = document.querySelector('.btn-add-all-wishlist');
                            if (addAllBtn) addAllBtn.remove();
                        }
                    }, 250);
                }
            } else {
                showToast(result.message, 'danger');
            }
            return;
        }

        // Add All to Cart button
        const addAllBtn = e.target.closest('.btn-add-all-wishlist');
        if (addAllBtn) {
            e.preventDefault();
            addAllBtn.disabled = true;
            addAllBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Adding...';

            const result = await sendAjax('ajax/wishlist.php', {
                action: 'add_all_to_cart'
            });

            addAllBtn.disabled = false;
            addAllBtn.innerHTML = '<i class="bi bi-cart-plus"></i> Add All to Cart';

            if (result.success) {
                updateCartBadges(result.cart_count);
                showToast(result.message, 'success');
            } else {
                showToast(result.message, 'danger');
            }
        }
    });

    // =========================================================
    // 5. CART PAGE DYNAMIC ACTIONS (+, -, Remove, Save, Clear)
    // =========================================================
    function updateCartSummaryUI(totals) {
        if (!totals) return;

        const subtotalEl = document.querySelector('.summary-subtotal-val');
        if (subtotalEl) subtotalEl.textContent = totals.subtotal_formatted;

        const deliveryEl = document.querySelector('.summary-delivery-val');
        if (deliveryEl) {
            deliveryEl.textContent = totals.shipping_formatted;
            if (totals.shipping === 0) {
                deliveryEl.classList.add('summary-free');
            } else {
                deliveryEl.classList.remove('summary-free');
            }
        }

        const taxEl = document.querySelector('.summary-tax-val');
        if (taxEl) taxEl.textContent = totals.tax_formatted;

        const totalEl = document.querySelector('.summary-total-val');
        if (totalEl) totalEl.textContent = totals.total_formatted;

        // Shipping progress bar
        const progressBar = document.querySelector('.shipping-progress-bar span');
        if (progressBar) progressBar.style.width = `${totals.progress_percent}%`;

        const progressTop = document.querySelector('.shipping-progress-top');
        if (progressTop) {
            if (totals.free_shipping_unlocked) {
                progressTop.innerHTML = `
                    <span><i class="bi bi-truck"></i> Free delivery unlocked</span>
                    <strong><i class="bi bi-check-circle-fill text-success"></i></strong>
                `;
            } else {
                progressTop.innerHTML = `
                    <span><i class="bi bi-truck"></i> Add Rs. ${totals.amount_for_free_shipping.toLocaleString()} for FREE delivery</span>
                    <strong><span>${totals.progress_percent}%</span></strong>
                `;
            }
        }

        const progressP = document.querySelector('.shipping-progress p');
        if (progressP) {
            progressP.textContent = totals.free_shipping_unlocked
                ? 'Your order qualifies for free delivery.'
                : 'Free delivery applies on orders of Rs. 3,000 or more.';
        }
    }

    // Quantity Plus
    document.addEventListener('click', async function (e) {
        const plusBtn = e.target.closest('.cart-qty-plus');
        if (!plusBtn) return;

        const cartId = plusBtn.getAttribute('data-cart-id');
        const cartItem = plusBtn.closest('.cart-item, .mini-cart-item');
        const qtyVal = cartItem ? cartItem.querySelector('.cart-qty-val') : null;
        if (!cartId || !qtyVal) return;

        const currentQty = parseInt(qtyVal.textContent, 10) || 1;
        const newQty = currentQty + 1;

        const result = await sendAjax('ajax/cart.php', {
            action: 'update',
            cart_id: cartId,
            quantity: newQty
        });

        if (result.success) {
            // Update all quantity displays for this cart ID (e.g. main cart AND mini-cart)
            document.querySelectorAll(`[data-cart-id="${cartId}"] .cart-qty-val`).forEach(el => {
                el.textContent = result.quantity;
            });
            document.querySelectorAll(`[data-cart-id="${cartId}"] .cart-item-qty`).forEach(el => {
                el.textContent = `Qty: ${result.quantity}`;
            });
            
            updateCartBadges(result.cart_count);
            updateCartSummaryUI(result.totals);

            if (result.items) {
                const updatedItem = result.items.find(item => item.cart_id == cartId);
                if (updatedItem) {
                    // Update all item totals for this cart ID
                    document.querySelectorAll(`[data-cart-id="${cartId}"] .item-total-val`).forEach(el => {
                        el.textContent = `Rs. ${(updatedItem.item_total).toLocaleString()}`;
                    });
                }
            }
        } else {
            showToast(result.message, 'danger');
        }
    });

    // Quantity Minus
    document.addEventListener('click', async function (e) {
        const minusBtn = e.target.closest('.cart-qty-minus');
        if (!minusBtn) return;

        const cartId = minusBtn.getAttribute('data-cart-id');
        const cartItem = minusBtn.closest('.cart-item, .mini-cart-item');
        const qtyVal = cartItem ? cartItem.querySelector('.cart-qty-val') : null;
        if (!cartId || !qtyVal) return;

        const currentQty = parseInt(qtyVal.textContent, 10) || 1;
        const newQty = currentQty - 1;

        if (newQty <= 0) {
            // Trigger remove
            const removeBtn = cartItem.querySelector('.cart-remove-button, .mini-cart-remove');
            if (removeBtn) removeBtn.click();
            return;
        }

        const result = await sendAjax('ajax/cart.php', {
            action: 'update',
            cart_id: cartId,
            quantity: newQty
        });

        if (result.success) {
            // Update all quantity displays for this cart ID
            document.querySelectorAll(`[data-cart-id="${cartId}"] .cart-qty-val`).forEach(el => {
                el.textContent = result.quantity;
            });
            document.querySelectorAll(`[data-cart-id="${cartId}"] .cart-item-qty`).forEach(el => {
                el.textContent = `Qty: ${result.quantity}`;
            });
            
            updateCartBadges(result.cart_count);
            updateCartSummaryUI(result.totals);

            if (result.items) {
                const updatedItem = result.items.find(item => item.cart_id == cartId);
                if (updatedItem) {
                    // Update all item totals for this cart ID
                    document.querySelectorAll(`[data-cart-id="${cartId}"] .item-total-val`).forEach(el => {
                        el.textContent = `Rs. ${(updatedItem.item_total).toLocaleString()}`;
                    });
                }
            }
        } else {
            showToast(result.message, 'danger');
        }
    });

    // Remove Item from Cart
    document.addEventListener('click', async function (e) {
        const removeBtn = e.target.closest('.cart-remove-button, .mini-cart-remove');
        if (!removeBtn) return;

        e.preventDefault();
        const cartId = removeBtn.getAttribute('data-cart-id');
        if (!cartId) return;

        const result = await sendAjax('ajax/cart.php', {
            action: 'remove',
            cart_id: cartId
        });

        if (result.success) {
            showToast(result.message, 'info');
            updateCartBadges(result.cart_count);
            updateCartSummaryUI(result.totals);

            // Remove cart row from page
            const items = document.querySelectorAll(`[data-cart-id="${cartId}"]`);
            items.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'scale(0.95)';
                el.style.transition = 'all 0.25s ease';
                setTimeout(() => el.remove(), 250);
            });

            // If on cart.php and cart is now empty, reload or show empty UI
            if (result.cart_count === 0 && document.querySelector('.cart-layout')) {
                setTimeout(() => window.location.reload(), 300);
            }
        } else {
            showToast(result.message, 'danger');
        }
    });

    // Save for Later (Moves item to wishlist)
    document.addEventListener('click', async function (e) {
        const saveBtn = e.target.closest('.cart-save-button');
        if (!saveBtn) return;

        e.preventDefault();
        const productId = saveBtn.getAttribute('data-product-id');
        const cartId = saveBtn.getAttribute('data-cart-id');
        if (!productId || !cartId) return;

        // 1. Add to wishlist
        await sendAjax('ajax/wishlist.php', {
            action: 'toggle',
            product_id: productId
        });

        // 2. Remove from cart
        const result = await sendAjax('ajax/cart.php', {
            action: 'remove',
            cart_id: cartId
        });

        if (result.success) {
            showToast('Item moved to your Wishlist!', 'success');
            updateCartBadges(result.cart_count);
            updateCartSummaryUI(result.totals);

            const items = document.querySelectorAll(`[data-cart-id="${cartId}"]`);
            items.forEach(el => el.remove());

            if (result.cart_count === 0 && document.querySelector('.cart-layout')) {
                setTimeout(() => window.location.reload(), 300);
            }
        }
    });

    // Clear Cart
    document.addEventListener('click', async function (e) {
        const clearBtn = e.target.closest('.cart-clear-button');
        if (!clearBtn) return;

        if (!confirm('Are you sure you want to clear your cart?')) return;

        const result = await sendAjax('ajax/cart.php', { action: 'clear' });
        if (result.success) {
            showToast(result.message, 'info');
            updateCartBadges(0);
            setTimeout(() => window.location.reload(), 250);
        }
    });
});

