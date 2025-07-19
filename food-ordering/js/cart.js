document.addEventListener('DOMContentLoaded', function() {
    // Update quantity functionality
    const quantityInputs = document.querySelectorAll('.quantity-input');
    
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.getAttribute('data-id');
            const newQuantity = parseInt(this.value);
            
            if (newQuantity > 0) {
                updateCartItem(itemId, newQuantity);
            } else {
                this.value = 1;
            }
        });
    });
    
    // Increment and decrement buttons
    const incrementBtns = document.querySelectorAll('.increment-btn');
    const decrementBtns = document.querySelectorAll('.decrement-btn');
    
    incrementBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            const input = document.querySelector(`.quantity-input[data-id="${itemId}"]`);
            let currentValue = parseInt(input.value);
            input.value = currentValue + 1;
            
            updateCartItem(itemId, currentValue + 1);
        });
    });
    
    decrementBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            const input = document.querySelector(`.quantity-input[data-id="${itemId}"]`);
            let currentValue = parseInt(input.value);
            
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateCartItem(itemId, currentValue - 1);
            }
        });
    });
    
    // Remove item buttons
    const removeButtons = document.querySelectorAll('.remove-item');
    
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            removeCartItem(itemId);
        });
    });
    
    function updateCartItem(id, quantity) {
        fetch('update_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartDisplay(data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    function removeCartItem(id) {
        fetch('remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the item from the DOM
                const itemElement = document.querySelector(`.cart-item[data-id="${id}"]`);
                if (itemElement) {
                    itemElement.remove();
                }
                
                updateCartDisplay(data);
                
                // If cart is empty, show empty cart message
                if (data.cartCount === 0) {
                    const cartContainer = document.querySelector('.cart-container');
                    cartContainer.innerHTML = `
                        <div class="empty-cart">
                            <h2>Your cart is empty</h2>
                            <p>Looks like you haven't added anything to your cart yet.</p>
                            <a href="menu.php" class="cta-button">Browse Menu</a>
                        </div>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    function updateCartDisplay(data) {
        // Update cart count
        document.getElementById('cart-count').textContent = data.cartCount;
        
        // Update cart total
        const totalElement = document.querySelector('.cart-total-value');
        if (totalElement) {
            totalElement.textContent = `$${data.cartTotal.toFixed(2)}`;
        }
        
        // Update each item subtotal
        if (data.items) {
            Object.keys(data.items).forEach(id => {
                const subtotalElement = document.querySelector(`.item-subtotal[data-id="${id}"]`);
                if (subtotalElement) {
                    subtotalElement.textContent = `$${data.items[id].subtotal.toFixed(2)}`;
                }
            });
        }
    }
});