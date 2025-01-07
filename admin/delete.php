<?php 

# Logic to delete item from db 

# 1. connect to database 

require ('../config/connect.php');

# 2. validate item id 

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($link, $_GET['id']);

    # 3. run SQL query and delete where id matches 

    $q = "DELETE FROM products WHERE item_id = '$id'";
    if ($link->query($q) === true) {
        header("Location: ../public/index.php");
        exit();
    } else {
        echo "Error deleting the item: " . $link->error;
    }
} 

?>
