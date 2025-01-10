<?php 

include ('../public/session_cart.php');
require ('../config/connect.php');

# Getting the product id from the URL.
if (isset( $_GET['id'] )) {
    $id = $_GET['id'];
}

# Executes a SQL query to fetch product details
$q = "SELECT * FROM products WHERE item_id = $id";
$r = mysqli_query( $link, $q );

#  Handling Query Result
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
                <a href="../public/index.php">Continue Shopping</a> | <a href="../public/cart.php">View Your Cart</a>
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
                <p>'.$row["item_name"].' has been added to your cart</p>
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

?>
