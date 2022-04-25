<?php
    require_once("templates/header.php");
    // require_once("db.php");
    

    // VERIFY USER AUTHENTICATION
    require_once("dao/MovieDAO.php");
    require_once("models/Movie.php");

    // GET MOVIE ID
    $id = filter_input(INPUT_GET, "id");

    $movie;

    $movieDao = new MovieDAO($conn, $BASE_URL);
    // $message = new Message($BASE_URL);

    if(empty($id))
    {
        
        $message->setMessage("Movie not found", "error", "index.php");

    }
    else
    {

        $movie = $movieDao->findById($id);

        // CHECK MOVIE ID
        if(!$movie)
        {

            $message->setMessage("Movie not found", "error", "index.php");

        }

    }

    // print_r($movie); exit;

    // IF MOVIE DON´T HAVE IMAGE
    if($movie->image == "")
    {
        $movie->image = "movie_cover.jpg";
    }

    // CHECK IF MOVIE BELONGS TO USER
    $userOwnsMovie = false;

    if(!empty($userData))
    {

        if($userData->id ===$movie->users_id)
        {
            $userOwnsMovie = true;
        }

    }

    // GET MOVIE REVIEWS
    $alreadyReviewed = false;


?>

    <div id="main-container" class="container-fluid">
        <div class="row">
            <div class="offset-md-1 col-md-6 movie-container">
                <h1 class="page-title"><?= $movie->title ?></h1>
                <p class="movi-details">
                    <span>Length: <?= $movie->length ?></span>
                    <span class="pipe"></span>
                    <span><?= $movie->category ?></span>
                    <span class="pipe"></span>
                    <span><i class="fas fa-star"></i>9</span>
                </p>
                <iframe src="<?= $movie->trailer ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" allowfullscreen ></iframe>
                <p><?= $movie->description ?></p>
            </div>
            <div class="col-md-4">
                <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>')"></div>
            </div>
            <div class="offset-md-1 col-md-10" id="reviews-container">
                <h3 id="reviews-title">Reviews: </h3>
                <!-- CHECK IF SHOW REVIEWS -->
                <?php if(!empty($userData) && !$userOwnsMovie && !$alreadyReviewed): ?>
                <div class="col-md-12" id="review-form-container">
                    <h4>Make your review:</h4>
                    <p class="page-description">leave your review of this movie</p>
                    <form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="post">
                        <input type="hidden" name="type" value="create">
                        <input type="hidden" name="movies_id" value="<?= $movie->id ?>">
                        <div class="form-group">
                            <label for="rating">Movie rate:</label>
                            <select name="rating" id="rating" class="form-control">
                                <option value="">Selecione</option>
                                <option value="10">10</option>
                                <option value="9">9</option>
                                <option value="8">8</option>
                                <option value="7">7</option>
                                <option value="6">6</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                                <option value="0">0</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="review">Your review:</label>
                            <textarea name="review" id="review" rows="3" class="form-control" placeholder="What you think about this movie?"></textarea>
                        </div>
                        <input type="submit" value="Send review" class="btn card-btn">
                    </form>
                </div>
                <?php endif; ?>
                <!-- REVIEW SECTION -->
                <div class="col-md-12 review">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>img/users/user.png')"></div>
                        </div>
                        <div class="col-md-9 author-datails-container">
                            <h4 class="author-name">
                                <a href="#">Alexandre teste</a>
                            </h4>
                            <p><i class="fas fa-star"></i>9</p>
                        </div>
                        <div class="col-md-12">
                            <p class="comment-title">Comment:</p>
                            <p>This is the user comment!!</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

<?php
    require_once("templates/footer.php");
?>