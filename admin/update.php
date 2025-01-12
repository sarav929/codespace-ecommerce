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
            $item_brand = $row['item_brand'];
            $item_notes = $row['item_notes'];
            $item_type = $row['item_type'];
            $item_ml = $row['item_ml'];
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

        if (empty($_POST['item_brand'])) {
            $errors['item_brand'] = 'Enter the item brand.';
        } else {
            $brand = mysqli_real_escape_string($link, trim($_POST['item_brand']));
        }

        if (empty($_POST['item_notes'])) {
            $errors['item_notes'] = 'Enter the item notes (separated by commas).';
        } else {
            $notes = mysqli_real_escape_string($link, trim($_POST['item_notes']));
        }

        if (empty($_POST['item_type'])) {
            $errors['item_type'] = 'Enter the item type (if multiple, separated by commas).';
        } else {
            $type = mysqli_real_escape_string($link, trim($_POST['item_type']));
        }

        if (empty($_POST['item_ml'])) {
            $errors['item_ml'] = 'Enter the item capacity in ml.';
        } else {
            $ml = mysqli_real_escape_string($link, trim($_POST['item_ml']));
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
            <label for="name" class="form-label">Item name</label>
            <input type="text" 
            id="item_name" 
            class="form-control <?php echo isset($errors['item_name']) ? 'is-invalid' : ''; ?>" 
            name="item_name" 
            value="<?php echo isset($_POST['item_name']) ? $_POST['item_name'] : $item_name; ?>"
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_name']) ? $errors['item_name'] : ''; ?>
            </div>

            <!-- item brand -->
            <label for="brand" class="form-label">Item brand</label>
            <input type="text" 
            id="item_brand" 
            class="form-control <?php echo isset($errors['item_brand']) ? 'is-invalid' : ''; ?>" 
            name="item_brand"
            value="<?php echo isset($_POST['item_brand']) ? $_POST['item_brand'] : $item_brand; ?>" 
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_brand']) ? $errors['item_brand'] : ''; ?>
            </div>

            <!-- item type -->
            <label for="type" class="form-label">Item type</label>
            <input type="text" 
            id="item_type" 
            class="form-control <?php echo isset($errors['item_type']) ? 'is-invalid' : ''; ?>" 
            name="item_type" 
            value="<?php echo isset($_POST['item_type']) ? $_POST['item_type'] : $item_type; ?>"  
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_type']) ? $errors['item_type'] : ''; ?>
            </div>

            <!-- item notes -->
            <label for="notes" class="form-label">Item notes</label>
            <input type="text" 
            id="item_notes" 
            class="form-control <?php echo isset($errors['item_notes']) ? 'is-invalid' : ''; ?>" 
            name="item_notes" 
            value="<?php echo isset($_POST['item_notes']) ? $_POST['item_notes'] : $item_notes; ?>"  
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_notes']) ? $errors['item_notes'] : ''; ?>
            </div>

            <!-- item description -->
            <label for="description" class="form-label">Description</label>
            <textarea id="item_desc" 
            class="form-control <?php echo isset($errors['item_desc']) ? 'is-invalid' : ''; ?>"
            name="item_desc"
            required><?php echo isset($_POST['item_desc']) ? $_POST['item_desc'] : $item_desc; ?></textarea>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_desc']) ? $errors['item_desc'] : ''; ?>
            </div>

            <!-- item image -->
            <label for="img" class="form-label">Image</label>
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
            <label for="price" class="form-label">Price</label>
            <input type="number" 
            id="item_price" 
            class="form-control <?php echo isset($errors['item_price']) ? 'is-invalid' : ''; ?>" 
            name="item_price" min="0" step="0.01" 
            value="<?php echo isset($_POST['item_price']) ? $_POST['item_price'] : $item_price; ?>" 
            required>
            
            <div class="invalid-feedback">
                <?php echo isset($errors['item_price']) ? $errors['item_price'] : ''; ?>
            </div>            
            
            <!-- item ml -->
            <label for="ml" class="form-label">Item capacity (ml)</label>
            <input type="number" 
            id="item_ml" 
            class="form-control <?php echo isset($errors['item_ml']) ? 'is-invalid' : ''; ?>" 
            name="item_ml" 
            value="<?php echo isset($_POST['item_ml']) ? $_POST['item_ml'] : $item_ml; ?>"
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_ml']) ? $errors['item_ml'] : ''; ?>
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
