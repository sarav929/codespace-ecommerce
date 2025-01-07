<?php include '../partials/nav.php'; 

# Logic for create item form submission 

# 1. connect to database 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('../config/connect.php');

    # 2. initialize error array
    $errors = array();

    # 3. check all fields 

    # name: 
    if (empty($_POST['item_name'])) {
        $errors['item_name'] = 'Enter the item name.';
    } else {
        $name = mysqli_real_escape_string($link, trim($_POST['item_name']));
    }

    # description: 
    if (empty($_POST['item_description'])) {
        $errors['item_description'] = 'Enter the item description.';
    } else {
        $descr = mysqli_real_escape_string($link, trim($_POST['item_description']));
    }

    # image: 
    if (empty($_POST['item_image'])) {
        $errors['item_image'] = 'Enter the item image.';
    } else {
        $img = mysqli_real_escape_string($link, trim($_POST['item_image']));
    }

    # price: 
    if (empty($_POST['item_price'])) {
        $errors['item_price'] = 'Enter the item price.';
    } else {
        $price = mysqli_real_escape_string($link, trim($_POST['item_price']));
    }

    # 4. if connection to db is successful: insert data into the table
    if (empty($errors)) {
        $q = "INSERT INTO products (item_name, item_description, item_image, item_price)
        VALUES ('$name', '$descr', '$img', '$price')";

        $r = @mysqli_query($link, $q);
        if ($r) {
           # redirect to the read.php page
           header("Location: ../public/index.php");
           exit();
        }

        # and close the connection
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

<div class="container">
    <h1 class="text-center mt-4 p-3">Add Item</h1>

    <form action="../controllers/create.php" method="post" class="needs-validation" novalidate>

        <!-- item name -->
        <label for="name" class="form-label">Item name</label>
        <input type="text" 
        id="item_name" 
        class="form-control <?php echo isset($errors['item_name']) ? 'is-invalid' : ''; ?>" 
        name="item_name" value="<?php echo isset($_POST['item_name']) ? $_POST['item_name'] : ''; ?>" 
        required>

        <div class="invalid-feedback">
            <?php echo isset($errors['item_name']) ? $errors['item_name'] : ''; ?>
        </div>

        <!-- item description -->
        <label for="description" class="form-label">Description</label>
        <textarea id="item_description" 
        class="form-control <?php echo isset($errors['item_description']) ? 'is-invalid' : ''; ?>"
        name="item_description" required></textarea>

        <div class="invalid-feedback">
            <?php echo isset($errors['item_description']) ? $errors['item_description'] : ''; ?>
        </div>

        <!-- item image -->
        <label for="image" class="form-label">Image</label>
        <input type="text" 
        id="item_image" 
        class="form-control <?php echo isset($errors['item_image']) ? 'is-invalid' : ''; ?>" 
        name="item_image" value="<?php echo isset($_POST['item_image']) ? $_POST['item_image'] : ''; ?>" 
        required>

        <div class="invalid-feedback">
            <?php echo isset($errors['item_image']) ? $errors['item_image'] : ''; ?>
        </div>

        <!-- item price -->
        <label for="price" class="form-label">Price</label>
        <input type="number" 
        id="item_price" 
        class="form-control <?php echo isset($errors['item_price']) ? 'is-invalid' : ''; ?>" 
        name="item_price" min="0" step="0.01" 
        value="<?php echo isset($_POST['item_price']) ? $_POST['item_price'] : ''; ?>" 
        required>
        
        <div class="invalid-feedback">
            <?php echo isset($errors['item_price']) ? $errors['item_price'] : ''; ?>
        </div>

        <!-- submit button -->
        <div class="d-flex justify-content-center mt-4 p-3">
            <input type="submit" class="btn btn-dark" value="Add">
        </div>
    </form>
</div>

<?php include '../partials/footer.php'; ?>

</body>
</html>
