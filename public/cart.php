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

    session_start();
    
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
            if ( $qty == 0 ) { unset ($_SESSION['cart'][$id]); } 
            elseif ( $qty > 0 ) { $_SESSION['cart'][$id]['quantity'] = $qty; }
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
        echo '<form action="cart.php" method="post">';

        while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

            # Calculate sub-totals and grand total.
            $subtotal = $_SESSION['cart'][$row['item_id']]['quantity'] * $_SESSION['cart'][$row['item_id']]['price'];
            $total += $subtotal;

            # Display the row/s:
            echo "{$row['item_name']} 
            <input type=\"text\" 
                size=\"3\" 
                name=\"qty[{$row['item_id']}]\" 
                value=\"{$_SESSION['cart'][$row['item_id']]['quantity']}\">
            <br>@ {$row['item_price']} = 
            
            <br> &pound ".number_format ($subtotal, 2)." ";

            # Display the total.
            echo ' <p>Total = &pound '.number_format($total,2).'</p>
            <p><input type="submit" name="submit" class="btn btn-light btn-block" value="Update My Cart"></p>
            <br>
            <a href="checkout.php?total='.$total.'" class="btn btn-light btn-block">Checkout Now</a><br>
            </form>';
        }

    } else {
        echo '<h4 class="text-center mt-5">Your bag is currently empty</h4>';
    }

    include '../includes/footer.php'; ?>
    
</body>
</html>