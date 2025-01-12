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

// Check for Order Conditions
if (isset($_GET['total']) && ($_GET['total'] > 0) && (!empty($_SESSION['cart']))) {

    // Connect to database
    require('../config/connect.php');

    // Store Order in Database
    $q = "INSERT INTO orders (user_id, total, order_date) 
          VALUES ({$_SESSION['user_id']}, {$_GET['total']}, NOW())";
    $r = mysqli_query($link, $q);

    if ($r) {
        // Retrieve Order ID (last inserted ID)
        $orderId = mysqli_insert_id($link);

        // Insert items into order_contents table
        foreach ($_SESSION['cart'] as $id => $value) {
            $item = $_SESSION['cart'][$id];
            $query = "INSERT INTO order_contents (order_id, item_id, quantity, price)
                      VALUES ({$orderId}, {$id}, {$item['quantity']}, {$item['price']})";
            mysqli_query($link, $query);
        }

        // Store order status in session
        $_SESSION['order_status'] = 'success';
        $_SESSION['order_id'] = $orderId;  // Store order ID for use on confirmation page
        $_SESSION['order_total'] = $_GET['total']; // Store order total

        // Clear cart after order is placed
        $_SESSION['cart'] = [];

        // Redirect to confirmation page
        header('Location: ../public/order_confirmation.php');
        exit();

    } else {
        // If order placement fails, set status as error
        $_SESSION['order_status'] = 'error';
        $_SESSION['error_message'] = 'There was an issue placing your order. Please try again later.';
        header('Location: ../public/order_confirmation.php');
        exit();
    }

    // Close database connection
    mysqli_close($link);
} else {
    // If there's an issue with the cart or total
    $_SESSION['order_status'] = 'error';
    $_SESSION['error_message'] = 'Invalid cart or total amount.';


    # Cart Update Modal #

        echo '
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Cart Update</h5>
                        <button type="button" class="close" aria-label="Close">✕</button>
                    </div>
                    <div class="modal-body">
                        '.htmlspecialchars($row["item_name"]).' has been added to your cart.
                    </div>
                    <div class="modal-footer">
                        <a href="../public/session_cart.php" class="btn btn-dark">Continue Shopping</a>
                        <a href="../public/cart.php" class="btn btn-dark">View Your Cart</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = new bootstrap.Modal(document.getElementById("cartModal"));
                modal.show();
            });
        </script>
        ';
    
    exit();
}

// Send the output buffer
ob_end_flush();
?>
