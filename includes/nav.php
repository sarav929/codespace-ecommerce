<?php

    if (!isset($_SESSION[ 'user_id' ])) {
        session_start();
    }
        
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark pr-5 pl-5">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- logo -->
        <a class="navbar-brand mr-5" href="../public/index.php">MKTIME</a>

        <!-- collapse nav -->
        <button class="navbar-toggler" type="button" 
                data-toggle="collapse" 
                data-target="#navbarNav" 
                aria-controls="navbarNav" 
                aria-expanded="false" 
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- nav links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link mr-5" href="../public/session_cart.php">Shop</a>
                </li>
            </ul>
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

            <a class="nav-link dropdown-toggle" href="../public/cart.php">
                <img class="nav-icon cart-icon" src="../assets/icons/bag.png" alt="Shopping Cart">
            </a>
        </div>
    </div>


        
    </div>
</nav>
