<?php

    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name'])){
        //1. Get ID and Image Name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Remove the Image if Available
        //Check whether the image is available or not and delete only if available
        if($image_name != "") {
            //it has image and need to remove from folder
            //Get the image path
            $path = "../images/food/" . $image_name;
            //Remove image file from folder 
            $remove = unlink($path);

            //check whether the image is removed or not
            if($remove == false) {
                //Failed to Remove image
                $_SESSION['upload'] = '<div class="error">Failed to Remove Image File.</div>';
                //Rediract to Manage Food
                header('location: ' .SITEURL. 'admin/manage-food.php');
                //Stop the process of deleting food
                die();//لا نريد حذف الصورة من الداتا بيز
            }
        }

        //3. Delete Food from Database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check Whether the query executed or not and set the session message respectively
        //4. Redirect to Manage food with Session Message
        if($res) {
            //Food Deleted
            $_SESSION['delete'] = '<div class="succsess">Food Deleted Successfully.</div>';
            header('location: ' . SITEURL . 'admin/manage-food.php');
        } else {
             //Failed to Deleted Food
             $_SESSION['delete'] = '<div class="error">Failed to Deleted Food. </div>';
             header('location: ' . SITEURL . 'admin/manage-food.php');

        }

        




    } else {
        //Redirect to Manage Food Page
        $_SESSION['unauthorize'] = '<div class="error">Unauthorized Access. </div>';
        header('location: ' . SITEURL . 'admin/manage-food.php');
    }
?>