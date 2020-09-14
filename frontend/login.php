<?php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../api/shared/UserModel.php');
if(isset($_POST['submit'])) {
    $user_model = new UserModel();
    $user_model->login($_POST);
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Employee Login</title>
</head>
<body>
<div class="instructions">
    Login Below
</div>
<form id="login_form" action="" method="POST">
    <div>
        <label for="username">Username</label>
        <input id="username" type="text" name="username" value="">
    </div>
    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" value="">
    </div>    
    <div>
        <input type="submit" name="submit" value="Login" />
    </div>
    <p>Don't Have an Account? <a href="register.php" >Register</a></p>
</form>
</body>

</html>