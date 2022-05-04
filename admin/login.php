<?php include('../config/constants.php') ?>

<html>
<head>
    
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
    <body>   
        <div class="login">
            <br><br>
            <h1 class="text-center">Login</h1>
            <br><br>
            <?php 
                if (isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if (isset($_SESSION['no-login-message'])) {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
                
            ?>
            <br><br>
            <!-- Login Form Starts Here -->           
            <form action="" method="POST" class="text-center">
            Username: <br />
            <input type="text" name="username" placeholder="Enter Username"><br /><br />
            Password: <br />
            <input type="password" name="password" placeholder="Enter Password"><br /><br />
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
            </form>
            <!-- Login Form Ends Here -->
            <p class="text-center">Created By - <a href="https://www.facebook.com/profile.php?id=100010190101364">Mohammed Habboub</a></p>
        </div>
    </body>
</html>
<?php 
    //Check Whether The Submit Button Is Clicked Or Not
    if (isset($_POST['submit'])) {
        //Process For Login.
        //1. Get The Data From Login Form.
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        //2. SQL To Check Whether user With username and password Exists or Not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Execute The Query
        $res = mysqli_query($conn, $sql);

        //4. Count Rows To Check Whether The User Exists Or Not
        $count = mysqli_num_rows($res);
        
        if ($count == 1) {
            //User AVailable and Login Success
            $_SESSION['login'] = "<div class='succsess'>Login Successful.<div>";
            $_SESSION['user'] = $username;//To Check  Whether the user is logged in or not and logout unset it
            //Redirect to Home Page/Dashboard
            header('location:' . SITEURL . 'admin/');
        } else {
            //User not Available and Login Fail
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not metch.<div>";
            //Redirect to Home Page/Dashboard
            header('location:' . SITEURL . 'admin/login.php');
        }
    }

    

?>