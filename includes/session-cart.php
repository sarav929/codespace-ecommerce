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
            <div class="col-md-3 d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
            <img src="'. $row['item_img'].'" class="card-img-top" alt="'. $row['item_name'].'">
            <div class="card-body text-center">
                <h5 class="card-title">'. $row['item_name'].'</h5>
                <p class="card-text">'. $row['item_desc'].'</p>
            </div>
            <div class="card-footer bg-transparent border-dark text-center">
                <p class="card-text">&pound '. $row['item_price'].'</p>
            </div>
            <div class="card-footer text-muted">
                <a href="added.php?id='.$row['item_id'].'" class="btn btn-light btn-block">Add to Cart</a>
            </div>
            </div>
            </div>';
        }
        
        # Close database connection.
        mysqli_close( $link) ; 
	}

	# Or display message.
	else { 
        echo '<p>There are currently no items in the table to display.</p>'; 
    }

?>