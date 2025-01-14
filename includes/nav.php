<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
        
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- logo -->
        <div class="nav-left d-flex align-items-center">
            <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle mr-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                ☰
            </button>
            <div class="dropdown-menu dropdown-menu">
                <a href="index.php" class="dropdown-item" type="button">Home</a>
                <a href="session_cart.php" class="dropdown-item" type="button">Shop</a>
            </div>
            </div>
            <a class="navbar-brand mr-5 logo" href="../public/index.php">Nocturne Scents</a>

        </div>

        <div class="nav-right">

            <!-- user -->

            <!-- LOGGED USER -->
            <?php if (isset($_SESSION[ 'user_id' ])): ?>

            <div class="user-section d-flex flex-row align-items-center p-3">
                <div class="logged-username">Hi, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</div>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="nav-icon user-icon" src="../assets/icons/user.png" alt="User Icon">
                    </a>
                        
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item d-flex align-items-center" href="../includes/logout.php"><img src="../assets/icons/logout.png" class="dropdown-icon"> Log Out</a>
                        <a class="dropdown-item d-flex align-items-center" href="../public/my_orders.php"><img src="../assets/icons/bag.png" class="dropdown-icon"> My Orders</a>
                        <!-- admin page for admin account -->
                        <?php if (isset($_SESSION[ 'user_id' ]) && $_SESSION[ 'user_id' ] == 8): ?>
                            <a class="dropdown-item d-flex align-items-center" href="../public/admin_page.php"><img src="../assets/icons/settings.png" class="dropdown-icon">Manage Shop</a>
                        <?php endif; ?>

                    </div>
                </div>

            </div>

            <!-- GUEST -->
            <?php else: ?>
            <div class="user-section d-flex flex-row align-items-center p-3">
                <div class="logged-username">Welcome!</div>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="nav-icon user-icon" src="../assets/icons/user.png" alt="User Icon">
                    </a>
                        
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item d-flex align-items-center" href="../public/register.php">Create Account</a>
                        <a class="dropdown-item d-flex align-items-center" href="../public/login.php">Log In</a>
                    </div>
                    
                </div>
            </div>
            <?php endif; ?>
            
            <!-- shopping cart  -->            
            
                <a class="nav-link dropdown-toggle bag-icon position-relative" href="../public/cart.php">
                    <img class="nav-icon cart-icon" src="../assets/icons/bag.png" alt="Shopping Cart">
                    <?php 
                    # notification badge for bag content
                        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                            echo '<span class="position-absolute top-0 start-100 translate-middle p-2 bg-secondary rounded-circle"></span>';
                        }
                    ?>
                </a>      
            </div>
        </div>
    </div>
        
    </div>

</nav>

