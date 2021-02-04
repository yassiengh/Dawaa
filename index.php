<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Dawaa | Home</title>
        <link rel="icon" type="image/png" href="media/icons/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/home.css">
    </head>
    <body>

        <?php

            session_start();
            require_once 'common/connection.php';

            // fetching all the products from the DB
            $result = mysqli_query($conn, "SELECT * FROM products");
            $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

            function displayMsg($errMsg, $status) {
                echo '<div class="alert alert-' . $status . '" role="alert">' . $errMsg .'</div>';
            }

            // add to cart
            if (isset($_POST['add-to-cart'])) {

                // it there's atleast one item in the shopping cart
                if (isset($_SESSION['shopping-cart'])) {

                    $item_array_id = array_column($_SESSION['shopping-cart'], "item_id");

                    // if the item is already added before alert that
                    if (in_array($_POST['ProductID'], $item_array_id)) {
                        displayMsg("The item is already added to the cart!", "warning");
                    }

                    else {

                        // if not added before
                        $items_count = count($_SESSION['shopping-cart']);
    
                        $item_array = array(
                            'item_id' => $_POST['ProductID'],
                            'item_amount' => $_POST['amount']
                        );
    
                        // append to the shopping cart array
                        $_SESSION['shopping-cart'][$items_count] = $item_array;

                        displayMsg("The item has been added to the cart!", "success");
                    }


                } else {

                    // if no items in cart
                    $item_array = array(
                        'item_id' => $_POST['ProductID'],
                        'item_amount' => $_POST['amount']
                    );

                    $_SESSION['shopping-cart'][0] = $item_array;

                    displayMsg("The item has been added to the cart!", "success");
                }

            }

        ?>

        <!-- header -->
        <header>
            <?php include 'common/navbar.php' ?>
            
            <div class="overview">
                <div class="overlay">
                    <div class="welcome">
                        <h1>Welcome to Dawaa website</h1>
                        <p class="lead">Where you can search for medicines<br>and reach more pharamacies in a simple way</p>
                    </div>

                    <form method="get" name="search-form" action="">
                        <input type="search" name="search" placeholder="search medicine">
                        <input type="submit" hidden>
                    </form>
                </div>
            </div>
        </header>

        <!-- view products -->
        <section class="view-products">
            <div class="container">
                <h3 class="heading">View Products</h3>

                <ul class="categories">
                    <li data-filter="*" class="current">All</li>
                    <?php
                        $result = mysqli_query($conn, "SELECT * FROM categories");
                        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

                        foreach ($categories as $category) {
                            echo '<li data-filter=".' . $category['CategoryName'] . '">' . $category['CategoryName'] . '</li>';
                        }
                    ?>
                </ul>

                <div class="product-wrapper row">

                    <?php foreach($products as $product) : ?>
                    <?php

                        // getting the product's category
                        $category_query  = mysqli_query($conn, "SELECT * FROM categories WHERE CategoryID='" . $product['CategoryID'] . "'");
                        $category_result = mysqli_fetch_assoc($category_query);
                    ?>

                    <div class="col-lg-4 col-md-6 mb-4 <?php echo $category_result['CategoryName']; ?>">
                        <div class="product card">
                            <img src="<?php echo 'media/products/' . $product['src'] ; ?>" class="card-img-top" alt="<?php echo $product['ProductName']; ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $product['ProductName']; ?></h5>
                                <div class="product-info">
                                    <p class="card-text price"><?php echo $product['ProductPrice']; ?> EGP</p>

                                    <form action="<?php echo isset($_SESSION['isLogged']) ? $_SERVER['PHP_SELF'] : 'login.php'; ?>" method="post" name="add-to-cart-form">
                                        <input type="text" name="ProductID" hidden value="<?php echo $product['ProductID']; ?>">

                                        <?php if ($product['ProductQuantity'] > 0): ?>
                                        <label for="amount">amount:</label>
                                        <input type="number" name="amount" id="amount" value="1" min="1" max="<?php echo $product['ProductQuantity']; ?>">
                                        <input type="submit" class="btn btn-success" value="Add to cart" name="add-to-cart">
                                        <?php else: ?>
                                        <span class="out-of-stock">out-of-stock</span>
                                        
                                        <input type="submit" class="btn btn-success" value="Add to cart" name="add-to-cart" disabled>
                                        <?php endif; ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </section>

        <?php mysqli_close($conn); ?>

        <!-- footer -->
        <?php include 'common/footer.php' ?>
        
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/isotope.pkgd.min.js"></script>
        <script src="js/home.js"></script>
    </body>
</html>