<?php include ('partials-front/menu.php'); ?>
    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //Display All The Categories  that Active
                //SQL Query
                $sql = "SELECT * FROM tbl_category WHERE 	active='Yes' ";
                //Execute the Query 
                $res = mysqli_query($conn, $sql);
                //count rows to check whether the category is available or not
                $count = mysqli_num_rows($res);
                if ($count>0){
                    //The Catecories is Available
                    while($row=mysqli_fetch_assoc($res)){
                        //Get The Values like id, title, image_name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>


                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php

                                    if($image_name == "") {
                                        //Image NOT Available
                                        echo '<div class="error">Image Not Found. </div>';

                                    } else {
                                        //Image Available

                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                        <?php

                                    }

                                ?>
                                

                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                } else {
                    //The Categories is Not Available
                    echo '<div class="error">category Not Found. </div>';
                }
            ?>

                   

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


<?php include ('partials-front/footer.php'); ?>