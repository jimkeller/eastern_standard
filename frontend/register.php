<?php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../api/shared/UserModel.php');
session_start();
$user_model = new UserModel();
if(isset($_POST['submit'])) {
    $user_model->register($_POST);
}
// Check if current user is admin.
$is_admin = FALSE;
if (array_key_exists('loggedin', $_SESSION) && $_SESSION["loggedin"] == 'true') {
    $username = $_SESSION["username"];
    $current_user = $user_model->getByUsername($username);
    if ($current_user->role == 'admin') {
      $is_admin = TRUE;
   }
}
?>

<!doctype html>
<html>
<head>
    <title>Employee Registration</title>
    <link rel="stylesheet" href="css/app.css">
</head>

<body>
<div id="register_msg"></div>
<div class="instructions">
   Employee Registration
</div>
<form id="register_form" action="" method="POST">
    <div>
        <label for="username">Username</label>
        <input id="username" type="text" name="username" value="" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="" required>
    </div>
    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" value="" required>
    </div>
    <?php
    if ($is_admin) {
        echo '<div>
        <label for="role">User Role</label>
        <select name="role" id="role">
          <option value="employee">Employee</option>
          <option value="admin">Admin</option>
        </select>
    </div>';
    }
    ?>
    <div>
        <input name="submit" type="submit" value="Register"/>
    </div>
    <?php
    if (array_key_exists('loggedin', $_SESSION) == FALSE || $_SESSION["loggedin"] != 'true') {
        echo "<p>Already have an Account? <a href='login.php' >Login</a></p>";
    }
    ?>
</form>
</body>

</html>