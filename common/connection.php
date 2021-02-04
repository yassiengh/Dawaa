<?php

    $conn = mysqli_connect('localhost', 'root', '', 'Dawaa');

    if (mysqli_connect_errno()) {
        echo 'Please, check the database connection! ' . mysqli_connect_errno();
    }

?>