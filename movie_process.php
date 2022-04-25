<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/Movie.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $message = new Message($BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);

    // GET FORM TYPE
    $type = filter_input(INPUT_POST, "type");

    // GET USER DATA
    $userData = $userDao->verifyToken();
    #print_r($userData); exit;
    
    if($type === "create")
    {

        // RECEIVE INPUT DATA
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");

        $movie = new Movie();

        // MIN DATA VALIDATION
        if(!empty($title) && !empty($description) && !empty($category))
        {
            
            $movie->title = $title;
            $movie->description = $description;
            $movie->trailer = $trailer;
            $movie->category = $category;
            $movie->length = $length;
            $movie->users_id = $userData->id;

            // IMAGE UPLOAD
            if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"]))
            {
                $image = $_FILES["image"];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                $jpgArray = ["image/jpeg", "image/jpg"];

                // CHECK IMAGE TYPE
                if(in_array($image["type"], $imagetypes))
                {

                    // IMAGE CHECKER
                    if(in_array($image["type"], $jpgArray))
                    {
                        $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                    }
                    else
                    {
                        $imageFile = imagecreatefrompng($image["tmp_name"]);
                    }

                    // GENERATE IMAGE NAME
                    $movie = new Movie();
                    
                    $imageName = $movie->imageGenerateName();

                    imagejpeg($imageFiles, "./img/movies/" . $imageName, 100);

                    $movie->image = $imageName;

                }
                else
                {

                    $message->setMessage("Invalid image type, allowed types: jpg and png.", "error", "back");

                }

            }

            // print_r($_SERVER); echo "<hr>"; print_r($_POST); echo "<hr>"; print_r($_FILES); exit;

            $movieDao->create($movie);

        }
        else
        {
            $message->setMessage("You need insert at least: title, description and category to add a movie", "error", "back");
        }

    }
    else if($type === "delete")
    {

        // RECEIVE FORM DATA
        $id = filter_input(INPUT_POST, "id");

        $movie = $movieDao->findById($id);
        #print_r($movie); exit;

        if($movie)
        {

            // CHECK USER MOVIE
            if($movie->users_id === $userData->id)
            {

                $movieDao->destroy($movie->id);

            }
            else
            {

                $message->setMessage("Invalid informatios 1!", "error", "index.php");
                
            }

        }
        else
        {

            $message->setMessage("Invalid informatios 2!", "error", "index.php");

        }

    }
    else if($type === "update")
    {

         // RECEIVE INPUT DATA
         $title = filter_input(INPUT_POST, "title");
         $description = filter_input(INPUT_POST, "description");
         $trailer = filter_input(INPUT_POST, "trailer");
         $category = filter_input(INPUT_POST, "category");
         $length = filter_input(INPUT_POST, "length");
         $id = filter_input(INPUT_POST, "id");
 
         $movieData = $movieDao->findById($id);

         // IF FIND MOVIE
         if($movieData)
         {

            // CHECK USER MOVIE
            if($movieData->users_id === $userData->id)
            {

                // MIN DATA VALIDATION
                if(!empty($title) && !empty($description) && !empty($category))
                {

                    // MOVIE EDIT
                    $movieData->title = $title;
                    $movieData->description = $description;
                    $movieData->trailer = $trailer;
                    $movieData->category = $category;
                    $movieData->length = $length;

                    // IMAGE UPLOAD
                    if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"]))
                    {
                        $image = $_FILES["image"];
                        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                        $jpgArray = ["image/jpeg", "image/jpg"];

                        // CHECK IMAGE TYPE
                        if(in_array($image["type"], $imagetypes))
                        {

                            // IMAGE CHECKER
                            if(in_array($image["type"], $jpgArray))
                            {
                                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                            }
                            else
                            {
                                $imageFile = imagecreatefrompng($image["tmp_name"]);
                            }

                            // GENERATE IMAGE NAME
                            $movie = new Movie();
                            
                            $imageName = $movie->imageGenerateName();

                            imagejpeg($imageFiles, "./img/movies/" . $imageName, 100);

                            $movieData->image = $imageName;

                        }
                        else
                        {

                            $message->setMessage("Invalid image type, allowed types: jpg and png.", "error", "back");

                        }

                    }       

                    $movieDao->update($movieData);

                }
                else
                {
                    $message->setMessage("You need insert at least: title, description and category to add a movie", "error", "back");
                }       

            }
            else
            {

                $message->setMessage("Invalid informatios 1!", "error", "index.php");
                
            }  
         }
         else
        {

            $message->setMessage("Invalid informatios 2!", "error", "index.php");
            
        }  

    }
    
    else
    {

        $message->setMessage("Invalid informatios 3!", "error", "index.php");

    }

?>