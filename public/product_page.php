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

        # perfume notes array

        $notes = explode(", ", $row["item_notes"]);

        # Render product page
        echo '
        <div class="container-fluid d-flex mt-5">
            <img class="img-fluid" src="../assets/img/'.$row["item_img"].'.jpg">
            <div class="container flex-col">
                <h1 class="heading display-4 font-weight-bold">'.$row["item_name"].' <span class="heading font-weight-light">by '.$row["item_brand"].'</span></h1>
                <h4 class="mb-4">'.$row["item_type"].'</h4>
                <p>'.$row["item_desc"].'</p>

                <h4 class="mt-4">Notes</h4>
                <h5 class="font-weight-light mb-4"> • ';

                foreach($notes as $note) {
                    echo '<span class="note">'. $note . '</span> • '; 
                }
                            
                echo'</h5>
 
                <div>
                    <h6 class="mt-5 title3">£ '.$row["item_price"].' ('.$row["item_ml"].' ml)</h6>
                    <a class="btn btn-dark mt-3 mb-5 p-3" href="../includes/added.php?id=' . $row['item_id'] . '">Add to bag</a>
                </div>

                
            </div>
        </div>';
        
        include '../includes/footer.php'; 
        ?>        
    </body>
</html>