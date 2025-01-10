<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log in</title>

        <link rel="stylesheet" href="../assets/style/style.css">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
        crossorigin="anonymous">

    </head>
    <body>

        <?php 
        include '../includes/nav.php';

        // confirmation of order

        // Ensure session is started only once
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        print_r($_SESSION);

        // Retrieve order status and details from session
        $orderStatus = isset($_SESSION['order_status']) ? $_SESSION['order_status'] : 'error';
        $orderId = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : '';
        $orderTotal = isset($_SESSION['order_total']) ? $_SESSION['order_total'] : 0;

        // Clear session values after displaying message
        unset($_SESSION['order_status']); 
        unset($_SESSION['order_id']);
        unset($_SESSION['order_total']); ?>

        <div class="container mt-5">
        <?php if ($orderStatus === 'success'): ?>
            <div class="alert alert-success">
                <h4 class="alert-heading">Thank you for your purchase!</h4>
                <p>Your order has been placed successfully. Your order ID is #<?php echo $orderId; ?>. Total Amount: &pound;<?php echo number_format($orderTotal, 2); ?>.</p>
                <a href="../public/index.php">Back to Home</a>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                <h4 class="alert-heading">Order Failed!</h4>
                <p>There was an error processing your order. Please try again later.</p>
                <a href="../public/index.php">Back to Home</a>
            </div>
        <?php endif; ?>
        </div>

        <?php include '../includes/footer.php'; ?>        
    </body>
</html>