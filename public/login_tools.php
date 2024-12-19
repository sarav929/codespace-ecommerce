<?php 

    # 1. Function to load specified or default URL

    function load($page = '../public/login.php') {
        # Begin URL with protocol, domain, and current directory
        $url = 'http://' . $_SERVER[ 'HTTP_HOST' ] . dirname($_SERVER[ 'PHP_SELF' ]);

        # Remove trailing slashes then append page name to URL
        $url = rtrim( $url, '/\\' );
        $url .= '/' . $page;

        # Execute redirect then quit. 
        header( "Location: $url" ); 
        exit();
    }

    # 2. Function to check email address and password
    function validate($link, $email = '', $pwd = '') {

        # Initialize errors array
        $errors = array(); 
    
        # Check email field
        if (empty($email)) { 
            $errors['email'] = 'Enter your email address.'; 
        } else  { 
            $e = mysqli_real_escape_string($link, trim($email)); 
        }
    
        # Check password field
        if (empty($pwd)) { 
            $errors['pwd'] = 'Enter your password.'; 
        } else { 
            $p = trim($pwd); // No need to escape for password_verify
        }

    
        // If there are no validation errors
        if (empty($errors)) {
            // Retrieve user details based on the email
            $q = "SELECT user_id, first_name, last_name, pass FROM users WHERE email='$e'";
            $r = mysqli_query($link, $q);

            if ($r && mysqli_num_rows($r) == 1) {
                $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

                // Verify the password against the hash stored in the database

                if (password_verify($p, $row['pass'])) {
                    // If password is correct, return user details
                    return array(true, $row);
                } else {
                    // If password doesn't match
                    $errors['invalid'] = 'Invalid email or password.';
                }
            } else {
                // If email does not exist
                $errors['invalid'] = 'Invalid email or password.';
            }
        }

        // Return error messages if validation failed
        return array(false, $errors);
    }
    

?>