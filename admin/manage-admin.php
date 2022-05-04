<?php include('partials/menu.php') ?>

    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Admain</h1>

            <br />
            <?php
                if (isset($_SESSION['add'])) {

                    // Displaying the session Massage
                    echo $_SESSION['add'];

                    //Removing the session Massage
                    unset($_SESSION['add']);
                } 

                if (isset($_SESSION['delete'])) {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if (isset($_SESSION['updata'])) {
                    echo $_SESSION['updata'];
                    unset($_SESSION['updata']);
                }
                
                if (isset($_SESSION['user-not-found'])) {
                    echo $_SESSION['user-not-found'];
                    unset($_SESSION['user-not-found']);
                }

                if (isset($_SESSION['pwd-not-match'])) {
                    echo $_SESSION['pwd-not-match'];
                    unset($_SESSION['pwd-not-match']);
                }

                if (isset($_SESSION['change-pwd'])) {
                    echo $_SESSION['change-pwd'];
                    unset($_SESSION['change-pwd']);
                }
            
            ?>
            <br /><br /><br />
            <!-- Button to Add Admain -->
            <a href="add-admin.php" class="btn-primary">Add Admain</a>
            <br /><br /><br />

            <table class = "tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Actions</th>
                </tr>

                <?php 
                    //Query to Get All Admin
                    $sql = "SELECT * FROM tbl_admin";
                    //Execute the Query 
                    $res = mysqli_query($conn, $sql);

                    //Check Whether the Query is Excuted of Not
                    
                    if ($res) {
                        //Count Rows to Check whether We data in DataBase or not
                        $count = mysqli_num_rows($res);// Function to Get All rows in Database
                        $sn = 1; // Create a Variable and Assign the Value
                        // Check the num of rows 
                        if ($count > 0) {
                            //We Have data in Database

                            while ($rows = mysqli_fetch_assoc($res)) {
                                //Using while Loop to get All the data from DataBase.
                                //And while Loop will run as long as we have data in Database

                                //Get individual Data
                                $id        = $rows['id'];
                                $full_name = $rows['full_name'];
                                $username  = $rows['username'];

                                //Display the values in oue Table
                                ?>
                                <tr>
                                    <td><?php echo $sn++; ?>.</td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/updata-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                        <a href="<?php echo SITEURL; ?>admin/updata-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Updata Admain</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admain</a>
                                    </td>
                                </tr>

                    <?php
                            }
                        } else {
                            //We do not Have data in Database

                        }
                    }
                ?>
  
            </table>            
        </div>
    </div>
    <!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>