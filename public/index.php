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

    <?php include '../includes/nav.php' ?>
    <div class="d-flex justify-content-center text-center mb-5"> 
        <div class="ard bg-dark text-white" style="position: relative; height: 50vh; width: 100vw;">
            <img class="card-img" src="../assets/img/header.jpg" style="object-fit: cover; height: 100%; width: 100%; opacity: 70%;" alt="Card image">
            <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center text-center">
                <h1 class="card-title display-4 mb-3">Nocturne Scents</h1>
                <h5 class="card-subtitle mb-5 font-italic font-weight-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h5>
                <a href="../public/session_cart.php" class="btn btn-light btn-lg">Explore</a>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column justify-content-center text-center m-auto">
        <h3 class="mb-5">About</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> 
        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> 
        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
        <br>
        <p class="mb-5">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>

    <?php include '../includes/footer.php' ?>
    
</body>
</html>