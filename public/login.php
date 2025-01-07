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

            # Display error messages at the top if credentials are invalid
            if (isset($errors['invalid'])) {
                echo '<div class="alert alert-danger text-center">
                <p>Oops! There was a problem:<br>' . $errors['invalid'] . '</p>
                <p>Please try again or <a href="../public/register.php">Register</a></p>
                </div>';

            }

        ?>

        <div class="container-md p-5">
        <form class="container-md" action="../public/login_action.php" method="post" novalidate>

        <div class="row m-3">
            <label for="inputemail">Email</label>
            <input type="text" 
                name="email" 
                class="form-control" 
                required 
                placeholder="* Enter Email"
            >
            <!-- error -->
            <?php if (isset($errors['email'])): ?>
                <small class="text-danger"><?php echo $errors['email']; ?></small>
            <?php endif; ?> 
        </div> 

        <div class="row m-3">
            <label for="inputemail">Password</label>
            <input type="password" 
                name="pass"  
                class="form-control" 
                required 
                placeholder="* Enter Password"
            >
            <!-- error -->
            <?php if (isset($errors['pwd'])): ?>
                <small class="text-danger"><?php echo $errors['pwd']; ?></small>
            <?php endif; ?> 
            
        </div>

        <div class="row pt-5 d-flex justify-content-center">
            <input type="submit" value="Log in">
        </div>

    </form>
    </div>

    <?php include '../includes/footer.php'; ?>

        
    </body>
</html>