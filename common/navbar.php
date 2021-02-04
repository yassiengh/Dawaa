<nav class="navbar navbar-expand-sm navbar-light">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="media/icons/logo.svg" alt="Dawaa" width="150"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <?php

                // check the logging status
                if ( isset($_SESSION['isLogged']) ) {

                    // check if admin to link the dashboard on navbar
                    if ($_SESSION['isAdmin']) {
                        echo '<li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>';
                    }
    
                    // check if user to link the cart and logout on navbar
                    else {
                        echo '<li class="nav-item"><a class="nav-link" href="cart.php">My cart</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php?logout=true">Logout</a></li>';
                    }

                }
                else {
                    echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                          <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>';
                }
            ?>
            </ul>
        </div>
    </div>
</nav>