<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require ('../config/connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$q = "SELECT * FROM products WHERE item_id = $id";
$r = mysqli_query($link, $q);

if (mysqli_num_rows($r) == 1) {
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity']++;
} else {
    $_SESSION['cart'][$id] = array('quantity' => 1, 'price' => $row['item_price']);
}

# Cart Update Modal #

echo '
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Cart Update</h5>
                <button type="button" class="close" aria-label="Close">✕</button>
            </div>
            <div class="modal-body">
                '.htmlspecialchars($row["item_name"]).' has been added to your cart.
            </div>
            <div class="modal-footer">
                <a href="../public/session_cart.php" class="btn btn-dark">Continue Shopping</a>
                <a href="../public/cart.php" class="btn btn-dark">View Your Cart</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modal = new bootstrap.Modal(document.getElementById("cartModal"));
        modal.show();
    });
</script>
';

include ('../public/product_page.php');

?>
