<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shop Admin Page</title>
        <link rel="stylesheet" href="../assets/style/style.css">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    </head>
    <body>

    <?php 
    include '../includes/nav.php'; 

    # Logic for update item form submission 

    # 1. connect to database 
    require('../config/connect.php');

    # 2. initialize error array
    $errors = array();

    # 3. Fetch item details from database if item_id is passed in the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        # Fetch the item from the database
        $q = "SELECT * FROM products WHERE item_id = '$id'";
        $r = mysqli_query($link, $q);

        # If item found, populate the form fields with existing data
        if ($row = mysqli_fetch_assoc($r)) {
            $item_name = $row['item_name'];
            $item_desc = $row['item_desc'];
            $item_img = $row['item_img'];
            $item_price = $row['item_price'];
        } else {
            echo "Item not found.";
        }
    }

    # 4. Process form submission (update the item)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        # Validate fields and update the item if valid
        if (empty($_POST['item_id'])) {
            $errors['item_id'] = 'Item ID is required.';
        } else {
            $id = mysqli_real_escape_string($link, trim($_POST['item_id']));
        }

        if (empty($_POST['item_name'])) {
            $errors['item_name'] = 'Item name is required.';
        } else {
            $name = mysqli_real_escape_string($link, trim($_POST['item_name']));
        }

        if (empty($_POST['item_desc'])) {
            $errors['item_desc'] = 'Item description is required.';
        } else {
            $descr = mysqli_real_escape_string($link, trim($_POST['item_desc']));
        }

        if (empty($_POST['item_img'])) {
            $errors['item_img'] = 'Item image is required.';
        } else {
            $img = mysqli_real_escape_string($link, trim($_POST['item_img']));
        }

        if (empty($_POST['item_price'])) {
            $errors['item_price'] = 'Item price is required.';
        } else {
            $price = mysqli_real_escape_string($link, trim($_POST['item_price']));
        }

        # If no errors, update the database
        if (empty($errors)) {
            $q = "UPDATE products 
                SET item_name='$name', item_desc='$descr', item_img='$img', item_price='$price' 
                WHERE item_id='$id'";

            $r = mysqli_query($link, $q);
            
            if ($r) {
                # Redirect to the products page
                header("Location: ../public/admin_page.php");
                exit();
            } else {
                # Display error if update failed
                echo "Error updating record: " . mysqli_error($link);
            }

            # Close database connection.
            mysqli_close($link);
        } 
    }
    ?>

    <div class="container mt-4 p-3">

        <h1 class="text-center">Update Item</h1>

        <form action="../admin/update.php" method="post" class="needs-validation" novalidate>

            <!-- item id (hidden) -->
            <input type="hidden" name="item_id" value="<?php echo $id; ?>">

            <!-- item name -->
            <label for="name">Item name</label>
            <input type="text" 
            id="item_name" 
            class="form-control <?php echo isset($errors['item_name']) ? 'is-invalid' : ''; ?>" 
            name="item_name" 
            value="<?php echo isset($_POST['item_name']) ? $_POST['item_name'] : $item_name; ?>" 
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_name']) ? $errors['item_name'] : ''; ?>
            </div>

            <!-- item description -->
            <label for="description">Description</label>
            <textarea 
            id="item_desc" 
            class="form-control <?php echo isset($errors['item_desc']) ? 'is-invalid' : ''; ?>" 
            name="item_desc" 
            required><?php echo isset($_POST['item_desc']) ? $_POST['item_desc'] : $item_desc; ?></textarea>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_desc']) ? $errors['item_desc'] : ''; ?>
            </div>

            <!-- item image -->
            <label for="image">Image</label>
            <input type="text" 
            id="item_img" 
            class="form-control <?php echo isset($errors['item_img']) ? 'is-invalid' : ''; ?>" 
            name="item_img" 
            value="<?php echo isset($_POST['item_img']) ? $_POST['item_img'] : $item_img; ?>" 
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_img']) ? $errors['item_img'] : ''; ?>
            </div>

            <!-- item price -->
            <label for="price">Price</label>
            <input type="number" 
            id="item_price" 
            class="form-control <?php echo isset($errors['item_price']) ? 'is-invalid' : ''; ?>" 
            name="item_price" min="0" step="0.01" 
            value="<?php echo isset($_POST['item_price']) ? $_POST['item_price'] : $item_price; ?>" 
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_price']) ? $errors['item_price'] : ''; ?>
            </div>

            <!-- submit button -->
            <div class="text-center m-3">
                <input type="submit" class="btn btn-dark m-1" value="Update">
                <a class="btn btn-dark" href="../public/admin_page.php">Cancel</a>
            </div>
            
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>

    </body>
</html>
