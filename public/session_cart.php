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

                # open database connection.
                require ( '../config/connect.php' );

                # check sort parameter
                if (isset($_GET['sort'])) {
                    switch ($_GET['sort']) {
                        case 'brand':
                            $sort = 'item_brand';
                            break;
                        case 'name':
                            $sort = 'item_name';
                            break;
                        case 'price-asc':
                            $sort = 'item_price ASC';
                            break;
                        case 'price-desc':
                            $sort = 'item_price DESC';
                            break;
                    }
                } else {
                    $sort = 'item_name';
                }


            echo "<div class='container text-center mt-5'> 
                <h2>Fragrances</h2>
                <p class='font-italic'>Explore our selection of eaux and extraits de parfum</p> 
            </div>";

            echo '<div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort by 
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"> 
                    <a class="dropdown-item" href="../public/session_cart.php?sort=brand">Brand</a>
                    <a class="dropdown-item" href="../public/session_cart.php?sort=name">Alphabetically</a>
                    <a class="dropdown-item" href="../public/session_cart.php?sort=price-asc">Price: Lower to Higher</a>
                    <a class="dropdown-item" href="../public/session_cart.php?sort=price-desc">Price: Higher to Lower</a>
                </div>
            </div>';

            echo '<div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort by 
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"> 
                    <a class="dropdown-item" href="../public/session_cart.php?sort=brand">Brand</a>
                    <a class="dropdown-item" href="../public/session_cart.php?sort=name">Alphabetically</a>
                    <a class="dropdown-item" href="../public/session_cart.php?sort=price-asc">Price: Lower to Higher</a>
                    <a class="dropdown-item" href="../public/session_cart.php?sort=price-desc">Price: Higher to Lower</a>
                </div>
            </div>';

            echo '<div class="row">';	

            # Retrieve items from 'products' database table.
            $q = "SELECT * FROM products ORDER BY ". $sort;
            $r = mysqli_query( $link, $q ) ;
            if ( mysqli_num_rows( $r ) > 0 ) {

                # Display body section.
                while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC )) {
                    echo '
                    <div class="col-md-3 d-flex justify-content-center mt-4 p-3 text-center">
                    <div class="card" style="width: 18rem;">
                        <a href="../public/product_page.php?id=' . $row['item_id'] . '">
                        <img src="../assets/img/' . $row['item_img'] . '.jpg" class="card-img-top" alt="Product Image">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title text-center">' . $row['item_name'] . '</h5>
                            <h6 class="card-title text-center">by ' . $row['item_brand'] . '</h6>
                            <p class="card-text">' . $row['item_ml'] . ' ml</p>
                        </div>
                        <ul class="list-group list-group-flush text-center">
                            <li class="list-group-item"><p class="d-flex justify-content-center align-items-center">£ ' . $row['item_price'] . '</p></li>
                        </ul>
                    </div>
                </div>';
                }
                
                # Close database connection.
                mysqli_close( $link) ; 
            }

            # Or display message.
            else { 
                echo '<div class="container-fluid mt-5 text-center">
                <h4>There are currently no items in the shop.</h4>
                </div>'; 
            }
            ?>
        </div>

        <?php include '../includes/footer.php'; ?>  

                

    </body>
</html>