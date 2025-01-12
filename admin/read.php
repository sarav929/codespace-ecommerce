        <div class="text-center mt-5">
            <a href="../admin/create.php" class="btn btn-dark">Add New Product</a>
        </div>
        

        <?php 
        # 1. Connect to the database
        require('../config/connect.php');

        # 2. Retrieve the items 
        $q = "SELECT * FROM products";
        $r = mysqli_query($link, $q);

        # If there are any items in the table: display them
        if (mysqli_num_rows($r) > 0) {
            echo '<div class="row d-flex justify-content-center">'; // Start a row to organize cards

            while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                // Check if all fields are present
                $item_img = !empty($row['item_img']) ? $row['item_img'] : 'placeholder.jpg'; 
                $item_name = !empty($row['item_name']) ? $row['item_name'] : 'No Name';
                $item_desc = !empty($row['item_desc']) ? $row['item_desc'] : 'No description available.';
                $item_price = !empty($row['item_price']) ? '£ '. $row['item_price'] : 'Price not set';
                $item_brand = !empty($row['item_brand']) ? $row['item_brand'] : 'Brand not set';
                $item_notes = !empty($row['item_notes']) ? $row['item_notes'] : 'Notes are not set';
                $item_type = !empty($row['item_type']) ? $row['item_type'] : 'Type is not set';
                $item_ml = !empty($row['item_ml']) ? $row['item_ml'] . 'ml' : 'Capacity is not set';

                echo '
                <div class="col-md-3 d-flex justify-content-center mt-4 p-3 text-center">
                    <div class="card" style="width: 18rem;">
                        <img src="../assets/img/' . htmlspecialchars($item_img) . '.jpg" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title text-center">' . htmlspecialchars($item_name) . '</h5>
                            <p class="card-text">by ' . htmlspecialchars($item_brand) . '</p>
                        </div>
                        <ul class="list-group list-group-flush text-center">
                            <li class="list-group-item"><p class="d-flex justify-content-center align-items-center">' . htmlspecialchars($item_price) . ' - ' . htmlspecialchars($item_ml) . '</p></li>
                            <li class="list-group-item">
                                <a class="btn btn-dark btn-lg btn-block" href="../admin/update.php?id=' . $row['item_id'] . '">Update</a>
                            </li>
                            <li class="list-group-item">
                                <a class="btn btn-dark" href="../admin/confirm-delete.php?id=' . $row['item_id'] . '">Delete Item</a>
                            </li>
                        </ul>
                    </div>
                </div>';
            }

            echo '</div>'; # Close row
            echo '</div>'; # Close container

            # Close the database connection
            mysqli_close($link);

        } else { 
            # else: print out that the table is empty 
            echo '<p class="text-center mt-4 p-3">There are currently no products in the shop.</p>'; 
        }
        ?>