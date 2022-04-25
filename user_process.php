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

    // UPDATE USER
    if($type === "update")
    {
        // GET USER DATA
        $userData = $userDao->verifyToken();

        // RECEIVE POST DATA
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");

        // CREATE NEW USER OBJECT
        $user = new User();

        // MAKE USER DATA
        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->email = $email;
        $userData->bio = $bio;

        // IMAGE UPLOAD
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"]))
        {
            
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/png"];

            #print_r($image); echo $image["tmp_name"] . ".jpeg"; exit;

            // IMAGE TYPE CHECK
            if(in_array($image["type"], $imageTypes))
            {

                // IF JPG
                if(in_array($image, $jpgArray))
                {
                    $imageFile = imagecreatefromjpeg($image["temp_name"]);
                    #echo "IT´s JPEG"; exit;
                }
                // IF PNG
                else
                {
                    $imageFile = imagecreatefrompng($image["temp_name"]);
                    #echo "IT´s PNG"; exit;
                }

                $imageName = $user->imageGenerateName();

                imagejpeg($imageFile, "./img/users/" . $imageName, 100);

                $userData->image = $imageName;

            }
            else
            {
                $message->setMessage("Invalid image type, allowed types ==> (JPG or PNG)", "error", "back");
            }
        
        }

        $userDao->update($userData);

    }
    // UPDATE USER PASSWORD
    else if($type === "changepassword")
    {
        // RECEIVE POST DATA
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
       
        // GET USER DATA
        $userData = $userDao->verifyToken();

        $id = $userData->id;

        if($password === $confirmpassword)
        {
            // CREATE NEW USER OBJECT
            $user = new User();

            $finalPassword = $user->generatePassword($password);

            $user->password = $finalPassword;
            $user->id = $id;

            $userDao->changePassword($user);

        }
        else
        {
            $message->setMessage("Password not match", "error", "back");
        }

    }
    else
    {
        $message->setMessage("Invalid informations!", "error", "index.php");
    }

?>