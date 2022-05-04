<?php include('partials/menu.php')?>

    <div class="main-contect">
        <div class="wrapper">
        <h1>Updata Category</h1>
        <br><br>
        <?php
            if(isset($_GET['id'])) {
                //Get the id and all details
                $id = $_GET['id'];
                //create SQL Query to get all other details
                $sql ="SELECT * FROM tbl_category WHERE id=$id";
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);
                if($count == 1){
                    //Get all the date
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                } else {
                    $_SESSION['no-category-found'] = '<div class="error">Category not Found. </div>';
                    //redirect to manage category
                    header('locatin: '. SITEURL .'admin/manage-category.php');
                }
            } else {
                //redirect to manage category
                header('locatin: '.SITEURL.'admin/manage-category.php');
            }
        
        ?>
 
        <br /><br />
        <!-- Add Category Form Starts -->
        <form action="" method= "POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

               

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                            if($current_image != "") {
                                //Display the image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="50px">
                                <?php

                            } else {
                                //Message Error
                                echo '<div class="error">Image Not Added. </div>';
                            }
                        
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                    
                </tr>

                <tr>
                    
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured == "Yes"){ echo "checked"; } ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured == "No"){ echo "checked"; } ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active== "Yes"){ echo "checked"; } ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active == "No"){ echo "checked"; } ?> type="radio" name="active" value="No"> No

                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="updata Category" class="btn-secondary">
                    </td>
                </tr>
                    
                
            </table>
        </form>
        <!-- Add Category Form Ends -->

        <?php
            if(isset($_POST['submit'])) {
                
                //1. Get The Value From Category Form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2.Updating New Image if selected
                //check whether the image is selected or not
                if(isset($_FILES['image']['name'])) {
                    //Get the image Details
                    $imageName = $_FILES['image']['name'];

                    //check whether the image is available or not
                    if($image_name != "" ){
                        //Image Available 
                        //A. upload the new image

                        //Auto Rename our Image 
                        //Get the Extension of our image (jpg, png, gif, etc) e.g."specialfood1,jpg"
                        $ext = end(explode('.', $imageName));
                        //Rename the image
                        $imageName = "Food_Category_" . rand(000, 999) . '.' . $ext;//e.g. Food_Category_845.jpg
                    
                        $sourcePath      = $_FILES['image']['tmp_name'];
                        $destinationPath = '../images/category/' . $imageName;

                        //Finally Upload the Image
                        $upload = move_uploaded_file($sourcePath, $destinationPath);

                        //check whether the inage is uploaded or not
                        //And if the image is not Uploaded then we will stop the proccess and redirect with error message
                        if ($upload == false) {
                            //set message 
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image </div>";
                            //Redirect to manage Category Page
                            header('location: ' . $SITEURL . 'admin/manage-category.php');
                            //Stop  the proccess
                            die();

                        }
                        //B. Remove the current image
                        if($current_image != "") {
                            $path = "../images/category/" . $current_image;
                            //Remove the Image
                            $remove = unlink($path);
    
                            
                            //check whether the image is removed or not
                            //If failed to remove image then add an error message and stop the process
                            if($remove == false) {
                                //Set the Session Message
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove current Image.</div>";
                                //Rediret to Message Category page
                                header('location: ' . SITEURL . 'admin/manage-category.php');
                                //Stop the Process
                                die();
                            }
                    
                        }
                



                    } else {
                        $image_name = $current_image;
                    }
                } else {
                    $image_name = $current_image;
                }

                //3.Updating the Database
                $sql2 = "UPDATE tbl_category SET 
                    title = '$title',
                    image_name = '$imageName',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                $res2 = mysqli_query($conn, $sql2);

                //4.Redirect to Manage Category Message
                if($res2) {
                    //Category Updated
                    $_SESSION['update'] = '<div class="succsess">Updated Successfully</div>';
                    header('location: '.SITEURL.'admin/manage-category.php');
                } else {
                    $_SESSION['update'] = '<div class="error">Failed to Update category.</div>';
                    header('location: '.SITEURL.'admin/manage-category.php');
                }


            }
        ?>
        </div>
       
    </div>


<?php include('partials/footer.php')?>