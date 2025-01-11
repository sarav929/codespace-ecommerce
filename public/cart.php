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

    <?php 

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    include '../includes/nav.php';

    # Update Cart

    # Check if form has been submitted for update.
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        # Update changed quantity field values.
        foreach ( $_POST['qty'] as $item_id => $item_qty )
        {
            # Ensure values are integers.
            $id = (int) $item_id;
            $qty = (int) $item_qty;

            # Change quantity or delete if zero.
            if ( $qty == 0 ) { 
                unset ($_SESSION['cart'][$id]); 
            } elseif ( $qty > 0 ) { 
                $_SESSION['cart'][$id]['quantity'] = $qty;
            }
        }
    }

    # Initialise grand total variable.
    $total = 0; 

    # If cart is not empty
    if (!empty($_SESSION['cart'])) {

        # Connect to databse 
        require ('../config/connect.php');

        # Get items 
        $q = "SELECT * FROM products WHERE item_id IN (";
        foreach ($_SESSION['cart'] as $id => $value) { 
            $q .= $id . ','; 
        }
        $q = substr( $q, 0, -1 ) . ') ORDER BY item_id ASC';


        $r = mysqli_query($link, $q);

        # Display body section with a form and a table.
        echo '<div class="container mt-5">
        <form action="cart.php" method="post">';

        while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

            # Calculate sub-totals and grand total.
            $subtotal = $_SESSION['cart'][$row['item_id']]['quantity'] * $_SESSION['cart'][$row['item_id']]['price'];
            $total += $subtotal;
            # Display the row/s:
            echo "<div class='row m-2'>
                <div class='col align-content-center'>
                    <img class='img-thumbnail rounded' style='max-width: 200px;' src='../assets/img/".$row['item_img'].".jpg'>
                </div>
                <div class='col align-content-center'>
                    <h4>{$row['item_name']}</h4>
                    <h5>{$row['item_brand']}</h5>
                </div>
                <div class='col align-content-center'>
                    <p>Quantity</p>
                    <input type=\"number\" 
                    min=\"0\" 
                    max=\"10\"
                    name=\"qty[{$row['item_id']}]\" 
                    value=\"{$_SESSION['cart'][$row['item_id']]['quantity']}\">
                </div> 
                <div class='col align-content-center'>
                    <p>Price</p>
                    <p>&pound ".number_format ($subtotal, 2)."</p>
                </div>
            </div>";
        }

        # Display the total.
        echo '<div class="container"> 
        <h5 class="text-right m-4">Order Total: &pound '.number_format($total,2).'</h5>
        <p><input type="submit" name="submit" class="btn btn-light btn-block" value="Update My Cart">
        <a href="../includes/checkout.php?total='.$total.'" class="btn btn-light btn-block">Checkout Now</a>
        <br>
        </div>
        </div>
        </form>';

    } else {
        echo '<h4 class="text-center mt-5">Your cart is currently empty</h4>';
    }

    ?>
    
</body>
</html>