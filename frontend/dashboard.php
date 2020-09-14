<?php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../api/shared/UserModel.php');
session_start();
if ($_SESSION["loggedin"] == 'true') {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
<h1>Dashboard</h1>
<ul>
    <li><a href="/frontend/emp-profile.php">Edit My Profile</a></li>
    <?php
    $user_model = new UserModel();
    $username = $_SESSION['username'];
    $current_user = $user_model->getByUsername($username);
    if($current_user) {
        if ($current_user->role == 'admin') {
            echo '<li><a href="/frontend/emp-listing.php">Employee Listing</a></li>';
            echo '<li><a href="/frontend/register.php">Add User</a></li>';
        }
    }
    ?>
    <li><a href="/frontend/logout.php">Logout</a></li>
</ul>
</body>
</html>

<?php
} else {
    echo "<script>alert('Please login.');</script>";
}
?>