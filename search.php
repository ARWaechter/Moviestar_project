<?php
    require_once("templates/header.php");
    require_once("dao/MovieDAO.php");

    // MOVIES DAO
    $movieDao = new MovieDAO($conn, $BASE_URL);

    // GET USER SEARCH
    $q = filter_input(INPUT_GET, "q");

    $movies = $movieDao->findByTitle($q);

?>
    <div id="main-container" class="container-fluid">
        <h2 class="section-title" id="search-title">You´re seaching for: <spam id="search-result"><?= $q ?></spam></h2>
        <p class="section-description">Search result for <?= $q ?></p>
        <div class="movies-container">
            <?php foreach($movies as $movie): ?>
                <?= require("templates/movie_card.php") ?>
            <?php endforeach; ?>
            <?php if(count($movies) === 0): ?>
                <p class="empty-list">No movies for your search, <a href="<?= $BASE_URL ?>index.php" class="back-link">Back</a></p>
            <?php endif; ?>
        </div>
    </div>
    <?php
    require_once("templates/footer.php");
?>