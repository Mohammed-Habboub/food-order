<?php include("partials/menu.php"); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Updata Admin</h1>
        <br /><br />
        <?php 
        
            //1. Get the ID of Selected Admin
            $id = $_GET['id'];

            //2. Creat SQL Query to Get the Details
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";
            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //Chek whether the Query Executed successfully or Not
            if ($res) {
                //Check whether the data is available or not
                $count = mysqli_num_rows($res);
                //Check whether we have admin data or not
                if ($count == 1) {
                    //Get the Details
                    $row = mysqli_fetch_assoc($res);
                    $fullName = $row['full_name'];
                    $username = $row['username'];
                } else {

                    //Redirect to Manage Admin page
                    header("location:" . SITEURL . 'admin/manage-admin.php');

                }
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">

                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $fullName; ?>" >               
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan='2'>
                        <input type="hidden" name = "id" value = "<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Updata Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>   
</div>
<?php 
    //Check Whether the Submit Button is Clicked or not 
    if(isset($_POST['submit'])) {
        //Get All the Value from form to Updata
        echo $id       = $_POST['id'];
        echo $fullName = $_POST['full_name'];
        echo $username = $_POST['username'];

        // Creat a SQL Query to Get the Details
        $sql = "UPDATE tbl_admin SET 
            full_name = '$fullName',
            username  = '$username'      
            WHERE id='$id'
            ";

        //Execute the Query
        $res = mysqli_query($conn, $sql);
        
        //Check The Query Executed successfully or Not
        if ($res) {
            //The Query  Executed successfully and Admin Updata
            //Creat Session Variable to Display Massege
            $_SESSION['updata'] = "<div class='succsess'>Admin Updata Successfully. </div>";

            //Redirect to Manage Admin page
            header("location:" . SITEURL . 'admin/manage-admin.php');

        } else {
            //Failed to Updata Admin
            $_SESSION['updata'] = "<div class='error'>Failed to Updata Admin. Try again Later.</div>";
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }  
    }       

?>
<?php include('partials/footer.php'); ?>