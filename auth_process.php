<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);

    // GET FORM TYPE
    $type = filter_input(INPUT_POST, "type");

    // VERIFY FORM TYPE
    if($type === "register")
    {

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        // MIN DATA VERIFICATION
        if($name && $lastname && $email && $password)
        {

            // PASSWORD VERIFICATION
            if($password === $confirmpassword)
            {
                    // E-MAIL VERIFICATION
                if($userDao->findByEmail($email) === false)
                {
                    $user = new User();

                    // CREATE PASSWORD
                    $userToken = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);

                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $finalPassword;
                    $user->token = $userToken;

                    $auth = true;

                    $userDao->create($user, $auth);

                }
                else
                {
                    // SEND ERROR MESSAGE, E-MAIL ALREADY EXISTS
                    $message->setMessage("E-mail already exists, please try another one.", "error", "back");
                }
            }
            else
            {
                // SEND ERROR MESSAGE, PASSWORD NOT MATCH
                $message->setMessage("Password not match.", "error", "back");
            }
            
        }
        else
        {

            // SEND ERROR MESSAGE, MISSING DATA
            $message->setMessage("Fill all required fields.", "error", "back");

        }
        
    }

    else if ($type === "login")
    {

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $name = filter_input(INPUT_POST, "name");

        // TRY TO AUTHENTICATE USER
        if ($userDao->authenticateUser($email, $password))
        {
            $message->setMessage("Welcome.", "success", "editprofile.php");
        }
        // REDIRECT WHEN AUTHENTICATE FAILURE
        else
        {
            $message->setMessage("User or password not match.", "error", "back");
        }
    }
    else
    {
        $message->setMessage("User or password not match.", "error", "back");
    }
?>