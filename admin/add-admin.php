<?php include("partials/menu.php") ?>


    <div class="main-cotact">
        <div class="wrapper">
            <h1>Add Admin</h1>

            <br /><br />

            <?php
                if (isset($_SESSION['add'])) {
                    //Checing wether the Session is Set of Not

                    //Display the Session Massage if Set
                    echo $_SESSION['add'];
                    //Remove the session
                    unset($_SESSION['add']);
                }
               
               
            
            ?>
            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Full name: </td>
                        <td>
                            <input type="text" name="full_name" placeholder="Enter Your Full Name">
                        </td>
                    </tr>

                    <tr> 
                        <td>Username: </td>
                        <td>
                            <input type="text" name="username" placeholder="Enter Your Uasername">
                        </td>
                    </tr>

                    <tr>
                        <td>Password: </td>
                        <td>
                            <input type="password" name="password" placeholder="Enter Your password">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add admin" class="btn-secondary">
                        </td>
                    </tr>

                </table>
            </form>
        </div>

    </div>

<?php include("partials/footer.php") ?>

<?php 
    // Process the value from Form and save it in Database
    //1. Check whether the submit button is clicked or not
   
    if(isset($_POST['submit'])) {
        // Button Cliked
        
        $full_name = $_POST['full_name'];
        $username  = $_POST['username'];
        $password  =md5($_POST['password']);

        //2. SQL Query to Save the data into database
        $sql = "INSERT INTO tbl_admin SET 
            full_name = '$full_name',
            username  = '$username',  
            password  = '$password' 
        ";
        
    }
        // 3. Exceuting Query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());
  
       
    
       //4. Check whether the (Query is Executed) data is inserted or Not display appropriate message
       if ($res) {

           // Creat the a session Variable to Display Message
           $_SESSION['add'] = "<div class='succsess'>Admin Added Successfully. </div>";
           //Redirect Page to Manage Admin
           header("location:" . SITEURL . 'admin/manage-admin.php');

       } else {

          // Creat the a session Variable to Display Message
          $_SESSION['add'] = "Failed  to Add Admin";
          //Redirect Page to Add Admin
          header("location:" . SITEURL . 'admin/add-admin.php');
       }



?>