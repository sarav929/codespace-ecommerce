<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MKTIME</title>
    <link rel="stylesheet" href="../assets/style/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
    crossorigin="anonymous">

</head>
<body>

    <?php include '../includes/nav.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    # 1. Connect to the database
    require('../config/connect.php');

    # 2. Retrieve the logged in user's orders with contents 

    $user_id = (int)$_SESSION['user_id'];

    $q = "SELECT 
        orders.order_id, 
        orders.order_date, 
        orders.total, 
        order_contents.item_id, 
        products.item_name, 
        products.item_price, 
        products.item_img,
        order_contents.quantity, 
        (products.item_price * order_contents.quantity) AS item_total 
    FROM orders 
    JOIN order_contents ON orders.order_id = order_contents.order_id 
    JOIN products ON order_contents.item_id = products.item_id 
    WHERE orders.user_id = $user_id 
    ORDER BY orders.order_id, orders.order_date DESC";

    echo '<div class="container text-center mt-5"> 
        <h2>My Orders</h2>
    </div>';

    $r = mysqli_query($link, $q);
    
    $orders = [];

    

    include '../includes/footer.php'; ?>
    
</body>
</html>