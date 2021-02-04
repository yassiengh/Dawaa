<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Dawaa | Dashboard</title>
        <link rel="icon" type="image/png" href="media/icons/dashboard.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/dashboard-all.css">
        <link rel="stylesheet" href="css/dashboard-update-product.css">
    </head>
    <body>
        <?php require_once 'common/connection.php'; ?>

        <!-- dashboard sidebar -->
        <?php include 'common/dashboard-sidebar.php' ?>

        <?php 
            session_start();

            if(isset($_POST["submit"]))
        {
            $clean = $_POST;
            
            $id = $clean["id"];
            
                if(!($clean["name"]=="")){
                    $name = $clean["name"];
                    $query = "UPDATE products SET ProductName = '$name' WHERE ProductID = $id";
                    mysqli_query($conn, $query);
                    
                }

                 if(!($clean["price"]=="")){
                    $price = $clean["price"];
                    $query = "UPDATE products SET ProductPrice = $price WHERE ProductID = $id";
                    mysqli_query($conn, $query);
                 }

                 if(!($clean["quantity"]=="")){
                    $quantity = $clean["quantity"];
                    $query = "UPDATE products SET ProductQuantity = $quantity WHERE ProductID = $id";
                    mysqli_query($conn, $query);    
                 }
                
                 
                 if(!($clean["category"]=="")){
                    $catid = $clean["category"];
                    $query = "UPDATE products SET CategoryID = $catid WHERE ProductID = $id";
                    mysqli_query($conn, $query);
                 }
                 
                 if(is_uploaded_file($_FILES["image"]["tmp_name"])){
                    $file_pointer = "media/products/" . $id . ".jpg";
                    
                    if(file_exists($file_pointer)){
                        unlink($file_pointer);
                    }
                    
                    move_uploaded_file($_FILES["image"]["tmp_name"], $file_pointer);
                    $query = "UPDATE products SET src ='$id.jpg' WHERE ProductID = $id";
                    mysqli_query($conn,$query);
                    
                 }  
        }
        ?>

        <!-- content -->
        <section class="content">
            <div class="container">

                <!-- update-product content -->
                <div class="content-section update-product">
                    <h3>Update product</h3>
                    
                    <!-- front-end -->
                    <form action="update-product.php" method="post" enctype="multipart/form-data">

                    <label for="id"> Product ID</label>
                    <input class="form-control" type ="number" id="id" name="id"
                            value="<?php echo isset($productID) ? $productID : ''; ?>" required><br>

                    <label for="name">Product name</label>
                    <input class="form-control" type="text" name="name"><br>
                    
                    <label for="price">Product price </label>
                    <input class="form-control" type="number" id="price" name="price" min="" 
                            value="productPrice"><br>
                    
                    <label for="quantity">Product quantity</label>
                    <input class="form-control" type="number" id="quantity" name="quantity" min="1" 
                            value="productQuantity"><br>
                    <?php
                        $cats = mysqli_query($conn,"SELECT * FROM categories");
                    ?>
                    <label> Select new category </label>
                    <select class="form-control" id="val-skill" name="category">
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
                    <input class="form-control" type="file" id="image" name="image"><br>
                    
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