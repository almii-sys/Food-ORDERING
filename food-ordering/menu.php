<?php include 'includes/header.php'; ?>

<div class="menu-container">
    <h1 class="page-title">Our Menu</h1>
    
    <div class="category-tabs">
        <a href="menu.php" class="category-tab <?php echo !isset($_GET['category']) ? 'active' : ''; ?>">All</a>
        <?php
        $sql = "SELECT * FROM categories";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $activeClass = (isset($_GET['category']) && $_GET['category'] == $row['id']) ? 'active' : '';
                echo '<a href="menu.php?category=' . $row['id'] . '" class="category-tab ' . $activeClass . '">' . $row['name'] . '</a>';
            }
        }
        ?>
    </div>
    
    <div class="menu-grid">
        <?php
        // Get products based on category filter
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p
                JOIN categories c ON p.category_id = c.id";
        
        if (isset($_GET['category'])) {
            $category_id = $_GET['category'];
            $sql .= " WHERE p.category_id = " . $category_id;
        }
        
        $sql .= " ORDER BY p.category_id, p.name";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $current_category = null;
            
            while($row = $result->fetch_assoc()) {
                // Display category header if we're on a new category
                if ($current_category !== $row['category_name']) {
                    $current_category = $row['category_name'];
                    echo '<h2 class="category-title">' . $current_category . '</h2>';
                }
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
        } else {
            echo '<p class="no-items">No items found.</p>';
        }
        ?>
    </div>
</div>

<style>
    .category-tabs {
        display: flex;
        overflow-x: auto;
        margin-bottom: 30px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    
    .category-tab {
        padding: 10px 20px;
        margin-right: 10px;
        background-color: #f1f1f1;
        border-radius: 20px;
        white-space: nowrap;
        transition: background-color 0.3s;
    }
    
    .category-tab.active, .category-tab:hover {
        background-color: #e74c3c;
        color: white;
    }
    
    .category-title {
        grid-column: 1 / -1;
        margin: 20px 0 10px 0;
        font-size: 1.5rem;
        color: #e74c3c;
    }
    
    .no-items {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px;
        background-color: #f9f9f9;
        border-radius: 8px;
    }
    
    .page-title {
        margin-bottom: 20px;
    }
</style>

<?php include 'includes/footer.php'; ?>