<?php include("partials/menu.php") ?>
<?php

    //Check Whether id is set or not
    if(isset($_GET['id'])) {
        //Get all the details 
        $id = $_GET['id'];

        //SQL Query to Get the Selected Food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

        //Execute the Query 
        $res2 = mysqli_query($conn, $sql2);

        //Get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //Get the Individual Values of Selected Food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    } else {
        //Redirect to Manage Food
        header('location: '.SITEURL.'admin/manage-food.php');
    }
?>



    <div class="main-cotact">
        <div class="wrapper">
            <h1>Update Food</h1>
            <br /><br />

             <?php 
                if(isset($_SESSION['upload'])) {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            
            ?>

            <?php
                if (isset($_SESSION['add'])) {
                    //Checing wether the Session is Set of Not

                    //Display the Session Massage if Set
                    echo $_SESSION['add'];
                    //Remove the session
                    unset($_SESSION['add']);
                }
               
               
            
            ?> 
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" value = "<?php echo $title; ?>">
                        </td>
                    </tr>

                    <tr> 
                        <td>Description: </td>
                        <td>
                            <textarea name="description"  cols="30" rows="5" value = "<?php echo $description; ?>"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price" value = "<?php echo $price; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>current image: </td>
                        <td>
                            <?php 
                                if($current_image == ""){
                                //Image not Available 
                                echo '<div class="error">Image not Available. </div>';
                                } else {
                                    //Image Available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width = "150ox" >
                                    <?php 
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Select New Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        
                        <td>Category: </td>
                        <td>
                            <select name="category">
                                <?php 
                                    //Creat PHP Code to Display categories from Database
                                    //1. Create SQL to get all active Categories from database
                                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                    //Executing Query 
                                    $res = mysqli_query($conn, $sql);

                                    //Count Rows to Check whether we have categories or not
                                    $count = mysqli_num_rows($res);

                                    //IF count is greater than zero, we have categories else we donot hane categories
                                    if($count>0) {
                                        //We have caregories
                                        while ($row=mysqli_fetch_assoc($res)) {
                                            //Get the details of categories
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            ?>
                                                <option <?php if($current_category==$id){echo "selected"; }?> value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                            <?php
                                            
                                        }
                                    } else {
                                        //We do not have category
                                        ?>
                                        <option value="0">No Category Found</option>
                                        <?php

                                    }

                                    //2. Display on Drpopdown

                                
                                
                                ?>
                            </select>
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
                        <input <?php if($active== "No"){ echo "checked"; } ?> type="radio" name="active" value="No"> No

                    </td>
                </tr>


                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="update Food" class="btn-secondary">
                        </td>
                    </tr>

                </table>
            </form>
            <?php
            //Check  whether the button is clicked or not
            if(isset($_POST['submit'])) {
                //Add the Food in Database

                //1. Get al the Details from the Form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];

                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];
                

                //Check whether radion button for featured active are checked or not
                if(isset($_POST['featured'])) {
                    $featured = $_POST['featured'];
                } else {
                    $featured = "NO";//Setting the Default Value
                }

                if(isset($_POST['active'])) {
                    $active = $_POST['active'];
                } else {
                    $active = "NO";//Setting the Default Value
                }


                //2. Upload the Image if selected 
                //Check whether the image is selected or not and uipload image only if selected
                if(isset($_FILES['image']['name'])) {
                    //Get the details of the selected image
                    $image_name = $_FILES['image']['name'];//New Image Name

                    //Check Whether the Image is Selected or not and upload image only if selected
                    if($image_name != "") {
                        //Image is Selected
                        //A. Uploading New Image
                        //Renamge the Image
                        //Get the extension of selected image (jpg, png, gif, ect.)"Mohammed-habboub.jpg" ==> Mohammed-habboub
                        $ext = end(explode('.', $image_name));

                        // Create New Name for Image
                        $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext;//New Image Name May BE "Food-Name-744.jpg"

                        //B. Upload the Image
                        //Get the Src Path and Destinaton path

                        //Source path is the current location of the image
                        $src_path = $_FILES['image']['tmp_name'];

                        //Destination Path for the image to be uploaded
                        $dst = "../images/food/".$image_name;

                        //Finally Uppload the food image
                        $upload = move_uploaded_file($src_path, $dst);//بتحمل الصورة في المجلد الموجود في محرر الاكواد الفيجوال استيديو الذي أنشأته

                        //check whether image uploaded of not 
                        if($upload==false){
                            //Failed to Upload the image
                            //Redirect to Add Food Page with Error Message
                            $_SESSION['upload'] = '<div class="error">Failed to Upload new Image. </div>';
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Stop the proccess
                            die();
                            
                        }
                        //3. Remove the image if new image uploaded and current image exists
                        //B. Remove current image if Available
                        if($current_image != "") {
                            //Current Image is Available
                            //Remove the image
                            $remove_path = "../images/food/" . $current_image;

                            $remove = unlink($remove_path);

                            //Check whether the image is removed or not

                            if($remove == false) {
                                //failed to remove current image
                                $_SESSION['remve-failed'] = "<div class='error'>Faile to remove current image.</div>";
                                header('location: ' .SITEURL.'admin/manage-food.php');
                                die();
                            }
                        }

                    } else {
                        $image_name = $current_image;//Default Image when image is not selected
                    }

                } else {
                    $image_name = $current_image;//Default Image when Button not click

                }
                //4. Update the Food in Database
                $sql3 = "UPDATE tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    category_id = $category,
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";
                //Execute the Query 
                $res3 = mysqli_query($conn, $sql3);

                //Check whether data inserted or not
                //4. Redirect With Message to Manage Food Page
                if($res3) {
                    //Data update Successfully
                    $_SESSION['update'] = '<div class="succsess">Food Updated Successfully</div>';
                    header('location: ' . SITEURL . 'admin/manage-food.php');
                } else {
                    //Failed to update Data
                    $_SESSION['update'] = '<div class="error">Failed Update Food..</div>';
                    header('location: ' . SITEURL . 'admin/manage-food.php');

                }
            }
            
            ?>
            
        </div>

    </div>

<?php include("partials/footer.php") ?>
