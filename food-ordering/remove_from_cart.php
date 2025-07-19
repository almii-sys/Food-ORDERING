<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    
    // Make sure cart exists and item is in cart
    if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$id])) {
        // Remove item
        unset($_SESSION['cart'][$id]);
        
        // Calculate new totals
        $cartCount = 0;
        $cartTotal = 0;
        
        foreach ($_SESSION['cart'] as $item) {
            $cartCount += $item['quantity'];
            $cartTotal += $item['price'] * $item['quantity'];
        }
        
        // Return updated cart info
        echo json_encode([
            'success' => true,
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal
        ]);
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Item not found in cart'
        ]);
        exit;
    }
} else {
    // Return error for non-POST requests
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}
?>