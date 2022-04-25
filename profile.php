<?php
    require_once("templates/header.php");

    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");
    require_once("models/User.php");

    $user = new User;
    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);

    // RECEIVE USER ID
    $id = filter_input(INPUT_GET, "id");

    if(empty($id))
    {

        if(!empty($userData))
        {

            $id = $userData->id;

        }
        else
        {
            $message->setMessage("User not found!", "error", "index.php");
        }

    }
    else
    {

        $userData = $userDao->findById($id);

        // IF USER NOT FOUND
        if(!$userData)
        {
            $message->setMessage("User not found!", "error", "index.php");
        }

    }

    $fullName = $user->getFullName($userData);

    // IF USER DON´T HAVE IMAGE
    if($userData->image == "")
    {
        $userData->image = "user.png";
    }

    // USER MOVIES
    $userMovies = $movieDao->getMoviesByUserId($id);

?>

<div id="main-container" class="container-fluid">
    <div class="col-md-8 offset-md-2">
        <div class="row profile-container">
            <div class="col-md-12 about-container">
                <h1 class="page-title"><?= $fullName ?></h1>
                <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                <h3 class="about-title">Bio:</h3>
                <?php if(!empty($userData->bio)): ?>
                    <p class="profile-description"><?= $userData->bio ?></p>
                <?php else: ?>
                    <p class="profile-description">User don´t have bio...</p>
                <?php endif; ?>
            </div>
            <div class="col-md-12 added-movies-container">
                <h3>User movies:</h3>
                <div class="movies-container">
                    <?php foreach($userMovies as $movie): ?>
                        <?php require("templates/movie_card.php"); ?>
                    <?php endforeach; ?>
                    <?php if(count($userMovies) === 0): ?>
                        <p class="empty-list">This user not added movies yet.</p>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>