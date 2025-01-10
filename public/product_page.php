<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log in</title>

        <link rel="stylesheet" href="../assets/style/style.css">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
        crossorigin="anonymous">

    </head>
    <body>

        <?php 
        include '../includes/nav.php';

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

        # Render product page
        echo '<div class="container">
                <h1>'.$row["item_name"].'</h1>
                <img src="'.$row["item_img"].'">
                <p>'.$row["item_desc"].'</p>
    
                <a class="btn btn-dark" data-toggle="modal" data-target="#bagModal" href="../public/added.php?id=' . $row['item_id'] . '">Add to bag</a>
            </div>
         </div>';
        
        include '../includes/footer.php'; 
        ?>        
    </body>
</html>