<?php include("partials/menu.php") ?>


    <div class="main-cotact">
        <div class="wrapper">
            <h1>Add Food</h1>

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
                            <input type="text" name="title" placeholder="Title of the Food">
                        </td>
                    </tr>

                    <tr> 
                        <td>Description: </td>
                        <td>
                            <textarea name="description" id="" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price" placeholder="price">
                        </td>
                    </tr>

                    <tr>
                        <td>Select image: </td>
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
                                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
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
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No"> No
                        </td>
                    </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No

                    </td>
                </tr>


                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                        </td>
                    </tr>

                </table>
            </form>
            <?php
            //Check  whether the button is cliiked or not
            if(isset($_POST['submit'])) {
                //Add the Food in Database

                //1. Get the Data from Form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                

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
                    $image_name = $_FILES['image']['name'];

                    //Check Whether the Image is Selected or not and upload image only if selected
                    if($image_name != "") {
                        //Image is Selected
                        //A. Renamge the Image
                        //Get the extension of selected image (jpg, png, gif, ect.)"Mohammed-habboub.jpg" ==> Mohammed-habboub
                        $ext = end(explode('.', $image_name));
                        // Create New Name for Image
                        $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext;//New Image Name May BE "Food-Name-744.jpg"

                        //B. Upload the Image
                        //Get the Src Path and Destinaton path

                        //Source path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];

                        //Destination Path for the image to be uploaded
                        $dst = "../images/food/".$image_name;

                        //Finally Uppload the food image
                        $upload = move_uploaded_file($src, $dst);

                        //check whether image uploaded of not 
                        if($upload==false){
                            //Failed to Upload the image
                            //Redirect to Add Food Page with Error Message
                            $_SESSION['upload'] = '<div class="error">Failed to Upload Image. </div>';
                            header('location:'.SITEURL.'admin/add-food.php');
                            //Stop the proccess
                            die();
                            
                        }

                    }
                } else {
                    $image_name = "";//Setting Default Value as blank

                }

                //3. Insert Into Database
                //Create a SQL Query to Save or Add food
                // For Numerical we do not need to pass value inside quotes '' But for string value it is compulsory to add quotes''
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    category_id = $category,
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                ";
                //Execute the Query 
                $res2 = mysqli_query($conn, $sql2);

                //Check whether data inserted or not
                //4. Redirect With Message to Manage Food Page
                if($res2) {
                    //Data inserted Successfully
                    $_SESSION['add'] = '<div class="succsess">Food Added Successfully</div>';
                    header('location: '.SITEURL.'admin/manage-food.php');
                } else {
                    //Failed to Insert Data
                    $_SESSION['add'] = '<div class="error">Failed Add Food..</div>';
                    header('location: '.SITEURL.'admin/manage-food.php');

                }
            }
            
            ?>
            
        </div>

    </div>

<?php include("partials/footer.php") ?>
