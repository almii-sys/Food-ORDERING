<?php include 'includes/header.php'; ?>

<section class="hero">
    <h1>Delicious Food, Delivered Fast</h1>
    <p>Order your favorite burgers, fries, and drinks online</p>
    <a href="menu.php" class="cta-button">Order Now</a>
</section>

<section class="menu-section">
    <h2 class="section-title">Our Popular Items</h2>
    <div class="menu-grid">
        <?php
        // Get popular items from each category
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p
                JOIN categories c ON p.category_id = c.id
                ORDER BY p.id LIMIT 6";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="menu-item">
                    <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <div class="menu-item-info">
                        <h3><?php echo $row['name']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                        <div class="menu-item-price">$<?php echo number_format($row['price'], 2); ?></div>
                        <button class="add-to-cart" 
                                data-id="<?php echo $row['id']; ?>" 
                                data-name="<?php echo $row['name']; ?>" 
                                data-price="<?php echo $row['price']; ?>">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div style="text-align: center; margin-top: 30px;">
        <a href="menu.php" class="cta-button">View Full Menu</a>
    </div>
</section>

<section class="menu-section">
    <h2 class="section-title">Why Choose Us</h2>
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; text-align: center;">
        <div style="flex: 1; min-width: 200px; margin: 15px; padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
            <i class="fas fa-hamburger" style="font-size: 3rem; color: #e74c3c; margin-bottom: 15px;"></i>
            <h3>Fresh Ingredients</h3>
            <p>We use only the freshest ingredients to make our delicious food.</p>
        </div>
        <div style="flex: 1; min-width: 200px; margin: 15px; padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
            <i class="fas fa-shipping-fast" style="font-size: 3rem; color: #e74c3c; margin-bottom: 15px;"></i>
            <h3>Fast Delivery</h3>
            <p>Our team ensures your food is delivered hot and fresh in no time.</p>
        </div>
        <div style="flex: 1; min-width: 200px; margin: 15px; padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
            <i class="fas fa-smile" style="font-size: 3rem; color: #e74c3c; margin-bottom: 15px;"></i>
            <h3>Satisfaction Guaranteed</h3>
            <p>Your satisfaction is our top priority, always.</p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>