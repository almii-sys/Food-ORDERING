<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $quantity = (int)$_POST['quantity'];
    
    // Make sure cart exists and item is in cart
    if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$id])) {
        // Update quantity
        $_SESSION['cart'][$id]['quantity'] = $quantity;
        
        // Calculate new totals
        $cartCount = 0;
        $cartTotal = 0;
        $items = [];
        
        foreach ($_SESSION['cart'] as $itemId => $item) {
            $cartCount += $item['quantity'];
            $subtotal = $item['price'] * $item['quantity'];
            $cartTotal += $subtotal;
            
            $items[$itemId] = [
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal
            ];
        }
        
        // Return updated cart info
        echo json_encode([
            'success' => true,
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal,
            'items' => $items
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