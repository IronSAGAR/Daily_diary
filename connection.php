<?php

    $username = "Celestial69";
    $servename = "localhost";
    $password = "mysqlpass@654";

    $link = new mysqli($servename, $username, $password, "daily_diary");
    if ($link->connect_error) {
        die("Connection failed: ". $link->connect_error);
    }


?>