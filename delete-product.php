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
        ?>

        <!-- content -->
        <section class="content">
            <div class="container">

                <!-- delete-product content -->
                <div class="content-section delete-product">
                    <h3>Delete product</h3>

                    <!-- write here the front-end -->

                </div>

            </div>
        </section>

        <?php mysqli_close($conn); ?>
        
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/dashboard-all.js"></script>
    </body>
</html>