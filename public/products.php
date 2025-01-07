<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MKTIME</title>
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

        # Access session.
        session_start();

        # Redirect if not logged in.
        if (!isset( $_SESSION[ 'user_id' ])) { 
            require ( 'login_tools.php' ); 
            load(); 
        }

        echo '<h1 class="text-center m-5"> Product page </h1>';

        include '../includes/footer.php';
    ?>
    
</body>
</html>