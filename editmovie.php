<?php
    require_once("templates/header.php");

    
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");
    require_once("models/User.php");

    $user = new User;
    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);

    // VERIFY USER AUTHENTICATION
    $userData = $userDao->verifyToken(true);
    $id = filter_input(INPUT_GET, "id");

    // CHECK MOVIE ID
    if(empty($id))
    {

        $message->setMessage("Movie not found!", "error", "index.php");

    }
    else
    {

        $movie = $movieDao->findById($id);

        // CHECK MOVIE EXISTENSE
        if(!$movie)
        {

            $message->setMessage("Movie not found!", "error", "index.php");

        }

    }

    // IF MOVIE DON´T HAVE IMAGE
    if($movie->image == "")
    {
        $movie->image = "movie_cover.jpg";
    }
    
?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1><?= $movie->title ?></h1>
                <p class="page-description">Update movie data down below:</p>
                <form action="<?= $BASE_URL ?>movie_process.php" method="post" id="edit-movie-form" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="id" value="<?= $movie->id ?>">
                    <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Insert movie title" value="<?= $movie->title ?>">
                    </div>
                    <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" class="form-control-file" name="image" id="image">
                    </div>
                    <div class="form-group">
                    <label for="length">length:</label>
                    <input type="text" class="form-control" id="length" name="length" placeholder="Insert movie length" value="<?= $movie->length ?>">
                    </div>
                    <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Select</option>
                        <option value="Action" <?= $movie->category === "Action" ? "selected" : "" ?>>Action</option>
                        <option value="Drama" <?= $movie->category === "Drama" ? "selected" : "" ?>>Drama</option>
                        <option value="Comedy" <?= $movie->category === "Comedy" ? "selected" : "" ?>>Comedy</option>
                        <option value="SCY-FY" <?= $movie->category === "SCY-FY" ? "selected" : "" ?>>SCY-FY</option>
                        <option value="Romance" <?= $movie->category === "Romance" ? "selected" : "" ?>>Romance</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="trailer">Trailer:</label>
                    <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer" value="<?= $movie->trailer ?>">
                    </div>
                    <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme..."><?= $movie->description ?></textarea>
                    </div>
                    <input type="submit" class="btn card-btn" value="Update movie">
                </form>
            </div>
            <div class="col-md-3">
                <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>')"></div>
            </div>
        </div>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>