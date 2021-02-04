<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Dawaa | Cart</title>
        <link rel="icon" type="image/png" href="media/icons/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/cart.css">
    </head>
    <body>

        <?php
            session_start();

            // if not logged redirect to login page
            if ( !isset($_SESSION['isLogged']) ) {
                header("Location: login.php");
            }

            require_once 'common/connection.php';

            $all_items = array();

            // if one item is removed
            if ( isset($_POST['remove']) ) {

                $itemToRemove =  $_POST['product_id'];

                // search in the cart for the item to remove
                foreach ($_SESSION['shopping-cart'] as $keys => $values) {

                    // remove the item from the session variable shopping-cart
                    if ($values['item_id'] == $itemToRemove) {
                        unset($_SESSION['shopping-cart'][$keys]);
                        break;
                    }

                }
                
            }
            
            // if there's atleast one item in the cart
            if ( isset($_SESSION['shopping-cart']) ) {

                $total = 0;

                foreach ($_SESSION['shopping-cart'] as $cart_item) {

                    // getting the items' data from DB
                    $item_query  = mysqli_query($conn, "SELECT * FROM products WHERE ProductID='" . $cart_item['item_id'] . "'");
                    $item_result = mysqli_fetch_assoc($item_query);

                    array_push($all_items, array(
                        "ProductID"     => $item_result['ProductID'],
                        "ItemName"      => $item_result['ProductName'],
                        "ItemQuantity"  => $cart_item['item_amount'],
                        "TotalPrice"    => $cart_item['item_amount'] * $item_result['ProductPrice']
                    ));
                    
                    $total += $all_items[count($all_items) - 1]['TotalPrice'];
                }
            }

            // make order
            if ( isset($_POST['make-order']) ) {
                // --------------- adding the order in orders table ---------------

                // getting the number of rows in orders table
                $result = mysqli_query($conn, "SELECT * FROM orders");
                $rows = mysqli_num_rows($result);

                // inserting the new order in the DB
                $OrderID = $rows; // if 0 rows, OrderID=0, etc... (like array index)
                date_default_timezone_set("Africa/Cairo");
                $OrderDate = date("Y-m-d H:i:s");
                $UserID = $_SESSION['UserID'];
                $query = "INSERT INTO orders(OrderID, OrderDate, UserID) VALUES('$OrderID', '$OrderDate', '$UserID')";
                mysqli_query($conn, $query);

                
                // --------------- adding the items in items table ---------------

                // getting the number of rows in items table
                $result = mysqli_query($conn, "SELECT * FROM items");
                $rows = mysqli_num_rows($result);

                // inserting the purchased items in the DB
                foreach ($all_items as $item) {

                    $ItemID = $rows;
                    $TotalPrice = $item['TotalPrice'];
                    $Quantity = $item['ItemQuantity'];
                    $ProductID = $item['ProductID'];

                    $query = "INSERT INTO items(ItemID, OrderID, TotalPrice, Quantity, ProductID) VALUES('$ItemID', '$OrderID', '$TotalPrice', '$Quantity', '$ProductID')";
                    mysqli_query($conn, $query);
                    
                    $rows++;
                }

                // --------------- updating the product quantity in products table ---------------
                foreach ($all_items as $item) {

                    $ItemQuantity = $item['ItemQuantity'];
                    $ProductID = $item['ProductID'];

                    $query = "SELECT * FROM products WHERE ProductID='$ProductID'";
                    $result = mysqli_query($conn, $query);
                    $ProductQuantityRow = mysqli_fetch_assoc($result);
                    $ProductQuantity = $ProductQuantityRow['ProductQuantity'];

                    $newQuantity = $ProductQuantity - $ItemQuantity;

                    $query = "UPDATE products SET ProductQuantity='$newQuantity' WHERE ProductID='$ProductID'";
                    mysqli_query($conn, $query);
                }

                // --------------- reseting the shopping cart session variable ---------------
                unset($_SESSION['shopping-cart']);
                $all_items = array();

                // --------------- alert success ---------------
                echo '<div class="alert alert-success" role="alert">The order has been made successfully!</div>';

            }

            // terminating the DB connection
            mysqli_close($conn);

        ?>
        
        <!-- make order box -->
        <div class="overlay"></div>
        <div class="make-order-box">
            <div class="container">
                <div class="bill-wrapper">
                    <div class="bill">
                        <table id="bill-table">
                            <tr>
                                <th>Item</th>
                                <th>amount</th>
                                <th>Price</th>
                            </tr>

                            <?php foreach ($all_items as $item) : ?>
                            <tr>
                                <td><?php echo $item['ItemName']; ?></td>
                                <td><?php echo $item['ItemQuantity']; ?></td>
                                <td><?php echo $item['TotalPrice']; ?> EGP</td>
                            </tr>
                            <?php endforeach; ?>
                        
                            <tr>
                                <td colspan="2">Total:</td>
                                <td><?php echo $total; ?> EGP</td>
                            </tr>
                        </table>
                    </div>
                    <div class="payment">
                        <h5 class="text-center">Payment</h5>

                        <form method="post" name="make-order-form">
                            <label for="payment-method">Payment method:</label>

                            <select id="payment-method" name="payment-method">
                                <option value="cash">Cash</option>
                                <option value="credit-card">Credit Card</option>
                            </select>

                            <input type="submit" value="ORDER" name="make-order" class="btn btn-primary">
                        </form>
                        <span class="btn btn-primary" id="cancel-btn">Cancel</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- navbar -->
        <?php include 'common/navbar.php' ?>

        <!-- cart items -->
        <section class="my-cart">
            <div class="container">
                <h3>My Cart</h3>
                
                <p class="lead" id="empty-cart">The cart is empty!<br>go shop and get back here :)</p>

                <div class="cart-wrapper row">
                    
                    <?php foreach($all_items as $item) : ?>
                    <div class="col-lg-6">
                        <div class="cart-item card mb-4">
                            <div class="card-header text-center"><?php echo $item['ItemName']; ?></div>
                            <div class="card-body">
                                <span class="card-text text-muted">amount: <?php echo $item['ItemQuantity']; ?></span>
                                <span class="card-text text-muted">total price: <?php echo $item['TotalPrice']; ?> EGP</span>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <input type="hidden" value="<?php echo $item['ProductID']; ?>" name="product_id">
                                    <input type="submit" value="Remove" name="remove" class="remove-btn btn btn-danger">
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                </div>

                <div class="d-flex justify-content-center">
                    <span class="btn" id="make-order">Make Order</span>
                </div>
            </div>
        </section>

        <!-- footer -->
        <?php include 'common/footer.php' ?>
        
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/cart.js"></script>
    </body>
</html>