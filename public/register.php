<?php 
    include '../includes/nav.php';

    $showModal = false; // Flag to determine whether to show the modal

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

        # 1. Connect to the database
        require('../config/connect.php');

        # 2. Initialize an error array
        $errors = array();

        # 3. Check for user's info from form

        # First name
        if (empty($_POST['first_name'])) { 
            $errors['first_name'] = 'Enter your first name.'; 
        } else { 
            $fn = mysqli_real_escape_string($link, trim($_POST['first_name'])); 
        }

        # Last name
        if (empty($_POST['last_name'])) { 
            $errors['last_name'] = 'Enter your last name.'; 
        } else { 
            $ln = mysqli_real_escape_string($link, trim($_POST['last_name'])); 
        }

        # Email
        if (empty($_POST['email'])) { 
            $errors['email'] = 'Enter your email address.'; 
        } else { 
            $e = mysqli_real_escape_string($link, trim($_POST['email'])); 
        }

        # Check for duplicate email
        if (empty($errors)) {
            $q = "SELECT user_id FROM users WHERE email='$e'" ;
            $r = @mysqli_query($link, $q);

            if (mysqli_num_rows($r) != 0) {
                $errors['already_reg'] = 'Email address already registered.
                <a class="alert-link" href="login.php">Sign In</a>';
            } 
        }

        # Password validation
        if (!empty($_POST['pass1'])) {
            if (!preg_match('/^(?=.*[A-Z])(?=.*[\d@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $_POST['pass1'])) {
                $errors['pass_req'] = 'Password must be at least 8 characters long, 
                include at least one uppercase letter and one number or symbol.';
            } elseif ($_POST['pass1'] != $_POST['pass2']) { 
                $errors['confirm_pass'] = 'Passwords do not match.'; 
            } else { 
                $p = password_hash(trim($_POST['pass1']), PASSWORD_DEFAULT);
            }
        } else { 
            $errors['pass'] = 'Enter your password.'; 
        }

        # 4. Add user to database if no errors
        if (empty($errors)) {
            $q = "INSERT INTO users (first_name, last_name, email, pass, reg_date) 
            VALUES ('$fn', '$ln', '$e', '$p', NOW())";
            $r = @mysqli_query($link, $q);

            if ($r) {
                $showModal = true; // Set the modal flag to true
            }

            # Close database connection
            mysqli_close($link);
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link rel="stylesheet" href="../assets/style/style.css">

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

        <!-- Registration Modal -->
        <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registrationModalLabel">Registration Successful</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Thank you! Your account has been successfully created.
                    </div>
                    <div class="modal-footer">
                        <a href="login.php" class="btn btn-dark">Login</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Bootstrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc7ZnU98DhvFLEj2vmN9GkfjF5Dxv1fjtN8faBIo9" 
        crossorigin="anonymous"></script>

        <!-- Show modal if registration is successful php logic -->
        <?php if ($showModal): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var registrationModal = new bootstrap.Modal(document.getElementById("registrationModal"));
                registrationModal.show();
            });
        </script>
        <?php endif; ?>

        <?php include '../includes/footer.php'; ?>
        
    </body>
</html>