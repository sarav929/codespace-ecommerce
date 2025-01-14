<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nocturne Scents</title>
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

        $sort = 'item_name';

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
        }

        # Initialize filter variables
        $filter = '';  // For SQL
        $filter_query = '';  // For URL

        if (isset($_GET['type'])) {
            $type = mysqli_real_escape_string($link, $_GET['type']);
            $filter = "WHERE item_type LIKE '%$type%'";
            $filter_query = '&type=' . urlencode($_GET['type']);
        } elseif (isset($_GET['brand'])) {
            $brand = mysqli_real_escape_string($link, $_GET['brand']);
            $filter = "WHERE item_brand = '$brand'";
            $filter_query = '&brand=' . urlencode($_GET['brand']);
        }

        # Retrieve distinct item types
        $type_list = mysqli_query($link, "SELECT DISTINCT item_type FROM products");
        $types = [];
        while ($row = mysqli_fetch_assoc($type_list)) {
            $items = array_map('trim', explode(',', $row['item_type'])); // Split and trim
            $types = array_unique(array_merge($types, $items)); // Remove duplicates
        }

        # Retrieve distinct brands
        $brands_list = mysqli_query($link, "SELECT DISTINCT item_brand FROM products");

        # Page Content
        echo "<div class='container m-auto'>
        <div class='mt-5 d-flex flex-column align-items-center text-center'> 
            <h1 class='heading title1'>Fragrances</h2>
            <p>Explore our selection of eaux and extraits de parfum</p> 
        </div>";

            # container for dropdowns
            echo "<div class='container d-flex align-items-center mt-4 text-right'>
                
                <div class='d-flex align-items-center'> 
                <img class='mr-3' src='../assets/icons/filter.png' style='width:1.2rem;'>";
                
                    # Dropdown for brands
                    echo '<div class="dropdown mr-3">
                        <a class="btn btn-light dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Brand
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="../public/session_cart.php?&sort=' . $sort . '">All</a>
                        <div class="dropdown-divider"></div>';
                    while ($row = mysqli_fetch_array($brands_list, MYSQLI_ASSOC)) {
                        echo '<a class="dropdown-item" href="../public/session_cart.php?brand=' . $row['item_brand'] . '">' . $row['item_brand'] . '</a>';
                    }
                    echo '</div></div>';

                    # Dropdown for types
                    echo '<div class="dropdown mr-3">
                        <a class="btn btn-light dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Type
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="../public/session_cart.php?&sort=' . $sort . '">All</a>
                        <div class="dropdown-divider"></div>';
                    foreach ($types as $type) {
                        echo '<a class="dropdown-item" href="../public/session_cart.php?type=' . $type . '&sort=' . $sort . '">' . $type . '</a>';
                    }
                    echo '</div></div>
                </div>';

                # Dropdown for sorting
                echo "<div class='dropdown'>
                    <a class='btn btn-light dropdown-toggle' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        Sort by 
                    </a>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuLink'> 
                        <a class='dropdown-item' href='../public/session_cart.php?sort=brand" . $filter_query . "'>Brand</a>
                        <a class='dropdown-item' href='../public/session_cart.php?sort=name" . $filter_query . "'>Name</a>
                        <a class='dropdown-item' href='../public/session_cart.php?sort=price-asc" . $filter_query . "'>Price: Low to High</a>
                        <a class='dropdown-item' href='../public/session_cart.php?sort=price-desc" . $filter_query . "'>Price: High to Low</a>
                    </div>
                </div> </div>";

            # Fetch and display products
            $q = "SELECT * FROM products $filter ORDER BY $sort";
            $r = mysqli_query($link, $q);
            if (!$r) {
                die("Query failed: " . mysqli_error($link));
            }

            echo '<div class="row">';

            # Product card 

            if (mysqli_num_rows($r) > 0) {
                while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                    echo '
                    <div class="col-md-3 d-flex justify-content-center mt-4 p-3 text-center">
                    <div class="card" style="width: 18rem;">
                        <a href="../public/product_page.php?id=' . $row['item_id'] . '">
                        <img src="../assets/img/' . $row['item_img'] . '.jpg" class="card-img-top" alt="Product Image">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title text-center heading title2">' . $row['item_name'] . '</h5>
                            <h6 class="card-title text-center">' . $row['item_brand'] . '</h6>
                            <p class="card-text font-italic">' . $row['item_ml'] . ' ml</p>
                        </div>
                        <ul class="list-group list-group-flush text-center">
                            <li class="list-group-item"><p class="d-flex justify-content-center align-items-center font-weight-bold">£ ' . $row['item_price'] . '</p></li>
                        </ul>
                    </div>
                </div>';
                }
            } else {
                echo '<div class="container-fluid mt-5 text-center">
                    <h4>There are currently no items in the shop.</h4>
                </div>';
            }
            echo '</div>
        </div>';

        mysqli_close($link);
        
        include '../includes/footer.php'; ?>  
    </body>
</html>