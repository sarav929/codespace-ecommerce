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
        <?php include '../includes/nav.php'; ?>

                
            
            <?php 

                # open database connection.
                require ( '../config/connect.php' );

                echo '<div class="row">';	

                # Retrieve items from 'products' database table.
                $q = "SELECT * FROM products" ;
                $r = mysqli_query( $link, $q ) ;
                if ( mysqli_num_rows( $r ) > 0 ) {

                    # Display body section.
                    while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC )) {
                        echo '
                        <div class="col-md-3 d-flex justify-content-center mt-4 p-3 text-center">
                        <div class="card" style="width: 18rem;">
                            <img src="../assets/img/' . $row['item_img'] . '.png" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title text-center">' . $row['item_name'] . '</h5>
                                <h6 class="card-title text-center">by ' . $row['item_brand'] . '</h6>
                                <p class="card-text">' . $row['item_ml'] . ' ml</p>
                            </div>
                            <ul class="list-group list-group-flush text-center">
                                <li class="list-group-item"><p class="d-flex justify-content-center align-items-center">' . $row['item_price'] . '</p></li>
                                <li class="list-group-item">
                                    <a class="btn btn-dark" href="../public/product_page.php?id=' . $row['item_id'] . '">View More</a>
                                    <a class="btn btn-dark" href="../public/added.php?id=' . $row['item_id'] . '">Add to bag</a>
                                </li>
                            </ul>
                        </div>
                    </div>';
                    }
                    
                    # Close database connection.
                    mysqli_close( $link) ; 
                }

                # Or display message.
                else { 
                    echo '<p>There are currently no items in the shop.</p>'; 
                }
                ?>
            </div>

            <?php include '../includes/footer.php'; ?>  

                

    </body>
</html>