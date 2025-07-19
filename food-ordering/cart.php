<?php include 'includes/header.php'; ?>

<div class="cart-page">
    <h1 class="page-title">Your Shopping Cart</h1>
    
    <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
        <div class="empty-cart">
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added anything to your cart yet.</p>
            <a href="menu.php" class="cta-button">Browse Menu</a>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <h2 class="cart-title">Cart Items</h2>
            
            <?php 
            $total = 0;
            foreach ($_SESSION['cart'] as $id => $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <div class="cart-item" data-id="<?php echo $id; ?>">
                    <img src="images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="cart-item-image">
                    <div class="cart-item-details">
                        <h3 class="cart-item-title"><?php echo $item['name']; ?></h3>
                        <div class="cart-item-price">$<?php echo number_format($item['price'], 2); ?></div>
                    </div>
                    <div class="cart-item-quantity">
                        <button class="quantity-btn decrement-btn" data-id="<?php echo $id; ?>">-</button>
                        <input type="number" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input" data-id="<?php echo $id; ?>">
                        <button class="quantity-btn increment-btn" data-id="<?php echo $id; ?>">+</button>
                    </div>
                    <div class="item-subtotal" data-id="<?php echo $id; ?>">
                        $<?php echo number_format($subtotal, 2); ?>
                    </div>
                    <button class="remove-item" data-id="<?php echo $id; ?>">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            <?php endforeach; ?>
            
            <div class="cart-summary">
                <div class="cart-total">
                    <span>Total:</span>
                    <span class="cart-total-value">$<?php echo number_format($total, 2); ?></span>
                </div>
                <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
                <a href="menu.php" class="continue-shopping">Continue Shopping</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="js/cart.js"></script>

<style>
    .empty-cart {
        text-align: center;
        padding: 50px;
        background-color: #f9f9f9;
        border-radius: 8px;
        margin-bottom: 30px;
    }
    
    .empty-cart h2 {
        margin-bottom: 10px;
    }
    
    .empty-cart p {
        margin-bottom: 20px;
        color: #666;
    }
    
    .cart-title {
        font-size: 1.5rem;
    }
    
    .cart-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    
    .cart-item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 15px;
    }
    
    .cart-item-details {
        flex-grow: 1;
    }
    
    .cart-item-quantity {
        display: flex;
        align-items: center;
        margin: 0 20px;
    }
    
    .item-subtotal {
        font-weight: bold;
        color: #e74c3c;
        margin: 0 20px;
    }
    
    .remove-item {
        background: none;
        border: none;
        color: #888;
        cursor: pointer;
        font-size: 1.2rem;
    }
    
    .remove-item:hover {
        color: #e74c3c;
    }
</style>

<?php include 'includes/footer.php'; ?>