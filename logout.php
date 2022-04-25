<?php

    require_once("db.php");
    require_once("globals.php");
    require_once("dao/UserDAO.php");
    
    $userDao = new UserDAO($conn, $BASE_URL);

    if($userDao)
    {
        $userDao->destroyToken();
    }
    else{
        echo "deu merda!!!";
    }

?>