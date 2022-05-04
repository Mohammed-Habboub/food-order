<?php
    //Authorization - Access Control
    //Check Whether the user is logged in or not
    if(!isset($_SESSION['user'])) //If user session is not set
    {
        //User is not logged in
        //Redirct to login page with message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel.</div>";
        header('location: ' . SITEURL . 'admin/login.php');
    }

?>