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

    echo '<div class="container text-center mt-5 mb-5"> 
        <h2>My Orders</h2>
    </div>';

    $r = mysqli_query($link, $q);
    
    $orders = [];

    # add info to array sorting by order id 
    while ($row = mysqli_fetch_assoc($r)) {
        $order_id = $row['order_id'];

        # check if order already exists, if it doens't initiate the array item
        if (!isset($orders[$order_id])) {
            $orders[$order_id] = [
                # per each order register order information 
                'order_date' => $row['order_date'],
                'order_total' => $row['total'],
                'order_items' => [] # array where to add items for that order
            ];
        }

        # add items to the items array
        $orders[$order_id]['order_items'][] = $row;
    }

    # If there are any orders in the table: display them
    if (count($orders) > 0) {

        # 1. get order data according to order_id
        foreach ($orders as $order_id => $order_data) {

            $order_date = $order_data['order_date'];
            $order_total = number_format($order_data['order_total'], 2);

            echo "<div class='container border-top'>
                <div class='row mt-4'>
                <div class='col align-content-center'>
                    <h4>Order #".$order_id."</h4>
                    <p class='font-italic'>Date: ".$order_date."</p>
                </div>
            </div>";

            # 2. print each item from the order 
            foreach ($order_data['order_items'] as $item) {

                $item_img = !empty($item['item_img']) ? $item['item_img'] : 'N/A.jpg';
                $item_name = $item['item_name'];
                $item_quantity = $item['quantity'];
                $item_total = number_format($item['item_total'], 2);

                echo "
                <div class='row m-2'>
                    <div class='col align-content-center'>
                        <img class='img-thumbnail rounded' style='max-width: 100px;' src='../assets/img/".$item_img.".jpg'>
                    </div>
                    <div class='col align-content-center'>
                        <h5>".$item_name."</h5>
                    </div>
                    <div class='col align-content-center'>
                        <p>".$item_quantity."</p>
                    </div> 
                    <div class='col align-content-center'>
                        <p>&pound ".$item_total."</p>
                    </div>
                    </div>";

            }

            echo "<div class='row m-2 justify-content-end'>
                <h5>Total: &pound ".$order_total."</h5>
            </div>
            <div class='row m-2 justify-content-end'>
                <p class='text-success p-2 border rounded border-success'>Status: Confirmed</p>
            </div>
            </div>";
        }

        # Close the database connection
        mysqli_close($link);

    } else { 
        # else: print out that the table is empty 
        echo '<h3 class="text-center mt-4 p-3">No orders to display.</h3>'; 
    }

    include '../includes/footer.php'; ?>
    
</body>
</html>