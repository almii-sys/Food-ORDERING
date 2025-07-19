<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "food_ordering";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize database if not exists
function init_database($conn) {
    // Create categories
    $categories = [
        ["Burgers", "Delicious beef and vegetarian burgers"],
        ["Fries", "Crispy potato fries with various seasonings"],
        ["Drinks", "Refreshing beverages to complement your meal"]
    ];
    
    // Check if categories already exist
    $result = $conn->query("SELECT COUNT(*) as count FROM categories");
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        foreach ($categories as $category) {
            $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $category[0], $category[1]);
            $stmt->execute();
        }
        
        // Add sample products
        $burger_id = 1;
        $fries_id = 2;
        $drinks_id = 3;
        
        // Burgers
        $burgers = [
            ["Classic Burger", "Beef patty with lettuce, tomato, and special sauce", 8.99, "burger1.jpg"],
            ["Cheese Burger", "Classic burger with American cheese", 9.99, "burger2.jpg"],
            ["Bacon Burger", "Beef patty with crispy bacon and cheese", 10.99, "burger3.jpg"],
            ["Veggie Burger", "Plant-based patty with fresh vegetables", 9.99, "burger4.jpg"],
            ["Spicy Burger", "Beef patty with jalapeños and spicy sauce", 10.99, "burger5.jpg"]
        ];
        
        // Fries
        $fries = [
            ["Regular Fries", "Classic crispy potato fries", 3.99, "fries1.jpg"],
            ["Cheese Fries", "Fries topped with melted cheese", 4.99, "fries2.jpg"],
            ["Garlic Fries", "Fries tossed in garlic and herbs", 4.99, "fries3.jpg"],
            ["Sweet Potato Fries", "Crispy sweet potato fries", 4.99, "fries4.jpg"],
            ["Loaded Fries", "Fries with cheese, bacon, and sour cream", 6.99, "fries5.jpg"]
        ];
        
        // Drinks
        $drinks = [
            ["Cola", "Classic cola drink", 2.99, "drink1.jpg"],
            ["Lemonade", "Fresh squeezed lemonade", 3.99, "drink2.jpg"],
            ["Iced Tea", "Sweet or unsweetened tea", 2.99, "drink3.jpg"],
            ["Milkshake", "Creamy vanilla milkshake", 4.99, "drink4.jpg"],
            ["Water", "Bottled spring water", 1.99, "drink5.jpg"]
        ];
        
        // Insert products
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category_id) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($burgers as $burger) {
            $stmt->bind_param("ssdsi", $burger[0], $burger[1], $burger[2], $burger[3], $burger_id);
            $stmt->execute();
        }
        
        foreach ($fries as $fry) {
            $stmt->bind_param("ssdsi", $fry[0], $fry[1], $fry[2], $fry[3], $fries_id);
            $stmt->execute();
        }
        
        foreach ($drinks as $drink) {
            $stmt->bind_param("ssdsi", $drink[0], $drink[1], $drink[2], $drink[3], $drinks_id);
            $stmt->execute();
        }
    }
}

// Call initialization (only runs if tables are empty)
init_database($conn);
?>