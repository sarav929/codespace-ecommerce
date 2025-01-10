<?php
// Start output buffering
ob_start();

// Ensure session is started only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Prevent checkout if user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header('Location: ../public/login.php');
    exit();
}

# Check for Order Conditions
if (isset($_GET['total']) && ($_GET['total'] > 0) && (!empty($_SESSION['cart']))) {

    # Connect to database
    require('../config/connect.php');

    # Store Order in Database
    $q = "INSERT INTO orders (user_id, total, order_date) 
          VALUES ({$_SESSION['user_id']}, {$_GET['total']}, NOW())";
    $r = mysqli_query($link, $q);

    # Retrieve Order ID
    $order_id = mysqli_insert_id($link);

    # Retrieve Cart Items
    $q = "SELECT * FROM products WHERE item_id IN (";

    foreach ($_SESSION['cart'] as $id => $value) { 
        $q .= $id . ','; 
    }

    $q = substr($q, 0, -1) . ') ORDER BY item_id ASC';
    $r = mysqli_query($link, $q);

    # Store Order Content
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $query = "INSERT INTO order_contents (order_id, item_id, quantity, price)
                  VALUES ($order_id, 
                          {$row['item_id']},
                          {$_SESSION['cart'][$row['item_id']]['quantity']},
                          {$_SESSION['cart'][$row['item_id']]['price']})";
        $result = mysqli_query($link, $query);
    }

    # Close Database Connection
    mysqli_close($link);

    # Display Order Confirmation
    echo "<p>Thanks for your order. Your Order Number Is #$order_id</p>";

    # Clear Cart
    $_SESSION['cart'] = NULL;
} else {
    echo "<p>Error: Your cart is empty or invalid total amount.</p>";
}

// Send the output buffer
ob_end_flush();
?>