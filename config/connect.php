<?php

# Connect to the 'mktime' database

$link = mysqli_connect('localhost', 'root', '', 'mktime');

if (!$link) {
    die('Could not connect to database: ' . mysqli_connect_error()); 
}

?>
