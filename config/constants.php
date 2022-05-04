<?php
    // Start session
    session_start();
    
    // Create Constans to Stor Non repeating values
    define('SITEURL', 'http://localhost:82/food-order/');
    define('LOCALHOST', 'localhost:3309');
    define('DB_USERNAME','root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-order');
    
    // Database Connection 
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
    //Selecting Database
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

?>