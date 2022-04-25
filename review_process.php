<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/Movie.php");
    require_once("models/Review.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/ReviewDAO.php");

    $message = new Message($BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);
    $reviewDao = new ReviewDAO($conn, $BASE_URL);

    // GET FORM TYPE
    $type = filter_input(INPUT_POST, "type");

    // GET USER DATA
    $userData = $userDao->verifyToken();

    if($type === "create")
    {

        // RECEIVE POST DATA
        $rating = filter_input(INPUT_POST, "rating");
        $review = filter_input(INPUT_POST, "review");
        $movies_id = filter_input(INPUT_POST, "movies_id");
        $users_id = $userData->id;

        $reviewObject = new Review();

        $movieData = $movieDao->findById($movies_id);

        // CHECK MOVIE EXISTENCE
        if($movieData)
        {

            // MIN DATA VALIDATION
            if(!empty($rating) && !empty($review) && !empty($movies_id))
            {

                $reviewObject->rating = $rating;
                $reviewObject->review = $review;
                $reviewObject->movies_id = $movies_id;
                $reviewObject->users_id = $users_id;

                $reviewDao->create($reviewObject);

            }
            else
            {

                $message->setMessage("You need insert an rate and comment to submit a review", "error", "back");

            }

        }
        else
        {

            $message->setMessage("Invalid informations 2!", "error", "index.php");

        }

    }
    else
    {

        $message->setMessage("Invalid informations 1!", "error", "index.php");

    }

?>