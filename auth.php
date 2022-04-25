<?php
    require_once("templates/header.php");
?>
<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row" id="auth-row">
            <div class="col-md-4" id="login-container">
                <h2>Login</h2>
                <form action="<?= $BASE_URL ?>auth_process.php" method="post">
                    <input type="hidden" name="type" value="login">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Insert your e-mail">
                    </div>
                    <div class="form-group">
                        <label for="password">Passord</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Insert your password">
                    </div>
                    <input type="submit" value="Login" class="btn card-btn">
                </form>
            </div>
            <div class="col-md-4" id="register-container">
            <h2>Create account</h2>
                <form action="<?= $BASE_URL ?>auth_process.php" method="post">
                    <input type="hidden" name="type" value="register">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Insert your e-mail">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Insert your name">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Insert your lastname">
                    </div>
                    <div class="form-group">
                        <label for="password">Passord</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Insert your password">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirm your passord</label>
                        <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm your password">
                    </div>
                    <input type="submit" value="Sign in" class="btn card-btn">
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    require_once("templates/footer.php");
?>