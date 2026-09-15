/**
 * Velyora Checkout Engine
 */
document.addEventListener('DOMContentLoaded', function () {
    const checkoutPage = document.querySelector('.checkout-page');
    if (!checkoutPage) return;

    // --- 1. Payment Method Toggle ---
    const paymentRadios = document.querySelectorAll('input[name="payment"]');
    const cardFieldsContainer = document.querySelector('.card-payment-fields');
    const cardInputs = cardFieldsContainer ? cardFieldsContainer.querySelectorAll('input') : [];

    function togglePaymentFields() {
        const selected = document.querySelector('input[name="payment"]:checked');
        if (!selected) return;

        // Update active class on labels
        document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active'));
        selected.closest('.payment-option').classList.add('active');

        if (selected.value === 'card') {
            if (cardFieldsContainer) {
                cardFieldsContainer.style.display = 'block';
                // Restore required attributes for validation if needed
                cardInputs.forEach(input => input.setAttribute('required', 'true'));
            }
        } else {
            if (cardFieldsContainer) {
                cardFieldsContainer.style.display = 'none';
                // Remove required attributes so COD/Wallet can submit without validation errors
                cardInputs.forEach(input => {
                    input.removeAttribute('required');
                    input.value = ''; // clear values just in case
                });
            }
        }
    }

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', togglePaymentFields);
    });

    // Run once on load
    togglePaymentFields();

    // --- 2. Multi-step Accordion Navigation ---
    const stepCards = document.querySelectorAll('.checkout-card');
    const progressSteps = document.querySelectorAll('.checkout-step');

    // Hide all bodies except first by adding collapsed class
    stepCards.forEach((card, index) => {
        const body = card.querySelector('.checkout-card-body');
        const header = card.querySelector('.checkout-card-header');
        
        if (index !== 0) {
            card.classList.add('collapsed');
        } else {
            card.classList.remove('collapsed');
        }

        // Add click listener to header to open step (if it's a previous step)
        if (header) {
            header.addEventListener('click', () => {
                // Check if progress allows going to this step (e.g. only allow completed or current active steps)
                if (progressSteps[index] && progressSteps[index].classList.contains('active')) {
                    goToStep(index);
                }
            });
        }

        // Add a "Next" button to each section except the last
        if (index < stepCards.length - 1 && body) {
            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.className = 'btn-primary-custom mt-4 w-100';
            nextBtn.innerHTML = 'Continue to Next Step <i class="bi bi-arrow-right"></i>';
            nextBtn.addEventListener('click', () => {
                // Basic validation before moving next
                const inputs = body.querySelectorAll('input[required], select[required]');
                let valid = true;
                inputs.forEach(inp => {
                    if (!inp.value.trim()) {
                        valid = false;
                        inp.style.borderColor = 'red';
                    } else {
                        inp.style.borderColor = '';
                    }
                });

                if (valid) {
                    goToStep(index + 1);
                } else {
                    alert('Please fill out all required fields.');
                }
            });

            body.appendChild(nextBtn);
        }
    });

    function goToStep(index) {
        stepCards.forEach((c, i) => {
            if (i === index) {
                c.classList.remove('collapsed');
                c.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                c.classList.add('collapsed');
            }
        });

        progressSteps.forEach((step, i) => {
            if (i === index) {
                step.classList.add('active');
            } else if (i < index) {
                step.classList.add('active'); // Keep previous steps active to show they are completed
            } else {
                step.classList.remove('active'); // Remove active from future steps
            }
        });
    }

    // Allow clicking on previous progress steps to go back
    progressSteps.forEach((step, i) => {
        step.style.cursor = 'pointer';
        step.addEventListener('click', () => {
            // Only allow going back or to currently active step
            if (step.classList.contains('active')) {
                goToStep(i);
            }
        });
    });

    // --- 3. Place Order ---
    const placeOrderBtn = document.querySelector('.place-order-button');
    if (placeOrderBtn) {
        placeOrderBtn.addEventListener('click', function () {
            // Validate Terms
            const terms = document.querySelector('.terms-checkbox input[type="checkbox"]');
            if (terms && !terms.checked) {
                alert('You must agree to the Terms & Conditions and Privacy Policy.');
                return;
            }

            const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
            
            // Validate Card if Card is selected
            if (paymentMethod === 'card') {
                let cardValid = true;
                cardInputs.forEach(input => {
                    if (!input.value.trim()) {
                        cardValid = false;
                        input.style.borderColor = 'red';
                    }
                });
                if (!cardValid) {
                    goToStep(2); // Step 03 Payment Method
                    alert('Please fill out your card details.');
                    return;
                }
            }

            // Real order placement — send data to backend
            const origHtml = placeOrderBtn.innerHTML;
            placeOrderBtn.disabled = true;
            placeOrderBtn.innerHTML = '<span><span class="spinner-border spinner-border-sm"></span> Placing Order...</span>';

            const formData = new FormData();
            formData.append('first_name',     document.getElementById('first-name')?.value  || '');
            formData.append('last_name',      document.getElementById('last-name')?.value   || '');
            formData.append('email',          document.getElementById('email')?.value        || '');
            formData.append('phone',          document.getElementById('phone')?.value        || '');
            formData.append('address',        document.getElementById('address')?.value      || '');
            formData.append('address_2',      document.getElementById('address-2')?.value   || '');
            formData.append('city',           document.getElementById('city')?.value         || '');
            formData.append('postal_code',    document.getElementById('postal-code')?.value  || '');
            formData.append('payment_method', paymentMethod);

            try {
                const res    = await fetch('ajax/checkout.php', { method: 'POST', body: formData });
                const result = await res.json();

                if (result.success) {
                    placeOrderBtn.innerHTML = '<span><i class="bi bi-check-circle"></i> Order Placed!</span>';
                    setTimeout(() => {
                        window.location.href = 'my-profile.php#v-pills-orders';
                    }, 800);
                } else if (result.requires_login) {
                    window.location.href = 'login.php';
                } else {
                    alert(result.message || 'Failed to place order. Please try again.');
                    placeOrderBtn.disabled = false;
                    placeOrderBtn.innerHTML = origHtml;
                }
            } catch (e) {
                alert('Network error. Please check your connection and try again.');
                placeOrderBtn.disabled = false;
                placeOrderBtn.innerHTML = origHtml;
            }
        });
    }
});

