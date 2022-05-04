<?php include("partials/menu.php"); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br /><br />
        <?php 
            if(isset($_GET['id'])) {
                //1. Get the ID of Selected Admin
                $id = $_GET['id'];
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">

                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password" >               
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password" >
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" >
                    </td>
                </tr>

                <tr>
                    <td colspan='2'>
                        <input type="hidden" name = "id" value = "<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>   
</div>
<?php
    //Check whether the Submit Button is Clicked on Not
    if (isset($_POST['submit'])) {
        //1. Get the Data from Form
        $id = $_POST['id'];
        $currentPassword = md5($_POST['current_password']);
        $newPassword     = md5($_POST['new_password']);
        $confirmPassword =  md5($_POST['confirm_password']);

        //2. Check whether the user with current ID and Current Password Exists or Not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$currentPassword'"; 

        // Exceuting Query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //Check whether the (Query is Executed) data  
        if ($res) {

            // Check whether data is available or not
            $count = mysqli_num_rows($res);

            if ($count == 1){
                //User Exists and Password Can be Chenged
                

                //Check whether the New Password and Confirm Password Match or Not
                if ($newPassword == $confirmPassword) {
                    //Update the Password
                    $sql2 = "UPDATE tbl_admin SET
                            password = '$newPassword'
                            WHERE id=$id ";
                    $res2 = mysqli_query($conn, $sql2) or die(mysqli_error());
                    // Check whether the (Query is Executed) data  
                    if ($res2) {

                       //Display success Message
                       //Reirect to  Manage Admin Page with Success Message
                        $_SESSION['change-pwd'] = "<div class='succsess'>Password Changed Successfully. <div>";
                        //Redirect Page to Manage Admin  About to user
                        header("location:" . SITEURL . 'admin/manage-admin.php');

                    } else {
                        //Display Error Message
                        //Reirect to  Manage Admin Page with Error Message
                        $_SESSION['change-pwd'] = "<div class='error'>Failed to Chenge Password. <div>";
                        //Redirect Page to Manage Admin  About to user
                        header("location:" . SITEURL . 'admin/manage-admin.php');
                    }
                            
                } else {
                    //Reirect to  Manage Admin Page with Error Message
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password Did not match. <div>";
                    //Redirect Page to Manage Admin  About to user
                    header("location:" . SITEURL . 'admin/manage-admin.php');
                }
                
            } else {
                //User Does not Exists set Message and Redirect
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found. <div>";
                //Redirect Page to Manage Admin
                header("location:" . SITEURL . 'admin/manage-admin.php');
            }

        }
  
    }
        
        //3. Check whether the New Password and Confirm Password Match or Not

        //4. Change Password if all above is true 
    
?>

<?php include('partials/footer.php'); ?>