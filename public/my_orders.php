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

    # 2. Retrieve the orders 
    $q = "SELECT * FROM orders WHERE user_id = " . $_SESSION['user_id'];
    $r = mysqli_query($link, $q);

    # If there are any orders in the table: display them
    if (mysqli_num_rows($r) > 0) {

        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            // Check if all fields are present
            $order_id = !empty($row['order_id']) ? $row['order_id'] : 'N/A'; 
            $order_total = !empty($row['total']) ? $row['total'] : 'N/A';
            $order_date = !empty($row['order_date']) ? $row['order_date'] : 'N/A';

            echo '<div> 
            <p> Order #' . $order_id . '</p>
            <p> Order total: ' . $order_total . '</p>
            <p> Date: ' . $order_date . '</p>
            <p> Status: Confirmed </p>
            </div>';
        }

        # Close the database connection
        mysqli_close($link);

    } else { 
        # else: print out that the table is empty 
        echo '<h2 class="text-center mt-4 p-3">No orders to display.</p>'; 
    }


    include '../includes/footer.php'; ?>
    
</body>
</html>