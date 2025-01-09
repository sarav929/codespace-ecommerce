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

            # handle updating of cart 

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
            echo '<form action="../public/cart.php" method="post">';
        
            while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {
        
                # Calculate sub-totals and grand total.
                $subtotal = $_SESSION['cart'][$row['item_id']]['quantity'] * $_SESSION['cart'][$row['item_id']]['price'];
                $total += $subtotal;
        
                # Display the row/s:
                echo "<div class='cart-item-container'>
                    <div class='first-row'>
                    <h2>{$row['item_name']}</h2>
                    <button data-decrease>-</button> 
                    <input id='input-qty' type=\"text\" 
                        size=\"3\" 
                        name=\"qty[{$row['item_id']}]\" 
                        value=\"{$_SESSION['cart'][$row['item_id']]['quantity']}\"> 
                    <button data-increase>+</button>
                    <button data-remove>Remove</button>
                    </div> 
                    <div class='item-total'> &pound ".number_format ($subtotal, 2)." </div>
                </div>";     
            }

            # Display the total.
            echo '<p id="order-total">Order Total: &pound '.number_format($total,2).'</p>
            <p><input type="submit" name="submit" class="btn btn-light btn-block" value="Update My Cart"></p>
            <br>
            <a href="../includes/checkout.php?total='.$total.'" class="btn btn-light btn-block">Checkout Now</a><br>
            </form>'; 
            
            print_r($_SESSION['cart']);
        }

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
                if (currentQty > 1) { // Prevent negative or zero quantity
                    input.value = currentQty - 1;
                }
            });
        });

        removeBtns.forEach(button => {
            button.addEventListener('click', () => {
                const row = button.closest('.cart-item-container'); // Parent container
                row.remove(); // Remove the item row
            });
        });
    });
        
    </script>
</html>