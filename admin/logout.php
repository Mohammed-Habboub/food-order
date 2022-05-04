<?php
    // include constant.php for SITEURL.
    include('../config/constants.php');
    //1. Destory the Session
    session_destroy();//Unsets $_SESSTON['user']

    //2. Redirect to Login Page
    header('location: ' .SITEURL. 'admin/login.php');

?>
