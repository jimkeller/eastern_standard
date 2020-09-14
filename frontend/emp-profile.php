<?php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../api/shared/EmployeeModel.php');
session_start();
$emp_model = new EmployeeModel();
$username = $_SESSION['username'];
if(isset($_GET['username']) && $_GET['username'] != NULL) {
    $username = $_GET['username'];
}
if(isset($_POST['submit'])) {
    $_POST['username'] = $username;
    $emp_model->profileUpdate($_POST);
}

$first_name = '';
$last_name = '';
$dob = '';
$phone = '';
$office_phone = '';
$emp_category = '';
if ($_SESSION["loggedin"] == 'true') {
    // Get data for employee profile.
    $get_data = $emp_model->getByUsername($username);
    if (isset($get_data) && $get_data != NULL) {
        $first_name = $get_data->first_name;
        $last_name = $get_data->last_name;
        $dob = $get_data->dob;
        $phone = $get_data->phone;
        $office_phone = $get_data->office_number;
        $emp_category = $get_data->emp_category;
    }

?>

<!doctype html>
<html>
<head>
    <title>Employee Profile</title>
    <link rel="stylesheet" href="css/app.css">
</head>

<body>
<div id="register_msg"></div>
<div class="instructions">
    Employee Profile
</div>
<form id="register_form" action="" method="POST">
    <div>
        <label for="fname">First Name</label>
        <input id="fname" type="text" name="fname" value="<?php print $first_name; ?>" required>
    </div>
    <div>
        <label for="lname">Last Name</label>
        <input id="lname" type="lname" name="lname" value="<?php print $last_name; ?>" required>
    </div>
    <div>
        <label for="dob">Date of Birth</label>
        <input id="dob" type="date" name="dob" value="<?php print $dob; ?>">
    </div>
    <div>
        <label for="phone">Phone Number</label>
        <input id="phone" type="tel" name="phone" value="<?php print $phone; ?>" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
        <small>Format: 123-45-678</small><br>
    </div>
    <div>
        <label for="office_number">Office Number</label>
        <input id="office_number" type="tel" name="office_number" value="<?php print $office_phone; ?>" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
        <small>Format: 123-45-678</small><br>
    </div>
    <div>
        <label for="emp_category">Employee Category</label>
        <select name="emp_category" id="emp_category" value="<?php print $emp_category; ?>">
            <?php
            $options_array = array(
                'full_time' => 'Full Time',
                'part_time' => 'Part Time',
                'intern' => 'Intern',
                'contractor' => 'Contractor'
            );
            foreach ($options_array as $key => $value) {
                if ($key == $emp_category) {
                    echo('<option selected="selected" value='.$key.'>'.$value.'</option>');
                } else {
                    echo('<option value='.$key.'>'.$value.'</option>');
                }
            }
            ?>

        </select>
    </div>
    <div>
        <input name="submit" type="submit" value="Update"/>
    </div>
</form>
</body>

</html>

    <?php
} else {
    echo "<script>alert('Please login.');</script>";
}
?>