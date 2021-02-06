<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Dawaa | Dashboard</title>
        <link rel="icon" type="image/png" href="media/icons/dashboard.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/dashboard-all.css">
        <link rel="stylesheet" href="css/dashboard-delete-product.css">
    </head>
    <body>

        <?php require_once 'common/connection.php'; ?>

        <!-- dashboard sidebar -->
        <?php include 'common/dashboard-sidebar.php' ?>

        <?php 
            session_start();

            // code here the back-end
            if(isset($_POST["delete"]))
            {   
                $found = false;
                $productID = $_POST['ProductID'];
                $IDs = mysqli_query($conn,"SELECT ProductID FROM products");
                while($ids = mysqli_fetch_array($IDs)){
                    if($ids["ProductID"]===$productID){
                        $found = true;
                    }
                }
                if(!$found){
                    echo '<script>alert("no product found")</script>';
                }else{
                    mysqli_query($conn,"DELETE FROM products WHERE ProductID=$productID"); 
                }

            }
        ?>
        

        <!-- content -->
        <section class="content">
            <div class="container">

                <!-- delete-product content -->
                <div class="content-section delete-product">
                    <h3>Delete product</h3>
                    
                    <!-- front-end -->

                    <form action="delete-product.php" method="post">
                        <input type="number" name="ProductID" id="ProductID" placeholder="product ID" required>
                        <input type="submit" name="delete" id="delete" value="Delete">
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

