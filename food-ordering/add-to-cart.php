<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    
    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Check if item already exists in cart
    if (isset($_SESSION['cart'][$id])) {
        // Increment quantity
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        // Add new item
        $_SESSION['cart'][$id] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'image' => 'product' . $id . '.jpg'
        ];
    }
    
    // Calculate cart count (total items)
    $cartCount = 0;
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['quantity'];
    }
    
    // Return success response
    echo json_encode([
        'success' => true,
        'cartCount' => $cartCount
    ]);
    exit;
} else {
    // Return error for non-POST requests
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}
?>