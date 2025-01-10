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

// Initialize order status
$orderStatus = '';
$orderId = '';

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

    if ($r) {
        // Order inserted successfully, get order ID
        $orderId = mysqli_insert_id($link);
        $_SESSION['order_status'] = 'success';
        $_SESSION['order_id'] = $orderId;  // Store order ID for use on confirmation page
        $_SESSION['order_total'] = $_GET['total']; // Store order total

        // Insert items into order_contents table
        $q = "SELECT * FROM products WHERE item_id IN ("; 
        foreach ($_SESSION['cart'] as $id => $value) {
            $q .= $id . ',';
        }
        $q = rtrim($q, ',') . ') ORDER BY item_id ASC';
        $r = mysqli_query($link, $q);

        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $query = "INSERT INTO order_contents (order_id, item_id, quantity, price)
                      VALUES ({$orderId}, {$row['item_id']}, {$_SESSION['cart'][$row['item_id']]['quantity']}, {$row['price']})";
            mysqli_query($link, $query);
        }

        // Clear cart after order is placed
        $_SESSION['cart'] = [];

        // Redirect to confirmation page
        header('Location: order_confirmation.php');
        exit();
    } else {
        // If order placement fails, set status as error
        $_SESSION['order_status'] = 'error';
        header('Location: ../public/order_confirmation.php');
        exit();
    }

    mysqli_close($link);
} else {
    // If there's an issue with the cart or total
    $_SESSION['order_status'] = 'error';
    header('Location: ../public/order_confirmation.php');
    exit();
}
// Send the output buffer
ob_end_flush();
?>
