<?php 
    include '../includes/nav.php';

    if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) { 

        # 1. Connect to the database
        require('../config/connect.php');

        # 2. Initialize an error array
        $errors = array();

        # 3. Check for user's info from form

        # first name

        if ( empty($_POST[ 'first_name' ])) { 
            $errors['first_name'] = 'Enter your first name.'; 
        } else { 
            $fn = mysqli_real_escape_string($link, trim($_POST[ 'first_name' ])); 
        }

        # last name

        if ( empty($_POST[ 'last_name' ])) { 
            $errors['last_name'] = 'Enter your last name.'; 
        } else { 
            $ln = mysqli_real_escape_string($link, trim($_POST[ 'last_name' ])); 
        }

        # email

        if ( empty($_POST[ 'email' ])) { 
            $errors['email'] = 'Enter your email address.'; 
        } else { 
            $e = mysqli_real_escape_string($link, trim($_POST[ 'email' ])); 
        }

        # email address (unique)

        if (empty( $errors )) {
            $q = "SELECT user_id FROM users WHERE email='$e'" ;
            $r = @mysqli_query ( $link, $q ) ;

            #if already exists - send to log in
            if ( mysqli_num_rows( $r ) != 0 ) {
                $errors['already_reg'] = 'Email address already registered.
                <a class="alert-link" href="login.php">Sign In</a>';
            } 

        }

        # password and matching

        if ( !empty($_POST[ 'pass1' ] ) ) {
            // check if meets requirements
            if (!preg_match('/^(?=.*[A-Z])(?=.*[\d@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $_POST['pass1'])) {
                $errors['pass_req'] = 'Password must be at least 8 characters long, 
                include at least one uppercase letter and one number or symbol.';
            
                // check if passwords match
            } elseif ( $_POST[ 'pass1' ] != $_POST[ 'pass2' ] ) { 
                $errors['confirm_pass'] = 'Passwords do not match.' ; 

                // if all ok save hashed password
            } else { 
                $p = password_hash(trim($_POST['pass1']), PASSWORD_DEFAULT);
            }

        } else { 
            $errors['pass'] = 'Enter your password.'; 
        }
    

        # 4. if no error - proceed to add user to database
        if (empty( $errors )) {
            $q = "INSERT INTO users (first_name, last_name, email, pass, reg_date) 
            VALUES ('$fn', '$ln', '$e', '$p', NOW() )";
            $r = @mysqli_query ( $link, $q );

            if ($r) {

                // head user to confirmation and log in 
                header('Location: ../public/confirm_reg.php');
            }
                
            # 5. close database connection

            mysqli_close($link); 
            exit();

        } 
        //else {
           //echo '<div class="alert alert-danger text-center m-0">'; // open error div

            // loop through error array and display them
            //foreach ($errors as $error) {
                //echo '<p>' . $error . '</p>';
            //}

            //echo '</div>'; // close error div
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
        crossorigin="anonymous">

    </head>
    <body>
        <div class="container-md p-5">

            <form class="container-md" action="../public/register.php" method="post" novalidate>

                <div class="row m-3">

                    <div class="col">
                        <label for="inputfirst_name">First Name</label>
                        <input type="text" 
                            name="first_name" 
                            class="form-control" 
                            required 
                            placeholder="* First Name " 
                            value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" 
                        >
                        <!-- error -->
                        <?php if (isset($errors['first_name'])): ?>
                        <small class="text-danger"><?php echo $errors['first_name']; ?></small>
                        <?php endif; ?>  

                    </div> 
                    <div class="col">
                        <label for="inputlast_name">Last Name</label>
                        <input type="text" 
                            name="last_name" 
                            class="form-control" 
                            required 
                            placeholder="* Last Name" 
                            value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>"
                        >
                        <!-- error -->
                        <?php if (isset($errors['last_name'])): ?>
                        <small class="text-danger"><?php echo $errors['last_name']; ?></small>
                        <?php endif; ?> 
                    </div>
                </div>

                <div class="row m-3">

                    <div class="col">

                        <label for="inputemail">Email</label>
                        <input type="email" 
                            name="email" 
                            class="form-control" 
                            required 
                            placeholder="* email@example.com" 
                            value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"
                        >
                        <!-- error -->
                        <?php if (isset($errors['email'])): ?>
                        <small class="text-danger"><?php echo $errors['email']; ?></small>
                        <?php endif; ?> 
                        <!-- error -->
                        <?php if (isset($errors['already_reg'])): ?>
                        <small class="text-danger"><?php echo $errors['already_reg']; ?></small>
                        <?php endif; ?> 

                    </div>
                </div>
                
                <div class="row m-3">
                    <div class="col">
                        <label for="inputpass1">Create New Password</label>
                        <input type="password"
                            name="pass1" 
                            class="form-control" 
                            required 
                            placeholder="* Create New Password" 
                            value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"
                        >
                        <!-- error -->
                        <?php if (isset($errors['pass'])): ?>
                        <small class="text-danger"><?php echo $errors['pass']; ?></small>
                        <?php endif; ?> 
                        <!-- error -->
                        <?php if (isset($errors['pass_req'])): ?>
                        <small class="text-danger"><?php echo $errors['pass_req']; ?></small>
                        <?php endif; ?> 
                    </div>
                    <div class="col">                                  
                        <label for="inputpass2">Confirm Password</label>
                        <input type="password" 
                            name="pass2" 
                            class="form-control" 
                            required 
                            placeholder="* Confirm Password" 
                            value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"
                        >
                        <!-- error -->
                        <?php if (isset($errors['confirm_pass'])): ?>
                        <small class="text-danger"><?php echo $errors['confirm_pass']; ?></small>
                        <?php endif; ?> 
                    </div>
                </div> 
                      
                <div class="row pt-5 d-flex justify-content-center">
                    <input type="submit" value="Create Account">
                </div>

            </form>
        </div>

        <?php include '../includes/footer.php'; ?>
        
    </body>
</html>