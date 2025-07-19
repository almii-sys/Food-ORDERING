<?php 
include 'includes/header.php';

// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);

// Process order if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $loggedIn ? $_SESSION['user_id'] : null;
    
    // Calculate total
    $total_amount = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }
    
    // Insert order into database
    $sql = "INSERT INTO orders (user_id, total_amount) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $user_id, $total_amount);
    
    if ($stmt->execute()) {
        $order_id = $conn->insert_id;
        
        // Insert order items
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
            $stmt->execute();
        }
        
        // Clear cart
        unset($_SESSION['cart']);
        
        // Redirect to confirmation page
        header("Location: confirmation.php?order_id=$order_id");
        exit;
    } else {
        $error = "There was an error processing your order. Please try again.";
    }
}
?>

<div class="checkout-page">
    <h1 class="page-title">Checkout</h1>
    
    <?php if (!$loggedIn): ?>
    <div class="checkout-login-message">
        <p>Please log in to complete your order. If you don't have an account, you can sign up now.</p>
        <div class="checkout-buttons">
            <a href="login.php?redirect=checkout.php" class="checkout-login-btn">Login</a>
            <a href="signup.php?redirect=checkout.php" class="checkout-signup-btn">Sign Up</a>
        </div>
    </div>
    <?php else: ?>
    
    <?php if (isset($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="checkout-container">
        <div class="checkout-details">
            <h2>Order Summary</h2>
            <div class="order-items">
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <div class="order-item">
                    <div class="order-item-name">
                        <?php echo $item['name']; ?> × <?php echo $item['quantity']; ?>
                    </div>
                    <div class="order-item-price">
                        $<?php echo number_format($subtotal, 2); ?>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="order-total">
                    <span>Total:</span>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
            </div>
            
            <h2>Delivery Details</h2>
            <form method="post" action="" id="checkout-form">
                <div class="form-group">
                    <label for="address">Delivery Address</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" required>
                    </div>
                    <div class="form-group">
                        <label for="zip">ZIP Code</label>
                        <input type="text" id="zip" name="zip" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                
                <h2>Payment Method</h2>
                <div class="payment-methods">
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="cash" checked>
                        <span>Cash on Delivery</span>
                    </label>
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="card">
                        <span>Credit/Debit Card</span>
                    </label>
                </div>
                
                <div class="card-details" style="display: none;">
                    <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" id="card_number" name="card_number">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry">Expiry Date</label>
                            <input type="text" id="expiry" name="expiry" placeholder="MM/YY">
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="place-order-btn">Place Order</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .checkout-page {
        margin-bottom: 40px;
    }
    
    .checkout-login-message {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        text-align: center;
    }
    
    .checkout-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }
    
    .checkout-login-btn, .checkout-signup-btn {
        padding: 10px 30px;
        border-radius: 4px;
        font-weight: bold;
        text-align: center;
    }
    
    .checkout-login-btn {
        background-color: #e74c3c;
        color: white;
    }
    
    .checkout-signup-btn {
        background-color: #f8f9fa;
        border: 1px solid #e74c3c;
        color: #e74c3c;
    }
    
    .checkout-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }
    
    .checkout-details {
        flex: 1;
        min-width: 300px;
    }
    
    .checkout-details h2 {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .order-items {
        margin-bottom: 30px;
    }
    
    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .order-total {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        font-size: 1.2rem;
        font-weight: bold;
        margin-top: 10px;
    }
    
    .form-row {
        display: flex;
        gap: 15px;
    }
    
    .form-row .form-group {
        flex: 1;
    }
    
    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .payment-method {
        display: flex;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .payment-method input {
        margin-right: 10px;
    }
    
    .place-order-btn {
        width: 100%;
        padding: 15px;
        background-color: #2ecc71;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 20px;
    }
    
    .place-order-btn:hover {
        background-color: #27ae60;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const cardDetails = document.querySelector('.card-details');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'card') {
                cardDetails.style.display = 'block';
                cardDetails.querySelectorAll('input').forEach(input => {
                    input.setAttribute('required', '');
                });
            } else {
                cardDetails.style.display = 'none';
                cardDetails.querySelectorAll('input').forEach(input => {
                    input.removeAttribute('required');
                });
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>