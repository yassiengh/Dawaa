<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Dawaa | Dashboard</title>
        <link rel="icon" type="image/png" href="media/icons/dashboard.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/dashboard-all.css">
        <link rel="stylesheet" href="css/dashboard-add-product.css">
    </head>


    <body>

        <?php require_once 'common/connection.php'; ?>

        <!-- dashboard sidebar -->
        <?php include 'common/dashboard-sidebar.php' ?>

       <?php 
            session_start();

         
        if(isset($_POST["submit"]))
        {
            extract($_POST);
            
            $target_dir = "media/products/";
            
            $src = time()."-" . basename($_FILES["image"]["name"]);
            
            $image = $target_dir . basename($_FILES["image"]["name"]);
            
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$src);
              
            $last_row_query = "SELECT * FROM products WHERE ProductID=(SELECT MAX(ProductID) FROM products)";
            $result = mysqli_query($conn, $last_row_query);
            $last_row = mysqli_fetch_assoc($result);
            $ProductID = ++$last_row['ProductID'];

            $query = "INSERT INTO products(ProductID, ProductName, ProductPrice, ProductQuantity, src, CategoryID) VALUES ( '$ProductID','$name', '$price', '$quantity', '$src', '$category')";

            mysqli_query($conn, $query);

        }
    

        ?>

        
        <!-- content -->
        <section class="content">
            <div class="container">

                <!-- add-product content -->
                <div class="content-section add-product">

                <h3>Add product</h3>

                <?php

                    $cats = mysqli_query($conn,"SELECT * FROM categories");
                ?>

                </div>
                    <!-- write here the front-end -->               
                    <form action="add-product.php" method="post" enctype="multipart/form-data">
                    <label for="name">Product name</label>
                    <input class="form-control" type="text" id="name" name="name" value="<?php echo isset($productName) ? $productName : ''; ?>"required><br>
                    
                    <label for="price">Product price </label>
                    <input class="form-control" type="number" id="price" name="price" min="" value="<?php echo isset($productPrice) ? $productPrice : '0'; ?>"required><br>
                    
                    <label for="quantity">Product quantity</label>
                    <input class="form-control" type="number" id="quantity" name="quantity" min="1" value="<?php echo isset($productQuantity) ? $productQuantity : '1'; ?>"required><br>
        
                    <select class="form-control" id="val-skill" name="category" required>
                    <option value="">--Choose Category--</option>
                        <?php
                            if ($cats->num_rows > 0) 
                            {
                                while ($row = mysqli_fetch_array($cats)) {?>
                                    <option value="<?php echo $row["CategoryID"];?>">
                                        <?php echo $row['CategoryName'];?>
                                    </option>
                                    <?php
                                }
                            } 
                            else 
                            {
                                echo "0 results";
                            }
                        ?>
                    </select>
                  
                    <label for="file">Image</label>
                    <input class="form-control" type="file" id="image" name="image" required><br>
                    
                    <button class="form-control" type="submit" id="submit" name="submit" class="button">Submit</button>
                    </form>
                </div>


            </div>
        </section>

        <?php mysqli_close($conn); ?>
        
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/dashboard-all.js"></script>
    </body>
</html>