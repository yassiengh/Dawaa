<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Dawaa | Dashboard</title>
        <link rel="icon" type="image/png" href="media/icons/dashboard.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/dashboard-all.css">
        <link rel="stylesheet" href="css/dashboard-view-user.css">
    </head>
    <body>

        <?php require_once 'common/connection.php'; ?>

        
        <?php

            session_start();
              
            if ( isset($_POST['view-user']) ) {

                $UserID = $_POST['userID'];

                // fetching the user's data
                $result = mysqli_query($conn, "SELECT * FROM users WHERE UserID='$UserID'");
                $rows = mysqli_num_rows($result);

                if($rows == 1) {

                    $found = True; // status flag

                    $userInfo = mysqli_fetch_assoc($result);

                    $UserName = $userInfo['UserName'];
                    $UserEmail = $userInfo['UserEmail'];

                    // getting number of orders made by this user
                    $result = mysqli_query($conn, "SELECT * FROM orders WHERE UserID='$UserID'");
                    $UserOrders = mysqli_num_rows($result);

                }
            }


        ?>

        <!-- dashboard sidebar -->
        <?php include 'common/dashboard-sidebar.php' ?>

        <!-- content -->
        <section class="content">
            <div class="container"> 

                <!-- view-users content -->
                <div class="content-section view-users">
                    <h3>View user's details</h3>

                    <form action="<?php echo $_SERVER['PHP_SELF'] ; ?>" method="post" name="view-users-form">
                        <input type="text" name="userID" id="user_id" placeholder="user ID" value="<?php echo isset($_POST['userID']) ? $_POST['userID'] : ''; ?>">
                        <input type="submit" name="view-user" id="view-user" value="view user">
                    </form>

                    <?php if ( isset($_POST['view-user']) ): ?>
                    <div class="user-info card">
                        <div class="card-body">

                            <?php if ( isset($found) ): ?>
                            <i class="far fa-user-circle"></i>
    
                            <div class="info">
                                <span class="card-text">Username: <?php echo '<span class="data">' . $UserName . '</span>'; ?></span>
                                <span class="card-text">Email: <?php echo '<span class="data">' . $UserEmail . '</span>'; ?></span>
                                <span class="card-text">Number of orders: <?php echo '<span class="data">' . $UserOrders . '</span>'; ?></span>
                            </div>

                            <?php else: ?>
                            <h1 class="text-danger">User ID not found!</h1>
                            <?php endif; ?>

                        </div>
                    </div>
                    <?php endif; ?>

                </div>

            </div>
                
        </section>

        <?php mysqli_close($conn); ?>
        
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/dashboard-all.js"></script>
    </body>
</html>