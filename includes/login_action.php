<?php 
    if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) { 

        # 1. Connect to the database
        require('../config/connect.php');

        # 2. require functions for validation
        require ('./login_tools.php');

        $errors = array();

        list ($check, $data) = validate($link, $_POST[ 'email' ], $_POST[ 'pass' ]);

        # if validation is successful register data into session
        if ( $check ) {
            session_start();
            $_SESSION[ 'user_id' ] = $data[ 'user_id' ];
            $_SESSION[ 'first_name' ] = $data[ 'first_name' ];
            $_SESSION[ 'last_name' ] = $data[ 'last_name' ];
            load( '../public/index.php' );

        # else store errors in array
        } else { 
            $errors = $data; 
        }

        # 3. close connetion to db
        mysqli_close( $link );

        # display log in form
        include ( '../public/login.php' ) ;
    }
?>