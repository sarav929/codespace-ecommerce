<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MKTIME</title>
    <link rel="stylesheet" href="../assets/style/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>

    <?php include '../includes/nav.php'; 

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
        if (empty($_POST['item_desc'])) {
            $errors['item_desc'] = 'Enter the item description.';
        } else {
            $descr = mysqli_real_escape_string($link, trim($_POST['item_desc']));
        }

        # image: 
        if (empty($_POST['item_img'])) {
            $errors['item_img'] = 'Enter the item image.';
        } else {
            $img = mysqli_real_escape_string($link, trim($_POST['item_img']));
        }

        # price: 
        if (empty($_POST['item_price'])) {
            $errors['item_price'] = 'Enter the item price.';
        } else {
            $price = mysqli_real_escape_string($link, trim($_POST['item_price']));
        }

        # brand: 
        if (empty($_POST['item_brand'])) {
            $errors['item_brand'] = 'Enter the item brand.';
        } else {
            $brand = mysqli_real_escape_string($link, trim($_POST['item_brand']));
        }

        # notes: 
        if (empty($_POST['item_notes'])) {
            $errors['item_notes'] = 'Enter the item notes (separated by commas).';
        } else {
            $notes = mysqli_real_escape_string($link, trim($_POST['item_notes']));
        }

        # type: 
        if (empty($_POST['item_type'])) {
            $errors['item_type'] = 'Enter the item type (if multiple, separated by commas).';
        } else {
            $type = mysqli_real_escape_string($link, trim($_POST['item_type']));
        }

        # ml: 
        if (empty($_POST['item_ml'])) {
            $errors['item_ml'] = 'Enter the item capacity in ml.';
        } else {
            $ml = mysqli_real_escape_string($link, trim($_POST['item_ml']));
        }

        # 4. if connection to db is successful: insert data into the table
        if (empty($errors)) {
            $q = "INSERT INTO products (item_name, item_desc, item_img, item_price, item_brand, item_notes, item_type, item_ml)
            VALUES ('$name', '$descr', '$img', '$price', '$brand', '$notes', '$type', '$ml')";

            $r = @mysqli_query($link, $q);
            if ($r) {
            # redirect to the read.php page
            header("Location: ../public/admin_page.php");
            exit();
            }

            # and close the connection
            mysqli_close($link);
        }
    } 

    ?>

    <div class="container">
        <h1 class="text-center mt-4 p-3">Add Item</h1>

        <form action="../admin/create.php" method="post" class="needs-validation" novalidate>

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

            <!-- item brand -->
            <label for="brand" class="form-label">Item brand</label>
            <input type="text" 
            id="item_brand" 
            class="form-control <?php echo isset($errors['item_brand']) ? 'is-invalid' : ''; ?>" 
            name="item_brand" value="<?php echo isset($_POST['item_brand']) ? $_POST['item_brand'] : ''; ?>" 
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_brand']) ? $errors['item_brand'] : ''; ?>
            </div>

            <!-- item type -->
            <label for="type" class="form-label">Item type</label>
            <input type="text" 
            id="item_type" 
            class="form-control <?php echo isset($errors['item_type']) ? 'is-invalid' : ''; ?>" 
            name="item_type" value="<?php echo isset($_POST['item_type']) ? $_POST['item_type'] : ''; ?>" 
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_type']) ? $errors['item_type'] : ''; ?>
            </div>

            <!-- item notes -->
            <label for="notes" class="form-label">Item notes</label>
            <input type="text" 
            id="item_notes" 
            class="form-control <?php echo isset($errors['item_notes']) ? 'is-invalid' : ''; ?>" 
            name="item_notes" value="<?php echo isset($_POST['item_notes']) ? $_POST['item_notes'] : ''; ?>" 
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_notes']) ? $errors['item_notes'] : ''; ?>
            </div>

            <!-- item description -->
            <label for="description" class="form-label">Description</label>
            <textarea id="item_desc" 
            class="form-control <?php echo isset($errors['item_desc']) ? 'is-invalid' : ''; ?>"
            name="item_desc" required></textarea>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_desc']) ? $errors['item_desc'] : ''; ?>
            </div>

            <!-- item image -->
            <label for="img" class="form-label">Image</label>
            <input type="text" 
            id="item_img" 
            class="form-control <?php echo isset($errors['item_img']) ? 'is-invalid' : ''; ?>" 
            name="item_img" value="<?php echo isset($_POST['item_img']) ? $_POST['item_img'] : ''; ?>" 
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
            value="<?php echo isset($_POST['item_price']) ? $_POST['item_price'] : ''; ?>" 
            required>
            
            <div class="invalid-feedback">
                <?php echo isset($errors['item_price']) ? $errors['item_price'] : ''; ?>
            </div>            
            
            <!-- item ml -->
            <label for="ml" class="form-label">Item capacity (ml)</label>
            <input type="number" 
            id="item_ml" 
            class="form-control <?php echo isset($errors['item_ml']) ? 'is-invalid' : ''; ?>" 
            name="item_ml" value="<?php echo isset($_POST['item_ml']) ? $_POST['item_ml'] : ''; ?>" 
            required>

            <div class="invalid-feedback">
                <?php echo isset($errors['item_ml']) ? $errors['item_ml'] : ''; ?>
            </div>



            <!-- submit button -->
            <div class="text-center m-3">
                <input type="submit" class="btn btn-dark m-1" value="Add">
                <a class="btn btn-dark" href="../public/admin_page.php">Cancel</a>
            </div>
        </form>
    </div>

    <?php #include '../includes/footer.php'; ?> 

</body>
</html>
