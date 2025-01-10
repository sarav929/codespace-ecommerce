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

        # Initialise grand total variable.
        $total = 0; 
                
        # Check the cart is not empty
        if (!empty($_SESSION['cart'])) {
        
            # Connecting to the Database 
            require ('../config/connect.php');

            # show cart content with quantity > 0 or remove 
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['qty'])) {
                foreach ($_POST['qty'] as $id => $quantity) {
                    $quantity = max(0, (int)$quantity); // Ensure a valid quantity
                    if ($quantity > 0) {
                        $_SESSION['cart'][$id]['quantity'] = $quantity;
                    } else {
                        unset($_SESSION['cart'][$id]); // Remove item if quantity is zero
                    }
                }

                header('Location: ../public/cart.php'); // Redirect to avoid form resubmission
                exit;
            }
        
            # build the SQL query 
            $q = "SELECT * FROM products WHERE item_id IN (";
            foreach ($_SESSION['cart'] as $id => $value) { $q .= $id . ','; }
            $q = substr( $q, 0, -1 ) . ') ORDER BY item_id ASC';
        
            # Executing the query.
            $r = mysqli_query($link, $q);
        
            # Display body section with a form and a table.
            echo '<div class="col">
            <form action="../public/cart.php" method="post">';

            if ($r && mysqli_num_rows($r) > 0) {
            echo '<div class="container-fluid">
                <table class="table table-bordered">
                <tbody>';
            }

            while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            # Calculate sub-totals and grand total.
            $subtotal = $_SESSION['cart'][$row['item_id']]['quantity'] * $_SESSION['cart'][$row['item_id']]['price'];
            $total += $subtotal;

            # Display the row.
            echo "<tr>
                    <td>
                        <h5>{$row['item_name']}</h5>
                    </td>
                    <td class='d-flex align-items-center'>
                        <button data-decrease class='btn btn-dark rounded-circle mx-2'>-</button>
                        <input class='border-0 text-center rounded' id='input-qty' type='text' 
                            size='3' 
                            name='qty[{$row['item_id']}]' 
                            value='{$_SESSION['cart'][$row['item_id']]['quantity']}'> 
                        <button data-increase class='btn btn-dark rounded-circle mx-2'>+</button>
                    </td>
                    <td>&pound; " . number_format($subtotal, 2) . "</td>
                </tr>";
            }

            echo '</tbody>
            </table>';

            # Display the total and checkout button.
            echo '<div class="d-flex justify-content-between align-items-center my-4">
                <h5 id="order-total">Order Total: &pound; ' . number_format($total, 2) . '</h5>
                <a href="../includes/checkout.php?total=' . $total . '" class="btn btn-light btn-lg">Checkout Now</a>
            </div>';

            echo '</form>';
            } else {
            echo '<h2 class="text-center mt-5">Your cart is currently empty.</h2>';
            }

            echo '</div>';

        include '../includes/footer.php'; ?>
        
    </body>

    <script defer>
        document.addEventListener('DOMContentLoaded', () => {
            
        const increaseBtns = document.querySelectorAll('[data-increase]');
        const decreaseBtns = document.querySelectorAll('[data-decrease]');
        const removeBtns = document.querySelectorAll('[data-remove]');

        increaseBtns.forEach(button => {
            button.addEventListener('click', () => {
                const input = button.previousElementSibling; // Input element
                const currentQty = parseInt(input.value);
                input.value = currentQty + 1;
            });
        });

        decreaseBtns.forEach(button => {
            button.addEventListener('click', () => {
                const input = button.nextElementSibling; // Input element
                const currentQty = parseInt(input.value);
                input.value = currentQty - 1;
            });
        });

    });
        
    </script>
</html>