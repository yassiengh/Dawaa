<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Dawaa | Dashboard</title>
        <link rel="icon" type="image/png" href="media/icons/dashboard.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/dashboard-all.css">
        <link rel="stylesheet" href="css/dashboard.css">
    </head>
    <body>

        <?php

        session_start();
            
            // if not logged redirect to login page
            if ( !isset($_SESSION['isLogged']) ) {
                header("Location: login.php");
            }
            // if not admin redirect to home page
            else if ( isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == false ) {
                header("Location: index.php");
            }

        ?>

        <?php require_once 'common/connection.php'; ?>

        <!-- dashboard sidebar -->
        <?php include 'common/dashboard-sidebar.php' ?>

        <!-- content -->
        <section class="content">

            <!-- home content -->
            <div class="home-content">
                <div class="welcome">
                    <h3>Welcome to the <span>Dashboard</span></h3>
                    <p>From Here you can manage Dawaa Website!</p>
                </div>

                <h3>The Website's Statistics</h3>

                <div class="info">
                    <div class="unit">
                        <span id="users-counter">
                            <?php
                                $result = mysqli_query($conn, "SELECT COUNT(*) FROM users");
                                $rows = mysqli_fetch_row($result);
                                echo $rows[0];
                            ?>
                        </span>
                        <p>Users</p>
                    </div>

                    <div class="unit">
                        <span id="orders-counter">
                            <?php
                                $result = mysqli_query($conn, "SELECT COUNT(*) FROM orders");
                                $rows = mysqli_fetch_row($result);
                                echo $rows[0];
                            ?>
                        </span>
                        <p>orders</p>
                    </div>
                </div>
            </div>

        </section>
        
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/dashboard-all.js"></script>
        <script src="js/dashboard.js"></script>
    </body>
</html>