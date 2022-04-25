<?php
    require_once("templates/header.php");
    require_once("dao/UserDAO.php");
    require_once("models/User.php");

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(true);
    $user = new User;

    $fullName = $user->getFullName($userData);

    // IF USER DON´T HAVE IMAGE
    if($userData->image == "")
    {
        $userData->image = "user.png";
    }
    
?>

<div id="main-container" class="container-fluid edit-profile-page">
    <div class="col-md-12">
        <form action="<?= $BASE_URL ?>user_process.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="type" value="update">
        <div class="row">
            <div class="col-md-4">
                <h1><?= $fullName ?></h1>
                <p class="page-description">Update your perfil below</p>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Insert your name" value="<?= $userData->name ?>">
                </div>
                <div class="form-group">
                    <label for="lastname">lastname:</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Insert your lastname" value="<?= $userData->lastname ?>">
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="text" readonly name="email" id="email" class="form-control disabled" placeholder="Insert your email" value="<?= $userData->email ?>">
                </div>
                <input type="submit" value="Update" class="btn card-btn">
            </div>
            <div class="col-md-4">
                <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')">
                </div>
                <div class="form-group">
                    <label for="image">Picture:</label>
                    <input type="file" name="image" class="form-control-file">
                </div>
                <div class="form-group">
                    <label for="bio">About you:</label>
                    <textarea name="bio" class="form-control" id="bio" rows="5" placeholder="Talk more about you"><?= $userData->bio ?></textarea>
                </div>
            </div>
        </div>
    </form>
    <div class="row" id="change-password-container">
        <div class="col-md-4">
            <h2>Alerar senha</h2>
            <p class="page-description">Insert your new password below</p>
            <form action="<?= $BASE_URL ?>user_process.php" method="post">
                <input type="hidden" name="type" value="changepassword">
                <div class="form-group">
                    <label for="password">Passord:</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Insert password">
                </div>
                <div class="form-group">
                    <label for="confirmpassword">Confirm your passord</label>
                    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm your password">
                </div>
                <input type="submit" value="Update password" class="btn card-btn">
            </form>
        </div>
    </div>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>