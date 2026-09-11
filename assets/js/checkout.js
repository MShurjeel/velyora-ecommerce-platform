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

    // Hide all bodies except first
    stepCards.forEach((card, index) => {
        const body = card.querySelector('.checkout-card-body');
        if (index !== 0 && body) {
            body.style.display = 'none';
        }

        // Add a "Next" button to each section except the last
        if (index < stepCards.length - 1 && body) {
            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.className = 'btn btn-primary mt-4';
            nextBtn.innerHTML = 'Continue to Next Step <i class="bi bi-arrow-right"></i>';
            nextBtn.style.padding = '12px 24px';
            nextBtn.style.borderRadius = '999px';
            nextBtn.style.fontWeight = '600';
            
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
            const body = c.querySelector('.checkout-card-body');
            if (body) {
                if (i === index) {
                    body.style.display = 'block';
                    c.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    body.style.display = 'none';
                }
            }
        });

        progressSteps.forEach((step, i) => {
            if (i <= index) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
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

            // Fake processing and success
            const origHtml = placeOrderBtn.innerHTML;
            placeOrderBtn.disabled = true;
            placeOrderBtn.innerHTML = '<span><span class="spinner-border spinner-border-sm"></span> Processing...</span>';

            setTimeout(async () => {
                // Clear cart backend before redirecting
                try {
                    const formData = new FormData();
                    formData.append('action', 'clear');
                    await fetch('ajax/cart.php', { method: 'POST', body: formData });
                } catch(e) {}
                
                alert('Order placed successfully! Redirecting...');
                window.location.href = 'index.php';
            }, 1500);
        });
    }
});

