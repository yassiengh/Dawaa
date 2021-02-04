<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Dawaa | Register</title>
        <link rel="icon" type="image/png" href="media/icons/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/register.css">
    </head>
    <body>

        <?php session_start(); ?>
        
        <!-- navbar -->
        <?php include 'common/navbar.php' ?>
        

        <!-- register -->
        <section class="register">
            <div class="container">
                <h3>Register</h3>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="register-form" class="form-group d-flex flex-column align-items-center">

                <?php
                    require_once 'common/connection.php';

                    if(isset($_POST['register'])) {

                        // displaying error messages to the user
                        function error_msg($errMsg) {
                            echo '<div id="form-alert" class="alert alert-danger" role="alert">' . $errMsg .'</div>';
                        }

                        // checking if the data already exists in the DB
                        function already_exists($conn, $data, $type) {
                            if ($type == 'username') {
                                $result = mysqli_query($conn, "SELECT * FROM users WHERE UserName='".$data."'");
                            }
                            
                            else if ($type == 'email') {
                                $result = mysqli_query($conn, "SELECT * FROM users WHERE UserEmail='".$data."'");
                            }

                            if (mysqli_num_rows($result) > 0) {
                                return true;
                            }

                            return false;
                        }

                        // getting values from inputs
                        $UserName = mysqli_real_escape_string($conn, $_POST['username']);
                        $UserEmail = mysqli_real_escape_string($conn, $_POST['email']);
                        $UserPassword = mysqli_real_escape_string($conn, $_POST['password']);

                        // validation
                        if ($UserName == '' || $UserEmail == '' || $UserPassword == '') {
                            error_msg("All fields are required!");
                        }

                        else if (preg_match('/[^A-Za-z0-9]+/', $UserName)) {
                            error_msg("Username must only contain english characters and digits!");
                        }

                        else if (already_exists($conn, $UserName, 'username')) {
                            error_msg("Username already exists!");
                        }

                        else if (!(filter_var($UserEmail, FILTER_VALIDATE_EMAIL))) {
                            error_msg("Incorrect email address");
                        }

                        else if (already_exists($conn, $UserEmail, 'email')) {
                            error_msg("Account already exists!");
                        }

                        else {

                            // getting the last ID added
                            $last_row_query = "SELECT * FROM users WHERE UserID=(SELECT MAX(UserID) FROM users)";
                            $result = mysqli_query($conn, $last_row_query);
                            $last_row = mysqli_fetch_assoc($result);
                            $UserID = ++$last_row['UserID'];
    
                            // inserting the new user's data
                            $query = "INSERT INTO users(UserID, UserName, UserEmail, UserPassword) VALUES('$UserID', '$UserName', '$UserEmail', '$UserPassword')";
                            mysqli_query($conn, $query);

                            // setting logging status
                            $_SESSION['isLogged'] = True;

                            // getting the user's id
                            $_SESSION['UserID'] = $last_row['UserID'];

                            // setting the user rule
                            $_SESSION['isAdmin'] = False;

                            // terminating the DB connection
                            mysqli_close($conn);

                            // redirection to home
                            header("Location: index.php");
                        }

                    }

                ?>

                    <input type="text" placeholder="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" class="form-control mb-3">
                    <input type="email" placeholder="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" class="form-control mb-3">
                    <input type="password" placeholder="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" class="form-control mb-4">
                    <input type="submit" value="Register" name="register" class="btn btn-primary">
                </form>

            </div>
        </section>

        <!-- footer -->
        <?php include 'common/footer.php' ?>
        
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>