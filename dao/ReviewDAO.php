<?php

    require_once("models/Review.php");
    require_once("models/Message.php");

    // USER DAO
    require_once("dao/UserDAO.php");

    class ReviewDAO implements ReviewDAOInterface
    {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url)
        {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }
    
        public function buildReview($data)
        {

            $reviewObject = new Review();

            $reviewObject->id = $data["id"];
            $reviewObject->rating = $data["rating"];
            $reviewObject->review = $data["review"];
            $reviewObject->users_id = $data["users_id"];
            $reviewObject->movies_id = $data["movies_id"];

            return $reviewObject;

        }

        public function create(Review $review)
        {

            $stmt = $this->conn->prepare("INSERT INTO reviews (rating, review, movies_id, users_id) VALUES (:rating, :review, :movies_id, :users_id)");

            $stmt->bindParam(":rating", $review->rating);
            $stmt->bindParam(":review", $review->review);
            $stmt->bindParam(":movies_id", $review->movies_id);
            $stmt->bindParam(":users_id", $review->users_id);
            
            $stmt->execute();

            // REDIRECT TO HOME
            $this->message->setMessage("Review successfully added!", "success", "index.php");

        }

        public function getMoviesReview($id)
        {

            $reviews = [];

            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");

            $stmt->bindParam(":movies_id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0)
            {

                $reviewsData = $stmt->fetchAll();

                $userDao = new UserDAO($this->conn, $this->url);

                foreach($reviewsData as $review)
                {

                    $reviewObject = $this->buildReview($review);

                    //GET USER DATA
                    $user = $userDao->findById($reviewObject->users_id);

                    $reviewObject->user = $user;

                    $reviews[] = $reviewObject;
                }

            }

            Return $reviews;

        }

        public function hasAlreadyReviewed($id, $userId)
        {

            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id AND users_id = :users_id");

            $stmt->bindParam(":movies_id", $id);
            $stmt->bindParam(":users_id", $userId);

            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }

        }

        public function getRatings($id)
        {

            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");

            $stmt->bindParam(":movies_id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0)
            {

                $rating = 0;

                $reviews = $stmt->fetchAll();

                foreach($reviews as $review)
                {
                    $rating += $review["rating"];
                }

                $rating = $rating / count($reviews);
                
            }
            else
            {
                $rating = "Not reviewd";
            }

            return $rating;

        }

    }

?>