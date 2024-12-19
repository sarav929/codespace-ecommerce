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
            $p = mysqli_real_escape_string($link, trim($pwd)); 
        }

        # On success retrieve user_id, first_name, and last name from 'users' database
        if (empty($errors)) {
            $q = "SELECT user_id, first_name, last_name FROM users WHERE email='$e' AND pass='$p'";  
            $r = mysqli_query ($link, $q);

            if (@mysqli_num_rows( $r ) == 1) {
                $row = mysqli_fetch_array ( $r, MYSQLI_ASSOC );
                return array( true, $row ); 
            } else { 
                # Or on failure set error message
                $errors['invalid'] = 'Email address and password not found.';            
            }
        }

        # On failure retrieve error message/s
        return array( false, $errors ) ; 
    }

?>