<?php 

    include ('../includes/session-cart.php');

    # Getting the product id from the URL.
    if (isset( $_GET['id'] )) $id = $_GET['id'];

    # Handling Query Result
    if ( mysqli_num_rows( $r ) == 1 ) {
        $row = mysqli_fetch_array( $r, MYSQLI_ASSOC );
        // Product details are fetched and stored in $row
    }

    # CART MANAGEMENT #
    # Check if cart already contains one of this product id.

    if (isset( $_SESSION['cart'][$id] )) { 

        # Add one more of this product.
        $_SESSION['cart'][$id]['quantity']++; 

        echo '<div class="container">
                <div class="alert alert-secondary" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p>Another '.$row["item_name"].' has been added to your cart</p>
                    <a href="home.php">Continue Shopping</a> | <a href="cart.php">View Your Cart</a>
                </div>
            </div>';

    } else {

        # Or add one of this product to the cart.
        $_SESSION['cart'][$id]= array ( 'quantity' => 1, 'price' => $row['item_price'] );

        echo '<div class="container">
                <div class="alert alert-secondary" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p>A '.$row["item_name"].' has been added to your cart</p>
                <a href="home.php">Continue Shopping</a> | <a href="cart.php">View Your Cart</a>
                </div>
            </div>' ;
    }

    # Check if form has been submitted for update.
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        # Update changed quantity field values.
        foreach ( $_POST['qty'] as $item_id => $item_qty ) {
    
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
    
    # Check the cart is not empty
    if (!empty($_SESSION['cart'])) {
    
        # Connecting to the Database 
        require ('connect_db.php');
    
        # build the SQL query 
        $q = "SELECT * FROM products WHERE item_id IN (";
        foreach ($_SESSION['cart'] as $id => $value) { $q .= $id . ','; }
        $q = substr( $q, 0, -1 ) . ') ORDER BY item_id ASC';
    
        # Executing the query.
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
            echo '<p>Total = &pound '.number_format($total,2).'</p>
            <p><input type="submit" name="submit" class="btn btn-light btn-block" value="Update My Cart"></p>
            <br>
            <a href="checkout.php?total='.$total.'" class="btn btn-light btn-block">Checkout Now</a><br>
            </form>';       
        }
    }

?>