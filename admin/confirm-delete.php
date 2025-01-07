


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shop Admin Page</title>
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

        # 1. Connect to the database
        require('../config/connect.php');

        # Check if ID is passed in the URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            # 2. Retrieve the item details
            $q = "SELECT * FROM products WHERE item_id = '$id'";
            $r = mysqli_query($link, $q);
            
            if ($row = mysqli_fetch_assoc($r)) {
                // retrieve item name to display in the page for confirmation
                $item_name = $row['item_name'];  
            } else {
                echo "Item not found.";
                exit;
            }

            # 3. Show confirmation form - delete or go back to catalogue 
            echo '
            <div class="container mt-5 mb-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-center m-5">Are you sure you want to delete the item: <strong>' . htmlspecialchars($item_name) . '</strong>?</h5>
                                <form action="../admin/delete.php?id=' . $id . '" method="post">
                                    <input type="hidden" name="item_id" value="' . $id . '">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-danger btn-lg mr-2">Yes, Delete</button>
                                        <a href="../public/admin_page.php" class="btn btn-secondary btn-lg">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        } else {
            echo "Invalid item ID.";
        }

        mysqli_close($link);

        include '../includes/footer.php';
        ?>
    </body>
</html>