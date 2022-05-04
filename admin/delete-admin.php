<?php 

    //Include Constant.php File Here
    include('../config/constants.php');
    //1. Get the ID of Admin to be deleted 
    $id = $_GET['id'];
    
    //2. Creat SQL Query to Delet Admin
    $sql = "DELETE FROM tbl_admin WHERE id = $id";
    //Executed the Query 
    $res = mysqli_query($conn, $sql);
    //Chek whether the Query  Executed successfully or Not
    if ($res) {
        //The Query  Executed successfully and Admin Delete
        //Creat Session Variable to Display Massege
        $_SESSION['delete'] = "<div class='succsess'>Admin Deleted Successfully. </div>";

        //Redirect to Manage Admin page
        header("location:" . SITEURL . 'admin/manage-admin.php');

    } else {
        //Failed to Delete Admin
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try again Later.</div>";
        header('location:' . SITEURL . 'admin/manage-admin.php');
    } 


    //3. Redirect to Manage Admin page with Message (success/error)

?>