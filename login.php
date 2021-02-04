<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Dawaa | Login</title>
        <link rel="icon" type="image/png" href="media/icons/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>

        <?php session_start(); ?>
        
        <!-- navbar -->
        <?php include 'common/navbar.php' ?>

        <!-- login -->
        <section class="login">
            <div class="container">
                <h3>Login</h3>

    
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="login-form" class="form-group d-flex flex-column align-items-center">
                    <?php
                        require_once 'common/connection.php';

                        if(isset($_POST['login'])) {

                            // displaying error messages to the user
                            function error_msg($errMsg) {
                                echo '<div id="form-alert" class="alert alert-danger" role="alert">' . $errMsg .'</div>';
                            }
                            
                            // getting values from inputs
                            $UserEmail = mysqli_real_escape_string($conn, $_POST['email']);
                            $UserPassword = mysqli_real_escape_string($conn, $_POST['password']);

                        
                            // validation
                            if ($UserEmail == '' || $UserPassword == '') {
                                error_msg("All fields are required!");
                            }
    
                            else {
                                // checking if email and password are valid
                                $result = mysqli_query($conn, "SELECT * FROM users WHERE UserEmail='$UserEmail' AND UserPassword='$UserPassword'");
                                $rows = mysqli_num_rows($result);

                                // if there's a row in the result then the information provided are correct
                                if($rows == 1) {

                                    $userData = mysqli_fetch_assoc($result);

                                    // setting logging status
                                    $_SESSION['isLogged'] = True;

                                    // getting the user's id
                                    $_SESSION['UserID'] = $userData['UserID'];

                                    // getting the user rule
                                    $_SESSION['isAdmin'] = $userData['Admin'];

                                    // terminating the DB connection
                                    mysqli_close($conn);

                                    // redirection based on rule
                                    if ($_SESSION['isAdmin']) {
                                        header("Location: dashboard.php");
                                    } else {
                                        header("Location: index.php");
                                    }
                                    
                                } else {
                                    error_msg("Invalid email or password!");
                                }
                            }

                            // terminating the DB connection
                            mysqli_close($conn);
                        }
                    ?>
                    <input type="email" placeholder="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" class="form-control mb-3">
                    <input type="password" placeholder="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" class="form-control mb-4">
                    <input type="submit" value="Login" name="login" class="btn btn-primary">
                    <p class="mt-3">Don't have an account? <a href="register.php">create account</a></p>
                </form>
            </div>
        </section>

        <!-- footer -->
        <?php include 'common/footer.php' ?>
        
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>