<?php 
include 'includes/header.php';

// Check if order ID is provided
if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit;
}

$order_id = $_GET['order_id'];

// Get order details
$sql = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    header("Location: index.php");
    exit;
}

$order = $order_result->fetch_assoc();

// Get order items
$sql = "SELECT oi.*, p.name, p.image 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items_result = $stmt->get_result();
?>

<div class="confirmation-page">
    <div class="confirmation-container">
        <div class="confirmation-header">
            <i class="fas fa-check-circle"></i>
            <h1>Order Confirmed!</h1>
            <p>Thank you for your order. Your order has been received and is being processed.</p>
        </div>
        
        <div class="order-info">
            <div class="order-info-item">
                <span>Order Number:</span>
                <span>#<?php echo $order_id; ?></span>
            </div>
            <div class="order-info-item">
                <span>Date:</span>
                <span><?php echo date('F j, Y', strtotime($order['created_at'])); ?></span>
            </div>
            <div class="order-info-item">
                <span>Total:</span>
                <span>$<?php echo number_format($order['total_amount'], 2); ?></span>
            </div>
            <div class="order-info-item">
                <span>Status:</span>
                <span class="order-status"><?php echo ucfirst($order['status']); ?></span>
            </div>
        </div>
        
        <h2>Order Details</h2>
        <div class="order-items-list">
            <?php while ($item = $items_result->fetch_assoc()): ?>
            <div class="order-item">
                <img src="images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="order-item-image">
                <div class="order-item-details">
                    <h3><?php echo $item['name']; ?></h3>
                    <p>Qty: <?php echo $item['quantity']; ?></p>
                    <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                </div>
                <div class="order-item-total">
                    $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        
        <div class="confirmation-actions">
            <a href="index.php" class="home-btn">Return to Home</a>
            <a href="menu.php" class="menu-btn">Browse Menu</a>
        </div>
    </div>
</div>

<style>
    .confirmation-page {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 60vh;
    }
    
    .confirmation-container {
        max-width: 800px;
        width: 100%;
        background-color: #fff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    
    .confirmation-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .confirmation-header i {
        font-size: 5rem;
        color: #2ecc71;
        margin-bottom: 20px;
    }
    
    .confirmation-header h1 {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    
    .order-info {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .order-info-item {
        display: flex;
        flex-direction: column;
    }
    
    .order-info-item span:first-child {
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .order-status {
        text-transform: capitalize;
        color: #2ecc71;
        font-weight: bold;
    }
    
    .order-items-list {
        margin-bottom: 30px;
    }
    
    .order-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    
    .order-item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 15px;
    }
    
    .order-item-details {
        flex-grow: 1;
    }
    
    .order-item-details h3 {
        margin-bottom: 5px;
    }
    
    .order-item-details p {
        color: #666;
        margin: 2px 0;
    }
    
    .order-item-total {
        font-weight: bold;
        color: #e74c3c;
        font-size: 1.1rem;
    }
    
    .confirmation-actions {
        display: flex;
        justify-content: center;
        gap: 20px;
    }
    
    .home-btn, .menu-btn {
        padding: 12px 30px;
        border-radius: 4px;
        font-weight: bold;
        text-align: center;
    }
    
    .home-btn {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        color: #333;
    }
    
    .menu-btn {
        background-color: #e74c3c;
        color: white;
    }
</style>

<?php include 'includes/footer.php'; ?>