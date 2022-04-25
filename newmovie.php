<?php
    require_once("templates/header.php");

    // VERIFY USER AUTHENTICATION
    require_once("dao/UserDAO.php");
    require_once("models/User.php");

    $user = new User;
    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(true);
    
?>

<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-movie-container">
        <h1 class="page-title">Add Movie</h1>
        <p class="page-description">Share your review with everyone!</p>
        <form action="<?= $BASE_URL ?>movie_process.php" method="post" id="add-movie-form" enctype="multipart/form-data">
            <input type="hidden" name="type" value="create">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Isert movie title">
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" name="image" id="image" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="length">Length:</label>
                <input type="text" name="length" id="length" class="form-control" placeholder="Isert movie length">
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select name="category" id="category" class="form-control">
                    <option value="">Select</option>
                    <option value="action">Action</option>
                    <option value="drama">Drama</option>
                    <option value="scy-fi">Scy-Fy</option>
                    <option value="comedy">Comedy</option>
                    <option value="romance">Romance</option>
                </select>
            </div>
            <div class="form-group">
                <label for="trailer">Trailer:</label>
                <input type="text" name="trailer" id="trailer" class="form-control" placeholder="Isert trailer link">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Describe movie..."></textarea>
            </div>
            <input type="submit" value="Add movie" class="btn card-btn">
        </form>
    </div>
</div>
<?php
    require_once("templates/footer.php");
?>