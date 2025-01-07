<?php 
include '../partials/nav.php'; 

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
        $item_description = $row['item_description'];
        $item_image = $row['item_image'];
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

    if (empty($_POST['item_description'])) {
        $errors['item_description'] = 'Item description is required.';
    } else {
        $descr = mysqli_real_escape_string($link, trim($_POST['item_description']));
    }

    if (empty($_POST['item_image'])) {
        $errors['item_image'] = 'Item image is required.';
    } else {
        $img = mysqli_real_escape_string($link, trim($_POST['item_image']));
    }

    if (empty($_POST['item_price'])) {
        $errors['item_price'] = 'Item price is required.';
    } else {
        $price = mysqli_real_escape_string($link, trim($_POST['item_price']));
    }

    # If no errors, update the database
    if (empty($errors)) {
        $q = "UPDATE products 
              SET item_name='$name', item_description='$descr', item_image='$img', item_price='$price' 
              WHERE item_id='$id'";

        $r = mysqli_query($link, $q);
        
        if ($r) {
            # Redirect to the products page
            header("Location: ../public/index.php");
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

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shop Admin Page</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    </head>
    <body>

    <div class="container mt-4 p-3">

        <h1 class="text-center">Update Item</h1>

        <form action="../controllers/update.php" method="post" class="needs-validation" novalidate>

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
            id="item_description" 
            class="form-control <?php echo isset($errors['item_description']) ? 'is-invalid' : ''; ?>" 
            name="item_description" 
            required><?php echo isset($_POST['item_description']) ? $_POST['item_description'] : $item_description; ?></textarea>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_description']) ? $errors['item_description'] : ''; ?>
            </div>

            <!-- item image -->
            <label for="image">Image</label>
            <input type="text" 
            id="item_image" 
            class="form-control <?php echo isset($errors['item_image']) ? 'is-invalid' : ''; ?>" 
            name="item_image" 
            value="<?php echo isset($_POST['item_image']) ? $_POST['item_image'] : $item_image; ?>" 
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_image']) ? $errors['item_image'] : ''; ?>
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
                <a class="btn btn-dark" href="../public/index.php">Cancel</a>
            </div>
            
        </form>
    </div>

    <?php include '../partials/footer.php'; ?>

    </body>
</html>
