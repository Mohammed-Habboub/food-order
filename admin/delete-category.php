<?php 
    include("../config/constants.php");
    

    //Check whether the id and image_name Value is set or not
    if(isset($_GET['id'])) {
        
        //Get the Value and Delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file is available
        if($image_name != "") {
            //Image is Available. So remove it
            $path = "../images/category/" . $image_name;
            //Remove the Image
            $remove = unlink($path);

            //If failed to remove image then add an error message and stop the process
            if($remove == false) {
                //Set the Session Message
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
                //Rediret to Message Category page
                header('location: ' . SITEURL . 'admin/manage-category.php');
                //Stop the Process
                die();
            }
        }

        //Delete Data from Database
        //SQL Query to Delete Data from Database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

            //check whether the data is delete from database or not
            if($res) {
                $_SESSION['delete'] = '<div class="succsess">Category Deleted Sucessfully.</div>';
                header('location: ' . SITEURL . 'admin/manage-category.php');

            } else {
                $_SESSION['delete'] = '<div class="error">Category Failed to Deleted Category.</div>';
                header('location: ' . SITEURL . 'admin/manage-category.php');
            }
    } else {
       header('location: ' . SITEURL . 'admin/manage-category.php');
    }
?>