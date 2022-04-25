<?php

    $db_name = "moviestar";
    $db_host = "localhost";
    $db_user = "chimia";
    $db_pass = "242705at";

    $conn = new PDO("mysql:dbname=". $db_name . ";host=". $db_host, $db_user, $db_pass);

    // ENABLE PDO ERRORS
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

?>