<?php
    require_once("templates/header.php");
    require_once("dao/MovieDAO.php");

    // MOVIES DAO
    $movieDao = new MovieDAO($conn, $BASE_URL);

    $lastestMovies = $movieDao->getLastestMovies();
    $actionMovies = $movieDao->getMoviesByCategory("action");
    $comedyMovies = $movieDao->getMoviesByCategory("comedy");
    $scyfyMovies = $movieDao->getMoviesByCategory("scy-fy");
    $dramaMovies = $movieDao->getMoviesByCategory("drama");
    $romanceMovies = $movieDao->getMoviesByCategory("romance");

?>
    <div id="main-container" class="container-fluid">
        <h2 class="section-title">New movies</h2>
        <p class="section-description">Reviews of the last added movies on MovieStar</p>
        <div class="movies-container">
            <?php foreach($lastestMovies as $movie): ?>
                <?= require("templates/movie_card.php") ?>
            <?php endforeach; ?>
            <?php if(count($lastestMovies) === 0): ?>
                <p class="empty-list">No movies yet!</p>
            <?php endif; ?>
        </div>
        <h2 class="section-title">Action</h2>
        <p class="section-description">The best action movies</p>
        <div class="movies-container">
            <?php foreach($actionMovies as $movie): ?>
                <?= require("templates/movie_card.php") ?>
            <?php endforeach; ?>
            <?php if(count($actionMovies) === 0): ?>
                <p class="empty-list">No action movies yet!</p>
            <?php endif; ?>
        </div>
        <h2 class="section-title">Comedy</h2>
        <p class="section-description">The best comedy movies</p>
        <div class="movies-container">
            <?php foreach($comedyMovies as $movie): ?>
                <?= require("templates/movie_card.php") ?>
            <?php endforeach; ?>
            <?php if(count($comedyMovies) === 0): ?>
                <p class="empty-list">No comedy movies</p>
            <?php endif; ?>
        </div>
        <h2 class="section-title">Scy-fy</h2>
        <p class="section-description">The best scy-fi movies</p>
        <div class="movies-container">
            <?php foreach($scyfyMovies as $movie): ?>
                <?= require("templates/movie_card.php") ?>
            <?php endforeach; ?>
            <?php if(count($scyfyMovies) === 0): ?>
                <p class="empty-list">No scy-fy movies</p>
            <?php endif; ?>
        </div>
    </div>
    <?php
    require_once("templates/footer.php");
?>