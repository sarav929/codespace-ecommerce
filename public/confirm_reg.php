


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

        // confirmation of registration

        echo '<div class="container-md p-5 text-center">
                <p>Thank you! You are now registered.</p> 
                <a class="alert-link" href="../public/login.php">Login</a>
            </div>';

        include '../includes/footer.php';

        ?>
        
    </body>
</html>