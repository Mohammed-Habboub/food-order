<?php include('partials/menu.php')?>

    <div class="main-contect">
        <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <?php
            if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        
        ?>

        <br /><br />
        <!-- Add Category Form Starts -->
        <form action="" method= "POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>

                <tr>
                    <td>Select image: </td>
                    <td>
                        <input type="file" name="image">
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
                    <td>
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
                    
                
            </table>
        </form>
        <!-- Add Category Form Ends -->

        <?php
            if(isset($_POST['submit'])) {
                
                //1. Get The Value From Category Form
                $title = $_POST['title'];

                //For Radio input, We Need to Check Whether the Button is selected or not
                if(isset($_POST['featured'])) {
                    //Get the Value from form
                    $featured = $_POST['featured'];
                } else {
                    //Set the Default Value
                    $featured = "No";
                }

                if(isset($_POST['active'])) {
                    //Get the Value from form
                    $active = $_POST['active'];
                } else {
                    //Set the Default Value
                    $active = "No";
                }
                
                
                //Check whether the image is selected or not and set the value for image name accoridingly
                        //type   //name  for to input always
                //print_r($_FILES['image']);//ا تخدم كلمة الفايل داخل الاقواس لانه المدخل من نوع فايل حسب الفورة بالاعلى وداخل الفايل نضع الاسم 

                //die();//Break the code here.

                if (isset($_FILES['image']['name'])) {
                    //Upload the Image
                    //To upload image we need image name, source path and destination path
                    $imageName       = $_FILES['image']['name'];

                    //Upload the Image only if image is selected
                    if($image_name != ""){

                    
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
                        //Redirect to Add Category Page
                        header('location: ' . SITEURL . 'admin/add-category.php');
                        //Stop  the proccess
                        die();

                    }
                }
                    
                } else {
                    $imageName = "";
                }

                //2. Creat SQL 
                $sql = "INSERT INTO tbl_category SET
                        title      = '$title',
                        image_name = '$imageName',
                        featured   = '$featured',
                        active     = '$active'
                 ";

                 //3. Execute the Query and Save in Database
                 $res = mysqli_query($conn, $sql);

                 //4. Check Whether the query executed or not data added or not
                 if($res) {
                     //Query Executed and Category Added
                     $_SESSION['add'] = "<div class='succsess'>Category Added Successfully.</div>";
                     //Redirect to Manage Category Page
                     header('location: ' . SITEURL . 'admin/manage-category.php');

                 } else {
                     //Failed to Add Category
                     $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                     //Redirect to add Category Page
                     header('location: ' . SITEURL . 'admin/add-category.php');
                 }

            }
        ?>
        </div>
       
    </div>


<?php include('partials/footer.php')?>